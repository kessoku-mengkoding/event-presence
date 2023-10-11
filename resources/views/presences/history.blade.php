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
  <div class="mx-auto mt-12 flex max-w-2xl flex-col gap-6 text-center">
    @foreach ($user->presences as $presence)
      <div>
        <div class="group-card relative flex w-full items-center gap-6 overflow-clip rounded-lg border bg-white px-6 py-8">
          <div class="flex h-16 w-16 overflow-clip rounded-full bg-black">
            <img class="object-fill"
              src="{{ $presence->groupmember->group->image_path ?? 'https://images.unsplash.com/photo-1596367407372-96cb88503db6?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80' }}"
              alt="">
          </div>
          <div class="text-left">
            <h1 class="text-2xl font-bold">{{ $presence->timetable->title }}
              <span class="text-xs font-thin">
                ({{ formatDateTime($presence->timetable->start) }} - {{ formatDateTime($presence->timetable->end) }})
              </span>
            </h1>
            <p class="font-thin">in <span
                class="text-gradient-mktg font-semibold">{{ $presence->groupmember->group->name }}</span>
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
@endsection
