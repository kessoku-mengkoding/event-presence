@extends('layouts.main')

@section('content')
  <h1> Group name: {{ $group->name }} </h1>
  <p>Group Id: {{ $group->id }}</p>
  <p>Group Description: {{ $group->description }}</p>
  <p class="mt-4">Group Members:</p>
  <ul>
    @foreach ($group->groupmembers as $groupmember)
      <li class="flex gap-12 border border-black">
        <p>{{ $groupmember->user->username }}</p>
        <p>{{ $groupmember->user->name }}</p>
        <p>{{ $groupmember->user->email }}</p>
        <p>{{ $groupmember->role }}</p>
        @if (in_array($user_in_group->role, ['owner', 'admin']) && $groupmember->user_id != auth()->user()->id)
          <form action="/groups/{{ $group->id }}/member/{{ $groupmember->user->id }}" method="POST">
            @csrf
            @method('DELETE')
            <button class="btn">Delete</button>
          </form>
        @endif
        @if ($groupmember->user_id != auth()->user()->id && auth()->user()->role == 'admin')
          <form action="/groups/{{ $group->id }}/members/{{ $groupmember->id }}" method="POST">
            @csrf
            @method('DELETE')
            <button class="btn">Delete</button>
          </form>
        @endif
      </li>
    @endforeach
  </ul>

  <br>
  <br>
  <br>

  <h1>Invite member</h1>
  <div class="flex">
    <p>invite by email or username</p>
    <form action="/groups/{{ $group->id }}/invite" method="POST">
      @csrf
      @method('POST')
      <input type="text" name="key" id="" class="input">
    </form>
  </div>

  <br>
  <br>
  <br>

  <h1>Pending</h1>
  <ul>
    @foreach ($pendings as $pending)
      <li class="flex gap-12 border border-black">
        <p>{{ $pending->user->username }}</p>
        <p>{{ $pending->created_at }}</p>
        <form action="/invitations/{{ $pending->id }}/decline" method="POST">
          @csrf
          @method('PUT')
          <button class="bg-red-500">Cancel</button>
        </form>
      </li>
    @endforeach
  </ul>

  <br>
  <br>
  <br>

  @if ($user_in_group->role == 'owner')
    <form action="/groups/{{ $group->id }}" method="POST">
      @csrf
      @method('DELETE')
      <button class="btn">Delete Group</button>
    </form>
  @endif

  <br>
  <br>
  <br>

  <a href="/timetables/{{ $group->id }}/new" class="btn">Create Timetable</a>
  <h1>Timetables</h1>
@endsection
