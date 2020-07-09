@extends('layouts.app')

@push('add-on-meta')
  {{-- <meta name="book-id" content="{{ $book["id"] }}"> --}}
@endpush

@push('add-on-style')
  <link 
    rel="stylesheet" 
    href="{{ url('css/buyer/ebook_info.css') }}">
@endpush

@section('title')
  Beri Rating
@endsection

@section('content')
  <div class="container-fluid">
    <h4>Ulas Buku</h4>
  </div>
@endsection

@push('add-on-script')
  <script src="{{ url('js/view/buyer/ebook_info.js') }}"></script>
@endpush