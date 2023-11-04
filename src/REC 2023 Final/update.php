<!-- 
  PROGRAMMERS: Muhammad Zaman, Aryan Chandra   
  DATE: November 3, 2023
  COMMENTS: 
-->
<?php
    // Database connection parameters
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

    if (isset($_GET['table']) && isset($_GET['id']) && isset($_GET['amount'])) {
        $tableName = $_GET['table'];
        $id = $_GET['id'];
        $updatedAmount = $_GET['amount'];

        $updatedAmount = floatval($updatedAmount);
        
        $sql = "UPDATE $tableName SET Amount = $updatedAmount WHERE ID = $id";
        $result = $conn->query($sql);

        if ($result) {
            echo "Update successful";
        } else {
            echo "Update failed: " . $conn->error;
        }
    }

    $conn->close();
?>
