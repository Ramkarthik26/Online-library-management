<?php 
include("connection.php");
include("navbar2.php"); 
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
    height: 440px;
    background-color: black;
    opacity: 0.9;
    color: white;
    border-radius: 20px 20px;
    text-align: center;
}
.scroll
{
    width: 100%;
    height: 230px;
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
                <a href="profile2.php">Profile</a>
  <?php
  }
  ?>
  <a href="request2.php">Book Request</a>
  <a href="issue2.php">Issue Information</a>
  <a href="expired.php">Expired List</a>
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
<div class="container">
<?php
if(isset($_SESSION['login_user2']))
{
        $query5="SELECT register.username,books.book_id,name,author,edition,status FROM register inner join issue_book ON register.username=issue_book.username inner join books ON issue_book.book_id=books.book_id WHERE issue_book.approve=''";
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
            ?>
            <h1 style="color:navy; text-align: center;font-size:33px; color:white">BOOK REQUEST FROM STUDENTS</h1><br><br>
       <div>
        <form action="" method="post" name="form1">
            <input type="text" name="username" placeholder="Username" required>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <input type="text" name="book_id" placeholder="Book ID" required>&nbsp;&nbsp;&nbsp;&nbsp;
            <button style="width:100px;" name="submit">SUBMIT</button>
        </form><br>
       </div>
            <div class="scroll">
           <table class="table table-bordered">
            <tr style="background-color:darkred; color: white;">
                <th>Student Username</th>
                <th>Book ID</th>
                <th>Book Name</th>
                <th>Author's Name</th>
                <th>Edition</th>
                <th>Status</th>
            </tr>
            <?php
                while($row=mysqli_fetch_assoc($res2))
                {
            ?>
                   <tr>
                    <td><?php echo $row['username'] ?></td>
                    <td><?php echo $row['book_id']  ?></td>
                    <td><?php echo $row['name']  ?></td>
                    <td><?php echo $row['author']  ?></td>
                    <td><?php echo $row['edition']  ?></td>
                    <td><?php echo $row['status']  ?></td>
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
    if(isset($_POST['submit']))
    {
        $_SESSION['username']=$_POST['username'];
        $_SESSION['book_id']=$_POST['book_id'];
        ?>
           <script>
            window.location="approve.php";
           </script>
        <?php
    }
    ?>
    </div>
    </div>
</body>
</html>