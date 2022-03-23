<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>Sellx is a live auction platform</title>
  <link sizes="10x5" rel="shortcut icon" href="{{asset('public/assets\images\sellx-01.png')}}" rel="icon" type="image/png">
  <!-- <link rel="icon" type="image/png" href="http://localhost/sellx/public/assets/images/favicon.png" sizes="16x16" /> -->
   <!-- <meta name="description" content="Sellx is a live auction platform"> -->
   <!-- <meta name="Keywords" content="Sellx is a live auction platform"> -->

  <!-- Scripts -->
  <script src="{{ asset('public/js/app.js') }}" defer></script>

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
  <link rel="stylesheet" href="{{asset('public/assets/css/sellex.css')}}" />

  <!-- JS Scripts -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
  {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script> --}}
  <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>
<body>

    {{-- test nav bar --}}

    <nav class="navbar navbar-expand-lg navbar-light for_navbar_bg shadow">
        <a href="{{route('home')}}">
                <img
                    src="{{asset('public/assets/images/Layer1.svg')}}"
                    class="img-fluid for_nav_bar_logo"
                />
                <span>Sellx</span>
                </a>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon fs_15px-s"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item text-right mt-2 active mx-lg-4">
                        <a class="scrollto" href="{{route('home')}}#about"> {{ __('About us') }} </a>
                </li>
                <li class="nav-item text-right mt-2 mx-lg-4">
                        <a href="{{route('contact')}}"> {{ __('Contact us') }} </a>
                </li>
                <li class="nav-item text-right mx-lg-4">
                    @php
                        Session::get('locale') == NULL ? session()->put('locale','en') : '';
                    @endphp
                    <span class=" for_button_group" role="group" aria-label="Basic outlined example">
                        <button type="button" class="btn onee mr-6px-s h_40px-s changeLang {{ Session::get('locale') == 'en' ? ' active-btn' : '' }}" id="en">English</button>
                        <button type="button" class="btn twoo h_40px-s changeLang {{ Session::get('locale') == 'ar' ? 'active-btn' : '' }} " id="ar" >Arabic</button>
                    </span>
                </li>
            </ul>

        </div>
    </nav>
    {{-- test nav bar --}}



  <!-- Nav Bar Start -->
    {{-- <div class="top_nav">
      <div class="shadow p-3 bg-body rounded for_navbar_bg">
        <a href="{{route('home')}}">
          <img
            src="{{asset('public/assets/images/Layer1.svg')}}"
            class="img-fluid for_nav_bar_logo"
          />
          <span>Sellx</span>
        </a>

        <div class="pull-right mr-lg-5">



               <div>
                    <span class="mx-4">
                    <span>
                        <a href="{{route('about')}}"> {{ __('About us') }} </a>
                    </span>
                    <span>
                        <a href="{{route('contact')}}"> {{ __('Contact us') }} </a>
                    </span>
                </span> --}}

            <!-- <select class=" changeLang border"> -->
              <!-- <span class="">
                {<span class="m-0 p-0 btn changeLang {{ Config::get('app.locale') == 'en' ? 'bg-primary text-white' : '' }}" id="en">English</span>
                <span class="m-0 p-0 btn changeLang {{ Config::get('app.locale') == 'ar' ? 'bg-primary text-white' : '' }}" id="ar">Arabic</span>
              </span> -->
              <!--
               -->
               {{-- @php
                Session::get('locale') == NULL ? session()->put('locale','en') : '';
               @endphp
              <span class=" for_button_group" role="group" aria-label="Basic outlined example">
                  <button type="button" class="btn onee mr-6px-s h_40px-s changeLang {{ Session::get('locale') == 'en' ? ' active-btn' : '' }}" id="en">English</button>
                  <button type="button" class="btn twoo h_40px-s changeLang {{ Session::get('locale') == 'ar' ? 'active-btn' : '' }} " id="ar" >Arabic</button>
              </span> --}}
            <!-- </select> -->
               {{-- </div> --}}

{{--
        </div>
      </div>
    </div> --}}
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

                    <p class="fox-text for_terms_and_conditions_p_res for_sm_footer_text" >
                      <a href="{{ route('termsandcondition') }}">{{ __('Terms and Conditions') }}<br /></a>
                      {{-- <a href="#">{{ __('Comming Soon') }}<br /></a> --}}
                      <span class="fox-text">
                        <a href="{{ route('termsandcondition') }}">{{ __('Refunds and Cancellations') }} <br /> </a>
                        {{-- <a href="#">{{ __('Comming Soon') }} <br /> </a> --}}
                      </span class="fox-text">
                      <span class="">
                        <a href="{{ route('termsandcondition') }}"> {{ __('Service Pricing') }}  <br /></a>
                        {{-- <a href="#"> {{ __('Comming Soon') }}  <br /></a> --}}
                      </span>
                    </p>

                  </div>
                  <div class="col-lg-6 col-md-6 footer_first_col_main second">
                    <p>
                      <a href="{{route('contact')}}">{{ __('Contact us') }}</a>
                      {{-- <a href="#">{{ __('Comming Soon') }}</a> --}}

                      <span class="pull-right footer_logo"
                        ><img src="{{asset('public/assets/images/Frame27.svg')}}" class="img-fluid"
                      /></span>
                    </p>
                    <p>
                      <a href="{{route('about')}}">{{ __('About us') }}</a>
                      {{-- <a href="#">{{ __('Comming Soon') }}</a> --}}

                    </p>
                  </div>
                  <br />

                </div>

            </div>
            <div class="container">
              <div class="end_footer ">
                <a target="_blank" href="https://www.instagram.com/sellxapp/">
                  <i class="fa fa-instagram fa-3x m-2" aria-hidden="true"></i>
                </a>
                <br>
                <span class = "text-dark">
                  
                <i class="fa fa-cc-stripe fa-3x m-2" aria-hidden="true"></i>
                <i class="fa fa-cc-visa fa-3x m-2" aria-hidden="true"></i>
                <i class="fa fa-cc-mastercard fa-3x m-2" aria-hidden="true"></i>
                </span>
                {{-- <img src="{{asset('public/assets/images/Frame28.svg')}}" class="img-fluid"/> --}}
                <span class="pull-right fox-text for_end_text">
                  <br />
                  Sellx @ {{ now()->year }} All rights reserved
                </span>
              </div>
          </div>
        </div>
          <!-- Footer End -->
  </body>
  </html>
  <script type="text/javascript">

    var url = "{{ route('changeLang') }}";

    $(".changeLang").click(function(){
        // console.log(url + "?lang="+ $(this).val());
        // console.log("$(this).val()", $(this).attr('id'));
        window.location.href = url + "?lang="+ $(this).attr('id');
    });

</script>
