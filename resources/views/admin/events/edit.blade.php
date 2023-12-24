@extends('layouts.admin')

@section('content')
  <form class="max-w-sm" action="/events" method="POST">
    @csrf
    @method('PUT')
    <h1 class="mb-4 text-xl font-bold">Edit Kegiatan</h1>

    <input type="text" name="id" value="{{ $event->id }}" hidden>

    <div class="mb-5">
      <label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Nama Lengkap</label>
      <input type="text" name="name"
        class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
        placeholder="Rapat Umum" required value="{{ $event->name }}">
    </div>

    <div class="mb-5">
      <label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Alamat</label>
      <input type="text" name="description"
        class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
        placeholder="Jalan Menuju Surga 69" required value="{{ $event->description }}">
    </div>

    <button type="submit"
      class="w-full rounded-lg bg-blue-700 px-5 py-2.5 text-center text-sm font-medium text-white hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 sm:w-auto">Submit</button>
  </form>
@endsection
