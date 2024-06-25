<?php

function showStats() {
    $host = "localhost:3307";
    $username = "root";
    $password = "";
    $dbname = "login_db";

    $mysqli = new mysqli($host, $username, $password, $dbname);

    if ($mysqli->connect_errno) {
        die("Connection error " . $mysqli->connect_error);
    }

    $sql = "SELECT page, COUNT(*) as visits FROM traffic GROUP BY page";
    $result = $mysqli->query($sql);

    if ($result->num_rows > 0) {
        echo "<h2>Website Traffic Stats</h2>";
        echo "<table>";
        echo "<tr><th>Page</th><th>Visits</th></tr>";

        while ($row = $result->fetch_assoc()) {
            echo "<tr><td>" . htmlspecialchars($row['page']) . "</td><td>" . $row['visits'] . "</td></tr>";
        }

        echo "</table>";
    } else {
        echo "No traffic data available.";
    }

    $mysqli->close();
}
?>

