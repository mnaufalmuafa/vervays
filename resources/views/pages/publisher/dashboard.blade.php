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
  @foreach ($books as $book)
    <div class="container-fluid">
      <div 
        class="row card-book"
        rating="{{ $book["rating"] }}"
        id="book-card-{{$book["id"]}}">
        <div class="col-2">
          <img 
            src="{{ $book["imageURL"] }}" 
            alt=""
            class="ebook-image"
            book-id="{{ $book["id"] }}">
        </div>
        <div class="col-10">
          <h4
            class="book-title"
            book-id="{{ $book["id"] }}">{{ $book["title"] }}</h4>
          <p
            class="font-weight-bold author-info"><span>Ditulis oleh </span><span class="author-text">{{ $book["author"] }}</span></p>
          <p
            class="synopsis">{{ $book["synopsis"] }}</p>
          <div class="book-rating-container row">
            <div class="star-container d-inline">
              <img 
                src="{{ url('image/icon/blank_star.png') }}"
                alt=""
                class="star-image first-star">
              <img 
                src="{{ url('image/icon/blank_star.png') }}"
                alt=""
                class="star-image second-star">
              <img 
                src="{{ url('image/icon/blank_star.png') }}"
                alt=""
                class="star-image third-star">
              <img 
                src="{{ url('image/icon/blank_star.png') }}"
                alt=""
                class="star-image fourth-star">
              <img
                src="{{ url('image/icon/blank_star.png') }}"
                alt=""
                class="star-image fifth-star">
            </div>
            <p class="d-inline-block ml-3"><span>{{ $book["rating"] }}</span> &emsp; (<span>{{ $book["ratingCount"] }}</span> Ulasan) &emsp; <span>{{ $book["soldCount"] }}</span>x terjual</p>
          </div>
          <p 
            class="price font-weight-bold d-inline">Rp. {{ $book["price"] }}</p>
          <img 
            src="{{ url('/image/ic_trash.png') }}" 
            alt="ic_trash"
            class="d-inline float-right ic-trash mt-1"
            book-id="{{ $book["id"] }}"
            book-title="{{ $book["title"] }}">
          <button
            class="button d-inline float-right mr-2 btn-edit-buku"
            book-id="{{ $book["id"] }}">Edit buku</button>
          <button
            class="button d-inline float-right mr-2 btn-view-buku"
            book-id="{{ $book["id"] }}"
            book-title="{{ $book["title"] }}">Lihat detail buku</button>
        </div>
      </div>
    </div>
  @endforeach
@endsection

@push('add-on-script')
  <script
    src="{{ url('js/view/publisher/dashboard.js') }}"></script>
@endpush