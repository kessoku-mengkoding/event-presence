@extends('layouts.admin')

@section('content')
  <div class="mx-auto mb-12 text-center">
    <h1 class="text-3xl font-bold">
      <i class="fa-solid fa-calendar-days mr-1.5"></i>
      Jadwal Pada Kegiatan ...
    </h1>

    <div class="mt-8">
      <a {{-- href="{{ route('timetablesAdminView', $event->id) }}" --}}
        class="mb-2 me-2 rounded-lg bg-gradient-to-br from-purple-600 to-blue-500 px-5 py-2.5 text-center text-sm font-medium text-white hover:bg-gradient-to-bl focus:outline-none focus:ring-4 focus:ring-blue-300 dark:focus:ring-blue-800">Buat Jadwal</a>
    </div>
  </div>
@endsection
