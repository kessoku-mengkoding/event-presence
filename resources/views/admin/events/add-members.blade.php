@extends('layouts.admin')

@section('content')
  <h1 class="text-3xl font-bold">Tambah member pada kegiatan {{ $event->name }} </h1>
  <div class="mt-6">

    <div class="mx-auto w-36 cursor-pointer text-center" data-popover-target="popover-right" data-popover-placement="right"
      type="button">
      <img src="{{ $event->qr_code_path }}" alt="QR Code">
    </div>
    <div data-popover id="popover-right" role="tooltip"
      class="invisible absolute z-10 inline-block w-64 rounded-lg border border-gray-200 bg-white text-sm text-gray-500 opacity-0 shadow-sm transition-opacity duration-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-400">
      <div class="rounded-t-lg border-b border-gray-200 bg-gray-100 px-3 py-2 dark:border-gray-600 dark:bg-gray-700">
        <h3 class="font-semibold text-gray-900 dark:text-white">Deskripsi</h3>
      </div>
      <div class="px-3 py-2">
        <p>Bagikan QR Code ini kepada penduduk yang telah mendaftar</p>
      </div>
      <div data-popper-arrow></div>
    </div>

    <div class="relative inline-flex w-full items-center justify-center mb-4">
      <hr class="my-8 h-px w-full border-0 bg-slate-300">
      <span class="absolute left-1/2 -translate-x-1/2 bg-white px-3 text-sm text-black/50">atau tambahkan lewat tabel imi</span>
    </div>

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
          class="mb-2 me-2 mt-6 rounded-lg bg-gradient-to-r from-cyan-500 to-blue-500 px-5 py-2.5 text-center text-sm font-medium text-white hover:bg-gradient-to-bl focus:outline-none focus:ring-4 focus:ring-cyan-300 dark:focus:ring-cyan-800">Tambahkan</button>
      </form>
    </div>
  </div>
@endsection
