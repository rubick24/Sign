<?php
/**
 * Created by PhpStorm.
 * User: Deada
 * Date: 2016/7/20
 * Time: 22:01
 */
session_start();
date_default_timezone_set("Asia/Shanghai");
include './User.php';

if(isset($_SESSION['uid'])&&!is_null($_SESSION['uid'])){
    $User=new User();
    $User->getUserInfo($_SESSION['uid']);
}

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
            require_once 'indexPage.php';
        }
        else{
            switch ($arr[0]){
                case $User->username :
                    include 'UserProfile.php';

            }
        }
    }
    else{
        require_once 'indexPage.php';
    }

}

