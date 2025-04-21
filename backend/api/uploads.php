<?php
/**
 * File Upload API Endpoint
 * RESTful API for handling file uploads
 */

// Include upload service
require_once __DIR__ . '/../models/UploadService.php';

// Set headers
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With');

// Handle preflight requests
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

// Create upload service instance
$uploadService = new UploadService();

// Get request method
$method = $_SERVER['REQUEST_METHOD'];

// Route request based on HTTP method
switch ($method) {
    case 'POST':
        // Upload file
        handleUpload($uploadService);
        break;
    case 'DELETE':
        // Delete file
        handleDelete($uploadService);
        break;
    default:
        // Method not allowed
        http_response_code(405);
        echo json_encode(['error' => 'Method not allowed']);
        break;
}

/**
 * Handle file upload
 * 
 * @param UploadService $uploadService The upload service
 */
function handleUpload($uploadService) {
    // Check if category parameter is set
    if (!isset($_GET['category'])) {
        http_response_code(400);
        echo json_encode(['error' => 'Missing category parameter']);
        return;
    }
    
    // Get category parameter
    $category = $_GET['category'];
    
    // Check if a file was uploaded
    if (!isset($_FILES['file'])) {
        http_response_code(400);
        echo json_encode(['error' => 'No file uploaded']);
        return;
    }
    
    // Upload file
    $result = $uploadService->upload($_FILES['file'], $category);
    
    // Check if upload was successful
    if ($result['success']) {
        http_response_code(201); // Created
        echo json_encode($result);
    } else {
        http_response_code(400);
        echo json_encode($result);
    }
}

/**
 * Handle file deletion
 * 
 * @param UploadService $uploadService The upload service
 */
function handleDelete($uploadService) {
    // Parse request body
    $data = json_decode(file_get_contents('php://input'), true);
    
    // Check if required parameters are set
    if (!isset($data['filename']) || !isset($data['category'])) {
        http_response_code(400);
        echo json_encode(['error' => 'Missing parameters. Required: filename, category']);
        return;
    }
    
    // Delete file
    $result = $uploadService->delete($data['filename'], $data['category']);
    
    // Check if deletion was successful
    if ($result['success']) {
        http_response_code(200);
        echo json_encode($result);
    } else {
        http_response_code(404);
        echo json_encode($result);
    }
}
?> 