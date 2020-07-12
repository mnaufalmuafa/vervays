@extends('layouts.app')

@push('add-on-style')
  <link 
    rel="stylesheet" 
    href="{{ url('css/buyer/info_order.css') }}">
@endpush

@section('title')
  Pesanan
@endsection

@section('content')
  <div class="container-fluid">
		<section id="first-section" class="mb-3">
			<div class="d-flex">
				<div class="left-row">
					<p>Nomor Transaksi&emsp;</p>
					<p>Tanggal Pemesanan&emsp;</p>
					<p>Status&emsp;</p>
					<p>Total Harga&emsp;</p>
					<p>Metode Pembayaran&emsp;</p>
					<p>No Virtual Account&emsp;</p>
				</div>
				<div class="middle-row">
					<p>:</p>
					<p>:</p>
					<p>:</p>
					<p>:</p>
					<p>:</p>
					<p>:</p>
				</div>
				<div class="right-row pl-3">
					<p>1241241</p>
					<p>26 Mei 2020</p>
					<p>Menunggu Pembayaran</p>
					<p>Rp. 156.000</p>
					<p>BNI Virtual Account</p>
					<p>3535252</p>
				</div>
			</div>
		</section>
		<section id="second-section">
			<h4 class="font-weight-bold">Daftar Buku</h4>
			<div class="book-item book-item-container">
				<div class="row mt-3 justify-content-between">
					<div class="col-2">
						<img 
							src="{{ url('/image/book_placeholder.png') }}" 
							alt="book cover" 
							class="book-cover">
					</div>
					<div class="col-10">
						<h5 class="title font-weight-bold">Judul Buku</h5>
						<p class="author-info">Ditulis oleh <span>Nama Penulis</span></p>
						<p class="publisher">Penerbit</p>
						<h5 class="float-right mt-5 price font-weight-bold">Rp. <span>34.000</span></h5>
					</div>
				</div>
				<hr>
			</div>
			<div class="book-item book-item-container">
				<div class="row mt-3 justify-content-between">
					<div class="col-2">
						<img 
							src="{{ url('/image/book_placeholder.png') }}" 
							alt="book cover" 
							class="book-cover">
					</div>
					<div class="col-10">
						<h5 class="title font-weight-bold">Judul Buku</h5>
						<p class="author-info">Ditulis oleh <span>Nama Penulis</span></p>
						<p class="publisher">Penerbit</p>
						<h5 class="float-right mt-5 price font-weight-bold">Rp. <span>34.000</span></h5>
					</div>
				</div>
				<hr>
			</div>
		</section>
		<section class="third-section">
			<h4 class="font-weight-bold mb-2">Cara Bayar</h4>
			<h6 class="font-weight-bold">Melalui ATM</h6>
			<ol>
				<li>Efficiently unleash cross-media information without cross-media value. Quickly maximize timely deliverables</li>
				<li>Efficiently unleash cross-media information without cross-media value. Quickly maximize timely deliverables</li>
				<li>Efficiently unleash cross-media information without cross-media value. Quickly maximize timely deliverables</li>
			</ol>
			<h6 class="font-weight-bold">Melalui ATM</h6>
			<ol>
				<li>Efficiently unleash cross-media information without cross-media value. Quickly maximize timely deliverables</li>
				<li>Efficiently unleash cross-media information without cross-media value. Quickly maximize timely deliverables</li>
				<li>Efficiently unleash cross-media information without cross-media value. Quickly maximize timely deliverables</li>
			</ol>
		</section>
  </div>
@endsection

@push('add-on-script')
  {{-- <script src="{{ url('js/view/buyer/cart.js') }}"></script> --}}
@endpush