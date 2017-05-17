<?php
$db = new PDO("mysql:host=localhost;dbname=fine", "root", "");
$username = $_POST['username'];
$password = $_POST['password'];
$query = $db->query("SELECT * FROM students WHERE adm_number='$username'");
$result = $query->fetch();
if ($result['password'] == $password) {
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
    echo "True";
} else {
    $query2 = $db->query("SELECT * FROM lecturers WHERE lec_id='$username'");
    $results = $query2->fetch();
    if ($results[1] != null && $results['password'] == $password) {
        session_start();
        $_SESSION['staffno'] = "";
        $_SESSION['idnumber'] = $results['lec_id'];
        $_SESSION['name'] = $results['lec_name'];
        $_SESSION['phone'] = $results['contact'];
        $_SESSION['email'] = $results['email'];
        $_SESSION['department'] = $results['department'];
        $_SESSION['service_type'] = "";
        $_SESSION['units'] = json_decode($results['units']);
        echo "Success";
    } else {
        echo "Invalid username or password";
    }
}
?>