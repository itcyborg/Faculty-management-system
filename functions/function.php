<?php
/**
 * Created by PhpStorm.
 * User: itcyb
 * Date: 4/12/2017
 * Time: 9:27 AM
 */
@session_start();

include '../system/newdb.php';
$db=new newdb();

/**
 * @param $array
 */
function addCourse($array){
    global $db;
    $course_code=$array['code'];
    $course_name=$array['name'];
    $department=$array['department'];
    $sql = "INSERT INTO courses(CourseCode,CourseName,DepartmentID) VALUES ('" . $course_code . "','" . $course_name . "','" . $department . "')";
    try{
        $result=$db->put($sql);
        var_dump($result);
    }catch (DBException $e){
        echo $e;
    }
}

/**
 * @param $topic
 */
function addForum($topic){
    global $db;
    $forumid="F".generateID();
    $by="ADMIN";
    $sql="INSERT INTO forums(Forum_ID, Topic, ThreadBy) VALUES ('$forumid','$topic','$by')";
    try{
        $db->put($sql);
    }catch (DBException $e){
        echo $e;
    }
}

/**
 * @return string
 */
function generateID(){
    $keyspace="ABCDEFGHIJKLMNPQRSTUVWXYZ123456789";
    $length=7;
    $idstr=array();
    $max=strlen($keyspace)-1;
    for($i=0;$i<$length;++$i){
        $n=rand(0,$max);
        $idstr[]=$keyspace[$n];
    }

    return implode($idstr);
}

/**
 * @param $array
 */
function addAttendance($array){
    global $db;
    $dept_id=$array['Dept_ID'];
    $course_id=$array['Course_ID'];
    $att_id="AT".generateID();
    $lec_id=$array['LecID'];
    $sql="INSERT INTO attendance(Dept_ID, UnitID, Att_ID, LecID) VALUES ('$dept_id','$course_id','$att_id','$lec_id')";
    $result=$db->put($sql);
    var_dump($result);
}

/**
 * @param $array
 */
function fillAttendance($array){
    global $db;
    $attid=$array['id'];
    $regno=strtoupper($array['regno']);
    $sql="SELECT * from attendance WHERE Att_ID='$attid'";
    if($regno!="") {
        $attendance = $db->get($sql)->fetch(PDO::FETCH_ASSOC)['Attendance'];
        if ($attendance == "" || $attendance == null) {
            $attendance = $regno;
        } else {
            if (strpos($attendance, $regno) !== false) {
                echo "Sorry you have already filled the attendance";
            } else {
                $attendance .= "," . $regno;
                $_SESSION['status']="success";
            }
        }
        if ($attendance == "" || $attendance == null) {
            echo "An error occured. The record cannot be updated";
        } else {
            $sql1 = "UPDATE attendance SET Attendance='$attendance' WHERE Att_ID='$attid'";
            $db->put($sql1);
        }
    }else{
        echo "Sorry cannot accept null values";
    }
}

/**
 * @param $array
 */
function addResource($array){
    $url="";
    if(isset($array['file'])){
        $fname="FL".generateID();
        $url=uploadFile($array['file'],"",$fname);
    }
    $type=$array['type'];
    $name=$array['name'];
    $resourceid="RC".generateID();
    $level=$array['access'];
    $dept_id=$array['dept'];
    $description=$array['description'];
    $uploadedby=$array['uploader'];
    $sql="INSERT INTO resources(UploadedBy, Type, Name, URL, ResourceID, AccessLevel, Dept_ID, Description) VALUES ('$uploadedby','$type','$name','$url','$resourceid','$level','$dept_id','$description')";
    global $db;
    try{
        $db->put($sql);
    }catch(DBException $e){
        echo $e;
    }

}

/**
 * @param $file
 * @param $destination
 */
function uploadFile($file, $type,$name){
    $txt=array('doc','docx','wps','txt','wpd');
    $powerpoint=array('pps','ppt','pptx',);
    $audio=array('m4a','mp3','wav','wma');
    $videos=array('avi','3gp','flv','mpg','mp4','wmv');
    $images=array('bmp','gif','jpg','png');
    $pdf=array('pdf');
    $spreadsheet=array('xlr','xls','xlsx');
    $compressed=array('zip','zipx');
    if($type=="profile"){

    }else {
        $type=pathinfo($file['name'], PATHINFO_EXTENSION);
        switch ($type){
            //text
            case in_array($type,$txt) :{
                $destination="../uploads/text/".$name.".".$type;
                if(move_uploaded_file($file['tmp_name'],$destination)){
                    echo "success";
                    return $destination;
                }else
                    echo "error";
                break;
            }
            //powerpoint
            case in_array($type,$powerpoint):{
                $destination="../uploads/ppt/".$name.".".$type;
                if(move_uploaded_file($file['tmp_name'],$destination)){
                    echo "success";
                    return $destination;
                }else
                    echo "error";
                break;
            }
            //audio
            case in_array($type,$audio):{
                $destination="../uploads/audio/".$name.".".$type;
                if(move_uploaded_file($file['tmp_name'],$destination)){
                    echo "success";
                    return $destination;
                }else
                    echo "error";
                break;
            }
            //videos
            case in_array($type,$videos):{
                $destination="../uploads/videos/".$name.".".$type;
                if(move_uploaded_file($file['tmp_name'],$destination)){
                    echo "success";
                    return $destination;
                }else
                    echo "error";
                break;
            }
            //images
            case in_array($type,$images):{
                $destination="../uploads/images/".$name.".".$type;
                if(move_uploaded_file($file['tmp_name'],$destination)){
                    echo "success";
                    return $destination;
                }else
                    echo "error";
                break;
            }
            //pdf
            case in_array($type,$pdf):{
                $destination="../uploads/pdf/".$name.".".$type;
                if(move_uploaded_file($file['tmp_name'],$destination)){
                    echo "success";
                    return $destination;
                }else
                    echo "error";
                break;
            }
            //spreadsheets
            case in_array($type,$spreadsheet):{
                $destination="../uploads/speadsheets/".$name.".".$type;
                if(move_uploaded_file($file['tmp_name'],$destination)){
                    echo "success";
                    return $destination;
                }else
                    echo "error";
                break;
            }
            //compressed
            case in_array($type,$compressed):{
                $destination="../uploads/compressed/".$name.".".$type;
                if(move_uploaded_file($file['tmp_name'],$destination)){
                    echo "success";
                    return $destination;
                }else
                    echo "error";
                break;
            }
            default :{
                die("Error! File type not supported");
            }
        }
    }
}

/**
 * @param $array
 */
function addPost($array){
    global $db;
    $forumid=$array['forum'];
    $content=$array['content'];
    $by=$array['by'];
    $sql="INSERT INTO posts(PostContent, PostBy, Forum_ID) VALUES ('$content','$by','$forumid')";
    try{
        $db->put($sql);
        header("location:".$array['url']);
    }catch (DBException $e){
        echo $e;
    }
}

/**
 * @param $array
 */
function registerOrganisation($array){
    global $db;
    $name=$array['name'];
    $type=$array['type'];
    $target=$array['target'];
    $slogan=$array['slogan'];
    $description=$array['description'];
    $leader=$array['leader'];
    $id="ORG".generateID();
    $sql="INSERT INTO organizations(name, type, target, slogan, description, leader, ID) VALUES ('$name','$type','$target','$slogan','$description','$leader','$id')";
    $error=false;
    try{
        $result=$db->put($sql);
        $error=false;
    }catch (DBException $e){
        var_dump($e->getMessage());
        $error=true;
    }
    if(!$error){
        return "success";
    }
}

/**
 * @param null $flag
 * @return array
 */
function viewForums($flag=NULL){
    global $db;
    $sql="SELECT * FROM forums";
    if($flag!==null){
        $sql.=" WHERE Flag='1'";
    }
    $_result=$db->get($sql);
    if($_result->rowCount()>0){
        $result=$_result->fetchAll(PDO::FETCH_OBJ);
        return $result;
    }
}

/**
 * @param $array
 */
function generateTimetable($array){
    global $db;
    $sql="SELECT * FROM units";
    try{
        $result=$db->get($sql);
        $result=$result->fetchAll(PDO::FETCH_NAMED);
        $max=3;
        $min=1;
        $maj=array('7-9','9-11','11-1','3-5');
        $nmaj=array('8-9','10-11','2-3');
        $days=array('monday','tuesday','wednesday','thursday','friday');
        $units=null;
        foreach ($result as $row){
            $units[]=array('course'=>$row['course_id'],'time'=>$row['AllocatedTime']);
        }
        $size=sizeof($maj);
        $sizem=sizeof($nmaj);
        $allocated=array();
        $alloc=array();
        foreach ($units as $unit){
            if($unit['time']%2==1){
                $sel=rand(0,$size-1);
                $day=rand(0,sizeof($days)-1);
                if(!in_array($unit['course'].": ".$maj[$sel].",".$days[$day]."\n",$alloc)) {
                    $alloc[] = $unit['course'] . ": " . $maj[$sel] . "," . $days[$day] . "\n";
                }
                if(!in_array($maj[$sel].",".$days[$day],$allocated)) {
                    $allocated[] = $maj[$sel] . "," . $days[$day];
                }else{
                }
            }else{
                $sel=rand(0,$sizem-1);
                $day=rand(0,sizeof($days)-1);
                if(!in_array($unit['course'].": ".$nmaj[$sel].",".$days[$day]."\n",$alloc)) {
                    $alloc[] = $unit['course'] . ": " . $nmaj[$sel] . "," . $days[$day] . "\n";
                }
                if(!in_array($nmaj[$sel].",".$days[$day],$allocated)) {
                    $allocated[] = $nmaj[$sel] . "," . $days[$day];
                }else{
                }
            }
        }
        foreach ($alloc as $value){
            echo $value;
        }
    }catch (DBException $e){
        die($e);
    }
}

/**
 * @param $array
 * @return DBException|Exception|string
 */
function addLecturer($array){
    global $db;
    $password = generateID() . generateID();
    $result="";
    $id=$array['id'];
    $name=$array['name'];
    $dep=$array['dep'];
    $contact=$array['contact'];
    $email=$array['email'];
    $pass = hashPass($password);
    $sql = "INSERT INTO lecturers(lec_id,lec_name,department,contact,email,password) VALUES('$id','$name','$dep',$contact,'$email','$pass')";
    try{
        $db->put($sql);
        $result="Success";
    }catch (DBException $e){
        $result=$e;
    }
    return $result . $password;
}

/**
 * @param null $id
 * @return array|mixed|string
 */
function viewLecturer($id = null)
{
    global $db;
    $sql = "SELECT * FROM lecturers";
    $result = "";
    if ($id != null && $id != "") {
        $sql .= " WHERE lec_id='$id' LIMIT 1";
        $result = $db->get($sql)->fetch(PDO::FETCH_OBJ);
    } else {
        $result = $db->get($sql)->fetchAll(PDO::FETCH_OBJ);
    }
    return $result;
}

/**
 * @param $array
 * @return DBException|Exception|null|string
 */
function editLectuers($array)
{
    global $db;
    $sql = "";
    $name = $array['name'];
    $id = $array['id'];
    $department = $array['department'];
    $contact = $array['contact'];
    $email = $array['email'];
    $result = null;
    if ($array['action'] == "edit") {
        $sql = "UPDATE lecturers SET lec_name='$name',department='$department',contact='$contact',email='$email' WHERE lec_id='$id'";
        try {
            $db->put($sql);
            $result = "SUCCESS";
        } catch (DBException $e) {
            $result = $e;
        }
    } elseif ($array['action'] == "delete") {

    }
    return $result;
}

/**
 *
 */
function sendMail()
{
    //require $_SERVER['DOCUMENT_ROOT']."/api/mailer.php";
    require "../api/mailer.php";
    $mail = new mailer();

    //set the instances

    $mail->setTo("test@gmail.com");
    $mail->setFrom("admin@faculty.com");
    $mail->setSubject("Account Creation");
    $mail->setBody("hello there wecome");
    $mail->sendMail();
}

/**
 * @param $array
 */
function login($array)
{
    global $db;
    $email = $array['email'];
    $sql = "SELECT * FROM lecturers WHERE email='$email'";
    $result = $db->get($sql);
    $ajax = false;
    if ($array['ajax'] == 1) $ajax = true;
    $errors = true;
    $url = '../staff/dashboard.php';
    $msg = null;
    if ($result->rowCount() > 0) {
        $row = $result->fetch(PDO::FETCH_OBJ);
        $hash = $row->password;
        if (verifyPass($array['password'], $hash)) {
            $errors = false;
            $msg = "success";
        } else {
            $errors = true;
            $msg = "Error.Wrong login details/User does not exist.";
        }
    } else {
        $errors = true;
        $msg = "Error.Wrong login details/User does not exist.";
    }
    if (!$ajax) {
        if (!$errors) {
            header('location:' . $url);
        } else {
            echo $msg;
        }
    } else {
        echo json_encode(array('error' => $errors, 'msg' => $msg, 'url' => $url));
    }
}

/**
 * @param $pass
 * @return bool|string
 */
function hashPass($pass)
{
    $options = [
        'cost' => 12
    ];
    return password_hash($pass, PASSWORD_DEFAULT, $options);
}

/**
 * @param $pass
 * @param $hash
 * @return bool
 */
function verifyPass($pass, $hash)
{
    if (password_verify($pass, $hash)) {
        return true;
    } else {
        return false;
    }
}


function addStudent($array)
{
    global $db;
    $password = generateID() . generateID();
    $pass = hashPass($password);
    $adm = $array['adm'];
    $name = $array['name'];
    $course = $array['course'];
    $email = $array['email'];
    $year = $array['year'];
    $contact = $array['contact'];
    $sql = "INSERT INTO fine.students(adm_number, name, year, course, contact, email, password) VALUES ('$adm','$name','$year','$course','$contact','$email','$pass')";
    try {
        $db->put($sql);
        echo "Success";
    } catch (DBException $e) {
        die(var_dump($e));
    }
}

function viewStudent($id = null)
{
    global $db;
    $sql = "SELECT * FROM students";
    $result = "";
    if ($id != null && $id != "") {
        $sql .= " WHERE adm_number='$id' LIMIT 1";
        $result = $db->get($sql)->fetch(PDO::FETCH_OBJ);
    } else {
        $result = $db->get($sql)->fetchAll(PDO::FETCH_OBJ);
    }
    return $result;
}

function editStudent($array)
{
    global $db;
    $adm = $array['adm'];
    $email = $array['email'];
    $name = $array['name'];
    $contact = $array['contact'];
    $course = $array['course'];
    $year = $array['year'];
    $sql = "UPDATE students SET name='$name',year='$year',course='$course',email='$email',contact='$contact' WHERE adm_number='$adm'";
    try {
        $db->put($sql);
        return "success";
    } catch (DBException $e) {
        die($e);
    }
}