<?php
require_once 'vendor/autoload.php';


ini_set('display_errors', 1);
error_reporting(E_ALL);

try {
    // Connect to MongoDB
    $client = new MongoDB\Client("mongodb://localhost:27017");
    $collection = $client->movies_database->internet_user;

    // Execute a query on the collection
    $result = $collection->find();

    echo "<ul>";
    // Iterate over the query results
    foreach ($result as $entry) {
        $name = $entry['name'];
        $email = $entry['email'];
        echo "<li>" . htmlspecialchars($name, ENT_QUOTES, 'UTF-8') . " - " . htmlspecialchars($email, ENT_QUOTES, 'UTF-8') . "</li>";
    }
    echo "</ul>";
} catch (Exception $e) {
    // Error handling
    echo "Error: " . htmlspecialchars($e->getMessage());
}
