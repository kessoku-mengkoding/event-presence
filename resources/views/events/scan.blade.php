<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>

  <title>Presenced | Join Event</title>
</head>

<body>
  <div id="reader" width="600px"></div>

  <script>
    // this is in /scan route
    function onScanSuccess(decodedText, decodedResult) {
      console.log(`Code matched = ${decodedText}`, decodedResult);
      html5QrcodeScanner.clear();
      //   window.location.replace({{ env('APP_COMPLETE_URL') }} + decodedText);
      window.location.replace("http://localhost:8000" + decodedText);
    }

    function onScanFailure(error) {
      console.warn(`Code scan error = ${error}`);
    }

    let html5QrcodeScanner = new Html5QrcodeScanner(
      "reader", {
        fps: 10,
        qrbox: {
          width: 800,
          height: 800
        },
        supportedScanTypes: [
          // Html5QrcodeScanType.SCAN_TYPE_FILE,
          Html5QrcodeScanType.SCAN_TYPE_CAMERA
        ],
        disableFlip: true
      },
      /* verbose= */
      false
    );
    html5QrcodeScanner.render(onScanSuccess, onScanFailure);
  </script>
</body>

</html>
