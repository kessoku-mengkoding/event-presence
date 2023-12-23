<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta http-equiv="X-UA-Compatible" content="ie=edge" />
  @vite('resources/css/app.css')
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
    integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-
     alpha/css/bootstrap.css"
    rel="stylesheet">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
  <title>Presenced | Sign In</title>
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
      <h1 class="text-gradient-mktg mb-8 text-3xl font-bold">Sign in to Presenced</h1>
      <button class="flex justify-center items-center gap-2 w-full rounded-full border border-slate-300 py-3 text-center text-base font-semibold">
        {{-- <i class="fa-brands fa-google mr-1"></i> --}}
        <div class="w-6">
          <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" viewBox="0 0 48 48">
            <path fill="#FFC107"
              d="M43.611,20.083H42V20H24v8h11.303c-1.649,4.657-6.08,8-11.303,8c-6.627,0-12-5.373-12-12c0-6.627,5.373-12,12-12c3.059,0,5.842,1.154,7.961,3.039l5.657-5.657C34.046,6.053,29.268,4,24,4C12.955,4,4,12.955,4,24c0,11.045,8.955,20,20,20c11.045,0,20-8.955,20-20C44,22.659,43.862,21.35,43.611,20.083z">
            </path>
            <path fill="#FF3D00"
              d="M6.306,14.691l6.571,4.819C14.655,15.108,18.961,12,24,12c3.059,0,5.842,1.154,7.961,3.039l5.657-5.657C34.046,6.053,29.268,4,24,4C16.318,4,9.656,8.337,6.306,14.691z">
            </path>
            <path fill="#4CAF50"
              d="M24,44c5.166,0,9.86-1.977,13.409-5.192l-6.19-5.238C29.211,35.091,26.715,36,24,36c-5.202,0-9.619-3.317-11.283-7.946l-6.522,5.025C9.505,39.556,16.227,44,24,44z">
            </path>
            <path fill="#1976D2"
              d="M43.611,20.083H42V20H24v8h11.303c-0.792,2.237-2.231,4.166-4.087,5.571c0.001-0.001,0.002-0.001,0.003-0.002l6.19,5.238C36.971,39.205,44,34,44,24C44,22.659,43.862,21.35,43.611,20.083z">
            </path>
          </svg>
        </div>
        <span>Sign In with Google</span>
      </button>
      <div class="inline-flex w-full items-center justify-center">
        <hr class="my-8 h-px w-full border-0 bg-slate-300">
        <span class="absolute left-1/2 -translate-x-1/2 bg-white px-3 text-sm text-black/50">
          or sign in with email</span>
      </div>
      <form action="/sign-in" method="POST"> @csrf
        <div class="flex flex-col">
          <label for="email" class="font-semibold">Email</label>
          <input type="email" name="email" class="input mt-2">
          @error('email')
            <div class="mt-0.5 text-sm text-red-500">{{ $message }}</div>
          @enderror
        </div>
        <div class="mt-6 flex flex-col">
          <div class="flex justify-between">
            <label for="password" class="font-semibold">Password</label>
            <a href="/forgot-password" class="cursor-pointer font-thin underline">Forgot?</a>
          </div>
          <input type="password" name="password" id="" class="input mt-2">
          @error('password')
            <div class="mt-0.5 text-sm text-red-500">{{ $message }}</div>
          @enderror
        </div>
        <button class="btn-primary mt-8">Sign
          In</button>
      </form>
      <div class="mt-4 text-center text-sm">Don't have account? <a href="/sign-up"
          class="cursor-pointer font-thin underline">Sign
          Up</a></div>
    </div>
  </div>

</body>

</html>
