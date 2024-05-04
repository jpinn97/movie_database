<?php
require_once 'vendor/autoload.php'; // Ensure this path is correct


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
        // Ensure that 'name' and 'email' fields exist in the documents
        $name = $entry['name'] ?? 'No name';
        $email = $entry['email'] ?? 'No email';
        echo "<li>" . htmlspecialchars($name) . " - " . htmlspecialchars($email) . "</li>";
    }
    echo "</ul>";
} catch (Exception $e) {
    // Error handling
    echo "Error: " . htmlspecialchars($e->getMessage());
}
?>
