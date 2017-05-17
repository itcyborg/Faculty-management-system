<!doctype html>
<html>
<link rel="stylesheet" href="../assets/css/admin.css">
<style type="text/css">

    form {
        margin-left: 35%;
        margin-top: 15%;
    }
</style>
<body>
<div id="status"></div>
<form id="loginForm" method="post" action="../functions/constructor.php">
    <input type="email" id="email" placeholder="Email" name="email"><br>
    <input type="password" id="password" placeholder="Password" name="password"><br><br>
    <input type="submit" value="Login" name="login">
</form>
<script type="text/javascript" src="../assets/js/jquery.js"></script>
<script type="text/javascript">
    $('#loginForm').submit(function (e) {
        e.preventDefault();
        var email = $('#email').val();
        var password = $('#password').val();
        $.ajax({
            url: '../functions/constructor.php',
            type: 'POST',
            data: {
                'login': 1,
                'email': email,
                'password': password,
                'synche': 1
            },
            dataType: 'JSON',
            beforeSend: function () {
                $('#status').html("Checking and verifying details. Please wait.");
            },
            success: function (data) {
                if (data.error) {
                    $('#status').html(data.msg);
                } else {
                    window.location.href = data.url;
                }
            }
        });
    })
</script>
</body>
</html>
