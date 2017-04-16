<?php
/**
 * Created by PhpStorm.
 * User: itcyb
 * Date: 4/16/2017
 * Time: 6:25 PM
 */
if(isset($_GET['forums'])){
    $forum=$_GET['forums'];
    if($forum=="list"){
        require "system/db.php";
        $db=new db();
        $sql="SELECT * FROM forums";
        $result=$db->getRecord($sql);
        $output="";
        while($row=$result->fetch_assoc()){
            $output.="<a href='view.php?forums=id&id=".$row['Forum_ID']."'>".$row['Topic']."</a><br>";
        }
        echo $output;
    }
    if($forum=="id"){
        $id=$_GET['id'];
        $posts="";
        echo $id;
    }
}