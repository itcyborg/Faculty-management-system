<?php
session_start();
if (!isset($_SESSION['idnumber'])) {
    header("Location: ../student/login.php");
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>FMS</title>
    <link rel="stylesheet" type="text/css" href="index.css">
    <script type="text/javascript" src="index.js"></script>
</head>
<body>
<div id="header">
</div>
<div id="nav">
    <ol>
        <li onclick="changeView('details')" id="details">My Details</li>
        <li onclick="changeView('payslip')" id="payslip">Payslip</li>
        <li onclick="changeView('units')" id="units">My Units</li>
        <li onclick="changeView('lectures')" id="lectures">My Lecture Time</li>
        <li onclick="changeView('results')" id="results">Student Results</li>
        <li onclick="changeView('resources')" id="resources">Send Learning Materials</li>
        <li onclick="changeView('settings')" id="settings">Account Settings</li>
    </ol>
</div>
<div id="display"></div>
<div id="footer"></div>
</body>
</html>