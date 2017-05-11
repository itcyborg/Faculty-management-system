<?php
$suggestion_id=$_POST['suggestion_id'];
$comment=$_POST['comment'];
$db=new PDO("mysql:host=localhost;dbname=fine","root","");
if(!empty($comment)){
	$insert=$db->query("INSERT INTO `comments`(`suggestion_id`,`commentor`,`comment`,`time`) VALUES('$suggestion_id',null,'$comment',NOW())");
	if($isnert==true){
		echo "Comment posted successfully";
	}
}
?>