<?php
$host = "localhost"; 
$user = "bloguser";       // your DB username
$pass = "Blog@12345";           // your DB password
$dbname = "blogdb";

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Database Connection Failed: " . $conn->connect_error);
}
?>
