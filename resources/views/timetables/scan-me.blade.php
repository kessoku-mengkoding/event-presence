<?php
$timezone = new DateTimeZone('Asia/Makassar'); // UTC+8
$now = new DateTime('now', $timezone);
$currentDateTime = $now->format('Y-m-d H:i:s');
?>

@extends('layouts.main')

@section('content')
  @if ($currentDateTime >= $timetable->start && $currentDateTime <= $timetable->end)
    <div class="mx-auto flex max-w-sm flex-col">
      <div class="mt-24 flex w-full items-center justify-center">
        <img src="{{ $timetable->qr_code_path }}" alt="">
      </div>
      <div class="inline-flex w-full items-center justify-center">
        <hr class="my-8 h-px w-full border-0 bg-slate-300">
        <span class="absolute left-1/2 -translate-x-1/2 bg-white px-3 text-sm text-black/50">or</span>
      </div>
      <a href="/presences/get-device-information?group_id={{ $timetable->group->id }}&timetable_id={{ $timetable->id }}"
        class="btn-primary-sm mx-auto w-max">Click Me</a>
    </div>
  @elseif($currentDateTime < $timetable->start)
    <div class="w-full">
      <dotlottie-player class="mx-auto my-24"
        src="https://lottie.host/d272a983-912f-43b5-b5f0-e76bca19396e/XyK5DRHtD2.json" background="transparent"
        speed="1" style="width: 300px; height: 300px;" loop autoplay></dotlottie-player>
      <h1 class="text-gradient-pink-blue mt-8 text-center text-2xl font-bold">Not yet</h1>
    </div>
  @else
    <div class="w-full">
      <dotlottie-player class="mx-auto" src="https://lottie.host/26c1a6fe-0609-4968-993a-38dc75e0a767/p9q2jJInhb.json"
        background="transparent" speed="1" style="width: 500px; height: 500px;" loop autoplay></dotlottie-player>
      <h1 class="text-gradient-pink-blue mt-8 text-center text-2xl font-bold">You missed it</h1>
    </div>
  @endif


  <a href="/"
    class="fixed left-12 top-1/2 flex h-12 w-12 -translate-y-1/2 transform items-center justify-center rounded-full bg-black p-4">
    <i class="fa-solid fa-angle-left text-white"></i>
  </a>
@endsection
