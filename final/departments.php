<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<div id="departments">
		<?php
		$db=new PDO("mysql:host=localhost;dbname=fine","root","");
		$query=$db->query("SELECT * FROM departments");
		$result=$query->fetchAll();
		foreach($result as $value){
			echo "<b>$value[1]</b>","<br>";
			echo "Head:","\t","<i>$value[2]</i>","<br>";
		}
		?>
	</div>

</body>
</html>