<?php

$servername = "localhost";
$username = $_POST['username'];
$password = $_POST['password'];
$dbname = "movies_database";

try {
    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }

    $dropViewQuery = "DROP VIEW IF EXISTS MoviesWithActors";

    $conn->query($dropViewQuery);

    $createViewQuery = "CREATE VIEW MoviesWithActors AS 
                        SELECT m.title AS MovieTitle, m.year AS ReleaseYear, m.genre AS Genre, 
                               a.surname AS ActorSurname, a.name AS ActorName, a.DOB AS ActorDOB
                        FROM Movie m
                        JOIN Role r ON m.movieId = r.movieId
                        JOIN Artist a ON r.actorId = a.artistId";

    $conn->query($createViewQuery);

    echo "View 'MoviesWithActors' created successfully.<br>";

    $selectViewQuery = "SELECT * FROM MoviesWithActors";

    $result = $conn->query($selectViewQuery);

    if ($result->num_rows > 0) {
        echo "<h2>Results from 'MoviesWithActors' View:</h2>";
        while ($row = $result->fetch_assoc()) {
            echo "Movie Title: " . $row["MovieTitle"] . " - Genre: " . $row["Genre"] . " - Release Year: " . $row["ReleaseYear"] . "<br>";
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
