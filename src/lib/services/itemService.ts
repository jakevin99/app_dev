import { apiFetch } from './api';

export interface Item {
  id?: string;
  title: string;
  description: string;
  category: string;
  location: string;
  date: string;
  status: 'lost' | 'found';
  contactInfo: string;
  image?: string;
  userId?: string;
}

// RESTful endpoints for items
const ENDPOINTS = {
  ALL_ITEMS: '/items',
  LOST_ITEMS: '/items/lost',
  FOUND_ITEMS: '/items/found',
  ITEM_DETAIL: (id: string) => `/items/${id}`,
  USER_ITEMS: (userId: string) => `/users/${userId}/items`
};

/**
 * Service for lost and found items
 * Following RESTful design patterns
 */
export const itemService = {
  // Get all items
  getAllItems: () => apiFetch<Item[]>(ENDPOINTS.ALL_ITEMS),
  
  // Get lost items
  getLostItems: () => apiFetch<Item[]>(ENDPOINTS.LOST_ITEMS),
  
  // Get found items
  getFoundItems: () => apiFetch<Item[]>(ENDPOINTS.FOUND_ITEMS),
  
  // Get item by ID
  getItemById: (id: string) => apiFetch<Item>(ENDPOINTS.ITEM_DETAIL(id)),
  
  // Get items by user
  getUserItems: (userId: string) => apiFetch<Item[]>(ENDPOINTS.USER_ITEMS(userId)),
  
  // Create new item
  createItem: (item: Item) => apiFetch<Item>(ENDPOINTS.ALL_ITEMS, {
    method: 'POST',
    body: item
  }),
  
  // Update item
  updateItem: (id: string, item: Item) => apiFetch<Item>(ENDPOINTS.ITEM_DETAIL(id), {
    method: 'PUT',
    body: item
  }),
  
  // Delete item
  deleteItem: (id: string) => apiFetch<void>(ENDPOINTS.ITEM_DETAIL(id), {
    method: 'DELETE'
  })
}; 