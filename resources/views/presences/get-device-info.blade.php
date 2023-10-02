<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Document</title>
</head>

<body>
  {{-- /presences/redirect --}}
  <form action="/presences/redirect">
    <label for="group_id">group_id</label>
    <input type="text" name="group_id" value="{{ $group_id }}">
    <label for="timetable_id">timetable_id</label>
    <input type="text" name="timetable_id" value="{{ $timetable_id }}">
    <label for="address">Address</label>
    <input type="text" name="address" id="address">
    <label for="lat">Lat</label>
    <input type="text" name="lat" id="lat">
    <label for="long">Long</label>
    <input type="text" name="long" id="long">
    <button id="submit">Submit</button>
  </form>

  <script>
    function getLocation() {
      const options = {
        enableHighAccuracy: true,
        timeout: 5000,
        maximumAge: 0,
      };
      if ("geolocation" in navigator) {
        navigator.geolocation.getCurrentPosition(function(position) {
          const latitude = position.coords.latitude;
          const longitude = position.coords.longitude;

          localStorage.setItem('latitude', latitude);
          localStorage.setItem('longitude', longitude);
        }, function(error) {
          console.error("Error getting location:", error);
        }, options);
      } else {
        alert("Geolocation is not available in your browser.");
      }
    }

    async function processLocation() {
      if (!localStorage.getItem('latitude') || !localStorage.getItem('longitude')) {
        getLocation();
      }

      const latitude = localStorage.getItem('latitude');
      const longitude = localStorage.getItem('longitude');
      const latInput = document.getElementById('lat');
      const longInput = document.getElementById('long');
      latInput.value = latitude;
      longInput.value = longitude;

      const response = await fetch(
        `https://api.opencagedata.com/geocode/v1/json?q=${latitude}+${longitude}&key=024c66666f024043ac452d5d9993329e`
      )
      const data = await response.json();
      const address = data?.results[0]?.formatted;

      const inputLocation = document.getElementById('address');
      inputLocation.value = address;

      if(latInput.value && longInput.value) {
        const submitButton = document.getElementById('submit');
        submitButton.click();
      }
    }

    processLocation();
  </script>
</body>

</html>
