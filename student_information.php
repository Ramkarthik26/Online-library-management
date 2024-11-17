<?php 
include("connection.php");
include("navbar2.php"); 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Information</title>
    <style>
        body
        {
            background-color: darkgray;
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
table tr
{
  font-size: large;
}
input
{
  font-size: 17px;
}
    </style>
</head>
<body>
<div id="mySidenav" class="sidenav">
  <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
  <?php
  if(isset($_SESSION['login_user2']))
  {
   ?>
                <div style="color: white;margin-left:30px">
                    <?php
                    if(isset($_SESSION['image2'])) {
                        echo "<img class='img-circle profile_img' height='70px' width='70px' src='".$_SESSION['image2']."'>";
                    }
                    echo "<strong style='font-size:20px'>&nbsp;&nbsp;".$_SESSION['login_user2']."</strong>";
                    ?>
                </div><br>
  <a href="profile.php">Profile</a>
  <?php
  }
  ?>
  <a href="books.php">Books</a>
  <a href="request2.php">Book Request</a>
  <a href="issue2.php">Issue Information</a>
  <a href="expired.php">Expired List</a>
</div>

<div id="main">
  <span style="font-size:26px; cursor:pointer" onclick="openNav()">&#9776; OPEN</span>

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

    <h1 style="color:navy; text-align: center;font-size:33px;">LIST OF STUDENTS</h1><br>
        <form action="" class="navbar-form" method="post" name="form1">
            <div>
                <input style="color: black; background-color: whitesmoke; border:3px solid black; border-radius:7px 7px; height: 45px;" type="text" name="search" placeholder="Search Students Username..." required>
                <button type="submit" name="searchb" style="height: 41px; width: 50px; border: 3px solid black; color: white;">
                    <span class="glyphicon glyphicon-search"></span>
                </button>
            </div>
        </form><br>
    <?php
    if(isset($_POST['searchb']))
    {
        $query5="SELECT first,last,username,email,phone FROM register WHERE username like '%$_POST[search]%'";
        $res2=mysqli_query($db,$query5);
        if(mysqli_num_rows($res2)==0)
        {
            ?>
               <div class="searchbox">
            <?php
            echo "<strong style='color:red;font-size:17px;margin-left: 20px;'>Sorry! No Student found with that username.</strong>";
                    ?>
                    <script>document.getElementById('searchbox').style.height ='70px';</script></div><br>
                    <?php
        }
        else
        {
            ?>
           <table class="table table-bordered table-hover">
            <tr style="background-color:dimgrey; color: white;">
                <th>First Name</th>
                <th>Last Name</th>
                <th>Username</th>
                <th>Email ID</th>
                <th>Phone Number</th>
            </tr>
            <?php
                while($row=mysqli_fetch_assoc($res2))
                {
            ?>
                   <tr>
                    <td><?php echo $row['first']  ?></td>
                    <td><?php echo $row['last']  ?></td>
                    <td><?php echo $row['username']  ?></td>
                    <td><?php echo $row['email']  ?></td>
                    <td><?php echo $row['phone']  ?></td>
                   </tr>
            <?php
                }
                ?>
           </table>
           <?php
        }
    }
    else
    {
        $query3="SELECT first,last,username,email,phone FROM register ORDER BY 'username' ASC";
        $res2=mysqli_query($db,$query3);
        ?>
        <table class="table table-bordered table-hover">
         <tr style="background-color:dimgrey; color: white;">
             <th>First Name</th>
             <th>Last Name</th>
             <th>Username</th>
             <th>Email ID</th>
             <th>Phone Number</th>
         </tr>
         <?php
             while($row=mysqli_fetch_assoc($res2))
             {
         ?>
                <tr>
                 <td><?php echo $row['first']  ?></td>
                 <td><?php echo $row['last']  ?></td>
                 <td><?php echo $row['username']  ?></td>
                 <td><?php echo $row['email']  ?></td>
                 <td><?php echo $row['phone']  ?></td>
                </tr>
         <?php
             }
             ?>
        </table>
        <?php
    }
    ?>
</body>
</html>