<!DOCTYPE html>
<html>

<head>
    <title>Registracija vozila</title>
    <meta charset="UTF-8" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@picocss/pico@2/css/pico.min.css" />
</head>

<body>
    <h1>Login</h1>
    <form action="login.php" method="post">
        <label for="user">Username</label>
        <input type="text" name="user" id="user" required />

        <label for="password">Password</label>
        <input type="password" name="password" id="password" required />

        <br />
        <input type="submit" value="Log in" name="submit">
    </form>

    <?php
        function checkLogin()
        {
            if($_POST["user"] == "root" && $_POST["password"] == "1234") {

                header("Location: dbconnection.php");
            } else {

                echo 'WRONG USERNAME OR PASSWORD';
            }
        }
        if(isset($_POST['submit']))
        {
            checkLogin();
        } 
    ?>
</body>

</html>