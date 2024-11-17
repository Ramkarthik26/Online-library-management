<?php
// Ensure all necessary dependencies are installed with Composer
require __DIR__ . '/vendor/autoload.php';

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;
use Ratchet\Http\HttpServer;
use Ratchet\Server\IoServer;
use Ratchet\WebSocket\WsServer;

// WebSocket server implementation
class FeedbackServer implements MessageComponentInterface {
    protected $clients;

    public function __construct() {
        $this->clients = new \SplObjectStorage;
    }

    public function onOpen(ConnectionInterface $conn) {
        $this->clients->attach($conn);
        echo "New connection! ({$conn->resourceId})\n";
    }

    public function onMessage(ConnectionInterface $from, $msg) {
        foreach ($this->clients as $client) {
            if ($from !== $client) {
                $client->send($msg);
            }
        }
    }

    public function onClose(ConnectionInterface $conn) {
        $this->clients->detach($conn);
        echo "Connection {$conn->resourceId} has disconnected\n";
    }

    public function onError(ConnectionInterface $conn, \Exception $e) {
        echo "An error has occurred: {$e->getMessage()}\n";
        $conn->close();
    }
}

// Run WebSocket server in the background
$pid = pcntl_fork();
if ($pid == -1) {
    die('could not fork');
} else if ($pid) {
    // parent process
} else {
    // child process
    $server = IoServer::factory(
        new HttpServer(
            new WsServer(
                new FeedbackServer()
            )
        ),
        8080
    );

    $server->run();
    exit;
}

// Start session and include database connection
session_start();
include("connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['comment'])) {
    $comment = mysqli_real_escape_string($db, $_POST['comment']);
    $query4 = "INSERT INTO feedback (username, comment) VALUES('Admin', '$comment')";
    if (mysqli_query($db, $query4)) {
        $context = new ZMQContext();
        $socket = $context->getSocket(ZMQ::SOCKET_PUSH, 'my pusher');
        $socket->connect("tcp://localhost:5555");

        $data = array(
            'username' => 'Admin',
            'comment' => $comment
        );

        $socket->send(json_encode($data));
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            width: 1470px;
            height: 800px;
            background-image: url("feedback.jpg");
            font-family: auto;
        }
        table tr:hover {
            background-color: grey;
        }
        table tr {
            font-size: large;
        }
        .scroll {
            width: 100%;
            height: 200px;
            overflow: auto;
        }
        .box3 {
            width: 900px;
            height: 300px;
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
    <a href="issue2.php">Issue Information</a>
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

    <div id="fbox3" class="box3">
        <h4 style="margin:25px; padding: 5px;">Give Solutions for Student Suggestions</h4>
        <form action="" method="post" onsubmit="sendFeedback(event)">
            <div class="login">
                <input type="text" style="width: 600px; height:110px;" name="comment" placeholder="Write Something..." required><br><br>
                <button name="submit">SUBMIT</button><br><br>
            </div>
        </form>
        <div class="scroll">
            <table class="table table-bordered"></table>
        </div>
    </div>
</div>

<script>
let socket = new WebSocket("ws://localhost:8080");

socket.onopen = function(event) {
    console.log("Connected to WebSocket server");
};

socket.onmessage = function(event) {
    let message = JSON.parse(event.data);
    displayMessage(message.username, message.comment);
};

socket.onclose = function(event) {
    console.log("Disconnected from WebSocket server");
};

socket.onerror = function(error) {
    console.log("WebSocket error: " + error.message);
};

function sendFeedback(event) {
    event.preventDefault();
    let comment = document.querySelector('input[name="comment"]').value;
    sendMessage('Admin', comment);
}

function sendMessage(username, comment) {
    let message = {
        username: username,
        comment: comment
    };
    socket.send(JSON.stringify(message));
}

function displayMessage(username, comment) {
    let table = document.querySelector(".table");
    let row = table.insertRow();
    let cell1 = row.insertCell(0);
    let cell2 = row.insertCell(1);
    cell1.innerHTML = "<b>" + username + "</b>";
    cell2.innerHTML = comment;
}
</script>
</body>
</html>
