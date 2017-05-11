<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
<h1>Add a new course</h1>
	<form method="POST" action="admin/newcourse.php">
		<label for="course_code">Course code:</label>
		<input type="text" name="course_code" autocomplete="off" required><br><br>
		<label for="name">Course name:</label>
		<input type="text" name="name" autocomplete="off" required><br><br>
		<label for="dept">Department:</label>
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
		<input type="submit" name="submit" value="SUBMIT">
	</form>
</body>
</html>
<?php
if(isset($_POST['submit'])){
	$course_code=$_POST['course_code'];
	$name=$_POST['name'];
	$dept=$_POST['dept'];
	$db=new PDO("mysql:host=localhost;dbname=fine","root","");
	$insert=$db->query("INSERT INTO `courses` (`ID`, `CourseCode`, `CourseName`, `TimeStamp`, `DepartmentID`) VALUES (null, '$course_code', '$name', NOW(), '$dept')");
	if ($insert==true) {
		echo "Information saved successfully";
	}
}
?>