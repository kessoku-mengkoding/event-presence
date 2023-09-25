@extends('layouts.main')

@section('content')
  <div class="w-full">
    <div class="my-4">
      <img class="mx-auto" width="500"
        src="https://cdn.dribbble.com/assets/art-banners/live-ch-2-06c2d22b44499770d946df4be0064fe7f6d22e30664016542a42d8221ff25fb0.jpg"
        alt="">
      <p class="mx-auto max-w-xl text-center font-thin">Say goodbye to manual attendance tracking and embrace a world
        of efficiency,
        accuracy, and convenience. Whether you're a school, business, or organization of any size, our attendance app is
        designed to streamline your processes and elevate your productivity.
      </p>
      <div class="flex justify-center mt-8 gap-4 items-center">
        <button class="btn-border">Join Group</button>
        <span class="font-thin">or</span>
        <button class="btn-sm-no-color bg-yellow-100/50 font-semibold text-black hover:bg-yellow-100">Create Group</button>
      </div>
    </div>

    <div class="mx-auto grid grid-cols-1 items-center justify-center gap-4 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
      {{-- <div class="min-h-[200px] border rounded-lg p-8">
        <h1>Create your own group</h1>
        <p>Simplify Attendance Tracking and Increase Efficiency Your Organization Today!</p>
        <button class="text-xs btn-primary-sm">Create Group</button>
      </div> --}}
    </div>
  </div>
@endsection
