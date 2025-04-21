<script lang="ts">
  import Button from '$lib/components/Button.svelte';
  import { onMount } from 'svelte';
  
  let heroImage: HTMLImageElement;
  
  function handleImageError(event: Event) {
    const img = event.target as HTMLImageElement;
    img.src = 'https://via.placeholder.com/500x400?text=Lost+and+Found+Illustration';
  }
</script>

<section class="bg-[#fef8d8] py-16">
  <div class="container mx-auto px-4">
    <div class="flex flex-col md:flex-row items-center justify-between">
      <!-- Left column - hero text -->
      <div class="md:w-1/2 mb-8 md:mb-0">
        <h1 class="text-5xl font-bold leading-tight mb-6">
          Where lost <br />
          items find <br />
          their way back <br />
          home
        </h1>
        <Button size="lg">Sign Up</Button>
      </div>
      
      <!-- Right column - hero image -->
      <div class="md:w-1/2 relative">
        <img 
          bind:this={heroImage}
          src="/images/personholdingmagnifying.png" 
          alt="Person searching with magnifying glass" 
          class="max-w-full"
          on:error={handleImageError}
        />
      </div>
    </div>
  </div>
</section>

<section class="py-16">
  <div class="container mx-auto px-4">
    <h2 class="text-3xl font-bold text-center mb-12">How It Works</h2>
    
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
      <div class="text-center">
        <div class="bg-orange-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8 text-orange-500">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
          </svg>
        </div>
        <h3 class="text-xl font-bold mb-2">Report a Loss</h3>
        <p class="text-gray-600">Register and submit details about your lost item, including when and where it was lost.</p>
      </div>
      
      <div class="text-center">
        <div class="bg-orange-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8 text-orange-500">
            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
          </svg>
        </div>
        <h3 class="text-xl font-bold mb-2">Search for Items</h3>
        <p class="text-gray-600">Browse our database of found items to see if someone has found what you lost.</p>
      </div>
      
      <div class="text-center">
        <div class="bg-orange-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8 text-orange-500">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15.182 15.182a4.5 4.5 0 01-6.364 0M21 12a9 9 0 11-18 0 9 9 0 0118 0zM9.75 9.75c0 .414-.168.75-.375.75S9 10.164 9 9.75 9.168 9 9.375 9s.375.336.375.75zm-.375 0h.008v.015h-.008V9.75zm5.625 0c0 .414-.168.75-.375.75s-.375-.336-.375-.75.168-.75.375-.75.375.336.375.75zm-.375 0h.008v.015h-.008V9.75z" />
          </svg>
        </div>
        <h3 class="text-xl font-bold mb-2">Get Reunited</h3>
        <p class="text-gray-600">Arrange to meet with the finder to retrieve your belongings safely.</p>
      </div>
    </div>
  </div>
</section>

<section class="bg-gray-100 py-16">
  <div class="container mx-auto px-4">
    <h2 class="text-3xl font-bold text-center mb-12">Recent Items</h2>
    
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
      <!-- These would be populated from API data in a real implementation -->
      {#each Array(3) as _, i}
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
          <div class="p-6">
            <div class="flex justify-between items-start mb-4">
              <h3 class="font-bold text-lg">Sample Item {i + 1}</h3>
              <span class={`px-2 py-1 text-sm rounded ${i % 2 === 0 ? 'bg-red-500 text-white' : 'bg-green-500 text-white'}`}>
                {i % 2 === 0 ? 'Lost' : 'Found'}  
              </span>
            </div>
            <p class="text-gray-600 mb-4">This is a sample description of the item. It might include details about the appearance, when and where it was found or lost.</p>
            <Button variant="primary" size="sm">View Details</Button>
          </div>
        </div>
      {/each}
    </div>
    
    <div class="text-center mt-8">
      <Button variant="secondary" size="lg">View All Items</Button>
    </div>
  </div>
</section>
