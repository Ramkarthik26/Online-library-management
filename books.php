<?php 
include("connection.php");
include("navbar.php"); 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Books</title>
    <style>
        body {
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
        table tr {
            font-size: 
            large;
        }
        input {
            font-size: 17px;
        }
    </style>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#load-books').click(function(event) {
                event.preventDefault();
                var searchTerm = $('#search').val();
                var department = $('#department').val();
                
                var endpoint = 'load_books.php?search=' + searchTerm + '&department=' + department;
                
                $.ajax({
                    url: endpoint,
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        var bookList = $('#book-list tbody');
                        bookList.empty(); 
                        if (response.length > 0) {
                            $.each(response, function(index, book) {
                                var html = '<tr>' +
                                    '<td>' + book.book_id + '</td>' +
                                    '<td>' + book.name + '</td>' +
                                    '<td>' + book.author + '</td>' +
                                    '<td>' + book.edition + '</td>' +
                                    '<td>' + book.status + '</td>' +
                                    '<td>' + book.quantity + '</td>' +
                                    '<td>' + book.department + '</td>' +
                                    '</tr>';
                                bookList.append(html);
                            });
                        } else {
                            bookList.append('<tr><td colspan="7" style="color:red; font-size:22px; text-align:center;">No books found</td></tr>');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching books:', error);
                    }
                });
            });
        });
    </script>
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

    <h1 style="color:navy; text-align: center;font-size:33px;">LIST OF BOOKS</h1><br>
    <div style="display:flex;width: 1450px;">
        <form id="search-form" class="navbar-form" style="padding: 0px;" method="get">
            <div>
                <input id="search" style="color: black; background-color: whitesmoke; border:3px solid black; border-radius:7px 7px; height: 45px;" type="text" name="search" placeholder="Search Books...">
                <input id="department" style="color: black; background-color: whitesmoke; border:3px solid black; border-radius:7px 7px; height: 45px; margin-left: 10px;" type="text" name="department" placeholder="Department">
                <button type="button" id="load-books" style="height: 41px; width: 50px; border: 2px solid black; color: white;" name="searchb">
                    <span class="glyphicon glyphicon-search"></span>
                </button>
            </div>
        </form>
        <?php
        if(isset($_SESSION['login_user'])) {
            ?>
            <form action="" class="navbar-form" method="post" name="form1" style="padding: 0px; padding-left: 150px;">
                <div>
                    <input style="color: black; background-color: whitesmoke; border:3px solid black; border-radius:7px 7px; height: 45px;" type="text" name="book_id" placeholder="Book ID" required>
                    <button type="submit" name="request" style="height: 41px; width: 80px; border: 2px solid black; color: white; font-size: 17px;">
                        Request
                    </button>
                </div>
            </form><br>
        <?php
        }
        ?>
    </div>
    <table id="book-list" class="table table-bordered table-hover">
        <thead style="background-color:dimgrey; color: white;">
            <tr>
                <th>ID</th>
                <th>Book-Name</th>
                <th>Author's name</th>
                <th>Edition</th>
                <th>Status</th>
                <th>Quantity</th>
                <th>Department</th>
            </tr>
        </thead>
        <tbody>
        <?php
       if(!isset($_GET['searchb']))
       {
        $query3="SELECT * FROM `books`";
        $res=mysqli_query($db,$query3);
        ?>
            <?php
                while($row=mysqli_fetch_assoc($res))
                {
            ?>
                   <tr>
                    <td><?php echo $row['book_id'] ?></td>
                    <td><?php echo $row['name']  ?></td>
                    <td><?php echo $row['author']  ?></td>
                    <td><?php echo $row['edition']  ?></td>
                    <td><?php echo $row['status']  ?></td>
                    <td><?php echo $row['quantity']  ?></td>
                    <td><?php echo $row['department']  ?></td>
                   </tr>
            <?php
                }
            }
            if(isset($_POST['request']))
            {
              $query10="INSERT INTO issue_book VALUES ('$_SESSION[login_user]','$_POST[book_id]','','','')";
              $res=mysqli_query($db,$query10);
              ?>
                 <script>
                  alert("Requested Successfully");
                  window.location="request.php";
                 </script>
              <?php
            }
            ?>
            <!-- Books will be dynamically loaded here -->
        </tbody>
    </table>
</div>
</body>
</html>
