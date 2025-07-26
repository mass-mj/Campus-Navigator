<?php
// Include database connection
require_once '../config/db_connect.php';

// Initialize response array
$response = array();
$response['colleges'] = array();
$response['count'] = 0;

// Get advanced filter parameters
$locations = isset($_POST['locations']) ? $_POST['locations'] : [];
$programs = isset($_POST['programs']) ? $_POST['programs'] : [];
$types = isset($_POST['types']) ? $_POST['types'] : [];
$maxTuition = isset($_POST['maxTuition']) ? intval($_POST['maxTuition']) : 2500000;

// Build the base query
$query = "SELECT * FROM colleges WHERE 1=1";

// Add location filters
if (!empty($locations)) {
    $locationConditions = [];
    foreach ($locations as $location) {
        $locationConditions[] = "category LIKE '%$location%'";
    }
    if (!empty($locationConditions)) {
        $query .= " AND (" . implode(" OR ", $locationConditions) . ")";
    }
}

// Add program filters
if (!empty($programs)) {
    $programConditions = [];
    foreach ($programs as $program) {
        $programConditions[] = "category LIKE '%$program%' OR tags LIKE '%$program%'";
    }
    if (!empty($programConditions)) {
        $query .= " AND (" . implode(" OR ", $programConditions) . ")";
    }
}

// Add college type filters
if (!empty($types)) {
    $typeConditions = [];
    foreach ($types as $type) {
        $typeConditions[] = "category LIKE '%$type%'";
    }
    if (!empty($typeConditions)) {
        $query .= " AND (" . implode(" OR ", $typeConditions) . ")";
    }
}

// Add tuition filter
if ($maxTuition > 0) {
    $query .= " AND tuition <= $maxTuition";
}

// Add default sorting by ranking
$query .= " ORDER BY ranking ASC";

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