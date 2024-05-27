<?php

$servername = "localhost";
$username = $_POST['username'];
$password = $_POST['password'];
$dbname = "movies_database";

try {
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }

    $query = "SELECT title, genre, year FROM Movie";

    // Execute the query
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        // Output data of each row
        while ($row = $result->fetch_assoc()) {
            echo "Title: " . $row["title"] . " - Genre: " . $row["genre"] . " - Year: " . $row["year"] . "<br>";
        }
    } else {
        echo "0 results";
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
} finally {
    if (isset($conn)) {
        $conn->close();
    }
}
