@extends('layouts.admin')

@section('content')
  <h1 class="text-3xl font-bold">Tambah member pada kegiatan {{ $event->name }} </h1>
  <div class="mt-8">
    <div class="relative overflow-x-auto sm:rounded-lg">
      <form action="{{ route('addMembers') }}" method="POST">
        @csrf
        <input type="text" name="event_id" value="{{ $event->id }}" hidden>
        <table class="w-full text-left text-sm text-gray-500 shadow-md rtl:text-right dark:text-gray-400">
          <thead class="bg-gray-50 text-xs uppercase text-gray-700 dark:bg-gray-700 dark:text-gray-400">
            <tr>
              <th scope="col" class="p-4">
                No
              </th>
              <th scope="col" class="p-4">
                Select
              </th>
              <th scope="col" class="px-6 py-3">
                Username
              </th>
              <th scope="col" class="px-6 py-3">
                Nama Lengkap
              </th>
              <th scope="col" class="px-6 py-3">
                NIK
              </th>
            </tr>
          </thead>
          <tbody>
            @foreach ($users as $user)
              <tr class="border-b bg-white hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:hover:bg-gray-600">
                <td class="w-4 p-4">
                  {{ $loop->iteration }}
                </td>
                <td class="w-4 p-4">
                  <div class="flex items-center">
                    <input id="checkbox-table-search-{{ $loop->iteration }}" type="checkbox" name="user_ids[]"
                      value="{{ $user->id }}"
                      class="h-4 w-4 rounded border-gray-300 bg-gray-100 text-blue-600 focus:ring-2 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:ring-offset-gray-800 dark:focus:ring-blue-600 dark:focus:ring-offset-gray-800">
                    <label for="checkbox-table-search-{{ $loop->iteration }}" class="sr-only">checkbox</label>
                  </div>
                </td>
                <th scope="row" class="whitespace-nowrap px-6 py-4 font-medium text-gray-900 dark:text-white">
                  {{ optional($user)->username ?? '-' }}
                </th>
                <td class="px-6 py-4">
                  {{ optional($user->resident)->fullname ?? '-' }}
                </td>
                <td class="px-6 py-4">
                  {{ optional($user->resident)->nik ?? '-' }}
                </td>
              </tr>
            @endforeach
            @if ($users->count() == 0)
              <tr>
                <td colspan="7" class="p-4 text-center"><i
                    class="fa-solid fa-triangle-exclamation mr-2 text-yellow-200"></i>Tidak ada user yang bisa ditambahkan
                </td>
              </tr>
            @endif
          </tbody>
        </table>
        <button
          class="mt-6 mb-2 me-2 rounded-lg bg-gradient-to-r from-cyan-500 to-blue-500 px-5 py-2.5 text-center text-sm font-medium text-white hover:bg-gradient-to-bl focus:outline-none focus:ring-4 focus:ring-cyan-300 dark:focus:ring-cyan-800">Tambahkan</button>
      </form>
    </div>
  </div>
@endsection
