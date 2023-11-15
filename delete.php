<?php
if (isset($_GET["id"])) {
    $id = $_GET["id"];

    $servername = "localhost";
    $username = "root";
    $password = "Emman12pogi";
    $database = "phpcrud";
    try {
        $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
        // Set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        // Perform database operations here
        // Prepare the SQL statement

        $stmt = $conn->prepare("DELETE FROM sms WHERE id = :sms_id");

        // Bind parameter
        $stmt->bindParam(':sms_id', $id);

        // Execute the query
        $stmt->execute();

        header("location: /sent.php");
        exit;

    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
}


?>