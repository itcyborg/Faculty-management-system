<?php
/**
 * Created by PhpStorm.
 * User: itcyb
 * Date: 4/20/2017
 * Time: 5:44 PM
 */

require "system/newdb.php";
$db = new newdb();
$sql = "
CREATE TABLE attendance
(
	ID INT AUTO_INCREMENT
		PRIMARY KEY,
	Dept_ID VARCHAR(6) NULL,
	Att_ID VARCHAR(6) NULL,
	TimeStamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
	LecID VARCHAR(6) NULL,
	Attendance TEXT NULL,
	UnitID VARCHAR(6) NULL,
	CONSTRAINT attendance_Att_ID_uindex
		UNIQUE (Att_ID)
)
;
CREATE TABLE lecturers
(
  lec_id VARCHAR(12) NOT NULL PRIMARY KEY,
  lec_name VARCHAR(30) NOT NULL,
  department VARCHAR(40) NOT NULL,
  contact INT,
  email VARCHAR(60) NOT NULL,
  password VARCHAR(30) NOT NULL,
  units TEXT NULL
)
;
CREATE TABLE lecturer_material
(
	lec_id VARCHAR(30) PRIMARY KEY,
	resources TEXT NULL
)
;

CREATE TABLE comments
(
	suggestion_id INT NOT NULL,
	commentor VARCHAR(40) NOT NULL,
	comment VARCHAR(200) NOT NULL,
	time TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
	CONSTRAINT comment
		UNIQUE (comment)
)
;

CREATE TABLE course_outlines
(
	course_id VARCHAR(100) NOT NULL
		PRIMARY KEY,
	course_topics VARCHAR(100) NOT NULL,
	lec_id INT NOT NULL
)
;

CREATE TABLE courses
(
	ID INT AUTO_INCREMENT
		PRIMARY KEY,
	CourseCode VARCHAR(6) NULL,
	CourseName VARCHAR(254) NULL,
	TimeStamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
	DepartmentID VARCHAR(6) NULL,
	CONSTRAINT courses_CourseCode_uindex
		UNIQUE (CourseCode)
)
;

ALTER TABLE course_outlines
	ADD CONSTRAINT course_outlines_ibfk_1
		FOREIGN KEY (course_id) REFERENCES fine.courses (CourseCode)
			ON UPDATE CASCADE ON DELETE CASCADE
;

CREATE TABLE departments
(
	id VARCHAR(11) NOT NULL
		PRIMARY KEY,
	name VARCHAR(100) NOT NULL,
	head VARCHAR(60) NOT NULL,
	time TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
	CONSTRAINT name
		UNIQUE (name),
	CONSTRAINT head
		UNIQUE (head)
)
;

CREATE TABLE events
(
	event_name VARCHAR(100) NOT NULL
		PRIMARY KEY,
	event_date VARCHAR(30) NOT NULL,
	event_venue VARCHAR(30) NOT NULL,
	event_organizer VARCHAR(60) NOT NULL,
	target_group VARCHAR(100) NOT NULL,
	event_theme VARCHAR(100) NOT NULL
)
;

CREATE TABLE forums
(
	Forum_ID VARCHAR(8) NOT NULL
		PRIMARY KEY,
	PostDate TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
	Topic VARCHAR(128) NOT NULL,
	ThreadBy VARCHAR(8) NOT NULL,
	Flag INT DEFAULT '0' NOT NULL,
	CONSTRAINT forums_Topic_uindex
		UNIQUE (Topic)
)
;

CREATE TABLE guests
(
	ID INT AUTO_INCREMENT
		PRIMARY KEY,
	IP_Address VARCHAR(16) NOT NULL,
	Client_agent TEXT NULL,
	TimeStamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL
)
;

CREATE TABLE lecturers
(
	lec_id VARCHAR(12) NOT NULL
		PRIMARY KEY,
	lec_name VARCHAR(30) NOT NULL,
	department VARCHAR(10) NOT NULL,
	contact INT NULL,
	email VARCHAR(60) NOT NULL,
	password VARCHAR(30) NOT NULL
)
;

CREATE INDEX department
	ON lecturers (department)
;

CREATE TABLE news
(
	title VARCHAR(30) NOT NULL,
	date TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
	content TEXT NULL
)
;

CREATE TABLE organizations
(
	name VARCHAR(100) NOT NULL,
	type VARCHAR(60) NOT NULL,
	target VARCHAR(60) NOT NULL,
	slogan VARCHAR(60) NOT NULL,
	description TEXT NOT NULL,
	leader VARCHAR(60) NULL,
	time TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
	ID VARCHAR(8) NOT NULL
		PRIMARY KEY,
	CONSTRAINT organizations_name_uindex
		UNIQUE (name)
)
;

CREATE TABLE posts
(
	ID INT AUTO_INCREMENT
		PRIMARY KEY,
	PostContent TEXT NOT NULL,
	PostBy VARCHAR(8) NOT NULL,
	Forum_ID VARCHAR(8) NOT NULL,
	TimeStamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP NULL,
	Flag INT DEFAULT '0' NOT NULL,
	CONSTRAINT posts_ibfk_1
		FOREIGN KEY (Forum_ID) REFERENCES fine.forums (Forum_ID)
			ON UPDATE CASCADE ON DELETE CASCADE
)
;

CREATE INDEX Forum_ID
	ON posts (Forum_ID)
;

CREATE TABLE resources
(
	ID INT AUTO_INCREMENT
		PRIMARY KEY,
	UploadedBy VARCHAR(8) NOT NULL,
	Type INT NOT NULL,
	Name VARCHAR(254) NOT NULL,
	URL TEXT NULL,
	ResourceID VARCHAR(6) NOT NULL,
	TimeStamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
	AccessLevel INT NOT NULL,
	Dept_ID VARCHAR(6) NOT NULL,
	Description TEXT NOT NULL,
	CONSTRAINT resources_ResourceID_uindex
		UNIQUE (ResourceID)
)
;

CREATE TABLE results
(
	department_id INT NOT NULL,
	course_id INT NOT NULL,
	student_id VARCHAR(15) NOT NULL,
	lecturer_id VARCHAR(15) NOT NULL,
	sem VARCHAR(6) NOT NULL,
	year VARCHAR(6) NOT NULL,
	id INT AUTO_INCREMENT
		PRIMARY KEY,
	grade VARCHAR(4) NOT NULL,
	result_type VARCHAR(20) NOT NULL,
	time TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL
)
;

CREATE TABLE search_history
(
	ID INT AUTO_INCREMENT
		PRIMARY KEY,
	Keyword TEXT NOT NULL,
	IP_address VARCHAR(16) NOT NULL,
	Result_Selected TEXT NOT NULL
)
;

CREATE TABLE student_leaders
(
	adm_number VARCHAR(15) NOT NULL,
	leader_name VARCHAR(30) NOT NULL,
	year_of_study VARCHAR(6) NOT NULL,
	leader_course VARCHAR(100) NOT NULL,
	leader_phone VARCHAR(12) NOT NULL,
	leader_email VARCHAR(60) NOT NULL,
	resignation VARCHAR(20) NOT NULL,
	period VARCHAR(30) NOT NULL,
	Org_ID VARCHAR(8) NOT NULL
)
;

CREATE TABLE students
(
	adm_number VARCHAR(15) NOT NULL
		PRIMARY KEY,
	name VARCHAR(30) NOT NULL,
	year VARCHAR(6) NOT NULL,
	course VARCHAR(100) NOT NULL,
	contact INT NULL,
	email VARCHAR(60) NOT NULL,
	password VARCHAR(20) NOT NULL
)
;

CREATE TABLE suggestions
(
	id INT AUTO_INCREMENT
		PRIMARY KEY,
	title VARCHAR(60) NOT NULL,
	suggestion TEXT NOT NULL,
	owner VARCHAR(60) NULL,
	time TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
	CONSTRAINT title
		UNIQUE (title)
)
;

CREATE TABLE units
(
	course_id VARCHAR(10) NOT NULL,
	name VARCHAR(60) NOT NULL,
	id INT AUTO_INCREMENT
		PRIMARY KEY,
	department_id INT NOT NULL,
	time TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
	AllocatedTime INT NULL,
	CONSTRAINT units_course_id_uindex
		UNIQUE (course_id),
	CONSTRAINT units_ibfk_1
		FOREIGN KEY (course_id) REFERENCES fine.courses (CourseCode)
			ON UPDATE CASCADE ON DELETE CASCADE
)
;

CREATE TABLE voting
(
	vote_id INT AUTO_INCREMENT
		PRIMARY KEY,
	voter VARCHAR(15) NULL,
	aspirant VARCHAR(60) NOT NULL
)
;

CREATE VIEW forumview AS 
SELECT
    forums.Forum_ID   AS Forum_ID,
    forums.PostDate   AS PostDate,
    forums.Topic      AS Topic,
    forums.ThreadBy   AS ThreadBy,
    posts.PostBy      AS PostBy,
    posts.PostContent AS PostContent,
    posts.TimeStamp   AS TimeStamp
  FROM (forums
    JOIN posts ON ((forums.Forum_ID = posts.Forum_ID)));

CREATE VIEW studentorgs AS 
SELECT
    organizations.name            AS name,
    organizations.type            AS type,
    organizations.target          AS target,
    organizations.slogan          AS slogan,
    organizations.description     AS description,
    organizations.leader          AS leader,
    organizations.time            AS time,
    organizations.ID              AS ID,
    student_leaders.adm_number    AS adm_number,
    student_leaders.leader_name   AS leader_name,
    student_leaders.year_of_study AS year_of_study,
    student_leaders.leader_course AS leader_course,
    student_leaders.leader_phone  AS leader_phone,
    student_leaders.leader_email  AS leader_email,
    student_leaders.resignation   AS resignation,
    student_leaders.period        AS period,
    student_leaders.Org_ID        AS Org_ID
  FROM (organizations
    LEFT JOIN student_leaders ON ((organizations.ID = student_leaders.Org_ID)));



";

try {
    $db->createTable($sql);
    echo "success creating tables";
} catch (DBException $e) {
    //echo $e.',<br>';
}
