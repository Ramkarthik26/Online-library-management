<?php 
include("connection.php");
include("navbar2.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Page</title>
    <style>
        body
        {
            background-color: cadetblue;
        }
        .container
        {
            margin-top: 40px;
            display: flex;
            flex-direction: column;
            height: 650px;
            width: 600px;
            text-align: center;
            justify-content: center;
            align-items: center;
        }
        label h5
        {
            color: black;
            font-size: 22px;
            margin-right: 190px;
        }
        input
        {
            background-color: white;
        }
        button
        {
            height: 40px;
            width: 80px;
            font-size: 15px;
            color: white;
            background-color: #020d0c;
            border: 2px solid black;
        }
    </style>
</head>
<body>
  <div class="container">
    <h1 style="text-align: center; color:black;font-size:30px;">EDIT PROFILE</h1>

    <?php
       $sql="SELECT * FROM admin WHERE username='$_SESSION[login_user2]'";
       $result=mysqli_query($db,$sql);
       while($row=mysqli_fetch_assoc($result))
       {
        $first=$row['first'];
        $last=$row['last'];
        $email=$row['email'];
        $phone=$row['phone'];
       }
    ?>

    <div  style="text-align: center; color: white;">
        <h1>Welcome</h1>
        <h1><?php echo $_SESSION['login_user2'] ?></h1>
    </div><br>
    <div style="margin-bottom: 60px;">
     <form action="" method="post" enctype="multipart/form-data">
        <label><h5>First Name:</h5></label><br>
        <input type="text" name="first" placeholder="First Name" required value="<?php echo $first ?>"><br>
        <label><h5>Last Name:</h5></label><br>
        <input type="text" name="last" placeholder="Last Name" required value="<?php echo $last ?>"><br>
        <label><h5 style="margin-right: 210px;">Email ID:</h5></label><br>
        <input type="text" name="email" placeholder="Email ID" required value="<?php echo $email ?>"><br>
        <label><h5 style="margin-right: 150px;">Phone Number:</h5></label><br>
        <input type="text" name="phone" placeholder="Phone Number" required value="<?php echo $phone ?>"><br><br>
        <button name="save">SAVE</button>
     </form>
    </div>
  </div>

  <?php
     if(isset($_POST['save']))
     {
        $first1=$_POST['first'];
        $last1=$_POST['last'];
        $email1=$_POST['email'];
        $phone1=$_POST['phone'];

        $sql1="UPDATE admin SET first='$first1', last='$last1', email='$email1', phone='$phone1' WHERE username='$_SESSION[login_user2]'";
        if(mysqli_query($db,$sql1))
        {
            ?>
               <script>
                alert("Saved Successfully");
                window.location="profile2.php";
               </script>
            <?php
        }
     }
  ?>
</body>
</html>