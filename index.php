<!DOCTYPE html>
<html>
<head>
    <title>FMS</title>
    <link rel="stylesheet" type="text/css" href="index.css">
    <script type="text/javascript" src="index.js"></script>
</head>
<body>
<div id="header">
    <b id="time"></b>
    <h1>FACULTY MANAGEMENT SYSTEM</h1>
    <a href="student/" style="left: 46%">Student Portal</a>
    <a href="staff/" style="left: 57%">Staff Portal</a>
    <a href="forums/" style="left: 66.5%">Forums</a>
    <a href="ils/" style="left: 74%">Integrated Learning System</a>
    <a href="resources/" style="left: 93%">Resources</a>
</div>
<div id="right_nav">
    <div id="events"><a href="">Events</a></div>
    <div id="news"><a href="">News</a></div>
</div>
<div id="photos">
    <div id="next" onclick="slide()"><strong>&#10095;</strong></div>
    <img id="image">
    <div id="back" onclick="slide()"><strong>&#10094;</strong></div>
</div>
<div id="stories"></div>
<div id="footer"></div>
</body>
<script type="text/javascript">
    function slide() {
        images("1588374.jpg", "40f5a7f63-1.jpg", "74d372ba0-1.jpg", "85a1bf7ab-1.jpg", "vlcsnap-2017-03-26-22h29m33s954.png");
    }
    setInterval(slide, 15000);
</script>
</html>