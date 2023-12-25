@extends('layouts.admin')

@section('content')
  <div class="mx-auto flex items-center justify-center gap-3 text-center">
    <i class="fa-solid fa-calendar-days fa-2xl mr-1.5"></i>
    <h1 class="text-3xl font-bold">Jadwal {{ $timetable->title }}</h1>
    @if ($timetable_status == 'Upcoming')
      <div class="rounded-2xl bg-yellow-500 px-2 py-1 font-semibold text-white">Upcoming</div>
    @elseif($timetable_status == 'Ongoing')
      <div class="rounded-2xl bg-blue-500 px-2 py-1 font-semibold text-white">Ongoing</div>
    @else
      <div class="rounded-2xl bg-red-500 px-2 py-1 font-semibold text-white">Ended</div>
    @endif
  </div>
  <h1 class="text-center text-xl font-bold">Kegiatan {{ $event->name }}</h1>

  <div class="mx-auto my-8 w-36 cursor-pointer text-center" data-popover-target="popover-right"
    data-popover-placement="right" type="button">
    <img src="{{ $event->qr_code_path }}" alt="QR Code">
  </div>
  <div data-popover id="popover-right" role="tooltip"
    class="invisible absolute z-10 inline-block w-64 rounded-lg border border-gray-200 bg-white text-sm text-gray-500 opacity-0 shadow-sm transition-opacity duration-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-400">
    <div class="rounded-t-lg border-b border-gray-200 bg-gray-100 px-3 py-2 dark:border-gray-600 dark:bg-gray-700">
      <h3 class="font-semibold text-gray-900 dark:text-white">Deskripsi</h3>
    </div>
    <div class="px-3 py-2">
      <p>QR Code ini dapat digunakan untuk absensi jadwal ini</p>
    </div>
    <div data-popper-arrow></div>
  </div>

  <div class="text-center">
    <h2 class="font-bold">{{ $timetable->start }}
      <span class="font-normal">sampai</span>
      {{ $timetable->end }}
    </h2>
    <p>Berlokasi di {{ $timetable->address }} ({{ $timetable->latitude }}, {{ $timetable->longitude }})</p>
    <p>Absensi hanya berlaku radius
      <span class="font-bold">
        {{ $timetable->radius_meter }} meter
      </span>
      dari lokasi
    </p>
  </div>

  {{-- total --}}
  <div class="my-8 text-left">
    <div class="mt-2">
      <i class="fa-solid fa-file"></i>
      <span>Total absensi:</span>
      <span class="font-bold"> {{ $presences->count() }} </span>
    </div>
    <div class="mt-2">
      <i class="fa-solid fa-file"></i>
      <span>Total absensi tepat waktu:</span>
      <span class="font-bold"> {{ $presences->where('status', 'on time')->count() }} </span>
    </div>
    <div class="mt-2">
      <i class="fa-solid fa-file"></i>
      <span>Total absensi terlambat:</span>
      <span class="font-bold"> {{ $presences->where('status', 'late')->count() }} </span>
    </div>
    {{-- belum absen --}}
    <div class="mt-2">
      <i class="fa-solid fa-file"></i>
      <span>Total penduduk belum absen:</span>
      <span class="font-bold"> {{ $eventmembers->count() - $presences->count() }} </span>
    </div>
    <div class="mt-2">
      <i class="fa-solid fa-file"></i>
      <span>Total absensi tidak valid:</span>
      <span class="font-bold"> {{ $presences->where('is_valid', false)->count() }} </span>
    </div>
  </div>

  <h2 class="text-left font-bold">Tabel Absensi</h2>
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
          Waktu Absen
        </th>
        <th scope="col" class="px-6 py-3">
          Koordinat (lat, long)
        </th>
        <th scope="col" class="px-6 py-3">
          Jarak Absen (meter)
        </th>
        <th scope="col" class="px-6 py-3">
          Terlambat (menit)
        <th scope="col" class="px-6 py-3">
          Status
        </th>
        </th>
        <th scope="col" class="px-6 py-3 text-center">
          Absen Valid
        </th>
        {{-- <th scope="col" class="px-6 py-3">
            Action
          </th> --}}
      </tr>
    </thead>
    <tbody>
      @foreach ($presences as $key => $presence)
        <tr class="border-b bg-white hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:hover:bg-gray-600">
          <td class="w-4 p-4">
            {{ $loop->iteration }}
          </td>
          <th scope="row" class="whitespace-nowrap px-6 py-4 font-medium text-gray-900 dark:text-white">
            {{ optional($presence->user->resident)->full_name ?? '-' }}
          </th>
          <td class="px-6 py-4">
            {{ $presence->created_at }}
          </td>
          <td class="px-6 py-4">
            {{ $presence->latitude }}, {{ $presence->longitude }}
          </td>
          <td class="px-6 py-4">
            {{ $presences_location_distance[$key] }}
          </td>
          <td class="px-6 py-4">
            {{ $presence->status == 'on time' ? '0' : $presences_late_duration[$key] }}
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
        </tr>
      @endforeach
      @if ($presences->count() == 0)
        <tr>
          <td colspan="7" class="p-4 text-center"><i
              class="fa-solid fa-triangle-exclamation mr-2 text-yellow-200"></i>Penduduk Tidak Ditemukan</td>
        </tr>
      @endif
    </tbody>
  </table>


  <h2 class="mt-8 text-left font-bold">Tabel Member (Penduduk) Belum Absen</h2>
  <table class="w-full text-left text-sm text-gray-500 rtl:text-right dark:text-gray-400">
    <thead class="bg-gray-50 text-xs uppercase text-gray-700 dark:bg-gray-700 dark:text-gray-400">
      <tr>
        <th scope="col" class="p-4">
          No
        </th>
        <th scope="col" class="px-6 py-3 text-center">
          Nama Lengkap
        </th>
      </tr>
    </thead>
    <tbody>
      @foreach ($eventmembers_not_presence as $key => $eventmember)
        <tr class="border-b bg-white hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:hover:bg-gray-600">
          <td class="w-4 p-4">
            {{ $loop->iteration }}
          </td>
          <th scope="row" class="whitespace-nowrap px-6 py-4 font-medium text-gray-900 dark:text-white">
            {{ optional($eventmember->user->resident)->full_name ?? '-' }}
          </th>
        </tr>
      @endforeach
      @if ($eventmembers_not_presence->count() == 0)
        <tr>
          <td colspan="7" class="p-4 text-center"><i class="fa-solid fa-triangle-exclamation mr-2 text-yellow-200"></i>
            Tidak ada member yang belum absen
          </td>
        </tr>
      @endif
    </tbody>
  </table>
  </div>
@endsection
