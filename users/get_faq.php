<?php
include '../config/db_connect.php';
session_start();

// Check if user is logged in and is an admin
if (!isset($_SESSION['user_id']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Content-Type: application/json');
    echo json_encode(['error' => 'Unauthorized access']);
    exit();
}

// Set JSON content type
header('Content-Type: application/json');

// Check if ID is provided
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo json_encode(['error' => 'Invalid FAQ ID']);
    exit();
}

$faq_id = intval($_GET['id']);

// Get FAQ data
$stmt = $conn->prepare("SELECT * FROM ai_assistant_faq WHERE faq_id = ?");
$stmt->bind_param("i", $faq_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo json_encode(['error' => 'FAQ not found']);
    exit();
}

$faq = $result->fetch_assoc();
$stmt->close();

// Return FAQ data
echo json_encode($faq);
?> 