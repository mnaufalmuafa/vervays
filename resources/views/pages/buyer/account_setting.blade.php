@extends('layouts.app')

@push('add-on-style')
  {{-- <link 
    rel="stylesheet" 
    href="{{ url('css/buyer/cart.css') }}"> --}}
@endpush

@section('title')
  Pengaturan Akun
@endsection

@section('content')
  <div class="container-fluid">
    <h1>Pengaturan akun</h1>
  </div>
@endsection

@push('add-on-script')
  {{-- <script src="{{ url('js/view/buyer/cart.js') }}"></script> --}}
@endpush