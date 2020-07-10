@extends('layouts.app')

@push('add-on-style')
  {{-- <link 
    rel="stylesheet" 
    href="{{ url('css/buyer/mybook.css') }}"> --}}
@endpush

@section('title')
  {{-- Nama Publisher --}}
@endsection

@section('content')
	<h1>Info Publisher</h1>
@endsection

@push('add-on-script')
  {{-- <script 
    type="text/javascript"
    src= "{{ url('js/view/buyer/mybook.js') }}">
  </script> --}}
@endpush