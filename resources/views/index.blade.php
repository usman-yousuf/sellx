<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css"
      integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l"
      crossorigin="anonymous"
    />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"
      integrity="sha512-SfTiTlX6kk+qitfevl/7LibUOeJWlt9rbyDn92a1DqWOw9vWG2MFoays0sgObmWazO5BQPiFucnnEAjpAB+/Sw=="
      crossorigin="anonymous"
    />

    <link rel="stylesheet" href="{{asset('assets/css/sellex.css')}}" />

    <title>Index.html</title>
    <style></style>
  </head>
  <body>
    <!-- Nav Bar Start -->
    <div class="top_nav">
      <div class="shadow p-3 mb-5 bg-body rounded for_navbar_bg">
        <a href="{{route('home')}}">
          <img
            src="assets/images/Layer 1.svg"
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
                                    src="{{asset('assets/images/Iphone.jpg')}}"
                                    align="middle"
                                    class="d-block w-100"
                                    alt="..."
                                    object-fit: contain
                                    />
                                </div>
                                <div class="carousel-item">
                                    <img
                                    src="{{asset('assets/images/Iphone.jpg')}}"
                                    align="middle"
                                    class="d-block w-100"
                                    alt="..."
                                    object-fit: contain
                                    />
                                </div>
                                <div class="carousel-item">
                                    <img
                                    src="{{asset('assets/images/Iphone.jpg')}}"
                                    class="d-block w-100"
                                    alt="..."
                                    object-fit: contain
                                    />
                                </div>
                                <div class="carousel-item">
                                    <img
                                    src="{{asset('assets/images/Iphone.jpg')}}"
                                    align="middle"
                                    class="d-block w-100"
                                    alt="..."
                                    object-fit: contain
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
            <h2>Sellex is a live auction platform in your phone</h2>

            <p class="for_p_text_the_platform">
              The Platform that connects auction houses and bidders online and
              allows you to take part in auctions in real-time
            </p>

            <div class="for_btn_download">
              <button type="button" class="btn btn-outline-primary">
                <span>
                  <i class="fa fa-apple" aria-hidden="true"></i>

                  <p>
                    Download on the
                    <br />
                    <span> App Store</span>
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
              src="assets/images/Illustration 1.svg"
              class="img-fluid"
              alt=""
            />
          </div>
          <div class="col-lg-3 col-md-6 for_sellex_text order-md-2 order-lg-1">
            <h4>Sellex is a live auction platform</h4>
            <p>
              Sellex is a live auction platform that connects auction houses and
              bidders online is a more efficient way
            </p>
          </div>

          <div class="col-lg-3 col-md-6 order-md-1 for_common_img_res">
            <img src="assets/images/Illustration 2.svg" class="img-fluid" />
          </div>

          <div class="col-lg-3 col-md-6 for_sellex_textt order-md-2">
            <h4>Take part in live auction platform</h4>
            <p>
              Watch the auctions from the auction houses in real time, place
              bids and win lots, or just write your comments.
            </p>
          </div>
        </div>

        <!-- Block Two Child One Start -->
        <div class="row for_blocktw_childone_main">
          <div
            class="col-lg-3 col-md-6 order-md-1 order-lg-0 for_common_img_res"
          >
            <img
              src="assets/images/Illustration 3.svg"
              class="img-fluid"
              alt=""
            />
          </div>
          <div class="col-lg-3 col-md-6 for_sellex_text order-md-2 order-lg-1">
            <h4>Discover lots from the auction houses</h4>
            <p>
              Discover and buy lots in a wide variety of catagories, from
              watches and jewelry to cars and properties.
            </p>
          </div>

          <div class="col-lg-3 col-md-6 order-md-1 for_common_img_res">
            <img src="assets/images/Illustration 5.svg" class="img-fluid" />
          </div>

          <div class="col-lg-3 col-md-6 for_sellex_textt order-md-2">
            <h4>Register an auction house</h4>
            <p>
              Register your auction house to start selling to your customers
              more efficiently, or find new customers on the platforms .
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
        <h3>Stay updated!</h3>
        <p>Send your email to keep abreast of all updates and news .</p>
        <div class="row">
          <div class="col-lg-9 col-md-9">
            <form class="for_common_input">
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text">
                    <i class="fa fa-envelope-o" aria-hidden="true"></i>
                  </span>
                </div>
                <input
                  type="text"
                  class="form-control"
                  placeholder="Your Email ..."
                  name="subscribe"
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
                  Sellex @ 2021 All rights reserved
                </span>
              </div>
          </div>
          </div>
          <!-- Footer End -->

<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns"
      crossorigin="anonymous"
    ></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script> 
  <script type="text/javascript">

    $(".btn-email").click(function(event){
        event.preventDefault();

        let email = $("input[name=subscribe]").val();

        $.ajax({
          url: `http://localhost/sellx/api/subscribe`,
          type:"POST",
          data:{
            e_mail:email,
            // _token: _token
          },
          success:function(response){
            if(response) {
             Swal.fire({
              icon:'success',
              text:'You are '+response.message,
              footer:'Thanks for subscription',
             })
            }
          },
          error: function (xhr, ajaxOptions, thrownError) {
            swal(xhr.status);
            swal(thrownError);
          }
         });
    });
  </script>
  </body>
</html>
