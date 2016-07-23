<?php
/**
 * Created by PhpStorm.
 * User: Deada
 * Date: 2016/7/23
 * Time: 8:31
 */
namespace Common;

class Loader{
    static function autoload($class){
        require_once BASEDIR.'\\'.$class.'.php';
    }
}