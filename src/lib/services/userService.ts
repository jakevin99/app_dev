import { apiFetch } from './api';

export interface User {
  id?: string;
  name: string;
  email: string;
  contact?: string;
}

export interface AuthCredentials {
  email: string;
  password: string;
}

// RESTful endpoints for users
const ENDPOINTS = {
  REGISTER: '/auth/register',
  LOGIN: '/auth/login',
  LOGOUT: '/auth/logout',
  CURRENT_USER: '/auth/me',
  USER_PROFILE: (id: string) => `/users/${id}`
};

/**
 * Service for user authentication and management
 * Following RESTful design patterns
 */
export const userService = {
  // User registration
  register: (userData: User & { password: string }) => 
    apiFetch<User>(ENDPOINTS.REGISTER, {
      method: 'POST',
      body: userData
    }),
  
  // User login
  login: (credentials: AuthCredentials) => 
    apiFetch<{ user: User; token: string }>(ENDPOINTS.LOGIN, {
      method: 'POST',
      body: credentials
    }),
  
  // User logout
  logout: () => apiFetch<void>(ENDPOINTS.LOGOUT, { method: 'POST' }),
  
  // Get current user
  getCurrentUser: () => apiFetch<User>(ENDPOINTS.CURRENT_USER),
  
  // Get user profile
  getUserProfile: (id: string) => apiFetch<User>(ENDPOINTS.USER_PROFILE(id)),
  
  // Update user
  updateUser: (id: string, userData: Partial<User>) => 
    apiFetch<User>(ENDPOINTS.USER_PROFILE(id), {
      method: 'PUT',
      body: userData
    }),
}; 