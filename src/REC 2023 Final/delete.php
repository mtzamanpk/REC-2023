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

    // Check if the table name and ID are provided in the URL
    if (isset($_GET['table']) && isset($_GET['id'])) {
        $tableName = $_GET['table'];
        $id = $_GET['id'];

        $allowedTables = ["Wants", "Needs", "Expenses"];
        if (in_array($tableName, $allowedTables)) {

            $sql = "DELETE FROM $tableName WHERE ID = $id";
            
            if ($conn->query($sql) === TRUE) {
                
            } else {
                echo "Error deleting record: " . $conn->error;
            }
        } else {
            echo "Invalid table name.";
        }
    } else {
        echo "Invalid parameters.";
    }

    $conn->close();
?>
