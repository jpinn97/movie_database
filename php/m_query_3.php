<?php
require_once 'vendor/autoload.php';

ini_set('display_errors', 1);
error_reporting(E_ALL);

try {
    // Initialize MongoDB Client
    $client = new MongoDB\Client("mongodb://localhost:27017");

    // Access the view in the 'movies_database' database
    $collection = $client->movies_database->movies_by_year_view;

    // Perform the query using find() since it's a view
    $result = $collection->find();

    echo "<ul>";
    // Iterate over the query results
    foreach ($result as $data) {
        
        $year = $data['_id'];
        $count = $data['count'];

        echo "<li>Year: " . htmlspecialchars($year) . " - Count: " . htmlspecialchars($count) . "</li>";
    }
    echo "</ul>";
} catch (Exception $e) {
    // Output error message if something goes wrong
    echo "Error: " . htmlspecialchars($e->getMessage());
}
