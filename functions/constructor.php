<?php
/**
 * Created by PhpStorm.
 * User: itcyb
 * Date: 4/12/2017
 * Time: 12:39 PM
 */

if(isset($_POST['addcourse'])){
    if(isset($_POST['department']) && isset($_POST['name']) && isset($_POST['code'])) {
        $code = $_POST['code'];
        $name = $_POST['name'];
        $department = $_POST['department'];
        include "function.php";
        $array=array(
            'code'=>$code,
            'name'=>$name,
            'department'=>$department
        );
        addCourse($array);
    }else{
        echo 'Error. Please input all the required fields';
    }
}

if(isset($_POST['forum'])){
    $topic=$_POST['topic'];
    include "function.php";
    addForum($topic);
}