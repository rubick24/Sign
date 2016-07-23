<?php
/**
 * Created by PhpStorm.
 * User: Deada
 * Date: 2016/7/23
 * Time: 9:33
 */

namespace Common;


class Database
{
    protected static $db;

    private $db_host = '127.0.0.1';
    private $db_user = 'root';
    private $db_pass = 'qqqqqq';
    private $db_name = 'new';

    private $con;
    private $result = array();
    private $resultNum;

    private function __construct(){
        if(!($this->con=mysqli_connect($this->db_host,$this->db_user,$this->db_pass,$this->db_name))){
            echo mysqli_error($this->con);
        }
        mysqli_query($this->con,'set names utf8');
    }
    private function __clone(){}

    static function getInstance(){
        if(self::$db){
            return self::$db;
        }
        else{
            self::$db = new self();
            return self::$db;
        }
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

    function select($table,$rows = "*",$where = null,$order = null){
        if($this->tableExists($table)){
            $q= 'SELECT '.$rows.' FROM '.$table;
            if(isset($where)&&!empty($where))
                $q .= ' WHERE '.$where;
            if(isset($order)&&!empty($order))
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
                return $this;
            }
            else return false;
        }
        else return false;
    }

    public function insert($table,$data){
        if($this->tableExists($table)){
            $insert = "INSERT INTO ".$table;
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
            if($ins)
                return true;
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

    function getResult(){
        return ['num'=>$this->resultNum,'result'=>$this->result];
    }

}