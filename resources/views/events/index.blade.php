@extends('layouts.main')

@section('content')
  <div class="w-full">

    @if (!sizeof($eventmembers))
      <div class="my-4">
        <img class="mx-auto" width="500"
          src="https://cdn.dribbble.com/assets/art-banners/live-ch-2-06c2d22b44499770d946df4be0064fe7f6d22e30664016542a42d8221ff25fb0.jpg"
          alt="">
        <p class="mx-auto max-w-xl text-center font-thin">Say goodbye to manual attendance tracking and embrace a world
          of efficiency,
          accuracy, and convenience. Whether you're a school, business, or organization of any size, our attendance app is
          designed to streamline your processes and elevate your productivity.
        </p>
        <div class="mt-8 flex items-center justify-center gap-4">
          @if (Auth::user()->is_admin)
            <a href="/events/create" class="btn-sm-no-color bg-yellow-100/50 font-semibold text-black hover:bg-yellow-100">
              Create Event
            </a>
          @else
            <a class="btn-border block" href="/events/join">Join Event</a>
          @endif
        </div>
      @else
        <div class="mx-auto max-w-2xl">
          <h1 class="text-gradient-coral-yellow-dark mt-12 text-3xl font-bold">Events</h1>
        </div>
        <div class="mx-auto mt-8 flex max-w-2xl flex-col items-center justify-center gap-6">
          <div class="flex w-full items-center justify-center gap-4 rounded-lg border py-8 shadow-md">
            @if (Auth::user()->is_admin)
              <a href="/events/create"
                class="btn-sm-no-color bg-yellow-100/50 font-semibold text-black hover:bg-yellow-100">Create
              </a>
            @else
              <a class="btn-primary-sm" href="/events/join">Join </a>
            @endif
          </div>
          @foreach ($eventmembers as $member)
            <a href="{{ '/events/' . $member->event->id . '/detail' }}"
              class="event-card relative flex w-full items-center gap-6 overflow-clip rounded-lg border px-6 py-5 shadow-md">
              <div class="flex h-16 w-16 overflow-clip rounded-full bg-black">
                <img class="object-fill"
                  src="{{ $member->event->image_path ? $member->event->image_path : 'https://images.unsplash.com/photo-1596367407372-96cb88503db6?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80' }}"
                  alt="">
              </div>
              <div class="flex items-center justify-between">
                <div>
                  <h1 class="text-2xl font-semibold">{{ $member->event->name }}</h1>
                  <div>
                    <i class="fa-regular fa-user"></i>
                    <span>{{ sizeof($member->event->eventmembers) }}</span>
                  </div>
                </div>
                <div class="absolute right-6">
                  <i class="fa-regular fa-star fa-xl"></i>
                </div>
              </div>
            </a>
          @endforeach
        </div>
    @endif
  </div>
@endsection
