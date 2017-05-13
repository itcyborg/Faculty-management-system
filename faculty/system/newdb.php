<?php

/**
 * Created by PhpStorm.
 * User: itcyb
 * Date: 4/18/2017
 * Time: 8:54 PM
 */
class DBException extends Exception {}

/**
 * Class newdb
 */
class newdb
{
    /**
     * @var string
     */
    protected $queryString;
    /**
     * @var PDO
     */
    private $connection;
    /**
     * @var string
     */
    private $dbuser;
    /**
     * @var string
     */
    private $dbname;
    /**
     * @var string
     */
    private $dbpass;
    /**
     * @var string
     */
    private $dbhost;

    public function __construct()
    {
        $this->dbuser = "root";
        $this->dbname = "fms";
        $this->dbpass = "";
        $this->dbhost = "localhost";
        $this->queryString = "";
        try{
            $this->connection=new PDO("mysql:host=$this->dbhost;dbname=$this->dbname",$this->dbuser,$this->dbpass,array(PDO::ATTR_EMULATE_PREPARES=> true,PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,INFO_GENERAL));
        }catch (PDOException $e){
            throw new DBException($e);
        }
    }

    public function connectionInfo(){
        return $this->connection->getAttribute(PDO::ATTR_SERVER_INFO);
    }

    /**
     * @param null $sql
     * @return array
     * @throws DBException
     */
    public function put($sql=NULL){
        try{
            $this->connection->query($sql);
            return $this->connection->errorInfo();
        }catch (PDOException $e){
            throw new DBException($e);
        }
    }

    /**
     * @param null $sql
     * @return PDOStatement
     * @throws DBException
     */
    public function get($sql=NULL){
        try{
            return $this->connection->query($sql);
        }catch (PDOException $e){
            //throw new DBException($e);
            die($e);
        }
    }

    /**
     * @param null $sql
     * @return int
     * @throws DBException
     */
    public function createTable($sql=null){
        try{
            return $this->connection->exec($sql);
        }catch (PDOException $e){
            throw new DBException($e);
        }
    }
}