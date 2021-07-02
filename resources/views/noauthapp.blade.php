<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>{{ config('app.name', 'Sellx') }}</title>

  <!-- Scripts -->
  <script src="{{ asset('js/app.js') }}" defer></script>

  <!-- Fonts -->
  <link rel="dns-prefetch" href="//fonts.gstatic.com">
  <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
  <script src = "https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>

  <!-- Styles -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous"/>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha512-SfTiTlX6kk+qitfevl/7LibUOeJWlt9rbyDn92a1DqWOw9vWG2MFoays0sgObmWazO5BQPiFucnnEAjpAB+/Sw==" crossorigin="anonymous"/>
  <link rel="stylesheet" href="{{asset('assets/css/sellex.css')}}" />

  <!-- JS Scripts -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>
  <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  
</head>
<body>
  <!-- Nav Bar Start -->
    <div class="top_nav">
      <div class="shadow p-3 mb-5 bg-body rounded for_navbar_bg">
        <a href="{{route('home')}}">
          <img
            src="{{asset('assets/images/Layer1.svg')}}"
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
  



  <main class="">
    @yield('content')
  </main>

  <!-- Footer Start -->
        <div class="for_overflow sm_res_footer">
            <div class="for_footer_bg">
              <div class="container for_footer_bottom ">
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
                        ><img src="{{asset('assets/images/Frame27.svg')}}" class="img-fluid"
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
                <img src="{{asset('assets/images/Frame28.svg')}}" class="img-fluid"/><span class="pull-right fox-text for_end_text">
                  <br />
                  Sellex @ 2021 All rights reserved
                </span>
              </div>
          </div>
          </div>
          <!-- Footer End --> 
  </body>
  </html>