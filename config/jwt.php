<?php
// JWT Configuration
define('JWT_SECRET', 'your-secret-key-here'); // Change this in production
define('JWT_EXPIRATION', 3600); // 1 hour

// Generate JWT token
function generateJWT($user) {
    $header = json_encode(['typ' => 'JWT', 'alg' => 'HS256']);
    $payload = json_encode([
        'user_id' => $user['id'],
        'username' => $user['username'],
        'role' => $user['role'],
        'exp' => time() + JWT_EXPIRATION
    ]);

    $base64UrlHeader = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($header));
    $base64UrlPayload = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($payload));

    $signature = hash_hmac('sha256', $base64UrlHeader . "." . $base64UrlPayload, JWT_SECRET, true);
    $base64UrlSignature = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($signature));

    return $base64UrlHeader . "." . $base64UrlPayload . "." . $base64UrlSignature;
}

// Validate JWT token
function validateJWT($token) {
    try {
        // Split token into parts
        $parts = explode('.', $token);
        if (count($parts) !== 3) {
            throw new Exception('Invalid token format');
        }

        // Decode payload
        $payload = json_decode(base64_decode(str_replace(['-', '_'], ['+', '/'], $parts[1])), true);
        if (!$payload) {
            throw new Exception('Invalid payload');
        }

        // Check expiration
        if (isset($payload['exp']) && $payload['exp'] < time()) {
            throw new Exception('Token has expired');
        }

        // Verify signature
        $signature = hash_hmac('sha256', $parts[0] . "." . $parts[1], JWT_SECRET, true);
        $base64UrlSignature = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($signature));
        
        if ($base64UrlSignature !== $parts[2]) {
            throw new Exception('Invalid signature');
        }

        return $payload;
    } catch (Exception $e) {
        return false;
    }
}

// Get user from token
function getUserFromToken($token) {
    $payload = validateJWT($token);
    if (!$payload) {
        return null;
    }

    return [
        'id' => $payload['user_id'],
        'username' => $payload['username'],
        'role' => $payload['role']
    ];
}

// Check if user has required role
function checkUserRole($token, $requiredRole) {
    $user = getUserFromToken($token);
    if (!$user) {
        return false;
    }

    $roleHierarchy = [
        'admin' => 3,
        'editor' => 2,
        'viewer' => 1
    ];

    return $roleHierarchy[$user['role']] >= $roleHierarchy[$requiredRole];
}

// Middleware to check authentication
function requireAuth($requiredRole = 'viewer') {
    $headers = getallheaders();
    if (!isset($headers['Authorization'])) {
        http_response_code(401);
        echo json_encode(['error' => 'No authorization token provided']);
        exit();
    }

    $token = str_replace('Bearer ', '', $headers['Authorization']);
    if (!checkUserRole($token, $requiredRole)) {
        http_response_code(403);
        echo json_encode(['error' => 'Insufficient permissions']);
        exit();
    }

    return getUserFromToken($token);
}
?> 