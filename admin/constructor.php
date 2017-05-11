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
            $output .= "<a class='link' href='../view.php?forums=id&id=" . $row->Forum_ID . "' target='_#content'>" . $row->Topic . "</a>
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
    echo "<a href='#addresource' onclick=\"getPage('constructor.php','addresource','main')\">Add Resources</a><br><hr>";
    require $_SERVER['DOCUMENT_ROOT']."/system/newdb.php";
    $db=new newdb();
    $sql="SELECT * FROM resources";
    $result=$db->get($sql);
    $rs=$result->fetchAll(PDO::FETCH_OBJ);
    foreach ($rs as $r) {
        $link=substr($r->ResourceID,0);
        echo "<a href='#resources$link' onclick=\"getPages('constructor.php','resourcesid','main','$link')\">".$r->Name."</a><br>";
        echo "<p>$r->Description</p>";
    }
}
if($page=='resourcesid'){
    require $_SERVER['DOCUMENT_ROOT']."/system/newdb.php";
    $db=new newdb();
    $sql="SELECT * FROM resources WHERE ResourceID='$id'";
    $result=$db->get($sql);
    $rs=$result->fetchAll(PDO::FETCH_OBJ);
    foreach ($rs as $r) {
        $link=substr($r->URL,0);
        $desc=$r->Description;
        echo "<a href='$link'>".$r->Name."</a><br><p>$desc</p>";
    }
}
if($page=='addresource'){
    echo '
    <form id="addresourceform" method="post" action="functions/constructor.php" enctype="multipart/form-data">
        <input id="deptid" type="text" name="deptid" placeholder="Department ID"><br>
        <select name="type" id="type">
            <option value="document">Document</option>
            <option value="video">Video</option>
            <option value="other">Other</option>
        </select><br>
        <input type="text" name="name" id="name" placeholder="Name"><br>
        <input type="text" name="level" id="level" placeholder="Level"><br>
        <input type="text" name="uploadedby" id="uploadedby" placeholder="Uploaded by"><br>
        <textarea name="description" id="description" placeholder="Description"></textarea><br>
        <input type="file" name="file" id="file"><br>
        <input type="submit" value="Add Resource" name="addresource">
    </form>
    <script type=\'text/javascript\'>
        $(\'#addresourceform\').submit(function (h) {
            h.preventDefault();
            var name=$(\'#name\').val();
            var type=$(\'#type\').val();
            var deptid=$(\'#deptid\').val();
            var level=$(\'#level\').val();
            var description=$(\'#description\').val();
            var formdata=new FormData();
            var file=$(\'#file\').files;
            $.ajax({
                url :   \'../functions/constructor.php\',
                data:{
                    \'addresource\':1,
                    \'name\':name,
                    \'type\':type,
                    \'description\':description,
                    \'file\':file
                },
                type:   \'POST\',
                beforeSend:function(){
                },
                success:function(data){
                alert(data);
                    //getPage(\'constructor.php\',\'organisations\',\'main\');
                }
            });
        });</script>
    ';
}
if($page=='logs'){
    if(file_exists($_SERVER['DOCUMENT_ROOT']."/logs/access_logs.log")){
        echo "<a class='link' target='_blank' href='../logs/access_logs.log'>Access Logs</a><br>";
    }
    if(file_exists($_SERVER['DOCUMENT_ROOT']."/logs/error.log")){
        echo "<a class='link' target='_blank' href='../logs/error.log'>Error Logs</a><br>";
    }
    if(file_exists($_SERVER['DOCUMENT_ROOT']."/logs/search_logs.fcts")){
        echo "<a class='link' target='_blank' href='../logs/search_logs.fcts'>Search Logs</a><br>";
    }
    if(file_exists($_SERVER['DOCUMENT_ROOT']."/logs/searchError_logs.fct")){
        echo "<a class='link' target='_blank' href='../logs/searchError_logs.fct'>Search Error Logs</a><br>";
    }
}
if($page=="lecturers"){
    require $_SERVER['DOCUMENT_ROOT']."/system/newdb.php";
    $db=new newdb();
    echo "<a class='link' href='#addlecturers' onclick=\"getPage('constructor.php','addlecturers','main')\">Add Lecturers</a>";
}
if($page=='addlecturers'){
    $form='
        <form id="addlecturers">
            <input name="id" id="id" type="text" required placeholder="ID Number"><br>
            <input name="name" id="name" type="text" required placeholder="Lecturer Name"><br>
            <input name="dep" id="dep" type="text" required placeholder="Department"><br>
            <input name="contact" id="contact" type="number" required placeholder="Phone Number"><br>
            <input name="email" id="email" type="text" required placeholder="Email"><br><br>
            <input name="password" id="password" type="password" required placeholder="Password"><br>
            <button type="submit" value="register" name="register">register</button>
        </form>';
    $script="
        <script>
            $('#addlecturers').submit(function(a){
                a.preventDefault();
                var id=$('#id').val();
                var name=$('#name').val();
                var dep=$('#dep').val();
                var contact=$('#contact').val();
                var email=$('#email').val();
                var pass=$('#password').val();
                $.ajax({
                    url:    '../functions/constructor.php',
                    data:{
                        'addlecturers':1,
                        'id'    :   id,
                        'name'  :   name,
                        'dep'   :   dep,
                        'contact':  contact,
                        'email' :   email,
                        'pass'  :   pass
                    },
                    type:'POST',
                    beforeSend:function(){},
                    success:function(data) {
                        $('#main').html(data);
                    }
                });                
            });
        </script>
    ";
    echo $form.$script;
}
if($page=='viewlecturers'){

}