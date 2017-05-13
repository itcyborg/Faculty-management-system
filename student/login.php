<?php
session_start();
if (isset($_SESSION['userid']) && isset($_SESSION['password'])) {
    header("Location: index.php");
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" type="text/css" href="index.css">
    <script type="text/javascript" src="index.js"></script>
    <script type="text/javascript">
        setInterval(changebackground, 5000);
        function changebackground() {
            var red = Math.ceil(Math.random() * 255);
            var green = Math.ceil(Math.random() * 255);
            var blue = Math.ceil(Math.random() * 255);
            var hue = Math.ceil(Math.random() * 255);
            document.getElementById('logindiv').setAttribute("style", "border: 6px rgba(" + red + "," + green + "," + blue + "," + hue + ") solid");
            //for background
            var black = Math.ceil(Math.random() * 5);
            var black1 = Math.ceil(Math.random() * 5);
            var black2 = Math.ceil(Math.random() * 10);
            document.body.setAttribute("style", "background:rgb(" + black + "," + black1 + "," + black2 + ")");
        }
        navigator.geolocation.getCurrentPosition(function (pos) {
            alert(pos.coords.lattitude);
        });
    </script>
    <noscript>
        Please turn on JavaScript to continue...Or upgrade your browser to either Ms Edge, Internet Explorer 11,Firefox
        Mozilla,Google Chrome or Safari
    </noscript>
</head>
<body>
<div id="time"></div>
<form id="logindiv">
    <label for="username" id="usernamelab">Username:</label>
    <input type="text" id="username" autofocus><br><br>
    <label for="pass" id="passlab">Password:</label>
    <input type="password" id="pass">
    <input type="reset" id="reset">
    <input type="button" id="loginbut" name="loginbut"
           onclick="setupuser(document.getElementById('username').value,document.getElementById('pass').value,document.getElementById('errordiv'))"
           value="Login">
    <div id="errordiv"></div>
</form>
</body>
</html>