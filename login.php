<?php
header('Content-Type: application/json');
include 'dbconn.php';

// Get email and password from the POST request
$email = trim($_POST['email'] ?? '');
$password = trim($_POST['password'] ?? '');

// Check if email and password are provided
if (empty($email) || empty($password)) {
    echo json_encode([
        'status' => false,
        'message' => 'Email and password are required.'
    ]);
    exit;
}

// Prepare SQL query to get user by email
$sql = "SELECT id, email, password, role FROM users WHERE email = ?";
$stmt = $conn->prepare($sql);

// Check for SQL preparation errors
if (!$stmt) {
    echo json_encode([
        'status' => false,
        'message' => 'Database error: ' . $conn->error
    ]);
    exit;
}

$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

// Check if the user exists and verify the password
if ($result && $result->num_rows === 1) {
    $user = $result->fetch_assoc();

    // Verify the password using password_verify
    if (password_verify($password, $user['password'])) {
        echo json_encode([
            'status' => true,
            'user' => [
                'id' => $user['id'],
                'email' => $user['email'],
                // Omit the password for security reasons
                'role' => $user['role']
            ]
        ]);
        exit;
    }
}

// If login fails (invalid credentials)
echo json_encode([
    'status' => false,
    'message' => 'Invalid credentials'
]);
?>
