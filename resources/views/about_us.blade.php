@extends('noauthapp')

@section('content')
    <!-- After NavBar AboutUs Block One  Start -->
<div class="for_overflow">
    <div class="container">
        <div class="row for_about_main_row">
            <div class="col-lg-3 col-md-4 col-sm-12 for_col_after one order-lg-1 order-md-1 order-2">
                <a href="{{route('about')}}">Terms and Conditions</a>
                <br>
                <a href="{{route('about')}}">Privacy & Data Policy</a>
                <br>
                <a href="{{route('about')}}">Refund & Cancellations</a>
                <br>
                <a href="{{route('about')}}">Service Delivery Policy</a>
                <br>
                <a href="{{route('about')}}">Service Pricing</a>
                <br>
                <a href="{{route('about')}}" class="">Partners Terms</a>
                <hr class="for_partners_bottom">


                <div>
                    
                    <a href="{{route('contact')}}" class="">Contact Us</a>
                    <br>
                    <a href="{{route('about')}}" class="">About Us</a>


                </div>


            </div>
            <div class="col-lg-9 col-md-8 col-sm-12 order-lg-2 order-md-2 order-1">
                <h1>User Agreement: General Terms and Conditions of the Sellex Service</h1>

                <div class="for_basic_deffination_text">
                    <h4>Basic Deffination</h4>
                    <p>
                        Familiar and comforting-you know your future is in safe hands, but with the promise of something unexpecting. We have an infectious energy that sparks a curiosity to explore the new and undiscovered. We ask meaningful questions,
                        always with a clear vision and a desire to make a difference . Fantastic teams are made up of empowered individuals.
                    </p>
                    
                </div>

                <div class="for_basic_deffination_text">
                    <h4>The User Agreement</h4>
                    <p>
                        We have an infectious energy that sparks a curiosity to explore the new and undiscovered. We strive for exceptional in everything that we do, taking the smart route, not the easy one. We’re always thinking ahead, figuring out how to make the most purposeful impact. Familiar and comforting – you know your future is in safe hands, but with the promise of something unexpected.


                    </p>
                    <p>
                       We write like we talk – simply and with clarity; we never use a long word where a short one will do. We are united in our determination to create meaningful change, taking pride in making long-lasting impact. We are at the heart of shaping the future of design, raising a new bar for our clients, our peers and our industry. Each project is a chance to crack a new code.

                    </p>
                    <p>
                         We have purpose, but also spirit. We are storytellers. We never stop learning. We are experts in our field, have an opinion on our craft, and are ambitious; but always humble, because we know there’s always more to learn.
                    </p>
                    
                </div>
                <hr class="for_about_us_bottom_sm_obly"> 

            </div>

        </div>
        

    </div>

</div>
<!-- After NavBar AboutUs Block One  End -->

@endsection