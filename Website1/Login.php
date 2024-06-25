
    <?php
   $is_invalid= false;

   if($_SERVER["REQUEST_METHOD"] ==="POST") {
    require_once "database.php";
    $sql = sprintf("SELECT * FROM users 
                    WHERE email = '%s'",
                    $mysqli->real_escape_string($_POST["email"]));

                   $result= $mysqli->query($sql);
                   $user= $result->fetch_assoc();

           if($user) {
            if(password_verify($_POST["password"], $user["Password"])){
                session_start();
                session_regenerate_id();
                $_SESSION["username"]= $user["username"];
                header("Location: Home.html");
                exit;
               
            }
           }     
           
           $is_invalid = true;
                
   }

   

    
        
    ?>
    
    <!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <link rel="stylesheet" href="login.css">
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/light.css">
</head>
<body>
  <div class="wrapper">
    
    <form method="post" action="Login.php">
        <h1>Login</h1>
        
        <?php if ($is_invalid): ?>
            <em>Login is invalid</em>
            <?php endif; ?>
        <div class="input-box">
            <i class='bx bxs-envelope'></i>
            <input type="email" placeholder="email" name="email" required
            value="<?=htmlspecialchars($_POST["email"] ??"") ?>">
        </div>
        <div class="input-box">
            <i class='bx bxs-lock-alt'></i>
            <input type="password" placeholder="Password" name="password" required>
        </div>
        
        <button type="submit" class="button" name="login">Log in</button>
        <p>Don't have an account? <a href="Sign Up.html">Sign Up</a></p>
    </form>
  </div>
</body>
</html>
