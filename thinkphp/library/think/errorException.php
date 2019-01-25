<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019/1/24
 * Time: 15:10
 */
namespace think;

class errorException extends \Exception {

    protected $level;

    public function __construct($errno,$errstr,$errfile,$errline)
    {
        $this->level = $errno;
        $this->message = $errstr;
        $this->file = $errfile;
        $this->line = $errline;
        $this->code = 0;
    }
}