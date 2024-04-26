<?php
$servername = "localhost";
$username = $_POST['username'];
$password = $_POST['password'];
$dbname = "movies_database";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully";

$conn->close();
