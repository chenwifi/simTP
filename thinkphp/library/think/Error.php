<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019/1/19
 * Time: 14:27
 */
namespace think;

use think\errorException;

class Error{
    public static function test(){
        echo 'error test';
    }

    public static function register(){
        error_reporting(E_ALL);
        set_error_handler([__CLASS__,'appError']);
        set_exception_handler([__CLASS__,'appException']);
        register_shutdown_function([__CLASS__,'appShutdown']);
    }

    public static function appError($errno,$errstr,$errfile,$errline){
        $exception = new errorException($errno,$errstr,$errfile,$errline);
        if(error_reporting() & $errno){
            throw $exception;
        }

        //if not output data

    }

    public static function appException($e){
        echo $e->getMessage();
        //output data.
    }

    public static function appShutdown(){
        //捕获最后一次错误
        if(!is_null($error = error_get_last())){
            $exception = new errorException($error['type'],$error['message'],$error['file'],$error['line']);
            self::appException($exception);
        }
        //写入日志
    }


}
