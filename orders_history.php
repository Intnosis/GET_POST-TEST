<?php
// Include the database connection file
include 'dbconn.php';

// Start the session to get user information (Assuming user is logged in)
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // If the user is not logged in, return an error
    echo json_encode(['error' => 'User not logged in']);
    exit;
}

$user_id = $_SESSION['user_id'];  // Assuming user ID is stored in session after login

// Create a connection to the database
$conn = open_db_connection();

// Prepare the SQL query to fetch the user's order history from the database
$query = "SELECT id, user_id, order_date, status, total_amount FROM orders WHERE user_id = ?";
$stmt = $conn->prepare($query);

// Check if statement preparation is successful
if ($stmt === false) {
    echo json_encode(['error' => 'SQL preparation failed: ' . $conn->error]);
    exit;
}

$stmt->bind_param("i", $user_id);

// Execute the query
$stmt->execute();
$result = $stmt->get_result();

// Check if there are any orders
if ($result->num_rows > 0) {
    $orders = [];

    // Fetch all orders and store them in an array
    while ($row = $result->fetch_assoc()) {
        $orders[] = $row;
    }

    // Return the orders in JSON format
    echo json_encode(['orders' => $orders]);
} else {
    // If no orders are found for the user
    echo json_encode(['message' => 'No orders found for this user']);
}

// Close the database connection
$stmt->close();
$conn->close();

// Function to open a database connection (replace with your actual DB connection logic)
function open_db_connection() {
    $host = 'localhost';  // Your DB host
    $username = 'root';   // Your DB username
    $password = '';       // Your DB password
    $dbname = 'order'; // Your DB name
    
    $conn = new mysqli($host, $username, $password, $dbname);
    
    // Check for connection errors
    if ($conn->connect_error) {
        die('Connection failed: ' . $conn->connect_error);
    }
    
    return $conn;
}
?>
