<?php
/**
 * Created by PhpStorm.
 * User: itcyb
 * Date: 4/16/2017
 * Time: 6:25 PM
 */
@session_start();
if(isset($_GET['forums'])){
    $forum=$_GET['forums'];
    require "system/newdb.php";
    $db=new newdb();
    $sql="SELECT * FROM forums WHERE Flag='0'";
    $result=$db->get($sql);
    $output="";
    if($result->rowCount()>0) {
        while ($row = $result->fetch(PDO::FETCH_NAMED)) {
            $output .= "<a href='view.php?forums=id&id=" . $row['Forum_ID'] . "'>" . $row['Topic'] . "</a>
                   <small><i><a href='report.php?forum&id=" . $row['Forum_ID'] . "'>Report</a></i></small><br>";
        }
    }else{
        $output= "No forums found";
    }

    if($forum=="id"){
        $id=$_GET['id'];
        $output= "<b>".$id."</b><br><hr>";
        $posts="";
        $sql="SELECT * from posts WHERE Forum_ID='$id' AND Flag='0'";
        $result=$db->get($sql);
        $posts=$result->fetchAll(PDO::FETCH_OBJ);
        foreach ($posts as $post){
            $output.= "<div>
                <p>".$post->PostContent."</p>
                <p><blockquote>".$post->PostBy." at <small><i>".$post->TimeStamp."</i></small></blockquote></p>
                <small><a href='functions/constructor.php?report=1&cat=post&id=".$post->ID."'>Report post</a></small>
            </div><hr>";
        }
        $output.="
        <form method=\"post\" action=\"functions/constructor.php\">
            <input name=\"forumid\" value=\"$id\" hidden>
            <input name=\"by\" placeholder=\"Name\" type=\"text\" autofocus=\"autofocus\"><br>
            <input name=\"comment\" placeholder=\"comment\" type=\"text\"><br>
            <input type=\"submit\" name=\"post\" value=\"Post\">
        </form>";
    }
    echo $output;
}
if(isset($_GET['attendance'])){
    require "system/newdb.php";
    $db=new newdb();
    $id=$_GET['attendance'];
    $sql="SELECT * FROM attendance WHERE Att_ID='$id'";
    $result=$db->get($sql)->fetch(PDO::FETCH_OBJ);
    ?>
    <title>Fill Attendance</title>
    <div>
        <h3><?php echo $result->Att_ID;?></h3>
        <?php
            $attended=$result->Attendance;
            $att=explode(",",$attended);
            foreach ($att as $key){
                echo "$key<br>";
            }
        ?>
    </div>
    <form action="functions/constructor.php" method="post">
        <?php
            if(isset($_SESSION['status'])){
                echo "success<br>";
                session_destroy();
            }
        ?>
        <input type="text" value="<?php echo $result->Att_ID;?>" hidden name="id">
        <input type="text" name="regno" placeholder="Registration number"><br><br>
        <input type="password" name="pass" placeholder="Password"><br><br>
        <input type="submit" name="attendancefill" value="Fill Attendance">
    </form>
    <?php
}
if(isset($_GET['organisation'])){
    require "system/newdb.php";
    $db=new newdb();
    if(isset($_GET['list'])) {
        $sql = "SELECT * FROM organizations";
        try{
            $result=$db->get($sql)->fetchAll(PDO::FETCH_OBJ);
            foreach ($result as $org){
                echo "
                <div>
                    <h2><a href='view.php?organisation&id=".$org->ID."'>".$org->name."</a></h2><br>
                    <small><small><i>".$org->slogan."</i></small></small>
                    <p>".$org->description."</p>
                </div>
                ";
            }
        }catch (DBException $e){
            echo $e;
        }
    }
    if(isset($_GET['id'])){
        $id=str_replace("-"," ",$_GET['id']);
        $sql="SELECT * FROM studentorgs WHERE name='$id'";
        try{
            $result=$db->get($sql)->fetchAll(PDO::FETCH_OBJ);
            $result=$result[0];
            echo "
            <div>
                <h2></h2>
                <div style='width:70%;'>
                    <h3>".$result->name."</h3>
                    <p>".$result->description."</p>
                </div>
            </div>
            ";
        }catch (DBException $e){
            echo $e;
        }
    }
}
if(isset($_GET['courses'])){
    if(isset($_GET['list'])){
        $sql="SELECT * FROM courses";
        include "system/newdb.php";
        $db=new newdb();
        try {
            $result = $db->get($sql)->fetchAll(PDO::FETCH_OBJ);
            foreach ($result as $item){
                echo $item->CourseCode.":".$item->CourseName."<br>";
            }
        }catch (DBException $e){
        }
    }
}
if(isset($_GET['resources'])){
    require "system/newdb.php";
    $db=new newdb();
    if(isset($_GET['id'])){
        $id=$_GET['id'];
        $sql="SELECT * FROM resources WHERE ResourceID='$id'";
        $result=$db->get($sql);
        $rs=$result->fetchAll(PDO::FETCH_OBJ);
        foreach ($rs as $r) {
            $link=substr($r->URL,0);
            $desc=$r->Description;
            echo "<a href='$link'>".$r->Name."</a><br><p>$desc</p>";
        }
    }else{
        $sql="SELECT * FROM resources";
        $result=$db->get($sql);
        $rs=$result->fetchAll(PDO::FETCH_OBJ);
        foreach ($rs as $r) {
            $link=substr($r->ResourceID,0);
            echo "<a href='resources/$link'>".$r->Name."</a><br>";
        }
    }
}