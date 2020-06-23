@extends('layouts.app')

@push('add-on-style')
  <link 
    rel="stylesheet" 
    href="{{ url('css/buyer/ebook_info.css') }}">
@endpush

@section('title')
  Judul Buku
@endsection

@section('content')
  <div class="container-fluid">
    <div class="row mt-2">
      <div class="col-2">
        <img 
          src="{{ url('/image/book_placeholder.png') }}" 
          alt=""
          class="ebook-cover">
        <h5>Rp. 34.000</h5>
        <div class="button-container mt-4" role="1" id="button-container">
          <button class="button-aside" id="btnDelete">Hapus Buku</button>
          <button class="button-aside" id="btnEdit">Edit Buku</button>
          {{-- //////////////////////////////////////// --}}
          <button class="button-aside" id="btnRead">Baca Buku</button>
          <button class="button-aside" id="btnGiveRating">Beri Rating</button>
          {{-- //////////////////////////////////////// --}}
          <button class="button-aside" id="btnReadSample">Baca Sample</button>
          <button class="button-aside" id="btnAddToCart">Tambah ke Keranjang</button>
          <button class="button-aside" id="btnAddToWishlist">Tambah ke Wishlist</button>
          <button class="button-aside" id="btnBuy">Beli</button>
        </div>
      </div>
      <div class="col-10">
        <section class="first-section">
          <h2>Judul Buku</h2>
          <p class="author-info">Ditulis oleh <span>Nama Penulis</span></p>
          <div class="row rating-row">
            <img 
              src="{{ url('image/icon/blank_star.png') }}"
              alt=""
              class="star-image d-inline first-star">
            <img 
              src="{{ url('image/icon/blank_star.png') }}"
              alt=""
              class="star-image d-inline first-star">
            <img 
              src="{{ url('image/icon/blank_star.png') }}"
              alt=""
              class="star-image d-inline first-star">
            <img 
              src="{{ url('image/icon/blank_star.png') }}"
              alt=""
              class="star-image d-inline first-star">
            <img 
              src="{{ url('image/icon/blank_star.png') }}"
              alt=""
              class="star-image d-inline first-star">
            <p class="d-inline-block rating mt-1 ml-2">4.5</p>
            <p class="d-inline-block rating-count mt-1 ml-3">(127 Ulasan)</p>
          </div>
          <p class="order-sold-info">237 kali terjual</p>
          <hr>
        </section>
        <section class="synopsis-section">
          <h4>Sinopsis</h4>
          <p>
            Est single shot aromatic, a eu caramelization plunger pot, a, carajillo barista coffee id french press plunger 
            pot aromatic café au lait milk instant ristretto. Chicory java cinnamon mazagran, dark arabica, macchiato
            milk beans grinder cinnamon crema café au lait arabica. Ut aroma, chicory lungo plunger pot iced, chicory, 
            aromatic aged spoon caffeine strong irish, and americano froth shop americano aged. Mocha spoon barista 
            eu aftertaste siphon cappuccino frappuccino to go.
          </p>
          <p>
            Mug doppio et flavour body café au lait latte cappuccino. Froth caffeine extra brewed, rich, saucer skinny 
            roast so irish strong, fair trade white, latte brewed, dark, wings barista steamed mazagran pumpkin spice 
            fair trade. Brewed single origin wings, caramelization ristretto sugar that, robusta grinder java
            flavour extraction galão.
          </p>
          <hr>
        </section>
        <section class="detail-section">
          <h4>Detail Buku</h4>
          <div class="row">
            <div class="d-inline">
              <p>Bahasa</p>
              <p>Penerbit</p>
              <p>Penulis</p>
              <p>Jumlah halaman &ensp;</p>
              <p>Terbit</p>
            </div>
            <div class="d-inline">
              <p>: Inggris</p>
              <p id="publisherText">: <span>Elex Media Computindo</span></p>
              <p>: Asma Nadia</p>
              <p>: 213</p>
              <p>: 15 April 2020</p>
            </div>
          </div>
          <hr>
        </section>
        <section class="rating-section">
          <h4>Rating dan Ulasan</h4>
          <div class="row">
            <div class="d-inline">
              <div class="text-center">
                <h1 class="d-inline rating">4.5</h1>
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
                  class="star-image d-inline first-star">
                <img 
                  src="{{ url('image/icon/blank_star.png') }}"
                  alt=""
                  class="star-image d-inline first-star">
                <img 
                  src="{{ url('image/icon/blank_star.png') }}"
                  alt=""
                  class="star-image d-inline first-star">
                <img 
                  src="{{ url('image/icon/blank_star.png') }}"
                  alt=""
                  class="star-image d-inline first-star">
              </div>
              <p class="rating-count text-center">127 Ulasan</p>
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
                <p class="mt-1 ml-2">75</p>       
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
                <p class="mt-1 ml-2">75</p>       
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
                <p class="mt-1 ml-2">75</p>       
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
                <p class="mt-1 ml-2">75</p>       
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
                <p class="mt-1 ml-2">75</p>       
              </div>
            </div>
          </div>
        </section>
        <section class="review-section mt-4">
          <div class="card-custom">
            <div class="rating-row">
              <div class="row rating-row mt-1">
                <img 
                  src="{{ url('image/icon/blank_star.png') }}"
                  alt=""
                  class="star-image d-inline first-star">
                <img 
                  src="{{ url('image/icon/blank_star.png') }}"
                  alt=""
                  class="star-image d-inline first-star">
                <img 
                  src="{{ url('image/icon/blank_star.png') }}"
                  alt=""
                  class="star-image d-inline first-star">
                <img 
                  src="{{ url('image/icon/blank_star.png') }}"
                  alt=""
                  class="star-image d-inline first-star">
                <img 
                  src="{{ url('image/icon/blank_star.png') }}"
                  alt=""
                  class="star-image d-inline first-star">
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
          <div class="card-custom">
            <div class="rating-row">
              <div class="row rating-row mt-1">
                <img 
                  src="{{ url('image/icon/blank_star.png') }}"
                  alt=""
                  class="star-image d-inline first-star">
                <img 
                  src="{{ url('image/icon/blank_star.png') }}"
                  alt=""
                  class="star-image d-inline first-star">
                <img 
                  src="{{ url('image/icon/blank_star.png') }}"
                  alt=""
                  class="star-image d-inline first-star">
                <img 
                  src="{{ url('image/icon/blank_star.png') }}"
                  alt=""
                  class="star-image d-inline first-star">
                <img 
                  src="{{ url('image/icon/blank_star.png') }}"
                  alt=""
                  class="star-image d-inline first-star">
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
          <div class="card-custom">
            <div class="rating-row">
              <div class="row rating-row mt-1">
                <img 
                  src="{{ url('image/icon/blank_star.png') }}"
                  alt=""
                  class="star-image d-inline first-star">
                <img 
                  src="{{ url('image/icon/blank_star.png') }}"
                  alt=""
                  class="star-image d-inline first-star">
                <img 
                  src="{{ url('image/icon/blank_star.png') }}"
                  alt=""
                  class="star-image d-inline first-star">
                <img 
                  src="{{ url('image/icon/blank_star.png') }}"
                  alt=""
                  class="star-image d-inline first-star">
                <img 
                  src="{{ url('image/icon/blank_star.png') }}"
                  alt=""
                  class="star-image d-inline first-star">
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
          <button
            class="mb-5 ml-2 button" id="btnLoadMore">Muat Lebih</button>
        </section>
      </div>
    </div>
  </div>
@endsection