<?php
/**
 * Created by PhpStorm.
 * User: itcyb
 * Date: 5/3/2017
 * Time: 4:05 PM
 */

$page = "";
$output = "";
$id = "";
if (isset($_POST['page']) && isset($_POST['id'])) {
    $page = $_POST['page'];
    $id = $_POST['id'];
} elseif (isset($_POST['page'])) {
    $page = $_POST['page'];
}

if ($page === "forums") {
    require $_SERVER['DOCUMENT_ROOT'] . "/system/newdb.php";
    $db = new newdb();
    $sql = "SELECT * FROM forums";
    $result = $db->get($sql);
    if ($result->rowCount() > 0) {
        while ($row = $result->fetch(PDO::FETCH_OBJ)) {
            $output .= "<a class='link' href='../view.php?forums=id&id=" . $row->Forum_ID . "' target='_#content'>" . $row->Topic . "</a>
                   <small><i><a href='../report.php?forum&id=" . $row->Forum_ID . "'>Report</a></i></small><br>";
        }
    } else {
        $output = "No forums found";
    }
    echo $output;
}
if ($page == 'attendance') {
    echo "<a href='#addattendance' class='link' onclick='getPage(\"constructor.php\",\"addattendance\",\"main\")'>New Attendance</a><hr>";
    require $_SERVER['DOCUMENT_ROOT'] . "/system/newdb.php";
    $db = new newdb();
    $sql = "SELECT * FROM attendance";
    $result = $db->get($sql)->fetchAll(PDO::FETCH_OBJ);
    echo "<h2>Attendance</h2>";
    $count = 0;
    foreach ($result as $item) {
        $count++;
        echo $count . ". <a href='#attendace#" . $item->Att_ID . "' onclick=\"getPages('constructor.php','attendaceid','main','$item->Att_ID')\">$item->Att_ID</a><br>";
    }
}
if ($page == 'addattendance') {
    $form = "<h3>Attendance</h3>
    <form id='attfrm'>
        <input type='text' name='deptid' id='deptid' placeholder='dept_id'><br>
        <input type='text' name='course' id='course' placeholder='course Id'><br>
        <input type='text' name='lecid' id='lecid' placeholder='Lecturer ID'><br>
        <input type='submit' name='addattendance' value='Add Attendance'>
    </form>
    <script type='text/javascript'>
        $('#attfrm').submit(function(e){
            e.preventDefault();
            $.ajax({
                url :   '../functions/constructor.php',
                type:   'POST',
                data:   {
                    'addattendance':1,
                    'lecid':$('#lecid').val(),
                    'course':$('#course').val(),
                    'deptid':$('#deptid').val()
                },
                success:function(data) {
                  alert(data);
                }
            });
        });
    </script>
    ";
    echo $form;
}
if ($page == 'attendaceid') {
    require_once $_SERVER['DOCUMENT_ROOT'] . "/system/newdb.php";
    $db = new newdb();
    echo "<h2>Fill Attendance :$id</h2>";
    $form = "
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
    $sql = "SELECT * FROM attendance WHERE Att_ID='$id'";
    $result = $db->get($sql)->fetch(PDO::FETCH_OBJ);
    $atts = $result->Attendance;
    $atts = explode(",", $atts);
    $attendance = "";
    foreach ($atts as $att) {
        $attendance .= "<p>$att</p>";
    }
    echo $attendance . $form;
}
if ($page == 'organisations') {
    echo "<a href='#addorganisation' onclick='getPage(\"constructor.php\",\"addorganisation\",\"main\")'>Add Organisation</a>";
    require $_SERVER['DOCUMENT_ROOT'] . "/system/newdb.php";
    $db = new newdb();
    $sql = "SELECT * FROM organizations";
    try {
        $result = $db->get($sql)->fetchAll(PDO::FETCH_OBJ);
        foreach ($result as $org) {
            echo "
            <div>
                <h2><a href='#organisation" . $org->ID . "' onclick='getPages(\"constructor.php\",\"organisation\",\"main\",\"$org->name\")'>" . $org->name . "</a></h2><br>
                <small><small><i>" . $org->slogan . "</i></small></small>
                <p>" . $org->description . "</p>
            </div>
            ";
        }
    } catch (DBException $e) {
        echo $e;
    }
}
if ($page == 'organisation') {
    require $_SERVER['DOCUMENT_ROOT'] . "/system/newdb.php";
    $db = new newdb();
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
if ($page == 'addorganisation') {
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
if ($page == 'courses') {
    $sql = "SELECT * FROM courses";
    include $_SERVER['DOCUMENT_ROOT'] . "/system/newdb.php";
    echo "<a href='#addcourse' class='link' onclick='getPage(\"constructor.php\",\"addcourses\",\"main\")'>Add Course</a><hr>";
    $db = new newdb();
    try {
        $result = $db->get($sql)->fetchAll(PDO::FETCH_OBJ);
        if (sizeof($result) < 1) {
            echo "No courses found";
        }
        $thead = "<table><thead><tr><th>Course Code</th><th>Course Name</th></tr></thead><tbody>";
        $tfoot = "</tbody></table>";
        $row = "";
        foreach ($result as $item) {
            $row .= "<tr><td>$item->CourseCode</td><td>$item->CourseName</td></tr>";
        }
        echo $thead . $row . $tfoot;
    } catch (DBException $e) {
    }
}
if ($page == 'addcourses') {
    require $_SERVER['DOCUMENT_ROOT'] . "/system/newdb.php";
    $db = new newdb();
    echo "adding course";
    $departments = "";
    $lecs = "";
    $sql = "SELECT * FROM departments";
    $results = $db->get($sql)->fetchAll(PDO::FETCH_OBJ);
    foreach ($results as $result) {
        $departments .= "<option value='$result->id'>$result->name</option>";
    }
    $form = "<form id='addcoursefrm'>
        <input type='text' name='code' id='code' placeholder='Course code'><br>
        <input type='text' name='name' id='name' placeholder='Course Name'><br>
        <select>
            <option id='department'>Select Department</option>
            $departments
        </select><br>
        <input type='submit' name='addcourse' id='addcourse' value='Add Course'>
    </form>
    <script type='text/javascript'>
        $('#addcoursefrm').submit(function(e) {
          e.preventDefault();
          $.ajax({
            url:'../functions/constructor.php',
            type:'POST',
            data:{
                'addcourse':1,
                'code':$('#code').val(),
                'name':$('#name').val(),
                'department':$('#department').val()
            },
            success:function (data) {
            }
          });
        });
    </script>";
    echo $form;
}
if ($page == 'resources') {
    echo "<a href='#addresource' onclick=\"getPage('constructor.php','addresource','main')\">Add Resources</a><br><hr>";
    require $_SERVER['DOCUMENT_ROOT'] . "/system/newdb.php";
    $db = new newdb();
    $sql = "SELECT * FROM resources";
    $result = $db->get($sql);
    $rs = $result->fetchAll(PDO::FETCH_OBJ);
    foreach ($rs as $r) {
        $link = substr($r->ResourceID, 0);
        echo "<a href='#resources$link' onclick=\"getPages('constructor.php','resourcesid','main','$link')\">" . $r->Name . "</a><br>";
        echo "<p>$r->Description</p>";
    }
}
if ($page == 'resourcesid') {
    require $_SERVER['DOCUMENT_ROOT'] . "/system/newdb.php";
    $db = new newdb();
    $sql = "SELECT * FROM resources WHERE ResourceID='$id'";
    $result = $db->get($sql);
    $rs = $result->fetchAll(PDO::FETCH_OBJ);
    foreach ($rs as $r) {
        $link = substr($r->URL, 0);
        $desc = $r->Description;
        echo "<a href='$link'>" . $r->Name . "</a><br><p>$desc</p>";
    }
}
if ($page == 'addresource') {
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
if ($page == 'logs') {
    if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/logs/access_logs.log")) {
        echo "<a class='link' target='_blank' href='../logs/access_logs.log'>Access Logs</a><br>";
    }
    if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/logs/error.log")) {
        echo "<a class='link' target='_blank' href='../logs/error.log'>Error Logs</a><br>";
    }
    if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/logs/search_logs.fcts")) {
        echo "<a class='link' target='_blank' href='../logs/search_logs.fcts'>Search Logs</a><br>";
    }
    if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/logs/searchError_logs.fct")) {
        echo "<a class='link' target='_blank' href='../logs/searchError_logs.fct'>Search Error Logs</a><br>";
    }
}
if ($page == "lecturers") {
    echo "<a class='link' href='#addlecturers' onclick=\"getPage('constructor.php','addlecturers','main')\">Add Lecturers</a>";
    echo "<a class='link' href='#viewlecturers' onclick=\"getPage('constructor.php','viewlecturers','main')\">View/Edit/Delete Lecturers</a>";
}
if ($page == 'addlecturers') {
    $form = '
        <form id="addlecturers">
            <input name="id" id="id" type="text" required placeholder="ID Number"><br>
            <input name="name" id="name" type="text" required placeholder="Lecturer Name"><br>
            <input name="dep" id="dep" type="text" required placeholder="Department"><br>
            <input name="contact" id="contact" type="number" required placeholder="Phone Number"><br>
            <input name="email" id="email" type="text" required placeholder="Email"><br><br>
            <button type="submit" value="register" name="register">register</button>
        </form>';
    $script = "
        <script>
            $('#addlecturers').submit(function(a){
                a.preventDefault();
                var id=$('#id').val();
                var name=$('#name').val();
                var dep=$('#dep').val();
                var contact=$('#contact').val();
                var email=$('#email').val();
                $.ajax({
                    url:    '../functions/constructor.php',
                    data:{
                        'addlecturers':1,
                        'id'    :   id,
                        'name'  :   name,
                        'dep'   :   dep,
                        'contact':  contact,
                        'email' :   email
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
    echo $form . $script;
}
if ($page == 'viewlecturers') {
    require $_SERVER['DOCUMENT_ROOT'] . "/functions/function.php";
    $results = viewLecturer();
    $output = "";
    if (sizeof($results) > 0) {
        $rows = "";
        foreach ($results as $result) {
            $id = $result->lec_id;
            $rows .= "<tr><td>$result->lec_id</td><td>$result->lec_name</td><td>$result->department</td><td>$result->email</td><td>$result->contact</td><td><select id='$id' onchange=\"doaction('$id')\"><option>Choose an option</option><option value='edit'>Edit</option><option value='delete'>Delete</option></select></td></tr>";
        }
        $thead = "<table class='table'>
                <thead>
                    <tr>
                        <th>Lec_ID</th>
                        <th>Name</th>
                        <th>Department</th>
                        <th>Email</th>
                        <th>Contact</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    $rows
                </tbody>
            </table>";
        $script = "<script type='text/javascript'>
                function doaction(id){
                    var action=$('#'+id).val();
                    getPages('constructor.php','editlecturer','main',id);
                }
                </script>
        ";
        $output = $thead . $script;
    }
    echo $output;
}
if ($page == "editlecturer") {
    require $_SERVER['DOCUMENT_ROOT'] . "/functions/function.php";
    $result = viewLecturer($id);
    $form = " <form id='editlecs'>
                <table>
                    <tr><td>Lecturer ID</td><td><input id='id' type='text' value='$result->lec_id' locked></td></tr>
                    <tr><td>Full Name</td><td><input id='name' type='text' value='$result->lec_name'></td></tr>
                    <tr><td>Department</td><td><input id='department' type='text' value='$result->department'></td></tr>
                    <tr><td>Email</td><td><input id='email' type='email' value='$result->email'></td></tr>
                    <tr><td>Contact</td><td><input id='contact' type='number' value='$result->contact'></td></tr>
                    <tr><td>Password</td><td></td></tr>
                    <tr><td></td><td><button onclick=\"sub('delete')\">Delete</button><button onclick=\"sub('edit')\" style='float:right;'>Edit</button></td></tr>
                </table>
            </form>";
    $script = "<script type='text/javascript'>
        $('#editlecs').submit(function(ew){
            ew.preventDefault();
        });

        function sub(action){
            var id=$('#id').val();
            var name=$('#name').val();
            var department=$('#department').val();
            var contact=$('#contact').val();
            var email=$('#email').val();
            $.ajax({
                url     :   '../functions/constructor.php',
                type    :   'POST',
                data    :   {
                    'action'    :   action,
                    'editlecturers' :   1,
                    'email' :   email,
                    'name'  :   name,
                    'id'    :   id,
                    'contact':  contact,
                    'department':   department
                },
                success:    function(data){
                    alert(data);
                }
            });
        }
</script>";
    echo $form . $script;
}
if ($page == 'timetable') {
    $list = scandir($_SERVER['DOCUMENT_ROOT'] . '/uploads/timetables', '1');
    foreach ($list as $item) {
        if ($item != ".." && $item != ".") {
            echo "<a target='_blank' href='../ptimetable.php?name=$item'>$item</a><br>";
        }
    }
}
if ($page == "students") {
    echo "<a class='link' href='#AddStudents' onclick=\"getPage('constructor.php','addstudents','main')\">Add Students</a>";
    echo "<a class='link' href='#ViewStudents' onclick=\"getPage('constructor.php','viewstudents','main')\">View Students</a>";
}
if ($page == "addstudents") {
    $form = "<form id='studentform'>
      <input type='text' id='adm' name='adm' placeholder='Admission Number'><br>
      <input type='text' id='name' name='name' placeholder='Name'><br>
      <input type='number' id='year' name='year' placeholder='Year'><br>
      <input type='text' placeholder='Course' name='course' id='course'><br>
      <input type='number' name='contact' placeholder='Contact' id='contact'><br>
      <input type='email' placeholder='Email' name='email' id='email'><br>
      <input type='submit' name='submit' value='Add'>
    </form>";
    $script = "
    <script type='text/javascript'>
      $('#studentform').submit(function(wer){
          wer.preventDefault();
          var adm=$('#adm').val();
          var name=$('#name').val();
          var year=$('#year').val();
          var course=$('#course').val();
          var contact=$('#contact').val();
          var email=$('#email').val();
          $.ajax({
            url:    '../functions/constructor.php',
            data:   {
                'addstudent'    :   1,
                'adm'           :   adm,
                'year'          :   year,
                'course'        :   course,
                'contact'       :   contact,
                'email'         :   email,
                'name'          :   name
            },
            type:   'POST',
            beforeSend: function(){
                alert(0);
            },
            success :function(data){
                alert(data);
            }
          });
      });
    </script>
    ";
    echo $form . $script;
}
if ($page == "viewstudents") {
    require $_SERVER['DOCUMENT_ROOT'] . "/functions/function.php";
    $results = viewStudent();
    if (sizeof($results) > 0) {
        $rows = "";
        foreach ($results as $result) {
            $id = $result->adm_number;
            $id = str_replace("/", '#', $id);
            $rows .= "<tr><td>$result->adm_number</td><td>$result->name</td><td>$result->year</td><td>$result->email</td><td>$result->course</td><td>$result->contact</td><td><select id='$id' onchange=\"actiondo('$id')\"><option>Choose an option</option><option value='edit'>Edit</option><option value='delete'>Delete</option></select></td></tr>";
        }
        $thead = "<table class='table'>
                <thead>
                    <tr>
                        <th>Admission Number</th>
                        <th>Name</th>
                        <th>Year</th>
                        <th>Email</th>
                        <th>Course</th>
                        <th>Contact</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    $rows
                </tbody>
            </table>";
        $script = "<script type='text/javascript'>
                function actiondo(id){
                    var action=$('#'+id).val();
                    getPages('constructor.php','editstudent','main',id);
                }
                </script>
        ";
        echo $thead . $script;
    }
}
if ($page == "editstudent") {
    require $_SERVER['DOCUMENT_ROOT'] . "/functions/function.php";
    $result = viewStudent(str_replace('#', '/', $id));
    $form = " <form id='editstudent'>
                <table>
                    <tr><td>Admission Number</td><td><input id='id' type='text' value='$result->adm_number' locked></td></tr>
                    <tr><td>Full Name</td><td><input id='name' type='text' value='$result->name'></td></tr>
                    <tr><td>Year</td><td><input type='number' id='year' value='$result->year'></td></tr>
                    <tr><td>Course</td><td><input id='course' type='text' value='$result->course'></td></tr>
                    <tr><td>Email</td><td><input id='email' type='email' value='$result->email'></td></tr>
                    <tr><td>Contact</td><td><input id='contact' type='number' value='$result->contact'></td></tr>
                    <tr><td>Password</td><td></td></tr>
                    <tr><td></td><td><button onclick=\"sub('delete')\">Delete</button><button onclick=\"sub('edit')\" style='float:right;'>Edit</button></td></tr>
                </table>
            </form>";
    $script = "<script type='text/javascript'>
        $('#editstudent').submit(function(ew){
            ew.preventDefault();
        });

        function sub(action){
            var id=$('#id').val();
            var name=$('#name').val();
            var course=$('#course').val();
            var contact=$('#contact').val();
            var email=$('#email').val();
            var year=$('#year').val();
            $.ajax({
                url     :   '../functions/constructor.php',
                type    :   'POST',
                data    :   {
                    'action'    :   action,
                    'editstudent' :   1,
                    'email' :   email,
                    'name'  :   name,
                    'id'    :   id,
                    'contact':  contact,
                    'course':   course,
                    'year'  :   year
                },
                success:    function(data){
                    alert(data);
                }
            });
        }
</script>";
    echo $form . $script;
}
