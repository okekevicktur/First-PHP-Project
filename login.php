<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Sign In</title>
</head>
<body>
    <div class="container">
        <!-- <img src="https://www.kindpng.com/picc/m/651-6513429_transparent-login-icons-png-circle-png-download.png" alt="Transparent Login Icons Png - Circle, Png Download@kindpng.com"> -->
        <img src="./image/print.png" alt="icon">
        <form action="includes/signin.inc.php" class="wrapper" method="POST">
            <input type="text" name="uid" class="details" placeholder="username">
            <input type="password" name="pass" class="details" placeholder="password">
            <button class="btn-signin" name="submit">Login</button>
            
        </form>
        <?php
            if (isset($_SESSION['userId'])){
                echo '<p> You are logged In </p>';
            }else{
                echo '<p> You are logged Out </p>';

            }
        ?>
    </div>
</body>
</html>