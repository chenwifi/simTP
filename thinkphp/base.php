<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019/1/19
 * Time: 14:14
 */
namespace think;

require __DIR__ . '/library/think/Loader.php';

Loader::register();

Error::register();

Loader::addClassAlias([
    'App'      => facade\App::class,
    'Db'       => Db::class,
    'Facade'   => Facade::class,
    'Request'  => facade\Request::class,
    'Response' => facade\Response::class,
    'Route'    => facade\Route::class,
    'Url'      => facade\Url::class,
]);
