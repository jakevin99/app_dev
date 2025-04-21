<script>
  import '../app.css';
  import { page } from '$app/stores';
</script>

<div class="min-h-screen flex flex-col">
  <!-- Header -->
  <header class="bg-[#4a3b26] text-white shadow">
    <div class="container mx-auto px-4 py-3 flex justify-between items-center">
      <div class="flex items-center">
        <div class="w-12 h-12 bg-white rounded-md mr-3"></div>
        <div>
          <h1 class="font-bold text-xl">Lost And Found</h1>
          <div class="text-xs">Management System</div>
        </div>
      </div>
      
      <nav>
        <ul class="flex space-x-6">
          <li>
            <a href="/" class={$page.url.pathname === '/' ? 'font-bold' : ''}>
              Home
            </a>
          </li>
          <li>
            <a href="/lost" class={$page.url.pathname === '/lost' ? 'font-bold' : ''}>
              Lost
            </a>
          </li>
          <li>
            <a href="/found" class={$page.url.pathname === '/found' ? 'font-bold' : ''}>
              Found
            </a>
          </li>
          <li>
            <a href="/report-lost" class={$page.url.pathname === '/report-lost' ? 'font-bold' : ''}>
              Report Lost
            </a>
          </li>
          <li>
            <a 
              href="/signup" 
              class="bg-orange-500 hover:bg-orange-600 px-4 py-2 rounded font-medium transition"
            >
              Sign Up
            </a>
          </li>
        </ul>
      </nav>
    </div>
  </header>

  <!-- Main content -->
  <main class="flex-grow">
    <slot />
  </main>

  <!-- Footer -->
  <footer class="bg-[#f2e3c0] py-10">
    <div class="container mx-auto px-4">
      <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <div>
          <h3 class="font-bold text-lg mb-3">Help</h3>
          <ul class="space-y-1">
            <li>1231</li>
            <li>1234</li>
            <li>1234</li>
            <li>124</li>
          </ul>
        </div>
        
        <div>
          <h3 class="font-bold text-lg mb-3">Links</h3>
          <ul class="space-y-1">
            <li>1231</li>
            <li>1234</li>
            <li>1234</li>
            <li>124</li>
          </ul>
        </div>
        
        <div>
          <h3 class="font-bold text-lg mb-3">Contact</h3>
          <ul class="space-y-1">
            <li>1231</li>
            <li>1234</li>
            <li>1234</li>
            <li>124</li>
          </ul>
        </div>
      </div>
    </div>
  </footer>
</div> 