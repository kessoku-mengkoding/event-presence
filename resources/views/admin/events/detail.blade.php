@extends('layouts.admin')

@section('content')
  <a href="/events/admin"
    class="mb-4 inline-block rounded-lg bg-blue-700 px-5 py-2.5 text-center text-sm font-medium text-white hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 sm:w-auto">Kembali</a>
  <h1 class="text-3xl font-bold">Kegiatan {{ $event->name }} </h1>
  <p class="mt-4">{{ $event->description }}</p>
  <p class="mt-4">Qr: {{ $event->qr_code_path }}</p>
  <img src="{{ $event->qr_code_path }}" alt="Join by QR Code">

  <div class="mt-8">
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
      <div class="flex justify-between justify-items-center bg-white pb-4 dark:bg-gray-900">
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
        <div>
          <button
            class="w-full rounded-lg bg-blue-700 px-5 py-2.5 text-center text-sm font-medium text-white hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 sm:w-auto">Tambah
            Anggota</button>
        </div>
      </div>
      <div class="mt-2">Total Anggota: {{ $event->eventmembers->count() }}</div>
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
              NIK
            </th>
            <th scope="col" class="px-6 py-3">
              Email
            </th>
            <th scope="col" class="px-6 py-3">
              Action
            </th>
          </tr>
        </thead>
        <tbody>
          @foreach ($event->eventmembers as $eventmember)
            <tr class="border-b bg-white hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:hover:bg-gray-600">
              <td class="w-4 p-4">
                {{ $loop->iteration }}
              </td>
              <th scope="row" class="whitespace-nowrap px-6 py-4 font-medium text-gray-900 dark:text-white">
                {{ $eventmember->user->resident->full_name }}
              </th>
              <td class="px-6 py-4">
                {{ $eventmember->user->resident->nik }}
              </td>
              <td class="px-6 py-4">
                {{ $eventmember->user->email }}
              </td>
              <td class="flex items-center px-6 py-4">
                {{-- <a href="#" class="font-medium text-blue-600 hover:underline dark:text-blue-500">Edit</a> --}}
                <a href="#" class="ms-3 font-medium text-red-600 hover:underline dark:text-red-500">Remove</a>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
@endsection
