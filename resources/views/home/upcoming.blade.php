@extends('layouts.main')

@section('content')
  <div class="mt-4 flex justify-center gap-4">
    {{-- <a href="/" class="btn-sm-no-color cursor-pointer hover:opacity-50">Recent</a>
    <a href="/reminder" class="btn-sm-no-color cursor-pointer hover:opacity-50">Reminder</a> --}}
    <a href="/upcoming" class="btn-sm-no-color cursor-pointer bg-yellow-50 hover:opacity-50">Upcoming</a>
    <a href="/ongoing" class="btn-sm-no-color cursor-pointer hover:opacity-50">Ongoing</a>
  </div>
@endsection
