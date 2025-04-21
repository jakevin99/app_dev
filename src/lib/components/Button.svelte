<script lang="ts">
  export let variant: 'primary' | 'secondary' | 'danger' = 'primary';
  export let type: 'button' | 'submit' | 'reset' = 'button';
  export let disabled = false;
  export let fullWidth = false;
  export let size: 'sm' | 'md' | 'lg' = 'md';
  export let className = '';

  // Map variants to Tailwind classes (DRY approach)
  const variantClasses = {
    primary: 'bg-orange-500 hover:bg-orange-600 text-white',
    secondary: 'bg-gray-200 hover:bg-gray-300 text-gray-800',
    danger: 'bg-red-500 hover:bg-red-600 text-white'
  };

  // Map sizes to Tailwind classes
  const sizeClasses = {
    sm: 'text-sm py-1 px-3',
    md: 'py-2 px-4',
    lg: 'text-lg py-3 px-6'
  };

  // Compute classes using Tailwind (following DRY principle)
  $: classes = `
    ${variantClasses[variant]}
    ${sizeClasses[size]}
    font-medium rounded transition duration-200
    ${fullWidth ? 'w-full' : ''}
    ${disabled ? 'opacity-50 cursor-not-allowed' : ''}
    ${className}
  `;
</script>

<button 
  {type} 
  {disabled} 
  class={classes}
  on:click
>
  <slot />
</button> 