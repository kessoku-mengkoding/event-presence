@extends('layouts.admin')

@section('content')
  <div>
    <h1 class="mb-4 text-3xl font-bold">Daftar Penduduk</h1>
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
      <form action="{{ route('residentsAdminView', ['search' => request('search')]) }}">
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
            <input type="text" id="table-search" name="search"
              class="block w-80 rounded-lg border border-gray-300 bg-gray-50 ps-10 pt-2 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
              placeholder="Search for items">
          </div>
      </form>
    </div>
    @if ($is_search)
      <div class="mt-2">
        <span>Hasil Dari Pencarian </span>
        '{{ request('search') }}'
      </div>
    @endif
    <div class="mt-2">
      <span>{{ $is_search ? 'Total Penduduk Ditemukan:' : 'Total Penduduk:' }}</span>
      {{ $residents->count() }}
    </div>
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
            KK
          </th>
          <th scope="col" class="px-6 py-3">
            Alamat
          </th>
          <th scope="col" class="px-6 py-3">
            Terdaftar
          </th>
          <th scope="col" class="px-6 py-3">
            Action
          </th>
        </tr>
      </thead>
      <tbody>
        @foreach ($residents as $resident)
          <tr class="border-b bg-white hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:hover:bg-gray-600">
            <td class="w-4 p-4">
              {{ $loop->iteration }}
            </td>
            <th scope="row" class="whitespace-nowrap px-6 py-4 font-medium text-gray-900 dark:text-white">
              {{ $resident->full_name }}
            </th>
            <td class="px-6 py-4">
              {{ $resident->nik }}
            </td>
            <td class="px-6 py-4">
              {{ $resident->kk }}
            </td>
            <td class="px-6 py-4">
              {{ $resident->address }}
            </td>
            <td class="px-6 py-4 text-center">
              @if ($resident->user_id)
                <i class="fa-solid fa-pen-to-square text-green-500"></i>
              @else
                <i class="fa-solid fa-circle-xmark text-red-500"></i>
              @endif
            </td>
            <td class="flex items-center px-6 py-4">
              <a href="/residents/{{ $resident->id }}/edit"
                class="font-medium text-blue-600 hover:underline dark:text-blue-500">
                <i class="fa-solid fa-pen-to-square"></i>
              </a>
              <form action="{{ route('deleteResident') }}" method="POST">
                @csrf
                @method('DELETE')
                <input type="text" name="id" value="{{ $resident->id }}" hidden>
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
@endsection
