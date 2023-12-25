@extends('layouts.admin')

@section('content')
  <div class="mx-auto mb-12 text-center">
    <h1 class="text-3xl font-bold">
      <i class="fa-solid fa-calendar-days mr-1.5"></i>
      Jadwal Pada Kegiatan {{ $event->name }}
    </h1>

    <div class="my-8">
      <a href="{{ route('createTimetableFromAdminView', $event->id) }}"
        class="mb-2 me-2 rounded-lg bg-gradient-to-br from-purple-600 to-blue-500 px-5 py-2.5 text-center text-sm font-medium text-white hover:bg-gradient-to-bl focus:outline-none focus:ring-4 focus:ring-blue-300 dark:focus:ring-blue-800">Buat
        Jadwal</a>
    </div>

    <table class="w-full text-left text-sm text-gray-500 rtl:text-right dark:text-gray-400">
      <thead class="bg-gray-50 text-xs uppercase text-gray-700 dark:bg-gray-700 dark:text-gray-400">
        <tr>
          <th scope="col" class="p-4">
            No
          </th>
          <th scope="col" class="px-6 py-3">
            Nama Jadwal
          </th>
          <th scope="col" class="px-6 py-3">
            Alamat
          </th>
          <th scope="col" class="px-6 py-3">
            Koordinat (lat, long)
          </th>
          <th scope="col" class="px-6 py-3">
            Radius (meter)
          </th>
          <th scope="col" class="px-6 py-3">
            Toleransi Keterlambatan (menit)
          </th>
          <th scope="col" class="px-6 py-3">
            Waktu Mulai
          </th>
          <th scope="col" class="px-6 py-3">
            Waktu Selesai
          </th>
          <th scope="col" class="px-6 py-3">
            Status
          </th>
          <th scope="col" class="px-6 py-3">
            Action
          </th>
        </tr>
      </thead>
      <tbody>
        @foreach ($timetables as $timetable)
          <tr class="border-b bg-white hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:hover:bg-gray-600">
            <td class="w-4 p-4">
              {{ $loop->iteration }}
            </td>
            <th scope="row" class="whitespace-nowrap px-6 py-4 font-medium text-gray-900 dark:text-white">
              {{ $timetable->title }}
            </th>
            <td class="px-6 py-4">
              {{ $timetable->address }}
            </td>
            <td class="px-6 py-4">
              {{ $timetable->latitude }}, {{ $timetable->longitude }}
            </td>
            <td class="px-6 py-4">
              {{ $timetable->radius_meter }}
            </td>
            <td class="px-6 py-4">
              {{ $timetable->lateness_tolerance }}
            </td>
            <td class="px-6 py-4">
              {{ $timetable->start }}
            </td>
            <td class="px-6 py-4">
              {{ $timetable->end }}
            </td>
            <td class="px-6 py-4">
              @if ($timetable->start > now())
                Belum Dimulai
              @elseif($timetable->end < now())
                Selesai
              @else
                Sedang Berlangsung
              @endif
            </td>
            <td class="flex items-center px-6 py-4 justify-center m-auto">
              <a href="{{ route('editTimetableView', $timetable->id) }}"
                class="font-medium text-blue-600 hover:underline dark:text-blue-500">
                <i class="fa-solid fa-pen-to-square"></i>
              </a>

              @include('components.modal-delete', [
                  'name' => 'jadwal',
                  'input_name' => 'id',
                  'id' => $timetable->id,
                  'test' => $timetable->title,
                  'action' => route('deleteTimetable', $timetable->id),
              ])
            </td>
          </tr>
        @endforeach
        @if ($timetables->count() == 0)
          <tr>
            <td colspan="7" class="p-4 text-center"><i
                class="fa-solid fa-triangle-exclamation mr-2 text-yellow-200"></i>Penduduk Tidak Ditemukan</td>
          </tr>
        @endif
      </tbody>
    </table>
  </div>
@endsection
