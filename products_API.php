<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Content-Type: application/json");

include 'dbconn.php';

$action = $_GET['action'] ?? '';

switch ($action) {
    case 'product_registration':
        handleProductRegistration($conn);
        break;

    case 'all_products':
        fetchAllProducts($conn);
        break;

    case 'update_stock':
        updateStockQuantity($conn);
        break;

    default:
        echo json_encode(['error' => 'Invalid or missing action.']);
        break;
}

function handleProductRegistration($conn) {
    $data = json_decode(file_get_contents("php://input"), true);

    if (
        isset($data['name']) &&
        isset($data['price']) &&
        isset($data['quantity']) &&
        isset($data['image']) &&
        isset($data['enddate']) &&
        isset($data['category']) 
    ) {
        $name = $data['name'];
        $price = floatval($data['price']);
        $quantity = intval($data['quantity']);
        $enddate = $data['enddate'];
        $image = $data['image'];
        $category = $data['category'];

        // Notice: No productID, no id
        $stmt = $conn->prepare("INSERT INTO products (name, price, quantity, enddate, image, category) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sdisss", $name, $price, $quantity, $enddate, $image, $category);

        if ($stmt->execute()) {
            echo json_encode(['success' => 'Product registered successfully']);
        } else {
            echo json_encode(['error' => 'Failed to register product', 'details' => $stmt->error]);
        }

        $stmt->close();
    } else {
        echo json_encode(['error' => 'Missing required fields']);
    }
}

function fetchAllProducts($conn) {
    $result = $conn->query("SELECT * FROM products");

    $products = [];
    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }

    echo json_encode($products);
}

function updateStockQuantity($conn) {
    $data = json_decode(file_get_contents("php://input"), true);

    if (isset($data['id']) && isset($data['newStock'])) {
        $id = intval($data['id']);
        $newStock = intval($data['newStock']);

        $stmt = $conn->prepare("UPDATE products SET quantity = ? WHERE id = ?");
        $stmt->bind_param("ii", $newStock, $id);

        if ($stmt->execute()) {
            echo json_encode(['message' => 'Stock updated successfully']);
        } else {
            echo json_encode(['error' => 'Failed to update stock', 'details' => $stmt->error]);
        }

        $stmt->close();
    } else {
        echo json_encode(['error' => 'Missing id or newStock']);
    }
}
?>
