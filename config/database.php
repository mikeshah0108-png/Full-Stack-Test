<?php
/**
 * Database Configuration and Connection
 * WPoets Full Stack Test
 */

// Database credentials
$servername = "localhost";
$username = "root";
$password = ""; // Update with your password
$dbname = "wpoets_test";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die(json_encode([
        'success' => false,
        'message' => 'Database connection failed: ' . $conn->connect_error
    ]));
}

// Set charset to UTF-8
if (!$conn->set_charset("utf8mb4")) {
    die(json_encode([
        'success' => false,
        'message' => 'Error loading character set utf8mb4: ' . $conn->error
    ]));
}

// Set error mode
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

// Helper function to escape output
function escape_output($data) {
    return htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
}

// Helper function for JSON response
function json_response($success, $message = '', $data = null) {
    $response = [
        'success' => $success,
        'message' => $message
    ];
    if ($data !== null) {
        $response['data'] = $data;
    }
    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}
?>
