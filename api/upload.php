<?php
require_once '../config/database.php';

// Check if user is authenticated
function authenticateRequest() {
    $headers = getallheaders();
    if (!isset($headers['Authorization'])) {
        http_response_code(401);
        echo json_encode(['error' => 'No authorization token provided']);
        exit();
    }

    $token = str_replace('Bearer ', '', $headers['Authorization']);
    // TODO: Implement JWT token validation
    return true;
}

// Validate file type
function validateFileType($file) {
    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
    $maxSize = 5 * 1024 * 1024; // 5MB

    if (!in_array($file['type'], $allowedTypes)) {
        return ['valid' => false, 'error' => 'Invalid file type. Only JPG, PNG and GIF files are allowed.'];
    }

    if ($file['size'] > $maxSize) {
        return ['valid' => false, 'error' => 'File too large. Maximum size is 5MB.'];
    }

    return ['valid' => true];
}

// Generate unique filename
function generateUniqueFilename($originalName) {
    $extension = pathinfo($originalName, PATHINFO_EXTENSION);
    return uniqid() . '_' . time() . '.' . $extension;
}

// Handle file upload
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Authenticate request
        authenticateRequest();

        if (!isset($_FILES['file'])) {
            throw new Exception('No file uploaded');
        }

        $file = $_FILES['file'];
        
        // Validate file
        $validation = validateFileType($file);
        if (!$validation['valid']) {
            throw new Exception($validation['error']);
        }

        // Create uploads directory if it doesn't exist
        $uploadDir = '../uploads/';
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        // Generate unique filename
        $filename = generateUniqueFilename($file['name']);
        $targetPath = $uploadDir . $filename;

        // Move uploaded file
        if (!move_uploaded_file($file['tmp_name'], $targetPath)) {
            throw new Exception('Failed to move uploaded file');
        }

        // Return success response with file URL
        echo json_encode([
            'success' => true,
            'file_url' => '/uploads/' . $filename
        ]);

    } catch (Exception $e) {
        http_response_code(400);
        echo json_encode([
            'success' => false,
            'error' => $e->getMessage()
        ]);
    }
} else {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
}
?> 