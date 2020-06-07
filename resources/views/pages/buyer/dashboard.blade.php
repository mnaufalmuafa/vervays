@extends('layouts.app')

@push('add-on-style')
  <link 
    rel="stylesheet" 
    href="{{ url('css/buyer/dashboard.css') }}">
@endpush

@section('title')
  Heav
@endsection

@section('content')
  <h1>Best Seller</h1>
@endsection

@push('add-on-script')
  <script 
    type="text/javascript"
    src= "{{ url('js/view/dashboard.js') }}">
  </script>
@endpush