<div class="border-b border-gray-800 bg-white shadow-md">
  <nav class="container mx-auto my-4 flex justify-between px-4 sm:px-8 lg:px-12">
    <ul class="hidden sm:flex items-center gap-8"> <!-- Hide on small screens -->
      <li class="hover:underline"><a href="/">Home</a></li>
      <li class="hover:underline"><a href="/events">Events</a></li>
      <li class="hover:underline"><a href="#">Statistic</a></li>
    </ul>

    <!-- Hamburger Menu -->
    <div class="flex sm:hidden items-center">
      <button id="menu-toggle" class="text-gray-800 focus:outline-none">
        <svg class="h-6 w-6" viewBox="0 0 24 24">
          <path
            fill="currentColor"
            d="M4 6h16M4 12h16m-7 6h7"
          ></path>
        </svg>
      </button>
    </div>

    {{-- <div class="flex items-center">Logo</div> --}}
    <ul id="responsive-menu" class="hidden sm:flex items-center gap-6">
      <li>
        <a href="/presences/history">
          <i class="fa-solid fa-clock-rotate-left fa-lg"></i>
        </a>
      </li>
      <li>
        <a href="/invitations" class="invitations-btn">
          <i class="fa-solid fa-paper-plane fa-lg"></i>
          <i class="fa-regular fa-paper-plane fa-lg"></i>
        </a>
      </li>
      <li>
        <a href="/notifications" class="notification-btn">
          <i class="fa-solid fa-bell fa-lg"></i>
          <i class="fa-regular fa-bell fa-lg"></i>
        </a>
      </li>

      <div class="dropdown relative inline-block">
        <div class="mt-1 inline-flex h-8 w-8 items-center overflow-clip rounded-full bg-gray-300">
          <img src="{{ auth()->user()->profile_picture_path }}" alt="Profile Picture">
        </div>
        <div class="dropdown-menu absolute right-0 z-[100] hidden pt-4 text-gray-700">
          <div class="w-[300px] rounded-xl border bg-white px-8 py-6 drop-shadow-lg">
            <a href="/profile/me" class="cursor-pointer">
              <div class="mx-auto h-24 w-24 overflow-clip rounded-full bg-gray-300">
                <img src="{{ auth()->user()->profile_picture_path }}" alt="Profile Picture">
              </div>
              <h1 class="text-gradient-pink-blue pt-2 text-center text-xl font-semibold">{{ auth()->user()->username }}
              </h1>
              <h3 class="pt-1 text-center text-sm">{{ auth()->user()->name }}</h3>
            </a>
            <hr class="my-3">
            <form action="/logout" method="POST"> @csrf @method('POST')
              <button
                class="whitespace-no-wrap block w-full text-left font-semibold text-red-500 hover:opacity-60">Logout</button>
            </form>
          </div>
        </div>
      </div>
    </ul>
  </nav>
</div>

<script>
  // JavaScript to toggle menu visibility
  const menuToggle = document.getElementById('menu-toggle');
  const responsiveMenu = document.getElementById('responsive-menu');

  menuToggle.addEventListener('click', () => {
    responsiveMenu.classList.toggle('hidden');
  });
</script>
