<?php
/**
 * Created by PhpStorm.
 * User: Deada
 * Date: 2016/7/23
 * Time: 8:28
 */
date_default_timezone_set("Asia/Shanghai");
define('BASEDIR',__DIR__);
require_once BASEDIR.'/Common/Loader.php';
require __DIR__ . '/vendor/autoload.php';
spl_autoload_register("\\Common\\Loader::autoload");
//App\Controller\Index::test(3);
session_start();
$string=implode("",array_keys($_GET));
if(!is_null($string)&&!empty($string)){
    $arr = explode("/",$string);
}
else {
    if(isset($_SERVER['PATH_INFO'])&&!is_null($_SERVER['PATH_INFO'])){
        $path = $_SERVER['PATH_INFO'];
        $arr = explode("/",$path);
        array_shift($arr);
        if(empty($arr[0])){
            App\Controller\Index::index();
        }
        else{
            switch ($arr[0]){
                case $User->username :
                    //require_once 'UserProfile.php';

            }
        }
    }
    else{
        App\Controller\Index::index();
    }

}
