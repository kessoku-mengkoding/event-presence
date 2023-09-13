<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta http-equiv="X-UA-Compatible" content="ie=edge" />
  @vite('resources/css/app.css')
  <title>Document</title>
</head>

<body>
  <div class="m-auto">
    @if (session('invalid_auth'))
      <div class="text-red-500">{{ session('invalid_auth') }}</div>
    @endif
    <h1 class="text-2xl font-bold">Login</h1>
    <form action="/login" method="POST">
      @csrf
      <div>
        <label for="email">Email</label>
        <input type="text" name="email" id=""
          class="@error('email') border-red-500 @enderror border-2 border-black" />
        @error('email')
          <div class="text-red-500">{{ $message }}</div>
        @enderror
      </div>
      <div>
        <label for="password">Password</label>
        <input type="password" name="password" id="" class="border-2 border-black
          @error('password') border-red-500 @enderror" />
        @error('password')
          <div class="text-red-500">{{ $message }}</div>
        @enderror
      </div>
      <button class="rounded-lg bg-blue-500 px-5 py-1 text-white">Login</button>
    </form>
    <a href="/register" class="underline">Don't have account?</a>
  </div>
</body>

</html>
