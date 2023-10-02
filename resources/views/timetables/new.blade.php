@extends('layouts.main')

@section('content')
  <div class="relative mx-auto my-12 max-w-2xl">
    <h1 class="my-6 text-2xl font-bold"><span class="text-gradient-purple-coral">{{ $group->name }}</span> <span
        class="text-gray-300">/</span> New Timetable</h1>
    <form action="/timetables" method="POST" class="flex flex-col">
      @csrf
      @method('POST')
      <input hidden type="text" name="group_id" value="{{ $group_id }}" class="input">
      <label for="" class="font-semibold">Title</label>
      <input type="text" name="title" id="" class="input mt-2">
      @error('title')
        <div class="mt-0.5 text-sm text-red-500">{{ $message }}</div>
      @enderror
      <div class="mt-6 flex w-full gap-6">
        <div class="flex w-full flex-col">
          <label for="startDatetime" class="font-semibold">Start</label>
          <input type="datetime-local" name="start" id="startDatetime" class="input mt-2">
          @error('start')
            <div class="mt-0.5 text-sm text-red-500">{{ $message }}</div>
          @enderror
        </div>
        <div class="flex w-full flex-col">
          <label for="endDatetime" class="font-semibold">End</label>
          <input type="datetime-local" name="end" id="endDatetime" class="input mt-2">
          @error('end')
            <div class="mt-0.5 text-sm text-red-500">{{ $message }}</div>
          @enderror
        </div>
      </div>
      <label for="" class="mt-6 font-semibold">Lateness tolerance <span class="text-xs font-thin">(minute)</label>
      <input type="number" name="lateness_tolerance" value="0" id="" class="input mt-2">
      @error('lateness_tolerance')
        <div class="mt-0.5 text-sm text-red-500">{{ $message }}</div>
      @enderror
      <label for="" class="mt-6 font-semibold">Location</label>
      <div id="map" class="mt-2 h-[180px] rounded-lg"></div>
      <div class="mt-6 flex w-full gap-6">
        <div class="flex w-full flex-col">
          <label for="" class="font-semibold">Latitude</label>
          <input type="text" name="lat" id="lat" class="input mt-2">
          @error('lat')
            <div class="mt-0.5 text-sm text-red-500">{{ $message }}</div>
          @enderror
        </div>
        <div class="flex w-full flex-col">
          <label for="" class="font-semibold">Longitude</label>
          <input type="text" name="long" id="long" class="input mt-2">
          @error('long')
            <div class="mt-0.5 text-sm text-red-500">{{ $message }}</div>
          @enderror
        </div>
      </div>
      <label for="" class="font-semibold mt-6">Address</label>
      <input type="text" name="address" disabled id="address" value="" class="cursor-not-allowed input mt-2">
      <label for="" class="font-semibold mt-6">Radius <span class="text-xs font-thin">(meter)</span></label>
      <input type="number" name="radius_meter" id="radius" value="100" class="input mt-2">
      @error('radius_meter')
        <div class="mt-0.5 text-sm text-red-500">{{ $message }}</div>
      @enderror
      <button class="btn-primary mt-6">Create</button>
    </form>

    <a href="/groups/{{ $group_id }}/detail"
      class="fixed left-12 top-1/2 flex h-12 w-12 -translate-y-1/2 transform items-center justify-center rounded-full bg-black p-4">
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

    const lat = localStorage.getItem('latitude')
    const long = localStorage.getItem('longitude')
    const latInput = document.getElementById('lat');
    const longInput = document.getElementById('long');

    // initialize long lat with current location
    latInput.value = lat;
    longInput.value = long;
    const address = null
    getAddress();

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
    // marker.bindPopup(`<b>Central Point</b><br>${address}`).openPopup();
    circle.bindPopup("Valid area");

    var popup = L.popup();

    function onMapClick(e) {
      popup
        .setLatLng(e.latlng)
        .setContent("You clicked the map at " + e.latlng.toString())
        .openOn(map);
    }
    // map.on('click', onMapClick);

    marker.on('drag', function(event) {
      var marker = event.target;
      var position = marker.getLatLng();
      marker.setLatLng(new L.LatLng(position.lat, position.lng), {
        draggable: true
      });
      map.panTo(new L.LatLng(position.lat, position.lng))
      document.getElementById('lat').value = position.lat;
      document.getElementById('long').value = position.lng;
      // popup.setLatLng(position).setContent(marker.getLatLng().toString()).openOn(map);

      circle.setLatLng(position);
    });
    marker.on('dragend', function() {
      getAddress();
    })

    // watch long lat change
    latInput.addEventListener('input', function() {
      console.log('lat changed');
      const lat = parseFloat(latInput.value);
      const long = parseFloat(longInput.value);
      marker.setLatLng([lat, long]);
      circle.setLatLng([lat, long]);
      map.panTo(new L.LatLng(lat, long))
      getAddress();
    });

    longInput.addEventListener('input', function() {
      //   console.log('long changed');
      const lat = parseFloat(latInput.value);
      const long = parseFloat(longInput.value);
      marker.setLatLng([lat, long]);
      circle.setLatLng([lat, long]);
      map.panTo(new L.LatLng(lat, long))
      getAddress();
    });

    async function getAddress() {
      const response = await fetch(
        `https://api.opencagedata.com/geocode/v1/json?q=${latInput.value}+${longInput.value}&key=024c66666f024043ac452d5d9993329e`
      )
      const data = await response.json();
      const address = data?.results[0]?.formatted;
      marker.bindPopup(`<b>Central Point</b><br>${address}`).openPopup();
      document.getElementById('address').value = address;
    }
  </script>
@endsection
