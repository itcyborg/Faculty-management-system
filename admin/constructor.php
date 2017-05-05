<?php
/**
 * Created by PhpStorm.
 * User: itcyb
 * Date: 5/3/2017
 * Time: 4:05 PM
 */

$page="";
$output="";
$id="";
if (isset($_POST['page']) && isset($_POST['id'])){
    $page=$_POST['page'];
    $id=$_POST['id'];
}elseif(isset($_POST['page'])){
    $page=$_POST['page'];
}


if($page==="forums"){
    require $_SERVER['DOCUMENT_ROOT']."/system/newdb.php";
    $db=new newdb();
    $sql="SELECT * FROM forums";
    $result=$db->get($sql);
    if($result->rowCount()>0) {
        while ($row = $result->fetch(PDO::FETCH_OBJ)) {
            $output .= "<a href='../view.php?forums=id&id=" . $row->Forum_ID . "' target='_#content'>" . $row->Topic . "</a>
                   <small><i><a href='../report.php?forum&id=" . $row->Forum_ID . "'>Report</a></i></small><br>";
        }
    }else{
        $output= "No forums found";
    }
    echo $output;
}
if($page=='attendance'){
    require $_SERVER['DOCUMENT_ROOT']."/system/newdb.php";
    $db=new newdb();
    $sql="SELECT * FROM attendance";
    $result=$db->get($sql)->fetchAll(PDO::FETCH_OBJ);
    echo "<h2>Attendance</h2>";
    $count=0;
    foreach ($result as $item) {
        $count++;
        echo $count.". <a href='#attendace#".$item->Att_ID."' onclick=\"getPages('constructor.php','attendaceid','main','$item->Att_ID')\">$item->Att_ID</a><br>";
    }
}
if($page=='attendaceid'){
    require_once $_SERVER['DOCUMENT_ROOT']."/system/newdb.php";
    $db=new newdb();
    echo "<h2>Fill Attendance :$id</h2>";
    $form="
    	<form id='attendanceform'>
    	    <input type='text' name='id' id='id' value='$id' hidden>
    	    <input type='text' name='regno' id='regno' placeholder='Reg No'><br>
    	    <button>Add</button>
    	</form>
    	<script type='text/javascript'>
        $(\"#attendanceform\").submit(function (f) {
            f.preventDefault();
            var id=$('#id').val();
            var regno=$('#regno').val();
            $.ajax({
                url :   '../functions/constructor.php',
                data:{
                    'attendancefill':1,
                    'regno':regno,
                    'id':id
                },
                type:   'POST',
                beforeSend:function(){
                },
                success:function(data){
                    getPages('constructor.php','attendaceid','main','$id');
                }
            });
        });</script>
    ";
    $sql="SELECT * FROM attendance WHERE Att_ID='$id'";
    $result=$db->get($sql)->fetch(PDO::FETCH_OBJ);
    $atts=$result->Attendance;
    $atts=explode(",",$atts);
    $attendance="";
    foreach ($atts as $att) {
        $attendance.="<p>$att</p>";
    }
    echo $attendance.$form;
}
if($page=='organisations'){
    echo "<a href='#addorganisation' onclick='getPage(\"constructor.php\",\"addorganisation\",\"main\")'>Add Organisation</a>";
    require $_SERVER['DOCUMENT_ROOT']."/system/newdb.php";
    $db=new newdb();
    $sql = "SELECT * FROM organizations";
    try{
        $result=$db->get($sql)->fetchAll(PDO::FETCH_OBJ);
        foreach ($result as $org){
            echo "
            <div>
                <h2><a href='#organisation".$org->ID."' onclick='getPages(\"constructor.php\",\"organisation\",\"main\",\"$org->name\")'>".$org->name."</a></h2><br>
                <small><small><i>".$org->slogan."</i></small></small>
                <p>".$org->description."</p>
            </div>
            ";
        }
    }catch (DBException $e){
        echo $e;
    }
}
if($page=='organisation') {
    require $_SERVER['DOCUMENT_ROOT']."/system/newdb.php";
    $db=new newdb();
    $id = str_replace("-", " ", $id);
    $sql = "SELECT * FROM studentorgs WHERE name='$id'";
    try {
        $result = $db->get($sql)->fetchAll(PDO::FETCH_OBJ);
        $result = $result[0];
        echo "
            <div>
                <h2></h2>
                <div>
                    <h3>" . $result->name . "</h3>
                    <p>" . $result->description . "</p>
                </div>
            </div>
            ";
    } catch (DBException $e) {
        echo $e;
    }
}
if($page=='addorganisation'){
    echo '
    <h3>Add organisation</h3>
        <form id="addorganisation_form">
            <input name="name" id="name" placeholder="Name" type="text"><br>
            <input name="type" id="type" placeholder="Type" type="text"><br>
            <input name="target" id="target" placeholder="Target" type="text"><br>
            <input name="slogan" id="slogan" placeholder="Slogan" type="text"><br>
            <input name="description" id="description" placeholder="Description" type="text"><br>
            <input name="leader" id="leader" placeholder="Leader" type="text"><br>
            <input type="submit" name="addorganisation">
        </form>
    	<script type=\'text/javascript\'>
        $(\'#addorganisation_form\').submit(function (g) {
            g.preventDefault();
            var name=$(\'#name\').val();
            var type=$(\'#type\').val();
            var target=$(\'#target\').val();
            var slogan=$(\'#slogan\').val();
            var description=$(\'#description\').val();
            var leader=$(\'#leader\').val();
            $.ajax({
                url :   \'../functions/constructor.php\',
                data:{
                    \'addorganisation\':1,
                    \'name\':name,
                    \'target\':target,
                    \'type\':type,
                    \'slogan\':slogan,
                    \'description\':description,
                    \'leader\':leader
                },
                type:   \'POST\',
                beforeSend:function(){
                },
                success:function(data){
                    alert(data);
                    getPage(\'constructor.php\',\'organisations\',\'main\');
                }
            });
        });</script>';
}
if($page=='courses'){
    $sql="SELECT * FROM courses";
    include $_SERVER['DOCUMENT_ROOT']."/system/newdb.php";
    $db=new newdb();
    try {
        $result = $db->get($sql)->fetchAll(PDO::FETCH_OBJ);
        if(sizeof($result)<1){
            echo "No courses found";
        }
        foreach ($result as $item){
            echo $item->CourseCode.":".$item->CourseName."<br>";
        }
    }catch (DBException $e){
    }
}
if($page=='resources'){
    require $_SERVER['DOCUMENT_ROOT']."/system/newdb.php";
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