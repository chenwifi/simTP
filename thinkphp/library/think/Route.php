<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019/1/30
 * Time: 11:37
 */
namespace think;

use think\route\Domain;

class Route{

    protected $app;
    protected $host;
    protected $domain;
    protected $domains = [];
    protected $group;

    public function __construct(App $app)
    {
        $this->app = $app;
        $this->host = $_SERVER['HTTP_HOST'];
    }

    protected function setDefaultDomain(){
        $this->domain = $this->host;
        $domain = new Domain($this,$this->host);
        $this->domains[$this->host] = $domain;
        $this->group = $domain;
    }

    public function rule($rule,$route,$method='*'){
        $this->group->addRule($rule,$route,$method);
    }

    public function get($rule,$route){
        $this->rule($rule,$route,'GET');
    }

    public function check($url){
        $domain = $this->domains[$this->host];
        $domain->check($url);
    }
}