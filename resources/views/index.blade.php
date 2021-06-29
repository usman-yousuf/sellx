@extends('noauthapp')

@section('content')

    <style>
      .for_col_six_bg {
        background-image: url(assets/images/Right\ side.svg);
        background-size: cover;
        object-fit: cover;
        height: 550px;
      }
    </style>
  <body>

    <!-- After NavBar Block One Start -->
    <div class="for_overflow">
      <div class="row">
        <div
          class="col-lg-6 col-md-6 for_col_six_bg order-2 order-lg-1 order-md-1"
        >
          <!-- <img src="assets/images/iphone front 1.svg" /> -->
          <div class="text-center for_bg_iphone">
            <img src="assets/images/Iphone.jpg" class="img-fluid" />
          </div>
        </div>

        <div
          class="
            col-lg-6 col-md-6
            for_secoond_col_bg
            order-1 order-lg-2 order-md-1
          "
        >
          <div class="for_second_col">
            <h2>Sellex is a live auction platform in your phone</h2>

            <p>
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
              <button
                type="button"
                class="btn btn-primary shadow bg-body rounded"
              >
                Submit
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
    <br />
    <br />
    <!-- After NavBar Block Two End -->
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script> 
  <script type="text/javascript">

    $(".btn-primary").click(function(event){
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
@endsection
