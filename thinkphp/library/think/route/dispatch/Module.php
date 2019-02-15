<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019/2/11
 * Time: 15:17
 */
namespace think\route\dispatch;

use think\route\Dispatch;

class Module extends Dispatch {
    protected $module;
    protected $controller;
    protected $actionName;

    public function init(){
        parent::init();

        $available = false;
        $result = $this->dispatch;
        $module = $result[0];

        if(is_dir($this->app->getAppPath() . $module)){
            $available = true;
        }

        if($module && $available){
            $this->app->init($module);
        }else{
            throw new \Exception('module not exists');
        }

        $this->module = $result[0];
        $this->controller = $result[1];
        $this->actionName = $result[2];

        return $this;
    }

    public function exec(){
        //1、实例化控制器
        //2、加入中间件，type为controller
        //3、调用中间件

        $instance = $this->app->controller($this->module,$this->controller);

        $this->app->middleware->controller(function ($next) use ($instance){
            $action = $this->actionName;
            if(is_callable([$instance,$action])){
                $reflect = new \ReflectionMethod($instance,$action);
                //实现自动绑定
                $data = $this->app->invokeReflectMethod($instance,$reflect);
            }else{
                throw new \Exception('404 ');
            }
        });

        return $this->app->middleware->dispatch('controller');
    }
}