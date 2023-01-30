<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta name="description" content="" />
  <meta name="author" content="" />
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <!-- Favicon icon -->
  <link
    rel="icon"
    type="image/png"
    sizes="16x16"
    href="/images/favicon.png"
  />
  <title>Admin Panel</title>

	<!-- CSS -->
  <link rel="stylesheet" type="text/css" href="{{ asset('bundle/css/app.css') }}">
  <link href="{{ asset('css/my-style.css') }}" rel="stylesheet" />

  @yield('styles')
</head>