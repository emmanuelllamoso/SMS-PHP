<?php
// we will insert the data into database
$servername = "localhost";
$username = "root";
$dbpassword = "Emman12pogi";
$database = "phpcrud";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $dbpassword);
    // Set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Perform database operations here
    // Prepare the SQL statement

} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>