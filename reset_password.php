<?php
include 'dbconn.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $verification_code = trim($_POST['verification_code']); // renamed here
    $new_password = password_hash($_POST['new_password'], PASSWORD_BCRYPT);

    // First, verify that the provided verification code matches the user's stored code
    $sql_check = "SELECT verification_code FROM users WHERE email = ?";
    $stmt_check = $conn->prepare($sql_check);
    $stmt_check->bind_param("s", $email);
    $stmt_check->execute();
    $stmt_check->bind_result($stored_code);
    $stmt_check->fetch();
    $stmt_check->close();

    if ($stored_code && $stored_code === $verification_code) {
        // Codes match, update password
        $sql_update = "UPDATE users SET password = ? WHERE email = ?";
        $stmt_update = $conn->prepare($sql_update);
        $stmt_update->bind_param("ss", $new_password, $email);
        $stmt_update->execute();

        if ($stmt_update->affected_rows === 1) {
            echo "Password reset successful.";
        } else {
            echo "Failed to update password.";
        }
        $stmt_update->close();
    } else {
        echo "Invalid verification code or email.";
    }

    $conn->close();
} else {
    echo "Invalid request method.";
}
?>
