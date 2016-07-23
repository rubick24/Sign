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
            self::ajax();
        }
        else{
            if(isset($_SESSION['uid'])&&!is_null($_SESSION['uid'])){
                $user = Factory::createUser()->getUserInfo($_SESSION['uid']);
                Render::signedIndex($user);
            }
            else{
                Render::index();
            }
        }
    }
    static function ajax(){
        switch ($_POST['code']){
            case 1: {
                if(isset($_POST['userinput'])&&!empty($_POST['userinput'])&&isset($_POST['password'])&&!empty($_POST['password'])){
                    $userInput = test_input($_POST['userinput']);
                    $password  = md5(test_input($_POST['password']));
                    $User = Factory::createUser()->signIn($userInput,$password);
                    if($User){
                        $User = $User->getUserInfo($User->uid);
                        $data = [
                            "status"   =>  true,
                            "uid"      =>  $User->uid,
                            "username" =>  $User->username,
                            "level"    =>  $User->level
                        ];
                        echo json_encode($data);
                        break;
                    }
                    else {
                        echo json_encode(['status'=> false,'msg'=>'incorrect input']);
                        break;
                    }
                }
                else {
                    echo json_encode(['status'=> false,'msg'=>'userinput or password can\'t be empty' ]);
                    break;
                }
            }

            case 2: {
                User::signOut();
                break;
            }

            case 3: {
                if(isset($_POST['username'])&&!empty($_POST['username'])){
                    $username=test_input($_POST['username']);
                    if(User::checkName($username)){
                        echo json_encode(['status'=>true]);
                    }
                    else {
                        echo json_encode(['status'=>false,'msg'=>'This username has been registered']);
                    }
                    break;
                }
                else {
                    echo json_encode(['status'=>false,'msg'=>'username can\'t be empty']);
                    break;
                }
            }

            case 4: {
                if(isset($_POST['email'])&&!empty($_POST['email'])){
                    $email = test_input($_POST['email']);
                    if(User::checkEmail($email)){
                        echo json_encode(['status'=>true]);
                    }
                    else {
                        echo json_encode(['status'=>false,'msg'=>'This email has been registered']);
                    }
                    break;
                }
                else {
                    echo json_encode(['status'=>false,'msg'=>'email can\'t be empty']);
                    break;
                }
            }

            case 5: {
                if (isset($_POST['username'])&&!empty($_POST['username'])&&isset($_POST['email'])&&!empty($_POST['email'])&&isset($_POST['password'])&&!empty($_POST['password'])){
                    $username = test_input($_POST['username']);
                    $password = md5(test_input($_POST['password']));
                    $email = test_input($_POST['email']);

                    if(User::regUser($username,$password,$email)){
                        echo json_encode(['status'=>true]);
                    }
                    else {
                        echo json_encode(['status'=>false]);
                    }

                    break;
                }
                else {
                    echo json_encode(['status'=>false]);
                    break;
                }
            }

            default: {
                echo json_encode(['status'=>false,'msg'=>'unknown request code']);
            }

        }
    }
    static function test($uid){
        $rel = Factory::createDatabase()->select("users",'*','uid="'.$uid.'"')->getResult();
        if($rel['num']==1){
            echo 'success';
        }
        else echo 'failed';
    }
}

function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}