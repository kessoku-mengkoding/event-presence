<nav class="container mx-auto my-4 flex justify-between px-4 sm:px-8 lg:px-12">
  <ul class="flex items-center gap-8">
    <li class="hover:underline"><a href="/">Home</a></li>
    <li class="hover:underline"><a href="/groups">Groups</a></li>
    <li class="hover:underline">Statistic</li>
  </ul>
  <div class="flex items-center">Logo</div>
  <ul class="flex items-center gap-8">
    <li class="hover:underline">Notification</li>
    <li class="hover:underline">Invitation</li>

    <div class="dropdown relative inline-block">
      <div class="mt-1 inline-flex h-12 w-12 items-center overflow-clip rounded-full bg-gray-300">
        <img src="{{ auth()->user()->profile_picture_path }}" alt="Profile Picture">
      </div>
      <div class="dropdown-menu absolute right-0 hidden pt-4 text-gray-700">
        <div class="w-[300px] rounded-xl border bg-white p-8">
          <a href="/profile/me" class="cursor-pointer">
            <div class="mx-auto h-24 w-24 overflow-clip rounded-full bg-gray-300">
              <img src="{{ auth()->user()->profile_picture_path }}" alt="Profile Picture">
            </div>
            <h1 class="mt-2 text-center text-xl font-semibold">{{ auth()->user()->username }}</h1>
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