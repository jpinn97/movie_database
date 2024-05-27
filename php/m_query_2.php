<?php
require_once __DIR__ . '/../vendor/autoload.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

echo "Initializing MongoDB Client...<br>";
$client = new MongoDB\Client("mongodb://localhost:27017");
echo "MongoDB Client initialized.<br>";

echo "Selecting database and collection...<br>";
$collection = $client->movies_database->movie;
echo "Database and collection selected.<br>";

$currentYear = 2024;

$pipeline = [
    ['$unwind' => '$role'],
    ['$addFields' => [
        'role.artist_age' => [
            '$subtract' => [
                $currentYear,
                '$role.artist.DOB'
            ]
        ]
    ]],
    ['$group' => [
        '_id' => '$genre',
        'average_age' => [
            '$avg' => '$role.artist_age'
        ]
    ]],
    ['$project' => [
        '_id' => 0,
        'genre' => '$_id',
        'average_age' => 1
    ]]
];

$result = $collection->aggregate($pipeline);

echo "<table border='1'>";
echo "<tr><th>Genre</th><th>Average Age</th></tr>";
foreach ($result as $entry) {
    echo "<tr><td>" . htmlspecialchars($entry['genre']) . "</td><td>" . round(htmlspecialchars($entry['average_age'])) . "</td></tr>";
}
echo "</table>";
?>
