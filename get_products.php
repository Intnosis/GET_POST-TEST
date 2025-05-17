<?php
header("Access-Control-Allow-Origin: *"); // Allow cross-origin requests
header('Content-Type: application/json');

// Include your database connection file
include 'dbconn.php';

$sql = "SELECT id, name, price, quantity, image, enddate, category FROM products";
$result = $conn->query($sql);

$products = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Ensure price is a float and enddate is a valid date string
        $row['price'] = (float) $row['price'];
        $row['enddate'] = date("Y-m-d H:i:s", strtotime($row['enddate'])); // format enddate to a standard format

        $products[] = $row;
    }
    echo json_encode($products);
} else {
    // If no products are found, return an empty array
    echo json_encode([]);
}

$conn->close();
?>
