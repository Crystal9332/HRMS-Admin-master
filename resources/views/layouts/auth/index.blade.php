<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="">
  <meta name="author" content="">
  <!-- Favicon icon -->
  <link rel="icon" type="image/png" sizes="16x16" href="/images/favicon.png">
  <title>Admin Panel</title>

  <!-- page css -->
  {{-- <link href="/css/system/login-register-lock.css" rel="stylesheet">
  <!-- Custom CSS -->
  <link href="/css/system/style.min.css" rel="stylesheet"> --}}
  <link href="{{mix('bundle/css/app.css')}}" rel="stylesheet">
</head>

<body>
  <!-- ============================================================== -->
  <!-- Preloader - style you can find in spinners.css -->
  <!-- ============================================================== -->
  <div class="preloader">
    <div class="loader">
      <div class="loader__figure"></div>
      <p class="loader__label">Admin panel</p>
    </div>
  </div>
  <!-- ============================================================== -->
  <!-- Main wrapper - style you can find in pages.scss -->
  <!-- ============================================================== -->
  <section id="wrapper" class="login-register login-sidebar" style="background-image:url(images/background/login-register.jpg);">
    @yield('login')
  </section>
  <!-- ============================================================== -->
  <!-- End Wrapper -->
  <!-- ============================================================== -->
  <!-- ============================================================== -->
  <!-- JS -->
  <script src="{{ mix('bundle/js/app.js') }}"></script>

</body>

</html>