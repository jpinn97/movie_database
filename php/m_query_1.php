<?php
require_once __DIR__ . '/../vendor/autoload.php'; // Adjust the path to the autoload file

use MongoDB\Client;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

try {
    // Initialize MongoDB Client
    echo "Initializing MongoDB Client...<br>";
    $client = new MongoDB\Client("mongodb://localhost:27017");
    echo "MongoDB Client initialized.<br>";

    // Select the database and collection
    echo "Selecting database and collection...<br>";
    $collection = $client->movies_database->movies;
    echo "Database and collection selected.<br>";

    // Define the aggregation pipeline
    $pipeline = [
        [
            '$group' => [
                '_id' => '$genre',
                'count' => ['$sum' => 1],
                'movies' => [
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
    $result = $collection->aggregate($pipeline);
    echo "Aggregation performed.<br>";

    // Output the results
    echo "<ul>";
    foreach ($result as $doc) {
        $genre = htmlspecialchars($doc['_id'], ENT_QUOTES, 'UTF-8');
        $count = htmlspecialchars((string)$doc['count'], ENT_QUOTES, 'UTF-8');
        echo "<li><strong>{$genre}</strong> ({$count} movies)";
        echo "<ul>";
        foreach ($doc['movies'] as $movie) {
            $title = htmlspecialchars($movie['title'], ENT_QUOTES, 'UTF-8');
            $year = htmlspecialchars($movie['year'], ENT_QUOTES, 'UTF-8');
            $summary = htmlspecialchars($movie['summary'], ENT_QUOTES, 'UTF-8');
            $producerName = htmlspecialchars($movie['producer']['name'], ENT_QUOTES, 'UTF-8');
            $producerSurname = htmlspecialchars($movie['producer']['surname'], ENT_QUOTES, 'UTF-8');

            echo "<li>";
            echo "<strong>Title:</strong> {$title}<br>";
            echo "<strong>Year:</strong> {$year}<br>";
            echo "<strong>Summary:</strong> {$summary}<br>";
            echo "<strong>Producer:</strong> {$producerName} {$producerSurname}<br>";
            echo "<strong>Roles:</strong><ul>";
            foreach ($movie['roles'] as $role) {
                $roleName = htmlspecialchars($role['roleName'], ENT_QUOTES, 'UTF-8');
                $artistName = htmlspecialchars($role['artist']['name'], ENT_QUOTES, 'UTF-8');
                $artistSurname = htmlspecialchars($role['artist']['surname'], ENT_QUOTES, 'UTF-8');
                echo "<li>{$roleName} - {$artistName} {$artistSurname}</li>";
            }
            echo "</ul></li>";
        }
        echo "</ul></li>";
    }
    echo "</ul>";
} catch (MongoDB\Driver\Exception\Exception $e) {
    echo "MongoDB Error: " . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8');
} catch (Exception $e) {
    echo "Error: " . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8');
}
