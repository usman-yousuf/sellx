@extends('noauthapp')

@section('content')
    <!-- After NavBar Block One Start -->
    <div class="for_overflow">
      <div class="row for_row_slider_responsive">
        <div class="col-lg-6 col-md-6 order-2 order-sm-1 order-lg-1 order-md-1 for_slider_res">
          <div class="for_bg_slider_css">
                    <div
                    id="carouselExampleIndicators"
                    class="carousel slide"
                    data-ride="carousel"
                    >
                            <ol class="carousel-indicators">
                                <li
                                    data-target="#carouselExampleIndicators"
                                    data-slide-to="0"
                                    class="active"
                                ></li>
                                <li
                                    data-target="#carouselExampleIndicators"
                                    data-slide-to="1"
                                ></li>
                                <li
                                    data-target="#carouselExampleIndicators"
                                    data-slide-to="2"
                                ></li>
                                <li
                                    data-target="#carouselExampleIndicators"
                                    data-slide-to="3"
                                ></li>
                            </ol>
                            <div class="carousel-inner">
                                <div class="carousel-item active">
                                    <img 
                                    src="{{asset('assets/images/Iphonee.jpg')}}"
                                    align="middle"
                                    class="d-block w-100"
                                    alt="..."
                                    style="object-fit:contain;" 
                                    />
                                </div>
                                <div class="carousel-item">
                                    <img
                                    src="{{asset('assets/images/Iphonee.jpg')}}"
                                    align="middle"
                                    class="d-block w-100"
                                    alt="..."
                                    style="object-fit:contain;"
                                    />
                                </div>
                                <div class="carousel-item">
                                    <img
                                    src="{{asset('assets/images/Iphonee.jpg')}}"
                                    class="d-block w-100"
                                    alt="..."
                                    style="object-fit:contain;"
                                    />
                                </div>
                                <div class="carousel-item">
                                    <img
                                    src="{{asset('assets/images/Iphonee.jpg')}}"
                                    align="middle"
                                    class="d-block w-100"
                                    alt="..."
                                    style="object-fit:contain;"
                                    />
                                </div>
                    </div>       </div>

          </div>
         
        </div>

        <div
          class="
            col-lg-6 col-md-6
            for_secoond_col_bg
            order-1 order-lg-2 order-md-1 order-sm-0
          "
        >
          <div class="for_second_col">
            <h2> {{ __('Sellx is a live auction platform') }}</h2>

            <p class="for_p_text_the_platform">
              {{ __('An online Platform that connects auction houses & bidders and bring them in one place') }}
            </p>

            <div class="for_btn_download">
              <button type="button" class="btn btn-outline-primary">
                <span>
                  <i class="fa fa-apple" aria-hidden="true"></i>

                  <p>
                    Coming Soon on 
                    <br />
                    <strong style="font-weight:bold;font-size: 150%">App Store</strong>
                  </p>
                </span>
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- After NavBar Block One End -->

    <!-- After NavBar Block Two Start -->
    <div class="for_overflow">
      <div class="container for_block_two_main">
        <div class="row">
          <div
            class="
              col-lg-3 col-md-6
              order-md-1 order-lg-0
              for_common_img_res for_first_img_res
            "
          >
            <img
              src="{{asset('assets/images/Illustration1.svg')}}"
              class="img-fluid"
              alt=""
            />
          </div>
          <div class="col-lg-3 col-md-6 for_sellex_text order-md-2 order-lg-1">
            <h4>{{ __('Sellx is a live auction platform') }}</h4>
            <p>
              {{ __('Sellx is an online live auction platform that connects auction houses & bidders in a more efficient, interactive and secure way') }}
            </p>
          </div>

          <div class="col-lg-3 col-md-6 order-md-1 for_common_img_res">
            <img src="{{asset('assets/images/Illustration2.svg')}}" class="img-fluid" />
          </div>

          <div class="col-lg-3 col-md-6 for_sellex_textt order-md-2">
            <h4>{{ __('Be part of the competition') }}</h4>
            <p>
              {{ __('Attend the live auctions to place bids & win lots, or enjoy watching the competion') }}
            </p>
          </div>
        </div>

        <!-- Block Two Child One Start -->
        <div class="row for_blocktw_childone_main">
          <div
            class="col-lg-3 col-md-6 order-md-1 order-lg-0 for_common_img_res"
          >
            <img
              src="{{asset('assets/images/Illustration3.svg')}}"
              class="img-fluid"
              alt=""
            />
          </div>
          <div class="col-lg-3 col-md-6 for_sellex_text order-md-2 order-lg-1">
            <h4>{{ __('Discover & find your interesting lots') }}</h4>
            <p>
              {{ __('Discover & win your favorite lots of watches, jewelries to cars, properties and much more') }}
            </p>
          </div>

          <div class="col-lg-3 col-md-6 order-md-1 for_common_img_res">
            <img src="{{asset('assets/images/Illustration5.svg')}}" class="img-fluid" />
          </div>

          <div class="col-lg-3 col-md-6 for_sellex_textt md_register_responsive order-md-2">
            <h4>{{ __('All you need to become a professional auction house') }}</h4>
            <p>
             {{ __('Register your auction house today and use all the tools to sell more in an easy and reliable way') }}
            </p>
          </div>
        </div>
        <!-- Block Two Child One End -->
      </div>
    </div>

    <!-- After NavBar Block Two End -->

    <!-- After NavBar Block Three Start -->
    <div for_overflow>
      <div class="container for_block_three_bg">
        <h3>{{ __('Stay updated!') }}</h3>
        <p>{{ __('Subscribe to keep abreast of all updates and news') }}</p>
        <div class="row">
          <div class="col-lg-9 col-md-9">
            <form class="for_common_input">
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text img_index_height">
                    <!-- <i class="fa fa-envelope-o" aria-hidden="true"></i> -->
                    <img src="{{asset('assets/images/Mail1.svg')}}" class="img-fluid" />

                  </span>
                </div>
                <input
                  type="text"
                  class="form-control for_input_css"
                  placeholder="Your Email ..."
                  name="subscribe"
                  id="subscribe-d"
                />
              </div>
            </form>
          </div>
          <div class="col-lg-3 col-md-3">
            <div class="for_common_input">
              <button type="button" class="btn shadow bg-body rounded btn-email">
                Submit
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
    <br />
    <br />
    <!-- After NavBar Block Three End -->

    <script type="text/javascript">

      $(".btn-email").click(function(event){
        event.preventDefault();

        let email = $("input[name=subscribe]").val();

        $.ajax({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          url: '{{route('subscribe')}}',
          type:"POST",
          data:{
            e_mail:email,
          },
          success:function(response){
            if(response) {
              if(response.status == true){
                Swal.fire({
                  icon:'success',
                  showConfirmButton: false,
                  timer: 3000,
                  allowOutsideClick: false,
                  allowEscapeKey: false,
                  allowEnterKey: false,
                  text:'Subscribed Successfully.',
                  footer:'Thanks for Subscribing.',
                }).then((result) => {
                  $('#subscribe-d').val('');
                });
              }else{
                swal.fire({
                  title: "Error!",
                  icon: "error",
                  confirmButtonColor: "#49AAEF",
                  confirmButtonText: 'Ok!',
                  footer:'The email feild is required.',
                });
              }
            }
          },
          error: function(xhr) {
            console.log(xhr);
          },
          complete: function() {
            console.log('Completed');
          },
        });
      });
  </script>

@endsection
