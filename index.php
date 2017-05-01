<?php
/**
 * Created by PhpStorm.
 * User: itcyb
 * Date: 4/14/2017
 * Time: 8:34 PM
 */

/**
 * capture guests
 */
if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
    $ip = $_SERVER['HTTP_CLIENT_IP'];
} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
} else {
    $ip = $_SERVER['REMOTE_ADDR'];
}

require "api/search.php";
$db=new newdb();

$client_agent=$_SERVER['HTTP_USER_AGENT'];
$sql="INSERT INTO guests(IP_Address, Client_agent) VALUES ('$ip','$client_agent')";
try{
    $db->put($sql);
}catch (dbException $e){

}
$output="";
    if(isset($_POST['search'])){
        $output="";
        $searchb=new search();
        $search=$_POST['query'];
        $result=$searchb->all($search);
        foreach ($result as $key=>$value) {
            $output.= "<h3><a href='$value->link' target='_blank'>".$value->title."</a></h3>";
            $output.= "<small><i>Source: $value->source</i></small><br>";
            $output.=$value->snippet."<br>";
        }

        try{
            $sql="INSERT INTO search_history (Keyword,IP_address) VALUES ('".$search."','".$ip."')";
            $db->put($sql);
        }catch (dbException $e){
            die($e);
        }
    }
?>

<!DOCTYPE html>
<html>
<head>
    <title>Faculty management system</title>
</head>
<body>
<style>
    input,textarea,select{
        margin:10px;
    }
</style>
    Add Courses<br>
    <form action="functions/constructor.php" method="post">
        <input type="text" name="code" placeholder="Course Code"><br>
        <input type="text" name="name" placeholder="Course Name"><br>
        <input type="text" name="department" placeholder="Department"><br>
        <input type="submit" name="addcourse" value="Submit">
    </form>
    <h4>View courses</h4>
    <a href="view.php?courses&list">All courses</a>
    <hr>
    <h3>Search</h3>
    <form action="index.php" method="post">
        <input type="search" name="query" placeholder="Search"><br>
        <input type="submit" name="search" value="Search">
    </form>
    <bR>
    <?php echo $output;?>
    <hr>
    <h3>Add Forum</h3>
    <form action="functions/constructor.php" method="post">
        <input type="text" name="topic" placeholder="Topic"><br>
        <input type="submit" name="forum" value="Create Forum">
    </form>
    <h3>Forums</h3>
    <div>
        <a href="view.php?forums=list">List Forums</a>
    </div>
    <h3>Attendance</h3>
    <form method="post" action="functions/constructor.php">
        <input type="text" name="deptid" placeholder="dept_id"><br>
        <input type="text" name="course" placeholder="courde Id"><br>
        <input type="text" name="lecid" placeholder="Lecturer ID"><br>
        <input type="submit" name="addattendance" value="Add Attendance">
    </form>

    <h4>Fill attendance</h4>
    <?php
    $sql="SELECT * FROM attendance";
    $result=$db->get($sql);
    $result=$result->fetchAll(PDO::FETCH_NAMED);
    foreach ($result as $value){
        echo "<a href='view.php?attendance=".$value["Att_ID"]."'>".$value["Att_ID"]."</a><br>";
    }
    ?>
    <hr>
    <h3>Add Resources</h3>
    <form method="post" action="functions/constructor.php" enctype="multipart/form-data">
        <input type="text" name="deptid" placeholder="Department ID"><br>
        <select name="type">
            <option value="document">Document</option>
            <option value="video">Video</option>
            <option value="other">Other</option>
        </select><br>
        <input type="text" name="name" placeholder="Name"><br>
        <input type="text" name="level" placeholder="Level"><br>
        <input type="text" name="uploadedby" placeholder="Uploaded by"><br>
        <textarea name="description" placeholder="Description"></textarea><br>
        <input type="file" name="file"><br>
        <input type="submit" value="Add Resource" name="addresource">
    </form>
    <br>
    <a href="resources">View all resources</a>
    <hr>
    <div>
        <h3>Add organisation</h3>
        <form action="functions/constructor.php" method="post">
            <input name="name" placeholder="Name" type="text"><br>
            <input name="type" placeholder="Type" type="text"><br>
            <input name="target" placeholder="Target" type="text"><br>
            <input name="slogan" placeholder="Slogan" type="text"><br>
            <input name="description" placeholder="Description" type="text"><br>
            <input name="leader" placeholder="Leader" type="text"><br>
            <input type="submit" name="addorganisation">
        </form>
    </div>
</body>
</html>