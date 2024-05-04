<?php
require_once 'vendor/autoload.php';

ini_set('display_errors', 1);
error_reporting(E_ALL);



try {
    $client = new MongoDB\Client("mongodb://localhost:27017");
    $collection = $client->movies_database->internet_user;

    $result = $collection->find();

    echo "<ul>";
    foreach ($result as $entry) {
        echo "<li>" . $entry['name'] . " - " . $entry['email'] . "</li>";
    }
    echo "</ul>";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>
