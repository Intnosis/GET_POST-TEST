<?php
include 'dbconn.php';

$email = $_POST['email'];
$code = $_POST['verification_code'];

$sql = "UPDATE users SET email_verified = 1 WHERE email = ? AND verification_code = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $email, $code);
$stmt->execute();

if ($stmt->affected_rows === 1) {
    echo "Email verified successfully.";
} else {
    echo "Verification failed.";
}

$stmt->close();
$conn->close();
?>
