<?php

/**
 * Created by PhpStorm.
 * User: itcyb
 * Date: 4/24/2017
 * Time: 11:39 AM
 */
require $_SERVER['DOCUMENT_ROOT']."faculty/system/newdb.php";
require "api.php";
class searchException extends Exception{
    public function errorMessage()
    {
        $error="Error getting results from ".$this->getMessage();
        return $error;
    }
}
class searchdb extends newdb{}
class search extends searchdb
{
    protected $query;
    protected $output;
    private $api;
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

    private function searchError_logs($error){
        $file=fopen($_SERVER['DOCUMENT_ROOT'].'faculty/logs/searchError_logs.txt','a');
        fwrite($file,$error);
        fclose($file);
    }

    private function search_logs($search){
        $file=fopen($_SERVER['DOCUMENT_ROOT'].'faculty/logs/search_logs.txt','a');
        fwrite($file,$search);
        fclose($file);

    }

    public function all($query=null,$array=null){
        $this->api=new api($query);
        $this->search_logs("Api:".$query."\n");
        $_wiki="";
        $_archive="";
        $_resources="";
        $_news="";
        $_organisations="";
        try{
            $_wiki=$this->api->wiki();
        }catch (apiException $e){
            //throw new searchException("wikipedia");
            $this->searchError_logs($e);
            $_wiki=array();
        }
        try{
            $_archive=$this->api->archive();
        }catch (apiException $e){
            //throw new searchException("archive");
            $this->searchError_logs($e);
            $_archive=array();
        }
        try{
            $_resources=$this->resources($query);
        }catch (Exception $e){
            throw new searchException("resources");
        }

        try{
            $_news=$this->news($query);
        }catch (Exception $e){
            throw new searchException("resources");
        }

        try{
            $_organisations=$this->organisations($query);
        }catch (Exception $e){
            throw new searchException("resources");
        }
        return array('wiki'=>$_wiki,'archive'=>$_archive,'news'=>$_news,'resources'=>$_resources,'organisations'=>$_organisations);
    }
}

/*$search=new search();
try{
    var_dump($search->all("all the time to keep"));
}catch (searchException $e){
    echo $e->errorMessage();
}*/

