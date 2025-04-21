<script lang="ts">
  import { itemService, type Item } from '$lib/services/itemService';
  import ItemForm from '$lib/components/ItemForm.svelte';
  import Card from '$lib/components/Card.svelte';
  
  let isSubmitting = false;
  let error = '';
  let success = false;
  
  // Create a new item with 'lost' status
  const initialItem: Partial<Item> = {
    title: '',
    description: '',
    category: '',
    location: '',
    date: new Date().toISOString().split('T')[0],
    status: 'lost',
    contactInfo: '',
  };
  
  async function handleSubmit(event: CustomEvent<{item: Item}>) {
    const { item } = event.detail;
    isSubmitting = true;
    error = '';
    
    try {
      // In a real app, this would send to the API
      /* 
      await itemService.createItem(item);
      */
      
      // Simulate API call for demonstration
      await new Promise(resolve => setTimeout(resolve, 1000));
      success = true;
      
      // Scroll to top to see success message
      window.scrollTo({ top: 0, behavior: 'smooth' });
    } catch (err) {
      console.error('Failed to submit lost item:', err);
      error = 'Failed to submit your lost item. Please try again.';
    } finally {
      isSubmitting = false;
    }
  }
  
  function handleCancel() {
    window.history.back();
  }
  
  function handleReportAnother() {
    success = false;
  }
</script>

<div class="container mx-auto px-4 py-8">
  <div class="max-w-2xl mx-auto">
    <h1 class="text-3xl font-bold mb-6">Report Lost Item</h1>
    
    {#if success}
      <Card padding="lg" className="bg-green-50 border-green-500 mb-8">
        <div class="text-center">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-green-500 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
          </svg>
          <h2 class="text-2xl font-bold text-green-800 mb-2">Successfully Reported!</h2>
          <p class="text-green-700 mb-6">Your lost item has been reported successfully. We'll notify you if someone finds it.</p>
          <div class="flex flex-col sm:flex-row justify-center gap-4">
            <button 
              class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 transition duration-200" 
              on:click={handleReportAnother}
            >
              Report Another Item
            </button>
            <a 
              href="/lost" 
              class="px-4 py-2 bg-gray-200 text-gray-800 rounded hover:bg-gray-300 transition duration-200"
            >
              View Lost Items
            </a>
          </div>
        </div>
      </Card>
    {:else}
      {#if error}
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
          <p>{error}</p>
        </div>
      {/if}
      
      <Card padding="lg" shadow="md" rounded="md">
        <p class="mb-6 text-gray-600">
          Please provide as much detail as possible about your lost item. This will increase the chances of someone finding and returning it to you.
        </p>
        
        <ItemForm 
          item={initialItem} 
          {isSubmitting}
          submitButtonText="Report Lost Item"
          on:submit={handleSubmit}
          on:cancel={handleCancel}
        />
      </Card>
    {/if}
  </div>
</div> 