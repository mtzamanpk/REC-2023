<!-- 
  PROGRAMMERS: Muhammad Zaman, Aryan Chandra   
  DATE: November 3, 2023
  COMMENTS: 
-->
<?php
    session_start();

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Get the user ID from the session
        if (isset($_SESSION['user_id'])) {
            $userId = $_SESSION['user_id'];
            
            // Get the table name and amount from the submitted form
        if (isset($_POST['wantsAmount'])) {
            $tableName = "Wants";
            $name = $_POST['wantsName'];
            $date = $_POST['wantsDate'];
            $amount = $_POST['wantsAmount'];
            $paymentMethod = $_POST['wantsPaymentMethod'];
        } elseif (isset($_POST['needsAmount'])) {
            $tableName = "Needs";
            $name = $_POST['needsName'];
            $date = $_POST['needsDate'];
            $amount = $_POST['needsAmount'];
            $paymentMethod = $_POST['needsPaymentMethod'];
        } elseif (isset($_POST['expensesAmount'])) {
            $tableName = "Expenses";
            $name = $_POST['expensesName'];
            $date = $_POST['expensesDate'];
            $amount = $_POST['expensesAmount'];
            $paymentMethod = $_POST['expensesPaymentMethod'];
        }
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

            // Insert the data into the respective table
            $sql = "INSERT INTO $tableName (user_id, Name, Date, Amount, PaymentMethod) VALUES (?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("issds", $userId, $name, $date, $amount, $paymentMethod);

            if ($stmt->execute()) {
                // Data added successfully
                header("Location: homepage.php");
                exit();
            } else {
                // Error handling, you can redirect to an error page or display an error message
                echo "Error adding data to the table.";
            }

            // Close the database connection
            $conn->close();
        }
    }
?>
