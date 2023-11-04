<!-- 
  PROGRAMMERS: Muhammad Zaman, Aryan Chandra   
  DATE: November 3, 2023
  COMMENTS: 
-->
<?php
// Database connection setup
$dbHost = "localhost";
$dbUser = "mtz774";
$dbPassword = "!rKH5HdA";
$dbName = "mtz774"; // Use the name of your database

$conn = new mysqli($dbHost, $dbUser, $dbPassword, $dbName);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle user registration
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["username1"]) && isset($_POST["psw1"])) {
    $username = $_POST["username1"];
    $password = $_POST["psw1"];

    // Check if the username is already registered
    $stmt_check = $conn->prepare("SELECT username FROM users WHERE username = ?");
    $stmt_check->bind_param("s", $username);
    $stmt_check->execute();
    $stmt_check->store_result();

    if ($stmt_check->num_rows == 0) {
        // username is not registered, insert into the database
        $stmt_check->close();

        $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
        $stmt->bind_param("ss", $username, $password);

        if ($stmt->execute()) {
            // Registration successful
            header("Location: homepage.php"); // Redirect to the homepage
            exit();
        } else {
            // Registration failed
            echo "Registration failed. Please try again.";
        }

        $stmt->close();
    } else {
        // username is already registered
        echo "username is already registered. Please use a different username.";
    }
}

// Handle user login
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["loginusername"]) && isset($_POST["loginPassword"])) {
    $loginusername = $_POST["loginusername"];
    $loginPassword = $_POST["loginPassword"];

    $stmt = $conn->prepare("SELECT password FROM users WHERE username = ?");
    $stmt->bind_param("s", $loginusername);
    $stmt->execute();
    $stmt->bind_result($storedPassword);
    $stmt->fetch();
    $stmt->close();

    if ($loginPassword === $storedPassword) {
        // Login successful
        header("Location: homepage.php"); // Redirect to the homepage
        exit();
    } else {
        // Login failed
        echo "Login failed. Please check your username and password.";
    }
}

$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <link rel="stylesheet" href="./css/style.css">
    <title>REC 2023</title>  
</head>
<body>
    <h1 class="title">Login/Registration</h1>
    <div class="container-fluid">
        <div class="accordion" id="accordionExample">
            <div class="accordion-item">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                    Login
                </button> 

                <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        <h3>Log in</h3>
                        <form id="loginForm" action="index.php" method="post">
                            <div class="mb-1">
                                <label for="username1">Username </label>
                                <input type="username" class="form-control" id="username1" name="loginusername" aria-describedby="usernameHelp" placeholder="Enter username" required>
                            </div>
                            <div class="mb-1">
                                <label for="psw1">Password</label>
                                <input type="password" class="form-control" id="psw1" name="loginPassword" placeholder="Enter Password" required>
                            </div><br/>
                            <button type="submit" class="btn btn-primary">Login</button> <br/><br/>
                        </form>
                    </div>
                </div>
            </div>

            <div class="accordion-item">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                    Register
                </button>
            
                <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                    <div class "accordion-body">
                        <h3>Sign up</h3>
                        <form id="registrationForm" action="index.php" method="post">
                            <div class="mb-1">
                                <label for="exampleInputusername1">Username </label> <br />
                                <input type="username" class="form-control" id="exampleInputusername1" name="username1" aria-describedby="usernameHelp" placeholder="Enter username" required>
                            </div>
                            <div class="mb-1">
                                <label for="InputPassword2">Password</label> <br />
                                <input type="password" class="form-control" id="InputPassword2" name="psw1" placeholder="Enter Password" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Signup</button><br/><br/>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
</body>
</html>
