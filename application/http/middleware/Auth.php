<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019/2/16
 * Time: 9:39
 */
namespace app\http\middleware;

class Auth{
    public function handle($request,\Closure $next,$name){
        echo $name;
        echo ' this is auth middleware ';
        return $next($request);
    }
}
