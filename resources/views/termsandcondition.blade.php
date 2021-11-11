@extends('noauthapp')

@section('content')
<div class="for_overflow">
  <div class="container">
      <div class="row for_about_main_row">
          <div class="col-lg-3 col-md-4 col-sm-12 for_col_afterr right_border order-lg-1 order-md-1 order-2">
            {{ Session::get('locale') }}
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
            <a href="{{ route('partnersterms') }}" class="">{{ __('Partners Terms')}}</a>
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
        Welcome to <b> Sellx </b> (“Company”, “we”, “our”, “us”)!
        These Terms of Service (“Terms”, “Terms of Service”) govern your use of our website located at <b> sellx.ae </b> (together or individually “Service”) {{__('operated by')}} <b> {{__('Sellx')}} </b>.
        {{__('Our Privacy Policy also governs your use of our Service and explains how we collect, safeguard and disclose information that results from your use of our web pages. Your agreement with us includes these Terms and our Privacy Policy (“Agreements”). You acknowledge that you have read and understood Agreements, and agree to be bound of them. If you do not agree with (or cannot comply with) Agreements, then you may not use the Service, but please let us know by emailing at info@sellx.ae so we can try to find a solution. These Terms apply to all visitors, users and others who wish to access or use Service.')}}"
        <br>
        <h4>
          Communications
        </h4>
        By using our Service, you agree to subscribe to newsletters, marketing or promotional materials and other information we may send. However, you may opt out of receiving any, or all, of these communications from us by following the unsubscribe link or by emailing at info@sellx.ae.

</div>
  </div>
</div>
@endsection
