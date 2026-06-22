<?php
/**
 * API Endpoint: Create a new item
 * Method: POST
 * Parameters: category_id, title, description, image_url
 * Returns: JSON response with created item id
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
    $required_fields = ['category_id', 'title', 'description', 'image_url'];
    foreach ($required_fields as $field) {
        if (!isset($data[$field]) || empty(trim($data[$field]))) {
            json_response(false, "Missing or empty required field: $field");
        }
    }

    $category_id = intval($data['category_id']);
    $title = trim($data['title']);
    $description = trim($data['description']);
    $image_url = trim($data['image_url']);

    // Validate category_id
    if ($category_id <= 0) {
        json_response(false, 'Invalid category_id');
    }

    // Validate title and description length
    if (strlen($title) > 255) {
        json_response(false, 'Title must be less than 255 characters');
    }

    if (strlen($description) > 1000) {
        json_response(false, 'Description must be less than 1000 characters');
    }

    // Check if category exists
    $categoryCheck = "SELECT id FROM categories WHERE id = ?";
    $stmt = $conn->prepare($categoryCheck);
    $stmt->bind_param('i', $category_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 0) {
        json_response(false, 'Category not found');
    }
    $stmt->close();

    // Get max display_order for this category
    $orderSql = "SELECT MAX(display_order) as max_order FROM items WHERE category_id = ?";
    $stmt = $conn->prepare($orderSql);
    $stmt->bind_param('i', $category_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $orderRow = $result->fetch_assoc();
    $display_order = ($orderRow['max_order'] ?? 0) + 1;
    $stmt->close();

    // Insert new item
    $sql = "INSERT INTO items (category_id, title, description, image_url, display_order, created_at) VALUES (?, ?, ?, ?, ?, NOW())";
    $stmt = $conn->prepare($sql);
    
    if (!$stmt) {
        throw new Exception('Prepare failed: ' . $conn->error);
    }

    $stmt->bind_param('isssi', $category_id, $title, $description, $image_url, $display_order);
    
    if (!$stmt->execute()) {
        throw new Exception('Execute failed: ' . $stmt->error);
    }

    $item_id = $conn->insert_id;
    $stmt->close();

    json_response(true, 'Item created successfully', ['id' => $item_id]);

} catch (Exception $e) {
    json_response(false, $e->getMessage());
} finally {
    $conn->close();
}
?>
