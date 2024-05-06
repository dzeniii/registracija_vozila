<?php

$host = "localhost:3306";
$username = $_POST["user"];
$password = $_POST["password"];
$dbname = "reg_vozila";

mysqli_connect($host, $username, $password, $dbname);

if(mysqli_connect_errno()) {

    die("Connection error: " . mysqli_connect_error());
}

echo "Connection successful";