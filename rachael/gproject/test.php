<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<form method="POST" action="test.php">
		<input type="file" name="filename">
		<input type="submit">
	</form>
</body>
</html>
<?php
if(isset($_POST['submit'])){
	$photo=$_FILES['image']['tmp_name'];
	$newimage=$_FILES['image']['name'];
	$store=move_uploaded_file($newimage, "/");
	echo $store;
}
?>