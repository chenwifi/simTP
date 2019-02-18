<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019/1/30
 * Time: 11:42
 */
namespace think\route;

use think\route\dispatch\Module as ModuleDispatch;
use think\route\dispatch\Callback as CallbackDispatch;

class Rule{
    protected $method;
    protected $parent;
    protected $name;
    protected $route;
    protected $rule;
    protected $router;
    protected $option;
    protected $domain;

    public function getDomain(){
        return $this->parent->getDomain();
    }

    public function getMethod(){
        return strtolower($this->method);
    }

    public function middleware($middleware,$params=null){
        if(is_array($middleware)){
            $this->option['middleware'] = $middleware;
        }else{
            $this->option['middleware'][] = [$middleware,$params];
        }
    }

    protected function parseUrlPath($route){
        $url = trim($route);
        $vars = [];

        if(strpos($url,'?') !== false){

        }else if(strpos($url,'/')){
            $path = explode('/',$url);
        }

        return [$path,$vars];
    }

    protected function dispatchModule($route){
        //分析路由
        list($path,$vars) = $this->parseUrlPath($route);

        $action = array_pop($path);
        $controller = array_pop($path);
        $module = array_pop($path);

        $dispatch = [$module,$controller,$action];

        return new ModuleDispatch($this,$dispatch);
    }

    //检测路由
    public function dispatch($route){
        //这里只有闭包方法和路由到模块/控制器/操作
        if($route instanceof \Closure){
            $result = new CallbackDispatch($this,$route);
        }else{
            $result = $this->dispatchModule($route);
        }

        return $result;
    }

    public function getOption($name=''){
        if(empty($name)){
            return $this->option;
        }

        return isset($this->option[$name])?$this->option[$name]:null;
    }
}