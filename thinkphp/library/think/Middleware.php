<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019/1/30
 * Time: 16:56
 */
namespace think;

class Middleware{

    protected $config = [
        'default_namespace' => 'app\\http\\middleware\\',
    ];

    //中间件队列
    protected $queue = [];

    public function __construct()
    {

    }

    public function import(array $middlewares = [],$type='route'){
        foreach ($middlewares as $middleware){
            $this->add($middleware,$type);
        }
    }

    public function add($middleware,$type='route'){

    }
}