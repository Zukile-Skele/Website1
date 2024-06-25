<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['Logout-button'])) {
        session_destroy();
        header('Location: user-admin.php'); // Redirect to the admin login page
        exit();
    } elseif (isset($_POST['Stay-button'])) {
        header('Location: adminhome.php'); // Redirect to the home page or the page you want to stay on
        exit();
    }
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
    <form action="admin-logout.php" method="post">
    <button type="submit" name="Logout-button">Yes, log out</button>
    <button type="submit" name="Stay-button">No, stay</button>
    </form>
<div class="Logo"><img src="IGUGULETHU LOGO.png" alt="">
</div>
</div>

</body> 
</html>
