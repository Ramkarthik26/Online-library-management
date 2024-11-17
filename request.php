<?php 
include("connection.php");
include("navbar.php"); 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Request Page</title>
    <style>
        body
        {
            background-image: url("request.png");
            height: 800px;
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
.container
{
    padding: 10px;
    margin: 60px auto;
    width: 900px;
    height: 350px;
    background-color: black;
    opacity: 0.9;
    color: white;
    border-radius: 20px 20px;
    text-align: center;
}
.scroll
{
    width: 100%;
    height: 210px;
    overflow: auto;
}
th
{
    text-align: center;
}
    </style>
</head>
<body>
<div id="mySidenav" class="sidenav">
  <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
  <?php
  if(isset($_SESSION['login_user']))
  {
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
  <a href="recommendation.php">Recommendations</a>
</div>

<div id="main">
  <span style="font-size:26px; cursor:pointer; color:white;" onclick="openNav()">&#9776; OPEN</span>

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

<div class="container">
<?php
if(isset($_SESSION['login_user']))
{
        $query5="SELECT * FROM issue_book WHERE username='$_SESSION[login_user]'";
        $res2=mysqli_query($db,$query5);
        if(mysqli_num_rows($res2)==0)
        {
            ?>
               <div class="searchbox">
            <?php
            echo "<br><br><strong style='color:red;font-size:25px;margin-left: 10px;'>There is no pending request.</strong>";
                    ?>
                    <script>document.getElementById('searchbox').style.height ='70px';</script></div><br>
                    <?php
        }
        else
        {
            ?><br>
            <h1 style="color:white; text-align: center;font-size:33px;">BOOK REQUEST</h1><br>
            <div class="scroll">
           <table class="table table-bordered">
            <tr style="background-color:darkred; color: white;">
                <th>Book ID</th>
                <th>Approve Status</th>
                <th>Issue Date</th>
                <th>Return Date</th>
            </tr>
            <?php
                while($row=mysqli_fetch_assoc($res2))
                {
            ?>
                   <tr>
                    <td><?php echo $row['book_id'] ?></td>
                    <td><?php echo $row['approve']  ?></td>
                    <td><?php echo $row['issue']  ?></td>
                    <td><?php echo $row['return']  ?></td>
                   </tr>
            <?php
                }
                ?>
           </table>
           </div>
           <?php
        }
    }
    else
    {
        echo "<br><br><strong style='color:red;font-size:25px;margin-left: 10px;'>You have to login first.</strong>";
    }
    ?>
    </div>
    </div>
</body>
</html>