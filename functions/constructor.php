<?php
session_start();
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
            'department' => $department
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
    $lecid=$_POST['lecid'];
    $courseid=$_POST['course'];
    $deptid=$_POST['deptid'];
    $array=array(
        'Dept_ID'   =>   $deptid,
        'Course_ID' =>   $courseid,
        'LecID' => $lecid
    );
    include "function.php";
    addAttendance($array);
}

if(isset($_POST['attendancefill'])){
    $id=$_POST['id'];
    $regno=$_POST['regno'];
    include "function.php";
    fillAttendance(array('id'=>$id,'regno'=>$regno));
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
        'leader'=>$leader
    );
    include "function.php";
    echo registerOrganisation($array);
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

if(isset($_POST['search'])){
    require $_SERVER['DOCUMENT_ROOT']."/api/search.php";
    $_search=new search();
    $term=$_POST['term'];
    $_result=$_search->all($term);
    $count=sizeof($_result);
    echo "<small><i>Showing $count results for : <u><b>$term</b></u></i></small>";
    foreach ($_result as $item) {
        $title=$item->title;
        $link=$item->link;
        $snippet=$item->snippet;
        $source=$item->source;
        echo "<h2><a href='$link' target='_blank'>$title</a></h2><br> Source:<small><i>$source</i></small><p>$snippet</p>";
    }
}

if(isset($_POST['addlecturers'])){
    $id = $_POST['id'];
    $name = $_POST['name'];
    $dep = $_POST['dep'];
    $contact = $_POST['contact'];
    $email = $_POST['email'];
    $array=array(
        'id'    =>  $id,
        'name'  =>  $name,
        'dep'   =>  $dep,
        'contact'=> $contact,
        'email' => $email
    );
    include "function.php";
    var_dump(addLecturer($array));
}

if (isset($_POST['editlecturers'])) {
    $action = $_POST['action'];
    $id = $_POST['id'];
    $name = $_POST['name'];
    $contact = $_POST['contact'];
    $email = $_POST['email'];
    $department = $_POST['department'];

    $array = array(
        'action' => $action,
        'id' => $id,
        'name' => $name,
        'contact' => $contact,
        'email' => $email,
        'department' => $department
    );
    require $_SERVER['DOCUMENT_ROOT'] . "/functions/function.php";
    $_result = editLectuers($array);
    echo $_result;
}

if(isset($_POST['timetable'])){
    if (isset($_SESSION['year']) && isset($_SESSION['sem']) && isset($_SESSION['course'])) {
        $slot = $_POST['slot'];
        $unit = $_POST['unit'];
        $slot = explode('|', $slot);
        $array = 'day => ' . $slot[0] . ', time => ' . $slot[1] . ', unit => ' . $unit;
        if (stristr($_SESSION['tt'], $array)) {

        } else {
            if ($_SESSION['tt'] != "") {
                $_SESSION['tt'] .= "|" . $array;
            } else {
                $_SESSION['tt'] .= $array;
            }
        }
        echo $_SESSION['tt'];
    }
}

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $pass = $_POST['password'];
    $ajax = false;
    if (isset($_POST['synche'])) {
        $ajax = true;
    } else {
        $ajax = false;
    }
    $array = array(
        'email' => $email,
        'password' => $pass,
        'ajax' => $ajax
    );
    require $_SERVER['DOCUMENT_ROOT'] . "/functions/function.php";
    login($array);
}

if (isset($_POST['addstudent'])) {
    $adm = $_POST['adm'];
    $name = $_POST['name'];
    $year = $_POST['year'];
    $course = $_POST['course'];
    $contact = $_POST['contact'];
    $email = $_POST['email'];
    $array = array(
        'adm' => $adm,
        'name' => $name,
        'year' => $year,
        'course' => $course,
        'contact' => $contact,
        'email' => $email
    );
    require $_SERVER['DOCUMENT_ROOT'] . "/functions/function.php";
    addStudent($array);
}

if (isset($_POST['editstudent'])) {
    $array = array(
        'adm' => $_POST['id'],
        'email' => $_POST['email'],
        'name' => $_POST['name'],
        'contact' => $_POST['contact'],
        'course' => $_POST['course'],
        'year' => $_POST['year']
    );
    require "function.php";
    $response = editStudent($array);
    echo $response;
}