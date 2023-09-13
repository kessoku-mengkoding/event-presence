<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  @vite('resources/css/app.css')
  <title>Document</title>
</head>

<body>
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
    <p>invite by user id</p>
    <form action="/groups/{{ $group->id }}/invite" method="POST">
      @csrf
      @method('POST')
      <input type="text" name="user_id" id="" class="input">
    </form>
  </div>

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




</body>

</html>
