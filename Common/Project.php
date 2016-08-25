<?php
/**
 * Created by PhpStorm.
 * User: Deada
 * Date: 2016/7/25
 * Time: 8:46
 */

namespace Common;


class Project
{
    public $pid;
    public $projectName;
    public $pownerid;
    public $ptime;
    public $content;
    public $status;
    public $referby;

    public static function createProject($uid, $projectName, $content)
    {

        $data = array(
            'projectname' => $projectName,
            'pownerid' => $uid,
            'ptime' => time(),
            'pcontent' => $content);

        return $CreateP = Factory::createDatabase()->insert("project", $data);
    }

    public static function projectExists($projectName){
        $res=Factory::createDatabase()->select("project","pid",'projectname="'.$projectName.'"')->getResult();
        if($res['num']==1){
            return $res['result']['pid'];
        }
        else return false;
    }

    public function getProjInfo($pid){
        $sign = Factory::createDatabase()->select("project",'*',$pid)->getResult();
        if($sign['num']==1){
            $this->pid=$pid;
            $this->projectName=$sign['result']['projectname'];
            $this->pownerid=$sign['result']['pownerid'];
            $this->content=$sign['result']['pcontent'];
            $this->ptime=$sign['result']['ptime'];
            $this->status=$sign['result']['status'];
            $this->referby=$sign['result']['referby'];
            return $this;
        }
        else return false;
    }

    public static function getOneList($uid){
        $sign = Factory::createDatabase()->select("project",'*',$uid)->getResult();
        return $sign;
    }
}
