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
  <h1 class="text-3xl font-bold">Home</h1>
  <form action="/logout" method="POST">
    @csrf
    <button class="rounded-lg bg-red-500 px-5 py-1 text-white">Logout</button>
  </form>
  <a href="/profile/me" class="rounded-lg bg-blue-500 px-5 py-1 text-white">Profile</a>
  <br>
  <div>
    <h1 class="mt-4">My Groups:</h1>
    <ul class="flex flex-wrap gap-2">
      @foreach ($groups as $group)
        <a href="/groups/{{$group->group_id}}/detail">
          <li class="min-w-[200px] border border-black">
            <h1 class="font-bold">{{ $group->group->name }}</h1>
            <h1>{{ $group->group->description }}</h1>
          </li>
        </a>
      @endforeach
    </ul>
  </div>
  <a href="/groups/create" class="link">Create Group</a>

  <h1 class="font-bold mt-4">Join group</h1>
  <form action="/groups/join" method="POST">
    @csrf
    @method('POST')
    <label for="id">Group Id:</label>
    <input type="text" name="id" id="" class="input">
  </form>
  <br>
  <a href="/notifications" class="btn">notifications</a>
  <a href="/invitations" class="btn">invitations</a>
</body>

</html>
