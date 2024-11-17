<?php
include("connection.php");
include("navbar2.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>REGISTRATION PAGE</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .box2
        {
            height: 650px;
        }
    </style>
</head>

<body>
    <section>
        <div class="sec_sign">
            <div class="box2" id="reg">
                <h1 style="font-size: 21px;">ADMIN REGISTRATION FORM</h1>
                <form action="" name="registration" method="post" enctype="multipart/form-data">
                    <br>
                    <div class="login">
                        <input type="text" name="first" placeholder="First Name" required><br><br>
                        <input type="text" name="last" placeholder="Last Name"><br><br>
                        <input type="text" name="username" placeholder="Username" required><br><br>
                        <input type="password" name="password" placeholder="Password" required><br><br>
                        <input type="file" name="image" style="padding-top: 6px;margin-left: 20px;" accept="image/png, image/jpeg" required><br>
                        <input type="password" name="confirm_password" placeholder="Confirm Password" required><br><br>
                        <input type="email" name="email" placeholder="Email ID" required><br><br>
                        <input type="phone" name="phone" placeholder="Phone Number" required><br><br>
                        <button type="submit" name="submit" style="font-family: auto;font-size:17px">SUBMIT</button><br>
                    </div>
                </form>
            <?php
            if (isset($_POST['submit']))
                {
                    $count=0;
                    $sql='SELECT username FROM admin';
                    $res=mysqli_query($db,$sql);

                    while($row=mysqli_fetch_assoc($res))
                    {
                        if($row['username']==$_POST['username'])
                        {
                            $count=$count+1;
                        }
                    }

                    $first = mysqli_real_escape_string($db, $_POST['first']);
                    $last = mysqli_real_escape_string($db, $_POST['last']);
                    $username = mysqli_real_escape_string($db, $_POST['username']);
                    $password = mysqli_real_escape_string($db, $_POST['password']);
                    $confirm_password = mysqli_real_escape_string($db, $_POST['confirm_password']);
                    $email = mysqli_real_escape_string($db, $_POST['email']);
                    $phone = mysqli_real_escape_string($db, $_POST['phone']);

                if($count==0)
                {
                    if ($password == $confirm_password) 
                    {
                        if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
                            $image = $_FILES['image'];
                            $imageTmpName = $image['tmp_name'];
                            $imageType = mime_content_type($imageTmpName);
                            $allowedTypes = ['image/png', 'image/jpeg'];
                            if (in_array($imageType, $allowedTypes)) {
                                $uploadDir = 'uploads/';
                                if (!is_dir($uploadDir)) 
                                {
                                    mkdir($uploadDir, 0777, true);
                                }

                                $imageExtension = pathinfo($image['name'], PATHINFO_EXTENSION);
                                $imageName = uniqid() . '.' . $imageExtension;
                                $imagePath = $uploadDir . $imageName;

                                if (move_uploaded_file($image['tmp_name'], $imagePath)) {
                                    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                                    $query = "INSERT INTO admin (first, last, username, password, image_path, email, phone) VALUES ('$first', '$last', '$username', '$hashed_password', '$imagePath', '$email', '$phone')";
                                    if (mysqli_query($db, $query)) {
                                        ?>
                                        <script>
                                            window.location="registration2.php";
                                            alert("Registered Successfully");
                                        </script>
                                        <?php
                                    } else {
                                        echo "<p>Error: " . mysqli_error($db) . "</p>";
                                    }
                                } else {
                                    echo "<p style='color:red;font-size:19px;background-color: transparent;'>Failed to move uploaded file.</p>";
                                    ?>
                                    <script>document.getElementById('reg').style.height ='662px';</script>
                                    <?php
                                }
                            } else {
                                echo "<p style='color:red;font-size:19px;background-color: transparent;'>Invalid file type. Only PNG and JPEG are allowed.</p>";
                                ?>
                                <script>document.getElementById('reg').style.height ='662px';</script>
                                <?php
                            }
                        } else {
                            echo "<p style='color:red;font-size:19px;background-color: transparent;'>File upload failed. Please try again.</p>";
                            ?>
                            <script>document.getElementById('reg').style.height ='662px';</script>
                            <?php
                        }
                     }
                    else 
                    {
                        echo "<p style='color:red;font-size:19px;background-color: transparent;'>Passwords do not match. Please try again.</p>";
                        ?>
                        <script>document.getElementById('reg').style.height ='662px';</script>
                        <?php
                    }
                }
                else
                {
                    echo "<p style='color:red;font-size:19px;background-color: transparent;'>The Username already exists.</p>";
                    ?>
                    <script>document.getElementById('reg').style.height ='662px';</script>
                    <?php
                }
            }
            ?>
            </div>
        </div>
    </section>
</body>
</html>

<?php
mysqli_close($db);
?>
