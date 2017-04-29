<?php 
$id=$_POST['suggestion_id'];
try{
	$db=new PDO("mysql:host=localhost;dbname=fine","root","");
	$query=$db->query("SELECT * FROM comments WHERE `suggestion_id`=$id");
	$result=$query->fetchAll();
	if($result==true){
		foreach ($result as $value) {
		echo $value['comment'],"<br>";
		}
	}
}catch(PDOException $e){
	echo "Error fetching results";
}

?>