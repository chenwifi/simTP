<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019/1/19
 * Time: 14:13
 */
namespace think;

//加载基础文件
require __DIR__ . '/../thinkphp/base.php';

//执行应用
Container::get('app',['name'=>'smallfai','wifi'=>'wifi']);