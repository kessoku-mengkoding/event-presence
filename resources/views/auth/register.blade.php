<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta http-equiv="X-UA-Compatible" content="ie=edge" />
  @vite('resources/css/app.css')
  <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-
     alpha/css/bootstrap.css"
    rel="stylesheet">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
  <title>Presenced | Sign Up</title>
</head>

<body>

  @include('toast.toastr')

  <div class="flex h-screen items-center">
    <div class="container mx-auto max-w-md px-4">
      <h1 class="text-gradient-blue-green mb-8 text-3xl font-bold">Sign up to Presenced</h1>
      <form action="/sign-up" method="POST"> @csrf
        <div class="flex gap-4">
          <div class="w-6/12">
            <label for="nik" class="font-semibold">NIK</label>
            <input type="text" name="nik" value="{{ old('nik') }}" class="input mt-2 w-full">
            @error('nik')
              <div class="mt-0.5 text-sm text-red-500">{{ $message }}</div>
            @enderror
          </div>
          <div class="w-6/12">
            <label for="username" class="font-semibold">Username</label>
            <input type="text" name="username" value="{{ old('username') }}" class="input mt-2 w-full">
            @error('username')
              <div class="mt-0.5 text-sm text-red-500">{{ $message }}</div>
            @enderror
          </div>
        </div>
        <div class="mt-6 flex flex-col">
          <label for="email" class="font-semibold">Email</label>
          <input type="email" name="email" value="{{ old('email') }}" class="input mt-2">
          @error('email')
            <div class="mt-0.5 text-sm text-red-500">{{ $message }}</div>
          @enderror
        </div>
        <div class="mt-6 flex flex-col">
          <label for="password" class="font-semibold">Password</label>
          <input type="password" placeholder="6+ characters" name="password"
            class="input mt-2 placeholder:text-slate-300">
          @error('password')
            <div class="mt-0.5 text-sm text-red-500">{{ $message }}</div>
          @enderror
        </div>
        <div class="mt-6 flex flex-col">
          <label for="confirm_password" class="font-semibold">Confirm Password</label>
          <input type="password" name="confirm_password" class="input mt-2">
          @error('confirm_password')
            <div class="mt-0.5 text-sm text-red-500">{{ $message }}</div>
          @enderror
        </div>
        <button class="btn-primary mt-8">Create
          Account</button>
      </form>
      <div class="mt-4 text-center text-sm">Already have an account? <a href="/sign-in"
          class="cursor-pointer font-thin underline">Sign
          In</a></div>
    </div>
  </div>

</body>

</html>
