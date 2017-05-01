<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
<h1>New Staff addition</h1>
<form method="POST" action="admin/newstaff.php">
	<input type="text" name="lec_id" placeholder="ID" required><br><br>
	<input type="text" name="lec_name" placeholder="Name" required><br><br>
	<select name="department">
		<?php
		$connect=new PDO("mysql:host=localhost;dbname=fine","root","");
		$query=$connect->query("SELECT `name` FROM departments");
		$result=$query->fetchAll();
		foreach ($result as $department){
			echo "<option>$department[0]</option>";
		}
		?>
	</select><br><br>
	<input type="text" name="contact" placeholder="Contact" required><br><br>
	<input type="text" name="email" placeholder="Email" required><br><br>
	<input type="password" name="pass" value="welcome" readonly><br><br>
	<input type="submit" name="submit_lec" value="ADD"><br><br>
</form>
</body>
</html>
<?php
if(isset($_POST['submit_lec'])){
	$lec_id=$_POST['lec_id'];
	$lec_name=$_POST['lec_name'];
	$department=$_POST['department'];
	$contact=$_POST['contact'];
	$email=$_POST['email'];
	$pass=$_POST['pass'];
	//Securing the password before storing in the database
	$salt1="#$%^&";
	$salt2="_)(*";
	$secured=hash("ripemd128","$salt1$pass$salt2");
	$db=new PDO("mysql:host=localhost;dbname=fine","root","");
	$insert=$db->query("INSERT INTO `lecturers` (`lec_id`, `lec_name`, `department`, `contact`, `email`, `password`) VALUES ('$lec_id', '$lec_name', '$department', $contact, '$email', '$secured')");
	if($insert==true){
		echo "<p style='color:green;'>Data inserted successfully. Please inform the user to use <b style='color: black'>welcome</b> as the initial password</p>";
		header("Location: http://localhost/final/admin.php");
	}

}
?>