@extends('layouts.app')

@push('add-on-style')
  <link 
    rel="stylesheet" 
    href="{{ url('css/buyer/dashboard.css') }}">
@endpush

@section('title')
  Heav ebook store
@endsection

@section('content')
  <div class="container-fluid mt-1"> {{-- Bestseller --}}
    <h2>Bestseller</h2>
    <div class="row">
      @for ($i = 0; $i < 6; $i++)
        <div class="col-2 book-card">
          <img 
            src="/image/book_placeholder.png" 
            alt=""
            class="book-cover">
          <p class="bookTitle">Unlock Your Ideas for Your Business Unlock Your Ideas for Your Business</p>
          <p class="bookAuthor">Asma Nadia</p>
          <img 
            src="{{ url('image/icon/blank_star.png') }}"
            alt=""
            class="star-image d-inline first-star">
          <img 
            src="{{ url('image/icon/blank_star.png') }}"
            alt=""
            class="star-image d-inline second-star">
          <img 
            src="{{ url('image/icon/blank_star.png') }}"
            alt=""
            class="star-image d-inline third-star">
          <img 
            src="{{ url('image/icon/blank_star.png') }}"
            alt=""
            class="star-image d-inline fourth-star">
          <img 
            src="{{ url('image/icon/blank_star.png') }}"
            alt=""
            class="star-image d-inline fifth-star">
          <p class="rating-text d-inline">(3.4)</p>
          <p class="price mt-2">Rp. 34.000</p>
        </div>
      @endfor
    </div>
  </div>
  <div class="container-fluid mt-3"> {{-- Terbaru --}}
    <h2>Buku Terbaru</h2>
    <div class="row">
      @for ($i = 0; $i < 6; $i++)
        <div class="col-2 book-card">
          <img 
            src="/image/book_placeholder.png" 
            alt=""
            class="book-cover">
          <p class="bookTitle">Unlock Your Ideas for Your Business Unlock Your Ideas for Your Business</p>
          <p class="bookAuthor">Asma Nadia</p>
          <img 
            src="{{ url('image/icon/blank_star.png') }}"
            alt=""
            class="star-image d-inline first-star">
          <img 
            src="{{ url('image/icon/blank_star.png') }}"
            alt=""
            class="star-image d-inline second-star">
          <img 
            src="{{ url('image/icon/blank_star.png') }}"
            alt=""
            class="star-image d-inline third-star">
          <img 
            src="{{ url('image/icon/blank_star.png') }}"
            alt=""
            class="star-image d-inline fourth-star">
          <img 
            src="{{ url('image/icon/blank_star.png') }}"
            alt=""
            class="star-image d-inline fifth-star">
          <p class="rating-text d-inline">(3.4)</p>
          <p class="price mt-2">Rp. 34.000</p>
        </div>
      @endfor
    </div>
  </div>
  <div class="container-fluid mt-3 mb-3"> {{-- Pilihan Editor --}}
    <h2>Pilihan Editor</h2>
    <div class="row">
      @for ($i = 0; $i < 6; $i++)
        <div class="col-2 book-card">
          <img 
            src="/image/book_placeholder.png" 
            alt=""
            class="book-cover">
          <p class="bookTitle">Unlock Your Ideas for Your Business Unlock Your Ideas for Your Business</p>
          <p class="bookAuthor">Asma Nadia</p>
          <img 
            src="{{ url('image/icon/blank_star.png') }}"
            alt=""
            class="star-image d-inline first-star">
          <img 
            src="{{ url('image/icon/blank_star.png') }}"
            alt=""
            class="star-image d-inline second-star">
          <img 
            src="{{ url('image/icon/blank_star.png') }}"
            alt=""
            class="star-image d-inline third-star">
          <img 
            src="{{ url('image/icon/blank_star.png') }}"
            alt=""
            class="star-image d-inline fourth-star">
          <img 
            src="{{ url('image/icon/blank_star.png') }}"
            alt=""
            class="star-image d-inline fifth-star">
          <p class="rating-text d-inline">(3.4)</p>
          <p class="price mt-2">Rp. 34.000</p>
        </div>
      @endfor
    </div>
  </div>
@endsection

@push('add-on-script')
  <script 
    type="text/javascript"
    src= "{{ url('js/view/buyer/dashboard.js') }}">
  </script>
@endpush