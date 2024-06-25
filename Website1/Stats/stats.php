<?php

require 'showstats.php'; 



?>

<!DOCTYPE html>
<html>
<head>
    <title>Website Traffic Stats</title>
    <link rel="stylesheet" type="text/css" href="home.css"> 
</head>
<body>
<div class="sidebar">
    <img class="logo" = img src = "IGUGULETHU LOGO.png">
    <ul>
    <li><a href="adminhome.php">Dashboard</a></li>
        <li><a href="services.php">Services</a></li>
        <li><a href="users.php">Users</a></li>
        <li><a href="stats.php">Stats</a></li>
        <li><a href="admin-logout.php">Log out</a></li>
    </ul>
    </div>
    <div class="stats-container">
        <?php showStats(); ?>
    </div>
</body>
</html>
