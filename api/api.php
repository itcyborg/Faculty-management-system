<?php

/**
 * Created by PhpStorm.
 * User: itcyb
 * Date: 4/12/2017
 * Time: 2:10 PM
 */
class apiException extends Exception {}

class api
{
    public $search="";
    function wiki($_wiki){
        $this->search=str_replace(" ", "+", $_wiki);
        $this->search=$this->search;
        if($wiki=file_get_contents("http://en.wikipedia.org/w/api.php?action=query&list=search&srsearch=".$this->search."&format=json")){
            $data=json_decode($wiki);
            return $data;
        }
        else{
            throw new apiException("Encountered an error fetching results");
        }
    }
}
