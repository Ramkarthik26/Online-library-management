<?php 
include("connection.php");
include("navbar2.php"); 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Books</title>
    <style>
        body
        {
            background-image: url("addbooks.jpg");
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
  color: white;
}

@media screen and (max-height: 450px) {
  .sidenav {padding-top: 15px;}
  .sidenav a {font-size: 18px;}
}
.wrapper
{
    height: 750px;
    width: 1440px;
    margin-top: 20px;
    display: flex;
    justify-content: center;
    align-items: center;
}
.box2
{
    height: 620px;
    width: 420px;
    background-color: black;
    text-align: center;
    opacity: 0.8;
    color: white;
    padding-top: 20px;
    border-radius: 20px 20px;
}
input
{
    background-color: whitesmoke;
    border: 1px solid black;
    color: black;
}
button
{
    height: 45px;
    width: 100px;
    font-size: 16px;
    color: white;
    background-color: #020d0c;
    border: 2px solid black;
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
  <a href="add.php">Add Books</a>
  <?php
  }
  ?>
  <a href="request2.php">Book Request</a>
  <a href="issue2.php">Issue Information</a>
</div>

<div id="main">
  <span style="font-size:26px; cursor:pointer;background-color:black;border-radius:8px 8px;padding:3px;" onclick="openNav()">&#9776; OPEN</span>
  <div class="wrapper">
  <div class="box2">
    <h2>ADD NEW BOOKS</h2><br><br>
    <form action="" method="post">
        <input type="number" name="book_id" placeholder="Book ID" required><br><br>
        <input type="text" name="name" placeholder="Book Name" required><br><br>
        <input type="text" name="author" placeholder="Author's Name" required><br><br>
        <input type="text" name="edition" placeholder="Edition" required><br><br>
        <input type="text" name="status" placeholder="Status" required><br><br>
        <input type="number" name="quantity" placeholder="Quantity" required><br><br>
        <input type="text" name="department" placeholder="Department" required><br><br>
        <button name="add" style="background-color:teal;">ADD</button>
    </form>
  <?php
     if(isset($_POST['add']))
     {
      $count = 0;
                $sql = 'SELECT book_id FROM books';
                $res = mysqli_query($db, $sql);

                while ($row = mysqli_fetch_assoc($res)) {
                    if ($row['book_id'] == $_POST['book_id']) {
                        $count++;
                    }
                }
        $book_id = mysqli_real_escape_string($db, $_POST['book_id']);
        $name = mysqli_real_escape_string($db, $_POST['name']);
        $author = mysqli_real_escape_string($db, $_POST['author']);
        $edition = mysqli_real_escape_string($db, $_POST['edition']);
        $status = mysqli_real_escape_string($db, $_POST['status']);
        $quantity = mysqli_real_escape_string($db, $_POST['quantity']);
        $department = mysqli_real_escape_string($db, $_POST['department']);
        if($count==0)
        {
            $query8="INSERT INTO books VALUES('$book_id','$name','$author','$edition','$status','$quantity','$department')";
            mysqli_query($db,$query8);
            ?>
               <script>
                 alert("Book added Successfully");
               </script>
            <?php
        }
        else
        {
          echo "<p style='color:red;font-size:19px;background-color: transparent;'>This book ID already exists.</p>";
        }
     }
  ?>
    </div>
    </div>

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