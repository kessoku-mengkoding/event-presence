<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  @vite('resources/css/app.css')
  <title>Presenced | {{ $title }}</title>
</head>

<body>

  @include('partials.navbar')

  <div class="w-screen">
    @if (session('message'))
      <div class="bg-black py-3 text-center text-sm text-white">
        {{ session('message') }}
      </div>
    @endif
  </div>

  <div class="container mx-auto my-4 px-4 sm:px-8 lg:px-12">
    @yield('content')
  </div>

</body>

</html>
