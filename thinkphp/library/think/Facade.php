<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019/1/30
 * Time: 17:39
 */
namespace think;

use think\Container;

class Facade{

    protected static function getFacadeClass()
    {}

    protected static function createFacade($class='',$args=[]){
        $class = static::getFacadeClass();

        return Container::getIns()->make($class,$args);
    }

    public static function __callStatic($name, $arguments)
    {
        // TODO: Implement __callStatic() method.
        return call_user_func_array([static::createFacade(),$name],$arguments);
    }
}