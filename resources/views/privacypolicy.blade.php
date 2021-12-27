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
            Our <b>Service</b> allows you to post, link, store, share and otherwise make available certain information, text, graphics, videos, or other material (“Content”). You are responsible for Content that you post on or through Service, including its legality, reliability, and appropriateness.
            By posting Content on or through Service, You represent and warrant that:<br> <b>(i)</b> Content is yours (you own it) and/or you have the right to use it and the right to grant us the rights and license as provided in these Terms. <br> <b>(ii)</b> The posting of your Content on or through Service does not violate the privacy rights, publicity rights, copyrights, contract rights or any other rights of any person or entity. We reserve the right to terminate the account of anyone found to be infringing on a copyright.
            You retain any and all of your rights to any Content you submit, post or display on or through Service and you are responsible for protecting those rights. We take no responsibility and assume no liability for Content you or any third party posts on or through Service. <br> However, by posting Content using Service you grant us the right and license to use, modify, publicly perform, publicly display, reproduce, and distribute such Content on and through Service. You agree that
            this license includes the right for us to make your Content available to other users of Service, who may also use your Content subject to these Terms.
            Sellx has the right but not the obligation to monitor and edit all Content provided by users.
            In addition, Content found on or through this Service are the property of Sellx or used with permission. You may not distribute, modify, transmit, reuse, download, repost, copy, or use said Content, whether in whole or in part, for commercial purposes or for personal gain, without express advance written permission from us.

        </div>
  </div>
</div>
@endsection
