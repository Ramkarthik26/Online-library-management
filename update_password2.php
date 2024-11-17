<?php 
include("connection.php");
include("navbar2.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password</title>
    <link rel="stylesheet" href="style.css">
    <style>
.box1
{
    height: 420px;
    width: 400px;
    background-color: black;
    text-align: center;
    opacity: 0.7;
    color: white;
    padding-top: 20px;
    border-radius: 20px 20px;
}
    </style>
</head>
<body>
    <section>
        <div class="sec_student">
            <div id="loginBox" class="box1">
                <h1>CHANGE PASSWORD</h1><br><br>
                <form action="" method="post">
                    <input type="text" name="username" placeholder="Username" required><br><br>
                    <input type="email" name="email" placeholder="Email ID" required><br><br>
                    <input type="password" name="password" placeholder="New Password" required><br><br>
                    <input type="password" name="confirm_password" placeholder="Confirm Password" required><br><br>
                    <button name="submit">SUBMIT</button>
                </form>

        <?php
           if(isset($_POST['submit']))
           {
            $username = mysqli_real_escape_string($db, $_POST['username']);
            $password = mysqli_real_escape_string($db, $_POST['password']);
            $confirm_password = mysqli_real_escape_string($db, $_POST['confirm_password']);
            $email = mysqli_real_escape_string($db, $_POST['email']);

            $query2 = "SELECT * FROM admin WHERE username='$username' AND email='$email'";
            $res=mysqli_query($db,$query2);
            $count = mysqli_num_rows($res);

            if($count==0)
            {
                echo "<strong style='color:red;font-size:17px;'>Username and Email didn't match.</strong>";
                    ?>
                    <script>document.getElementById('loginBox').style.height ='445px';</script>
                    <?php
            }
            else
            {
                if ($password == $confirm_password)
                {
                    $query7="UPDATE admin SET password='$password' WHERE username='$username' AND email='$email'";
                    if (mysqli_query($db, $query7)) {
                        ?>
                        <script>
                            window.location="admin.php";
                            alert("The Password updated Successfully");
                        </script>
                        <?php
                    } else {
                        echo "<p>Error: " . mysqli_error($db) . "</p>";
                    }
                }
                else
                {
                    echo "<strong style='color:red;font-size:17px;'>Passwords didn't match.</strong>";
                    ?>
                    <script>document.getElementById('loginBox').style.height ='445px';</script>
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