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
    protected $app;

    //中间件队列
    protected $queue = [];

    public function __construct(App $app)
    {
        $this->app = $app;
    }

    public function import(array $middlewares = [],$type='route'){
        foreach ($middlewares as $middleware){
            $this->add($middleware,$type);
        }
    }

    public function add($middleware,$type='route'){
        if(empty($middleware)){
            return ;
        }
        $middleware = $this->buildMiddleware($middleware,$type);

        $this->queue[$type][] = $middleware;

    }

    public function buildMiddleware($middleware){
        if(is_array($middleware)){
            list($middleware,$param) = $middleware;
        }

        if($middleware instanceof \Closure){
            return [$middleware,isset($param) ? $param : null];
        }

        if(!is_string($middleware)){
            throw new \Exception('error middleware');
        }

        if(strpos($middleware,'\\')===false){
            $middleware = $this->config['default_namespace'] . $middleware;
        }

        if(strpos($middleware,':')){
            list($middleware,$param) = explode(':',$middleware,2);
        }

        return [[$this->app->make($middleware),'handle'],isset($param)?$param:null];
    }

    //中间件调度
    public function dispatch($type='route'){
        return call_user_func($this->resolve($type));
    }

    //中间件返回的载体方法
    public function resolve($type='route'){
        return function () use ($type){
            $middleware = array_shift($this->queue[$type]);

            list($call,$param) = $middleware;
            try{
                $response = call_user_func_array($call,[$this->resolve($type),$param]);
            }catch (\Exception $exception){
                exit($exception->getMessage());
            }
        };
    }

    public function controller($middleware){
        $this->add($middleware,'controller');
    }
}