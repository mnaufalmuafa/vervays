@extends('layouts.app')

@push('add-on-style')
  <link 
    rel="stylesheet" 
    href="{{ url('css/buyer/wishlist.css') }}">
@endpush

@section('title')
  Wishlist
@endsection

@section('content')
  <h1>Wishlist</h1>
@endsection

@push('add-on-script')
  <script src="{{ url('js/view/buyer/wishlist.js') }}"></script>
@endpush