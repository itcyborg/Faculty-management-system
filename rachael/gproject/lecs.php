<!DOCTYPE html>
<html>
<head>
    <title>lecs</title>
</head>
<body>
<form action="posting.php" method="POST">
    <label for="id">ID number</label>
    <input name="id" type="text" required><br>
    <label for="name">lecturer name</label>
    <input name="name" type="text" required><br>
    <label for="department">department</label>
    <input name="dep" type="text" required><br>
    <label for="contact">contact</label>
    <input name="contact" type="number" required><br>
    <label for="email">email</label>
    <input name="email" type="text" required><br><br>
    <label for="password">password</label>
    <input name="password" type="password" required><br>
    <button type="success" value="register" name="register">register</button>
</form>

</body>
</html>