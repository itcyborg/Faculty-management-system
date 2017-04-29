<!DOCTYPE html>
<html>
<head>
	<title>Faculty Manager</title>
	<link rel="stylesheet" type="text/css" href="index.css">
	<script type="text/javascript" src="js.js"></script>
	<link rel="icon" type="image/x-icon" href="/favicon.ico">
</head>
<body>
	<div id="container">
		<h2>Log in</h2>
		<form method="POST">
			<label for="username">Username</label>
			<input type="text" id="username" name="username" autocomplete="off"><br><br>
			<label for="password">Password</label>
			<input type="password" id="pass" name="pass"><br><br>
			<input type="button" name="submit" value="Log In" onclick="login(document.getElementById('username').value,document.getElementById('pass').value,document.getElementById('response'))"><br>
		</form>
		<div id="response"></div>
	</div>
</body>
</html>