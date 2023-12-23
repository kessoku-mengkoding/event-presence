@extends('layouts.main')

@section('content')
  <h1> Event name: {{ $event->name }} </h1>
  <p>Event Id: {{ $event->id }}</p>
  <p>Event Description: {{ $event->description }}</p>
  <p>Qr: {{ $event->qr_code_path }}</p>
  <img src="{{ $event->qr_code_path }}" alt="">
  <p class="mt-4">Event Members:</p>
  <ul>
    @foreach ($event->eventmembers as $eventmember)
      <li class="flex gap-12 border border-black">
        <p>{{ $eventmember->user->username }}</p>
        <p>{{ $eventmember->user->name }}</p>
        <p>{{ $eventmember->user->email }}</p>
        <p>{{ $eventmember->role }}</p>
        <form action="/events/{{ $event->id }}/member/{{ $eventmember->user->id }}" method="POST">
          @csrf
          @method('DELETE')
          <button class="btn">Delete</button>
        </form>
        <form action="/events/{{ $event->id }}/members/{{ $eventmember->id }}" method="POST">
          @csrf
          @method('DELETE')
          <button class="btn">Delete</button>
        </form>
      </li>
    @endforeach
  </ul>

  <br>
  <br>
  <br>

  <h1>Invite member</h1>
  <div class="flex">
    <p>invite by email or username</p>
    <form action="/events/{{ $event->id }}/invite" method="POST">
      @csrf
      @method('POST')
      <input type="text" name="key" id="" class="input">
    </form>
  </div>

  <br>
  <br>
  <br>

  <form action="/events/{{ $event->id }}" method="POST">
    @csrf
    @method('DELETE')
    <button class="btn">Delete Event</button>
  </form>

  <br>
  <br>
  <br>

  <a href="/timetables/{{ $event->id }}/new" class="btn">Create Timetable</a>
  <h1>Timetables</h1>
  <ul>
    @foreach ($timetables as $timetable)
      <li class="flex gap-12 border border-black">
        <p>{{ $timetable->title }}</p>
        <p>{{ $timetable->start }}</p>
        <p>{{ $timetable->end }}</p>
        <p>{{ $timetable->lateness_tolerance }}</p>
        <p>{{ $timetable->lat }}</p>
        <p>{{ $timetable->long }}</p>
        <p>{{ $timetable->radius_meter }}</p>
        <p>{{ $timetable->address }}</p>
        <a href="/timetables/{{ $timetable->id }}/presences" class="btn">Detail</a>
        <form action="/timetables/{{ $timetable->id }}" method="POST">
          @csrf
          @method('DELETE')
          <button class="btn">Delete</button>
        </form>
      </li>
      <img src="{{ $timetable->qr_code_path }}" alt="">
      {{ $timetable->qr_code_path }}
    @endforeach
  </ul>
@endsection
