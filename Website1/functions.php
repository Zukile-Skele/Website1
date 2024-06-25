<?php


if(empty($_POST["username"])) {
    die ("Username is required");
}

if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {

    die ("Valid email is required.");
}

if(strlen($_POST["password"]) <8 ) {
    die ("Password requires at least 8 characters.");
}

if(!preg_match("/[a-z]/i", $_POST["password"])) {
    die ("Password must contain at least 1 letter.");
}

if(!preg_match("/[1-9]/", $_POST["password"])) {
    die ("Password must contain at least 1 number.");
}

$password_hash = password_hash($_POST["password"], PASSWORD_DEFAULT );

$mysqli= require __DIR__ ."/database.php";

$sql= "INSERT INTO users (Username, email, Password)
        VALUES (?, ?, ?)";

    $stmt = $mysqli->stmt_init();
    if (!$stmt->prepare($sql)) {
        die ("SQL error: " . $mysqli->error);
    }
$stmt->bind_param("sss",
                    $_POST["username"],
                    $_POST["email"],
                    $password_hash);

$stmt->execute();

header("Location: Signup Success.html");
exit
?>