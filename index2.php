<?php
  session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online Library</title>
    <link rel="stylesheet" href="style.css">
    <style>
nav
{
    float: right;
    word-spacing: 35px;
    padding: 0px 15px;
}
nav li
{
    display: inline-block;
    margin-top: 40px;
}
nav li a
{
    color: white;
    text-decoration: none;
    font-size: 17px;
}
.image
{
    margin-left: 220px;
    margin-top: 20px;
}
.image img
{
    padding: 12px;
}
.footer
{
    display: flex;
    justify-content: center;
    align-items: center;
}
    </style>
</head>
<body>
    <div class="wrapper">
        <header>
            <div class="book">
                <img src="manual.png" height="110px" width="140px" style="padding-left: 120px;padding-top: 5px;">
                <h1 style="color: wheat;margin: 0px;">ONLINE LIBRARY MANAGEMENT</h1>
            </div>

            <?php
               if(isset($_SESSION['login_user2']))
               {
                ?>
                 <ul class="nav navbar-nav navbar-right" style="padding-right:10px; margin-top: 24px; font-family: auto;text-align:right;margin-bottom:0px;">
                <li>
                <div style="color: white;margin-right:10px; display: flex; justify-content: end;">
                    <div style="margin-bottom:10px;">
                    <?php
                    if(isset($_SESSION['image2']))
                    {
                        echo "<img class='img-circle profile_img' height='40px' width='40px' style='border-radius:100px 100px;' src='".$_SESSION['image2']."'>";
                    }
                    ?>
                    </div>
                    <div style="font-size:20px; margin-top: 10px;">
                    <?php
                    echo "<strong>&nbsp;&nbsp;".$_SESSION['login_user2']."</strong>";
                    ?>
                    </div>
                </div>
                </li></ul>
                   <nav>
                <ul style="padding-bottom: 30px;margin:0px;">
                    <li><a href="index2.php">HOME</a></li>
                    <li><a href="books2.php">BOOKS</a></li>
                    <li><a href="feedback2.php">FEEDBACK</a></li>
                    <li><a href="registration2.php">SIGN-UP</a></li>
                    <li><a href="logout2.php">LOG-OUT</a></li>
                </ul>
            </nav>
                <?php
               }
               else
               {
                ?>
                <nav>
                <ul>
                    <li><a href="index.php">HOME</a></li>
                    <li><a href="books2.php">BOOKS</a></li>
                    <li><a href="admin.php">LOGIN</a></li>
                    <li><a href="feedback2.php">FEEDBACK</a></li>
                </ul>
            </nav>
            <?php
               }
            ?>
        </header>

        <section>
            <div class="sec_index">
                <div class="box">
                    <h1><b>WELCOME TO LIBRARY</b></h1><br>
                    <h2><b>Opens at: 9:00 AM</b></h2>
                    <h2><b>Closes at: 5:00 PM</b></h2>
                </div>
            </div>
        </section>
        <footer>
            <div style="margin-top: 20px;"><strong style="color: white;margin-left: 1085px; font-size: 24px;">Contact us through social media</strong></div>
            <div class="footer">
            <p style="text-align: center;padding-top: 15px;color: white;font-size: 23px;margin: 0px;margin-left: 500px;">
                Email:&nbsp; onlinelibrary@gmail.com <br><br>
                Phone Number:&nbsp; 8838840290
            </p>
            <div class="image">
            <a href="https://ptuniv.edu.in" title="google"><img src="google.png" height="40px" width="40px"></a>
            <a href="https://www.flaticon.com/free-icons/facebook" title="facebook"><img src="facebook.png" height="40px" width="40px"></a>
            <a href="https://www.instagram.com/puducherry_tech_university" title="instagram"><img src="instagram.png" height="40px" width="40px"></a>
            <a href="https://in.linkedin.com/school/ptu-puducherry" title="linkedin"><img src="linkedin.png" height="40px" width="40px"></a>
        </div>
            </div>
        </footer>
    </div>
</body>
</html>