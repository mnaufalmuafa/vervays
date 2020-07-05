<!DOCTYPE html>
<html lang="en">
<head>
  @include('includes.meta')
  @stack('add-on-meta')
  @include('includes.style')
  @stack('add-on-style')
  <title>@yield('title')</title>
</head>
<body>
  @include('includes.publisher.navbar')
  @yield('content')
  @include('includes.script')
  @stack('add-on-script')
</body>
</html>