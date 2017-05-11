<?php
	session_start();
	if(!isset($_SESSION['username'])){
		header("Location: index.php");
	}
?>
<html>
<title>Main</title>
<frameset rows="10%,*">
	<frame>
	<frameset cols="20%,*">
		<frame name="frame2" src="view.php">
		<frame name="frame3">
	</frameset>
</frameset>
</html>