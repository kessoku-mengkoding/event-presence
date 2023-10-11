@extends('layouts.main')

@section('content')
  <div class="mt-12 flex items-center justify-center gap-12">
    <div class="relative flex max-w-md flex-col">
      <h1 class="text-gradient-mktg mb-6 text-3xl font-bold">Here we go!</h1>
      <p class="text-sm">Please enter the group ID or simply scan the QR code shared by the group administrator.</p>
      <form action="/groups/join" method="POST" class="mt-10"> @csrf @method('POST')
        <div class="flex flex-col">
          <label for="id" class="font-semibold">Group ID</label>
          <input type="text" name="id" class="input mt-2">
        </div>
        <button class="btn-primary-sm mt-6 text-sm">Join Group</button>
      </form>
      <div class="inline-flex w-full items-center justify-center">
        <hr class="my-8 h-px w-full border-0 bg-slate-300">
        <span class="absolute left-1/2 -translate-x-1/2 bg-white px-3 text-sm text-black/50">or</span>
      </div>
      <div class="flex justify-center gap-4">

        {{-- join by qr image --}}
        <form action="/groups/join/qr-image" method="POST" enctype="multipart/form-data" id="imageUploadForm"> @csrf
          <input type="file" name="image" accept="image/*" id="imageInput" class="hidden">
          <button type="button" class="flex h-12 w-12 items-center justify-center rounded-full bg-black hover:opacity-70"
            id="chooseImageButton">
            <i class="fa-solid fa-folder-open" style="color: #ffffff;"></i>
          </button>
        </form>

        {{-- join by scan qr --}}
        <a href="/groups/join/scan"
          class="flex h-12 w-12 items-center justify-center rounded-full bg-black hover:opacity-70">
          <i class="fa-solid fa-camera" style="color: #ffffff;"></i>
        </a>

      </div>
    </div>
    <dotlottie-player src="https://lottie.host/04549575-00a3-4c3d-947c-bd26a1be1531/u9fucFTNhL.json"
      background="transparent" speed="0.9" style="width: 500px; height: 500px;" loop autoplay></dotlottie-player>
  </div>


  <script>
    // handle join by upload qr image
    const fileInput = document.getElementById('imageInput');
    const chooseImageButton = document.getElementById('chooseImageButton');
    const imageUploadForm = document.getElementById('imageUploadForm');

    imageUploadForm.addEventListener('submit', function(event) {
      if (!fileInput.files.length) {
        event.preventDefault();
      }
    });

    chooseImageButton.addEventListener('click', function() {
      fileInput.click();
    });

    fileInput.addEventListener('change', function() {
      const submitButton = document.createElement('button');
      submitButton.type = 'submit';
      submitButton.style.display = 'none';
      imageUploadForm.appendChild(submitButton);

      submitButton.click();
    });

    // handle join by scan qr
    function onScanSuccess(decodedText, decodedResult) {
      // handle the scanned code as you like, for example:
      console.log(`Code matched = ${decodedText}`, decodedResult);
    }

    function onScanFailure(error) {
      // handle scan failure, usually better to ignore and keep scanning.
      // for example:
      console.warn(`Code scan error = ${error}`);
    }

    let html5QrcodeScanner = new Html5QrcodeScanner(
      "reader", {
        fps: 10,
        qrbox: {
          width: 250,
          height: 250
        }
      },
      /* verbose= */
      false);
    html5QrcodeScanner.render(onScanSuccess, onScanFailure);
  </script>
@endsection
