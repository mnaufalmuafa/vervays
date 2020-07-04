@extends('layouts.app')

@push('add-on-style')
  {{-- <meta name="keyword" content="{{ $keyword }}">
  <link 
    rel="stylesheet" 
    href="{{ url('css/buyer/search.css') }}"> --}}
@endpush

@section('title')
  Daftar Transaksi
@endsection

@section('content')
  <div class="container-fluid">
    <h4>Daftar Transaksi</h4>
  </div>
@endsection

@push('add-on-script')
  {{-- <script 
    type="text/javascript"
    src= "{{ url('js/view/buyer/search.js') }}">
  </script> --}}
@endpush