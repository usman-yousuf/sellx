
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
            <div class="col-lg-3 col-md-4 col-sm-12 for_col_afterr right_border order-lg-1 order-md-1 order-2">
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
                    
                    <a href="#" class="">Contact Us</a>
                    <br>
                    <a href="#" class="">About Us</a>


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
                                    <span>hi@sellex.com</span>
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
                    <div class="col-lg-6 col-md-12   ">
                        <div class="for_first_col_main row_one_col_two_main ">
                            <h3>Contact Form</h3>

                            <div class="for_col_two_bg">
                                <div class="pt-5 text-center">
                                    <div class="btn-group for_button_group" role="group" aria-label="Basic outlined example">
                                        <button type="button" class="btn type" name="type" value="bidder">Bidder</button>
                                        <button type="button" class="btn type" name="type" value="auctioneer">Auctioneer</button>
                                        <button type="button" class="btn type" name="type" value="other">Other</button>
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
                                          <button type="button" class="btn btn_send" onClick="myFunction()">Send</button>
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

                success: function(data) {
                    if (data.errors) {
                        if (data.errors.name) {
                            $('#name-error').html(data.errors.name[0]);
                        }
                        if (data.errors.email) {
                            $('#email-error').html(data.errors.email[0]);
                        }
                        if (data.errors.message) {
                            $('#message-error').html(data.errors.message[0]);
                        }
                    }

                    if (data.success) {
                        $('#show_message').removeClass('notin');
                        setInterval(function() {
                            $('#show_message').addClass('notin');
                        }, 3000);

                    }
                },
            });
        }

    </script>
  @endsection