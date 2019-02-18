<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019/1/31
 * Time: 16:54
 */
namespace think\route\dispatch;

use think\route\Dispatch;

class Callback extends Dispatch{
    public function exec(){
        return $this->app->invoke($this->dispatch);
    }
}