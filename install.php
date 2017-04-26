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
create table fms.attendance
(
	ID int not null auto_increment
		primary key,
	Dept_ID varchar(6) null,
	Att_ID varchar(6) null,
	TimeStamp timestamp default CURRENT_TIMESTAMP not null,
	LecID varchar(6) null,
	Attendance text null,
	UnitID varchar(6) null,
	constraint attendance_Att_ID_uindex
		unique (Att_ID)
)
;

create table fms.comments
(
	suggestion_id int not null,
	commentor varchar(40) not null,
	comment varchar(200) not null,
	time timestamp default CURRENT_TIMESTAMP not null,
	constraint comment
		unique (comment)
)
;

create table fms.course_outlines
(
	course_id varchar(100) not null
		primary key,
	course_topics varchar(100) not null,
	lec_id int not null
)
;

create table fms.courses
(
	ID int not null auto_increment
		primary key,
	CourseCode varchar(6) null,
	CourseName varchar(254) null,
	TimeStamp timestamp default CURRENT_TIMESTAMP not null,
	DepartmentID varchar(6) null,
	constraint courses_CourseCode_uindex
		unique (CourseCode)
)
;

alter table course_outlines
	add constraint course_outlines_ibfk_1
		foreign key (course_id) references fms.courses (CourseCode)
			on update cascade on delete cascade
;

create table fms.departments
(
	id varchar(11) not null
		primary key,
	name varchar(100) not null,
	head varchar(60) not null,
	time timestamp default CURRENT_TIMESTAMP not null,
	constraint name
		unique (name),
	constraint head
		unique (head)
)
;

create table fms.events
(
	event_name varchar(100) not null
		primary key,
	event_date varchar(30) not null,
	event_venue varchar(30) not null,
	event_organizer varchar(60) not null,
	target_group varchar(100) not null,
	event_theme varchar(100) not null
)
;

create table fms.forums
(
	Forum_ID varchar(8) not null
		primary key,
	PostDate timestamp default CURRENT_TIMESTAMP not null,
	Topic varchar(128) not null,
	ThreadBy varchar(8) not null,
	constraint forums_Topic_uindex
		unique (Topic)
)
;

create table fms.guests
(
	ID int not null auto_increment
		primary key,
	IP_Address varchar(16) not null,
	Client_agent text null,
	TimeStamp timestamp default CURRENT_TIMESTAMP not null
)
;

create table fms.lecturers
(
	lec_id varchar(12) not null
		primary key,
	lec_name varchar(30) not null,
	department varchar(10) not null,
	contact int null,
	email varchar(60) not null,
	password varchar(30) not null
)
;

create index department
	on lecturers (department)
;

create table fms.news
(
	title varchar(30) not null,
	date timestamp default CURRENT_TIMESTAMP not null,
	content text null
)
;

create table fms.organizations
(
	name varchar(100) not null,
	type varchar(60) not null,
	target varchar(60) not null,
	slogan varchar(60) not null,
	description text not null,
	leader varchar(60) null,
	time timestamp default CURRENT_TIMESTAMP not null,
	ID varchar(8) not null
		primary key,
	constraint organizations_name_uindex
		unique (name)
)
;

create table fms.posts
(
	ID int not null auto_increment
		primary key,
	PostContent text not null,
	PostBy varchar(8) not null,
	Forum_ID varchar(8) not null,
	TimeStamp timestamp default CURRENT_TIMESTAMP null,
	Flag int default '0' not null,
	constraint posts_ibfk_1
		foreign key (Forum_ID) references fms.forums (Forum_ID)
			on update cascade on delete cascade
)
;

create index Forum_ID
	on posts (Forum_ID)
;

create table fms.resources
(
	ID int not null auto_increment
		primary key,
	UploadedBy varchar(8) not null,
	Type int not null,
	Name varchar(254) not null,
	URL text null,
	ResourceID varchar(6) not null,
	TimeStamp timestamp default CURRENT_TIMESTAMP not null,
	AccessLevel int not null,
	Dept_ID varchar(6) not null,
	Description text not null,
	constraint resources_ResourceID_uindex
		unique (ResourceID)
)
;

create table fms.results
(
	department_id int not null,
	course_id int not null,
	student_id varchar(15) not null,
	lecturer_id varchar(15) not null,
	sem varchar(6) not null,
	year varchar(6) not null,
	id int not null auto_increment
		primary key,
	grade varchar(4) not null,
	result_type varchar(20) not null,
	time timestamp default CURRENT_TIMESTAMP not null
)
;

create table fms.search_history
(
	ID int not null auto_increment
		primary key,
	Keyword text not null,
	IP_address varchar(16) not null,
	Result_Selected text not null
)
;

create table fms.student_leaders
(
	adm_number varchar(15) not null,
	leader_name varchar(30) not null,
	year_of_study varchar(6) not null,
	leader_course varchar(100) not null,
	leader_phone varchar(12) not null,
	leader_email varchar(60) not null,
	resignation varchar(20) not null,
	period varchar(30) not null,
	Org_ID varchar(8) not null
)
;

create table fms.students
(
	adm_number varchar(15) not null
		primary key,
	name varchar(30) not null,
	year varchar(6) not null,
	course varchar(100) not null,
	contact int null,
	email varchar(60) not null,
	password varchar(20) not null
)
;

create table fms.suggestions
(
	id int not null auto_increment
		primary key,
	title varchar(60) not null,
	suggestion text not null,
	owner varchar(60) null,
	time timestamp default CURRENT_TIMESTAMP not null,
	constraint title
		unique (title)
)
;

create table fms.units
(
	course_id varchar(10) not null,
	name varchar(60) not null,
	id int not null auto_increment
		primary key,
	department_id int not null,
	time timestamp default CURRENT_TIMESTAMP not null,
	AllocatedTime int null,
	constraint units_course_id_uindex
		unique (course_id),
	constraint units_ibfk_1
		foreign key (course_id) references fms.courses (CourseCode)
			on update cascade on delete cascade
)
;

create table fms.voting
(
	vote_id int not null auto_increment
		primary key,
	voter varchar(15) null,
	aspirant varchar(60) not null
)
;

create view fms.forumview as 
SELECT
    `fms`.`forums`.`Forum_ID`   AS `Forum_ID`,
    `fms`.`forums`.`PostDate`   AS `PostDate`,
    `fms`.`forums`.`Topic`      AS `Topic`,
    `fms`.`forums`.`ThreadBy`   AS `ThreadBy`,
    `fms`.`posts`.`PostBy`      AS `PostBy`,
    `fms`.`posts`.`PostContent` AS `PostContent`,
    `fms`.`posts`.`TimeStamp`   AS `TimeStamp`
  FROM (`fms`.`forums`
    JOIN `fms`.`posts` ON ((`fms`.`forums`.`Forum_ID` = `fms`.`posts`.`Forum_ID`)));

create view fms.studentorgs as 
SELECT
    `fms`.`organizations`.`name`            AS `name`,
    `fms`.`organizations`.`type`            AS `type`,
    `fms`.`organizations`.`target`          AS `target`,
    `fms`.`organizations`.`slogan`          AS `slogan`,
    `fms`.`organizations`.`description`     AS `description`,
    `fms`.`organizations`.`leader`          AS `leader`,
    `fms`.`organizations`.`time`            AS `time`,
    `fms`.`organizations`.`ID`              AS `ID`,
    `fms`.`student_leaders`.`adm_number`    AS `adm_number`,
    `fms`.`student_leaders`.`leader_name`   AS `leader_name`,
    `fms`.`student_leaders`.`year_of_study` AS `year_of_study`,
    `fms`.`student_leaders`.`leader_course` AS `leader_course`,
    `fms`.`student_leaders`.`leader_phone`  AS `leader_phone`,
    `fms`.`student_leaders`.`leader_email`  AS `leader_email`,
    `fms`.`student_leaders`.`resignation`   AS `resignation`,
    `fms`.`student_leaders`.`period`        AS `period`,
    `fms`.`student_leaders`.`Org_ID`        AS `Org_ID`
  FROM (`fms`.`organizations`
    LEFT JOIN `fms`.`student_leaders` ON ((`fms`.`organizations`.`ID` = `fms`.`student_leaders`.`Org_ID`)));


";

try{
    $db->createTable($sql);
    echo "success creating tables";
}catch (DBException $e){
    //echo $e.',<br>';
}
