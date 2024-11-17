<?php
include("connection.php");
include("navbar2.php");

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/SMTP.php';

if(isset($_SESSION['login_user2'])) {
    // Assuming navbar2.php sets up session-related data
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Approve Page</title>
    <style>
        body {
            background-image: url("request.png");
            height: 800px;
            font-family: auto;
        }
        .sidenav {
            height: 100%;
            width: 0;
            margin-top: 100px;
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
        .container {
            padding: 10px;
            margin: 100px auto;
            width: 500px;
            height: 380px;
            background-color: black;
            opacity: 0.8;
            color: white;
            border-radius: 20px 20px;
            text-align: center;
        }
        .scroll {
            width: 100%;
            height: 230px;
            overflow: auto;
        }
        input {
            font-size: 17px;
        }
        th {
            text-align: center;
        }
    </style>
</head>
<body>
<div id="mySidenav" class="sidenav">
  <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
  <?php
  if(isset($_SESSION['login_user2'])) {
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
  <a href="">Issue Information</a>
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
    <h1>APPROVE REQUEST</h1><br><br>
    <form action="" class="approve" method="post">
        <input type="text" name="approve" placeholder="Yes or No" required><br><br>
        <input type="date" name="issue" placeholder="Issue Date" required><br><br>
        <input type="date" name="return" placeholder="Return Date" required><br><br>
        <button name="submit" style="width:100px;">SUBMIT</button>
    </form>
</div>
</div>

<?php
if(isset($_POST['submit'])) 
{
    $query = "UPDATE issue_book SET approve = '$_POST[approve]', issue = '$_POST[issue]', `return` = '$_POST[return]' WHERE username='$_SESSION[username]' and book_id='$_SESSION[book_id]'";
    $res = mysqli_query($db, $query);

    if($res) 
    {
        $query2 = "UPDATE books SET quantity = quantity-1 WHERE book_id='$_SESSION[book_id]'";
        $res2 = mysqli_query($db, $query2);

        $query3 = "SELECT quantity FROM books WHERE book_id='$_SESSION[book_id]'";
        $res3 = mysqli_query($db, $query3);

        while($row = mysqli_fetch_assoc($res3)) {
            if($row['quantity'] == 0) {
                $query4 = "UPDATE books SET status = 'Not Available' WHERE book_id='$_SESSION[book_id]'";
                $res4 = mysqli_query($db, $query4);
            }
        }

        $student_email_query = "SELECT email FROM register WHERE username = '$_SESSION[username]'";
        $student_email_result = mysqli_query($db, $student_email_query);
        if (!$student_email_result) {
            die('Query Error: ' . mysqli_error($db));
        }
        
        $student_email_row = mysqli_fetch_assoc($student_email_result);
        $student_email = $student_email_row['email'];

        $admin_email_query = "SELECT email FROM admin WHERE username = '$_SESSION[login_user2]'"; 
        $admin_email_result = mysqli_query($db, $admin_email_query);
        if (!$admin_email_result) {
            die('Query Error: ' . mysqli_error($db));
        }
        $admin_email_row = mysqli_fetch_assoc($admin_email_result);
        $admin_email = $admin_email_row['email'];

        $subject = "Book Approval Confirmation";
        $message = "
        <html>
        <body>
            <h2>Library Management System</h2>
            <p>Dear ".$_SESSION['login_user2'].",</p><br>
            <p>Your book request has been approved by the admin.</p><br>
            <p><strong>Issue Date: </strong> ".$_POST['issue']."</p>
            <p><strong>Return Date: </strong> ".$_POST['return']."</p><br>
            <h2 style='text-align: center;'>THANK YOU!</h2>
        </body>
        </html>
        ";

        $mail=new PHPMailer(true);
        $mail->isSMTP();
        $mail->Host='smtp.gmail.com';
        $mail->SMTPAuth=true;
        $mail->Username= $admin_email;
        $mail->Password='fspkfdfaccmncoyw';
        $mail->SMTPSecure='ssl';
        $mail->Port=465;

        $mail->setFrom($admin_email);
        $mail->addAddress($student_email);
        $mail->isHTML(true);
        $mail->Subject=$subject;
        $mail->Body=$message;
        $mail->send();
            ?>
            <script>
                alert("Updated Successfully and Email Sent");
                window.location = "request2.php";
            </script>
            <?php
    } else {
        ?>
        <script>
            alert("Failed to Update Data");
            window.location = "request2.php";
        </script>
        <?php
    }
}
?>
</body>
</html>
