@extends('noauthapp')

@section('content')

<style type="text/css">
     .activelabel {
        background-color: white !important;
        color: #6dbbf2 !important;
    }
</style>

<!-- After NavBar ContactUs Block One  Start -->
<div class="for_overflow">
    <div class="container">
        <div class="row for_about_main_row">
            <div class="col-lg-3 col-md-4 col-sm-12 for_col_afterr right_border order-lg-1 order-md-1 order-2">
                <a href="{{ route('termsandcondition') }}">{{ __('Terms and Conditions') }}</a>
                <br>
                <a href="{{ route('privacypolicy') }}">{{ __('Privacy & Data Policy')}}</a>
                <br>
                {{-- <a href="{{ route('refundandcancelation') }}">{{ __('Refunds and Cancellations') }}</a>
                <br>
                <a href="{{ route('servicedeliverypolicy') }}">{{ __('Service Delivery Policy')}}</a>
                <br>
                <a href="{{ route('servicepricing') }}">{{ __('Service Pricing') }}</a>
                <br>
                <a href="{{ route('termsandcondition') }}" class="">{{ __('Partners Terms')}}</a> --}}
                {{-- <a href="#">{{ __('Comming Soon') }}</a>
                <br>
                <a href="#">{{ __('Comming Soon')}}</a>
                <br>
                <a href="#">{{ __('Comming Soon') }}</a>
                <br>
                <a href="#">{{ __('Comming Soon')}}</a>
                <br>
                <a href="#">{{ __('Comming Soon') }}</a>
                <br>
                <a href="#">{{ __('Comming Soon') }}</a> --}}
                <br>
                <hr class="for_partners_bottom">


                <div>

                  <a href="{{route('contact')}}" class="">{{ __('Contact us') }}</a>
                  <br>
                  
                    {{-- <a href="{{route('contact')}}" class="">{{ __('Comming Soon') }}</a>
                    <br>
                    <a href="{{route('about')}}" class="">{{ __('Comming Soon') }}</a> --}}


                </div>


            </div>
            <div class="col-lg-9 col-md-8 col-sm-12 order-lg-2 order-md-2 order-1">
                 <h1>Contact Us</h1>
                <div class="row for_row_main">
                    <div class="col-lg-6 col-md-12 for_border_bottom">
                        <div class="for_first_col_main ">
                            <h3>Contact Information</h3>

                        </div>
                        <hr>

                        <div class="row for_border_bottom">
                            <div class="col-lg-5 col-md-5 for_child_row_col_one">
                                <p>Get in touch:</p>
                            </div>

                            <div class="col-lg-7 col-md-7 for_child_row_col_two">
                                <p>
                                    <!-- <i class="fa fa-envelope-o" aria-hidden="true"></i> -->
                                    <img src="{{asset('assets/images/Mail.svg')}}" />
                                    <span>info@sellx.ae</span>
                                </p>
                            </div>
                        </div>
                        <hr>
                        <div class="row for_border_bottom">
                          <div class="col-lg-5 col-md-5 for_child_row_col_one">
                              <p>Support:</p>
                          </div>

                          <div class="col-lg-7 col-md-7 for_child_row_col_two">
                              <p>
                                  <!-- <i class="fa fa-life-ring" aria-hidden="true"></i> -->
                                  <img src="{{asset('assets/images/Support.svg')}}" />
                                  <span>help@sellx.ae</span>
                              </p>
                          </div>
                        </div>

                      <hr>
                      <div class="row for_border_bottom">
                        <div class="col-lg-5 col-md-5 for_child_row_col_one">
                            <p>Phone: (What'sApp)</p>
                        </div>

                        <div class="col-lg-7 col-md-7 for_child_row_col_two">
                            <p>
                                <!-- <i class="fa fa-phone" aria-hidden="true"></i> -->
                                <img src="{{asset('assets/images/Phone.svg')}}" />
                                <span>+971 50 4777055</span>
                            </p>
                        </div>
                      </div>

                      <hr>
                      <div class="row for_border_bottom">
                        <div class="col-lg-5 col-md-5 for_child_row_col_one">
                            <p>Mailing address:</p>
                        </div>

                        <div class="col-lg-7 col-md-7 for_child_row_col_two for_location_special">
                            <p>
                                <img src="{{asset('assets/images/Location.svg')}}" />
                                <span>Hamdan Incubator<br>
                                  <span class="for_dubai_text_common">
                                    Dubai, UAE,
                                  </span> <br>
                                  <span class="for_dubai_text_common">
                                  </span>

                                </span>
                            </p>
                        </div>
                      </div>
                      <hr>
                    </div>
                    <div class="col-lg-6 col-md-12   ">
                        <div class="for_first_col_main row_one_col_two_main ">
                          <form id="basic-form" method="post" enctype="multipart/form-data">
                            <h3>Contact Form</h3>
                            <div class="sm-res_buttons">

                              <div class="for_col_two_bg">
                                <div class="pt-3 text-center">

                                    <div class="btn-group for_button_group pt-3 sub_cards-d" role="group" aria-label="Basic outlined example">

                                      <label class="btn border type shadow bg-white fg_primary-s sub_plans-d bidder_position_css" data-plan="bidder">
                                          <input type="radio" class="form-check-input valid" value="bidder" name="type" style="display:none" id="rb_type-d" aria-invalid="false">
                                          <span class="for_bidder_span">
                                            Bidder
                                          </span>
                                      </label>
                                      <label class="btn type border shadow bg-white fg_primary-s auctioneer_position_css sub_plans-d" data-plan="auctioneer">
                                          <input type="radio" class="form-check-input valid" value="auctioneer" name="type" style="display:none" id="rb_type-d" aria-invalid="false">
                                          <span class="auctioneer_span_css">
                                            Auctioneer
                                            </span>
                                      </label>
                                      <label class="btn type border shadow bg-white fg_primary-s sub_plans-d other_position_css" data-plan="other">
                                          <input type="radio" class="form-check-input valid" value="other" name="type" style="display:none" id="rb_type-d" aria-invalid="false">
                                           <span class="other_span_css">
                                            Other
                                           </span>
                                      </label>
                                  </div>

                                    <div class="text-center">

                                        <div class="input-group mb-3 for_input_fields">
                                            <div class="input-group-prepend">
                                              <span class="input-group-text">
                                              <img src="{{asset('assets/images/User.svg')}}" class="img-fluid" />

                                              </span>
                                            </div>
                                            <input type="text" class="form-control for_input_css" placeholder="Your name" name="name">
                                        </div>


                                        <div class="input-group mb-3 for_input_fields">
                                            <div class="input-group-prepend">
                                              <span class="input-group-text">
                                                <img src="{{asset('assets/images/Mail1.svg')}}" class="img-fluid" />

                                              </span>
                                            </div>
                                            <input type="text" class="form-control for_input_css" placeholder="Your email" name="email">
                                        </div>



                                        <div class="form-group for_comments_css pt-2">
                                          <textarea class="form-control comment_css for_input_css" rows="2" id="message" name="message" placeholder="Enter Your Message" ></textarea>
                                        </div>

                                        <div>
                                          <button type="button" class="btn btn_send mt-3" onClick="myFunction()">Send</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                          </div>
                          </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

  <script type="text/javascript">

      $('.sub_cards-d').on('click', '.sub_plans-d', function(e) {
          let elm = $(this);
          let planName = $(this).attr('data-plan');
          $('.sub_plans-d').removeClass('activelabel');
          $(elm).addClass('activelabel');
      });

      function myFunction() {
          var registerForm = $("#basic-form");
          var formData = registerForm.serialize();

          console.log(formData);

          // $('#userType-error').html("");
          // $('#name-error').html("");
          // $('#email-error').html("");
          // $('#message-error').html("");


          $.ajax({
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              },
              url: '{{route('contact-us')}}',
              type: 'POST',
              data: formData,

              success: function(data) {
                  if (data.errors) {
                      if (data.errors.type) {
                        swal.fire({
                          title: "Error!",
                          icon: "error",
                          confirmButtonColor: "#49AAEF",
                          confirmButtonText: 'Ok!',
                          footer:data.errors.type,
                        });
                        // $('#userType-error').html(data.errors.type[0]);
                      }
                      if (data.errors.name){
                        swal.fire({
                          title: "Error!",
                          icon: "error",
                          confirmButtonColor: "#49AAEF",
                          confirmButtonText: 'Ok!',
                          footer:data.errors.name,
                        });
                        // $('#name-error').html(data.errors.name[0]);
                      }
                      if (data.errors.email){
                        swal.fire({
                          title: "Error!",
                          icon: "error",
                          confirmButtonColor: "#49AAEF",
                          confirmButtonText: 'Ok!',
                          footer:data.errors.email,
                        });
                        // $('#email-error').html(data.errors.email[0]);
                      }
                      if (data.errors.message) {
                        swal.fire({
                          title: "Error!",
                          icon: "error",
                          confirmButtonColor: "#49AAEF",
                          confirmButtonText: 'Ok!',
                          footer:data.errors.message,
                        });
                        // $('#userType-error').html(data.errors.message[0]);
                      }
                  }

                  if (data.success) {
                      // $('#show_message').removeClass('notin');
                      // setInterval(function() {
                      //     $('#show_message').addClass('notin');
                      // }, 3000);

                      Swal.fire({
                        icon:'success',
                        showConfirmButton: false,
                        timer: 3000,
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        allowEnterKey: false,
                        text:'Query Successfully Sent.',
                        footer:'Thanks for Contacting Us.',
                      }).then((result) => {
                        // $('#basic-form').reset();
                        document.getElementById("basic-form").reset()
                      });

                      // document.getElementById("basic-form").reset();
                  }
              },
          });
      }

  </script>

@endsection
