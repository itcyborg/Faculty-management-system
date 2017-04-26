<?php

/**
 * Created by PhpStorm.
 * User: itcyb
 * Date: 4/12/2017
 * Time: 2:10 PM
 */
class apiException extends Exception {}

/**
 * Class api
 */
class api
{
    /**
     * @var string
     */
    public $search="";

    /**
     * api constructor.
     * @param string $search
     */
    public function __construct($search)
    {
        $this->search =str_replace(" ", "+", $search);
    }

    /**
     * @param $_wiki
     * @return mixed
     * @throws apiException
     */
    function wiki(){
        if(@$wiki=file_get_contents("http://en.wikipedia.org/w/api.php?action=query&list=search&srsearch=".$this->search."&format=json")){
            $data=json_decode($wiki);
            return $data;
        }
        else{
            throw new apiException("Encountered an error fetching results");
        }
    }

    function archive(){
        if(@$archive=file_get_contents("https://archive.org/advancedsearch.php?q=$this->search~&description&title&source&output=json&rows=10")){
            return json_decode($archive);
        }else{
            throw new apiException("Encountered an error fetching results");
        }
    }
}
