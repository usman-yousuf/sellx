
@extends('noauthapp')

@section('content')
<style type="text/css">
     .notin {
        display: none;
    }
</style>

<!-- After NavBar ContactUs Block One  Start -->
<div class="for_overflow">
    <div class="container">
        <div class="row for_about_main_row">
            <div class="col-lg-3 col-md-4 col-sm-12 for_col_after one order-lg-1 order-md-1 order-2">
                <a href="#">Terms and Conditions</a>
                <br>
                <a href="#">Privacy & Data Policy</a>
                <br>
                <a href="#">Refund & Cancellations</a>
                <br>
                <a href="#">Service Delivery Policy</a>
                <br>
                <a href="#">Service Pricing</a>
                <br>
                <a href="#" class="">Partners Terms</a>
                <hr class="for_partners_bottom">
                <div>
                    
                    <a href="{{route('contact')}}" class="">Contact Us</a>
                    <br>
                    <a href="{{route('about')}}" class="">About Us</a>
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
                                    <i class="fa fa-envelope-o" aria-hidden="true"></i>
                                    <span>info@sellx.com</span>
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
                                  <i class="fa fa-life-ring" aria-hidden="true"></i>
                                  <span>support@sellex.com</span>
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
                                <i class="fa fa-phone" aria-hidden="true"></i>
                                <span>+971 545-5520-39</span>
                            </p>
                        </div>
                      </div>

                      <hr>
                      <div class="row for_border_bottom">
                        <div class="col-lg-5 col-md-5 for_child_row_col_one">
                            <p>Mailining address:</p>
                        </div>

                        <div class="col-lg-7 col-md-7 for_child_row_col_two for_location_special">
                            <p>
                                <i class="fa fa-map-marker" aria-hidden="true"></i>
                                <span>3105 Churchil Tower, Business Bay, Dubai Unitetd arab emirates</span>
                            </p>
                        </div>
                      </div>
                      <hr>
                    </div>
                    <div class="col-lg-6 col-md-12">
                        <div class="for_first_col_main row_one_col_two_main ">
                            <h3 class="text-center text-white">Contact Form</h3>

                            <div class="for_col_two_bg">
                                <div class="text-center">
                                    <div class="btn-group for_button_group p-3" role="group" aria-label="Basic outlined example">
                                        <button type="button" class="btn btn-primary type text-white border" name="type" value="bidder">Bidder</button>
                                        <button type="button" class="btn btn-primary type text-white border" name="type" value="auctioneer">Auctioneer</button>
                                        <button type="button" class="btn btn-primary type text-white border" name="type" value="other">Other</button>
                                    </div>

                                    <div class="text-center">
                                        <!-- <div class="form-group ">
                                            
                                            <i class="fa fa-user-o" aria-hidden="true"></i>

                                            <input type="text"  class="form-control  " id="usr" placeholder="Your name">

                                            
                                            
                                        </div> -->
                                        <div id="show_message" class="alert alert-success notin">
                                            <strong>Message Sent Successfully!</strong>
                                        </div>
                                        <div class="input-group mb-3 for_input_fields">
                                            <div class="input-group-prepend">
                                              <span class="input-group-text">
                                              <i class="fa fa-user-o" aria-hidden="true"></i>

                                              </span>
                                            </div>
                                            <input type="text" class="form-control" placeholder="Your name" name="name">
                                        </div>
                                            <span style="color:red" class="text-danger" id="name-error"></span>
                                            @error('name')
                                                <div class="alert alert-danger">
                                                    <strong>{{ $message }}</strong>
                                                </div>
                                            @enderror


                                        <div class="input-group mb-3 for_input_fields">
                                            <div class="input-group-prepend">
                                              <span class="input-group-text">
                                                <i class="fa fa-envelope-o" aria-hidden="true"></i>

                                              </span>
                                            </div>
                                            <input type="text" class="form-control" placeholder="Your email" name="email">
                                            <br>
                                        </div>
                                            <div style="color:red" class="text-danger" id="email-error"></div>
                                            @error('email')
                                                <div class="alert alert-danger">
                                                    <strong>{{ $message }}</strong>
                                                </div>
                                            @enderror

                                        <div>
                                          <button type="button" class="btn btn_send btn-primary border px-5" onClick="myFunction()">Send</button>
                                        </div>
                                    </div>
                                </div>



                            </div>
                        </div>
                    </div>

                                   
                </div>   

           
               

            </div>

        </div>
        

    </div>

</div>
<!-- After NavBar AboutUs Block One  End -->
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script type="text/javascript">
    
        function myFunction() {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: 'http://localhost/sellx/api/contact_form',
                type: 'POST',
                data: {
                    name:$("input[name=name]").val(),
                    email:$("input[name=email]").val(),
                    type:"bidding",//$("input[name=type]").val()
                },
                success:function(response){
                    if(response) {
                     Swal.fire({
                      icon:'success',
                      text:response.message,
                     })
                 }
                  },
                  error: function (xhr, ajaxOptions, thrownError) {
                    swal(xhr.status);
                    swal(thrownError);
                  }
            });
        }

    </script>
  @endsection