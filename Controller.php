<?php
require_once './Database.php';
require_once './User.php';
require_once './ProjectForm.php';
session_start();
if(isSetNotEmpty($_POST['code'])){
    switch ($_POST['code']){
        case 1: {
            if(isSetNotEmpty($_POST['userinput'])&&isSetNotEmpty($_POST['password'])){
                $userInput = test_input($_POST['userinput']);
                $password  = md5(test_input($_POST['password']));
                $User = new User();
                if($User->signIn($userInput,$password)){
                    $User = $User->getUserInfo($User->signIn($userInput,$password)->uid);
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
            echo json_encode(['status'=>true,'msg'=>'sign out success']);
            break;
        }

        case 3: {
            if(isSetNotEmpty($_POST['username'])){
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
            if(isSetNotEmpty($_POST['email'])){
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
            if (isSetNotEmpty($_POST['username'])&&isSetNotEmpty($_POST['email'])&&isSetNotEmpty(['password'])){
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


function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}