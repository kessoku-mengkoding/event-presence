@extends('layouts.main')

@section('content')
  <div class="mt-4 flex justify-center gap-4">
    <a href="/" class="btn-sm-no-color {{ !$type ? 'bg-yellow-50' : '' }} cursor-pointer hover:opacity-50">All</a>
    <a href="/?type=ongoing"
      class="btn-sm-no-color {{ $type == 'ongoing' ? 'bg-yellow-50' : '' }} cursor-pointer hover:opacity-50">Ongoing</a>
    <a href="/?type=upcoming"
      class="btn-sm-no-color {{ $type == 'upcoming' ? 'bg-yellow-50' : '' }} cursor-pointer hover:opacity-50">Upcoming</a>
  </div>

  <div class="flex gap-12 mt-12">
    @foreach ($timetables->groupmembers as $groupmembers)
      @foreach ($groupmembers->group->timetables as $timetable)
      <div>
        <h1>Timetable name: {{$timetable->title}}</h1>
        <h2>Group name: {{$groupmembers->group->name}}</h2>
        <p>{{$timetable->start}} to {{$timetable->end}}</p>
        <p>x Min left</p>
      </div>
      @endforeach
    @endforeach
  </div>
  {{-- {{$timetables}} --}}
@endsection
