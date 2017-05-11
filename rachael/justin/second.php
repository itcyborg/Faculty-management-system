<?php
session_start();
	if(!isset($_SESSION['username'])){
		header("Location: index.php");
}
$id=$_POST['id'];
$user=$_SESSION['username'];
$db=new PDO("mysql:host=localhost;dbname=fine","root","");
$hasAlreadyliked=$db->query("SELECT * FROM suggestion_likes WHERE `suggestion_id`=$id AND `liked_by`='$user'");
$test=$hasAlreadyliked->fetch();
if($test[0]==null){
	$insertIntoLikes=$db->query("INSERT INTO `suggestion_likes` (`suggestion_id`, `liked_by`, `time`) VALUES ($id, '$user',NOW())");
	$query=$db->query("SELECT * FROM suggestions WHERE `id`=$id");
	while($row=$query->fetch()){
	$new=$row[5]+1;
	$update=$db->query("UPDATE `suggestions` SET `likes`=$new WHERE `id`=$id");
	if($update==true){
		$query2=$db->query("SELECT * FROM suggestions WHERE `id`=$id");
		while($row2=$query2->fetch()){
			echo $row2[5];
			}	
		}
	}
}else{
	$deleteFromLikes=$db->query("DELETE FROM `suggestion_likes` WHERE `suggestion_id`=$id AND `liked_by`='$user'");
	$query=$db->query("SELECT * FROM suggestions WHERE `id`=$id");
	while($row=$query->fetch()){
	$new=$row[5]-1;
	$update=$db->query("UPDATE `suggestions` SET `likes`=$new WHERE `id`=$id");
	if($update==true){
		$query2=$db->query("SELECT * FROM suggestions WHERE `id`=$id");
		while($row2=$query2->fetch()){
			echo $row2[5];
		}
	}
 }
}









?>