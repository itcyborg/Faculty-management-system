<?php
$username=$_POST['username'];
$pass=$_POST['pass'];
$salt1="#$%^&";
$salt2="_)(*";
$secured=hash("ripemd128","$salt1$pass$salt2");
if(isset($username) && isset($pass)){
	$db=new PDO("mysql:host=localhost;dbname=fine","root","");
	$query=$db->query("SELECT * FROM students WHERE `adm_number`='$username'");
	$result=$query->fetch();
	if($result==true && $result[6]==$pass){
		session_start();
		$_SESSION['username']=$result[0];
		$_SESSION['name']=$result[1];
		$_SESSION['year']=$result[2];
		$_SESSION['course']=$result[3];
		$_SESSION['contact']=$result[4];
		$_SESSION['email']=$result[5];
		echo "True";
	}else{
		echo "No user found with the provided information";
	}
}
?>