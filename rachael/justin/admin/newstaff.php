<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
<style type="text/css">
	#lec_id{
		left: 15%;
	}
	#lec_name{
		left: 15%;
		top: 30%;
	}
	#department{
		left: 15%;
		top: 60%;
	}
	#contact{
		top: 0%;
		left: 80%;
	}
	#email{
		top: 0%;
		left: 80%;
		top: 30%;
	}
	#pass{
		top: 0%;
		left: 80%;
		top: 60%;
	}
	#id{

	}
	#name{
		top: 30%;
	}
	#dept{
		top: 60%;
	}
	#cont{
		top: 0%;
		left: 60%;
	}
	#mail{
		top: 30%;
		left: 60%;
	}
	#password{
		top: 60%;
		left: 60%;
	}
	#submit{
		background: blue;
		left: 47%;
		width: 30%;
		height: 20%;
		color: white;
	}
</style>
<h1>New Staff addition</h1>
<form method="POST" action="admin/newstaff.php">
	<label for="lec_id" id="id">Lecturer ID:</label>
	<input type="text" id="lec_id" name="lec_id" placeholder="12345678" required autocomplete="off"><br><br>
	<label for="lec_name" id="name">Name:</label>
	<input type="text" id="lec_name" name="lec_name" placeholder="Firstname Secondname" required autocomplete="off"><br><br>
	<label for="department" id="dept">Department:</label>
	<select id="department" name="department">
		<?php
		$connect=new PDO("mysql:host=localhost;dbname=fine","root","");
		$query=$connect->query("SELECT `name` FROM departments");
		$result=$query->fetchAll();
		foreach ($result as $department){
			echo "<option>$department[0]</option>";
		}
		?>
	</select><br><br>
	<label for="contact" id="cont">Contact:</label>
	<input type="text" id="contact" name="contact" placeholder="07xxxxxxxx" required autocomplete="off"><br><br>
	<label for="email" id="mail">Email Address:</label>
	<input type="email" id="email" name="email" placeholder="you@example.com" required autocomplete="off"><br><br>
	<label for="pass" id="password">Password:</label>
	<input type="password" id="pass" name="pass" value="welcome" readonly><br><br>
	<input type="submit" name="submit_lec" id="submit" value="ADD"><br><br>
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