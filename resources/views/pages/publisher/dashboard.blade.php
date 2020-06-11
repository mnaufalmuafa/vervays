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
    <button 
      class="button d-inline float-right"
      id="btnUbahData">Ubah Data</button>
  </div>
  <div class="container container-data-publisher">
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
  <div class="container conteiner-saldo">
    <h4 class="ml-2 d-inline">Saldo</h4>
    <h5 class="d-inline ml-5">Rp. {{ $publisher["balance"] }}</h5>
    <button class="button d-inline ml-5">Cairkan Saldo</button>
    <hr>
  </div>
  <div class="container mt-3">
    <h4 class="d-inline">Data Buku</h4>
    <button class="button d-inline float-right" id="btnTambahBuku">Tambah Buku</button>
  </div>
@endsection

@push('add-on-script')
  <script
    src="{{ url('js/view/publisher/dashboard.js') }}"></script>
@endpush