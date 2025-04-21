<script lang="ts">
  import { onMount } from 'svelte';
  import { itemService, type Item } from '$lib/services/itemService';
  import ItemCard from '$lib/components/ItemCard.svelte';
  import Button from '$lib/components/Button.svelte';
  import Card from '$lib/components/Card.svelte';
  
  let items: Item[] = [];
  let isLoading = true;
  let error = '';
  
  // Filter states
  let searchQuery = '';
  let selectedCategory = '';
  let categories = [
    'Electronics', 
    'Clothing', 
    'Accessories', 
    'Books', 
    'Documents', 
    'Keys', 
    'Other'
  ];
  
  onMount(async () => {
    try {
      // In a real app, this would fetch from the API
      // For now, we'll use mock data
      /* 
      items = await itemService.getLostItems();
      */
      
      // Mock data for demonstration
      setTimeout(() => {
        items = [
          {
            id: '1',
            title: 'iPhone 13 Pro',
            description: 'Lost my iPhone 13 Pro (blue) at Central Park near the fountain. It has a clear case with star stickers on the back.',
            category: 'Electronics',
            location: 'Central Park',
            date: '2023-04-15',
            status: 'lost',
            contactInfo: 'john@example.com',
            image: 'https://via.placeholder.com/300x200?text=iPhone'
          },
          {
            id: '2',
            title: 'Black Leather Wallet',
            description: 'Lost my wallet somewhere on Main Street. Contains ID, credit cards, and some cash.',
            category: 'Accessories',
            location: 'Main Street',
            date: '2023-04-16',
            status: 'lost',
            contactInfo: 'jane@example.com'
          },
          {
            id: '3',
            title: 'Car Keys with Red Keychain',
            description: 'Lost my car keys with a distinctive red keychain. Has Toyota logo and a small turtle charm.',
            category: 'Keys',
            location: 'Shopping Mall',
            date: '2023-04-17',
            status: 'lost',
            contactInfo: '555-123-4567',
            image: 'https://via.placeholder.com/300x200?text=Keys'
          }
        ];
        isLoading = false;
      }, 500);
    } catch (err) {
      console.error('Failed to load lost items:', err);
      error = 'Failed to load items. Please try again later.';
      isLoading = false;
    }
  });
  
  // Filter items based on search query and category
  $: filteredItems = items.filter(item => {
    const matchesSearch = searchQuery ? 
      item.title.toLowerCase().includes(searchQuery.toLowerCase()) || 
      item.description.toLowerCase().includes(searchQuery.toLowerCase()) : 
      true;
      
    const matchesCategory = selectedCategory ? 
      item.category === selectedCategory : 
      true;
      
    return matchesSearch && matchesCategory;
  });
  
  function handleViewItem(id: string) {
    // Navigate to item detail page
    window.location.href = `/items/${id}`;
  }
</script>

<div class="container mx-auto px-4 py-8">
  <div class="flex flex-col md:flex-row justify-between items-center mb-8">
    <h1 class="text-3xl font-bold mb-4 md:mb-0">Lost Items</h1>
    <a href="/report-lost" class="inline-block">
      <Button variant="primary">Report Lost Item</Button>
    </a>
  </div>
  
  <!-- Search and filter section -->
  <Card padding="md" shadow="sm" rounded="md" className="mb-8">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
      <div>
        <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Search</label>
        <input
          id="search"
          type="text"
          placeholder="Search for lost items..."
          bind:value={searchQuery}
          class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-orange-500"
        />
      </div>
      
      <div>
        <label for="category" class="block text-sm font-medium text-gray-700 mb-1">Category</label>
        <select
          id="category"
          bind:value={selectedCategory}
          class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-orange-500"
        >
          <option value="">All Categories</option>
          {#each categories as category}
            <option value={category}>{category}</option>
          {/each}
        </select>
      </div>
      
      <div class="flex items-end">
        <Button 
          variant="secondary" 
          on:click={() => { searchQuery = ''; selectedCategory = ''; }}
          className="w-full md:w-auto"
        >
          Clear Filters
        </Button>
      </div>
    </div>
  </Card>
  
  <!-- Loading state -->
  {#if isLoading}
    <div class="text-center py-12">
      <div class="inline-block animate-spin rounded-full h-8 w-8 border-t-2 border-b-2 border-orange-500 mb-2"></div>
      <p>Loading lost items...</p>
    </div>
  
  <!-- Error state -->
  {:else if error}
    <div class="text-center py-12 text-red-500">
      <p>{error}</p>
      <Button variant="primary" on:click={() => window.location.reload()} className="mt-4">
        Retry
      </Button>
    </div>
  
  <!-- Empty state -->
  {:else if filteredItems.length === 0}
    <div class="text-center py-12">
      <p class="text-lg mb-4">No lost items found matching your criteria.</p>
      {#if searchQuery || selectedCategory}
        <Button variant="secondary" on:click={() => { searchQuery = ''; selectedCategory = ''; }}>
          Clear Filters
        </Button>
      {:else}
        <p>Be the first to report a lost item!</p>
        <a href="/report-lost" class="inline-block mt-4">
          <Button variant="primary">Report Lost Item</Button>
        </a>
      {/if}
    </div>
  
  <!-- Results -->
  {:else}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
      {#each filteredItems as item (item.id)}
        <ItemCard 
          {item} 
          showActions={false}
          onView={handleViewItem}
        />
      {/each}
    </div>
  {/if}
</div> 