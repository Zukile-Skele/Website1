<?php
session_start();

include 'database.php';

$sql = "SELECT * FROM users";
$result = $mysqli->query($sql);
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Service</title>
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
<table style="font-size: 25px; font-family: Arial;">
            <thead style="color: forestgreen; font-size: 30px;">
                <tr>
                <th style="text-align: left;">UserID</th>
            <th style="text-align: left; padding: 20px;">Username</th>
            <th style="text-align: left; padding: 20px;">Email</th>
            <th style="text-align: center; padding: 20px;">Actions</th>
                
                    
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>";
                echo "<td style='text-align: left; padding: 10px;'>" . $row['UserID'] . "</td>";
                echo "<td style='text-align: left; padding: 10px;'>" . $row['Username'] . "</td>";
                echo "<td style='text-align: left; padding: 10px;'>" . $row['email'] . "</td>";
                
                echo "<td style='text-align: center; padding: 10px;'>";
                echo "<a href='edit_service.php?id=" . $row['UserID'] . "' class='btn'>Edit</a> ";
                echo "<a href='remove_service.php?id=" . $row['UserID'] . "' class='btn'>Remove</a>";
                echo "</td>";
                echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='4'>No users found</td></tr>";
                }
                ?>
            </tbody>
        </table>
        <footer>
        <p>© 2024 Igugulethu Consulting(PTY)LTD</p>
        </footer>
    