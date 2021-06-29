<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>{{ config('app.name', 'Laravel') }}</title>

  <!-- Scripts -->
  <script src="{{ asset('js/app.js') }}" defer></script>

  <!-- Fonts -->
  <link rel="dns-prefetch" href="//fonts.gstatic.com">
  <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
  <script src = "https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>

  <!-- Styles -->
  <link href="{{ asset('css/app.css') }}" rel="stylesheet">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet"  integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x"  crossorigin="anonymous"/>

  <link  rel="stylesheet"  href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"  integrity="sha512-SfTiTlX6kk+qitfevl/7LibUOeJWlt9rbyDn92a1DqWOw9vWG2MFoays0sgObmWazO5BQPiFucnnEAjpAB+/Sw=="  crossorigin="anonymous"  />

  <link rel="stylesheet" href="{{ asset('assets/css/sellex.css') }}" />
  
</head>
<body>
  <!-- Nav Bar Start -->
  <div class="top_nav">
    <div class="shadow p-3 mb-5 bg-body rounded for_navbar_bg">
      <a href="{{route('home')}}" class="text-decoration-none">
        
      <img
      src="{{asset('assets/images/Layer 1.svg')}}"
      class="img-fluid for_nav_bar_logo"
      />
      <span>Sellx</span>
      </a>
      <div class="pull-right for_aboutus_contact">
          <p>
            <a href="{{route('about')}}">About Us</a>
            <span> <a href="{{route('contact')}}"> Contact Us </a> </span>
          </p>
      </div>
    </div>
  </div>
  <!-- Nav Bar End -->
  



  <main class="py-4">
    @yield('content')
  </main>

  <!-- Footer Start -->
  <div class="for_overflow">
    <div class="for_footer_bg">
      <div class="container for_footer_bottom">
        <div class="row for_footer_row_">
          <div class="col-lg-6 col-md-6 col-sm-12 footer_first_col_main one">
            <p class="fox-text for_terms_and_conditions_p_res">
              <a href="#"> Terms and Conditions <br /></a>
              <span class="fox-text">
                <a href="#">Refunds and Cancellations <br /> </a>
              </span>
              <span class="for_after_footer fox-text">
                <a href="#">Service Pricing <br /> </a>
              </span>
            </p>

            <p class="fox-text for_terms_and_conditions_p_res for_sm_footer_text" >
              <a href="#"> Terms and Conditions <br /></a>
              <span class="fox-text">
                <a href="#">Refunds and Cancellations <br /> </a>
              </span class="fox-text">
              <span class="">
                <a href="#">Service Pricing <br /></a>
              </span>
            </p>
            
          </div>
          <div class="col-lg-6 col-md-6 footer_first_col_main second">
            <p>
              <a href="#"> Contact Us</a>
              
              <span class="pull-right footer_logo"
              ><img src="assets/images/Frame 27.svg" class="img-fluid"
              /></span>
            </p>
            <p>
              <a href="#"> About Us</a>
              
            </p>
          </div>
          <br />
          
        </div>
        
      </div>
      <div class="container">
        <div class="end_footer ">
          <img src="assets/images/Frame 28.svg" class="img-fluid"/><span class="pull-right fox-text for_end_text">
            <br />
            Sellex @ 2021 All rights reserved adssadas
          </span>
        </div>
      </div>
    </div>
    <!-- Footer End -->

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4"
    crossorigin="anonymous"
    ></script>
    <script
    src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
    integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p"
    crossorigin="anonymous"
    ></script>
    <script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.min.js"
    integrity="sha384-Atwg2Pkwv9vp0ygtn1JAojH0nYbwNJLPhwyoVbhoPwBhjQPR5VtM2+xf0Uwh9KtT"
    crossorigin="anonymous"
    ></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  </body>
  </html>