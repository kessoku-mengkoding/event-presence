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
    <h1 class="text-2xl font-bold">Register</h1>
    <form action="/register" method="POST">
      @csrf
      <div>
        <label for="username">Username</label>
        <input type="text" name="username" id=""
          class="@error('username') border-red-500 @enderror border-2 border-black" />
        @error('username')
          <div class="text-red-500">{{ $message }}</div>
        @enderror
      </div>
      <div>
        <label for="email">Email</label>
        <input type="text" name="email" id=""
          class="border-2 border-black
          @error('email') border-red-500 @enderror"
        />
        @error('email')
          <div class="text-red-500">{{ $message }}</div>
        @enderror
      </div>
      <div>
        <label for="password">Password</label>
        <input type="password" name="password" id=""
        class="border-2 border-black"
        @error('password') border-red-500 @enderror"
        />
        @error('password')
          <div class="text-red-500">{{ $message }}</div>
        @enderror
      </div>
      <div>
        <label for="confirm_password">Confirm Password</label>
        <input type="password" name="confirm_password" id=""
        class="border-2 border-black"
        @error('confirm_password') border-red-500 @enderror"
        />
        @error('confirm_password')
          <div class="text-red-500">{{ $message }}</div>
        @enderror
      </div>
      <button class="bg-blue-500 text-white py-1 px-5 rounded-lg">Register</button>
    </form>
  </div>
</body>
</html>
