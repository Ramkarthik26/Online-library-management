<?php 
include("connection.php");
include("navbar2.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ADMIN LOGIN PAGE</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<section>
    <div class="sec_student">
        <div id="loginBox" class="box1">
            <h1>ADMIN LOGIN FORM</h1>
            <form action="" name="login" method="post">
                <br>
                <div class="login">
                    <input type="text" name="username" placeholder="Enter Username" required><br><br>
                    <input type="password" name="password" placeholder="Enter Password" required><br><br>
                    <button type="submit" name="submit" style="font-family: auto;font-size:17px">LOGIN</button>
                </div>
            </form>
            <p style="color: white;">
                <br>
                <a style="color: white;text-decoration: none;" href="update_password2.php">Forgot Password?</a>
            </p>
            <?php
            if (isset($_POST['submit'])) {
                $username = mysqli_real_escape_string($db, $_POST['username']);
                $password = mysqli_real_escape_string($db, $_POST['password']);
                
                $query = "SELECT * FROM admin WHERE username='$username'";
                $res = mysqli_query($db, $query);

                if (mysqli_num_rows($res) == 0) {
                    echo "<strong style='color:red;font-size:17px;'>Incorrect Username or Password.</strong>";
                    ?>
                    <script>document.getElementById('loginBox').style.height ='365px';</script>
                    <?php
                } else {
                    $row = mysqli_fetch_assoc($res);
                    $stored_hashed_password = $row['password'];

                    if (password_verify($password, $stored_hashed_password)) {
                        $_SESSION['login_user2'] = $username;
                        $_SESSION['image2'] = $row['image_path'];
                        // Set the cookie for session management
                        setcookie('login_user2', $username, time() + (86400 * 30), "/"); 
                        ?>
                        <script>
                            window.location = "index2.php";
                        </script>
                        <?php
                    } else {
                        echo "<strong style='color:red;font-size:17px;'>Incorrect Username or Password.</strong>";
                        ?>
                        <script>document.getElementById('loginBox').style.height ='365px';</script>
                        <?php
                    }
                }
            }
            ?>
        </div>
    </div>
</section>

</body>
</html>
