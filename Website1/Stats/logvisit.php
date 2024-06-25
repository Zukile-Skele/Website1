<?php

function logVisit($page) {
    $host = "localhost:3307";
    $username = "root";
    $password = "";
    $dbname = "login_db";

    $mysqli = new mysqli($host, $username, $password, $dbname);

    if ($mysqli->connect_errno) {
        die("Connection error " . $mysqli->connect_error);
    }

    $page = $mysqli->real_escape_string($page);

    $sql = "INSERT INTO traffic (page) VALUES ('$page')";

    if (!$mysqli->query($sql)) {
        die("Error logging visit: " . $mysqli->error);
    }

    $mysqli->close();
}

// Call the function on each page load, passing the current page's name
logVisit('logvisit.php'); 
?>
