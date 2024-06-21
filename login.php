<?php
session_start();
// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Database configuration
$servername = "localhost";
$username = "root"; // replace with your database username
$password = ""; // replace with your database password
$dbname = "userdb";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get input values and sanitize them
    $user = htmlspecialchars($_POST['username']);
    $passwrd = htmlspecialchars($_POST['password']);

    // Debugging output
    echo "Username entered: $user<br>";
    echo "Password entered: $passwrd<br>";

    // Prepare and bind
    $stmt = $conn->prepare("SELECT password FROM userdetails WHERE userid = ?");
    if ($stmt === false) {
        die("Prepare failed: " . $conn->error);
    }
    $stmt->bind_param("s", $user);

    // Execute the query
    if ($stmt->execute()) {
        $stmt->store_result();

        // Debugging output
        echo "Number of rows found: " . $stmt->num_rows . "<br>";

        // Check if the user exists
        if ($stmt->num_rows > 0) {
            $stmt->bind_result($stored_password);
            $stmt->fetch();

            // Debugging output
            echo "Stored password: $stored_password<br>";

            // Verify the password
            if ($passwrd === $stored_password) {
                // Debugging output
                echo "Password match<br>";
                // Redirect to the protected area of the website
                $_SESSION['username'] = $user;
                header("Location: index.html");
                exit();
            } else {
                // Debugging output
                echo "Password does not match<br>";
                // Redirect to the signup page
                header("Location: signup.html");
                exit();
            }
        } else {
            // Debugging output
            echo "User not found<br>";
            // Redirect to the signup page
            header("Location: signup.html");
            exit();
        }
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();
} else {
    echo "Form not submitted<br>";
}
?>
