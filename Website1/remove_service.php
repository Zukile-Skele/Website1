<?php
session_start();

include 'database.php';

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $ServiceID = intval($_GET['id']);

    // Prepare the SQL delete statement
    $sql = "DELETE FROM services WHERE ServiceID = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("i", $ServiceID);

    if ($stmt->execute()) {
        header("Location: services.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $mysqli->error;
    }
} else {
    echo "Invalid Service ID.";
}
?>
