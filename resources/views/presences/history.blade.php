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
<div class="">
          <h1 class="text-gradient-coral-yellow-dark mt-12 text-3xl font-bold">History</h1>
        </div>
  <div class="mx-auto mt-12 flex max-w-2xl flex-col gap-6 text-center">
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
  </div>

  
<ol class="relative border-s border-gray-200 dark:border-gray-700">                  
    <li class="mb-10 ms-6">            
        <span class="absolute flex items-center justify-center w-6 h-6 bg-blue-100 rounded-full -start-3 ring-8 ring-white dark:ring-gray-900 dark:bg-blue-900">
            <svg class="w-2.5 h-2.5 text-blue-800 dark:text-blue-300" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"/>
            </svg>
        </span>
        <h3 class="flex items-center mb-1 text-lg font-semibold text-gray-900 dark:text-white">Debat Capres Cawapres TITLE<span class="bg-blue-100 text-blue-800 text-sm font-medium me-2 px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300 ms-3">Latest</span></h3>
        <time class="block mb-2 text-sm font-normal leading-none text-gray-400 dark:text-gray-500">Attended on January 13th, 2022</time>
        <p class="mb-4 text-base font-normal text-gray-500 dark:text-gray-400">
          Lorem ipsum dolor sit amet consectetur adipisicing elit. Repellendus nulla at molestias optio temporibus maxime, excepturi quasi quas ex et fugit consectetur, maiores illum facilis, earum esse laudantium blanditiis modi?  
        </p>
    </li>
    <li class="mb-10 ms-6">
        <span class="absolute flex items-center justify-center w-6 h-6 bg-blue-100 rounded-full -start-3 ring-8 ring-white dark:ring-gray-900 dark:bg-blue-900">
            <svg class="w-2.5 h-2.5 text-blue-800 dark:text-blue-300" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"/>
            </svg>
        </span>
        <h3 class="mb-1 text-lg font-semibold text-gray-900 dark:text-white">Day 1 Konser Ngawi</h3>
        <time class="block mb-2 text-sm font-normal leading-none text-gray-400 dark:text-gray-500">Released on December 7th, 2021</time>
        <p class="text-base font-normal text-gray-500 dark:text-gray-400">
          Lorem ipsum dolor sit amet consectetur adipisicing elit. Neque obcaecati minima consectetur. Aspernatur hic mollitia dicta odio est impedit quod nihil distinctio. Enim totam consequuntur modi ullam, ipsa consequatur quia?
        </p>
    </li>
</ol>



@endsection
