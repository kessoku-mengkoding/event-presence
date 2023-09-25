@extends('layouts.main')

@section('content')
  <div class="container mx-auto my-20 w-7/12 px-4">
    <div class="flex flex-col justify-center">

      @include('partials.profile-header', [
          'title' => 'Profile',
          'description' => 'Customize your profile for your friends to see',
          'name' => $user->username,
          'image_path' => $user->profile_picture_path,
          'title_color' => 'text-gradient-red-orange',
      ])

      <div class="mt-12 flex w-full gap-8">
        <ul class="w-[20%]">
          <a href="/profile/me">
            <li class="cursor-pointer text-slate-500 hover:text-black">General</li>
          </a>
          <a href="/profile/me/edit">
            <li class="mt-2 cursor-pointer font-bold text-black hover:text-black">Edit Profile</li>
          </a>
          <a href="/profile/me/password">
            <li class="mt-2 cursor-pointer text-slate-500 hover:text-black">Password</li>
          </a>
          <hr class="my-4">
          <form action="/account" method="POST"> @method('DELETE') @csrf
            <button class="w-full cursor-pointer text-left text-red-500">Delete Account</button>
          </form>
          </a>
        </ul>
        <div class="w-[80%]">
          <div class="flex items-center gap-4">
            <div class="h-24 w-24 overflow-clip rounded-full bg-black">
              <img src="{{ $user->profile_picture_path }}" alt="Profile Picture">
            </div>
            <form action="/users/me/profile-picture" method="POST" enctype="multipart/form-data" id="imageUploadForm">
              @csrf
              <input type="file" name="image" accept="image/*" id="imageInput" class="hidden">
              <button type="button" class="btn-border" id="chooseImageButton">Change Picture</button>
            </form>
            <form action="/users/me/profile-picture" method="POST"
              class="{{ $user->profile_picture_path ? 'block' : 'hidden' }}"> @csrf @method('DELETE')
              <button
                class="btn-sm-no-color bg-yellow-100/50 font-semibold text-black hover:bg-yellow-100">Delete</button>
            </form>
          </div>
          <form action="/profile" class="mt-8" method="POST"> @csrf @method('PUT')
            <label for="name" class="text-lg font-semibold">Name</label>
            <input type="text" name="name" id="" value="{{ $user->name }}"
              class="input mb-6 mt-2 w-full">
            <label for="location" class="text-lg font-semibold">Location</label>
            <input type="text" name="location" id="" value="{{ $user->location }}"
              class="input mb-6 mt-2 w-full">
            <label for="bio" class="text-lg font-semibold">Bio</label>
            <textarea type="text" name="bio" id="" class="input mt-2 w-full">{{ $user->bio }}</textarea>
            <div class="mt-6 flex justify-end">
              <button class="btn-primary-sm">Save Changes</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <script>
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
      submitButton.style.display = 'none'; // Hide the button visually
      imageUploadForm.appendChild(submitButton);

      submitButton.click();
    });
  </script>
@endsection
