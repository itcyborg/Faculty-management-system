<?php

/**
 * Created by PhpStorm.
 * User: itcyb
 * Date: 4/12/2017
 * Time: 9:27 AM
 */
define('DBUSER','root');
define('DBPASS','');
define('HOST','localhost');
define('DBNAME','fms');

class dbException extends Exception {}
class db
{
    public $connfile="";
    protected $sql="";
    protected $result="";
    function conn(){
        return $this->setConnection();
    }

    function setConnection(){
        $conn = new mysqli(HOST, DBUSER, DBPASS, DBNAME);

        // Check connection
        if ($conn->connect_error){
            throw new dbException("Connection failed: ".mysqli_connect_error());
        }
        return $conn;
    }

    public function getRecord($sql){
        $conn=$this->conn();
        $this->result=$conn->query($sql);
        if($conn->error){
            throw new dbException("Error: ".mysqli_error($conn));
        }
        return $this->result;
    }

    public function putRecord($sql){
        $conn=$this->conn();
        $this->result=$conn->query($sql);
        if($conn->error){
            throw new dbException("Error: ".mysqli_error($conn));
        }else{
            if($conn->insert_id) {
                $this->result = $conn->insert_id;
            }else{
                $this->result="Success";
            }
        }
        return $this->result;
    }
}