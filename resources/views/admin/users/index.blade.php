@extends('layouts.admin')

@section('content')
  <div>
    <h1 class="mb-4 text-3xl font-bold">Daftar User</h1>
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
      <div class="mt-2">Total User: {{ $users->count() }}</div>
      <table class="w-full text-left text-sm text-gray-500 rtl:text-right dark:text-gray-400">
        <thead class="bg-gray-50 text-xs uppercase text-gray-700 dark:bg-gray-700 dark:text-gray-400">
          <tr>
            <th scope="col" class="p-4">
              No
            </th>
            <th scope="col" class="px-6 py-3">
              Nama Lengkap
            </th>
            <th scope="col" class="px-6 py-3">
              Username
            </th>
            <th scope="col" class="px-6 py-3">
              Email
            </th>
            <th scope="col" class="px-6 py-3 text-center">
              Terverifikasi
            </th>
            <th scope="col" class="px-6 py-3">
              Action
            </th>
          </tr>
        </thead>
        <tbody>
          @foreach ($users as $user)
            <tr class="border-b bg-white hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:hover:bg-gray-600">
              <td class="w-4 p-4">
                {{ $loop->iteration }}
              </td>
              <th scope="row" class="whitespace-nowrap px-6 py-4 font-medium text-gray-900 dark:text-white">
                {{ optional($user->resident)->full_name ?? 'John Doe' }}
              </th>
              <td class="px-6 py-4">
                {{ $user->username }}
              </td>
              <td class="px-6 py-4">
                {{ $user->email }}
              </td>
              <td class="px-6 py-4 text-center">
                @if ($user->is_verified)
                  <i class="fa-solid fa-circle-xmark text-green-500"></i>
                @else
                  <i class="fa-solid fa-circle-xmark text-red-500"></i>
                @endif
              </td>
              <td class="flex items-center px-6 py-4">
                <form action="/admin/users" method="POST">
                  @csrf
                  @method('DELETE')
                  <input type="hidden" name="id" value="{{ $user->id }}">
                  <button class="ms-3 font-medium text-red-600 hover:underline dark:text-red-500">
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
@endsection
