<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
<h1>modify details</h1>
   <form id="sform" action="modifystudent.php" method="POST">
   <label for="admission">admission number</label>
   <input name="admission" type="text" placeholder="admission"required><br><br>
   <label for="phone">current contact</label>
   <input name="phone" type="text"  placeholder="current contact" required><br><br>
   <label for="phone2">preferred contact</label>
   <input name="phone2" type="text" placeholder="preferred contact" required><br><br>
   <label for="email">current email</label>
   <input name="email" type="text"placeholder="email" required><br><br><br>
   <button type="submit" name="update">UPDATE</button><br><br>
  </form>
</body>
</html>
<?php 
if (isset($_POST['update'])) {
 $admi=$_POST['admission'];
 $phone=$_POST['phone'];
 $phone2=$_POST['phone2'];
 $email=$_POST['email'];

 $db=new PDO("mysql:host=localhost;dbname=fine","root","");
 $db->query("UPDATE `students` SET `contact`='$phone2' WHERE `adm_number`='$admi'");
}
 ?>