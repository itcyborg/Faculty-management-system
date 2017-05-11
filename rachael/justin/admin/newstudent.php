<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" type="text/css" href="main.css">
</head>
<body>
<h1>Add new student</h1>
	<form  id="form"method="POST" action="admin/newstudent.php">
		<input type="text" name="adm_number" placeholder="adm_number"><br><br>
		<input type="text" name="name" placeholder="name"><br><br>
		<select name="year">
			<option>First Year</option>
			<option>Second Year</option>
			<option>Third Year</option>
			<option>Fourth Year</option>
			</select><br><br>
		<select name="school">
			<?php
			$connect=new PDO("mysql:host=localhost;dbname=fine","root","");
			$query=$connect->query("SELECT `school_name` FROM `schools`");
			$result=$query->fetchAll();
			foreach ($result as $school) {
				echo "<option>$school[0]</option>";
			}
			?>
		</select><br><br>
		<select name="course">
		<?php
		$connect=new PDO("mysql:host=localhost;dbname=fine","root","");
		$query=$connect->query("SELECT `CourseName` FROM courses");
		$result=$query->fetchAll();
		foreach ($result as $course){
			echo "<option>$course[0]</option>";
		}
		?>
		</select><br><br>
		<input type="text" name="contact" placeholder="contact"><br><br>
		<input type="text" name="email" placeholder="email"><br><br>
		<input type="password" name="pass" value="welcome" readonly><br><br><br>
		<input type="submit" name="submit_student"><br><br>
	</form>
</body>
</html>
<?php
if(isset($_POST['submit_student'])){
	$adm_number=$_POST['adm_number'];
	$name=$_POST['name'];
	$year=$_POST['year'];
	$course=$_POST['course'];
	$contact=$_POST['contact'];
	$email=$_POST['email'];
	$pass=$_POST['pass'];

	$salt1="#$%^&";
	$salt2="_)(*";
	$secured=hash("ripemd128","$salt1$pass$salt2");
	$db=new PDO("mysql:host=localhost;dbname=fine","root","");
	$insert=$db->query("INSERT INTO `students` (`adm_number`, `name`, `year`, `course`, `contact`, `email`, `password`) VALUES ('$adm_number', '$name', '$year', '$course', $contact, '$email', '$secured')");
	if($insert==true){
		echo "<p style='color:green;'>Data inserted successfully. Please inform the user to use <b style='color: black'>welcome</b> as the initial password</p>";
	}
}
?>