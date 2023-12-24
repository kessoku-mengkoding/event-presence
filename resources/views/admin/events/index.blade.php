@extends('layouts.admin')

@section('content')
  <div>
    <h1 class="mb-4 text-3xl font-bold">Daftar Kegiatan</h1>
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
      <div class="bg-white pb-4 dark:bg-gray-900">
        <label for="table-search" class="sr-only">Search</label>
        <div class="relative mt-1">
          <div class="rtl:inset-r-0 pointer-events-none absolute inset-y-0 start-0 flex items-center ps-3">
            <svg class="h-4 w-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
              fill="none" viewBox="0 0 20 20">
              <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
            </svg>
          </div>
          <input type="text" id="table-search"
            class="block w-80 rounded-lg border border-gray-300 bg-gray-50 ps-10 pt-2 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
            placeholder="Search for items">
        </div>
      </div>
      <table class="w-full text-left text-sm text-gray-500 rtl:text-right dark:text-gray-400">
        <thead class="bg-gray-50 text-xs uppercase text-gray-700 dark:bg-gray-700 dark:text-gray-400">
          <tr>
            <th scope="col" class="p-4">
              No
            </th>
            <th scope="col" class="px-6 py-3">
              Nama Kegiatan
            </th>
            <th scope="col" class="px-6 py-3 text-center">
              Jumlah Member
            </th>
            <th scope="col" class="px-6 py-3">
              Action
            </th>
          </tr>
        </thead>
        <tbody>
          @foreach ($events as $event)
            <tr class="border-b bg-white hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:hover:bg-gray-600">
              <td class="w-4 p-4">
                {{ $loop->iteration }}
              </td>
              <th scope="row" class="flex whitespace-nowrap px-6 py-4 font-medium text-gray-900 dark:text-white">
                <div class="my-auto h-5 w-5 overflow-hidden rounded-full border">
                  <img src="{{ $event->image_path }}">
                </div>
                <div class="ml-2">{{ $event->name }}</div>
              </th>
              <td class="px-6 py-4 text-center">
                {{ $event->eventmembers->count() }}
              </td>
              <td class="flex items-center px-6 py-4">
                <a href="/events/{{ $event->id }}/detail"
                  class="mr-4 font-medium text-blue-600 hover:underline dark:text-blue-500">
                  <i class="fa-solid fa-circle-info text-black"></i>
                </a>
                <a href="/admin/events/{{ $event->id }}/edit"
                  class="font-medium text-blue-600 hover:underline dark:text-blue-500">
                  <i class="fa-solid fa-pen-to-square"></i>
                </a>
                <form action="/events/{{ $event->id }}" method="POST">
                  @csrf
                  @method('DELETE')
                  <button href="#" class="ms-3 font-medium text-red-600 hover:underline dark:text-red-500">
                    <i class="fa-solid fa-trash-can"></i>
                  </button>
                </form>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
  {{-- <div class="w-full">
    @if (!sizeof($eventmembers))
      <div class="my-4">
        <img class="mx-auto" width="500"
          src="https://cdn.dribbble.com/assets/art-banners/live-ch-2-06c2d22b44499770d946df4be0064fe7f6d22e30664016542a42d8221ff25fb0.jpg"
          alt="">
        <p class="mx-auto max-w-xl text-center font-thin">Say goodbye to manual attendance tracking and embrace a world
          of efficiency,
          accuracy, and convenience. Whether you're a school, business, or organization of any size, our attendance app is
          designed to streamline your processes and elevate your productivity.
        </p>
        <div class="mt-8 flex items-center justify-center gap-4">
          @if (Auth::user()->is_admin)
            <a href="/events/create" class="btn-sm-no-color bg-yellow-100/50 font-semibold text-black hover:bg-yellow-100">
              Create Event
            </a>
          @else
            <a class="btn-border block" href="/events/join">Join Event</a>
          @endif
        </div>
      @else
        <div class="mx-auto max-w-2xl">
          <h1 class="text-gradient-coral-yellow-dark mt-12 text-3xl font-bold">Events</h1>
        </div>
        <div class="mx-auto mt-8 flex max-w-2xl flex-col items-center justify-center gap-6">
          <div class="flex w-full items-center justify-center gap-4 rounded-lg border py-8 shadow-md">
            @if (Auth::user()->is_admin)
              <a href="/events/create"
                class="btn-sm-no-color bg-yellow-100/50 font-semibold text-black hover:bg-yellow-100">Create
              </a>
            @else
              <a class="btn-primary-sm" href="/events/join">Join </a>
            @endif
          </div>
          @foreach ($eventmembers as $member)
            <a href="{{ '/events/' . $member->event->id . '/detail' }}"
              class="event-card relative flex w-full items-center gap-6 overflow-clip rounded-lg border px-6 py-5 shadow-md">
              <div class="flex h-16 w-16 overflow-clip rounded-full bg-black">
                <img class="object-fill"
                  src="{{ $member->event->image_path ? $member->event->image_path : 'https://images.unsplash.com/photo-1596367407372-96cb88503db6?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80' }}"
                  alt="">
              </div>
              <div class="flex items-center justify-between">
                <div>
                  <h1 class="text-2xl font-semibold">{{ $member->event->name }}</h1>
                  <div>
                    <i class="fa-regular fa-user"></i>
                    <span>{{ sizeof($member->event->eventmembers) }}</span>
                  </div>
                </div>
                <div class="absolute right-6">
                  <i class="fa-regular fa-star fa-xl"></i>
                </div>
              </div>
            </a>
          @endforeach
        </div>
    @endif
  </div> --}}
@endsection
