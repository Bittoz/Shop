<!DOCTYPE HTML>
<html lang="en">
<head>
<title>{{ __('Checkout') }} - {{ $allsettings->site_title }}</title>
@include('meta')
@include('style')
</head>
<body>
@include('header')
<div class="page-title-overlap pt-4" style="background-image: url('{{ url('/') }}/public/storage/settings/{{ $allsettings->site_other_banner }}');">
      <div class="container d-lg-flex justify-content-between py-2 py-lg-3">
        <div class="order-lg-2 mb-3 mb-lg-0 pt-lg-2">
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb flex-lg-nowrap justify-content-center justify-content-lg-star">
              <li class="breadcrumb-item"><a class="text-nowrap" href="{{ URL::to('/') }}"><i class="dwg-home"></i>{{ __('Home') }}</a></li>
              <li class="breadcrumb-item text-nowrap active" aria-current="page">{{ __('Checkout') }}</li>
              </li>
             </ol>
          </nav>
        </div>
        <div class="order-lg-1 pr-lg-4 text-center text-lg-left">
          <h1 class="h3 mb-0 text-white">{{ __('Checkout') }}</h1>
        </div>
      </div>
    </div>
<div class="container mb-5 pb-3">
      <div class="bg-light box-shadow-lg rounded-lg overflow-hidden">
        <div class="row">
          <!-- Content-->
          <section class="col-lg-8 pt-2 pt-lg-4 pb-4 mb-3">
          <form action="{{ route('checkout') }}" class="needs-validation" id="checkout_form" method="post" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="pt-2 px-4 pr-lg-0 pl-xl-5">
              <!-- Title-->
              @if(Auth::guest())
              <h2 class="h6 border-bottom pb-3 mb-3">{{ __('Not a customer yet') }}?</h2>
              <!-- Billing detail-->
              <div class="row pb-4">
                <div class="col-6 form-group">
                  <label for="mc-email">{{ __('Email address') }}  <span class='text-danger'>*</span></label>
                  <input type="text" id="email" class="form-control" name="email" data-bvalidator="required,email">
                </div>
                <div class="col-sm-6 form-group">
                  <label for="mc-company">{{ __('Password') }} <span class='text-danger'>*</span></label>
                  <input type="text" id="password" class="form-control" name="password" data-bvalidator="required,minlen[6]">
                </div>
              </div>
              @endif
              @if (Auth::check())
              <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
              @endif
              <div class="widget mb-3 d-lg-none">
                <h2 class="widget-title">{{ __('Order summary') }}</h2>
                @php 
                 $subtotal = 0;
                 $order_id = '';
                 $product_price = '';
                 $product_userid = '';
                 $coupon_code = ""; 
                 $new_price = 0; 
                 $single_price = 0;
                 $default_single_price = 0;
                 @endphp
                 @foreach($cart['item'] as $cart)
                <div class="media align-items-center pb-2 border-bottom">
                <a class="d-block mr-2" href="{{ url('/item') }}/{{ $cart->product_slug }}">
                @if($cart->product_image!='')
                <img class="rounded-sm" width="64" src="{{ url('/') }}/public/storage/product/{{ $cart->product_image }}" alt="{{ $cart->product_name }}"/>
                @else
                <img class="rounded-sm" width="64" src="{{ url('/') }}/public/img/no-image.png" alt="{{ $cart->product_name }}"/>
                @endif
                </a>
                  <div class="media-body pl-1">
                    <h6 class="widget-product-title"><a href="{{ url('/item') }}/{{ $cart->product_slug }}">{{ $cart->product_name }}</a></h6>
                    <div class="widget-product-meta"><span class="text-accent border-right pr-2 mr-2">{{ $allsettings->site_currency_symbol }} {{ $cart->product_price }}</span><span class="font-size-xs text-muted">{{ $cart->license }}@if($cart->license == 'regular') ({{ __('6 months') }}) @elseif($cart->license == 'extended') ({{ __('12 months') }}) @endif</span></div>
                  </div>
                </div>
                @php 
                $subtotal += $cart->product_price;
                $default_single_price += $cart->product_price;
                $single_price += $cart->product_price;
                $order_id .= $cart->ord_id.',';
                $product_price .= $cart->product_price.','; 
                $product_userid .= $cart->product_user_id.','; 
                if($cart->discount_price != 0)
                {
                    $price = $cart->discount_price;
                    $new_price += $cart->discount_price;
                    $coupon_code = $cart->coupon_code;
                }
                else
                {
                   $price = $cart->product_price;
                   $new_price += $cart->product_price;
                   $coupon_code = "";
                }
                @endphp
                @endforeach
                <ul class="list-unstyled font-size-sm py-3">
                  <li class="d-flex justify-content-between align-items-center"><span class="mr-2">{{ __('Subtotal') }}</span><span class="text-right">{{ $allsettings->site_currency_symbol }} {{ $subtotal }}</span></li>
                  @if($allsettings->site_extra_fee != 0)
                  <li class="d-flex justify-content-between align-items-center"><span class="mr-2">{{ __('Processing Fee') }}</span><span class="text-right">{{ $allsettings->site_currency_symbol }} {{ $allsettings->site_extra_fee }}</span></li>
                  @endif
                  @if($coupon_code != "")
                  @php 
                  $coupon_discount = $subtotal - $new_price;
                  $final = $new_price + $allsettings->site_extra_fee;
                  $last_price =  $new_price;
                  $priceamount = $new_price;
                  @endphp
                  <li class="d-flex justify-content-between align-items-center font-size-base"><span class="mr-2">{{ __('Discount Price') }}</span><span class="text-right"> - {{ $allsettings->site_currency_symbol }} {{ $coupon_discount }}</span></li>
                  @else
                  @php 
                  $final = $subtotal+$allsettings->site_extra_fee; 
                  $last_price =  $subtotal;
                  $priceamount = $subtotal;
                  @endphp
                  @endif
                  @if($country_percent != 0)
                  @php
                  $vat_price = ($single_price * $country_percent) / 100;
                  $default_vat_price = ($default_single_price * $country_percent) / 100;
                  @endphp
                  <li class="d-flex justify-content-between align-items-center font-size-base"><span class="mr-2">{{ __('VAT') }} (%)</span><span class="text-right">{{ $allsettings->site_currency_symbol }} {{ $vat_price }}</span></li>
                  @else
                  @php
                  $vat_price = 0;
                  $default_vat_price = 0;
                  @endphp
                  @endif 
                  @php
                  
                  $finbb = $final + $vat_price;
                  @endphp 
                  <li class="d-flex justify-content-between align-items-center font-size-base"><span class="mr-2">{{ __('Total') }}</span><span class="text-right">{{ $allsettings->site_currency_symbol }} {{ $finbb }}</span></li>
                </ul>
              </div>
              <div class="accordion mb-2" id="payment-method" role="tablist">
                @php $no = 1; @endphp
                @foreach($get_payment as $payment)
                <div class="card">
                  <div class="card-header" role="tab">
                    <h3 class="accordion-heading"><a href="#{{ $payment }}" id="{{ $payment }}" data-toggle="collapse">{{ __('Pay with') }} {{ $payment }}<span class="accordion-indicator"><i data-feather="chevron-up"></i></span></a></h3>
                  </div>
                  <div class="collapse @if($no == 1) show @endif" id="{{ $payment }}" data-parent="#payment-method" role="tabpanel">
                  @if($payment == 'stripe')
                    <div class="card-body font-size-sm custom-radio custom-control">
                      <p><span class='font-weight-medium'><input id="opt1-{{ $payment }}" name="payment_method" type="radio" class="custom_radio"  value="{{ $payment }}" data-bvalidator="required"> {{ __('Stripe') }}</span> - {{ __('Credit or debit card') }}</p>
                      @if($stripe_type == 'charges')
                      <div class="stripebox mb-3" id="ifYes" style="display:none;">
                        <label for="card-element">{{ __('Credit or debit card') }}</label>
                        <div id="card-element"></div>
                        <div id="card-errors" role="alert"></div>
                      </div>
                      @endif
                      <button class="btn btn-primary" type="submit">{{ __('Checkout with Stripe') }}</button>
                    </div> 
                    @endif
                    @if($payment == 'paypal')
                    <div class="card-body font-size-sm custom-control custom-radio">
                      <p><span class='font-weight-medium'><input id="opt1-{{ $payment }}" name="payment_method" type="radio" class="custom_radio" value="{{ $payment }}" @if($no == 1) checked @endif data-bvalidator="required"> {{ __('PayPal') }}</span> - {{ __('the safer, easier way to pay') }}</p>
                      <button class="btn btn-primary" type="submit">{{ __('Checkout with PayPal') }}</button>
                    </div>
                    @endif
                    @if (Auth::check())
                    @if($payment == 'wallet')
                    <div class="card-body font-size-sm custom-control custom-radio">
                      <p><span class='font-weight-medium'><input id="opt1-{{ $payment }}" name="payment_method" type="radio" class="custom_radio" value="{{ $payment }}" data-bvalidator="required"> {{ __('Wallet') }}</span> - ({{ $allsettings->site_currency_symbol }}{{ Auth::user()->earnings }})</p>
                      <button class="btn btn-primary" type="submit">{{ __('Checkout with Wallet') }}</button>
                    </div>
                    @endif
                    @endif
                    @if($payment == 'paystack')
                    <div class="card-body font-size-sm custom-control custom-radio">
                      <p><span class='font-weight-medium'><input id="opt1-{{ $payment }}" name="payment_method" type="radio" class="custom_radio" value="{{ $payment }}" @if($no == 1) checked @endif data-bvalidator="required"> {{ __('PayStack') }}</span></p>
                      <button class="btn btn-primary" type="submit">{{ __('Checkout with PayStack') }}</button>
                    </div>
                    @endif
                    @if($payment == 'offline')
                    <div class="card-body font-size-sm custom-control custom-radio">
                      <p><span class='font-weight-medium'><input id="opt1-{{ $payment }}" name="payment_method" type="radio" class="custom_radio" value="{{ $payment }}" @if($no == 1) checked @endif data-bvalidator="required"> {{ __('Offline') }}</span></p>
                      <button class="btn btn-primary" type="submit">{{ __('Checkout with Offline') }}</button>
                    </div>
                    @endif
                    @if($payment == 'localbank')
                    <div class="card-body font-size-sm custom-control custom-radio">
                      <p><span class='font-weight-medium'><input id="opt1-{{ $payment }}" name="payment_method" type="radio" class="custom_radio" value="{{ $payment }}" @if($no == 1) checked @endif data-bvalidator="required"> {{ __('Local Bank') }}</span></p>
                      <button class="btn btn-primary" type="submit">{{ __('Checkout with Local Bank') }}</button>
                    </div>
                    @endif
                    @if($payment == 'razorpay')
                    <div class="card-body font-size-sm custom-control custom-radio">
                      <p><span class='font-weight-medium'><input id="opt1-{{ $payment }}" name="payment_method" type="radio" class="custom_radio" value="{{ $payment }}" @if($no == 1) checked @endif data-bvalidator="required"> {{ __('Razorpay') }}</span></p>
                      <button class="btn btn-primary" type="submit">{{ __('Checkout with Razorpay') }}</button>
                    </div>
                    @endif
                    @if($payment == 'coingate')
                    <div class="card-body font-size-sm custom-control custom-radio">
                      <p><span class='font-weight-medium'><input id="opt1-{{ $payment }}" name="payment_method" type="radio" class="custom_radio" value="{{ $payment }}" @if($no == 1) checked @endif data-bvalidator="required"> {{ __('Coingate') }}</span></p>
                      <button class="btn btn-primary" type="submit">{{ __('Checkout with Coingate') }}</button>
                    </div>
                    @endif
                    @if($payment == 'coinpayments')
                    <div class="card-body font-size-sm custom-control custom-radio">
                      <p><span class='font-weight-medium'><input id="opt1-{{ $payment }}" name="payment_method" type="radio" class="custom_radio" value="{{ $payment }}" data-bvalidator="required"> {{ __('CoinPayments') }}</span></p>
                      <button class="btn btn-primary" type="submit">{{ __('Checkout with CoinPayments') }}</button>
                    </div>
                    @endif
                    @if($payment == 'payhere')
                    <div class="card-body font-size-sm custom-control custom-radio">
                      <p><span class='font-weight-medium'><input id="opt1-{{ $payment }}" name="payment_method" type="radio" class="custom_radio" value="{{ $payment }}" data-bvalidator="required"> {{ __('PayHere') }}</span></p>
                      <button class="btn btn-primary" type="submit">{{ __('Checkout with PayHere') }}</button>
                    </div>
                    @endif
                    @if($payment == 'payfast')
                    <div class="card-body font-size-sm custom-control custom-radio">
                      <p><span class='font-weight-medium'><input id="opt1-{{ $payment }}" name="payment_method" type="radio" class="custom_radio" value="{{ $payment }}" data-bvalidator="required"> {{ __('PayFast') }}</span></p>
                      <button class="btn btn-primary" type="submit">{{ __('Checkout with PayFast') }}</button>
                    </div>
                    @endif
                    @if($payment == 'flutterwave')
                    <div class="card-body font-size-sm custom-control custom-radio">
                      <p><span class='font-weight-medium'><input id="opt1-{{ $payment }}" name="payment_method" type="radio" class="custom_radio" value="{{ $payment }}" data-bvalidator="required"> {{ __('Flutterwave') }}</span></p>
                      <button class="btn btn-primary" type="submit">{{ __('Checkout with Flutterwave') }}</button>
                    </div>
                    @endif
                    @if($payment == 'mercadopago')
                    <div class="card-body font-size-sm custom-control custom-radio">
                      <p><span class='font-weight-medium'><input id="opt1-{{ $payment }}" name="payment_method" type="radio" class="custom_radio" value="{{ $payment }}" data-bvalidator="required"> {{ __('Mercadopago') }}</span></p>
                      <button class="btn btn-primary" type="submit">{{ __('Checkout with Mercadopago') }}</button>
                    </div>
                    @endif
                    @if($payment == 'coinbase')
                    <div class="card-body font-size-sm custom-control custom-radio">
                      <p><span class='font-weight-medium'><input id="opt1-{{ $payment }}" name="payment_method" type="radio" class="custom_radio" value="{{ $payment }}" data-bvalidator="required"> {{ __('Coinbase') }}</span></p>
                      <button class="btn btn-primary" type="submit">{{ __('Checkout with Coinbase') }}</button>
                    </div>
                    @endif
                    @if($payment == 'cashfree')
                    <div class="card-body font-size-sm custom-control custom-radio">
                      <p><span class='font-weight-medium'><input id="opt1-{{ $payment }}" name="payment_method" type="radio" class="custom_radio" value="{{ $payment }}" data-bvalidator="required"> {{ __('Cashfree') }}</span></p>
                      <button class="btn btn-primary" type="submit">{{ __('Checkout with Cashfree') }}</button>
                    </div>
                    @endif
                    @if($payment == 'nowpayments')
                    <div class="card-body font-size-sm custom-control custom-radio">
                      <p><span class='font-weight-medium'><input id="opt1-{{ $payment }}" name="payment_method" type="radio" class="custom_radio" value="{{ $payment }}" data-bvalidator="required"> {{ __('NowPayments') }}</span></p>
                      <button class="btn btn-primary" type="submit">{{ __('Checkout with NowPayments') }}</button>
                    </div>
                    @endif
                    @if($payment == 'uddoktapay')
                    <div class="card-body font-size-sm custom-control custom-radio">
                      <p><span class='font-weight-medium'><input id="opt1-{{ $payment }}" name="payment_method" type="radio" class="custom_radio" value="{{ $payment }}" data-bvalidator="required"> {{ __('UddoktaPay') }}</span></p>
                      <button class="btn btn-primary" type="submit">{{ __('Checkout with UddoktaPay') }}</button>
                    </div>
                    @endif
                  </div>
                </div>
                @php $no++; @endphp
                @endforeach
                <div class="clear-fix">&nbsp;</div>
                <div class="mt-3">
                <div class="form-group">
                  <input  type="checkbox" name="register_rules" id="ch2" value="1" data-bvalidator="required">
                  <span class="become_vendor">{{ __('I agree to the') }} <a href="{{ URL::to('/terms-and-conditions') }}">{{ __('terms & conditions') }}</a> {{ __('and') }} <a href="{{ URL::to('/privacy-policy') }}">{{ __('privacy policy') }}</a></span>
                </div>
                </div>
              </div>
            </div>
            <input type="hidden" name="order_id" value="{{ rtrim($order_id,',') }}">
            <input type="hidden" name="product_prices" value="{{ base64_encode(rtrim($product_price,',')) }}">
            <input type="hidden" name="product_user_id" value="{{ rtrim($product_userid,',') }}">
            <input type="hidden" name="amount" value="{{ base64_encode($finbb) }}">
            <input type="hidden" name="processing_fee" value="{{ base64_encode($allsettings->site_extra_fee) }}">
            <input type="hidden" name="website_url" value="{{ url('/') }}">
            <input type="hidden" name="vat_price" value="{{ base64_encode($vat_price) }}">
            <input type="hidden" name="default_vat_price" value="{{ base64_encode($default_vat_price) }}">
            <input type="hidden" name="token" class="token">
            </form>
          </section>
          <aside class="col-lg-4 d-none d-lg-block">
            <hr class="d-lg-none">
            <div class="cz-sidebar-static h-100 ml-auto border-left">
              <div class="widget mb-3">
                <h2 class="widget-title text-center">{{ __('Order summary') }}</h2>
                @php 
                 $subtotal = 0;
                 $order_id = '';
                 $product_price = '';
                 $single_price = 0;
                 $product_userid = ''; 
                 $coupon_code = ""; 
                 $new_price = 0;
                 @endphp
                 @foreach($cart_mobile['item'] as $cart)
                <div class="media align-items-center pb-3 mb-3 border-bottom">
                <a class="d-block mr-2" href="{{ url('/item') }}/{{ $cart->product_slug }}">
                @if($cart->product_image!='')
                <img class="rounded-sm" width="64" src="{{ url('/') }}/public/storage/product/{{ $cart->product_image }}" alt="{{ $cart->product_name }}"/>
                @else
                <img class="rounded-sm" width="64" src="{{ url('/') }}/public/img/no-image.png" alt="{{ $cart->product_name }}"/>
                @endif
                </a>
                  <div class="media-body pl-1">
                    <h6 class="widget-product-title"><a href="{{ url('/item') }}/{{ $cart->product_slug }}">{{ $cart->product_name }}</a></h6>
                    <div class="widget-product-meta"><span class="text-accent border-right pr-2 mr-2">{{ $allsettings->site_currency_symbol }} {{ $cart->product_price }}</span><span class="font-size-xs text-muted">{{ $cart->license }}@if($cart->license == 'regular') ({{ __('6 months') }}) @elseif($cart->license == 'extended') ({{ __('12 months') }}) @endif</span></div>
                  </div>
                </div>
                @php 
                $subtotal += $cart->product_price;
                $single_price += $cart->product_price;
                $order_id .= $cart->ord_id.',';
                $product_price .= $cart->product_price.','; 
                $product_userid .= $cart->product_user_id.',';
                if($cart->discount_price != 0)
                {
                    $price = $cart->discount_price;
                    $new_price += $cart->discount_price;
                    $coupon_code = $cart->coupon_code;
                }
                else
                {
                   $price = $cart->product_price;
                   $new_price += $cart->product_price;
                   $coupon_code = "";
                } 
                @endphp
                @endforeach
                <ul class="list-unstyled font-size-sm pt-3 pb-2 border-bottom">
                  <li class="d-flex justify-content-between align-items-center"><span class="mr-2">{{ __('Subtotal') }}</span><span class="text-right">{{ $allsettings->site_currency_symbol }} {{ $subtotal }}</span></li>
                  @if($allsettings->site_extra_fee != 0)
                  <li class="d-flex justify-content-between align-items-center"><span class="mr-2">{{ __('Processing Fee') }}</span><span class="text-right">{{ $allsettings->site_currency_symbol }} {{ $allsettings->site_extra_fee }}</span></li>
                  @endif
                  @if($coupon_code != "")
                  @php 
                  $coupon_discount = $subtotal - $new_price;
                  $final = $new_price + $allsettings->site_extra_fee;
                  $last_price =  $new_price;
                  $priceamount = $new_price;
                  @endphp
                  <li class="d-flex justify-content-between align-items-center"><span class="mr-2">{{ __('Discount Price') }}</span><span class="text-right"> - {{ $allsettings->site_currency_symbol }} {{ $coupon_discount }}</span></li>
                  @else
                  @php 
                  $final = $subtotal+$allsettings->site_extra_fee; 
                  $last_price =  $subtotal;
                  $priceamount = $subtotal;
                  @endphp
                  @endif
                  
                  @if($country_percent != 0)
                  @php
                  $vat_price = ($single_price * $country_percent) / 100;
                  @endphp
                  <li class="d-flex justify-content-between align-items-center"><span class="mr-2">{{ __('VAT') }} (%)</span><span class="text-right">{{ $allsettings->site_currency_symbol }} {{ $vat_price }}</span></li>
                  @else
                  @php
                  $vat_price = 0;
                  @endphp
                  @endif 
                  @php
                  
                  $finbb = $final + $vat_price;
                  @endphp
                </ul>
                <h3 class="font-weight-normal text-center my-4">{{ $allsettings->site_currency_symbol }} {{ $finbb }}</h3>
              </div>
            </div>
          </aside>
        </div>
      </div>
    </div>
@include('footer')
@include('script')
</body>
</html>