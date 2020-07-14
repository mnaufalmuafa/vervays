@extends('layouts.app')

@push('add-on-meta')
	<meta name="userId" content="{{ $user->id }}">
	<meta name="userGender" content="{{ $user->gender ?? "null" }}">
@endpush

@push('add-on-style')
  <link 
    rel="stylesheet" 
    href="{{ url('css/buyer/account_setting.css') }}">
@endpush

@section('title')
  Pengaturan Akun
@endsection

@section('content')
	<div class="container-fluid">
		<section class="first-section">
			<div class="row mt-3">
				<div class="col-2 d-flex justify-content-center">
					<img 
						src="{{ url('/image/navbar/ic_account.png') }}" 
						alt="Profile Photos"
						id="profile-photos">
				</div>
				<div class="col-10">
					<p class="user-name font-weight-bold">{{ $user->name }}</p>
					<p class="user-email">{{ $user->email }}</p>
				</div>
			</div> {{-- end row --}}
			<hr>
		</section>
		<section class="second-section">
			<form id="changeProfileForm" class="mb-2">
				<h3 class="font-weight-bold">Ubah Profil</h3>
				<div class="form-row">
					<div class="form-group col-md-6">
						<label for="inputFirstName">Nama depan</label>
						<input 
							type="text" 
							name="firstName" 
							id="inputFirstName" 
							class="form-control" 
							required 
							value="{{ $user->firstName }}">
						<small id="errorFirstName" class="d-none">error nama depan</small>
					</div>
					<div class="form-group col-md-6">
						<label for="inputLastName">Nama belakang (opsional)</label>
						<input 
							type="text" 
							name="lastName" 
							id="inputLastName"
							value="{{ $user->lastName }}"
							class="form-control">
						<small id="errorLastName" class="d-none">error nama belakang</small>
					</div>
				</div>
				<div class="form-group">
					<label for="inputBirthDay">Tanggal Lahir (opsional)</label>
					<input 
						type="date" 
						class="form-control" 
						max="{{ $currentDate }}" 
						id="inputBirthDay" 
						name="birthDay"
						value="{{ $user->birthDay }}">
					<small id="errorBirthDay" class="d-none">error tanggal lahir</small>
				</div>
				<div class="form-group">
					<label for="inputPhoneNumber">No HP (opsional)</label>
					<input 
						type="tel" 
						class="form-control" 
						id="inputPhoneNumber" 
						name="phoneNumber"
						maxlength="12"
						minlength="10"
						pattern="[0]{1}[8]{1}[0-9]{8,10}"
						value="{{ $user->phoneNumber ?? "" }}"
						placeholder="08xxxxxxxxxx">
					<small id="errorPhoneNumber" class="d-none">error NoHP</small>
				</div>
				<label for="">Jenis Kelamin (opsional)</label> <br>
				<div class="form-check form-check-inline">
					<input class="form-check-input" type="radio" name="gender" id="inputRadioLK" value="male">
					<label class="form-check-label" for="inputRadioLK">Laki-laki</label>
				</div>
				<div class="form-check form-check-inline">
					<input class="form-check-input" type="radio" name="gender" id="inputRadioPR" value="female">
					<label class="form-check-label" for="inputRadioPR">Perempuan</label>
				</div>
				<div class="form-check form-check-inline">
					<small id="errorGender" class="d-none">error Jenis Kelamin</small>
				</div>
				<div class="btn-container d-flex flex-row-reverse">
					<button type="submit" class="btn btn-danger">Ubah Profil</button>
				</div>
			</form>
			<hr>
		</section>
		<section class="third-section">
			<form id="changePasswordForm">
				<h3 class="font-weight-bold">Ubah Password</h3>
				<div class="form-group row">
					<label for="inputOldPassword" class="col-sm-2 col-form-label">Password Lama</label>
					<div class="col-sm-10">
						<input type="password" class="form-control" id="inputOldPassword" required>
						<small id="errorOldPassword" class="d-none">error Old Password</small>
					</div>
				</div>
				<div class="form-group row">
					<label for="inputNewPassword" class="col-sm-2 col-form-label">Password Baru</label>
					<div class="col-sm-10">
						<input type="password" class="form-control" id="inputNewPassword" required>
						<small id="errorNewPassword" class="d-none">error New Password</small>
					</div>
				</div>
				<div class="form-group row">
					<label for="inputRetypeNewPassword" class="col-sm-2 col-form-label">Ulangi Password Baru</label>
					<div class="col-sm-10">
						<input type="password" class="form-control" id="inputRetypeNewPassword" required>
						<small id="errorRetypeNewPassword" class="d-none">error Retype New Password</small>
					</div>
				</div>
				<div class="btn-container d-flex flex-row-reverse">
					<button type="submit" class="btn btn-danger">Ubah Password</button>
				</div>
			</form>
			<hr>
		</section>
		<section class="fourth-section">
			<h3 class="font-weight-bold">Hapus Akun</h3>
			<div class="d-flex justify-content-between">
				<p>Ingin menghapus akun Heav mu?</p>
				<p id="deleteAccount">Hapus Akun</p>
			</div>
		</section>
	</div>
@endsection

@push('add-on-script')
  <script src="{{ url('js/view/buyer/account_setting.js') }}" type="text/javascript"></script>
@endpush