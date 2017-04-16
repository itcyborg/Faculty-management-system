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

require "system/db.php";
$db=new db();

$client_agent=$_SERVER['HTTP_USER_AGENT'];
$sql="INSERT INTO fms.guests(IP_Address, Client_agent) VALUES ('$ip','$client_agent')";
try{
    $db->putRecord($sql);
}catch (dbException $e){

}
$output="";
    if(isset($_POST['search'])){
        require "api/api.php";
        $wiki=new api();
        try{
            $wiki_result=$wiki->wiki($_POST['query']);
        }catch (apiException $e){
            die($e);
        }
        foreach ($wiki_result->query->search as $key=>$value) {
            $output.= "<h3><a href='http://en.wikipedia.org/wiki/".$value->title."' target='_blank'>".$value->title."</a></h3>";
            $output.= "<small><i>Source: wikipedia</i></small><br>";
            $output.=$value->snippet."<br>";

        }
        $search_string=trim($_POST['query']);
        $remove=array("if","in","at","this","an","then","at");
        $searchterms=explode(" ",$search_string);
        $safe_search=array();
        $resource_construct="";
        $forum_construct="";

        $x=0;
        foreach ($searchterms as $value) {
            $x++;
            if (!in_array($value, $remove)) {
                $safe_search[] = $value;
                if($x==1){
                    $resource_construct.="Name like '%$value%' || ResourceID like '%$value%' ";
                    $forum_construct.="Topic like '%$value%' ";
                }else{
                    $resource_construct.="and Name like '%$value%' || ResourceID like '%$value%' ";
                    $forum_construct.="and Topic like '%$value%' ";
                }
            }
        }

        try{
            $sql="INSERT INTO fms.search_history (Keyword,IP_address) VALUES ('".$search_string."','".$ip."')";
            $db->putRecord($sql);
            $resource_result=$db->getRecord("SELECT * FROM resources WHERE ".$resource_construct);
            $forum_reply=$db->getRecord("SELECT * FROM forums WHERE ".$forum_construct);
            var_dump($resource_result->fetch_all());
            echo "<br>";
            var_dump($forum_reply->fetch_all());
            echo "<br>";
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
    Add Courses<br>
    <form action="functions/constructor.php" method="post">
        <input type="text" name="code" placeholder="Course Code"><br>
        <input type="text" name="name"><br>
        <input type="text" name="department"><br>
        <input type="submit" name="addcourse" value="Submit">
    </form>
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
</body>
</html>