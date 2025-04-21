<script lang="ts">
  import { createEventDispatcher } from 'svelte';
  import Button from './Button.svelte';
  import type { Item } from '../services/itemService';
  import { uploadService } from '../services/uploadService';
  
  export let item: Partial<Item> = {
    title: '',
    description: '',
    category: '',
    location: '',
    date: new Date().toISOString().split('T')[0],
    status: 'lost',
    contactInfo: '',
  };
  
  export let isSubmitting = false;
  export let submitButtonText = 'Submit';
  
  const dispatch = createEventDispatcher<{
    submit: { item: Item };
    cancel: void;
  }>();
  
  const categories = [
    'Electronics', 
    'Clothing', 
    'Accessories', 
    'Books', 
    'Documents', 
    'Keys', 
    'Other'
  ];
  
  // File upload states
  let fileInput: HTMLInputElement;
  let selectedFile: File | null = null;
  let isUploading = false;
  let uploadError = '';
  let uploadPreview = item.image || '';
  
  // Handle file selection
  function handleFileChange(event: Event) {
    const input = event.target as HTMLInputElement;
    if (input.files && input.files.length > 0) {
      selectedFile = input.files[0];
      
      // Show preview for image files
      if (selectedFile.type.startsWith('image/')) {
        const reader = new FileReader();
        reader.onload = (e) => {
          uploadPreview = e.target?.result as string;
        };
        reader.readAsDataURL(selectedFile);
      }
    }
  }
  
  // Upload file
  async function uploadFile() {
    if (!selectedFile) return null;
    
    isUploading = true;
    uploadError = '';
    
    try {
      const result = await uploadService.uploadFile(selectedFile, 'items');
      
      if (result.success && result.file) {
        isUploading = false;
        return result.file.url;
      } else {
        uploadError = result.error || 'Upload failed';
        isUploading = false;
        return null;
      }
    } catch (error) {
      console.error('Error uploading file:', error);
      uploadError = 'An unexpected error occurred';
      isUploading = false;
      return null;
    }
  }
  
  // Remove file and clear preview
  function removeImage() {
    selectedFile = null;
    uploadPreview = '';
    item.image = '';
    
    // Reset file input
    if (fileInput) {
      fileInput.value = '';
    }
  }
  
  // Handle form submission
  async function handleSubmit() {
    // Upload file first if one is selected
    if (selectedFile) {
      const imageUrl = await uploadFile();
      if (imageUrl) {
        item.image = imageUrl;
      } else if (uploadError) {
        // Don't proceed if upload failed
        return;
      }
    }
    
    dispatch('submit', { item: item as Item });
  }
  
  function handleCancel() {
    dispatch('cancel');
  }
</script>

<form on:submit|preventDefault={handleSubmit} class="space-y-4">
  <div>
    <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
    <input
      id="title"
      type="text"
      class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500"
      bind:value={item.title}
      required
    />
  </div>
  
  <div>
    <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
    <textarea
      id="description"
      rows="3"
      class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500"
      bind:value={item.description}
      required
    ></textarea>
  </div>
  
  <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
    <div>
      <label for="category" class="block text-sm font-medium text-gray-700">Category</label>
      <select
        id="category"
        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500"
        bind:value={item.category}
        required
      >
        <option value="">Select a category</option>
        {#each categories as category}
          <option value={category}>{category}</option>
        {/each}
      </select>
    </div>
    
    <div>
      <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
      <select
        id="status"
        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500"
        bind:value={item.status}
        required
      >
        <option value="lost">Lost</option>
        <option value="found">Found</option>
      </select>
    </div>
  </div>
  
  <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
    <div>
      <label for="location" class="block text-sm font-medium text-gray-700">Location</label>
      <input
        id="location"
        type="text"
        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500"
        bind:value={item.location}
        required
      />
    </div>
    
    <div>
      <label for="date" class="block text-sm font-medium text-gray-700">Date</label>
      <input
        id="date"
        type="date"
        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500"
        bind:value={item.date}
        required
      />
    </div>
  </div>
  
  <div>
    <label for="contactInfo" class="block text-sm font-medium text-gray-700">Contact Information</label>
    <input
      id="contactInfo"
      type="text"
      class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500"
      bind:value={item.contactInfo}
      placeholder="Phone or email"
      required
    />
  </div>
  
  <!-- File upload section -->
  <div>
    <label class="block text-sm font-medium text-gray-700 mb-1">Item Image</label>
    
    <!-- Preview image if exists -->
    {#if uploadPreview}
      <div class="mt-2 relative rounded-md overflow-hidden" style="max-width: 300px;">
        <img src={uploadPreview} alt="Preview" class="w-full h-auto" />
        <button 
          type="button" 
          class="absolute top-2 right-2 bg-red-500 text-white rounded-full w-8 h-8 flex items-center justify-center hover:bg-red-600"
          on:click={removeImage}
        >
          ×
        </button>
      </div>
    {:else}
      <!-- File input -->
      <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md">
        <div class="space-y-1 text-center">
          <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
          </svg>
          <div class="flex text-sm text-gray-600">
            <label for="file-upload" class="relative cursor-pointer bg-white rounded-md font-medium text-orange-500 hover:text-orange-600">
              <span>Upload a file</span>
              <input 
                id="file-upload" 
                name="file-upload" 
                type="file" 
                class="sr-only"
                accept="image/*" 
                bind:this={fileInput}
                on:change={handleFileChange}
              />
            </label>
            <p class="pl-1">or drag and drop</p>
          </div>
          <p class="text-xs text-gray-500">PNG, JPG, GIF up to 5MB</p>
        </div>
      </div>
    {/if}
    
    <!-- Upload error message -->
    {#if uploadError}
      <p class="mt-1 text-sm text-red-600">{uploadError}</p>
    {/if}
  </div>
  
  <div class="flex justify-end space-x-3 pt-4">
    <Button type="button" variant="secondary" on:click={handleCancel} disabled={isSubmitting || isUploading}>Cancel</Button>
    <Button type="submit" disabled={isSubmitting || isUploading}>
      {#if isUploading}
        Uploading...
      {:else if isSubmitting}
        {submitButtonText}...
      {:else}
        {submitButtonText}
      {/if}
    </Button>
  </div>
</form> 