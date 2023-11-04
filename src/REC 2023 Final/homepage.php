<!-- 
  PROGRAMMERS: Muhammad Zaman, Aryan Chandra   
  DATE: November 3, 2023
  COMMENTS: We started off by drafting a Lo-Fi diagram, After that we referenced our old work and found our old labs from ense 374, special thanks to Adam Tilson for teaching us the labs,
  then we worked  
-->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE, edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <link rel="stylesheet" href="./css/style.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <title>REC 2023</title>  
</head>

<body>
    <h1><a href="logout.php">Logout here</a></h1> 
    <h1 class="title">Budget Management</h1>
    <div class="row mt-4">
        <div class="col-md-4 offset-md-4">
            <label for="dateRange">Select Date Range:</label>
                <select class="form-select" id="dateRange" name="dateRange">
                    <option value="yearly">Yearly</option>
                    <option value="monthly">Monthly</option>
                </select>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-6 mx-auto">
            <?php
            // Database connection parameters 
            session_start();
            $dbHost = "localhost";
            $dbUser = "mtz774";
            $dbPassword = "!rKH5HdA";
            $dbName = "mtz774"; // Use the name of your database

            // Create a database connection
            $conn = new mysqli($dbHost, $dbUser, $dbPassword, $dbName);

            if (isset($_SESSION['user_id'])) {
                $userId = $_SESSION['user_id']; 
            }
            // Check the connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // Function to display a table's contents 
            function displayTableForUser($conn, $tableName, $userId) {
                $sql = "SELECT * FROM $tableName WHERE user_id = $userId";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    echo "<center><h2>$tableName</h2></center>";
                    echo '<table class="table table-striped">';
                    echo "<thead><tr><th>ID</th><th>Name</th><th>Date</th><th>Amount</th><th>Payment Method</th><th>Update</th><th>Delete</th></tr></thead>";
                    echo "<tbody>";
                
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row["ID"] . "</td>";
                        echo "<td>" . $row["Name"] . "</td>";
                        echo "<td>" . $row["Date"] . "</td>";
                        echo "<td><input type='text' id='updateAmount_$row[ID]' value='" . $row["Amount"] . "'></td>";
                        echo "<td>" . $row["PaymentMethod"] . "</td>";
                        echo "<td><button type='button' class='btn btn-primary' onclick='updateAmount($row[ID], \"$tableName\")'>Update</button></td>";
                        echo "<td><button type='button' class='btn btn-danger' onclick='deleteRow($row[ID], \"$tableName\")'>Delete</button></td>";
                        echo "</tr>";
                    }
                    echo "</tbody>";
                    echo "</table>";
                } else {
                    echo "No data in $tableName table for the logged-in user. ";
                }
            }
                // Assign a credit card with an initial balance
                $creditCardBalance = 1000.00;  // Initial credit card balance
                $sqlCreditCard = "INSERT INTO Balance (user_id, type, amount) VALUES (?, 'Credit Card', ?)";
                $stmtCreditCard = $conn->prepare($sqlCreditCard);
                $stmtCreditCard->bind_param("id", $userId, $creditCardBalance);
                $stmtCreditCard->execute();
                $stmtCreditCard->close();

                // Assign a debit card with an initial balance
                $debitCardBalance = 500.00;  // Initial debit card balance
                $sqlDebitCard = "INSERT INTO Balance (user_id, type, amount) VALUES (?, 'Debit Card', ?)";
                $stmtDebitCard = $conn->prepare($sqlDebitCard);
                $stmtDebitCard->bind_param("id", $userId, $debitCardBalance);
                $stmtDebitCard->execute();
                $stmtDebitCard->close();

                echo "Credit Card Balance: $" . number_format($creditCardBalance, 2) . "<br>";
                echo "Debit Card Balance: $" . number_format($debitCardBalance, 2) . "<br>";

            if (isset($_SESSION['user_id'])) {
                $userId = $_SESSION['user_id'];
                displayTableForUser($conn, "Wants", $userId);
                displayTableForUser($conn, "Needs", $userId);
                displayTableForUser($conn, "Expenses", $userId);
            }
            // Close the database connection
            $conn->close();
            ?>
            <div>
        <canvas id="wantsChart"></canvas>
    </div>
    <script>
        // Sample data 
        var wantsData = {
            labels: ["Item 1", "Item 2", "Item 3"],
            datasets: [{
                label: "Graphs",
                data: [50, 30, 70], 
                backgroundColor: [
                    'rgba(255, 99, 132, 0.5)',
                    'rgba(54, 162, 235, 0.5)',
                    'rgba(255, 206, 86, 0.5)'
                ],
            }],
        };

        // Chart.js options
        var chartOptions = {
            responsive: true,
            maintainAspectRatio: false,
        };

        // Create a bar chart
        var wantsChart = new Chart("wantsChart", {
            type: "bar",
            data: wantsData,
            options: chartOptions,
        });
    </script>
</body>
<title>Expense Tracker</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col">
            <h3>Wants</h3>
                <form id="addWantsForm" action="addData.php" method="post" class="mx-auto" style="max-width: 300px;">
                    <div class="mb-1">
                        <label for="wantsName">Item</label>
                        <input type="text" class="form-control" id="wantsName" name="wantsName" placeholder="Enter Name" required>
                    </div>
                    <div class="mb-1">
                        <label for="wantsDate">Date</label>
                        <input type="date" class="form-control" id="wantsDate" name="wantsDate" required>
                    </div>
                    <div class="mb-1">
                        <label for="wantsAmount">Amount</label>
                        <input type="text" class="form-control" id="wantsAmount" name="wantsAmount" placeholder="Enter Amount" required>
                    </div>
                    <div class="mb-1">
                        <label for="wantsPaymentMethod">Payment Method</label>
                        <select class="form-control" id="wantsPaymentMethod" name="wantsPaymentMethod">
                            <option value="Credit Card">Credit Card</option>
                            <option value="Debit Card">Debit Card</option>
                        </select>
                    </div>
                    <button type="submit" name="addWants" class="btn btn-primary">Add to Wants</button>
                </form>
            </div>
            <div class="col">
            <h3>Needs</h3>
                <form id="addNeedsForm" action="addData.php" method="post" class="mx-auto" style="max-width: 300px;">
                    <div class="mb-1">
                        <label for="needsName">Item</label>
                        <input type="text" class="form-control" id="needsName" name="needsName" placeholder="Enter Name" required>
                    </div>
                    <div class="mb-1">
                        <label for="needsDate">Date</label>
                        <input type="date" class="form-control" id="needsDate" name="needsDate" required>
                    </div>
                    <div class="mb-1">
                        <label for="needsAmount">Amount</label>
                        <input type="text" class="form-control" id="needsAmount" name="needsAmount" placeholder="Enter Amount" required>
                    </div>
                    <div class="mb-1">
                        <label for="needsPaymentMethod">Payment Method</label>
                        <select class="form-control" id="needsPaymentMethod" name="needsPaymentMethod">
                            <option value="Credit Card">Credit Card</option>
                            <option value="Debit Card">Debit Card</option>
                        </select>
                    </div>
                    <button type="submit" name="addNeeds" class="btn btn-primary">Add to Needs</button>
                </form>
            </div>
            <div class="col">
                <h3>Expenses</h3>
                <form id="addExpensesForm" action="addData.php" method="post" class="mx-auto" style="max-width: 300px;">
                    <div class="mb-1">
                        <label for="expensesName">Item</label>
                        <input type="text" class="form-control" id="expensesName" name="expensesName" placeholder="Enter Name" required>
                    </div>
                    <div class="mb-1">
                        <label for="expensesDate">Date</label>
                        <input type="date" class="form-control" id="expensesDate" name="expensesDate" required>
                    </div>
                    <div class="mb-1">
                        <label for="expensesAmount">Amount</label>
                        <input type="text" class="form-control" id="expensesAmount" name="expensesAmount"  placeholder="Enter Amount" required>
                    </div>
                    <div class="mb-1">
                        <label for="expensesPaymentMethod">Payment Method</label>
                        <select class="form-control" id="expensesPaymentMethod" name="expensesPaymentMethod">
                            <option value="Credit Card">Credit Card</option>
                            <option value="Debit Card">Debit Card</option>
                        </select>
                     </div>
                     <button type="submit" name="addExpenses" class="btn btn-primary">Add to Expenses</button>
                </form>        
</html>
<script>
function deleteRow(id, tableName) {
    if (confirm("Are you sure you want to delete this row?")) {
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                // Page reloads after successful deletion
                location.reload();
            }
        };
        xhr.open("GET", "delete.php?table=" + tableName + "&id=" + id, true);
        xhr.send();
    }
}

function updateAmount(id, tableName) {
    var updatedAmount = document.getElementById("updateAmount_" + id).value;
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            // Page reloads after successful update
            location.reload();
        }
    };
    // Send the updated amount to the server
    xhr.open("GET", "update.php?table=" + tableName + "&id=" + id + "&amount=" + updatedAmount, true);
    xhr.send();
}
</script>