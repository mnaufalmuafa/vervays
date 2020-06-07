@extends('layouts.app')

@push('add-on-style')
  <link 
    rel="stylesheet" 
    href="{{ url('css/buyer/dashboard.css') }}">
@endpush

@section('title')
  Search
@endsection

@section('content')
  <h1>Search</h1>
  <h2>Keyword : {{ $keyword }}</h2>
@endsection

@push('add-on-script')
  <script 
    type="text/javascript"
    src= "{{ url('js/view/buyer/dashboard.js') }}">
  </script>
@endpush