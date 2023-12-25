@extends('layouts.admin')

@section('content')
  <p>penduduk: {{ $total_residents }}</p>
  <p>kegiatan: {{ $total_events }}</p>
  <p>user: {{ $total_users }}</p>
@endsection
