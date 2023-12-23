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
  <script>
    function startCountdown(targetDate, elementId, status) {
      var countDownDate = new Date(targetDate).getTime();

      var x = setInterval(function() {
        var now = new Date().getTime();
        var distance = countDownDate - now;
        var days = Math.floor(distance / (1000 * 60 * 60 * 24));
        var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        var seconds = Math.floor((distance % (1000 * 60)) / 1000);

        document.getElementById(elementId).innerHTML = (status == 'upcoming' ? 'next ' : '') + days + "d " + hours + "h " +
          minutes + "m " + seconds + "s " + (status == 'upcoming' ? '' : 'left')

        if (distance < 0) {
          clearInterval(x);
          document.getElementById(elementId).innerHTML = "EXPIRED";
        }
      }, 1000);
    }
  </script>

  <div class="flex">

    <div class="mt-12 w-3/12">
      {{-- Recent --}}
      <div class="w-full">
        <div class="-mb-[6px] rounded-t-lg bg-black px-4 pb-3 pt-1">
          <h1 class="text-gradient-copilot font-semibold"><i class="fa-solid fa-cannabis mr-2"></i> Recent</h1>
        </div>
        <ul class="flex flex-col gap-2 rounded-lg border bg-white p-4 shadow-md">
          @foreach ($recent_timetables as $timetable)
            <li class="flex items-center gap-4">
              <div>
                <i class="fa-solid fa-clipboard-check"></i>
              </div>
              <div>
                <a href="">
                  <h1 class="text-gradient-blue-green">{{ $timetable->title }}</h1>
                </a>
                <p class="text-xs font-thin">{{ $timetable->group->name }}</p>
              </div>
            </li>
          @endforeach
        </ul>
      </div>

      {{-- Done --}}
      <div class="mt-6 w-full">
        <div class="-mb-[6px] rounded-t-lg bg-black px-4 pb-3 pt-1">
          <h1 class="text-gradient-copilot font-semibold"><i class="fa-solid fa-dove mr-2"></i> Done</h1>
        </div>
        <ul class="flex flex-col gap-2 rounded-lg border bg-white p-4 shadow-md">
          @foreach ($timetables->groupmembers as $groupmembers)
            @foreach ($groupmembers->group->timetables as $timetable)
              @if ($timetable->is_presence)
                <li class="flex items-center gap-4">
                  <div>
                    <i class="fa-solid fa-clipboard-check"></i>
                  </div>
                  <div>
                    <a href="">
                      <h1 class="text-gradient-blue-green">{{ $timetable->title }}</h1>
                    </a>
                    <p class="text-xs font-thin">{{ $groupmembers->group->name }}</p>
                  </div>
                </li>
              @endif
            @endforeach
          @endforeach
        </ul>
      </div>
    </div>

    <div class="w-8/12">
      <div class="mt-12 flex justify-center gap-4">
        <a href="/"
          class="btn-sm-no-color {{ !$type ? 'bg-gray-800 text-white' : '' }} cursor-pointer hover:opacity-50">All</a>
        <a href="/?type=ongoing"
          class="btn-sm-no-color {{ $type == 'ongoing' ? 'bg-gray-800 text-white' : '' }} cursor-pointer hover:opacity-50">Ongoing</a>
        <a href="/?type=upcoming"
          class="btn-sm-no-color {{ $type == 'upcoming' ? 'bg-gray-800 text-white' : '' }} cursor-pointer hover:opacity-50">Upcoming</a>
        <a href="/?type=missed"
          class="btn-sm-no-color {{ $type == 'missed' ? 'bg-gray-800 text-white' : '' }} cursor-pointer hover:opacity-50">Missed</a>
      </div>
    
      <div class="mx-auto mt-12 flex max-w-2xl flex-col gap-6 text-center">
      @if ($timetables == null || sizeof($timetables->groupmembers) == 0)
    <dotlottie-player class="mx-auto" src="https://lottie.host/35b76ef9-de90-4af4-967c-b5edb886af3b/gq16fXIeyQ.json"
        background="transparent" speed="1" style="width: 300px; height: 300px;" loop autoplay></dotlottie-player>
    <p class="text-semibold -mt-10 text-center">Nothing to see here</p>
@endif
        @foreach ($timetables->groupmembers as $groupmembers)
          @foreach ($groupmembers->group->timetables as $timetable)
            @if (($type ? $timetable->status == $type : true) && !$timetable->is_presence)
              <div class="group-card">
                <a href="/timetables/{{ $timetable->id }}/scan-me"
                  class="relative flex w-full items-center gap-6 overflow-clip rounded-lg border bg-white px-6 py-5 shadow-md">
                  <div class="flex h-16 w-16 overflow-clip rounded-full bg-black">
                    <img class="object-fill"
                      src="{{ $groupmembers->group->image_path ? $groupmembers->group->image_path : 'https://images.unsplash.com/photo-1596367407372-96cb88503db6?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80' }}"
                      alt="">
                  </div>
                  <div class="text-left">
                    <h1 class="text-2xl font-bold">{{ $timetable->title }}
                      <span class="text-xs font-thin">
                        ({{ formatDateTime($timetable->start) }} - {{ formatDateTime($timetable->end) }})
                      </span>
                    </h1>
                    <p class="font-thin">in <span
                        class="text-gradient-mktg font-semibold">{{ $groupmembers->group->name }}</span></p>
                  </div>
                  <div class="absolute right-3 top-3 rounded-[5px] bg-black px-2 py-1">
                    <p class="text-xs text-white">{{ $timetable->status }}</p>
                  </div>
                </a>
                <div class="timer -mt-2 hidden h-10 rounded-b-lg bg-black text-white" id="{{ $timetable->id }}">
                  {{-- @if ($timetable->status == 'ongoing')
                    <p class="text-gradient-premium-support pt-[12px] text-sm font-bold">
                      Until {{ \Carbon\Carbon::parse($timetable->end)->diffForHumans() }}</p>
                  @elseif ($timetable->status == 'upcoming')
                    <p class="text-gradient-premium-support pt-[12px] text-sm font-bold">
                      Opened {{ \Carbon\Carbon::parse($timetable->start)->diffForHumans() }}</p>
                  @else
                    <p class="text-gradient-premium-support pt-[12px] text-sm font-bold">
                      Closed {{ \Carbon\Carbon::parse($timetable->start)->diffForHumans() }}</p>
                  @endif --}}
                  <div class="group-card">
                    <p class="text-gradient-premium-support pt-[12px] text-sm font-bold" id="timer-{{ $timetable->id }}">
                      <script>
                        startCountdown("{{ $timetable->status == 'upcoming' ? $timetable->start : $timetable->end }}",
                          "timer-{{ $timetable->id }}", "{{ $timetable->status }}");
                      </script>
                    </p>
                  </div>
                  {{-- <p class="text-gradient-premium-support pt-[12px] text-sm font-bold">{{ $timetable->time_description }} --}}
                </div>
              </div>
 
            @endif
          @endforeach
        @endforeach
      </div>
    </div>
  </div>
@endsection
