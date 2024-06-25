<?php
session_start();

include 'database.php';

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id == 0) {
    die("Invalid Service ID");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $price = $_POST['price'];

    // Use prepared statements to prevent SQL injection
    $sql = "UPDATE services SET ServiceName=?, Price=? WHERE ServiceID=?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("sdi", $name, $price, $id);

    if ($stmt->execute()) {
        header("Location: services.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
} else {
    // Select service details for editing
    $sql = "SELECT * FROM services WHERE ServiceID=?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $service = $result->fetch_assoc();
    } else {
        echo "Service not found.";
    }
}
?>

<!DOCTYPE html>
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
        <li><a href="orders.php">Orders</a></li>
        <li><a href="settings.php">Settings</a></li>
        <li><a href="logout.php">Logout</a></li>
    </ul>
</div>
<div class="content">
    <h1>Edit Service</h1>
    <form method="post">
        <label for="name">Service Name:</label>
        <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($service['ServiceName']); ?>" required>
        <label for="price">Price:</label>
        <input type="text" id="price" name="price" value="<?php echo htmlspecialchars($service['Price']); ?>" required>
        <button type="submit">Update Service</button>
    </form>
</div>
</body>
</html>
