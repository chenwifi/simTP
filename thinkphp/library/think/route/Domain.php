<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019/1/30
 * Time: 11:40
 */
namespace think\route;

use think\Route;

class Domain extends RuleGroup{

    public function __construct(Route $route,$host)
    {
        $this->route = $route;
        $this->domain = $host;
    }

    public function addRule($rule,$route,$method='*'){
        if(is_string($route)){
            $name = $route;
        }else{
            $name = null;
        }

        $method = strtolower($method);

        $ruleItem = new RuleItem($this->route,$this,$name,$rule,$route,$method);
        $this->addRuleItem($ruleItem,$method);

        return $ruleItem;
    }


    //以下是路由检测的相关方法
    public function check($url){
        $method = $_SERVER['REQUEST_METHOD']?$_SERVER['REQUEST_METHOD'] : 'GET';
        $method = strtolower($method);
        //返回的是这个方法里的路由规则，即这个方法里的每一个ruleitem实例
        $rules = $this->getMethodRules($method);
        if(count($rules) == 0){
            return false;
        }

        foreach($rules as $key=>$item){
            $result = $item->checkRule($url);

            if(false !== $result){
                return $result;
            }else{
                return false;
            }
        }
    }

}