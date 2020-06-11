@extends('layouts.publishers')

@push('add-on-style')
  <link rel="stylesheet" href="{{ url('css/publisher/edit.css') }}">
@endpush

@section('title')
  Edit Data Publisher
@endsection

@section('content')
  @if($errors->any())
    @foreach ($errors->all() as $error)
      {{ $error }}
    @endforeach
  @endif
  <div class="container-fluid">
    <h3 class="font-weight-bold mt-3">Tambah Buku</h3>
    <form
      action=""
      method=""
      enctype="multipart/form-data">
      @csrf
      <div class="form-group row"> {{-- Judul --}}
        <label for="inputJudul" class="col-sm-2 col-form-label">Judul</label>
        <div class="col-sm-10">
          <input 
            type="text"
            class="form-control"
            id="inputJudul"
            name="title"
            required>
        </div>
      </div>
      <div class="form-group row"> {{-- Penulis --}}
        <label for="inputPenulis" class="col-sm-2 col-form-label">Penulis</label>
        <div class="col-sm-10">
          <input 
            type="text"
            class="form-control"
            id="inputPenulis"
            name="author"
            required>
        </div>
      </div>
      <div class="form-group row"> {{-- Bahasa --}}
        <label for="inputBahasa" class="col-sm-2 col-form-label">Bahasa</label>
        <div class="col-sm-10">
          <select 
            name="languageId" 
            id="inputBahasa"
            class="custom-select"
            required>
            <option value="1">Indonesia</option>
            <option value="2">Inggris</option>
            <option value="3">Jerman</option>
            <option value="4">Korea</option>
          </select>
        </div>
      </div>
      <div class="form-group row"> {{-- Jumlah Halaman --}}
        <label for="inputJumlahHalaman" class="col-sm-2 col-form-label">Jumlah Halaman</label>
        <div class="col-sm-10">
          <input 
            type="number"
            class="form-control"
            id="inputJumlahHalaman"
            name="numberOfPage"
            required>
        </div>
      </div>
      <div class="form-group row"> {{-- Kategori --}}
        <label for="inputCategory" class="col-sm-2 col-form-label">Kategori</label>
        <div class="col-sm-10">
          <select 
            name="languageId" 
            id="inputCategory"
            class="custom-select"
            required>
            <option value="1" selected>Ensiklopedia</option>
            <option value="2">Biografi</option>
            <option value="3">Komik</option>
            <option value="4">Musik</option>
          </select>
        </div>
      </div>
      <div class="form-group row"> {{-- Sinopsis --}}
        <label for="inputSinopsis" class="col-sm-2 col-form-label">Sinopsis</label>
        <div class="col-sm-10">
          <textarea 
            class="form-control" 
            id="inputSinopsis" 
            rows="3"
            name="synopsis"
            ></textarea>
        </div>
      </div>
      <div class="form-group row"> {{-- Harga --}}
        <label for="inputHarga" class="col-sm-2 col-form-label">Harga</label>
        <div class="col-sm-10">
          <input 
            type="number"
            class="form-control"
            min="1"
            id="inputHarga"
            name="price"
            required>
        </div>
      </div>
      <div class="form-group row"> {{-- Harga Diskon --}}
        <label for="inputHargaDiskon" class="col-sm-2 col-form-label">Harga Diskon</label>
        <div class="col-sm-10">
          <input 
            type="number"
            class="form-control"
            min="1"
            id="inputHargaDiskon"
            name="discountPrice">
        </div>
      </div>
      <div class="form-group row"> {{-- File Ebook --}}
        <label for="inputEbookFile" class="col-sm-2 col-form-label">File Ebook</label>
        <div class="col-sm-10">
          <input 
            type="file"
            class="form-control-file"
            id="inputEbookFile"
            name="ebookFile">
        </div>
      </div>
      <div class="form-group row"> {{-- File Sample Ebook --}}
        <label for="inputSampleEbookFile" class="col-sm-2 col-form-label">File Sample Ebook</label>
        <div class="col-sm-10">
          <input 
            type="file"
            class="form-control-file"
            id="inputSampleEbookFile"
            name="sampleEbookFile">
        </div>
      </div>
      <div class="form-group row"> {{-- Foto Cover --}}
        <label for="inputSampleEbookFile" class="col-sm-2 col-form-label">Foto Cover Ebook</label>
        <div class="col-sm-10">
          <input 
            type="file"
            class="form-control-file"
            id="inputSampleEbookFile"
            name="photo">
        </div>
      </div>
      <input {{-- Submit --}}
        type="submit"
        value="Tambah Buku"
        class="float-right button mb-5">
    </form>
  </div>
@endsection

@push('add-on-script')
  
@endpush