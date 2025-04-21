import { apiFetch } from './api';

interface UploadResponse {
  success: boolean;
  file?: {
    name: string;
    url: string;
    mime: string;
    size: number;
  };
  error?: string;
}

interface DeleteResponse {
  success: boolean;
  message?: string;
  error?: string;
}

/**
 * Service for handling file uploads, following DRY principles
 * Provides methods to upload and delete files through the RESTful API
 */
export const uploadService = {
  /**
   * Upload a file to the server
   * @param file - The file to upload
   * @param category - The category to upload to (items or profiles)
   * @returns Promise with the upload response
   */
  uploadFile: async (file: File, category: 'items' | 'profiles'): Promise<UploadResponse> => {
    // Create a FormData object to send the file
    const formData = new FormData();
    formData.append('file', file);
    
    try {
      // Use the fetch API directly as our apiFetch doesn't handle FormData
      const response = await fetch(`/backend/api/uploads.php?category=${category}`, {
        method: 'POST',
        body: formData,
        // Don't set Content-Type header - browser will set it with boundary for FormData
      });
      
      // Parse the response
      const data: UploadResponse = await response.json();
      
      // Return the response
      return data;
    } catch (error) {
      console.error('Error uploading file:', error);
      return {
        success: false,
        error: 'Failed to upload file. Please try again.'
      };
    }
  },
  
  /**
   * Delete a file from the server
   * @param filename - The filename to delete
   * @param category - The category the file belongs to
   * @returns Promise with the delete response
   */
  deleteFile: async (filename: string, category: 'items' | 'profiles'): Promise<DeleteResponse> => {
    try {
      // Use the fetch API directly
      const response = await fetch('/backend/api/uploads.php', {
        method: 'DELETE',
        headers: {
          'Content-Type': 'application/json'
        },
        body: JSON.stringify({ filename, category })
      });
      
      // Parse the response
      const data: DeleteResponse = await response.json();
      
      // Return the response
      return data;
    } catch (error) {
      console.error('Error deleting file:', error);
      return {
        success: false,
        error: 'Failed to delete file. Please try again.'
      };
    }
  }
}; 