// Base API service following DRY principles
// Single fetch function for all API requests

const API_BASE_URL = '/api'; // This will be configured for your backend

interface ApiOptions {
  method?: 'GET' | 'POST' | 'PUT' | 'DELETE';
  body?: any;
  headers?: Record<string, string>;
}

/**
 * Generic API fetch function
 * @param endpoint - API endpoint path
 * @param options - Request options
 * @returns Promise with response data
 */
export async function apiFetch<T>(endpoint: string, options: ApiOptions = {}): Promise<T> {
  const { method = 'GET', body, headers = {} } = options;
  
  const requestOptions: RequestInit = {
    method,
    headers: {
      'Content-Type': 'application/json',
      ...headers
    },
    credentials: 'include', // For handling cookies if needed
  };

  if (body) {
    requestOptions.body = JSON.stringify(body);
  }

  const response = await fetch(`${API_BASE_URL}${endpoint}`, requestOptions);
  
  if (!response.ok) {
    const errorData = await response.json().catch(() => ({}));
    throw new Error(errorData.message || `API error: ${response.status}`);
  }
  
  // For endpoints that return no content
  if (response.status === 204) {
    return {} as T;
  }
  
  return await response.json() as T;
} 