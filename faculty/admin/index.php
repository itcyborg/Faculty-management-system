<?php
/**
 * Created by PhpStorm.
 * User: itcyb
 * Date: 5/3/2017
 * Time: 9:24 AM
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin</title>
    <link rel="stylesheet" href="../assets/css/admin.css">
</head>
<body>
<div class="wrapper">
    <div class="sidebar">
        <div class="logo"></div>
        <div class="navigation">
            <ul>
                <li><a href="index.php" class="active">Home</a></li>
                <li><a href="#lecturers" id="lecturers" onclick="getPage('constructor.php','lecturers','main')">Lecturers</a>
                </li>
                <li><a href="#forums" id="forums" onclick="getPage('constructor.php','forums','main')">Forums</a></li>
                <li><a href="#attendance" id="attendance" onclick="getPage('constructor.php','attendance','main')">Attendance</a>
                </li>
                <li><a href="#organisations" id="organisations"
                       onclick="getPage('constructor.php','organisations','main')">Organisations</a></li>
                <li><a href="#courses" id="courses" onclick="getPage('constructor.php','courses','main')">Courses</a>
                </li>
                <li><a href="#resources" id="resources" onclick="getPage('constructor.php','resources','main')">Resources</a>
                </li>
                <li><a href="#timetable" id="timetable" onclick="getPage('constructor.php','timetable','main')">Timetable</a>
                </li>
                <li><a href="#logs" id="logs" onclick="getPage('constructor.php','logs','main')">logs</a></li>
            </ul>
        </div>
    </div>
    <div class="container">
        <div class="notification">
            <div class="searchbar">
                <form name="search" id="search_form">
                    <input type="search" id="search" placeholder="Search">
                    <button class="btn btn-primary" id="searchbtn">Search</button>
                </form>
            </div>
            <div class="userbar">
                <a href="">Logout</a>
            </div>
        </div>
        <div class="content" id="content">
            <div class="status" id="status"></div>
            <div class="main" id="main"></div>
        </div>
    </div>
</div>
<script type="text/javascript" src="../assets/js/jquery.js"></script>
<script type="text/javascript" src="../assets/js/admin.js"></script>
<script type="text/javascript">
    $("#search_form").submit(function (e) {
        e.preventDefault();
        var search = $('#search').val().trim();
        $.ajax({
            url: '../functions/constructor.php',
            data: {
                'term': search,
                'search': 1
            },
            type: 'POST',
            beforeSend: function () {
                $('#main').html("Searching...");
            },
            success: function (data) {
                $('#main').html(data);
            }
        });
    });
</script>
</body>
</html>
