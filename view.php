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
    if($forum=="list"){
        require "system/newdb.php";
        $db=new newdb();
        $sql="SELECT * FROM forums";
        $result=$db->get($sql);
        $output="";
        while($row=$result->fetch(PDO::FETCH_NAMED)){
            $output.="<a href='view.php?forums=id&id=".$row['Forum_ID']."'>".$row['Topic']."</a><br>";
        }
        echo $output;
    }
    if($forum=="id"){
        require "system/newdb.php";
        $db=new newdb();
        $id=$_GET['id'];
        echo "<b>".$id."</b><br><hr>";
        $posts="";
        $sql="SELECT * from posts WHERE Forum_ID='$id' AND Flag='0'";
        $result=$db->get($sql);
        $posts=$result->fetchAll(PDO::FETCH_NAMED);
        foreach ($posts as $post){
            echo "<div>
                <p>".$post['PostContent']."</p>
                <p><blockquote>".$post['PostBy']." at <small><i>".$post['TimeStamp']."</i></small></blockquote></p>
                <small><a href='functions/constructor.php?report=1&cat=post&id=".$post['ID']."'>Report post</a></small>
            </div><hr>";
        }
        ?>
        <form method="post" action="functions/constructor.php">
            <input name="forumid" value="<?php echo $id;?>" hidden>
            <input name="by" placeholder="Name" type="text" autofocus="autofocus"><br>
            <input name="comment" placeholder="comment" type="text"><br>
            <input type="submit" name="post" value="Post">
        </form>
        <?php
    }
}
if(isset($_GET['attendance'])){
    require "system/newdb.php";
    $db=new newdb();
    $id=$_GET['attendance'];
    $sql="SELECT * FROM fms.attendance WHERE Att_ID='$id'";
    $result=$db->get($sql)->fetch(PDO::FETCH_NAMED);
    ?>
    <title>Fill Attendance</title>
    <div>
        <h3><?php echo $result['Att_ID'];?></h3>
        <?php
            $attended=$result['Attendance'];
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
        <input type="text" value="<?php echo $result['Att_ID'];?>" hidden name="id">
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
        $sql = "SELECT * FROM fms.organizations";
        try{
            $result=$db->get($sql)->fetchAll(PDO::FETCH_NAMED);
            foreach ($result as $org){
                echo "
                <div>
                    <h2><a href='view.php?organisation&id=".$org['ID']."'>".$org['name']."</a></h2><br>
                    <small><small><i>".$org['slogan']."</i></small></small>
                    <p>".$org['description']."</p>
                </div>
                ";
            }
        }catch (DBException $e){
            echo $e;
        }
    }
    if(isset($_GET['id'])){
        $id=$_GET['id'];
        $sql="SELECT * FROM fms.organizations WHERE ID='$id'";
        try{
            $result=$db->get($sql)->fetchAll(PDO::FETCH_NAMED);
            echo "
            <div>
                <h2></h2>
                <div style='width:70%;'></div>
            </div>
            ";
        }catch (DBException $e){
            echo $e;
        }
    }
}
if(isset($_GET['courses'])){
    if(isset($_GET['list'])){
        $sql="SELECT * FROM fms.courses";
        include "system/newdb.php";
        $db=new newdb();
        try {
            $result = $db->get($sql)->fetchAll(PDO::FETCH_NAMED);
            foreach ($result as $item){
                echo $item['CourseCode'].":".$item['CourseName']."<br>";
            }
        }catch (DBException $e){
        }
    }
}