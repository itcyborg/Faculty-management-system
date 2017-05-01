<?php
$title=$_POST['title'];
$suggestion=$_POST['suggestion'];
$owner=$_POST['owner'];
$db=new PDO("mysql:host=localhost;dbname=fine","root","");
include("db.php");
$dbphp=new Connect;
$insert=$db->query("INSERT INTO `suggestions`(`title`,`suggestion`,`owner`,`time`,`likes`)VALUES('$title','$suggestion','$owner',NOW(),0)");
if($insert==true){
	echo "<b style='color:blue'>Suggestion posted successfully!!</b>";
}
?>