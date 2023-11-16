<?php
require_once "database.php";

if (isset($_GET["id"])) {
    $id = $_GET["id"];

    $stmt = $conn->prepare("DELETE FROM sms WHERE id = :sms_id");

    // Bind parameter
    $stmt->bindParam(':sms_id', $id);

    // Execute the query
    $stmt->execute();

    header("location: /sent.php");
    exit;

}
if (isset($_GET["idInbox"])) {
    $id = $_GET["idInbox"];

    $stmt = $conn->prepare("DELETE FROM inbox WHERE id = :inbox_id");

    // Bind parameter
    $stmt->bindParam(':inbox_id', $id);

    // Execute the query
    $stmt->execute();

    header("location: /inbox.php");
    exit;
}


?>