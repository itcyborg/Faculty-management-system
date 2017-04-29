<?php
	session_start();
	if(!isset($_SESSION['username'])){
		header("Location: index.php");
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<style type="text/css">
</style>
<body>
	<div id="result_header">
		<table>
			<tr>
				<td colspan="4" align="center">PROVISIONAL RESULTS</td>
			</tr>
			<tr>
				<td>Registration Number:</td>
				<td><?php echo $_SESSION['username']?></td>
				<td>Name:</td>
				<td><?php echo $_SESSION['name']?></td>
			</tr>
			<tr>
				<td>Year of Study:</td>
				<td><?php echo $_SESSION['year']?></td>
				<td>Academic Year:</td>
				<td>2016/2017</td>
			</tr>
			<tr>
				<td>Faculty:</td>
				<td>This school</td>
				<td>Degree:</td>
				<td>Not yet defined</td>
			</tr>
		</table>
	</div>
	<hr>
	<div id="result_body">
		<table>
			<tr>
				<th width="30%">Course code</th>
				<th width="40%">Course name</th>
				<th width="30%">Grade</th>
			</tr>
			<?php
			$db=new PDO("mysql:host=localhost;dbname=fine","root","");
			$identity=$_SESSION['username'];
			$query=$db->query("SELECT * FROM results WHERE `student_id`='$identity'");
			$result=$query->fetchAll();
			foreach($result as $value){
				echo "<tr>";
				echo "</tr>";
			}
			?>
			<tr>
				<td colspan="2">Average grade</td>
				<td></td>
			</tr>
		</table>
	</div>
	<hr>
	<div id="result_footer">
		<table>
			<tr>
				<td colspan="4">Legend:</td>
			</tr>
			<tr>
				<td colspan="2"></td>
				<td width="20%">70.00-100.00</td>
				<td>A</td>
			</tr>
			<tr>
				<td colspan="2"></td>
				<td>60.00-69.99</td>
				<td>B</td>
			</tr>
			<tr>
				<td colspan="2"></td>
				<td>50.00-59.99</td>
				<td>C</td>
			</tr>
			<tr>
				<td colspan="2"></td>
				<td>40.00-49.00</td>
				<td>D</td>
			</tr>
			<tr>
				<td colspan="2"></td>
				<td>0.00-39.99</td>
				<td>F</td>
			</tr>
		</table>
	</div>
</body>
</html>