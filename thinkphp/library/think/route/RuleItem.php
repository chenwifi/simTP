<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019/1/30
 * Time: 11:41
 */
namespace think\route;

use think\Container;
use think\Route;

class RuleItem extends Rule{

    public function __construct(Route $router,RuleGroup $parent,$name,$rule,$route,$method)
    {
        $this->router = $router;
        $this->parent = $parent;
        $this->name = $name;
        $this->route = $route;
        $this->method = $method;
        $this->rule = $rule;

        $this->setRuleName();
    }

    public function setRuleName(){
        //为null的时候一般都是闭包函数
        if($this->name){
            $name = strtolower($this->name);
            $value = [$this->rule,$this->parent->getDomain(),$this->method];
            Container::get('rule_name')->set($name,$value);
        }

        Container::get('rule_name')->setRule($this->rule,$this);
    }

    //以下是检测路由的相关方法
    public function checkRule($url){
        $option = $this->option;
        $match = strcasecmp($url,$this->rule)==0;
        if($match){
            return $this->dispatch($this->route);
        }else{
            return false;
        }
    }

}