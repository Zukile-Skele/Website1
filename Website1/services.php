<?php
session_start();

include 'database.php';

$sql = "SELECT * FROM services";
$result = $mysqli->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Services</title>
    <link rel="stylesheet" href="home.css">
</head>
<body>
    <div class="sidebar">
    <img class="logo" = img src = "IGUGULETHU LOGO.png">
    <ul>
    <li><a href="adminhome.php">Dashboard</a></li>
        <li><a href="services.php">Services</a></li>
        <li><a href="users.php">Users</a></li>
        <li><a href="admin-logout.php">Log out</a></li>
    </ul>
    </div>
    <div class="content">
        <h1>Manage Services</h1>
        <a href="add_services.php" class="btn" style="font-size: 30px; color:orangered;">Add Service</a>
        <table style="font-size: 25px; font-family: Arial;">
            <thead style="color: forestgreen; font-size: 30px;">
                <tr>
                
                    <th style="text-align: left; padding: 20px;">ServiceID</th>
                    <th style="text-align: left; padding: 20px;">ServiceName</th>
                    <th style="text-align: left; padding: 20px;">Price(R)</th>
                    
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td style='text-align: left; padding: 10px;'>" . $row['ServiceID'] . "</td>";
                        echo "<td style='text-align: left; padding: 10px;'>" . $row['ServiceName'] . "</td>";
                        echo "<td style='text-align: left; padding: 10px;'>" . $row['Price (R)'] . "</td>";
                        
                        echo "<td style='text-align: center; padding: 10px; color: orangered'>";
                        echo "<td><a href='edit_service.php?id=" . $row['ServiceID'] . "' class='btn'>Edit</a> ";
                        echo "<a href='remove_service.php?id=" . $row['ServiceID'] . "' class='btn'>Remove</a></td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='6'>No servicess found</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
<footer>
        <p>© 2024 Igugulethu Consulting(PTY)LTD</p>
        </footer>
</html>
