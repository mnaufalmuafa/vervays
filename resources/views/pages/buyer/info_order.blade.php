@extends('layouts.app')

@push('add-on-style')
  {{-- <link 
    rel="stylesheet" 
    href="{{ url('css/buyer/cart.css') }}"> --}}
@endpush

@section('title')
  Pesanan
@endsection

@section('content')
  <div class="container-fluid">
    <h1>Info Order</h1>
  </div>
@endsection

@push('add-on-script')
  {{-- <script src="{{ url('js/view/buyer/cart.js') }}"></script> --}}
@endpush