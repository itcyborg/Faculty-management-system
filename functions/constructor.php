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
        $url=$_SERVER['HTTP_REFERER'];
        $name = $_POST['name'];
        $department = $_POST['department'];
        include "function.php";
        $array=array(
            'code'=>$code,
            'name'=>$name,
            'department'=>$department,
            'url'   =>  $url
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

if(isset($_POST['addattendance'])){
    $url=$_SERVER['HTTP_REFERER'];
    $lecid=$_POST['lecid'];
    $courseid=$_POST['course'];
    $deptid=$_POST['deptid'];
    $array=array(
        'Dept_ID'   =>   $deptid,
        'Course_ID' =>   $courseid,
        'LecID'     =>   $lecid,
        'url'       =>   $url
    );
    include "function.php";
    addAttendance($array);
}

if(isset($_POST['attendancefill'])){
    $url=$_SERVER['HTTP_REFERER'];
    $id=$_POST['id'];
    $regno=$_POST['regno'];
    $pass=$_POST['pass'];
    include "function.php";
    fillAttendance(array('id'=>$id,'regno'=>$regno,'pass'=>$pass,'url'=>$url));
}

if(isset($_POST['addresource'])){
    $url=$_SERVER['HTTP_REFERER'];
    $type=$_POST['type'];
    $name=$_POST['name'];
    $file=$_FILES['file'];
    $uploadedby=$_POST['uploadedby'];
    $accesslevel=$_POST['level'];
    $dept_id=$_POST['deptid'];
    $description=$_POST['description'];
    $files=array('file'=>$file);
    $array=array(
        'type'          =>  $type,
        'name'          =>  $name,
        'uploader'      =>  $uploadedby,
        'dept'          =>  $dept_id,
        'description'   => $description,
        'access'        =>  $accesslevel,
        'url'           =>  $url
    );
    if($file['name']!=""){
        $array=array_merge($array,$files);
    }
    include "function.php";
    addResource($array);
}

if(isset($_POST['post'])){
    $url=$_SERVER['HTTP_REFERER'];
    $by=$_POST['by'];
    $comment=$_POST['comment'];
    $forumid=$_POST['forumid'];
    $array=array('by'=>$by,'content'=>$comment,'forum'=>$forumid,'url'=>$url);
    include "function.php";
    addPost($array);
}

if(isset($_POST['addorganisation'])){
    $url=$_SERVER['HTTP_REFERER'];
    $name=$_POST['name'];
    $type=$_POST['type'];
    $target=$_POST['target'];
    $slogan=$_POST['slogan'];
    $description=$_POST['description'];
    $leader=$_POST['leader'];
    $array=array(
        'name'=>$name,
        'type'=>$type,
        'target'=>$target,
        'slogan'=>$slogan,
        'description'=>$description,
        'leader'=>$leader,
        'url'   => $url
    );
    include "function.php";
    registerOrganisation($array);
}
if(isset($_GET['report']) && isset($_GET['cat'])){
    $id=$_GET['id'];
    $url=$_SERVER['HTTP_REFERER'];
    $sql="UPDATE posts SET Flag='1' WHERE ID='$id'";
    require "../system/newdb.php";
    $db=new newdb();
    try{
        $db->put($sql);
        header('location:'.$url);
    }catch (DBException $e){
        die($e);
    }
}