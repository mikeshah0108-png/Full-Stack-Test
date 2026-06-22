<?php
/**
 * API Endpoint: Get items for a specific category
 * Parameters: category_id (required)
 * Returns: JSON array of items
 */

header('Content-Type: application/json');
require_once '../config/database.php';

try {
    // Validate category_id parameter
    if (!isset($_GET['category_id']) || empty($_GET['category_id'])) {
        json_response(false, 'category_id parameter is required');
    }

    $category_id = intval($_GET['category_id']);

    if ($category_id <= 0) {
        json_response(false, 'Invalid category_id');
    }

    // Check if category exists
    $categoryCheck = "SELECT id FROM categories WHERE id = ?"; 
    $stmt = $conn->prepare($categoryCheck);
    if (!$stmt) {
        throw new Exception('Prepare failed: ' . $conn->error);
    }
    
    $stmt->bind_param('i', $category_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 0) {
        json_response(false, 'Category not found');
    }
    $stmt->close();

    // Query items for the category
    $sql = "SELECT id, category_id, title, description, image_url, display_order FROM items WHERE category_id = ? ORDER BY display_order ASC";
    $stmt = $conn->prepare($sql);
    
    if (!$stmt) {
        throw new Exception('Prepare failed: ' . $conn->error);
    }

    $stmt->bind_param('i', $category_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $items = [];
    while ($row = $result->fetch_assoc()) {
        $items[] = $row;
    }
    $stmt->close();

    if (empty($items)) {
        json_response(false, 'No items found for this category', []);
    }

    json_response(true, 'Items retrieved successfully', $items);

} catch (Exception $e) {
    json_response(false, $e->getMessage());
} finally {
    $conn->close();
}
?>
