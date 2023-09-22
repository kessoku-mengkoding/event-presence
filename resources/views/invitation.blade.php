<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Document</title>
</head>

<body>
  <h1>invitations</h1>

  <p>{{ $invitations }}</p>

  @foreach ($invitations as $inv)
    <div>
      You're invited to group {{ $inv->group->name }} by {{ $inv->groupmember->user->username }}
      <form action="/invitations/{{ $inv->id }}/accept" method="POST">
        @csrf
        @method('PUT')
        <input type="hidden" name="group_id" value="{{ $inv->group_id }}">
        <button>Accept</button>
      </form>
      <form action="/invitations/{{ $inv->id }}/decline" method="POST">
        @csrf
        @method('PUT')
        <button>Decline</button>
      </form>
    </div>
  @endforeach
</body>

</html>
