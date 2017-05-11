<!DOCTYPE html>
<html>
<head>
	<title>Administrator</title>
	<script type="text/javascript" src="js.js"></script>
</head>
<body>
<style type="text/css">
	#menu li{
		display: inline-block;
		width: 80px;
		position: relative;
		border: 1px black solid;
		padding: 5px 10px;
	}
	#menu li:hover{
		color: white;
		background: black;
	}
	#menu li:hover ul{
		display: block;
		background: blue;
		color: white;
	}
	#menu li ul {
		left: -4px;
		position: absolute;
		padding: 3px;
		display: none;
	}
	#menu li li{
		text-align: left;
		width: 200px;
		cursor: pointer;
	}
	#render{
		position: absolute;
		top: 35%;
		width: 80%;
	}

    h1{
		color:blueviolet;
		position: absolute;
		left: 48%;
		top:-40%;
	}
	#render input,select{
		width: 30%;
		height: 30px;
		position: absolute;
		border-radius: 10px;
	}
	#render label{
		color: blue;
		font-size: 140%;
		position: absolute;
	}
    #form{
        border:1px;
        width:38%;
        height:60%;
        padding-top: 4%;
        padding-bottom: 2%;
        padding-left: 7%;
        margin-left: 40%;
        border-top-left-radius: 15%;
        border-top-right-radius: 15%;
        border-bottom-left-radius: 15%;
        border-bottom-right-radius: 15%;
        background-color:cornflowerblue;
        vertical-align: middle;
    }
    #sform{
        border:1px;
        width:38%;
        height:60%;
        padding-top: 2%;
        padding-bottom: 2%;
        padding-left: 7%;
        margin-left: 40%;
        border-top-left-radius: 35%;
        border-top-right-radius: 0%;
        border-bottom-left-radius:0%;
        border-bottom-right-radius: 35%;
        background-color:cornflowerblue;
        vertical-align: middle; 
    }

</style>
<ol id="menu">
	<li>Students
		<ul>
			<li onclick="loadRequest('admin/newstudent.php')">Add a new student</li>
			<li onclick="loadRequest('admin/modifystudent.php')">Modified crucial student info</li>
			<li onclick="loadRequest('admin/changestudentcourse.php')">Change student course</li>
			<li onclick="loadRequest('admin/archivestudent.php')">Archive student</li>
			<li onclick="loadRequest('admin/sendmail.php')">Send email to student</li>
		</ul>
	</li>
	<li>Staff
		<ul>
			<li onclick="loadRequest('admin/newstaff.php')">Add new staff</li>
			<li onclick="loadRequest()">Modify staff information</li>
			<li onclick="loadRequest()">Assign unit</li>
			<li onclick="loadRequest()">Archive staff</li>
			<li onclick="loadRequest()">Send email</li>
		</ul>
	</li>
	<li>Departments
		<ul>
			<li onclick="loadRequest('admin/newdepartment.php')">Add new department</li>
			<li onclick="loadRequest()">Change head</li>
			<li onclick="loadRequest()">Delete dept</li>
		</ul>
	</li>
	<li>Elections
		<ul>
			<li onclick="loadRequest('admin/newaspirant.php')">Add aspirants</li>
			<li onclick="loadRequest()">View election result</li>
			<li onclick="loadRequest()">Publish result</li>
			<li onclick="loadRequest()">Delete aspirant</li>
		</ul>
	</li>
	<li>Attendance
		<ul>
			<li onclick="loadRequest('admin/classattendance.php')">Add attendance statistics</li>
			<li onclick="loadRequest()">View attendance analysis</li>
			<li onclick="loadRequest()">Publish performance</li>
		</ul>
	</li>
	<li>Courses
		<ul>
			<li onclick="loadRequest('admin/newcourse.php')">Add new course</li>
			<li onclick="loadRequest()">Delete a course</li>
		</ul>
	</li>
	<li>Units
		<ul>
			<li onclick="loadRequest('admin/newunit.php')">Add new unit</li>
			<li onclick="loadRequest()">Delete a unit</li>
		</ul>
	</li>
	<li>Events
		<ul>
			<li onclick="loadRequest('admin/newevent.php')">New event</li>
			<li onclick="loadRequest()">Remove event</li>
		</ul>
	</li>
	<li>News
		<ul>
			<li onclick="loadRequest('admin/news.php')">News</li>
			<li onclick="loadRequest()">Archive</li>
		</ul>
	</li>
	<li>Resourses
		<ul>
			<li onclick="loadRequest('admin/newresource.php')">New resource</li>
			<li onclick="loadRequest()">Remove resource</li>
		</ul>
	</li>
	<li>Results
		<ul>
			<li onclick="loadRequest('admin/newresult.php')">Add student result</li>
			<li onclick="loadRequest()">Correct result</li>
			<li onclick="loadRequest()">Publish result</li>
		</ul>
	</li>
</ol><br><br>
<div id="render"></div>
<!--
	<div id="menu">
		<button onclick="load('newstaff.php')">Add new staff</button>
		<button onclick="load('newstudent.php')">Add new student</button>
		<button onclick="load('newdepartment.php')">Add new department</button>
		<button onclick="load('newaspirant.php')">Add an aspirant</button>
		<button onclick="load('classattendance.php')">Add class attendance record</button>
		<button onclick="load('newcourse.php')">Add Course</button>
		<button onclick="load('newunit.php')">Add unit</button>
		<button onclick="load('newevent.php')">Add Event</button>
		<button onclick="load('news.php')">Add news</button>
		<button onclick="load('newresource.php')">Add resource</button>
		<button onclick="load('newresult.php')">Insert results</button>
		<button onclick="load('voteresults.php')">View Vote Results</button>
	</div>
-->
</body>
</html>