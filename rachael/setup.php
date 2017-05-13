<?php
$db = new PDO("mysql:host=localhost;dbname=fine", "root", "");
$username = $_POST['username'];
$password = $_POST['password'];
$salt1 = "#$%^&";
$salt2 = "_)(*";
$realpassword = hash("ripemd128", "$salt1$password$salt2");
$query = $db->query("SELECT * FROM students WHERE `adm_number`='$username'");
$result = $query->fetch();
if ($result['password'] == $realpassword) {
    session_start();
    $_SESSION['userid'] = $result['adm_number'];
    $_SESSION['name'] = $result['name'];
    $_SESSION['year'] = $result['year'];
    $_SESSION['course'] = $result['course'];
    $_SESSION['contact'] = $result['contact'];
    $_SESSION['email'] = $result['email'];
    $_SESSION['password'] = $result['password'];
    if ($result['pic_url'] != "") {
        $image = $result['pic_url'];
        $_SESSION['picture'] = "<img src='$image' width='20%'>";
    } else {
        $_SESSION['picture'] = "Your Avatar";
    }
    if ($password == "welcome") {
        echo "Change";
    } else {
        echo "True";
    }
} else {
    echo "Invalid username or password";
}
?>