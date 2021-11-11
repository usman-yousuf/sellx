@extends('noauthapp')

@section('content')
<div class="for_overflow">
  <div class="container">
      <div class="row for_about_main_row">
          <div class="col-lg-3 col-md-4 col-sm-12 for_col_afterr right_border order-lg-1 order-md-1 order-2">
            <a href="{{ route('termsandcondition') }}">{{ __('Terms and Conditions') }}</a>
            <br>
            <a href="{{ route('privacypolicy') }}">{{ __('Privacy & Data Policy')}}</a>
            <br>
            <a href="{{ route('refundandcancelation') }}">{{ __('Refunds and Cancellations') }}</a>
            <br>
            <a href="{{ route('servicedeliverypolicy') }}">{{ __('Service Delivery Policy')}}</a>
            <br>
            <a href="{{ route('servicepricing') }}">{{ __('Service Pricing') }}</a>
            <br>
            <a href="{{ route('termsandcondition') }}" class="">{{ __('Partners Terms')}}</a>
          <br>
          <hr class="for_partners_bottom">

          <div>
              <a href="{{route('contact')}}" class="">{{ __('Contact us') }}</a>
              <br>
              <a href="{{route('about')}}" class="">{{ __('About us') }}</a>

              {{-- <a href="{{route('contact')}}" class="">{{ __('Comming Soon') }}</a> --}}
              <br>
              {{-- <a href="{{route('about')}}" class="">{{ __('Comming Soon') }}</a> --}}
          </div>
      </div>
         <div class="col-lg-9 col-md-8 col-sm-12 order-lg-2 order-md-2 order-1">
            <b>Purchases</b><br>
            If you wish to purchase any product or service made available through Service (“Purchase”), you may be asked to supply certain information relevant to your Purchase including but not limited to, your credit or debit card number, the expiration date of your card, your billing address, and your shipping information.<br>
            You represent and warrant that:<br> <b>(i)</b> you have the legal right to use any card(s) or other payment method(s) in connection with any Purchase; and that <br> <b>(ii)</b> the information you supply to us is true, correct and complete.<br><br>
            We may employ the use of third party services for the purpose of facilitating payment and the completion of Purchases. By submitting your information, you grant us the right to provide the information to these third parties subject to our Privacy Policy.<br>
            We reserve the right to refuse or cancel your order at any time for reasons including but not limited to: product or service availability, errors in the description or price of the product or service, error in your order or other reasons.<br>
            We reserve the right to refuse or cancel your order if fraud or an unauthorized or illegal transaction is suspected.

        </div>
  </div>
</div>
@endsection
