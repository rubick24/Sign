<?php
/**
 * Created by PhpStorm.
 * User: Deada
 * Date: 2016/7/23
 * Time: 10:16
 */

namespace Common;


class User
{
    protected static $user;

    public $uid;
    public $username;
    public $level;
    public $email;
    public $password;
    public $regtime;
    public $lasttime;
    public $moreinfo;

    private function __construct(){}
    private function __clone(){}
    static function getInstance(){
        if(self::$user){
            return self::$user;
        }
        else{
            self::$user = new self();
            return self::$user;
        }
    }
    public static function nameExists($username){
        $Check = Factory::createDatabase()->select("users","uid",'username="'.$username.'"')->getResult();
        if($Check['num']==1){
            return $Check['result']['uid'];
        }
        else return false;
    }

    public static function emailExists($email){
        $Check = Factory::createDatabase()->select("users","uid",'email="'.$email.'"')->getResult();
        if($Check['num']==1){
            return true;
        }
        else return false;
    }

    public static function regUser($username,$password,$email,$level=0){
        $regtime  = time();
        $token    = md5($username.$password.$regtime);
        $data=array(
            'username' => $username,
            'password' => $password,
            'email'    => $email,
            'regtime'  => $regtime,
            'token'    => $token,
            'level'    => $level,
            'moreinfo' => "empty"
        );
        return Factory::createDatabase()->insert("users",$data);
    }

    public function signIn($userInput,$password)
    {
        $Sign = Factory::createDatabase();
        if (preg_match('/^\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*/', $userInput)) {
            $rel= $Sign->select("users", "uid", 'email="' . $userInput . '"')->getResult();
        } else {
            $rel= $Sign->select("users", "uid", 'username="' . $userInput . '"')->getResult();
        }
        if ($rel['num'] == 1) {
            $this->uid = $rel['result']['uid'];
            $rel = $Sign->select("users", "password", 'uid="' . $this->uid . '"')->getResult();
            if ($password == $rel['result']['password']) {
                $Sign->update("users", ["lasttime" => time()], ['uid="' . $this->uid . '"']);
                $_SESSION['uid'] = $this->uid;
                return $this;
            }
            else {
                echo json_encode(['status'=>false,'msg'=>'wrong password']);
                return false;
            }
        }
        else {
            echo json_encode(['status'=>false,'msg'=>'username can\'t be empty']);
            return false;
        }
    }

    public static function signOut(){
        $_SESSION['uid']=null;
        session_destroy();

        echo json_encode(['status'=>true,'msg'=>'sign out success']);
        return true;
    }

    public function  getUserInfo($uid){
        $Sign = Factory::createDatabase()->select("users",'*','uid="'.$uid.'"')->getResult();
        if($Sign['num']==1){
            $this->uid=$uid;
            $this->username=$Sign['result']['username'];
            $this->email=$Sign['result']['email'];
            $this->password=$Sign['result']['password'];
            $this->level=$Sign['result']['level'];
            $this->regtime=$Sign['result']['regtime'];
            $this->lasttime=$Sign['result']['lasttime'];
            $this->moreinfo=$Sign['result']['moreinfo'];
            return $this;
        }
        else return false;
    }




}