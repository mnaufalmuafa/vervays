@extends('layouts.app')

@push('add-on-style')
  <link 
    rel="stylesheet" 
    href="{{ url('css/buyer/cart.css') }}">
@endpush

@section('title')
  Keranjang Belanja
@endsection

@section('content')
  <div class="container-fluid exception-container d-none">
    <h2 class="text-center mt-5">Wah, keranjang belanjamu masih kosong</h2>
    <h4 class="text-center">Yuk, isi keranjang belanjamu</h4>
    <div class="button-container w-100 d-flex justify-content-center pt-2">
      <button class="btn btn-danger" id="btnSearchBook">Cari buku</button>
    </div>
  </div>
  <div class="container-fluid main-container d-none">
    <div class="row">
      <div class="col-xl-8 col-lg-8 col-md-12 col-sm-12 col-xs-12" id="bookContainer">
        <template id = "bookTemplate">
          <div class="book-item mt-2" data-book-id="" data-price="">
            <div class="row">
              <div class="col-2">
                <img 
                  src="{{ url('image/book_placeholder.png') }}" 
                  alt=""
                  class="book-cover"
                  data-book-id="">
              </div>
              <div class="col-10">
                <h4 class="font-weight-bold book-title" data-book-id="">Judul Buku</h4>
                <p class="authorInfo mb-0">Ditulis oleh <span>Nama penulis</span></p>
                <p class="publisherDetail mt-1 mb-0">Nama penerbit</p>
                <div class="row justify-content-between mt-4">
                  <div class="col-4">
                    <p class="price d-inline">Rp. <span>34.000</span></p>
                  </div>
                  <div class="col-4">
                    <img 
                      src="{{ url('/image/ic_trash.png') }}" 
                      alt="Trash Icon"
                      class="ic-trash d-inline mr-3"
                      data-book-id="">
                  </div>
                </div>
              </div>
            </div> {{-- end row --}}
            <hr>
          </div>
        </template>
      </div>
      <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-xs-12">
        <div class="card px-2 py-2">
          <div class="card-first-section row pr-3">
            <p class="d-inline col">Total harga</p>
            <p class="d-inline text-right col" id="total-amount">Rp <span>156.000</span></p>
          </div>
          <hr>
          <div class="card-second-section">
            <p>Pilih metode pembayaran</p>
            <form 
              id="orderForm"
              action=""
              class="pl-2 pb-2">
              <input type="radio" name="paymentMethod" id="BNIOption" value="1" required>
              <label for="BNIOption">BNI Virtual Account (Bisa ditansfer dari semua bank)</label><br>
              <input type="radio" name="paymentMethod" id="IndomaretOption" value="2">
              <label for="IndomaretOption">Indomaret</label><br>
              <button class="btn btn-danger w-100 mt-2" type="submit" id="btnMakeOrder">Buat Pesanan</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

@push('add-on-script')
  <script src="{{ url('js/view/buyer/cart.js') }}"></script>
@endpush