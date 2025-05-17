<?php
include 'dbconn.php';

$email = $_POST['email'];
$otp = rand(100000, 999999);

// Here you’d send the OTP via email/SMS
$sql = "UPDATE users SET verification_code = ? WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $otp, $email);
$stmt->execute();

if ($stmt->affected_rows === 1) {
    echo "OTP sent successfully.";
} else {
    echo "Email not found.";
}

$stmt->close();
$conn->close();
?>
