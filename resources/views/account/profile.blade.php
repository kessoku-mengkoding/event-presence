@extends('layouts.main')

@section('content')
  <div class="container mx-auto my-20 w-7/12 px-4">
    <div class="flex flex-col justify-center">

      @include('partials.profile-header', [
          'title' => 'General',
          'description' => 'Update your username and manage your account',
          'name' => $user->username,
          'image_path' => $user->profile_picture_path,
          'title_color' => 'text-gradient-pink-blue',
      ])

      <div class="mt-12 flex w-full gap-8">
        <ul class="w-[20%]">
          <a href="/profile/me">
            <li class="cursor-pointer font-bold text-black hover:text-black">General</li>
          </a>
          <a href="/profile/me/edit">
            <li class="mt-2 cursor-pointer text-slate-500 hover:text-black">Edit Profile</li>
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
          <form action="/profile" method="POST"> @csrf @method('PUT')
            <label for="email" class="text-lg font-semibold">Email</label>
            <input type="email" name="email" id="" value="{{ $user->email }}" class="input mt-2 w-full">
            <div class="mt-6">
              <label for="password" class="text-lg font-semibold">Password (if changing email)</label>
              <input type="password" name="password" id="" class="input mt-2 w-full">
            </div>
            <div class="mt-6 flex justify-end">
              <button class="btn-primary-sm">Save Changes</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection
