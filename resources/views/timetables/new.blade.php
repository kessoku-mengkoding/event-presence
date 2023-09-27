@extends('layouts.main')

@section('content')
  <div class="relative mx-auto mb-96 max-w-2xl">
    <h1 class="my-6 text-2xl font-bold"><span class="text-gradient-purple-coral">{{ $group->name }}</span> <span
        class="text-gray-300">/</span> New Timetable</h1>
    <form action="/timetable" method="POST" class="flex flex-col">
      @csrf
      @method('POST')
      <input type="text" name="group_id" hidden value="{{ $group_id }}" class="input">
      <label for="" class="font-semibold">Title</label>
      <input type="text" name="title" id="" class="input mb-6 mt-2">
      {{-- <label for="" class="font-semibold">Description</label>
      <textarea type="text" name="description" id="" class="input mb-6 mt-2"></textarea> --}}
      <div class="flex w-full gap-6">
        <div class="flex w-full flex-col">
          <label for="startDatetime" class="font-semibold">Start</label>
          <input type="datetime-local" name="start" id="startDatetime" class="input mb-6 mt-2">
        </div>
        <div class="flex w-full flex-col">
          <label for="endDatetime" class="font-semibold">End</label>
          <input type="datetime-local" name="end" id="endDatetime" class="input mb-6 mt-2">
        </div>
      </div>
      <label for="" class="font-semibold">Lateness tolerance <span class="text-xs font-thin">(minute)</label>
      <input type="number" name="lateness_tolerance" value="0" id="" class="input mb-6 mt-2">
      <label for="" class="font-semibold">Location</label>
      <div id="map" class="mt-2 h-[180px] rounded-lg"></div>
      <div class="mt-6 flex w-full gap-6">
        <div class="flex w-full flex-col">
          <label for="" class="font-semibold">Latitude</label>
          <input type="number" name="start" id="lat" class="input mb-6 mt-2">
        </div>
        <div class="flex w-full flex-col">
          <label for="" class="font-semibold">Longitude</label>
          <input type="number" name="end" id="long" class="input mb-6 mt-2">
        </div>
      </div>
      <label for="" class="font-semibold">Radius <span class="text-xs font-thin">(meter)</span></label>
      <input type="number" name="radius_meter" id="radius" value="100" class="input mb-6 mt-2">
  </div>
  </form>

  <a href="/groups/{{ $group_id }}/detail"
    class="absolute -left-20 top-1/2 flex h-12 w-12 -translate-y-1/2 transform items-center justify-center rounded-full bg-black p-4">
    <i class="fa-solid fa-angle-left text-white"></i>
  </a>
  </div>

  <script>
    function getCurrentDateTime() {
      const now = new Date();
      const year = now.getFullYear();
      const month = (now.getMonth() + 1).toString().padStart(2, '0');
      const day = now.getDate().toString().padStart(2, '0');
      const hours = now.getHours().toString().padStart(2, '0');
      const minutes = now.getMinutes().toString().padStart(2, '0');
      const datetimeString = `${year}-${month}-${day}T${hours}:${minutes}`;
      return datetimeString;
    }

    // handle default datetime value
    const start = document.getElementById('startDatetime');
    const end = document.getElementById('endDatetime');
    if (start.value == '') {
      start.value = getCurrentDateTime();
    }
    if (end.value == '') {
      end.value = getCurrentDateTime();
    }



    // handle map
    const radiusInput = document.getElementById('radius');
    radiusInput.addEventListener('input', function() {
      const radius = parseFloat(radiusInput.value);
      circle.setRadius(radius);
    });

    const lat = -8.687211429036072
    const long = 115.21838143258427

    var map = L.map('map', {
      center: [lat, long],
      zoom: 13
    });
    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
      maxZoom: 19,
      attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
    }).addTo(map);
    var marker = L.marker([lat, long], {
      draggable: true
    }).addTo(map);
    var circle = L.circle([lat, long], {
      color: 'red',
      fillColor: '#f03',
      fillOpacity: 0.5,
      radius: parseFloat(radiusInput.value),
    }).addTo(map);
    marker.bindPopup("<b>Central Point</b><br>Drag to customize.").openPopup();
    circle.bindPopup("I am a circle.");

    var popup = L.popup();

    function onMapClick(e) {
      popup
        .setLatLng(e.latlng)
        .setContent("You clicked the map at " + e.latlng.toString())
        .openOn(map);
    }
    map.on('click', onMapClick);
  </script>
@endsection
