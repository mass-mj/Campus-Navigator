<?php
include_once '../config/db_connect.php';
session_start();

// Set appropriate headers for API response
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header('Access-Control-Allow-Headers: Content-Type');

// Generate or retrieve session ID for non-logged in users
if (!isset($_SESSION['ai_chat_session'])) {
    $_SESSION['ai_chat_session'] = bin2hex(random_bytes(16));
}
$session_id = $_SESSION['ai_chat_session'];

// Get user ID if logged in
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

// Function to log chat in database
function logChatMessage($conn, $user_id, $session_id, $message, $is_user_message, $response_time = null) {
    $ip = $_SERVER['REMOTE_ADDR'];
    
    $stmt = $conn->prepare("INSERT INTO ai_assistant_chat_logs (user_id, session_id, message, is_user_message, response_time, ip_address) 
                           VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("issdds", $user_id, $session_id, $message, $is_user_message, $response_time, $ip);
    $stmt->execute();
    $stmt->close();
}

// Function to get predefined answer for a question
function getAnswer($conn, $question) {
    $start_time = microtime(true);
    
    // Clean up input
    $query = '%' . $conn->real_escape_string($question) . '%';
    
    // First try exact match
    $stmt = $conn->prepare("SELECT answer FROM ai_assistant_faq WHERE LOWER(question) = LOWER(?) AND is_active = 1 LIMIT 1");
    $stmt->bind_param("s", $question);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 0) {
        // If no exact match, try fuzzy match
        $stmt = $conn->prepare("SELECT answer FROM ai_assistant_faq 
                              WHERE LOWER(question) LIKE LOWER(?) AND is_active = 1 
                              LIMIT 1");
        $stmt->bind_param("s", $query);
        $stmt->execute();
        $result = $stmt->get_result();
    }
    
    $stmt->close();
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $answer = $row['answer'];
    } else {
        $answer = "I'm sorry, I don't have an answer for that question. Please try asking something else or contact our support team for assistance.";
    }
    
    $response_time = microtime(true) - $start_time;
    
    return [
        'answer' => $answer,
        'response_time' => $response_time
    ];
}

// Get all FAQ categories for the suggestion bubbles
function getFAQCategories($conn) {
    $stmt = $conn->prepare("SELECT DISTINCT category FROM ai_assistant_faq WHERE is_active = 1 ORDER BY category");
    $stmt->execute();
    $result = $stmt->get_result();
    
    $categories = [];
    while ($row = $result->fetch_assoc()) {
        $categories[] = $row['category'];
    }
    
    $stmt->close();
    return $categories;
}

// Get suggested questions by category
function getSuggestedQuestions($conn, $category = null) {
    if ($category) {
        $stmt = $conn->prepare("SELECT question FROM ai_assistant_faq 
                              WHERE category = ? AND is_active = 1 
                              ORDER BY display_order ASC LIMIT 5");
        $stmt->bind_param("s", $category);
    } else {
        $stmt = $conn->prepare("SELECT question FROM ai_assistant_faq 
                              WHERE is_active = 1 
                              ORDER BY display_order ASC LIMIT 5");
    }
    
    $stmt->execute();
    $result = $stmt->get_result();
    
    $questions = [];
    while ($row = $result->fetch_assoc()) {
        $questions[] = $row['question'];
    }
    
    $stmt->close();
    return $questions;
}

// Handle the request
$request_method = $_SERVER['REQUEST_METHOD'];

if ($request_method === 'GET') {
    // Return suggestions or categories
    if (isset($_GET['action']) && $_GET['action'] === 'get_categories') {
        $categories = getFAQCategories($conn);
        echo json_encode(['categories' => $categories]);
    } elseif (isset($_GET['action']) && $_GET['action'] === 'get_suggestions') {
        $category = isset($_GET['category']) ? $_GET['category'] : null;
        $suggestions = getSuggestedQuestions($conn, $category);
        echo json_encode(['suggestions' => $suggestions]);
    } else {
        // Default response
        echo json_encode([
            'status' => 'error',
            'message' => 'Invalid request'
        ]);
    }
} elseif ($request_method === 'POST') {
    // Process the user question
    $data = json_decode(file_get_contents("php://input"), true);
    
    if (isset($data['question'])) {
        $question = trim($data['question']);
        
        // Log user message
        logChatMessage($conn, $user_id, $session_id, $question, 1);
        
        // Get answer
        $response = getAnswer($conn, $question);
        $answer = $response['answer'];
        $response_time = $response['response_time'];
        
        // Log AI response
        logChatMessage($conn, $user_id, $session_id, $answer, 0, $response_time);
        
        // Send response
        echo json_encode([
            'status' => 'success',
            'message' => $answer,
            'response_time' => $response_time
        ]);
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'No question provided'
        ]);
    }
} else {
    // Invalid request method
    echo json_encode([
        'status' => 'error',
        'message' => 'Invalid request method'
    ]);
}

$conn->close();
?> 