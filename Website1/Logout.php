<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['Logout-button'])) {
        session_destroy();
        header('Location: user-admin.php'); // Redirect to the user/admin decision page
        exit();
    } elseif (isset($_POST['Stay-button'])) {
        header('Location: Home.html'); // Redirect to the home page or the page you want to stay on
        exit();
    }
}
$user = null;

if (isset($_SESSION['username'])) {
    $mysqli = require __DIR__ . "/database.php";

    // Use prepared statements to prevent SQL injection
    $sql = "SELECT * FROM users WHERE Username = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("s", $_SESSION['username']);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
    } else {
        // Handle the case where no user is found
        echo "No user found with username: " . htmlspecialchars($_SESSION['username']);
        exit();
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html>  
<head>  
<title>Logout</title>    
<link rel = "stylesheet" type = "text/css" href = "services.css">   
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head> 
<body>
<div class="Logout">
<h1>Do you want to log out?</h1>
    <form action="Logout.php" method="post">
    <button type="submit" name="Logout-button">Yes, log out</button>
    <button type="submit" name="Stay-button">No, stay</button>
    </form>
<div class="Logo"><img src="IGUGULETHU LOGO.png" alt="">
</div>
</div>

</body> 
</html>
