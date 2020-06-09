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
  <div class="container mt-3">
    <h4 class="d-inline">Data Penerbit</h4>
    <button class="button d-inline float-right">Ubah Data</button>
  </div>
  <div class="container container-data-publisher">
    <div class="row mt-3">
      <div class="col-2">
        <img 
          src="{{ url('image/profile_photos/1/default_publisher_profile_photo.jpg') }}" 
          alt=""
          class="publisher-brand-image">
      </div>
      <div class="col-10">
        <table>
          <tr>
            <td>Nama</td>
            <td>:</td>
            <td>Nama Publisher</td>
          </tr>
          <tr>
            <td>Bergabung</td>
            <td>:</td>
            <td>Mei 2020</td>
          </tr>
          <tr>
            <td class="align-top">Deskripsi</td>
            <td class="align-top">:</td>
            <td>Seasonal, mocha grinder, body siphon filter cup dripper affogato flavour. Robusta frappuccino 
              cup wings macchiato,  chicory latte, rich cream flavour extraction mazagran. Dark, medium crema 
              dark kopi luwak bar kopi-luwak. Aroma qui trifecta, cup, crema shop a affogato. Flavour, extra spoon
              est grounds redeye ...</td>
          </tr>
        </table>
      </div>
    </div>
    <hr>
  </div>
  <div class="container conteiner-saldo">
    <h4 class="ml-2 d-inline">Saldo</h4>
    <h5 class="d-inline ml-5">Rp. 0</h5>
    <button class="button d-inline ml-5">Cairkan Saldo</button>
    <hr>
  </div>
  <div class="container mt-3">
    <h4 class="d-inline">Data Buku</h4>
    <button class="button d-inline float-right">Tambah Buku</button>
  </div>
@endsection