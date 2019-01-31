<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019/1/30
 * Time: 11:42
 */
namespace think\route;

class Rule{
    protected $method;
    protected $parent;
    protected $name;
    protected $route;
    protected $rule;
    protected $router;
    protected $option;

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

    //检测路由
    public function dispatch($route){
        //这里只有闭包方法和路由到模块/控制器/操作
        if($route instanceof \Closure){

        }else{

        }
    }
}