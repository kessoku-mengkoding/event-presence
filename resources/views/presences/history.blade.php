<?php
function formatDateTime($inputDateTime)
{
    $dateTime = new DateTime($inputDateTime);
    $formattedDateTime = $dateTime->format('d/m/Y H:i:s');
    return $formattedDateTime;
}
?>

@extends('layouts.main')

@section('content')
  <div class="mx-auto max-w-3xl">
    <div class="mb-8">
      <h1 class="text-gradient-coral-yellow-dark mt-12 text-3xl font-bold">History</h1>
    </div>
    {{-- <div class="mx-auto mt-12 flex max-w-2xl flex-col gap-6 text-center">
    @foreach ($user->presences as $presence)
      <div>
        <div class="event-card relative flex w-full items-center gap-6 overflow-clip rounded-lg border bg-white px-6 py-8">
          <div class="flex h-16 w-16 overflow-clip rounded-full bg-black">
            <img class="object-fill"
              src="{{ $presence->eventmember->event->image_path ?? 'https://images.unsplash.com/photo-1596367407372-96cb88503db6?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80' }}"
              alt="">
          </div>
          <div class="text-left">
            <h1 class="text-2xl font-bold">{{ $presence->timetable->title }}
              <span class="text-xs font-thin">
                ({{ formatDateTime($presence->timetable->start) }} - {{ formatDateTime($presence->timetable->end) }})
              </span>
            </h1>
            <p class="font-thin">in <span
                class="text-gradient-mktg font-semibold">{{ $presence->eventmember->event->name }}</span>
            </p>
          </div>
        </div>
        <div class="-mt-2 h-10 rounded-b-lg bg-black text-white">
          <p class="text-gradient-premium-support pt-[12px] text-sm font-bold">
            {{ formatDateTime($presence->created_at) }}
          </p>
        </div>
      </div>
    @endforeach
  </div> --}}

    <ol class="relative border-s border-gray-200 dark:border-gray-700">
      @foreach ($presences as $presence)
        <li class="mb-10 ms-6">
          <span
            class="absolute -start-3 flex h-6 w-6 items-center justify-center rounded-full bg-blue-100 ring-8 ring-white dark:bg-blue-900 dark:ring-gray-900">
            <svg class="h-2.5 w-2.5 text-blue-800 dark:text-blue-300" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
              fill="currentColor" viewBox="0 0 20 20">
              <path
                d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
            </svg>
          </span>
          <h3 class="mb-1 flex items-center text-lg font-semibold text-gray-900 dark:text-white">
            {{ $presence->timetable->title }}, {{ $presence->eventmember->event->name }}
            @if ($loop->first)
              <span
                class="me-2 ms-3 rounded bg-blue-100 px-2.5 py-0.5 text-sm font-medium text-blue-800 dark:bg-blue-900 dark:text-blue-300">Latest</span>
            @endif
          </h3>
          <time class="mb-2 block text-sm font-normal leading-none text-gray-400 dark:text-gray-500">Attended on {{ $presence->date }}</time>
          {{-- <p class="mb-4 text-base font-normal text-gray-500 dark:text-gray-400">
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Repellendus nulla at molestias optio temporibus
            maxime,
            excepturi quasi quas ex et fugit consectetur, maiores illum facilis, earum esse laudantium blanditiis modi?
          </p> --}}
        </li>
      @endforeach
    </ol>
  </div>
@endsection
