<?php
/**
 * API Endpoint: Get all categories
 * Returns: JSON array of categories
 */

header('Content-Type: application/json');
require_once '../config/database.php';

try {
    // Query all categories
    $sql = "SELECT id, name, description, display_order FROM categories ORDER BY display_order ASC";
    $result = $conn->query($sql);

    if (!$result) {
        throw new Exception('Database query failed: ' . $conn->error);
    }

    $categories = [];
    while ($row = $result->fetch_assoc()) {
        $categories[] = $row;
    }

    if (empty($categories)) {
        json_response(false, 'No categories found', []);
    }

    json_response(true, 'Categories retrieved successfully', $categories);

} catch (Exception $e) {
    json_response(false, $e->getMessage());
} finally {
    $conn->close();
}
?>
