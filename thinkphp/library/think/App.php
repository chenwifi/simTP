<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019/1/25
 * Time: 9:51
 */
namespace think;

class App extends Container{

    protected $initialized;
    protected $rootPath;
    protected $routePath;
    protected $thinkPath;
    protected $appPath;

    public function __construct()
    {
        $this->thinkPath = dirname(dirname(__DIR__)) .'/';
        $this->appPath = Loader::getRootPath() .'application' . '/';
    }

    public function initialize(){
        $this->rootPath = dirname($this->appPath) . '/';
        $this->routePath = $this->rootPath . 'route' . '/';

        $this->init();
        //路由初始化
        $this->routeInit();
    }

    public function init($module = ''){
        $module = $module ? $module . '/' : '';
        $path = $this->appPath . $module;

        if(is_file($path . 'middleware.php')){
            $middleware = include $path . 'middleware.php';
            if(is_array($middleware)){
                $this->middleware->import($middleware);
            }
        }
    }

    public function run(){
        $this->initialize();

        //路由检测
        $dispatch = $this->routeCheck()->init();

        $this->middleware->add(function () use ($dispatch){
            $dispatch->run();
        });
    }

    public function routeInit(){
        //$file = scandir($this->routePath);
        include $this->routePath . 'route.php';
    }

    public function routeCheck(){
        $path = ltrim($_SERVER['PATH_INFO'],'/');

        //路由检测，返回一个Dispatch对象
        $dispatch = $this->route->check($path);
        return $dispatch;
    }

    public function getAppPath(){
        return $this->appPath;
    }

    //实例化控制器,返回实例(简易化)
    public function controller($module,$name,$layer = 'controller'){
        $class = 'app' . '\\' . $module . '\\' . $layer . '\\' . ucfirst($name);
        return $this->__get($class);
    }

    public function invokeReflectMethod($instance,$reflect,$vars = []){
        $args = $this->bindParams($reflect,$vars);
        return $reflect->invokeArgs($instance,$args);
    }
}