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
    }
}