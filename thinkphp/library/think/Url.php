<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019/2/15
 * Time: 16:20
 */
namespace think;

class Url{
    protected $app;

    public function __construct(App $app)
    {
        $this->app = $app;
    }

    //简易，不支持参数，瞄点等
    public function build($url = '',$vars = '',$suffix = true, $domain = false){
        $info = parse_url($url);
        $url = isset($info['path']) ? $info['path'] : '';
        parse_str($vars,$vars);

        $rule = $this->app->route->getName($url,$domain);
        if(!empty($rule) && $match = $this->getRuleUrl($url,$vars,$domain)){
            $url = $match[0];
            $domain = $match[1];
        }else{
            throw new \Exception('route name not exists');
        }
        if($suffix){
            $suffix = '.html';
        }

        $url .= $suffix;
        $domain = $this->parseDomain($domain);

        $url = $domain . rtrim($_SERVER['SCRIPT_NAME'],'/') . '/' . ltrim($url,'/');
        return $url;
    }

    public function getRuleUrl($url,$vars,$domain){
        foreach ($url as $item) {
            list($url, $domain, $method) = $item;
            return [$url,$domain];
        }
    }

    protected function isSsl(){
        if ($_SERVER('HTTPS') && ('1' == $_SERVER('HTTPS') || 'on' == strtolower($_SERVER('HTTPS')))) {
            return true;
        } elseif ('https' == $_SERVER('REQUEST_SCHEME')) {
            return true;
        } elseif ('443' == $_SERVER('SERVER_PORT')) {
            return true;
        } elseif ('https' == $_SERVER('HTTP_X_FORWARDED_PROTO')) {
            return true;
        }

        return false;
    }

    public function parseDomain($domain){
        $scheme = $this->isSsl() ? 'https://' : 'http://';
        return $scheme . $domain;
    }
}