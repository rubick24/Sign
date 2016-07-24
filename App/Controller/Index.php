<?php
/**
 * Created by PhpStorm.
 * User: Deada
 * Date: 2016/7/23
 * Time: 14:07
 */

namespace App\Controller;

use App\View\Render;
use Common\Factory;
use Common\User;
class Index
{
    static function index(){
        if (isset($_POST['code'])&&!is_null($_POST['code'])){
            Ajax::ajax();
        }
        else{
            if(isset($_SESSION['uid'])&&!is_null($_SESSION['uid'])){
                $user = Factory::createUser()->getUserInfo($_SESSION['uid']);
                Render::index(Render::jum(Render::signedNav($user)));
            }
            else{
                Render::index(Render::jum(Render::nav()));
            }
        }
    }

    static function userProfile($path){
        if(User::nameExists($path)){
            $path = Factory::createUser()->getUserInfo(User::nameExists($path));
            $pun = $path->username;
            if(isset($_SESSION['uid'])&&!is_null($_SESSION['uid'])){
                $user = Factory::createUser()->getUserInfo($_SESSION['uid']);
                Render::index(Render::userProfile(Render::signedNav($user),$pun));
            }
            else{
                Render::index(Render::userProfile(Render::nav(),$pun));
            }
        }
        else{
            echo '<h1>404 NOT FOUND</h1>';
        }
    }

}

function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}