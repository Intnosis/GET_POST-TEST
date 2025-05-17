<?php
header("Access-Control-Allow-Origin: *"); // Allow cross-origin requests
header("Access-Control-Allow-Methods: POST, GET, OPTIONS"); // Allow specific methods
header("Access-Control-Allow-Headers: Content-Type"); // Allow the Content-Type header

header("Content-Type: application/json"); // Set response type to JSON

include 'dbconn.php'; // Reuse your database connection script

// Handle OPTIONS request (CORS pre-flight)
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    exit(0); // Allow the pre-flight request to succeed
}

// Read the raw JSON input from the request
$data = json_decode(file_get_contents("php://input"), true);

// Check if data is valid
if (!$data || !is_array($data)) {
    http_response_code(400);
    echo json_encode(["error" => "Invalid JSON input"]);
    exit;
}

// Process each cart item
foreach ($data as $item) {
    $productId = intval($item['product_id']);
    $quantity = intval($item['quantity']);

    // Validate quantity, skip if invalid
    if ($quantity <= 0) continue;

    // Check current stock in the database
    $stmt = $conn->prepare("SELECT quantity FROM products WHERE id = ?");
    $stmt->bind_param("i", $productId);
    $stmt->execute();
    $stmt->bind_result($currentStock);
    $stmt->fetch();
    $stmt->close();

    // If product not found or insufficient stock, skip this item
    if ($currentStock === null || $currentStock < $quantity) {
        continue;
    }

    // Update the stock quantity
    $newQuantity = $currentStock - $quantity;
    $updateStmt = $conn->prepare("UPDATE products SET quantity = ? WHERE id = ?");
    $updateStmt->bind_param("ii", $newQuantity, $productId);
    $updateStmt->execute();
    $updateStmt->close();
}

// Send response indicating success
echo json_encode(["success" => true]);

// Close the database connection
$conn->close();
?>
