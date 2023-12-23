@extends('layouts.admin')

@section('content')
  <div class="mx-auto mt-12 max-w-md">
    <h1 class="text-gradient-mktg mb-10 text-3xl font-bold">Create New Event</h1>

    <form action="/events" method="POST" class="mt-6" enctype="multipart/form-data"> @csrf @method('POST')
      <div class="flex flex-col items-center gap-4">
        <div class="h-24 w-24 overflow-clip rounded-full bg-black">
          <img alt="Event Image" id="uploadPreview">
        </div>
        <input type="file" name="image" accept="image/*" id="uploadImage" hidden onchange="previewImage();">
        <label type="button" class="btn-border" for="uploadImage"">Change Picture</label>
      </div>

      <div class="mt-10 flex flex-col">
        <label for="name" class="font-semibold">Name</label>
        <input type="text" name="name" class="input mt-2" placeholder="Rapat Umum IV">
        @error('name')
          <div class="mt-0.5 text-sm text-red-500">{{ $message }}</div>
        @enderror
      </div>
      <div class="mt-4 flex flex-col">
        <label for="description" class="font-semibold">Description</label>
        <textarea type="text" name="description" id="" class="input mt-2 w-full"></textarea>
      </div>
      <div class="flex justify-end">
        <button class="btn-primary-sm mt-6 text-sm">Create</button>
      </div>
    </form>
  </div>

  <script type="text/javascript">
    function previewImage() {
      var oFReader = new FileReader();
      oFReader.readAsDataURL(document.getElementById("uploadImage").files[0]);

      oFReader.onload = function(oFREvent) {
        document.getElementById("uploadPreview").src = oFREvent.target.result;
      };
    };
  </script>
@endsection
