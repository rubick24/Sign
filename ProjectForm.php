<?php
/**
 * Created by PhpStorm.
 * User: Deada
 * Date: 2016/7/17
 * Time: 8:56
 */
require_once './Database.php';
require_once './User.php';

class Project
{
    public  $pid;
    private $projectName;
    private $pownerid;
    private $ptime;
    private $content;
    private $status;
    private $referby;

    public function createProject(User $user,$projectName,$content){
        if($user->level==1){
            $this->projectName = $projectName;
            $this->pownerid = $user->uid;
            $this->content = $content;
            $this->ptime = time();
            $CreateP = new Database();
            if ($CreateP->connect()){
                $data=array(
                    'projectname'=>$this->projectName,
                    'pownerid'   =>$this->pownerid,
                    'ptime'      =>$this->ptime,
                    'pcontent'   =>$this->content
                );
                if($CreateP->insert("users",$data)){
                    $CreateP->disconnect();
                    return true;
                }
                else {
                    $CreateP->disconnect();
                    return false;
                }
            }
            else return false;
        }
        else return false;
    }

    public function verifyProject(User $admin,Project $project){
        if($admin->level==3&&$project->status==0){
            $Sign = new Database();
            if($Sign->connect()){
                if($Sign->update("projectform",['status'=>1],['pid="'.$project->pid.'"'])){
                    $Sign->disconnect();
                    return true;
                }
                else {
                    $Sign->disconnect();
                    return false;
                }
            }
            else return false;
        }
        else return false;
    }

    public function getProjInfo($pid){
        $Sign = new Database();
        if($Sign->connect()){
            if($Sign->select("projectform",'*',"$pid"&&$Sign->getResultNum()==1)){
                $result=$Sign->getResult();
                $this->pid=$pid;
                $this->projectName=$result['projectname'];
                $this->pownerid=$result['pownerid'];
                $this->content=$result['pcontent'];
                $this->ptime=$result['ptime'];
                $this->status=$result['status'];
                $this->referby=$result['referby'];
                $Sign->disconnect();
                return $this;
            }
            else {
                $Sign->disconnect();
                return false;
            }
        }
        return false;
    }

    public function refer(User $level2,Project $project){
        if($level2->level==2&&$project->status==1){
            $Sign = new Database();
            if($Sign->connect()){
                if ($Sign->update("projectform",['referby'=>$project->referby.' '.$level2->username],['pid="'.$project->pid.'"'])){
                    $Sign->disconnect();
                    return true;
                }
                else {
                    $Sign->disconnect();
                    return false;
                }
            }
            else return false;
        }
        else return false;
    }

    public function deleteProj(User $user,Project $project){
        if($user->uid==$project->pid||$user->level==3){
            $Sign = new Database();
            if($Sign->connect()){
                if($Sign->delete("projectform",['pid="'.$project->pid.'"'])){
                    $Sign->disconnect();
                    return true;
                }
                else {
                    $Sign->disconnect();
                    return false;
                }
            }
            else return false;
        }
        else return false;
    }

}