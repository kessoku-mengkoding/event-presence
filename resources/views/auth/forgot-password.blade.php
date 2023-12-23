<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Document</title>
  @vite('resources/css/app.css')
</head>

<body>
  <div class="fixed w-[320px] max-w-[500px] left-[50%] translate-x-[-50%] rounded-[6px] overflow-hidden top-[20px]">
    @if (session('message'))
      <div class="bg-black py-3 text-center text-sm text-white">
        {{ session('message') }}
      </div>
    @endif
  </div>

  <div class="flex h-screen items-center">
    <div class="container mx-auto max-w-md px-4">
      <h1 class="text-gradient-mktg mb-10 text-3xl font-bold">Forgot Password?</h1>
      <p class="text-sm">Enter the email address you used when you joined and we’ll send you instructions to reset your password.</p>
      <p class="mt-6 text-sm">For security reasons, we do NOT store your password. So rest assured that we will never send your password via email.</p>
      <form action="/sign-in" method="POST" class="mt-10"> @csrf
        <div class="flex flex-col">
          <label for="email" class="font-semibold">Email</label>
          <input type="email" name="email" class="input mt-2">
          @error('email')
            <div class="mt-0.5 text-sm text-red-500">{{ $message }}</div>
          @enderror
        </div>
        <button class="btn-primary-sm mt-6 text-sm">Send Reset Instructions</button>
      </form>
    </div>
  </div>
</body>

</html>
