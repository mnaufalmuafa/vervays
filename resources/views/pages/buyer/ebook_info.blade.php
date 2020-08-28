@extends('layouts.app')

@push('add-on-meta')
  <meta name="book-id" content="{{ $book["id"] }}">
@endpush

@push('add-on-style')
  <link 
    rel="stylesheet" 
    href="{{ url('css/buyer/ebook_info.css') }}">
@endpush

@section('title')
  Jual ebook {{ $book["title"] }}
@endsection

@section('content')
  <div class="container-fluid d-none" id="exception-container">
    <h2 class="text-center mt-3">Hmmm.... Buku telah terhapus</h2>
  </div>
  <div class="container-fluid d-none" id="main-container">
    <div class="row mt-2">
      <div class="col-2">
        <img 
          src="{{ $book["imageURL"] }}" 
          alt=""
          class="ebook-cover">
        <h5>Rp. {{ $book["priceForHuman"] }}</h5>
        <div class="button-container mt-4" role="1" id="button-container">
          <button class="button-aside" id="btnEdit">Edit Buku</button>
          <button class="button-aside" id="btnDelete" data-title="{{ $book["title"] }}">Hapus Buku</button>
          {{-- //////////////////////////////////////// --}}
          <button class="button-aside" id="btnRead" onclick="redirectToReadPage()">Baca Buku</button>
          <button class="button-aside" id="btnGiveRating">Beri Ulasan</button>
          {{-- //////////////////////////////////////// --}}
          <button class="button-aside" id="btnReadSample" onclick="redirectToReadSamplePage()">Baca Sample</button>
          <button class="button-aside" id="btnAddToCart">Tambah ke Keranjang</button>
          <button class="button-aside" id="btnAddToWishlist">Tambah ke Wishlist</button>
          <button class="button-aside" id="btnBuy">Beli</button>
        </div>
      </div>
      <div class="col-10">
        <section class="first-section">
          <h2>{{ $book["title"] }}</h2>
          <p class="author-info">Ditulis oleh <span>{{ $book["author"] }}</span></p>
          <div class="row rating-row">
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
            <p class="d-inline-block rating mt-1 ml-2">{{ $book["rating"] }}</p>
            <p class="d-inline-block rating-count mt-1 ml-3">({{ $book["ratingCount"] }} Ulasan)</p>
          </div>
          <p class="order-sold-info">{{ $book["soldCount"] }} kali terjual</p>
          <hr>
        </section>
        <section class="synopsis-section">
          <h4>Sinopsis</h4>
          <div id="textSynopsis" style="white-space: pre-wrap">{{ $book["synopsis"] }}</div>
          <hr>
        </section>
        <section class="detail-section">
          <h4>Detail Buku</h4>
          <div class="row">
            <div class="d-inline">
              <p>Bahasa</p>
              <p>Penerbit</p>
              <p>Penulis</p>
              <p>Kategori</p>
              <p>Jumlah halaman &ensp;</p>
              <p>Terbit</p>
            </div>
            <div class="d-inline">
              <p>: {{ $book["language"] }}</p>
              <p id="publisherText" data-id="{{ $book["publisherId"] }}">: <span>{{ $book["publisher"] }}</span></p>
              <p>: {{ $book["author"] }}</p>
              <p>: {{ $book["category"] }}</p>
              <p>: {{ $book["numberOfPage"] }}</p>
              <p id="relaseDate">: <span>{{ $book["release_at"] }}</span></p>
            </div>
          </div>
          <hr>
        </section>
        <section class="rating-section">
          <h4>Rating dan Ulasan</h4>
          <div class="row">
            <div class="d-inline">
              <div class="text-center">
                <h1 class="d-inline rating">{{ $book["rating"] }}</h1>
                <p class="d-inline">/5</p>
              </div>
              <div class="row rating-row mt-1 mb-2">
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
              </div>
              <p class="rating-count text-center">{{ $book["ratingCount"] }} Ulasan</p>
            </div>
            <div class="d-inline pl-5">
              <div class="row rating-row-progress" id="fifth-rating-row">
                <img 
                  src="{{ url('image/icon/yellow_star.png') }}"
                  alt=""
                  class="star-image d-inline first-star">
                <p class="d-inline-block mt-1 ml-1 font-weight-bold">5</p>
                <div class="custom-progress mt-2 ml-2">
                  <div class="loaded"></div>
                </div>
                <p class="mt-1 ml-2">0</p>       
              </div>
              <div class="row rating-row-progress" id="fourth-rating-row">
                <img 
                  src="{{ url('image/icon/yellow_star.png') }}"
                  alt=""
                  class="star-image d-inline first-star">
                <p class="d-inline-block mt-1 ml-1 font-weight-bold">4</p>
                <div class="custom-progress mt-2 ml-2">
                  <div class="loaded"></div>
                </div>
                <p class="mt-1 ml-2">0</p>       
              </div>
              <div class="row rating-row-progress" id="third-rating-row">
                <img 
                  src="{{ url('image/icon/yellow_star.png') }}"
                  alt=""
                  class="star-image d-inline first-star">
                <p class="d-inline-block mt-1 ml-1 font-weight-bold">3</p>
                <div class="custom-progress mt-2 ml-2">
                  <div class="loaded"></div>
                </div>
                <p class="mt-1 ml-2">0</p>       
              </div>
              <div class="row rating-row-progress" id="second-rating-row">
                <img 
                  src="{{ url('image/icon/yellow_star.png') }}"
                  alt=""
                  class="star-image d-inline first-star">
                <p class="d-inline-block mt-1 ml-1 font-weight-bold">2</p>
                <div class="custom-progress mt-2 ml-2">
                  <div class="loaded"></div>
                </div>
                <p class="mt-1 ml-2">0</p>       
              </div>
              <div class="row rating-row-progress" id="first-rating-row">
                <img 
                  src="{{ url('image/icon/yellow_star.png') }}"
                  alt=""
                  class="star-image d-inline first-star">
                <p class="d-inline-block mt-1 ml-1 font-weight-bold">1</p>
                <div class="custom-progress mt-2 ml-2">
                  <div class="loaded"></div>
                </div>
                <p class="mt-1 ml-2">0</p>       
              </div>
            </div>
          </div>
        </section>
        <section class="review-section mt-4">
          <div id="reviews-container">
            <template id="ratingContainer">
              <div class="card-custom" id="rating-">
                <div class="rating-row">
                  <div class="row rating-row mt-1">
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
                    <p class="reviewer d-inline-block mt-1 ml-4 font-weight-bold">Kikim Rahmawati</p>
                  </div>
                </div>
                <p class="review">
                  My reading tastes seem to have changed this past year and I've been scooping up a lot of books in the mystery/suspense genre. So when St. Martin's Press sent me a paperback of this book, I couldn't wait to dive in. I am impressed with T.M. Logan's writing. I was practically glued to the pages of this book.
                </p>
                <div class="review-date-row">
                  <p class="review-date">28 September 2020</p>
                </div>
              </div>
            </template>
          </div>
          <button
            class="mb-5 ml-2 button" id="btnLoadMore">Muat Lebih</button>
        </section>
      </div>
    </div>
  </div>
@endsection

@push('add-on-script')
  <script src="{{ url('js/view/buyer/ebook_info.js') }}"></script>
@endpush