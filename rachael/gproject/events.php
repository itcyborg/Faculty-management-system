<!DOCTYPE html>
<html>
<head>
	<title>events</title>
</head>
<body>
 <form id="form1" action="posting.php" method="POST" >
 	<label for="e-name">event name</label>
 	<input  name="e-name" type="text" placeholder="name"><br><br>
 	<label for="date">event date and time</label>
 	<input name="date" type="date"><br><br>
 	<label for="venue">event venue</label>
 	<input name="venue" type="text"><br><br>
 	<label for="organizer">event organizer</label>
 	<input name="organizer" type="text"><br><br>
 	<label for="target">target group</label>
 	<input name="target" type="text"><br><br>
 	<label for="theme">event theme</label>
 	<input name="theme" type="text"><br><br>
 	<button type="success" name="post">post event</button>
 	
 </form>

 <form id="form2" action="posting.php" method="POST">
 <p><b>change event details<br>enter preferred date and venue</b></p>
 	<label for="ename">event name</label>
 	<input name="ename" type="text"><br><br>
 	<label for="edate">event date</label>
 	<input name="edate" type="text"><br><br>
 	<label for="evenue">event venue</label>
 	<input name="evenue" type="text"><br><br>
 	<button type="success" name="echange">change event</button><br><br>


 </form>
</body>
 <style type="text/css">
 body{
 	background-color: rgb(100,100,210);
 }
 #form1{
 	float: left;
 	border: solid;
 	border-width: 1px;
 	margin-left: 4%;
 	padding: 3%;
 	border-top-right-radius: 10%;
    border-bottom-right-radius: 10%;
    border-top-left-radius: 10%;
    border-bottom-left-radius: 10%;
 }
 #form1 label{
 	font-size: 20px;
 }
 #form2{
 	float: right;
 	border: solid;
 	border-width: 1px;
 	margin-right: 2%;
 	padding: 5%;
 	border-top-right-radius: 10%;
    border-bottom-right-radius: 10%;
    border-top-left-radius: 10%;
    border-bottom-left-radius: 10%;
 }
 #form label{
 	font-size: 20px;
 }

 </style>
</html>