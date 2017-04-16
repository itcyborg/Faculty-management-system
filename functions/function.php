<?php
/**
 * Created by PhpStorm.
 * User: itcyb
 * Date: 4/12/2017
 * Time: 9:27 AM
 */

include '../system/db.php';
$db=new db();

function addCourse($array){
    global $db;
    $course_code=$array['code'];
    $course_name=$array['name'];
    $department=$array['department'];
    $sql="INSERT INTO courses(CourseCode,CourseName,DepartmentID) VALUES ('".$course_code."','".$course_name."','".$department."')";
    try{
        $result=$db->putRecord($sql);
        var_dump($result);
    }catch (dbException $e){
        echo $e;
    }
}

function addForum($topic){
    global $db;
    $forumid="F".generateID();
    $by="ADMIN";
    $sql="INSERT INTO fms.forums(Forum_ID, Topic, ThreadBy) VALUES ('$forumid','$topic','$by')";
    try{
        $db->putRecord($sql);
    }catch (dbException $e){
        echo $e;
    }
}

function generateID(){
    $keyspace="ABCDEFGHIJKLMNPQRSTUVWXYZ123456789";
    $length=7;
    $idstr=array();
    $max=strlen($keyspace)-1;
    for($i=0;$i<$length;++$i){
        $n=rand(0,$max);
        $idstr[]=$keyspace[$n];
    }

    return implode($idstr);
}