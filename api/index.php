<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

require_once '../config/database.php';

// Get database connection
$conn = getDBConnection();

// Handle preflight requests
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

// Get request method and path
$method = $_SERVER['REQUEST_METHOD'];
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$path = str_replace('/api', '', $path);

// Authentication middleware
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

// Route handling
switch ($path) {
    case '/colleges':
        switch ($method) {
            case 'GET':
                // Get all colleges
                $stmt = $conn->query("SELECT * FROM colleges ORDER BY ranking");
                echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
                break;

            case 'POST':
                // Add new college (requires authentication)
                authenticateRequest();
                $data = json_decode(file_get_contents('php://input'), true);
                
                $stmt = $conn->prepare("INSERT INTO colleges (name, location, courses, fees, ranking, contact_info, description, image_url, website_url) 
                                      VALUES (:name, :location, :courses, :fees, :ranking, :contact_info, :description, :image_url, :website_url)");
                
                $stmt->execute([
                    ':name' => $data['name'],
                    ':location' => $data['location'],
                    ':courses' => $data['courses'],
                    ':fees' => $data['fees'],
                    ':ranking' => $data['ranking'],
                    ':contact_info' => $data['contact_info'],
                    ':description' => $data['description'],
                    ':image_url' => $data['image_url'],
                    ':website_url' => $data['website_url']
                ]);
                
                echo json_encode(['id' => $conn->lastInsertId(), 'message' => 'College added successfully']);
                break;
        }
        break;

    case (preg_match('/^\/colleges\/(\d+)$/', $path, $matches) ? true : false):
        $id = $matches[1];
        switch ($method) {
            case 'GET':
                // Get single college
                $stmt = $conn->prepare("SELECT * FROM colleges WHERE id = ?");
                $stmt->execute([$id]);
                $college = $stmt->fetch(PDO::FETCH_ASSOC);
                
                if ($college) {
                    echo json_encode($college);
                } else {
                    http_response_code(404);
                    echo json_encode(['error' => 'College not found']);
                }
                break;

            case 'PUT':
                // Update college (requires authentication)
                authenticateRequest();
                $data = json_decode(file_get_contents('php://input'), true);
                
                $stmt = $conn->prepare("UPDATE colleges SET 
                                      name = :name,
                                      location = :location,
                                      courses = :courses,
                                      fees = :fees,
                                      ranking = :ranking,
                                      contact_info = :contact_info,
                                      description = :description,
                                      image_url = :image_url,
                                      website_url = :website_url
                                      WHERE id = :id");
                
                $stmt->execute([
                    ':id' => $id,
                    ':name' => $data['name'],
                    ':location' => $data['location'],
                    ':courses' => $data['courses'],
                    ':fees' => $data['fees'],
                    ':ranking' => $data['ranking'],
                    ':contact_info' => $data['contact_info'],
                    ':description' => $data['description'],
                    ':image_url' => $data['image_url'],
                    ':website_url' => $data['website_url']
                ]);
                
                echo json_encode(['message' => 'College updated successfully']);
                break;

            case 'DELETE':
                // Delete college (requires authentication)
                authenticateRequest();
                $stmt = $conn->prepare("DELETE FROM colleges WHERE id = ?");
                $stmt->execute([$id]);
                
                if ($stmt->rowCount() > 0) {
                    echo json_encode(['message' => 'College deleted successfully']);
                } else {
                    http_response_code(404);
                    echo json_encode(['error' => 'College not found']);
                }
                break;
        }
        break;

    case '/auth/login':
        if ($method === 'POST') {
            $data = json_decode(file_get_contents('php://input'), true);
            
            $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
            $stmt->execute([$data['username']]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($user && password_verify($data['password'], $user['password'])) {
                // TODO: Generate JWT token
                echo json_encode([
                    'token' => 'dummy_token', // Replace with actual JWT token
                    'user' => [
                        'id' => $user['id'],
                        'username' => $user['username'],
                        'email' => $user['email'],
                        'role' => $user['role']
                    ]
                ]);
            } else {
                http_response_code(401);
                echo json_encode(['error' => 'Invalid credentials']);
            }
        }
        break;

    case '/analytics':
        if ($method === 'GET') {
            authenticateRequest();
            
            // Get total visits
            $stmt = $conn->query("SELECT COUNT(*) as total_visits FROM analytics");
            $totalVisits = $stmt->fetch(PDO::FETCH_ASSOC)['total_visits'];
            
            // Get visits by page
            $stmt = $conn->query("SELECT page_url, COUNT(*) as visits FROM analytics GROUP BY page_url");
            $visitsByPage = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            echo json_encode([
                'total_visits' => $totalVisits,
                'visits_by_page' => $visitsByPage
            ]);
        }
        break;

    default:
        http_response_code(404);
        echo json_encode(['error' => 'Endpoint not found']);
        break;
}
?> 