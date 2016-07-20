<?php

/**
 * Created by PhpStorm.
 * User: Deada
 * Date: 2016/7/16
 * Time: 16:53
 */
class Database
{
    private $db_host = '127.0.0.1';
    private $db_user = 'root';
    private $db_pass = 'qqqqqq';
    private $db_name = 'new';

    private $con;
    private $result = array();
    private $resultNum;

    public function connect(){
        if(!($this->con=mysqli_connect($this->db_host,$this->db_user,$this->db_pass))){
            echo mysqli_error($this->con);
            return false;
        }
        if(!mysqli_select_db($this->con,$this->db_name)){
            echo mysqli_error($this->con);
            return false;
        }

        mysqli_query($this->con,'set names utf8');
        return true;
    }

    public function disconnect(){
        if($this->con){
            if(mysqli_close($this->con)){
                $this->con=null;
                return true;
            }
            else return false;
        }
        else return false;
    }

    private function tableExists($table){
        $tablesInDb = mysqli_query($this->con,'SHOW TABLES FROM '.$this->db_name.' LIKE "'.$table.'"');
        if($tablesInDb){
            if(mysqli_num_rows($tablesInDb)==1){
                return true;
            }
            else return false;
        }
        else return false;
    }

    public  function select($table,$rows = "*",$where = null,$order = null){
        if($this->tableExists($table)){
            $q= 'SELECT '.$rows.' FROM '.$table;
            if(isSetNotEmpty($where))
                $q .= ' WHERE '.$where;
            if(isSetNotEmpty($order))
                $q .= ' ORDER BY '.$order;
            $query = mysqli_query($this->con,$q);
            if($query){
                $this->resultNum = mysqli_num_rows($query);
                for($i=0;$i<$this->resultNum;$i++){
                    $result=mysqli_fetch_assoc($query);
                    $key = array_keys($result);
                    for ($n = 0;$n < count($key);$n++){
                        if($this->resultNum>1)
                            $this->result[$i][$key[$n]] = $result[$key[$n]];
                        else if($this->resultNum<1)
                            $this->result = null;
                        else $this->result[$key[$n]] = $result[$key[$n]];
                    }
                }
               // echo json_encode($this->result);
                return true;
            }
            else return false;
        }
        else return false;
    }

    public function insert($table,$data){
        if($this->tableExists($table)){
            $insert = 'INSERT INTO '.$table;
            $keys=array_keys($data);
            $keys=implode(',',$keys);
            $values=array_values($data);
            if(!is_null($keys)){
                $insert.= ' ('.$keys.')';
            }

            for($i=0;$i<count($values);$i++){
                if(is_string($values[$i]))
                    $values[$i] = '"'.$values[$i].'"';
            }
            $values = implode(',',$values);
            $insert .= ' VALUES ('.$values.')';
            $ins = mysqli_query($this->con,$insert);
            if($ins) return true;
            else return false;
        }
        else return false;
    }

    public function delete($table,$where=null){
        if($this->tableExists($table)){
            if(is_null($where)){
                $delete = 'DELETE '.$table;
            }
            else{
                $delete = 'DELETE FROM'.$table.' WHERE '.$where;
            }
            $del = mysqli_query($this->con,$delete);
            if($del) return true;
            else return false;
        }
        else return false;
    }

    public  function  update($table,$rows,$where){
        if($this->tableExists($table)){
            for($i=0;$i < count($where);$i++){
                if($i%2 != 0){
                    if(is_string($where[$i])){
                        if(($i+1) != null)
                            $where[$i] = '"'.$where[$i].'" AND ';
                        else
                            $where[$i] = '"'.$where[$i].'"';
                    }
                }
            }
            $where = implode('',$where);
            $update = 'UPDATE '.$table.' SET ';
            $keys = array_keys($rows);
            for($i = 0; $i < count($rows); $i++)
            {
                if(is_string($rows[$keys[$i]]))
                {
                    $update .= $keys[$i].'="'.$rows[$keys[$i]].'"';
                }
                else
                {
                    $update .= $keys[$i].'='.$rows[$keys[$i]];
                }

                if($i != count($rows)-1)
                {
                    $update .= ',';
                }
            }
            $update .= ' WHERE '.$where;
            $query = mysqli_query($this->con,$update);
            if($query) return true;
            else return false;
        }
        else return false;
    }

    public function getResult(){
        return $this->result;
    }

    public function getResultNum(){
        return $this->resultNum;
    }

}

function isSetNotEmpty($var){
    if(isset($var)&&!empty($var)){
        return true;
    }
    else return false;
}