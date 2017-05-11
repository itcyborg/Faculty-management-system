<!DOCTYPE html>
<html>
<head>
	<title>voting</title>
</head>
<body>
  <form action="posting.php" method="POST" enctype="multipart/form-data">
    <label for="code">aspirant code</label>
    <input type="text" name="code"><br><br>
    <label for="name"d>aspirant name</label>
    <input type="text" name="name"><br><br>
    <label for="position">aspiring position</label>
    <input type="text" name="position"><br><br>
    <label for="image">aspirant image</label>
    <input type="file" name="image"><br><br>
  	<button type="submit" name="upload">upload</button>

  </form>

</body>
</html>