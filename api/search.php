<?php

/**
 * Created by PhpStorm.
 * User: itcyb
 * Date: 4/24/2017
 * Time: 11:39 AM
 */
require $_SERVER['DOCUMENT_ROOT']."/system/newdb.php";
require "api.php";

/**
 * Class searchException
 */
class searchException extends Exception{
    /**
     * @return string
     */
    public function errorMessage()
    {
        $error="Error getting results from ".$this->getMessage();
        return $error;
    }
}

/**
 * Class searchdb
 */
class searchdb extends newdb{}

/**
 * Class search
 */
class search extends searchdb
{
    /**
     * @var
     */
    protected $query;
    /**
     * @var
     */
    protected $output;
    /**
     * @var
     */
    private $api;

    private $isadmin;

    /**
     * @param null $query
     * @param null $array
     * @return array
     * @throws searchException
     */
    public function all($query = null, $array = null)
    {
        $this->api = new api($query);
        $this->search_logs("Api:" . $query . "\n");
        $_wiki = "";
        $_archive = "";
        $_resources = "";
        $_news = "";
        $_organisations = "";
        $output = array();
        try {
            $_resources = $this->resources($query);
            foreach ($_resources as $key => $value) {
                $output[] = (object)array(
                    'link' => "/resources/" . $value['ResourceID'],
                    'title' => $value['Name'],
                    'source' => "Local resource",
                    'snippet' => substr($value['Description'], 0, 250) . "..."
                );
            }
        } catch (Exception $e) {
            throw new searchException("resources");
        }
        try {
            $_news = $this->news($query);
            foreach ($_news as $key => $value) {
                $output[] = (object)array(
                    'link' => $value['title'],
                    'title' => $value['title'],
                    'source' => $value['local news'],
                    'snippet' => $value['date'] . "<br>" . substr($value['content'], 0, 250) . "...",
                );
            }
        } catch (Exception $e) {
            throw new searchException("news");
        }

        try {
            $_organisations = $this->organisations($query);
            foreach ($_organisations as $key => $value) {
                $output[] = (object)array(
                    'link' => "/organisations/" . str_replace(" ", "-", $value['name']),
                    'title' => $value['name'],
                    'source' => 'local organisations',
                    'snippet' => "Type:<i>" . $value['type'] . "</i><br>Slogan: <i>" . $value['slogan'] . "</i><br>" . substr($value['description'], 0, 250) . "...",
                );
            }
            $object[] = (object)$_organisations;
        } catch (Exception $e) {
            throw new searchException("organisations");
        }
        try {
            $_wiki = $this->api->wiki();
            foreach ($_wiki->query->search as $key => $value) {
                $output[] = (object)array(
                    'link' => "http://en.wikipedia.org/wiki/" . $value->title,
                    'title' => $value->title,
                    'source' => "Wikipedia.org",
                    'snippet' => substr($value->snippet, 0, 200)
                );
            }
        } catch (apiException $e) {
            //throw new searchException("wikipedia");
            $this->searchError_logs($e);
            $_wiki = array();
        }
        try {
            $_archive = $this->api->archive();
            foreach ($_archive->response->docs as $doc) {
                if (isset($doc->description)) {
                    $snippet = $doc->description;
                } else {
                    $snippet = "";
                }
                if (is_array($snippet)) {
                    $snippet = $snippet[0];
                }
                $output[] = (object)array(
                    'link' => "https://www.archive.org/details/" . $doc->identifier,
                    'title' => $doc->title,
                    'source' => "Archive.org",
                    'snippet' => substr($snippet, 0, 250) . "..."
                );
            }
        } catch (apiException $e) {
            //throw new searchException("archive");
            $this->searchError_logs($e);
            $_archive = array();
        }
        return $output;
    }

    /**
     * @param $search
     */
    private function search_logs($search)
    {
        $file = fopen($_SERVER['DOCUMENT_ROOT'] . '/logs/search_logs.fcts', 'a');
        fwrite($file, $search);
        fclose($file);

    }

    /**
     * @param null $query
     * @return array
     * @throws searchException
     */
    public function resources($query=null){
        $this->query=$query;
        $search_string=trim($this->query);
        $remove=array("if","in","at","this","an","then","at","the","to");
        $searchterms=explode(" ",$search_string);
        $safe_search=array();
        $resource_construct="";
        $x=0;
        foreach ($searchterms as $value) {
            $x++;
            if (!in_array($value, $remove)) {
                $safe_search[] = $value;
                $safe=implode(" ",$safe_search);
                if($x==1){
                    $resource_construct.="Name like '%$value%' || ResourceID like '%$value%' || Description like '%$value%'";
                }else{
                    $resource_construct.=" || Name like '%$value%' || ResourceID like '%$value%' || Description like '%$value%'";
                    $resource_construct.=" || Name like '%$query%' || ResourceID like '%$query%' || Description like '%$query%'";
                }
            }
        }
        $sql="SELECT * FROM resources WHERE ".$resource_construct;
        try{
            $this->search_logs($sql."\n");
            return $result=$this->get($sql)->fetchAll(PDO::FETCH_NAMED);
        }catch (DBException $e){
            throw new searchException("resources");
        }
    }

    /**
     * @param null $query
     * @return array
     * @throws searchException
     */
    public function news($query=null){
        $this->query=$query;
        $search_string=trim($this->query);
        $remove=array("if","in","at","this","an","then","at","the","to");
        $searchterms=explode(" ",$search_string);
        $safe_search=array();
        $resource_construct="";
        $x=0;
        foreach ($searchterms as $value) {
            $x++;
            if (!in_array($value, $remove)) {
                $safe_search[]=$value;
                $safe=implode(" ",$safe_search);
                if($x==1){
                    $resource_construct.="Title like '%$value%' || Date like '%$value%' || Content like '%$value%'";
                }else{
                    $resource_construct.=" || Title like '%$value%' || Date like '%$value%' || Content like '%$value%'";
                    $resource_construct.=" || Title like '%$query%' || Date like '%$query%' || Content like '%$query%'";
                }
            }
        }
        $sql="SELECT * FROM news WHERE ".$resource_construct;
        try{
            $this->search_logs($sql."\n");
            return $result=$this->get($sql)->fetchAll(PDO::FETCH_NAMED);
        }catch (DBException $e){
            throw new searchException("news");
        }
    }

    /**
     * @param null $query
     * @return array
     * @throws searchException
     */
    public function organisations($query=null){
        $this->query=$query;
        $search_string=trim($this->query);
        $remove=array("if","in","at","this","an","then","at","the","to");
        $searchterms=explode(" ",$search_string);
        $safe_search=array();
        $resource_construct="";
        $x=0;
        foreach ($searchterms as $value) {
            $x++;
            if (!in_array($value, $remove)) {
                $safe_search[] = $value;
                $safe=implode(" ",$safe_search);
                if($x==1){
                    $resource_construct.="name like '%$value%' || type like '%$value%' || target like '%$value%' || slogan like '%$value' || Description like '%$value%'";
                }else{
                    $resource_construct.=" || name like '%$value%' || type like '%$value%' || target like '%$value%' || slogan like '%$value' || Description like '%$value%'";
                    $resource_construct.=" || name like '%$query%' || type like '%$query%' || target like '%$query%' || slogan like '%$query' || Description like '%$query%'";
                }
            }
        }
        $sql="SELECT * FROM studentorgs WHERE ".$resource_construct;
        try{
            $this->search_logs($sql."\n");
            return $result=$this->get($sql)->fetchAll(PDO::FETCH_NAMED);
        }catch (DBException $e){
            throw new searchException("student organisations");
        }
    }

    /**
     * @param $error
     */
    private function searchError_logs($error){
        $file=fopen($_SERVER['DOCUMENT_ROOT'].'/logs/searchError_logs.fct','a');
        fwrite($file,$error);
        fclose($file);
    }

    /**
     * @return mixed
     */
    public function getIsadmin()
    {
        return $this->isadmin;
    }

    /**
     * @param mixed $isadmin
     */
    public function setIsadmin($isadmin)
    {
        $this->isadmin = $isadmin;
    }

    public function searchStudent($student = null)
    {
        if ($this->isadmin) {
            $this->query = $student;
            $sql = "SELECT * FROM fine.students WHERE adm_number LIKE '%$this->query%' || name LIKE '%$this->query%' || year LIKE '%$this->query%' || email LIKE '%$this->query%' || course LIKE '%$this->query%' || contact LIKE '%$this->query%'";
            $_result = $this->get($sql);
            $result = $_result->fetchAll(PDO::FETCH_OBJ);
        } else {
            throw new searchException("Access Denied. This feature is restricted to some users.");
        }
        return $result;
    }

}