<?php
	session_start();
	if(!isset($_SESSION['username'])){
		header("Location: index.php");
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
	<script type="text/javascript" src="js.js"></script>
</head>
<body>
	<form id="form">
		<input type="text" name="title" placeholder="Title" id="title"><br><br>
		<textarea cols="70%" rows="5%" id="suggestion" name="suggestion" placeholder="Enter your suggestion..."></textarea><br><br>
		<input type="text" id="owner" name="owner" value="<?php echo $_SESSION['name'];?>" readonly><br><br>
		<input type="button" id="go" name="go" value="Suggest" onclick="loader()">
	</form>
	<div id="topmost"></div>
	<div id="container"></div>
	<hr>
		<h2>Previous suggestions</h2>
	<hr>
</body>
</html>
<?php
echo "<script type='text/javascript'></script>";
$db=new PDO("mysql:host=localhost;dbname=fine","root","");
$query=$db->query("SELECT * FROM suggestions ORDER BY `id` DESC");
$row=$query->fetchAll();
$stylediv="display:none";
$styletextarea="background:white;border-radius:10px";
foreach ($row as  $value) {
	$textarea=$value[0]*2;
	$comment_button=$value[0]*3;
	$previousComments=$value[0]*4;
	$comment_div=$value[0]*5;
	echo "<style>
			a:visited{
				color :blue;
			}
			button{
				background: blue;
				color: white;
				border-radius:10px;
				box-shadow: 2px 3px 5px;
			}
			u{
				color:orange;
			}
			b{
				color: green;
			}
		  </style>";
	echo "<u>",$value['title'],"</u>","<i> Suggested by:</i>","<b> ",$value['owner'],"</b>"," on ",$value['time'],"<br>";
	echo "<p>",$value['suggestion'],"</p>","<br>";
	echo "<button onclick='handleSeconds($value[0])'>Second(<b style='color:white' id='$value[0]'>$value[0]</b>)</button>","\t\t","<button onclick='comment($value[0])'>Comment</button>","<a href='#' onclick='previousComments($value[0])'>View previous comments</a>";
	echo "<div id='$previousComments'></div>";
	echo "<div id='$comment_div' style='$stylediv'>
			<textarea id='$textarea' cols='60%' rows='5%' style='$styletextarea' placeholder='Enter your comment here' autofocus></textarea>
			<button id='$comment_button' onclick='sendCommend($comment_button)'>Post Comment</button>
		  </div>","<hr>";
}
?>