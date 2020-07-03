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
  <div class="main-section container-fluid">
    <h2 class="font-weight-bold mt-2">Wishlist</h2>
    <template id="bookTemplate">
      <div 
        class="row card-book"
        rating="4.5"
        id="book">
        <div class="col-2">
          <img 
            src="{{ url('image/book_placeholder.png') }}" 
            alt=""
            class="ebook-image"
            data-book-id=""
            data-book-title="">
        </div>
        <div class="col-10">
          <h4
            class="book-title"
            data-book-id=""
            data-book-title="">Judul Buku</h4>
          <p
            class="font-weight-bold author-info"><span>Ditulis oleh </span><span class="author-text">Nama penulis</span></p>
          <p
            class="synopsis">I'm baby tacos authentic letterpress, beard hella direct trade cronut trust fund tousled bitters venmo tote bag raw denim. Forage before they sold out migas banh mi echo park, scenester prism. Pickled keytar iceland, asymmetrical pork belly disrupt pop-up farm-to-table food truck marfa raclette austin slow-carb woke. Health goth art party roof party yr disrupt pitchfork kickstarter VHS affogato hell of poutine XOXO flannel. Health goth austin gluten-free put a bird on it cronut bespoke.</p>
          <div class="book-rating-container mb-3">
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
            <p class="d-inline-block mt-3"><span class="rating">4.5</span> &emsp; (<span class="ratingCount">25</span> Ulasan) &emsp; <span class="soldCount">100</span>x terjual</p>
          </div>
          <p class="price font-weight-bold d-inline">Rp. <span class="price">154.000</span></p>
          <img 
            src="{{ url('/image/ic_trash.png') }}" 
            alt="ic_trash"
            class="d-inline float-right ic-trash mt-1">
          <button class="float-right btn-buy mr-3">Beli</button>
        </div>
      </div>
    </template>
  </div>

@endsection

@push('add-on-script')
  <script src="{{ url('js/view/buyer/wishlist.js') }}"></script>
@endpush