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
    $sql="INSERT INTO courses(CourseCode,CourseName,DepartmentID) VALUES ('".$course_code."','".$course_name."','".$department."') ON DUPLICATE SET CourseName='$course_name',DepartmentID='$department'";
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
    $password=$array['pass'];
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
                header('location:'.$array['url']);
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
    try{
        $result=$db->put($sql);
        var_dump($result);
    }catch (DBException $e){
        var_dump($e->getMessage());
    }
}

/**
 *
 * TODO get a list of all the units of that particular course
 * TODO get all the timeslots
 * TODO allocate all the units to their specific timeslot randomly until all the units have been allocated
 * TODO allocate all the lectures a day
 * TODO allocate all the lectures a venue
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
