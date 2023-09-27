@extends('layouts.main')

@section('content')
  <div class="w-full">

    @if (!sizeof($groupmembers))
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
          <a class="btn-border block" href="/groups/join">Join Group</a>
          <span class="font-thin">or</span>
          <a href="/groups/create"
            class="btn-sm-no-color bg-yellow-100/50 font-semibold text-black hover:bg-yellow-100">Create
            Group</a>
        </div>
      </div>
    @else
      <h1 class="text-gradient-coral-yellow-dark mt-12 text-3xl font-bold text-center">Groups</h1>
      <div
        class="mx-auto mt-8 grid grid-cols-1 items-center justify-center gap-4 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
        <div class="flex h-full min-h-[200px] flex-col items-center justify-center gap-2 rounded-lg border">
          <a href="/groups/create"
            class="btn-sm-no-color bg-yellow-100/50 font-semibold text-black hover:bg-yellow-100">Create
            Group</a>
          <span class="font-thin">or</span>
          <a class="btn-border block" href="/groups/join">Join Group</a>
        </div>
        @foreach ($groupmembers as $member)
          <a href="{{ '/groups/' . $member->group->id . '/detail' }}"
            class="group-card relative flex min-h-[200px] flex-col rounded-lg border overflow-clip">
            <img
              src="{{$member->group->image_path ? $member->group->image_path : 'https://images.unsplash.com/photo-1596367407372-96cb88503db6?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80'}}"
              alt="">
            <div
              class="group-card-shadow absolute bottom-0 hidden h-[30%] w-full items-center justify-between rounded-b-lg bg-gradient-to-t from-black/40 to-transparent px-6">
              <h1 class="text-xl font-bold text-white">{{ $member->group->name }}</h1>
              <div class="flex h-12 w-12 items-center justify-center rounded-full bg-white">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 16 16" fill="none"
                  role="img" class="icon">
                  <path
                    d="M10.7408 2C13.0889 2 14.6667 4.235 14.6667 6.32C14.6667 10.5425 8.11856 14 8.00004 14C7.88152 14 1.33337 10.5425 1.33337 6.32C1.33337 4.235 2.91115 2 5.2593 2C6.60745 2 7.48893 2.6825 8.00004 3.2825C8.51115 2.6825 9.39263 2 10.7408 2Z"
                    stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                </svg>
              </div>
            </div>
          </a>
        @endforeach
      </div>
    @endif
  </div>
@endsection
