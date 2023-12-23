<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  @vite('resources/css/app.css')
  <script src="https://unpkg.com/@dotlottie/player-component@latest/dist/dotlottie-player.mjs" type="module"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
    integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
  <script src="https://unpkg.com/qrcode-decoder@0.3.1/dist/index.min.js"></script>
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
    integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
  <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
    integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
  <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
  <title>Presenced | {{ $title }}</title>
</head>

<body>

  @include('partials.navbar')

  <div class="fixed w-[320px] max-w-[500px] left-[50%] translate-x-[-50%] rounded-[6px] overflow-hidden top-[20px]">
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
