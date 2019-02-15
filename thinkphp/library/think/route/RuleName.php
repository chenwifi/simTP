<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019/1/30
 * Time: 11:42
 */
namespace think\route;

class RuleName{
    protected $item = [];
    protected $rule = [];

    public function setRule($rule,$route){
        $this->rule[$route->getDomain()][$rule][$route->getMethod()] = $route;
    }

    public function set($name,$value){
        $this->item[$name][] = $value;
    }

    public function get($name = null,$domain = null,$method = '*'){
        if(isset($this->item[$name])){
            $result = $this->item[$name];
        }

        return $result;
    }
}