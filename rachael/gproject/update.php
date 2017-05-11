<!DOCTYPE html>
<html>
<head>
	<title>update table</title>
</head>
<body>
  <form action="posting.php" method="POST">
   <label for="admission">admission number</label>
   <input name="admission" type="text" required><br><br>
   <label for="phone">current contact</label>
   <input name="phone" type="text" required><br><br>
   <label for="phone2">preferred contact</label>
   <input name="phone2" type="text" required><br><br>
   <label for="email">current email</label>
   <input name="email" type="text" required><br><br>
   <button type="submit" name="update">UPDATE</button><br><br>
  </form>

   <p>lecturers only</p>
  <form action="posting.php" method="POST">
   <label for="id">ID number</label>
   <input name="id" type="text"><br><br>
   <label for="contact">current contact</label>
   <input name="contact" type="text"><br><br>
   <label for="pcontact">preferred contact</label>
   <input name="pcontact" type="text"><br><br>
   <button type="submit" name="change">CHANGE</button>
  </form>
</body>
</html>