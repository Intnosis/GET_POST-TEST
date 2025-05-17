<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Content-Type: application/json");

include 'dbconn.php';

$action = $_GET['action'] ?? '';

switch ($action) {
    case 'edit_product':
        handleEditProduct($conn);
        break;

    default:
        echo json_encode(['error' => 'Invalid or missing action.']);
        break;
}

function handleEditProduct($conn) {
    $data = json_decode(file_get_contents("php://input"), true);

    if (
        isset($data['id']) &&
        isset($data['name']) &&
        isset($data['price']) &&
        isset($data['quantity']) &&
        isset($data['image']) &&
        isset($data['enddate']) &&
        isset($data['category']) 
    ) {
        $id = intval($data['id']);
        $name = $data['name'];
        $price = floatval($data['price']);
        $quantity = intval($data['quantity']);
        $enddate = $data['enddate'];
        $image = $data['image'];
        $category = $data['category'];

        $stmt = $conn->prepare("UPDATE products SET name = ?, price = ?, quantity = ?, enddate = ?, image = ?, category = ? WHERE id = ?");
        $stmt->bind_param("sdisssi", $name, $price, $quantity, $enddate, $image, $category, $id);

        if ($stmt->execute()) {
            echo json_encode(['success' => 'Product updated successfully']);
        } else {
            echo json_encode(['error' => 'Failed to update product', 'details' => $stmt->error]);
        }

        $stmt->close();
    } else {
        echo json_encode(['error' => 'Missing required fields']);
    }
}
?>
