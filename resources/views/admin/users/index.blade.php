@extends('layouts.admin')

@section('content')
  <div>
    <h1 class="mb-4 text-3xl font-bold">Daftar User</h1>
    <form action="{{ route('usersAdminView', ['search' => request('search')]) }}" class="flex gap-2">
      <div class="relative w-full overflow-x-auto sm:rounded-lg">
        <label for="table-search" class="sr-only">Search</label>
        <div class="rtl:inset-r-0 pointer-events-none absolute inset-y-0 start-0 flex w-full items-center pb-1 ps-3">
          <svg class="h-4 w-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
            fill="none" viewBox="0 0 20 20">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
          </svg>
        </div>
        <input type="text" id="table-search" name="search"
          class="block w-full rounded-lg border border-gray-300 bg-gray-50 ps-10 pt-2 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
          placeholder="Search for items">
      </div>
      <button type="submit"
        class="mb-2 me-2 ml-3 rounded-lg bg-gradient-to-r from-cyan-500 to-blue-500 px-5 py-2 text-center text-sm font-medium text-white hover:bg-gradient-to-bl focus:outline-none focus:ring-4 focus:ring-cyan-300 dark:focus:ring-cyan-800">Search</button>
      <a href="{{ route('usersAdminView') }}"
        class="mb-2 me-2 rounded-lg bg-gradient-to-br from-pink-500 to-orange-400 px-5 py-2 text-center text-sm font-medium text-white hover:bg-gradient-to-bl focus:outline-none focus:ring-4 focus:ring-pink-200 dark:focus:ring-pink-800">Reset</a>
    </form>

    <div class="my-4">
      @if ($is_search)
        <div class="mt-2">
          <i class="fa-solid fa-square-poll-vertical"></i>
          <span>Hasil dari pencarian </span>
          <span class="font-bold">'{{ request('search') }}'</span>
        </div>
      @endif
      <div class="mt-2">
        <i class="fa-solid fa-file"></i>
        <span>{{ $is_search ? 'Total user ditemukan:' : 'Total user:' }}</span>
        <span class="font-bold"> {{ $users->count() }} </span>
      </div>
    </div>

    <table class="w-full text-left text-sm text-gray-500 rtl:text-right dark:text-gray-400">
      <thead class="bg-gray-50 text-xs uppercase text-gray-700 dark:bg-gray-700 dark:text-gray-400">
        <tr>
          <th scope="col" class="p-4">
            No
          </th>
          <th scope="col" class="px-6 py-3">
            Username
          </th>
          <th scope="col" class="px-6 py-3">
            Email
          </th>
          <th scope="col" class="px-6 py-3 text-center">
            Data Penduduk
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
            <td class="px-6 py-4">
              {{ $user->username }}
            </td>
            <td class="px-6 py-4">
              {{ $user->email }}
            </td>
            <td class="px-6 py-4 text-center">
              <i class="fa-solid fa-circle-info cursor-pointer"
                data-popover-target="popover-default{{ $user->id }}"></i>

              <div data-popover id="popover-default{{ $user->id }}" role="tooltip"
                class="max-w-64 invisible absolute z-10 inline-block rounded-lg border border-gray-200 bg-white text-sm text-gray-500 opacity-0 shadow-sm transition-opacity duration-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-400">
                <div
                  class="rounded-t-lg border-b border-gray-200 bg-gray-100 px-3 py-2 dark:border-gray-600 dark:bg-gray-700">
                  <h3 class="font-semibold text-gray-900 dark:text-white">Data Penduduk</h3>
                </div>
                <div class="px-6 py-3">
                  <ul class="text-left">
                    @if ($user->resident)
                      <li>Nama Lengkap: {{ optional($user->resident)->full_name }}</li>
                      <li>NIK: {{ optional($user->resident)->nik }}</li>
                      <li>KK: {{ optional($user->resident)->kk }}</li>
                      <li>Alamat: {{ optional($user->resident)->address }}</li>
                    @else
                      <li>Tidak terdaftar dalam penduduk</li>
                    @endif
                  </ul>
                </div>
                <div data-popper-arrow></div>
              </div>
            </td>

            <td class="flex items-center px-6 py-4">
              <a href="{{ route('editUserFromAdminView', $user->id)}}"
                class="font-medium text-blue-600 hover:underline dark:text-blue-500">
                <i class="fa-solid fa-pen-to-square"></i>
              </a>

              @include('components.modal-delete', [
                  'name' => 'user',
                  'input_name' => 'id',
                  'id' => $user->id,
                  'test' => $user->username,
                  'action' => '/admin/users',
              ])
            </td>
          </tr>
        @endforeach
        @if ($users->count() == 0)
          <tr>
            <td colspan="7" class="p-4 text-center"><i
                class="fa-solid fa-triangle-exclamation mr-2 text-yellow-200"></i>User Tidak Ditemukan</td>
          </tr>
        @endif
      </tbody>
    </table>
  </div>
@endsection
