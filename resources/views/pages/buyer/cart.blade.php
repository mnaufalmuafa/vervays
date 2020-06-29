@extends('layouts.app')

@push('add-on-style')
  <link 
    rel="stylesheet" 
    href="{{ url('css/buyer/cart.css') }}">
@endpush

@section('title')
  Keranjang Belanja
@endsection

@section('content')
  <div class="fluid-container">
    <h1>Halaman Keranjang Belanja</h1>
  </div>
@endsection

@push('add-on-script')
  <script src="{{ url('js/view/buyer/cart.js') }}"></script>
@endpush