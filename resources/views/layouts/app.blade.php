<!DOCTYPE html>
<html lang="en">
<head>
  @include('includes.meta')
  @include('includes.style')
  @stack('add-on-style')
  <title>@yield('title')</title>
</head>
<body>
  @include('includes.navbar')
  <div class="container-custom">
    @yield('content')
  </div>
  @include('includes.script')
  @stack('add-on-script')
</body>
</html>