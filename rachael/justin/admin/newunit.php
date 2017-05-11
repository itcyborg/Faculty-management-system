<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
<h1>Add a new unit</h1>
<form method="POST" action="admin/newunit.php">
	<input type="text" name="course_id" placeholder="course_id"><br><br>
	<input type="text" name="name" placeholder="name"><br><br>
	<input type="text" name="id" placeholder="id"><br><br>
	<input type="text" name="department_id" placeholder="Dept id"><br><br>
	<input type="submit" name="submit_unit"><br><br>
</form>
</body>
</html>
<?php
if(isset($_POST['submit_unit'])){
	$course_id=$_POST['course_id'];
	$name=$_POST['name'];
	$id=$_POST['id'];
	$department_id=$_POST['department_id'];
	$db=new PDO("mysql:host=localhost;dbname=fine","root","");
	$insert=$db->query("INSERT INTO `units` (`course_id`, `name`, `id`, `department_id`, `time`) VALUES ($course_id, '$name', null, $department_id, NOW());");
	if($insert==true){
		echo "<p style='color:green;'>Unit added successfully</p>";
	}
}
?>