<?php
// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Database configuration
$servername = "localhost";
$username = "root"; // replace with your database username
$password = ""; // replace with your database password
$dbname = "userdb";
$dbnamei = "ArtCity";   

// Create connection to userdb
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection to userdb
if ($conn->connect_error) {
    die("Connection to userdb failed: " . $conn->connect_error);
} else {
    echo "Connected to userdb successfully<br>";
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get input values and sanitize them
    $name = htmlspecialchars($_POST['Name']);
    $phone = htmlspecialchars($_POST['Phone']);
    $place = htmlspecialchars($_POST['Place']);
    $user = htmlspecialchars($_POST['Username']);
    $passwrd = $_POST['Password'];
    $cnf_password = $_POST['CnfPassword'];

    // Debugging statement
    echo "Received input values<br>";

    // Validate passwords match
    if ($passwrd !== $cnf_password) {
        echo "Passwords do not match!";
    } else {
        // Prepare and bind for userdb
        $stmt = $conn->prepare("INSERT INTO userdetails (userid, password) VALUES (?, ?)");
        if ($stmt === false) {
            die("Prepare failed for userdb: " . $conn->error);
        }
        $stmt->bind_param("ss", $user, $passwrd); // Both userid and password should be strings

        // Execute the query for userdb
        if ($stmt->execute()) {
            echo "New record created successfully in userdb<br>";
        } else {
            echo "Error in userdb: " . $stmt->error;
        }

        // Close statement for userdb
        $stmt->close();
        // Close connection for userdb
        $conn->close();

        // Create connection to ArtCity
        $conn2 = new mysqli($servername, $username, $password, $dbnamei);

        // Check connection to ArtCity
        if ($conn2->connect_error) {
            die("Connection to ArtCity failed: " . $conn2->connect_error);
        } else {
            echo "Connected to ArtCity successfully<br>";
        }

        // Prepare and bind for ArtCity
        $stmt2 = $conn2->prepare("INSERT INTO CUSTOMER (C_id, Cname, Phone_no, place) VALUES (?, ?, ?, ?)");
        if ($stmt2 === false) {
            die("Prepare failed for ArtCity: " . $conn2->error);
        }
        $stmt2->bind_param("ssss", $user, $name, $phone, $place); // All fields should be strings

        // Execute the query for ArtCity
        if ($stmt2->execute()) {
            echo "New record created successfully in ArtCity<br>";
        } else {
            echo "Error in ArtCity: " . $stmt2->error;
        }
        header("Location: login.html");
        // Close statement and connection for ArtCity
        $stmt2->close();
        $conn2->close();
    }
} else {
    echo "Form not submitted<br>";
}
?>
