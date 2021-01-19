<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link 
    rel="stylesheet" 
    href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" 
    integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" 
    crossorigin="anonymous">
  <link 
    rel="stylesheet" 
    href="{{ url('css/style.css') }}">
  <link 
    href="https://fonts.googleapis.com/css2?family=Assistant:wght@200;300;400;600;700;800&display=swap" 
    rel="stylesheet">
  <link 
    rel="stylesheet" 
    href="{{ url('css/signup.css') }}">
  <title>Sign Up</title>
</head>
<body>
  <div class="container-custom">
    <div class="row">
      <div class="col-6 left-side" id="left-side">
        <div class="left-side-content w-100">
          <img 
            src="{{ url('image/login/left_side_login_content3.png') }}" 
            alt="left_side_login_content">
        </div>
      </div>
      <div class="col-6 right-side" id="right-side">
        <form action="/signup" method="POST" class="form">
          @csrf
          <h2 class="font-weight-bold">Sign Up</h2>
          <p>Daftar akun agar bisa berbelanja di Vervais</p>
          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="firstName">Nama depan</label>
              <input 
                type="text" 
                class="form-control" 
                id="firstName"
                value="{{ old('firstName') }}"
                name="firstName"
                required>
              @error('firstName')
                <div class="invalidFeedback">
                  Masukkan nama depan anda
                </div>
              @enderror
            </div>
            <div class="form-group col-md-6">
              <label for="lastName">Nama belakang</label>
              <input 
                type="text" 
                class="form-control"
                value="{{ old('lastName') }}"
                name="lastName"
                id="lastName">
            </div>
          </div>
          <div class="form-group">
            <label for="email">Email</label>
            <input
              type="email"
              id="email"
              name="email"
              value="{{ old('email') }}"
              class="form-control"
              required>
            @error('email')
              <div class="invalidFeedback">
                Email sudah terdaftar sebelumnya
              </div>
            @enderror
            @isset($emailErrorMessage)
              <div class="invalidFeedback">
                {{ $emailErrorMessage }}
              </div>
            @endisset
          </div>
          <div class="form-group">
            <label for="email">Password</label>
            <input
              type="password" 
              id="password"
              name="password"
              value="{{ old('password') }}"
              class="form-control"
              minlength="8"
              required>
            @error('password')
              <div class="invalidFeedback">
                Password minimal berisi 8 karakter
              </div>
            @enderror
          </div>
          <button type="submit" class="btn btn-danger">Sign Up</button>
          <p class="mt-5">Sudah punya akun? <a href="/login">Login disini</a></p>
        </form>
      </div>
    </div>
  </div>
  <script 
    src="https://code.jquery.com/jquery-3.5.1.slim.min.js" 
    integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" 
    crossorigin="anonymous">
  </script>
  <script 
    src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" 
    integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" 
    crossorigin="anonymous">
  </script>
  <script 
    src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" 
    integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" 
    crossorigin="anonymous">
  </script>
  <script 
    type="text/javascript"
    src= "{{ url('js/view/signup.js') }}">
  </script>
</body>
</html>