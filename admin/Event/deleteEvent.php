<?php
session_start();

include('connectToDatabase.php');

$conn = new database;

if ($conn->getDatabase()->connect_error) {
    die("การเชื่อมต่อฐานข้อมูลล้มเหลว: " . $conn->getDatabase()->connect_error);
}

if (isset($_GET['deleteEvent'])) {
    $eCode = $_GET['eCode'];

    if (!empty($eCode)) {
        $sql = "DELETE FROM Event WHERE eCode = ?";
        $stmt = $conn->getDatabase()->prepare($sql);

        $stmt->bind_param("s", $eCode);

        if ($stmt->execute()) {
            header("Location: event.php");
            exit();
        } else {
            echo "Error executing SQL query: " . $stmt->error;
        }
    } else {
        echo "Invalid eCode";
    }
} else {
    header("Location: event.php");
    exit();
}

$conn->closeConnection();
?>