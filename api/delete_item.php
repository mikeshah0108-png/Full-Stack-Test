<?php
/**
 * API Endpoint: Delete an item
 * Method: POST
 * Parameters: id
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

    // Validate required field
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

    // Delete the item
    $sql = "DELETE FROM items WHERE id = ?";
    $stmt = $conn->prepare($sql);
    
    if (!$stmt) {
        throw new Exception('Prepare failed: ' . $conn->error);
    }

    $stmt->bind_param('i', $id);
    
    if (!$stmt->execute()) {
        throw new Exception('Execute failed: ' . $stmt->error);
    }

    $stmt->close();

    json_response(true, 'Item deleted successfully');

} catch (Exception $e) {
    json_response(false, $e->getMessage());
} finally {
    $conn->close();
}
?>
