<!DOCTYPE HTML>
<html lang="en">
<head>
<title>{{ $allsettings->site_title }} - {{ __('Subscription') }}</title>
@include('meta')
@include('style')
</head>
<body>
@include('header')
@if($allsettings->subscription_mode == 1)
<section class="bg-position-center-top" style="background-image: url('{{ url('/') }}/public/storage/settings/{{ $allsettings->site_other_banner }}');">
      <div class="py-4">
        <div @if($custom_settings->theme_layout == 'container') class="container-fluid d-lg-flex justify-content-between py-2 py-lg-3" @else class="container d-lg-flex justify-content-between py-2 py-lg-3" @endif>
        <div class="order-lg-2 mb-3 mb-lg-0 pt-lg-2">
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb flex-lg-nowrap justify-content-center justify-content-lg-star">
              <li class="breadcrumb-item"><a class="text-nowrap" href="{{ URL::to('/') }}"><i class="dwg-home"></i>{{ __('Home') }}</a></li>
              <li class="breadcrumb-item text-nowrap active" aria-current="page">{{ __('Subscription') }}</li>
            </ol>
          </nav>
        </div>
        <div class="order-lg-1 pr-lg-4 text-center text-lg-left">
          <h1 class="h3 mb-0 text-white">{{ __('Subscription') }}</h1>
        </div>
      </div>
      </div>
    </section>
<div class="faq-section section-padding">
		<div @if($custom_settings->theme_layout == 'container') class="container-fluid py-5 mt-md-2 mb-2" @else class="container py-5 mt-md-2 mb-2" @endif>
            <div class="row">
                @foreach($subscription['view'] as $subscription)
 				<div @if($custom_settings->theme_layout == 'container') class="col-lg-3 col-md-4" @else class="col-lg-4 col-md-4" @endif data-aos="fade-up" data-aos-delay="200">
 					<div class="single-price-item wow fadeInLeft" data-wow-delay=".3s" style="visibility: visible; animation-delay: 0.3s; animation-name: fadeInLeft;">
 						<h5>{{ $subscription->subscr_name }}</h5>
 						<div class="price-box">
 							<p><b>{{ $allsettings->site_currency_symbol }}{{ $subscription->subscr_price }}</b>/ @if($subscription->subscr_duration == '1000 Year'){{ __('Life Time') }}@else{{ $subscription->subscr_duration }}@endif</p>
 						</div>
                        <hr>
 						<div class="price-list">
 							<ul>
                                @if($subscription->subscr_item_level == 'limited')
 								<li><i class="fa fa-check" aria-hidden="true"></i> {{ __('Download') }} {{ $subscription->subscr_item }} {{ __('products per day') }}</li>
                                @else
                                <li><i class="fa fa-check" aria-hidden="true"></i> {{ __('Unlimited Download Products') }}</li>
                                @endif
                                <li><i class="fa fa-check" aria-hidden="true"></i> {{ __('Direct Download Links') }}</li>
                                <li><i class="fa fa-check" aria-hidden="true"></i> {{ __('Email Support') }}</li>										
								<li><i class="fa fa-check" aria-hidden="true"></i> {{ __('Support 24 x 7') }}</li>
 							</ul>
 						</div>
 						@if(Auth::guest())																			
						<a href="{{ URL::to('/login') }}" class="main-btn small-btn">
						<span>{{ __('Upgrade') }}</span> <i class="fa fa-caret-right" aria-hidden="true"></i>
						</a>
                        @else
                        @if(Auth::user()->id != 1)
                        <?php /*?>@if(Auth::user()->user_subscr_date < date('Y-m-d'))<?php */?>
                        @if(Auth::user()->user_subscr_type == $subscription->subscr_name)
                        <a href="javascript:void(0)" class="main-btn small-btn inactiveLink">
						<span>{{ __('Upgrade') }}</span> <i class="fa fa-caret-right" aria-hidden="true"></i>
						</a>
                        @else
                        <a href="{{ URL::to('/confirm-subscription') }}/{{ base64_encode($subscription->subscr_id) }}" class="main-btn small-btn">
						<span>{{ __('Upgrade') }}</span> <i class="fa fa-caret-right" aria-hidden="true"></i>
						</a>
                        @endif
                        <?php /*?>@endif<?php */?>
                        @endif
                        @endif
 					</div>
 				</div>
 				@endforeach	
 			</div>
		</div>
	</div>
    @else
    @include('not-found')
    @endif
@include('footer')
@include('script')
</body>
</html>