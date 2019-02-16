<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019/1/25
 * Time: 9:39
 */
namespace think;

class Container{
    private static $ins=null;

    private $bind = [
        'app'                   => App::class,
        'middleware'            => Middleware::class,
        'request'               => Request::class,
        'response'              => Response::class,
        'route'                 => Route::class,
        'url'                   => Url::class,
        'rule_name'             => route\RuleName::class,
    ];

    //容器名
    protected $name = [];
    //容器实例
    protected $instances = [];

    public static function getIns(){
        if(is_null(self::$ins)){
            self::$ins = new static();
        }

        return self::$ins;
    }

    public static function get($class,$vars=[],$newIns=false){
        return static::getIns()->make($class,$vars,$newIns);
    }

    public function getObjectParam($className){
        return $this->make($className);
    }

    public function bindParams($reflect,$vars=[]){
        if(!$reflect->getNumberOfParameters()){
            return [];
        }

        $params = $reflect->getParameters();

        //如果是数字为键，按顺序赋值。否则，按以名字为键取值
        $type = key($vars)==0 ? 1 : 0;

        foreach ($params as $param){
            $name = $param->getName();
            $class = $param->getClass();

            if($class){//如果是类的参数，则进行实例化
                $args[] = $this->getObjectParam($class->getName());
            }else if($type==1 && !empty($vars)){
                $args[] = array_shift($vars);
            }else if($type==0 && isset($vars[$name])){
                $args[] = $vars[$name];
            }else if($param->isDefaultValueAvailable()){
                $args[] = $param->getDefaultValue();
            }else{
                throw new \Exception('method param miss: ' . $name);
            }
        }

        return $args;
    }

    public function invokeClass($class,$vars=[]){
        $reflect = new \ReflectionClass($class);

        $construct = $reflect->getConstructor();

        $args =$construct?$this->bindParams($construct,$vars):[];

        return $reflect->newInstanceArgs($args);
    }

    //实例化容器的类并实现依赖注入
    public function make($class,$vars=[],$newIns=false){
        $abstract = isset($this->name[$class])?$this->name[$class]:$class;

        if(isset($this->instances[$abstract]) && !$newIns){
            return $this->instances[$abstract];
        }

        if(isset($this->bind[$abstract])){
            $concrete = $this->bind[$abstract];
            $this->name[$class] = $concrete;
            return $this->make($concrete,$vars,$newIns);
        }else{
            $object = $this->invokeClass($abstract,$vars);
        }

        if(!$newIns){
            $this->instances[$abstract] = $object;
        }
        print_r($this->name);
        return $object;
    }

    public function __get($name)
    {
        // TODO: Implement __get() method.
        return $this->make($name);
    }
}