@extends('layouts.main')

@section('content')
  <div class="container mx-auto my-20 w-7/12 px-4">
    <div class="flex flex-col justify-center">

      @include('partials.profile-header', [
          'title' => 'Password',
          'description' => 'Manage your security settings and password easily',
          'name' => $user->username,
          'image_path' => $user->profile_picture_path,
          'title_color' => 'text-gradient-blue-green',
      ])

      <div class="mt-12 flex w-full gap-8">
        <ul class="w-[20%]">
          <a href="/profile/me">
            <li class="cursor-pointer text-slate-500 hover:text-black">General</li>
          </a>
          <a href="/profile/me/edit">
            <li class="mt-2 cursor-pointer text-slate-500 hover:text-black">Edit Profile</li>
          </a>
          <a href="/profile/me/password">
            <li class="mt-2 cursor-pointer font-bold text-black hover:text-black">Password</li>
          </a>
          <hr class="my-4">
          <form action="/account" method="POST"> @method('DELETE') @csrf
            <button class="w-full cursor-pointer text-left text-red-500">Delete Account</button>
          </form>
          </a>
        </ul>
        <div class="w-[80%]">
          <form action="/change-password" method="POST"> @csrf @method('PUT')
            <div>
              <label for="old_password" class="text-lg font-semibold">Old Password</label>
              <input type="password" name="old_password" id="" class="input mt-2 w-full">
            </div>
            @error('old_password')
              <div class="mt-0.5 text-sm text-red-500">{{ $message }}</div>
            @enderror
            <div class="mt-6">
              <label for="new_password" class="text-lg font-semibold">New Password</label>
              <input type="password" name="new_password" placeholder="6+ characters" id=""
                class="input mt-2 w-full placeholder:text-slate-300">
            </div>
            @error('new_password')
              <div class="mt-0.5 text-sm text-red-500">{{ $message }}</div>
            @enderror
            <div class="mt-6 flex justify-end">
              <button class="btn-primary-sm">Save Changes</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection
