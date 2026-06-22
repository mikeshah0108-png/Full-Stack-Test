<?php
/**
 * API Endpoint: Update an item
 * Method: POST
 * Parameters: id, category_id, title, description, image_url
 * Returns: JSON response
 */

header('Content-Type: application/json');
require_once '../config/database.php';

try {
    // Validate request method
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        http_response_code(405);
        json_response(false, 'Method not allowed');
    }

    // Get POST data
    $input = file_get_contents('php://input');
    $data = json_decode($input, true);

    // Validate required fields
    if (!isset($data['id']) || empty($data['id'])) {
        json_response(false, 'Item id is required');
    }

    $id = intval($data['id']);

    if ($id <= 0) {
        json_response(false, 'Invalid item id');
    }

    // Check if item exists
    $itemCheck = "SELECT id FROM items WHERE id = ?";
    $stmt = $conn->prepare($itemCheck);
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 0) {
        json_response(false, 'Item not found');
    }
    $stmt->close();

    // Build update query based on provided fields
    $updateFields = [];
    $params = [];
    $types = '';

    if (isset($data['title']) && !empty(trim($data['title']))) {
        $updateFields[] = 'title = ?';
        $params[] = trim($data['title']);
        $types .= 's';
    }

    if (isset($data['description']) && !empty(trim($data['description']))) {
        $updateFields[] = 'description = ?';
        $params[] = trim($data['description']);
        $types .= 's';
    }

    if (isset($data['image_url']) && !empty(trim($data['image_url']))) {
        $updateFields[] = 'image_url = ?';
        $params[] = trim($data['image_url']);
        $types .= 's';
    }

    if (isset($data['category_id'])) {
        $category_id = intval($data['category_id']);
        if ($category_id > 0) {
            // Verify category exists
            $catCheck = "SELECT id FROM categories WHERE id = ?";
            $catStmt = $conn->prepare($catCheck);
            $catStmt->bind_param('i', $category_id);
            $catStmt->execute();
            $catResult = $catStmt->get_result();
            
            if ($catResult->num_rows === 0) {
                json_response(false, 'Category not found');
            }
            $catStmt->close();
            
            $updateFields[] = 'category_id = ?';
            $params[] = $category_id;
            $types .= 'i';
        }
    }

    if (empty($updateFields)) {
        json_response(false, 'No fields to update');
    }

    // Add id to parameters
    $params[] = $id;
    $types .= 'i';

    // Build and execute update query
    $sql = "UPDATE items SET " . implode(', ', $updateFields) . " WHERE id = ?";
    $stmt = $conn->prepare($sql);
    
    if (!$stmt) {
        throw new Exception('Prepare failed: ' . $conn->error);
    }

    $stmt->bind_param($types, ...$params);
    
    if (!$stmt->execute()) {
        throw new Exception('Execute failed: ' . $stmt->error);
    }

    $stmt->close();

    json_response(true, 'Item updated successfully');

} catch (Exception $e) {
    json_response(false, $e->getMessage());
} finally {
    $conn->close();
}
?>
