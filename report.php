<?php
/**
 * Created by PhpStorm.
 * User: itcyb
 * Date: 5/1/2017
 * Time: 9:40 AM
 */
require "system/newdb.php";
$db=new newdb();
if(isset($_GET['forum'])){
    $url=$_SERVER['HTTP_REFERER'];
    $id=$_GET['id'];
    $sql="UPDATE forums SET Flag='1' WHERE Forum_ID='$id'";
    $result=$db->put($sql);
    var_dump($result);
    header('location:'.$url);
}