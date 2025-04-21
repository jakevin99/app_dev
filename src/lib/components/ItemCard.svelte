<script lang="ts">
  import { onMount } from 'svelte';
  import Card from './Card.svelte';
  import Button from './Button.svelte';
  import { itemService, type Item } from '../services/itemService';

  export let item: Item;
  export let showActions = false;
  export let onView: (id: string) => void = () => {};
  export let onEdit: (id: string) => void = () => {};
  export let onDelete: (id: string) => void = () => {};

  let statusClass = '';

  // Determine tag color based on item status
  $: {
    statusClass = item.status === 'lost' 
      ? 'bg-red-500 text-white' 
      : 'bg-green-500 text-white';
  }

  // Maximum characters to show in description
  const MAX_DESC_LENGTH = 100;

  // Truncate description text if needed
  $: truncatedDescription = item.description.length > MAX_DESC_LENGTH
    ? `${item.description.slice(0, MAX_DESC_LENGTH)}...`
    : item.description;
</script>

<Card shadow="sm" padding="md" rounded="md">
  <div class="flex flex-col">
    <div class="flex justify-between items-start">
      <h2 class="text-lg font-bold">{item.title}</h2>
      <span class={`px-2 py-1 text-sm rounded-md ${statusClass}`}>
        {item.status.charAt(0).toUpperCase() + item.status.slice(1)}
      </span>
    </div>
    
    <div class="mt-2 text-sm text-gray-600">
      <div><span class="font-medium">Category:</span> {item.category}</div>
      <div><span class="font-medium">Location:</span> {item.location}</div>
      <div><span class="font-medium">Date:</span> {item.date}</div>
    </div>
    
    <p class="mt-2 text-gray-700">{truncatedDescription}</p>
    
    {#if item.image}
      <div class="mt-3">
        <img src={item.image} alt={item.title} class="w-full h-40 object-cover rounded" />
      </div>
    {/if}
    
    {#if showActions}
      <div class="mt-4 flex gap-2">
        <Button variant="primary" size="sm" on:click={() => onView(item.id || '')}>View</Button>
        <Button variant="secondary" size="sm" on:click={() => onEdit(item.id || '')}>Edit</Button>
        <Button variant="danger" size="sm" on:click={() => onDelete(item.id || '')}>Delete</Button>
      </div>
    {/if}
  </div>
</Card> 