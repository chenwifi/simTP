<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019/1/31
 * Time: 16:55
 */
namespace think\route;

use think\Container;

class Dispatch{
    protected $rule;
    protected $dispatch;
    protected $app;

    public function __construct(Rule $rule,$dispatch)
    {
        $this->rule = $rule;
        $this->dispatch = $dispatch;
        $this->app = Container::get('app');
    }

    public function init(){
        $option = $this->rule->getOption();

        if(!empty($option['middleware'])){
            $this->app->middleware->import($option['middleware']);
        }
    }

    public function run(){
        $this->exec();
    }
}