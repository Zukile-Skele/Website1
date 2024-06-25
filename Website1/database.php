<?php

$host="localhost:3307";
$username="root";
$password="";
$dbname="login_db";

$mysqli = new mysqli($host, $username, $password, $dbname);

if($mysqli->connect_errno) {
    die ("Connection error ". $mysqli->connect_error);
}

return($mysqli);