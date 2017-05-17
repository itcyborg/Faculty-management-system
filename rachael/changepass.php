<!DOCTYPE html>
<html>
<head>
    <title>change password</title>
    <link rel="stylesheet" type="text/css" href="fms/index.css">
</head>
<body>
<form id="form" action="changepass.php" method="POST">
    <input name="new" type="text" placeholder="new password" required><br><br>
    <input name="confirm" type="password" placeholder="confirm password" required><br><br>
    <input type="submit" name="submit" placeholder="change password">
</form>

</body>
</html>

<?php
session_start();
if (isset($_POST['submit'])) {
    $new = $_POST['new'];
    $confirm = $_POST['confirm'];
    $salt1 = "#$%^&";
    $salt2 = "_)(*";
    $userid = $_SESSION['userid'];
    if ($new == $confirm) {
        $confirm = hash("ripemd128", "$salt1$confirm$salt2");
        $connect = new PDO("mysql:host=localhost;dbname=fine", "root", "");
        $query = $connect->query("UPDATE `students` SET `password`='$confirm' WHERE  `adm_number`='$userid'");
        header("Location: dashboard.php");
    } else {
        echo "change password not successful";
    }

}


?>