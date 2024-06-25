<?php
session_start();

include 'database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $price = $_POST['price'];
    
    // Use backticks around column name `Price (R)`
    $sql = "INSERT INTO services (ServiceName, `Price (R)`) VALUES ('$name', '$price')";
    
    if ($mysqli->query($sql) === TRUE) {
        header("Location: services.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $mysqli->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Service</title>
    <link rel="stylesheet" href="home.css">
</head>
<body>
    <div class="sidebar">
        <img class="logo" src="IGUGULETHU LOGO.png" alt="Igugulethu Logo">
        <ul>
            <li><a href="adminhome.php">Dashboard</a></li>
            <li><a href="services.php">Services</a></li>
            <li><a href="users.php">Users</a></li>
            <li><a href="admin-logout.php">Log out</a></li>
        </ul>
    </div>
    <div class="content">
        <h1>Add Services</h1>
        <form method="post">
            <label for="name">Service Name:</label>
            <input type="text" id="name" name="name" required>
            <label for="price">Price (R):</label>
            <input type="number" id="price" name="price" required>
            
            <button type="submit">Add Service</button>
        </form>
    </div>
</body>
</html>
