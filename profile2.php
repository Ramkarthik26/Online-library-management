<?php 
include("connection.php");
include("navbar2.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <style>
        .container
        {
            margin: 15px;
        }
        .wrapper
        {
            height: 600px;
            width: 500px;
            opacity: 0.7;
            margin: 20px auto;
            border-radius: 20px 20px;
            text-align: center;
            color: black;
        }
        .container
        {
            margin-left: 300px;
        }
        table tr td
        {
            font-size: 17px;
        }
        table tr
        {
            border: 2px solid white;
        }
        button
        {
            height: 43px;
            width: 90px;
            font-size: 16px;
        }
    </style>
</head>
<body style="background-color: cadetblue;">
    <div class="container">
        <form action="" method="post" name="edit" style="float: right;">
            <button style="color: white; border: 2px solid black;" name="edit">EDIT</button>
        </form>
    </div>
    <div class="wrapper">
        <?php
        if(isset($_POST['edit']))
        {
         ?>
            <script>
             window.location="edit2.php";
            </script>
         <?php
        }
           $query6="SELECT * FROM admin WHERE username='$_SESSION[login_user2]'";
           $res=mysqli_query($db,$query6);
        ?>
        <h1 style="padding-top:15px; color:black;"><b>My Profile</b></h1>
        <?php
           $row=mysqli_fetch_assoc($res);
           echo "<div><img class='img-circle profile_img' height='100px' width='100px' style='border-radius:100px 100px;' src='".$_SESSION['image2']."'></div>"
        ?>
        <div>
            <h2 style="color:black;"><b>Welcome</b></h2>
            <h2 style="color:black;"><?php echo $_SESSION['login_user2'] ?></h2>
        </div><br>
        <table class="table table-bordered" style="border: 3px solid white;" >
            <tr>
                <td><b>First Name</b></td>
                <td><?php echo $row['first'] ?></td>
            </tr>
            <tr>
                <td><b>Last Name</b></td>
                <td><?php echo $row['last'] ?></td>
            </tr>
            <tr>
                <td><b>Email ID</b></td>
                <td><?php echo $row['email'] ?></td>
            </tr>
            <tr>
                <td><b>Phone Number</b></td>
                <td><?php echo $row['phone'] ?></td>
            </tr>
        </table>
    </div>
</body>
</html>