<!DOCTYPE html>
<html>
<head>
	<title></title>
	<script type="text/javascript" src="js.js"></script>
</head>
<body>
	<style type="text/css">
		#neworg{
			display: none;
		}
	</style>
	<button onclick="displayAnyHiddenDiv(document.getElementById('neworg'))">New</button>
	<div id="neworg">
	<form method="POST" action="organisations.php">
		<input type="text" name="name" placeholder="Name" required><br><br>
		<input type="text" name="type" placeholder="Type" required><br><br>
		<input type="text" name="target" placeholder="Target" required><br><br>
		<input type="text" name="slogan" placeholder="Slogan" required><br><br>
		<textarea rows="4%" cols="25%" name="description" placeholder="Description" required></textarea><br><br>
		<input type="text" name="leader" placeholder="Leader" value="<?php echo $_SESSION['name'];?>" readonly><br><br>
		<input type="submit" name="sub"><br><br>
	</form>
	</div>
	<div id="displayorg">
		<?php
		$db=new PDO("mysql:host=localhost;dbname=fine","root","");
		if(isset($_POST['sub'])){
			$name=$_POST['name'];
			$type=$_POST['type'];
			$target=$_POST['target'];
			$slogan=$_POST['slogan'];
			$description=$_POST['description'];
			$leader=$_SESSION['username'];
			if(!empty($name)||!empty($type)||!empty($target)||!empty($slogan)||!empty($description)||!empty($leader)){
				$insert=$db->query("INSERT INTO `organizations` (`id`, `name`, `type`, `target`, `slogan`, `description`, `leader`, `time`) VALUES (null, '$name', '$type', '$target', '$slogan', '$description', '$leader', NOW())");
				if($insert==true){
					echo "<p style='color:green;'>Organization created successfully</p>","<br>";
				}
			}
		}
		$query=$db->query("SELECT * FROM organizations");
		$result=$query->fetchAll();
		foreach($result as $value){
			echo "<b>$value[1]</b>","<br>";
			echo "Purpose:","\t","<i>$value[2]</i>";
			echo "<button>Join</button>","<br>";
		}
		?>
	</div>
</body>
</html>