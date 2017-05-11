<!DOCTYPE html>
<html>
<head>
	<title>news</title>
</head>
<body>
  <form id="form"action="posting.php" method="POST">
  <br>
    <label for="title">title</label><br>
    <input name="title" type="text" required><br><br>
    <label for="content">content</label><br>
    <textarea width="9" height="5" name="content"></textarea><br><br>
    <button name="news">news</button>
  	

  </form>
</body>
<style type="text/css">
 body{
  background-color: rgb(100,100,210);
 }
 #form{
  float: left;
  border: solid;
  border-width: 1px;
  padding: 2%;
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