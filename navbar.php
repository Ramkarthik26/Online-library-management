<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NAVBAR</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

    <style>
        .navbar-inverse {
            background-color: #222;
            border-color: #080808;
            margin: 0px;
            width: 1470px;
        }

        @media (min-width: 768px) {
            .navbar {
                border-radius: 0px;
            }
        }

        .navbar {
            position: relative;
            min-height: 50px;
            border: 1px solid transparent;
        }

        .h1,
        .h2,
        .h3,
        .h4,
        .h5,
        .h6,
        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            font-family: auto;
            font-weight: 100;
            line-height: 1.1;
            color: white;
            font-size: x-large;
        }

        ul li a {
            font-size: large;
        }

        button:hover {
            color: yellow;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-inverse" style="background-color: black;height: 100px;">
        <div class="container-fluid" style="padding-top: 20px;">
            <div class="navbar-header" style="font-weight: bold;font-family: auto;">
                <a style="font-size: 25px;color: wheat;" class="navbar-brand active">ONLINE LIBRARY MANAGEMENT</a>
            </div>
            <ul class="nav navbar-nav" style="padding-left: 25px;font-family: auto;">
                <li><a href="index.php">HOME</a></li>
                <li><a href="books.php">BOOKS</a></li>
                <li><a href="feedback.php">FEEDBACK</a></li>
            </ul>

            <?php if (isset($_SESSION['login_user']) || isset($_COOKIE['login_user'])) : ?>
                <ul class="nav navbar-nav" style="font-family: auto;">
                    <li><a href="profile.php">PROFILE</a></li>
                </ul>
                <ul class="nav navbar-nav navbar-right" style="padding-right: 10px;font-family: auto;">
                    <li>
                        <div class="profile" style="color: white;margin-top:10px;margin-right:10px">
                            <?php
                            $username = isset($_SESSION['login_user']) ? $_SESSION['login_user'] : $_COOKIE['login_user'];
                            $image_path = isset($_SESSION['image']) ? $_SESSION['image'] : '';

                            if (!empty($image_path)) {
                                echo "<img class='img-circle profile_img' height='40px' width='40px' src='$image_path'>";
                            }
                            echo "<strong style='font-size:20px'><a href='profile.php' style='text-decoration:none; color:white;'>&nbsp;&nbsp;$username</a></strong>";
                            ?>
                        </div>
                    </li>
                    <li><a href="logout.php"><span class="glyphicon glyphicon-log-out"> LOG-OUT</span></a></li>
                </ul>
            <?php else : ?>
                <ul class="nav navbar-nav navbar-right" style="padding-right: 10px;font-family: auto;">
                    <li><a href="student.php"><span class="glyphicon glyphicon-log-in"> LOGIN</span></a></li>
                    <li><a href="registration.php"><span class="glyphicon glyphicon-user"> SIGN-UP</span></a></li>
                </ul>
            <?php endif; ?>
        </div>
    </nav>
</body>
</html>
