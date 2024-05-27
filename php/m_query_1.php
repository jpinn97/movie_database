<?php
require_once __DIR__ . '/../vendor/autoload.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Initialize MongoDB Client
echo "Initializing MongoDB Client...<br>";
$client = new MongoDB\Client("mongodb://localhost:27017");
echo "MongoDB Client initialized.<br>";

// Select the database and collection
echo "Selecting database and collection...<br>";
$collection = $client->movies_database->movie;
echo "Database and collection selected.<br>";

// Define the aggregation pipeline
$pipeline = [
    [
        '$group' => [
            '_id' => '$genre',
            'count' => ['$sum' => 1],
            'movie' => [
                '$push' => [
                    'title' => '$title',
                    'year' => [
                        '$dateToString' => [
                            'format' => '%Y',
                            'date' => '$year'
                        ]
                    ],
                    'summary' => '$summary',
                    'producer' => [
                        'name' => '$producer.name',
                        'surname' => '$producer.surname'
                    ],
                    'roles' => '$role'
                ]
            ]
        ]
    ],
    [
        '$sort' => ['count' => -1]
    ]
];



// Perform the aggregation
echo "Performing aggregation...<br>";
try {
    $result = $collection->aggregate($pipeline);

    echo "<h1>Movie Aggregation by Genre</h1>";
    foreach ($result as $genre) {
        echo "<h2>" . htmlspecialchars($genre->_id ?? 'Unknown Genre') . " (" . htmlspecialchars((string)($genre->count ?? 0)) . " movies)</h2>";
        echo "<ul>";
        foreach ($genre->movie as $movie) {
            echo "<li>";
            // Check and handle 'title' and other fields similarly if needed
            echo "<strong>Title:</strong> " . htmlspecialchars($movie['title'] ?? 'Unknown Title') . "<br>";
            echo "<strong>Year:</strong> " . htmlspecialchars($movie['year'] ?? 'Unknown Year') . "<br>";
            echo "<strong>Summary:</strong> " . htmlspecialchars($movie['summary'] ?? 'No Summary Available') . "<br>";

            // Check if producer details are available and handle nulls
            $producerName = $movie['producer']['name'] ?? 'Unknown Name';
            $producerSurname = $movie['producer']['surname'] ?? 'Unknown Surname';
            echo "<strong>Producer:</strong> " . htmlspecialchars($producerName) . " " . htmlspecialchars($producerSurname) . "<br>";

            echo "<ul>";
            foreach ($movie['roles'] as $role) {
                $roleName = htmlspecialchars($role['roleName'] ?? 'Unknown Role');
                $artistName = htmlspecialchars($role['artist']['name'] ?? 'Unknown Artist');
                $artistSurname = htmlspecialchars($role['artist']['surname'] ?? 'Unknown Artist Surname');
                echo "<li>$roleName - $artistName $artistSurname</li>";
            }
            echo "</ul>";
            echo "</li>";
        }
        echo "</ul>";
    }
} catch (Exception $e) {
    echo "Error: " . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8');
}
