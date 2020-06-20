@extends('layouts.app')

@push('add-on-style')
  <meta name="keyword" content="{{ $keyword }}">
  <link 
    rel="stylesheet" 
    href="{{ url('css/buyer/search.css') }}">
@endpush

@section('title')
  Search
@endsection

@section('content')
  <div class="container-fluid">
    <div class="row justify-content-between mt-3 mx-1 first-row">
      <p class="col" id="keyword">Hasil pencarian untuk "<span></span>"</p>
      <div class="col">
        <select name="" id="orderOption" class="d-inline float-right ml-2">
          <optgroup>
            <option value="1" selected>Bestseller</option>
            <option value="2">Harga - Termahal ke termurah</option>
            <option value="3">Harga - Termurah ke termahal</option>
          </optgroup>
        </select>
        <p class="d-inline float-right">Urutkan berdasarkan : </p>
      </div>
    </div>
    <div class="row second-row">
      <div class="col-2">
        <div class="filter-wrapper"> {{-- Filter kategori --}}
          <div 
            class="collapse-header" 
            id="categoryListCollapseHeader"
            data-toggle="collapse" 
            data-target="#categoryList" 
            aria-expanded="false" 
            aria-controls="categoryList">
            <p class="d-inline">Kategori</p>
            <i 
              class="fa fa-fw fa-sort-desc d-inline float-right"
              id="ic-sort-desc-category"></i>
          </div>
          <ul class="collapse" id="categoryList">
            <template id="category-row">
              <li class="li-category" id="">
                <p class="d-inline category-name"></p>
                <div class="float-right d-none">
                  <i class="fa fa-fw fa-check d-inline"></i>
                </div>
              </li>
            </template>
          </ul>
          <input type="hidden" name="category" id="categoryWrapper" value="">
        </div>

        <div class="filter-wrapper"> {{-- Filter bahasa --}}
          <div 
            class="collapse-header" 
            id="languageListCollapseHeader"
            data-toggle="collapse" 
            data-target="#languageList" 
            aria-expanded="false" 
            aria-controls="languageList">
            <p class="d-inline">Bahasa</p>
            <i 
              class="fa fa-fw fa-sort-desc d-inline float-right"
              id="ic-sort-desc-language"></i>
          </div>
          <ul class="collapse" id="languageList">
            <template id="language-row">
              <li class="li-language" id="">
                <p class="d-inline language-name"></p>
                <div class="float-right d-none">
                  <i class="fa fa-fw fa-check d-inline"></i>
                </div>
              </li>
            </template>
          </ul>
          <input type="hidden" name="category" id="languageWrapper" value="">
        </div>
        
      </div>
      <div class="col-10" id="col-book">
        <h3 class="ml-4 text-info-book-not-found">Maaf, buku tidak ditemukan</h3>
        <p class="ml-4 text-info-book-not-found">Cek lagi kata pencarianmu</p>
        <template id="productRow">
          <div 
            class="row card-book"
            rating="4.5"
            id="book">
            <div class="col-2">
              <img 
                src="{{ url('image/book_placeholder.png') }}" 
                alt=""
                class="ebook-image"
                book-id="id">
            </div>
            <div class="col-10">
              <h4
                class="book-title"
                book-id="">Judul Buku</h4>
              <p
                class="font-weight-bold author-info"><span>Ditulis oleh </span><span class="author-text">Nama penulis</span></p>
              <p
                class="synopsis">I'm baby tacos authentic letterpress, beard hella direct trade cronut trust fund tousled bitters venmo tote bag raw denim. Forage before they sold out migas banh mi echo park, scenester prism. Pickled keytar iceland, asymmetrical pork belly disrupt pop-up farm-to-table food truck marfa raclette austin slow-carb woke. Health goth art party roof party yr disrupt pitchfork kickstarter VHS affogato hell of poutine XOXO flannel. Health goth austin gluten-free put a bird on it cronut bespoke.</p>
              <div class="book-rating-container">
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
                <p class="d-inline mt-1"><span class="rating">4.5</span> &emsp; (<span class="ratingCount">25</span> Ulasan) &emsp; <span class="soldCount">100</span>x terjual</p>
              </div>
              <p 
                class="price font-weight-bold d-inline">Rp. <span class="price">154.000</span></p>
            </div>
          </div>
        </template>
      </div>
    </div>
  </div>
@endsection

@push('add-on-script')
  <script 
    type="text/javascript"
    src= "{{ url('js/view/buyer/search.js') }}">
  </script>
@endpush