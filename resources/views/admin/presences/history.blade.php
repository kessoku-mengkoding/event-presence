@extends('layouts.admin')

@section('content')
  <div>
    <h1 class="mb-4 text-3xl font-bold">History Absensi</h1>

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
            Data Penduduk
          </th>
          <th scope="col" class="px-6 py-3">
            Data User
          </th>
          <th scope="col" class="px-6 py-3">
            Nama Kegiatan
          </th>
          <th scope="col" class="px-6 py-3">
            Nama Jadwal
          </th>
          <th scope="col" class="px-6 py-3">
            Waktu Absen
          </th>
          <th scope="col" class="px-6 py-3">
            Status
          </th>
          <th scope="col" class="px-6 py-3 text-center">
            Valid
          </th>
        </tr>
      </thead>
      <tbody>
        @foreach ($presences as $presence)
          <tr class="border-b bg-white hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:hover:bg-gray-600">
            <td class="w-4 p-4">
              {{ $loop->iteration }}
            </td>
            <th scope="row" class="whitespace-nowrap px-6 py-4 font-medium text-gray-900 dark:text-white">
              {{ optional($presence->user->resident)->full_name ?? '-' }}
            </th>
            <td class="px-6 py-4">
              Data Penduduk
            </td>
            <td class="px-6 py-4">
                Data User
            </td>
            <td class="px-6 py-4">
                {{ $presence->eventmember->event->name }}
            </td>
            <td class="px-6 py-4">
                {{ $presence->timetable->title }}
            </td>
            <td class="px-6 py-4">
                {{ $presence->created_at }}
            </td>
            <td class="px-6 py-4">
                {{ $presence->status == 'on time' ? 'Tepat Waktu' : 'Terlambat' }}
            </td>
            <td class="px-6 py-4 text-center">
                @if ($presence->is_valid)
                    <i class="fa-solid fa-circle-check text-green-500"></i>
                @else
                    <i class="fa-solid fa-circle-xmark text-red-500"></i>
                @endif
            </td>
            {{-- <td class="px-6 py-4 text-center">
              @if ($resident->user_id)
                <i class="fa-solid fa-circle-check cursor-pointer"
                  data-popover-target="popover-default{{ $resident->id }}"></i>

                <div data-popover id="popover-default{{ $resident->id }}" role="tooltip"
                  class="max-w-64 invisible absolute z-10 inline-block rounded-lg border border-gray-200 bg-white text-sm text-gray-500 opacity-0 shadow-sm transition-opacity duration-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-400">
                  <div
                    class="rounded-t-lg border-b border-gray-200 bg-gray-100 px-3 py-2 dark:border-gray-600 dark:bg-gray-700">
                    <h3 class="font-semibold text-gray-900 dark:text-white">Data User</h3>
                  </div>
                  <div class="px-6 py-3">
                    <ul class="text-left">
                      <li>Username: {{ $resident->user->username }}</li>
                      <li>Email: {{ $resident->user->email }}</li>
                      <li>Role: {{ $resident->user->is_admin ? 'Admin' : 'User' }}</li>
                    </ul>
                  </div>
                  <div data-popper-arrow></div>
                </div>
              @else
                <i class="fa-solid fa-circle-xmark text-red-500"></i>
              @endif
            </td> --}}
          </tr>
        @endforeach
        @if ($presences->count() == 0)
          <tr>
            <td colspan="7" class="p-4 text-center"><i
                class="fa-solid fa-triangle-exclamation mr-2 text-yellow-200"></i>Tidak Ada History Absensi</td>
          </tr>
        @endif
      </tbody>
    </table>
  </div>
@endsection
