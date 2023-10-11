<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="./css/app.css">
  @vite('resources/css/app.css')
  <title>Presenced</title>


  <style>
    .lds-facebook {
      display: inline-block;
      position: relative;
      width: 80px;
      height: 80px;
    }

    .lds-facebook div {
      display: inline-block;
      position: absolute;
      left: 8px;
      width: 16px;
      background: black;
      animation: lds-facebook 0.8s cubic-bezier(0, 0.5, 0.5, 1) infinite;
    }

    .lds-facebook div:nth-child(1) {
      left: 8px;
      animation-delay: -0.24s;
    }

    .lds-facebook div:nth-child(2) {
      left: 32px;
      animation-delay: -0.12s;
    }

    .lds-facebook div:nth-child(3) {
      left: 56px;
      animation-delay: 0;
    }

    @keyframes lds-facebook {
      0% {
        top: 8px;
        height: 64px;
      }

      50%,
      100% {
        top: 24px;
        height: 32px;
      }
    }
  </style>
</head>

<body class="flex justify-center items-center h-screen">
  <div class="lds-facebook ">
    <div></div>
    <div></div>
    <div></div>
  </div>

  <form action="/presences/redirect" style="display:none;">
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

      if (latInput.value && longInput.value) {
        const submitButton = document.getElementById('submit');
        submitButton.click();
      }
    }

    processLocation();
  </script>
</body>

</html>
