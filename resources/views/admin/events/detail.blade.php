@extends('layouts.admin')

@section('content')
  <div class="mx-auto mb-12 text-center">
    <h1 class="text-3xl font-bold">
      <i class="fa-solid fa-cube mr-1.5"></i>
      Kegiatan {{ $event->name }}
    </h1>
    <p class="mx-auto mt-4 w-6/12">{{ $event->description }}</p>
    {{-- <img src="{{ $event->qr_code_path }}" alt="QR Code Kegiatan"> --}}

    <div class="mt-8">
      <a href="{{ route('timetablesAdminView', $event->id) }}"
        class="mb-2 me-2 rounded-lg bg-gradient-to-br from-purple-600 to-blue-500 px-5 py-2.5 text-center text-sm font-medium text-white hover:bg-gradient-to-bl focus:outline-none focus:ring-4 focus:ring-blue-300 dark:focus:ring-blue-800">Lihat
        Jadwal</a>
      <a href="{{ route('addMembersView', $event->id) }}"
        class="mb-2 me-2 rounded-lg bg-gradient-to-r from-red-200 via-red-300 to-yellow-200 px-5 py-2.5 text-center text-sm font-medium text-gray-900 hover:bg-gradient-to-bl focus:outline-none focus:ring-4 focus:ring-red-100 dark:focus:ring-red-400">Tambah
        Anggota</a>
    </div>
  </div>

  {{-- <form action="{{ route('eventDetailView', $event->id, ['search' => request('search')]) }}" class="flex gap-2">
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
    <a href="{{ route('eventDetailView', $event->id) }}"
      class="mb-2 me-2 rounded-lg bg-gradient-to-br from-pink-500 to-orange-400 px-5 py-2 text-center text-sm font-medium text-white hover:bg-gradient-to-bl focus:outline-none focus:ring-4 focus:ring-pink-200 dark:focus:ring-pink-800">Reset</a>
  </form> --}}

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
      <span>{{ $is_search ? 'Total member ditemukan:' : 'Total member:' }}</span>
      <span class="font-bold"> {{ $event->eventmembers->count() }} </span>
    </div>
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
          Username
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
            {{ optional($eventmember->user->resident)->full_name ?? '-' }}
          </th>
          <td class="px-6 py-4">
            {{ optional($eventmember->user->resident)->nik ?? '-' }}
          </td>
          <td class="px-6 py-4">
            {{ $eventmember->user->username ?? '-' }}
          </td>
          <td class="px-6 py-4">
            {{ $eventmember->user->email }}
          </td>
          <td class="flex items-center px-6 py-4">
            @include('components.modal-delete', [
                'name' => 'member',
                'id' => $eventmember->id,
                'action' => route('deleteMember', [$event->id, $eventmember->id]),
                'test' => optional($eventmember->user->resident)->full_name ?? '-',
                'input_name' => '',
            ])
          </td>
        </tr>
      @endforeach
      @if ($event->eventmembers->count() == 0)
        <tr>
          <td colspan="7" class="p-4 text-center"><i
              class="fa-solid fa-triangle-exclamation mr-2 text-yellow-200"></i>Member Kosong</td>
        </tr>
      @endif
    </tbody>
  </table>
  </div>
@endsection
