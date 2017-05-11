<?php

Class Post
{
    public $connect;

    public function __construct()
    {
        $this->connect = new PDO("mysql:host=localhost;dbname=faculty", "root", "");
    }

    public function create($sql)
    {
        $this->connect->query($sql);
    }

    public function insert($sql = NULL)
    {
        $this->connect->query($sql);

    }

    public function view($sql = NULL)
    {
        $result = $this->connect->query($sql);
        while ($row = $result->fetch()) {
            echo $row[0] . " <br>";
        }
    }

    public function viewstudents($sql = NULL)
    {
        $result = $this->connect->query($sql);
        while ($row = $result->fetch()) {
            echo $row[0] . " " . $row[1] . "<br>";
        }
    }

    public function viewaspirants($sql = NULL)
    {
        $result = $this->connect->query($sql);
        while ($row = $result->fetch()) {

            echo $row[1] . " " . $row[2] . " " . $row['image'] . "<br>";
        }

    }

    public function delete($sql = NULL)
    {
        $this->connect->query($sql);
    }

    public function upgrade($sql = NULL)
    {
        $result = $this->connect->query($sql);
        if ($result == true) {
            echo "data updated successfully";
        } else {
            echo "error updating data";
        }
    }
}

$create = ["CREATE TABLE `departments`(`id` INT AUTO_INCREMENT PRIMARY KEY,`name` VARCHAR(100) NOT NULL UNIQUE KEY,`head` VARCHAR(60)NOT NULL UNIQUE KEY,
	`time` TIMESTAMP)",
    "CREATE TABLE `results`(`department_id` INT NOT NULL,`course_id` INT NOT NULL,`student_id` VARCHAR(15) NOT NULL,`lecturer_id` VARCHAR(15) NOT NULL,
	`sem` VARCHAR(6) NOT NULL,`year` VARCHAR(6) NOT NULL,`id`INT PRIMARY KEY AUTO_INCREMENT,`grade` VARCHAR(4) NOT NULL,`result_type` VARCHAR(20) NOT 
	NULL,`time` TIMESTAMP)",
    "CREATE TABLE `voting`(`vote_id` INT AUTO_INCREMENT PRIMARY KEY,`voter` VARCHAR(15),`aspirant` VARCHAR(60) NOT NULL
	)",
    "CREATE TABLE `organizations`(`name` VARCHAR(100) PRIMARY KEY NOT NULL,`type` VARCHAR(60) NOT NULL,`target` VARCHAR(60) NOT NULL,`slogan`VARCHAR(60)
	 NOT NULL,`description` TEXT NOT NULL,`leader` VARCHAR(60),`time` TIMESTAMP
	)",
    "CREATE TABLE `suggestions`(`id` INT PRIMARY KEY AUTO_INCREMENT NOT NULL,`title` VARCHAR(60) NOT NULL UNIQUE KEY,`suggestion`TEXT NOT NULL,`owner`
	 VARCHAR(60),`time` TIMESTAMP
	)",
    "CREATE TABLE `units`(`course_id` INT,`name` VARCHAR(60) NOT NULL,`id` INT PRIMARY KEY AUTO_INCREMENT NOT NULL,`department_id` INT NOT NULL,`time` 
	TIMESTAMP)",
    "CREATE TABLE `students`(`adm_number` VARCHAR(15) NOT NULL PRIMARY KEY,`name` VARCHAR(30) NOT NULL,`year` VARCHAR(6) NOT NULL,`course` VARCHAR(100) NOT NULL,
	`contact` INT,`email` VARCHAR(60) NOT NULL,`password` VARCHAR(20) NOT NULL)",
    "CREATE TABLE `lecturers`(`lec_id` VARCHAR(12)NOT NULL PRIMARY KEY,`lec_name` VARCHAR(30) NOT NULL,`department` VARCHAR(40) NOT NULL,`contact` INT,
	`email` VARCHAR(60) NOT NULL,`password` VARCHAR(30) NOT NULL)",
    "CREATE TABLE `events`(`event_name` VARCHAR(100) NOT NULL PRIMARY KEY,`event_date` VARCHAR(30) NOT NULL,`event_venue` VARCHAR(30) NOT NULL,`event_organizer`
     VARCHAR(60) NOT NULL,`target_group` VARCHAR(100) NOT NULL,`event_theme` VARCHAR(100) NOT NULL)",
    "CREATE TABLE `news`(`title` VARCHAR(30) NOT NULL,`date` TIMESTAMP,`content`TEXT)",
    "CREATE TABLE `student_leaders`(`adm_number`VARCHAR(15) NOT NULL,`leader_name` VARCHAR(30) NOT NULL,`year_of_study` VARCHAR(6) NOT NULL,`leader_course` VARCHAR(100)NOT NULL,
    `leader_phone` VARCHAR(12) NOT NULL,`leader_email` VARCHAR(60) NOT NULL,`resignation` VARCHAR(20) NOT NULL,`period` VARCHAR(30) NOT NULL)",
    "CREATE TABLE `course_outlines`( `course_id` VARCHAR(100) NOT NULL PRIMARY KEY, `course_topics` VARCHAR(100) NOT NULL, `lec_id` INT NOT NULL)",
    "CREATE TABLE `attendance`(ID INT NOT NULL AUTO_INCREMENT	PRIMARY KEY,`Dept_ID` VARCHAR(6) NULL,`CourseID` VARCHAR(6) NULL,`Att_ID` VARCHAR(6)NULL,`TimeStamp` TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
	`LecID` VARCHAR(6) NULL,`Attendance` TEXT NULL,CONSTRAINT attendance_Att_ID_uindex UNIQUE (Att_ID))",
    "CREATE TABLE `courses`(ID INT NOT NULL AUTO_INCREMENT PRIMARY KEY,`CourseCode` VARCHAR(6) NULL,`CourseName` VARCHAR(254) NULL,`TimeStamp` TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
	`DepartmentID` VARCHAR(6) NULL,CONSTRAINT courses_CourseCode_uindex UNIQUE (CourseCode))",
    "CREATE TABLE `forums`(`ID` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,`Forum_ID` VARCHAR(8) NOT NULL,`PostDate` TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,`Topic` VARCHAR(128) NOT NULL,
	`ThreadBy` VARCHAR(8) NOT NULL,CONSTRAINT forums_Forum_ID_uindex UNIQUE (Forum_ID),CONSTRAINT forums_Topic_uindex UNIQUE (Topic))",
    "CREATE TABLE `guests`(`ID`INT NOT NULL AUTO_INCREMENT PRIMARY KEY,`IP_Address` VARCHAR(16) NOT NULL,`Client_agent` TEXT NULL,`TimeStamp` TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL)",
    "CREATE TABLE `posts``ID` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,`PostContent` TEXT NOT NULL,`Thread` VARCHAR(8) NOT NULL,`PostBy` VARCHAR(8) NOT NULL,`Forum_ID` VARCHAR(8) NOT NULL,
	CONSTRAINT Forum_ID UNIQUE (Forum_ID))",
    "CREATE TABLE `resources`(`ID`INT NOT NULL AUTO_INCREMENT PRIMARY KEY,`UploadedBy` VARCHAR(8) NOT NULL,`Type` INT NOT NULL,`Name` VARCHAR(254) NOT NULL,`URL` TEXT NULL,
	`ResourceID` VARCHAR(6) NOT NULL,`TimeStamp` TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,`AccessLevel` INT NOT NULL,`Dept_ID` VARCHAR(6) NOT NULL,`Description` TEXT NOT NULL,
	CONSTRAINT resources_ResourceID_uindex UNIQUE (ResourceID)",
    "CREATE TABLE `search_history`(`ID` INT NOT NULL AUTO_INCREMENT	PRIMARY KEY,`Keyword` TEXT NOT NULL,`IP_address` VARCHAR(16) NOT NULL,`Result_Selected` TEXT NOT NULL)",
    "CREATE TABLE `comments`(`suggestion_id` INT NOT NULL REFERENCES suggestions(`id`),`commentor` VARCHAR(40) NOT NULL,`comment` VARCHAR(200) NOT NULL UNIQUE KEY,`time` TIMESTAMP)",
    "CREATE TABLE `aspirants`(`aspirant_code` VARCHAR(20) PRIMARY KEY,`name` VARCHAR(60),`position` VARCHAR(30),`image`VARCHAR(200))"
];

$post = new Post();
foreach ($create as $key) {
    $post->create($key);
}

#..inserting data into tables

if (isset($_POST['submit'])) {
    $adm = $_POST['admission'];
    $name = $_POST['name'];
    $yr = $_POST['year'];
    $course = $_POST['course'];
    $contact = $_POST['contact'];
    $email = $_POST['email'];
    $pass = $_POST['password'];
    $sql = "INSERT INTO `students` (`adm_number`, `name`, `year`, `course`, `contact`, `email`,`password`)
 VALUES ('$adm', '$name', '$yr', '$course', $contact, '$email','$pass')";
    $post->insert($sql);
}
if (isset($_POST['register'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $dep = $_POST['dep'];
    $contact = $_POST['contact'];
    $email = $_POST['email'];
    $pass = $_POST['password'];
    echo "okay";
    $sql = "INSERT INTO `lecturers`(`lec_id`,`lec_name`,`department`,`contact`,`email`,`password`) 
	VALUES('$id','$name','$dep',$contact,'$email','$pass')";
    $post->insert($sql);
}
if (isset($_POST['post'])) {
    $e_name = $_POST['e-name'];
    $date = $_POST['date'];
    $venue = $_POST['venue'];
    $organizer = $_POST['organizer'];
    $target = $_POST['target'];
    $theme = $_POST['theme'];
    echo "eventing";
    $sql = "INSERT INTO `events`(`event_name`,`event_date`,`event_venue`,`event_organizer`,`target_group`,`event_theme`) 
	VALUES('$e_name','$date','$venue','$organizer','$target','$theme')";
    $post->insert($sql);
}
if (isset($_POST['news'])) {
    $title = $_POST['title'];
    $content = $_POST['content'];
    echo "recieved";
    $sql = "INSERT INTO `news`(`title`,`date`,`content`) VALUES('$title',NOW(),'$content')";
    $post->insert($sql);
}
if (isset($_POST['enter'])) {
    $admsi = $_POST['admission'];
    $name = $_POST['name'];
    $yr = $_POST['year'];
    $course = $_POST['course'];
    $contact = $_POST['contact'];
    $email = $_POST['email'];
    $resignation = $_POST['resignation'];
    $period = $_POST['period'];

    $sql = "INSERT INTO `student_leaders`(`adm_number`,`leader_name`,`year_of_study`,`leader_course`,`leader_phone`,`leader_email`,`resignation`,`period`) 
		VALUES('$admsi','$name','$yr','$course',$contact,'$email','$resignation','$period')";
    $post->insert($sql);
}
if (isset($_POST['upload'])) {
    $code = $_POST['code'];
    $name = $_POST['name'];
    $position = $_POST['position'];
    $tempfile = $_FILES['image']['tmp_name'];
    $deffile = $_FILES['image']['name'];
    if (is_uploaded_file($tempfile, $target)) {
        if (move_uploaded_file($tempfile, $target)) {
            $relpath = $deffile;

            $sql = "INSERT INTO `aspirants`(`aspirant_code`,`name`,`position`,`image`)
		 VALUES('$code','$name','$position','$relpath')";
            $post->insert($sql);
        }
    }
}

#...fetching data from the database

if (isset($_POST['check'])) {
    $adm = $_POST['admission'];
    $sql = "SELECT * FROM students WHERE `adm_number`='$adm'";
    $result = $post->viewstudents($sql);
}
if (isset($_POST['students'])) {
    $sql = "SELECT * FROM `students`";
    $post->viewstudents($sql);
}
if (isset($_POST['check'])) {
    $id = $_POST['admission'];
    $sql = "SELECT * FROM `lecturers` WHERE `lec_id`='$id'";
    $post->view($sql);
}
if (isset($_POST['lecs'])) {
    $sql = "SELECT * FROM `lecturers`";
    $post->viewstudents($sql);
}
if (isset($_POST['chec'])) {
    $sql = "SELECT * FROM `student_leaders`";
    $post->viewstudents($sql);
}
if (isset($_POST['view'])) {
    $sql = "SELECT * FROM `events`";
    $post->view($sql);
}
if (isset($_POST['new'])) {
    $sql = "SELECT * FROM `news`";
    $post->view($sql);
}
if (isset($_POST['vote'])) {
    $sql = "SELECT * FROM `aspirants`";
    $post->viewaspirants($sql);
}

#...deleting data

if (isset($_POST['delete'])) {
    $id = $_POST['admission'];
    echo "complete";
    $post->delete("DELETE FROM `lecturers` WHERE `lec_id`='$id'");
}
if (isset($_POST['delete'])) {
    $adms = $_POST['admission'];
    $post->delete("DELETE FROM `students` WHERE `adm_number`='$adms'");
}
if (isset($_POST['del_events'])) {
    $sql = "TRANCATE `events`";
    $post->delete($sql);
}

#...updating data

if (isset($_POST['update'])) {
    $admi = $_POST['admission'];
    $phone = $_POST['phone'];
    $phone2 = $_POST['phone2'];
    $email = $_POST['email'];
    $email2 = $_POST['email2'];
    $sql = "UPDATE `students` SET `contact`='$phone2', `email`='$email2' WHERE `adm_number`='$admi'";
    $post->upgrade($sql);

}
if (isset($_POST['change'])) {
    $id = $_POST['id'];
    $contact = $_POST['contact'];
    $pcontact = $_POST['pcontact'];
    $sql = "UPDATE `lecturers` SET `contact`='$pcontact' WHERE `lec_id`='$id'";
    $post->upgrade($sql);
}
if (isset($_POST['echange'])) {
    $name = $_POST['ename'];
    $date = $_POST['edate'];
    $venue = $_POST['evenue'];

    $sql = "UPDATE `events` SET `event_date`='$date',`event_venue`='$venue' WHERE `event_name`='$name'";
    $post->upgrade($sql);
}

?>