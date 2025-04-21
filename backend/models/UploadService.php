<?php
/**
 * UploadService - Handles file uploads with RESTful approach
 * Following DRY principles by centralizing upload logic
 */
class UploadService {
    // Base directory for uploads
    private $uploadsBaseDir;
    
    // Allowed file types (mime types)
    private $allowedTypes = [
        'image/jpeg',
        'image/png',
        'image/gif',
        'image/svg+xml'
    ];
    
    // Maximum file size in bytes (5MB)
    private $maxFileSize = 5242880;
    
    // Constructor
    public function __construct() {
        $this->uploadsBaseDir = __DIR__ . '/../uploads/';
    }
    
    /**
     * Upload a file to a specific category folder
     * 
     * @param array $file The uploaded file ($_FILES array element)
     * @param string $category The category folder (items, profiles, etc.)
     * @return array Response with status and file info
     */
    public function upload($file, $category) {
        // Validate category
        if (!$this->isValidCategory($category)) {
            return [
                'success' => false,
                'error' => 'Invalid upload category'
            ];
        }
        
        // Check if file was uploaded
        if (!isset($file) || $file['error'] !== UPLOAD_ERR_OK) {
            return [
                'success' => false,
                'error' => 'No file uploaded or upload error occurred'
            ];
        }
        
        // Validate file type
        if (!$this->isValidFileType($file)) {
            return [
                'success' => false,
                'error' => 'Invalid file type. Allowed types: JPG, PNG, GIF, SVG'
            ];
        }
        
        // Validate file size
        if (!$this->isValidFileSize($file)) {
            return [
                'success' => false,
                'error' => 'File too large. Maximum size is ' . ($this->maxFileSize / 1024 / 1024) . 'MB'
            ];
        }
        
        // Generate unique filename
        $filename = $this->generateUniqueFilename($file);
        
        // Set upload path
        $uploadPath = $this->uploadsBaseDir . $category . '/' . $filename;
        
        // Move the uploaded file
        if (move_uploaded_file($file['tmp_name'], $uploadPath)) {
            // Return success response with file info
            return [
                'success' => true,
                'file' => [
                    'name' => $filename,
                    'url' => '/backend/uploads/' . $category . '/' . $filename,
                    'mime' => $file['type'],
                    'size' => $file['size']
                ]
            ];
        } else {
            return [
                'success' => false,
                'error' => 'Failed to save uploaded file'
            ];
        }
    }
    
    /**
     * Delete a file from a specific category folder
     * 
     * @param string $filename The filename to delete
     * @param string $category The category folder (items, profiles, etc.)
     * @return array Response with status
     */
    public function delete($filename, $category) {
        // Validate category
        if (!$this->isValidCategory($category)) {
            return [
                'success' => false,
                'error' => 'Invalid upload category'
            ];
        }
        
        // Sanitize filename to prevent directory traversal
        $filename = basename($filename);
        
        // Set file path
        $filePath = $this->uploadsBaseDir . $category . '/' . $filename;
        
        // Check if file exists
        if (!file_exists($filePath)) {
            return [
                'success' => false,
                'error' => 'File not found'
            ];
        }
        
        // Delete the file
        if (unlink($filePath)) {
            return [
                'success' => true,
                'message' => 'File deleted successfully'
            ];
        } else {
            return [
                'success' => false,
                'error' => 'Failed to delete file'
            ];
        }
    }
    
    /**
     * Check if the category is valid
     * 
     * @param string $category The category to check
     * @return bool True if valid, false otherwise
     */
    private function isValidCategory($category) {
        $validCategories = ['items', 'profiles'];
        return in_array($category, $validCategories);
    }
    
    /**
     * Check if the file type is allowed
     * 
     * @param array $file The uploaded file
     * @return bool True if valid, false otherwise
     */
    private function isValidFileType($file) {
        return in_array($file['type'], $this->allowedTypes);
    }
    
    /**
     * Check if the file size is within limits
     * 
     * @param array $file The uploaded file
     * @return bool True if valid, false otherwise
     */
    private function isValidFileSize($file) {
        return $file['size'] <= $this->maxFileSize;
    }
    
    /**
     * Generate a unique filename for the uploaded file
     * 
     * @param array $file The uploaded file
     * @return string The generated filename
     */
    private function generateUniqueFilename($file) {
        $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        return uniqid() . '_' . time() . '.' . $extension;
    }
}
?> 