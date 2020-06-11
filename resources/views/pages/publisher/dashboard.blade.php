@extends('layouts.publishers')

@push('add-on-style')
  <link 
    rel="stylesheet" 
    href="{{ url('css/publisher/dashboard.css') }}">
@endpush

@section('title')
  Heav Publisher
@endsection

@section('content')
  <div class="container-fluid mt-3">
    <h4 class="d-inline">Data Penerbit</h4>
    <button 
      class="button d-inline float-right"
      id="btnUbahData">Ubah Data</button>
  </div>
  <div class="container-fluid container-data-publisher">
    <div class="row mt-3">
      <div class="col-2">
        <img 
          src="{{ $publisher["photoURL"] }}" 
          alt=""
          class="publisher-brand-image">
      </div>
      <div class="col-10">
        <table>
          <tr>
            <td>Nama</td>
            <td>:</td>
            <td>{{ $publisher["name"] }}</td>
          </tr>
          <tr>
            <td>Bergabung</td>
            <td>:</td>
            <td>{{ $publisher["month"] }} {{ $publisher["year"] }}</td>
          </tr>
          <tr>
            <td class="align-top">Deskripsi</td>
            <td class="align-top">:</td>
            <td>{{ $publisher["description"] }}</td>
          </tr>
        </table>
      </div>
    </div>
    <hr>
  </div>
  <div class="container-fluid conteiner-saldo">
    <h4 class="ml-2 d-inline">Saldo</h4>
    <h5 class="d-inline ml-5">Rp. {{ $publisher["balance"] }}</h5>
    <button class="button d-inline ml-5">Cairkan Saldo</button>
    <hr>
  </div>
  <div class="container-fluid mt-3">
    <h4 class="d-inline">Data Buku</h4>
    <button class="button d-inline float-right" id="btnTambahBuku">Tambah Buku</button>
  </div>
  <div class="container-fluid">
    <div class="row card-book">
      <div class="col-2">
        <img 
          src="{{ url('image/book_placeholder.png') }}" 
          alt=""
          class="ebook-image">
      </div>
      <div class="col-10">
        <h4>Judul Buku</h4>
        <p
          class="font-weight-bold author-info"><span>Ditulis oleh </span><span class="author-text">Nama Penulis</span></p>
        <p
          class="synopsis">Seasonal, mocha grinder, body siphon filter cup dripper affogato flavour. Robusta frappuccino cup wings macchiato,  chicory latte, rich cream flavour 
          extraction mazagran. Dark, medium crema dark kopi-luwak bar kopi-luwak. Aroma qui trifecta, cup, crema shop a affogato. Flavour, extra spoon,
          est grounds redeye xtraction mazagran. Dark, medium crema dark kopi-luwak bar kopi-luwak. Aroma qui trifecta, cup, cr,
          est grounds redeye xtraction mazagran. Dark, medium crema dark kopi-luwak bar kopi-luwak. Aroma qui trifecta, cup, cr</p>
        <div class="book-rating-container">
          <div class="star-container d-inline">
            <img 
              src="{{ url('image/icon/yellow_star.png') }}"
              alt=""
              class="star-image">
            <img 
              src="{{ url('image/icon/yellow_star.png') }}"
              alt=""
              class="star-image">
            <img 
              src="{{ url('image/icon/yellow_star.png') }}"
              alt=""
              class="star-image">
            <img 
              src="{{ url('image/icon/blank_star.png') }}"
              alt=""
              class="star-image">
            <img
              src="{{ url('image/icon/blank_star.png') }}"
              alt=""
              class="star-image">
          </div>
          <p class="d-inline mt-1">3.4 &emsp; (12 Ulasan) &emsp; 34x terjual</p>
        </div>
        <p class="price font-weight-bold">Rp. 34.000</p>
      </div>
    </div>
  </div>
@endsection

@push('add-on-script')
  <script
    src="{{ url('js/view/publisher/dashboard.js') }}"></script>
@endpush