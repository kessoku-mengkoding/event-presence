<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Document</title>
</head>

<body>
  <form action="/profile" method="POST">
    @method('PUT')
    @csrf
    <label for="email">Email</label>
    <input disabled type="email" value="{{ $user->email }}" name="email" id="">
    <br>
    <label for="name">Name</label>
    <input type="text" value="{{ $user->name }}" name="name" id="">
    <br>
    <button>Save</button>
  </form>
  <form action="/profile" method="POST">
    @method('DELETE')
    @csrf
    <button>Delete</button>
  </form>
</body>

</html>
