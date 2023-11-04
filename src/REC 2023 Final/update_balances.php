<?php
// Database connection settings
session_start();
$dbHost = "localhost";
$dbUser = "mtz774";
$dbPassword = "!rKH5HdA";
$dbName = "mtz774"; 

// Create a database connection
$conn = new mysqli($dbHost, $dbUser, $dbPassword, $dbName);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $cardType = $_POST["cardType"];
    $balance = $_POST["balance"];

    $sql = "UPDATE Balance SET balance = ? WHERE type = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ds", $balance, $cardType);
    
    if ($stmt->execute()) {
        header("Location: homepage.php");
        exit();
    } else {
        echo "Error updating balance: " . $stmt->error;
    }
    
    $stmt->close();
}

// Close the database connection
$conn->close();
?>
