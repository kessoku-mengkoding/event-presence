@extends('layouts.main')

@section('content')
  <script>
    const getAddress = async (lat, long) => {
      const response = await fetch(
        `https://api.opencagedata.com/geocode/v1/json?q=${lat}+${long}&key=024c66666f024043ac452d5d9993329e`
      );
      const data = await response.json();
      console.log(data?.results[0]?.formatted);
      return data?.results[0]?.formatted;
    };

    const updateAddress = async (latitude, longitude, elementId) => {
      const address = await getAddress(latitude, longitude);
      document.getElementById(elementId).textContent = address;
    };
  </script>

  <h1> Timetable name: {{ $timetable->title }} </h1>
  @foreach ($presences as $p)
    <li class="flex gap-12 border border-black">
      <p>username: {{ $p->user->username }}</p>
      <p>name: {{ $p->user->name }}</p>
      <p>email: {{ $p->user->email }}</p>
      <p>status: {{ $p->status }}</p>
      <p>is valid: {{ $p->is_valid }}</p>
      <p>coords: {{ $p->longitude }}, {{ $p->latitude }}</p>
      <p>address: <span id="address_{{ $p->id }}"></span></p>
      <script>
        updateAddress({{ $p->latitude }}, {{ $p->longitude }}, "address_{{ $p->id }}");
      </script>
      <p>created at: {{ $p->created_at }}</p>
    </li>
  @endforeach
@endsection
