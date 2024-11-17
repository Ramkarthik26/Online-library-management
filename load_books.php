<?php
include("connection.php");

if(isset($_GET['search']) && isset($_GET['department'])) {
    $searchTerm = $_GET['search'];
    $department = $_GET['department'];

    
    $searchTerm = mysqli_real_escape_string($db, $searchTerm);
    $department = mysqli_real_escape_string($db, $department);

    $query = "SELECT * FROM books WHERE name LIKE '%$searchTerm%' AND department LIKE '%$department%'";
    $query2 = "SELECT * FROM books";
    
    $result = mysqli_query($db, $query);
    $result2 = mysqli_query($db, $query2);

    if(mysqli_num_rows($result) > 0) {
        $books = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $books[] = array(
                'book_id' => $row['book_id'],
                'name' => $row['name'],
                'author' => $row['author'],
                'edition' => $row['edition'],
                'status' => $row['status'],
                'quantity' => $row['quantity'],
                'department' => $row['department']
            );
        }
        echo json_encode($books);
    } else {
        
        $books = array();
        echo json_encode($books);
    }
} else {

    
    $error = array('error' => 'Missing search parameters');
    echo json_encode($error);
    $books = array();
        while ($row = mysqli_fetch_assoc($result2)) {
            $books[] = array(
                'book_id' => $row['book_id'],
                'name' => $row['name'],
                'author' => $row['author'],
                'edition' => $row['edition'],
                'status' => $row['status'],
                'quantity' => $row['quantity'],
                'department' => $row['department']
            );
        }
        echo json_encode($books);
}

mysqli_close($db);
?>
