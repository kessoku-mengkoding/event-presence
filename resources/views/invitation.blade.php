@extends('layouts.main')

{{-- <p class="mb-4">{{ $invitations }}</p> --}}

@section('content')
  <div class="my-12">
    <h1 class="text-gradient-pink-blue mb-12 text-center text-3xl font-bold">Invitations</h1>

    @if (sizeof($invitations))
      @foreach ($invitations as $inv)
        <div class="mt-6 flex items-center justify-between">
          <p>You're invited to group <span class="font-bold text-gradient-mktg">{{ $inv->group->name }}</span> by
            <span class="font-bold text-gradient-copilot">{{ $inv->groupmember->user->username }}</span></p>
          <div class="flex gap-2">
            <form action="/invitations/{{ $inv->id }}/accept" method="POST"> @csrf @method('PUT')
              <input type="hidden" name="group_id" value="{{ $inv->group_id }}">
              <button class="btn-sm-no-color bg-yellow-100 hover:opacity-70">Accept</button>
            </form>
            <form action="/invitations/{{ $inv->id }}/decline" method="POST"> @csrf @method('PUT')
              <button class="btn-sm-no-color bg-red-300 hover:opacity-70">Decline</button>
            </form>
          </div>
        </div>
      @endforeach
    @else
      <dotlottie-player class="mx-auto" src="https://lottie.host/35b76ef9-de90-4af4-967c-b5edb886af3b/gq16fXIeyQ.json"
        background="transparent" speed="1" style="width: 300px; height: 300px;" loop autoplay></dotlottie-player>
      <p class="text-semibold -mt-10 text-center">Nothing to see here</p>
    @endif
  </div>
@endsection
