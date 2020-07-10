@extends('layouts.app')

@push('add-on-style')
  <link 
    rel="stylesheet" 
    href="{{ url('css/buyer/info_publisher.css') }}">
@endpush

@section('title')
  Nama Publisher
@endsection

@section('content')
  <div class="container-fluid container-data-publisher">
    <div class="row mt-3">
      <div class="col-2">
        <img 
          src="https://picsum.photos/200/300" 
          alt=""
          class="publisher-brand-image">
      </div>
      <div class="col-10">
        <h5 id="publisher-name-info" class="font-weight-bold">Nama publisher</h5>
        <p id="publisher-join-info">Bergabung Mei 2020</p>
        <p id="publisher-desc-info">Lorem ipsum dolor sit amet consectetur adipisicing elit. Distinctio, quo cupiditate repellat possimus quia commodi? Architecto tempora laboriosam laudantium explicabo inventore similique. Corporis, laboriosam autem ea fugit reiciendis sunt iure.</p>
      </div>
    </div>
    <hr>
  </div>
  <div class="container-fluid mt-3">
    <h4 class="d-inline">Ebook</h4>
  </div>
  <template id="card-book-template">
    <div class="container-fluid">
      <div 
        class="row card-book"
        rating="1.0"
        id="book-card-">
        <div class="col-2">
          <img 
            src="{{ url('/image/book_placeholder.png') }}" 
            alt=""
            class="ebook-image"
            book-id="">
        </div>
        <div class="col-10">
          <h4
            class="book-title"
            book-id="">Judul Buku</h4>
          <p
            class="font-weight-bold author-info"><span>Ditulis oleh </span><span class="author-text">Author</span></p>
          <p
            class="synopsis">
              Lorem ipsum dolor sit amet consectetur adipisicing elit. Qui ipsa, sit suscipit ab adipisci consequuntur veniam saepe necessitatibus! Sequi nesciunt voluptatem in molestias fugiat sed beatae voluptatum, aut suscipit odit.
              Lorem ipsum dolor sit amet consectetur, adipisicing elit. Ut vel expedita sequi culpa voluptatum. Sequi modi praesentium totam maxime voluptatem? Quaerat veniam maiores nostrum quibusdam optio? Quaerat laboriosam voluptate sit.
              Lorem ipsum dolor sit amet consectetur adipisicing elit. Eligendi quo, voluptates atque tenetur voluptatem velit dolorem eius, enim iusto, illo natus. Porro, nulla. Amet culpa consectetur dignissimos explicabo sunt iste.
          </p>
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
            <p class="d-inline-block ml-3"><span>2.0</span> &emsp; (<span>25</span> Ulasan) &emsp; <span>1231</span>x terjual</p>
          </div>
          <p 
            class="price font-weight-bold d-inline">Rp. 21.000</p>
        </div>
      </div>
    </div>
  </template>
@endsection

@push('add-on-script')
  {{-- <script 
    type="text/javascript"
    src= "{{ url('js/view/buyer/mybook.js') }}">
  </script> --}}
@endpush