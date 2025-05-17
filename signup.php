<?php
include 'dbconn.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $raw_password = $_POST['password'];
    $role = $_POST['role'];

    // Email validation
    if (!filter_var($email, FILTER_VALIDATE_EMAIL) || strpos($email, '@') === false || substr($email, -4) !== ".com") {
        echo json_encode(["status" => false, "message" => "Invalid email format. Must include '@' and end with '.com'"]);
        exit;
    }

    // Phone number validation
    if (!preg_match('/^09\d{9}$/', $phone)) {
        echo json_encode(["status" => false, "message" => "Invalid phone number. Must be 11 digits and start with 09"]);
        exit;
    }

    // Password validation
    if (strlen($raw_password) !== 8) {
        echo json_encode(["status" => false, "message" => "Password must be exactly 8 characters"]);
        exit;
    }

    $password = password_hash($raw_password, PASSWORD_BCRYPT);

    // ✅ Check if email already exists
    $check_sql = "SELECT id FROM users WHERE email = ?";
    $check_stmt = $conn->prepare($check_sql);
    if (!$check_stmt) {
        echo json_encode(["status" => false, "message" => "Check prepare failed: " . $conn->error]);
        exit;
    }

    $check_stmt->bind_param("s", $email);
    $check_stmt->execute();
    $check_stmt->store_result();

    if ($check_stmt->num_rows > 0) {
        echo json_encode(["status" => false, "message" => "User already exists"]);
        $check_stmt->close();
        $conn->close();
        exit;
    }
    $check_stmt->close();

    // ✅ Insert new user
    $insert_sql = "INSERT INTO users (email, phonenumber, password, role) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($insert_sql);

    if (!$stmt) {
        echo json_encode(["status" => false, "message" => "Insert prepare failed: " . $conn->error]);
        $conn->close();
        exit;
    }

    // 📌 Use 'ssss' since all inputs are strings
    $stmt->bind_param("ssss", $email, $phone, $password, $role);

    if ($stmt->execute()) {
        echo json_encode(["status" => true, "message" => "Signup successful"]);
    } else {
        echo json_encode(["status" => false, "message" => "Signup failed: " . $stmt->error]);
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(["status" => false, "message" => "Invalid request method."]);
}
?>
