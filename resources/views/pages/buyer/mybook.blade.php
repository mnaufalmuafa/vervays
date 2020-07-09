@extends('layouts.app')

@push('add-on-style')
  <link 
    rel="stylesheet" 
    href="{{ url('css/buyer/mybook.css') }}">
@endpush

@section('title')
  Buku Saya
@endsection

@section('content')
	<div class="container-fluid exception-container d-none">
		<h2 class="text-center mt-5">Wah, kamu belum punya buku</h2>
		<h4 class="text-center">Yuk, beli buku kesukaanmu</h4>
		<div class="button-container w-100 d-flex justify-content-center pt-2">
			<button class="btn btn-danger" id="btnSearchBook" onclick="window.location.href = '/'">Cari buku</button>
		</div>
	</div>
  <div class="container-fluid main-container d-none">
    <h2 class="mt-2 font-weight-bold">Buku Saya</h2>
    <div class="row">
      <div class="card-book col-2 mb-3" id="book-">
        <div class="card">
          <a href="#">
            <img 
              src="{{ url('image/book_placeholder.png') }}" 
              alt=""
              class="book-cover">
          </a>
          <div class="info-container">
            <a href="#">
              <p class="title mx-1">Judul Buku</p>
            </a>
            <p class="author mx-1">Author</p>
          </div>
          <button class="button mb-1 mx-auto">Baca Buku</button>
          <button class="button mx-auto">Beri Ulasan</button>
        </div>
      </div>
    </div>
  </div>
@endsection

@push('add-on-script')
  <script 
    type="text/javascript"
    src= "{{ url('js/view/buyer/mybook.js') }}">
  </script>
@endpush