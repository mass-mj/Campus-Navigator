<?php
// Include database connection
require_once '../config/db_connect.php';

// Initialize response array
$response = array();
$response['colleges'] = array();
$response['count'] = 0;

// Get search parameters
$search = isset($_GET['search']) ? $_GET['search'] : '';
$category = isset($_GET['category']) ? $_GET['category'] : 'all';
$sort = isset($_GET['sort']) ? $_GET['sort'] : 'ranking';

// Build the base query
$query = "SELECT * FROM colleges WHERE 1=1";

// Add search condition if search parameter exists
if (!empty($search)) {
    $query .= " AND (
        name LIKE '%$search%' OR 
        location LIKE '%$search%' OR
        category LIKE '%$search%' OR
        tags LIKE '%$search%'
    )";
}

// Add category filter if not 'all'
if ($category != 'all') {
    $query .= " AND category LIKE '%$category%'";
}

// Add sorting
switch ($sort) {
    case 'ranking':
        $query .= " ORDER BY ranking ASC";
        break;
    case 'tuition-low':
        $query .= " ORDER BY tuition ASC";
        break;
    case 'tuition-high':
        $query .= " ORDER BY tuition DESC";
        break;
    case 'acceptance':
        $query .= " ORDER BY acceptance_rate ASC";
        break;
    default:
        $query .= " ORDER BY ranking ASC";
}

// Execute query
$result = $conn->query($query);

// Check if query was successful
if ($result) {
    // Fetch colleges
    while ($row = $result->fetch_assoc()) {
        // Process tags (comma-separated to array)
        $tags = explode(',', $row['tags']);
        
        $college = array(
            'id' => $row['id'],
            'name' => $row['name'],
            'location' => $row['location'],
            'category' => $row['category'],
            'ranking' => $row['ranking'],
            'tuition' => $row['tuition'],
            'acceptance_rate' => $row['acceptance_rate'],
            'grade' => $row['grade'],
            'description' => $row['description'],
            'logo_url' => $row['logo_url'],
            'tags' => $tags
        );
        
        array_push($response['colleges'], $college);
    }
    
    // Update count
    $response['count'] = count($response['colleges']);
}

// Set content type header
header('Content-Type: application/json');

// Return response as JSON
echo json_encode($response);

// Close connection
$conn->close();
?> 