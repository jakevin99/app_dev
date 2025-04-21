<script lang="ts">
  export let title = '';
  export let padding: 'none' | 'sm' | 'md' | 'lg' = 'md';
  export let shadow: 'none' | 'sm' | 'md' | 'lg' = 'md';
  export let rounded: 'none' | 'sm' | 'md' | 'lg' = 'md';
  export let bgColor = 'bg-white';
  export let className = '';

  // Map options to Tailwind classes (DRY approach)
  const paddingClasses = {
    none: 'p-0',
    sm: 'p-2',
    md: 'p-4',
    lg: 'p-6'
  };

  const shadowClasses = {
    none: '',
    sm: 'shadow-sm',
    md: 'shadow',
    lg: 'shadow-lg'
  };

  const roundedClasses = {
    none: 'rounded-none',
    sm: 'rounded-sm',
    md: 'rounded',
    lg: 'rounded-lg'
  };

  // Compute classes using Tailwind (following DRY principle)
  $: classes = `
    ${bgColor}
    ${paddingClasses[padding]}
    ${shadowClasses[shadow]}
    ${roundedClasses[rounded]}
    border border-gray-200
    ${className}
  `;
</script>

<div class={classes}>
  {#if title}
    <div class="font-bold text-lg mb-2">{title}</div>
  {/if}
  <slot />
</div> 