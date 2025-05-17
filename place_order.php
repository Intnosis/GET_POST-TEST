<?php
require 'dbconn.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    die("You must be logged in.");
}

$user_id = $_SESSION['user_id'];
$total = 100.00; // Example
$status = "Pending";
$date = date('Y-m-d H:i:s');

$stmt = $conn->prepare("INSERT INTO orders (user_id, order_date, status, total_amount) VALUES (?, ?, ?, ?)");
$stmt->execute([$user_id, $date, $status, $total]);

echo "Order placed!";
