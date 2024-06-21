<?php
session_start();

$servername = "localhost"; // Corrected server name
$username = "root"; // Change this to your database username
$password = ""; // Change this to your database password
$database = "ArtCity"; // Change this to your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if user is logged in
if (!isset($_SESSION['username'])) {
    die("User not logged in");
}

$customerId = $_SESSION['username']; 

// Retrieve the cart data from the POST request
$cartData = json_decode(file_get_contents('php://input'), true);
if (!empty($cartData)) {
    foreach ($cartData as $item) {
        $artNo = $item['id'];
        $stmt = $conn->prepare("INSERT INTO CUSTOMER_ORDERS (C_id, Art_No) VALUES (?, ?) ON DUPLICATE KEY UPDATE C_id = VALUES(C_id), Art_No = VALUES(Art_No)");
        $stmt->bind_param("ii", $customerId, $artNo); // Bind parameters
        $stmt->execute();
    }

    echo "Checkout successful!";
} else {
    echo "Cart is empty!";
}
?>
