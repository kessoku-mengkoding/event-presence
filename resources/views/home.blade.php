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
</body>

</html>
