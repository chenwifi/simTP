<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019/1/30
 * Time: 11:36
 */
namespace think\facade;

use think\Facade;

class Route extends facade{
    public static function getFacadeClass(){
        return 'route';
    }
}