<?php 
include("connection.php");
include("navbar.php"); 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body
        {
            width: 1470px;
            height: 800px;
            background-image: url("feedback.jpg");
            font-family: auto;
        }
        .sidenav {
            height: 100%;
            width: 0;
            margin-top:  100px;
            position: fixed;
            z-index: 1;
            top: 0;
            left: 0;
            background-color: #111;
            overflow-x: hidden;
            transition: 0.5s;
            padding-top: 60px;
        }
        .sidenav a {
            padding: 8px 8px 8px 32px;
            text-decoration: none;
            font-size: 25px;
            color: #818181;
            display: block;
            transition: 0.3s;
        }
        .sidenav a:hover {
            color: #f1f1f1;
        }
        .sidenav .closebtn {
            position: absolute;
            top: 0;
            right: 25px;
            font-size: 36px;
            margin-left: 50px;
        }
        #main {
            transition: margin-left .5s;
            padding: 14px;
        }
        @media screen and (max-height: 450px) {
            .sidenav {padding-top: 15px;}
            .sidenav a {font-size: 18px;}
        }
        table tr:hover
        {
            background-color: grey;
        }
        table tr {
            font-size: large;
        }
        .scroll
        {
            width: 100%;
            height: 200px;
            overflow: auto;
        }
        .box3
        {
            width: 900px;
            height: 300px;
        }
    </style>
</head>
<body>
<div id="mySidenav" class="sidenav">
    <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
    <?php
    if(isset($_SESSION['login_user'])) {
        ?>
        <div style="color: white;margin-left:30px">
            <?php
            if(isset($_SESSION['image'])) {
                echo "<img class='img-circle profile_img' height='70px' width='70px' src='".$_SESSION['image']."'>";
            }
            echo "<strong style='font-size:20px'>&nbsp;&nbsp;".$_SESSION['login_user']."</strong>";
            ?>
        </div><br>
        <a href="profile.php">Profile</a>
    <?php
    }
    ?>
    <a href="request.php">Book Request</a>
    <a href="recommendation.php">Recommendation</a>
</div>

<div id="main">
<span style="font-size:26px; cursor:pointer; color: white;" onclick="openNav()">&#9776; OPEN</span>

<script>
function openNav() {
  document.getElementById("mySidenav").style.width = "250px";
  document.getElementById("main").style.marginLeft = "250px";
}

function closeNav() {
  document.getElementById("mySidenav").style.width = "0";
  document.getElementById("main").style.marginLeft= "0";
}
</script>

    <!---Side Navbar--->

    <div id="fbox3" class="box3">

    <?php
        if(isset($_SESSION['login_user']))
        {
            ?>
                <h4 style="margin:25px; padding: 5px;"> If you have any suggestions or question please comment below.</h4>
        <form action="" method="post">
            <div class="login">
            <input type="text" style="width: 600px; height:110px;" name="comment" placeholder="Write Something..." required><br><br>
            <button name="submit">SUBMIT</button><br><br>
            </div>
        </form>
            <?php
                ?>
                  <div class="scroll">
                <?php
            if(isset($_POST['submit']))
            {
                  $comment = mysqli_real_escape_string($db, $_POST['comment']);
                  $query4="INSERT INTO feedback (username,comment) VALUES('$_SESSION[login_user]', '$comment')";
                if(mysqli_query($db,$query4))
                {
                    $show="SELECT username,comment FROM `feedback` ORDER BY `feedback`.`f_id` ASC";
                    $res=mysqli_query($db,$show);
                    ?>
           <table class="table table-bordered">
            <?php
                while($row=mysqli_fetch_assoc($res))
                {
            ?>
                   <tr>
                    <td><b><?php echo $row['username']  ?></b></td>
                    <td><?php echo $row['comment']  ?></td>
                   </tr>
            <?php
                }
                ?>
           </table>
                    <script>document.getElementById('fbox3').style.height ='500px';</script>
           <?php
                } 
            }
            else
            {
              $show="SELECT username,comment FROM `feedback` ORDER BY `feedback`.`f_id` ASC";
              $res=mysqli_query($db,$show);
              ?>
   <table class="table table-bordered">
    <?php
             while($row=mysqli_fetch_assoc($res))
             {
    ?>
           <tr>
            <td><b><?php echo $row['username'] ?></b></td>
            <td><?php echo $row['comment']  ?></td>
           </tr>
    <?php
             }
        ?>
   </table>
        <script>document.getElementById('fbox3').style.height ='500px';</script>
   <?php
            }
        }
        else
        {
            echo "<br><strong style='color:red;font-size:28px;margin-left: 10px; font-family:auto;'>You have to login first.</strong>";
        }
           ?>
        </div>
    </div>
</body>
</html>