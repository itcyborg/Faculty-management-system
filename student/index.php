<?php
require("functions.php");
if (!isset($_SESSION['userid'])) {
    header("Location: login.php");
}
?>
    <!DOCTYPE html>
    <html>
    <head>
        <title>Student Portal</title>
        <link rel="stylesheet" type="text/css" href="index.css">
        <script type="text/javascript" src="index.js"></script>
        <script type="text/javascript">

        </script>
    </head>
    <body>
    <div id="header">
        <div id="picture"><?php echo $_SESSION['picture']; ?></div>
        <input type="text" id="search" placeholder="Search here..." onkeyup="search(this.value)">
        <div id="search_sugg"></div>
        <ol>
            <li>Account
                <ul>
                    <li onclick="info('profile_pic')">Change profile picture</li>
                    <li>Settings</li>
                    <li name="logout" onclick="logout()">Logout</li>
                </ul>
            </li>
        </ol>
    </div>
    <div id="nav">
        <ol>
            <li onclick="info('personal_info')" id="personal_info">Personal Information</li>
            <li onclick="info('results')" id="results">Examination Results</li>
            <li onclick="info('ils')" id="ils">Learning System</li>
            <li onclick="info('orgs')" id="orgs">Organisations</li>
            <li onclick="info('forums')" id="forums">Forums</li>
            <li onclick="info('suggestions')" id="suggestions">Suggestions</li>
            <li onclick="info('candidature')" id="candidature">Request Candidature</li>
            <li onclick="info('voting')" id="vote">Vote</li>
            <li onclick="info('problem')" id="problem">Report Problem</li>
        </ol>
    </div>
    <div id="content">
        <div id="background"><img src="vlcsnap-2017-03-26-22h29m33s954.png" width="95%"></div>
    </div>
    <div id="footer">
    </div>
    </body>
    </html>
<?php
if (isset($_POST['upload'])) {
    if ($_FILES) {
        $db = new PDO("mysql:host=localhost;dbname=fine", "root", "");
        $imageName = $_FILES['filename']['name'];
        $directory = "profile_pictures/";
        move_uploaded_file($_FILES['filename']['tmp_name'], $directory . $imageName);
        $url = $directory . $imageName;
        $username = $_SESSION['userid'];
        $insert = $db->query("UPDATE `students` SET `pic_url`='$url' WHERE `adm_number`='$username'");
    }
}
?>