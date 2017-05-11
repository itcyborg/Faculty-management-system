<?php
Class Connect{
	public $db;
	public function __construct(){
		try{
			$this->db=new PDO("mysql:host=localhost;dbname=fine","root","");
		}catch(PDOException $e){
			return false;
		}
	}
	public function anyQuery($sql=NULL){
		foreach ($sql as $KEY=> $value) {
			$query=$this->db->query($value);
			if($query==true){
				
			}
			else{
				
			}
		}
	}
	public function select($sql=NULL){
		$this->db->query($sql);
	}
	/*
	-Note that the function below is currently not servicing anything
	*/
	public function fetchsuggestions(){
		$result=$this->db->query("SELECT * FROM suggestions ORDER BY `time` DESC");
		while($row=$result->fetch()){
			$style="background-color:#000000;color:blue;border-radius:10px";
			$style2="background-color:black;color:blue;border-radius:10px";
			$comment=$row[0]*2;
				echo "<hr>";
				echo "<div style='$style'>";
				echo "<h3>$row[1]</h3>","<i>Suggested by: </i>",$row[3],"<i> at </i>", $row[4],"<br>";
				echo $row[2],"<br><br>";
				echo "<script type='text/javascript' src='js.js'></script>";
				echo "<button onclick='handleSeconds($row[0])'>Second(<b id='$row[0]'></b>)</button>";
				echo "<button onclick='handleComment($row[0])'>Comment</button>";
				echo "<div id='$comment'></div>";
				echo "</div>";
		}
	}
	public function suggestionscount(){
		$rows=$this->db->query("SELECT COUNT(*) FROM suggestions")->fetchColumn();
		echo $rows;
	}
}
$main=new Connect;
$CREATE=["CREATE TABLE `departments`(`id` INT AUTO_INCREMENT PRIMARY KEY,`name` VARCHAR(100) NOT NULL UNIQUE KEY,`head` VARCHAR(60)NOT NULL UNIQUE KEY,`time` TIMESTAMP)",
	"CREATE TABLE `results`(`department_id` INT NOT NULL,`course_id` INT NOT NULL,`student_id` VARCHAR(15) NOT NULL,`lecturer_id` VARCHAR(15) NOT NULL,`sem` VARCHAR(6) NOT NULL,`year` VARCHAR(6) NOT NULL,`id`INT PRIMARY KEY AUTO_INCREMENT,`grade` VARCHAR(4) NOT NULL,`result_type` VARCHAR(20) NOT NULL,`time` TIMESTAMP)",
	"CREATE TABLE `voting`(`vote_id` INT AUTO_INCREMENT PRIMARY KEY,`voter` VARCHAR(15),`aspirant` VARCHAR(60) NOT NULL
	)",
	"CREATE TABLE `organizations`(`id` INT AUTO_INCREMENT PRIMARY KEY,`name` VARCHAR(100) NOT NULL,`type` VARCHAR(60) NOT NULL,`target` VARCHAR(60) NOT NULL,`slogan`VARCHAR(60) NOT NULL,`description` TEXT NOT NULL,`leader` VARCHAR(60),`time` TIMESTAMP
	)",
	"CREATE TABLE `suggestions`(`id` INT PRIMARY KEY AUTO_INCREMENT NOT NULL,`title` VARCHAR(60) NOT NULL UNIQUE KEY,`suggestion`TEXT NOT NULL,`owner` VARCHAR(60) NOT NULL,`time` TIMESTAMP NOT NULL,`likes` INT NULL
	)",
	"CREATE TABLE `units`(`course_id` INT,`name` VARCHAR(60) NOT NULL,`id` INT PRIMARY KEY AUTO_INCREMENT NOT NULL,`department_id` INT NOT NULL,`time` TIMESTAMP
	)",
	"CREATE TABLE `students`(`adm_number` VARCHAR(15) NOT NULL PRIMARY KEY,`name` VARCHAR(30) NOT NULL,`year` VARCHAR(6) NOT NULL,`school` VARCHAR(100) NOT NULL,`course` VARCHAR(100) NOT NULL,`contact` INT,`email` VARCHAR(60) NOT NULL,`password` TEXT NOT NULL
	)",
	"CREATE TABLE `lecturers`(`lec_id` VARCHAR(12)NOT NULL PRIMARY KEY,`lec_name` VARCHAR(30) NOT NULL,`department` VARCHAR(40) NOT NULL,`contact` INT,`email` VARCHAR(60) NOT NULL,`password` VARCHAR(30) NOT NULL
	)",
	"CREATE TABLE `events`(`event_name` VARCHAR(100) NOT NULL PRIMARY KEY,`event_date` VARCHAR(30) NOT NULL,`event_venue` VARCHAR(30) NOT NULL,`event_organizer` VARCHAR(60) NOT NULL,`target_group` VARCHAR(100) NOT NULL,`event_theme` VARCHAR(100) NOT NULL
	)",
	"CREATE TABLE `news`(`title` VARCHAR(30) NOT NULL,`date` TIMESTAMP,`content`TEXT
	)",
	"CREATE TABLE `student_leaders`(`adm_number`VARCHAR(15) NOT NULL,`leader_name` VARCHAR(30) NOT NULL,`year_of_study` VARCHAR(6) NOT NULL,`leader_course` VARCHAR(100)NOT NULL,`leader_phone` VARCHAR(12) NOT NULL,`leader_email` VARCHAR(60) NOT NULL,`resignation` VARCHAR(20) NOT NULL,`period` VARCHAR(30) NOT NULL
	)",
	"CREATE TABLE `course_outlines`(`course_id` VARCHAR(100) NOT NULL PRIMARY KEY,`course_topics` VARCHAR(100) NOT NULL,`lec_id` INT NOT NULL
	)",
	"CREATE TABLE `attendance`(`ID` int NOT NULL auto_increment PRIMARY KEY,`Dept_ID` varchar(6) NULL,`CourseID` varchar(6) NULL,`Att_ID` varchar(6) NULL,`TimeStamp` timestamp default CURRENT_TIMESTAMP NOT NULL,`LecID` varchar(6) NULL,`Attendance` text NULL,constraint attendance_Att_ID_uindex
		unique (Att_ID)
	)",
	"CREATE TABLE `courses`(`ID` int NOT NULL auto_increment PRIMARY KEY,`CourseCode` varchar(6) NULL,`CourseName` varchar(254) NULL,`TimeStamp` timestamp default CURRENT_TIMESTAMP NOT NULL,`DepartmentID` varchar(6) NULL,constraint courses_CourseCode_uindex
		unique (CourseCode)
	)"
	,
	"CREATE TABLE `forums`(`ID` int NOT NULL auto_increment PRIMARY KEY,`Forum_ID` varchar(8) NOT NULL,`PostDate` timestamp default CURRENT_TIMESTAMP NOT NULL,`Topic` varchar(128) NOT NULL,`ThreadBy` varchar(8) NOT NULL,constraint forums_Forum_ID_uindex unique (Forum_ID),constraint forums_Topic_uindex unique (Topic)
	)"
	,
	"CREATE TABLE `guests`(`ID` int NOT NULL auto_increment PRIMARY KEY,`IP_Address` varchar(16) NOT NULL,`Client_agent` text NULL,`TimeStamp` timestamp default CURRENT_TIMESTAMP NOT NULL
	)"
	,
	"CREATE TABLE `posts`(`ID` int NOT NULL auto_increment PRIMARY KEY,`PostContent` text NOT NULL,`Thread` varchar(8) NOT NULL,`PostBy` varchar(8) NOT NULL,`Forum_ID` varchar(8) NOT NULL, constraint Forum_ID unique (Forum_ID)
	)"
	,
	"CREATE TABLE `resources`(`ID` int NOT NULL auto_increment PRIMARY KEY,`UploadedBy` varchar(8) NOT NULL,`Type` int NOT NULL,`Name` varchar(254) NOT NULL,`URL` text NULL,`ResourceID` varchar(6) NOT NULL,`TimeStamp` timestamp default CURRENT_TIMESTAMP NOT NULL,`AccessLevel` int NOT NULL,`Dept_ID` varchar(6) NOT NULL,`Description` text NOT NULL,constraint resources_ResourceID_uindex unique (ResourceID)
	)"
	,
	"CREATE TABLE `search_history`(`ID` int NOT NULL auto_increment PRIMARY KEY,`keyword` text NOT NULL,`IP_address` varchar(16) NOT NULL,`Result_Selected` text NOT NULL
	)",
	"CREATE TABLE `comments`(`suggestion_id` INT NOT NULL REFERENCES suggestions(`id`),`commentor` VARCHAR(40) NOT NULL,`comment` VARCHAR(200) NOT NULL UNIQUE KEY,`time` TIMESTAMP
	)",
	"CREATE TABLE `suggestion_likes`(`suggestion_id` INT NOT NULL,`liked_by` VARCHAR(20) NOT NULL,`time` TIMESTAMP)",
	"CREATE TABLE `schools`(`school_id` VARCHAR(10) NOT NULL,`school_name`VARCHAR(100) NOT NULL )"
];
$main->anyQuery($CREATE);
?>