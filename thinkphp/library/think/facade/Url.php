<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019/2/15
 * Time: 16:17
 */
namespace think\facade;

use think\Facade;

class Url extends Facade{
    public static function getFacadeClass(){
        return 'url';
    }
}