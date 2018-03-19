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
    <div id="events">
        <ol>
            <li>Java programming competition...</li>
            <li>Web development advisory...</li>
            <li>Information security debate...</li>
            <li>Maseno got talent: Maseno University programming geeks...</li>
            <li>Google team visits...</li>
            <li>Programmer's fun day...</li>
            <li>Artificial Intellligence...</li>
            <li>Database systems:Learn with experts...</li>
            <li>Hardware design showcase...</li>
            <li>IT proffesionals visit...</li>
            <li>Automata vs DSA: which helps most...?</li>
            <li>Official launching of the faculty website...</li>
        </ol>
    </div>
    <div id="news"><a href="">News</a></div>
</div>
<div id="photos">
    <div id="next" onclick="slide()"><strong>&#10095;</strong></div>
    <img id="image" src="site_photos/photo1.jpg">
    <div id="back" onclick="slide()"><strong>&#10094;</strong></div>
</div>
<div id="stories">
    <h3>OUR MISSION</h3>
    <p>To be the best faculty by ensuring quality in what we produce.</p>
    <h3>OUR VISION</h3>
    <p>To hit the world best for production of quality graduates.</p>
    <h3>CORE VALUES</h3>
    <p>
    <ol>
        <li>Honesty</li>
        <li>Hardwork</li>
        <li>Accountability</li>
    </ol>
    </p>
    <h3>SERVICE CHARTER</h3>
    <p></p>
</div>
<div id="footer">
    <div id="ownership">
        <ol>
            <li><a href="#">Copyright Information</a></li>
            <li><a href="#">Disclaimer notice</a></li>
            <li><a href="#">Terms and Conditions</a></li>
        </ol>
    </div>
    <div id="partnership">
        <ol>
            <li><a href="#">Our partners</a></li>
            <li><a href="#">Our sponsors</a></li>
            <li><a href="#">Well wishers</a></li>
        </ol>
    </div>
    <div id="charities">
        <ol>
            <li><a href="#">Charity works</a></li>
            <li><a href="#">Contributions</a></li>
            <li><a href="#">Donations</a></li>
        </ol>
    </div>
    <div>
        <ol id="privacy">
            <li><a href="#">Help</a></li>
            <li><a href="#">Feedback</a></li>
            <li><a href="#">Privacy statement</a></li>
        </ol>
    </div>
</div>
</body>
<script type="text/javascript">
    function slide() {
        images("photo1.jpg", "photo2.jpg", "photo4.jpg", "photo7.jpg", "photo8.jpg", "photo9.jpg", "photo12.png", "photo15.jpg");
    }
    setInterval(slide, 3000);
</script>
</html>
