<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019/1/19
 * Time: 14:17
 */
namespace think;

class Loader{
    //PSR-4
    private static $prefixLengthsPsr4 = [
        't'=>[
            'think\\' => 6,
        ],
        'a'=>[
            'app\\' => 4,
        ]
    ];
    private static $prefixDirsPsr4 = [
        'app\\'=>[
            0 => __DIR__ . '/../../../application',
        ],
        'think\\'=>[
            0=> __DIR__ ,
        ]
    ];
    private static $fallbackDirsPsr4 = [];

    protected static $classMap = [];

    public static function register(){
        spl_autoload_register('think\\Loader::autoload',true,true);
        $rootPath = self::getRootPath();
        self::addAutoLoadDir($rootPath . 'extend');
    }

    public static function getRootPath(){
        $scriptName = $_SERVER['SCRIPT_FILENAME'];
        return dirname(realpath(dirname($scriptName))) . '/';
    }

    public static function autoload($class){
        if($file = self::findFile($class)){
            __include_file($file);
            return true;
        }
    }

    private static function findFile($class){
        if(!empty(self::$classMap[$class])){
            return self::$classMap[$class];
        }

        $name = $class . '.php';
        $first = $name[0];

        if(isset(self::$prefixLengthsPsr4[$first])){
            foreach (self::$prefixLengthsPsr4[$first] as $prefix=>$length){
                if(0===strpos($name,$prefix)){
                    foreach(self::$prefixDirsPsr4[$prefix] as $path){
                        if(is_file($file = $path . '/' . substr($name,$length))){
                            return $file;
                        }
                    }
                }
            }
        }

        return self::$classMap[$class] = false;
    }

    public static function addAutoLoadDir($path){
        self::$fallbackDirsPsr4[] = $path;
    }

    public static function addNamespace($namespace,$path){

    }
}

function __include_file($file){
    return include $file;
}