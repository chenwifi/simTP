<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019/1/25
 * Time: 9:51
 */
namespace think;

class App extends Container{
    public function __construct($name)
    {
        echo 'hello world ' . $name;
    }

    public function run(){

    }
}