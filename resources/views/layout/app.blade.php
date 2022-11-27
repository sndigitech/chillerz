@include('layout.head_resource')
<body>
  <!-- ======= Header ======= -->
 @include('layout.header')
<!-- End Header -->

  <!-- ======= Sidebar ======= -->
  @include('layout.sidebar')

  <!-- End Sidebar-->

  <main id="main" class="main">   

    @yield('content')

  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
  @include('layout.footer')

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

@include('layout.foot_resource')

</body>

</html>
