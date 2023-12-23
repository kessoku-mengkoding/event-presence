@extends('layouts.admin')

@section('content')
  @if (session('message'))
    <div id="toast-simple"
      class="space-x mb-5 flex w-full max-w-xs items-center gap-4 space-x-4 divide-x divide-gray-200 rounded-lg bg-white p-4 text-gray-500 shadow rtl:space-x-reverse rtl:divide-x-reverse dark:divide-gray-700 dark:bg-gray-800 dark:text-gray-400"
      role="alert">
      <svg class="h-5 w-5 rotate-45 text-blue-600 dark:text-blue-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
        fill="none" viewBox="0 0 18 20">
        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
          d="m9 17 8 2L9 1 1 19l8-2Zm0 0V9" />
      </svg>
      <div class="ps-4 text-sm font-normal">
        {{ session('message') }}
      </div>
    </div>
  @endif

  <form class="max-w-sm" action="/residents/create" method="POST">
    @csrf
    <h1 class="mb-4 text-xl font-bold">Tambah Penduduk</h1>

    <div class="mb-5">
      <label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Nama Lengkap</label>
      <input type="text" name="full_name"
        class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
        placeholder="Aditya Mahendra" required>
    </div>

    <div class="mb-5">
      <label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">NIK</label>
      <input type="text" name="nik" maxlength="16"
        class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
        placeholder="xxxxxxxxxxxxxxxx" required>
    </div>

    <div class="mb-5">
      <label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">KK</label>
      <input type="text" name="kk" maxlength="16"
        class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
        placeholder="xxxxxxxxxxxxxxxx" required>
    </div>

    <div class="mb-5">
      <label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Alamat</label>
      <input type="text" name="address"
        class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
        placeholder="Jalan Menuju Surga 69" required>
    </div>

    <button type="submit"
      class="w-full rounded-lg bg-blue-700 px-5 py-2.5 text-center text-sm font-medium text-white hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 sm:w-auto">Submit</button>
  </form>
@endsection
