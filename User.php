<?php
require_once './Database.php';
/**
 * Created by PhpStorm.
 * User: Deada
 * Date: 2016/7/16
 * Time: 18:24
 */
class User
{
    public $uid;
    public $username;
    public $level;
    public $password;
    public $email;
    public $moreInfo;
    public $lasttime;

    public static function checkName($username){
        $Check = new Database();
        if($Check->connect()){
            $Check->select("users","uid",'username="'.$username.'"');
            if($Check->getResultNum()==0){
                return true;
            }
            else return false;
        }
        else return false;
    }
    public static function checkEmail($username){
        $Check = new Database();
        if($Check->connect()){
            $Check->select("users","uid",'email="'.$username.'"');
            if($Check->getResultNum()==0){
                return true;
            }
            else return false;
        }
        else return false;
    }

    public static function regUser($username,$password,$email,$level=0){
        $CreateU = new Database();
        if($CreateU->connect()){
            $regtime  = time();
            $token    = md5($username.$password.$regtime);
            $data=array(
                'username' => $username,
                'password' => $password,
                'email'    => $email,
                'regtime'  => $regtime,
                'token'    => $token,
                'level'    => $level
            );
            if($CreateU->insert("users",$data)){
                $CreateU->disconnect();
                return true;
            }
            else {
                $CreateU->disconnect();
                return false;
            }
        }
        else return false;
    }
    
    public function signIn($userInput,$password){
        $Sign = new Database();
        if ($Sign->connect()){
            if(preg_match('/^\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*/',$userInput)){
                $Sign->select("users","uid",'email="'.$userInput.'"');
            }
            else{
                $Sign->select("users","uid",'username="'.$userInput.'"');
            }
            if($Sign->getResultNum()==1){

                $result=$Sign->getResult();
                $this->uid=$result['uid'];
                $Sign->select("users","password",'uid="'.$this->uid.'"');
                $result=$Sign->getResult();
                if($password==$result['password']){
                    $Sign->update("users",["lasttime"=>time()],['uid="'.$this->uid.'"']);
                    $Sign->select("users","level",'uid="'.$this->uid.'"');
                    $result=$Sign->getResult();
                    $this->level=$result['level'];
                    $_SESSION['uid']=$this->uid;
                    $Sign->disconnect();
                    return $this;
                }
                else {
                    $Sign->disconnect();
                    return false;
                }
            }
            else {
                $Sign->disconnect();
                return false;
            }
        }
        else return false;
    }

    public static function signOut(){
        $_SESSION['uid']=null;
        session_destroy();
    }

    public function  getUserInfo($uid){
        $Sign = new Database();
        if ($Sign->connect()){
            $Sign->select("users",'*','uid="'.$uid.'"');
            if($Sign->getResultNum()==1){
                $result=$Sign->getResult();
                $this->uid=$uid;
                $this->username=$result['username'];
                $this->password=$result['password'];
                $this->email=$result['email'];
                $this->level=$result['level'];
                $this->lasttime=$result['lasttime'];
                $this->moreInfo=$result['moreinfo'];
                $Sign->disconnect();
                return $this;
            }
            else {
                $Sign->disconnect();
                return false;
            }
        }
        else return false;
    }

    public static function verifyUser(User $admin,User $user){
        if ($admin->level==3&&$user->level==0){
            $Sign = new Database();
            if($Sign->connect()){
                if($Sign->update("users",['level'=>1],['uid="'.$user->uid.'"'])){
                    $Sign->disconnect();
                    return true;
                }
                else {
                    return false;
                }
            }
            else return false;
        }
        else return false;
    }

    public static function deleteUser(User $admin,User $user){
        if ($admin->level==3&&$user->level==0){
            $Sign = new Database();
            if($Sign->connect()){
                if($Sign->delete("users",['uid="'.$user->uid.'"'])){
                    $Sign->disconnect();
                    return true;
                }
                else {
                    return false;
                }
            }
            else return false;
        }
        else return false;
    }
}