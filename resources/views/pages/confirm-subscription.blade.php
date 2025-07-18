<!DOCTYPE HTML>
<html lang="en">
<head>
<title>{{ $allsettings->site_title }} - {{ __('Subscription Upgrade') }}</title>
@include('meta')
@include('style')
</head>
<body>
@include('header')
<section class="bg-position-center-top" style="background-image: url('{{ url('/') }}/public/storage/settings/{{ $allsettings->site_other_banner }}');">
      <div class="py-4">
        <div @if($custom_settings->theme_layout == 'container') class="container-fluid d-lg-flex justify-content-between py-2 py-lg-3" @else class="container d-lg-flex justify-content-between py-2 py-lg-3" @endif>
        <div class="order-lg-2 mb-3 mb-lg-0 pt-lg-2">
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb flex-lg-nowrap justify-content-center justify-content-lg-star">
              <li class="breadcrumb-item"><a class="text-nowrap" href="{{ URL::to('/') }}"><i class="dwg-home"></i>{{ __('Home') }}</a></li>
              <li class="breadcrumb-item text-nowrap active" aria-current="page">{{ __('Subscription Upgrade') }}</li>
            </ol>
          </nav>
        </div>
        <div class="order-lg-1 pr-lg-4 text-center text-lg-left">
          <h1 class="h3 mb-0 text-white">{{ __('Subscription Upgrade') }}</h1>
        </div>
      </div>
      </div>
    </section>
<div class="faq-section section-padding subscribe-details" data-aos="fade-up" data-aos-delay="200">
		<div class="container py-5 mt-md-2 mb-2">
            <div class="row">
         <div class="col-sm-6 col-md-5 col-lg-5 subscribe-details">
            <div>
            <form action="{{ route('subscription-coupon') }}" class="setting_form" id="coupon_form" method="post" enctype="multipart/form-data">
              {{ csrf_field() }} 
              <div class="mb-4 pb-3 border-bottom">
                <h2 class="h6 mb-3 pb-1">{{ __('Coupon Code') }}</h2>
                  <div class="form-group">
                    <input class="form-control" type="text" placeholder="{{ __('Coupon Code') }}" id="coupon" name="coupon" required>
                    <input type="hidden" name="id" value="{{ $id }}">
                  </div>
                  <button class="text-center  btn btn-secondary btn-block" type="submit">{{ __('Apply Coupon') }}</button>
              </div>
             </form>
             </div>
            <div class="mb-3">
                <h4 class="mb-3">{{ __('Subscription Details') }}</h4>
                <div class="card-body carder couprices">
                    <p><label>{{ __('Subscription Name') }} :</label> {{ $subscr['view']->subscr_name }}</p>
                    <p><label>{{ __('Price') }} :</label> 
                    @if($user_details->user_coupon_id != "")<del>{{ $allsettings->site_currency_symbol }}{{ $subscr['view']->subscr_price }}</del> {{ $allsettings->site_currency_symbol }}{{ $user_details->user_discount_price }} @else{{ $allsettings->site_currency_symbol }}{{ $subscr['view']->subscr_price }}@endif</p>
                    @if($user_details->user_coupon_id != "")
                    <p><label>{{ __('Coupon Code') }} :</label> <span class="green">{{ $user_details->user_coupon_code }}</span> <a href="{{ URL::to('/remove-subscription/') }}/{{ base64_encode($user_details->id) }}" class="red fs14" onClick="return confirm('{{ __('Are you sure you want to delete') }}?');" title="{{ __('Remove') }}"> <i class="dwg-close font-size-xs"></i> </a></p>
                    @endif
                    <p><label>{{ __('Duration') }} :</label> @if($subscr['view']->subscr_duration == '1000 Year'){{ __('Life Time') }}@else{{ $subscr['view']->subscr_duration }}@endif</p>
                    @if($subscr['view']->subscr_item_level == 'limited')
                    <p><label>{{ __('No of Products') }} :</label> {{ $subscr['view']->subscr_item }} {{ __('Products') }}</p>
                    @else
                    <p><label>{{ __('No of Products') }} :</label> {{ __('Unlimited') }}</p>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-7 col-lg-7">
        <form action="{{ route('confirm-subscription') }}" class="needs-validation" id="checkout_form" method="post" enctype="multipart/form-data">
             {{ csrf_field() }}
            <div class="pt-2 px-4 pr-lg-0 pl-xl-5">
              <!-- Title-->
              <h2 class="h6 border-bottom pb-3 mb-3">{{ __('Select Payment Method') }}</h2>
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
                      <button class="btn btn-primary" type="submit">{{ __('Pay with Stripe') }}</button>
                    </div> 
                    @endif
                    @if($payment == 'paypal')
                    <div class="card-body custompads font-size-sm custom-control custom-radio">
                      <p><span class='font-weight-medium'><input id="opt1-{{ $payment }}" name="payment_method" type="radio" class="custom_radio" value="{{ $payment }}" @if($no == 1) checked @endif data-bvalidator="required"> {{ __('PayPal') }}</span> - {{ __('the safer, easier way to pay') }}</p>
                      <button class="btn btn-primary" type="submit">{{ __('Pay with Paypal') }}</button>
                    </div>
                    @endif
                    @if (Auth::check())
                    @if($payment == 'wallet')
                    <div class="card-body custompads font-size-sm custom-control custom-radio">
                      <p><span class='font-weight-medium'><input id="opt1-{{ $payment }}" name="payment_method" type="radio" class="custom_radio" value="{{ $payment }}" @if($no == 1) checked @endif data-bvalidator="required"> {{ __('Wallet') }}</span> - ({{ $allsettings->site_currency_symbol }}{{ Auth::user()->earnings }})</p>
                      <button class="btn btn-primary" type="submit">{{ __('Pay with Wallet') }}</button>
                    </div>
                    @endif
                    @endif
                    @if($payment == 'paystack')
                    <div class="card-body custompads font-size-sm custom-control custom-radio">
                      <p><span class='font-weight-medium'><input id="opt1-{{ $payment }}" name="payment_method" type="radio" class="custom_radio" value="{{ $payment }}" @if($no == 1) checked @endif data-bvalidator="required"> {{ __('PayStack') }}</span></p>
                      <button class="btn btn-primary" type="submit">{{ __('Pay with PayStack') }}</button>
                    </div>
                    @endif
                    @if($payment == 'localbank')
                    <div class="card-body custompads font-size-sm custom-control custom-radio">
                      <p><span class='font-weight-medium'><input id="opt1-{{ $payment }}" name="payment_method" type="radio" class="custom_radio" value="{{ $payment }}" @if($no == 1) checked @endif data-bvalidator="required"> {{ __('Local Bank') }}</span></p>
                      <button class="btn btn-primary" type="submit">{{ __('Pay with Local Bank') }}</button>
                    </div>
                    @endif
                    @if($payment == 'razorpay')
                    <div class="card-body custompads font-size-sm custom-control custom-radio">
                      <p><span class='font-weight-medium'><input id="opt1-{{ $payment }}" name="payment_method" type="radio" class="custom_radio" value="{{ $payment }}" @if($no == 1) checked @endif data-bvalidator="required"> {{ __('Razorpay') }}</span></p>
                      <button class="btn btn-primary" type="submit">{{ __('Pay with Razorpay') }}</button>
                    </div>
                    @endif
                    @if($payment == 'coingate')
                    <div class="card-body custompads font-size-sm custom-control custom-radio">
                      <p><span class='font-weight-medium'><input id="opt1-{{ $payment }}" name="payment_method" type="radio" class="custom_radio" value="{{ $payment }}" @if($no == 1) checked @endif data-bvalidator="required"> {{ __('Coingate') }}</span></p>
                      <button class="btn btn-primary" type="submit">{{ __('Pay with Coingate') }}</button>
                    </div>
                    @endif
                    @if($payment == 'coinpayments')
                    <div class="card-body custompads font-size-sm custom-control custom-radio">
                      <p><span class='font-weight-medium'><input id="opt1-{{ $payment }}" name="payment_method" type="radio" class="custom_radio" value="{{ $payment }}" data-bvalidator="required"> {{ __('CoinPayments') }}</span></p>
                      <button class="btn btn-primary" type="submit">{{ __('Pay with Coinpayments') }}</button>
                    </div>
                    @endif
                    @if($payment == 'payhere')
                    <div class="card-body custompads font-size-sm custom-control custom-radio">
                      <p><span class='font-weight-medium'><input id="opt1-{{ $payment }}" name="payment_method" type="radio" class="custom_radio" value="{{ $payment }}" data-bvalidator="required"> {{ __('PayHere') }}</span></p>
                      <button class="btn btn-primary" type="submit">{{ __('Pay with PayHere') }}</button>
                    </div>
                    @endif
                    @if($payment == 'payfast')
                    <div class="card-body custompads font-size-sm custom-control custom-radio">
                      <p><span class='font-weight-medium'><input id="opt1-{{ $payment }}" name="payment_method" type="radio" class="custom_radio" value="{{ $payment }}" data-bvalidator="required"> {{ __('PayFast') }}</span></p>
                      <button class="btn btn-primary" type="submit">{{ __('Pay with PayFast') }}</button>
                    </div>
                    @endif
                    @if($payment == 'flutterwave')
                    <div class="card-body custompads font-size-sm custom-control custom-radio">
                      <p><span class='font-weight-medium'><input id="opt1-{{ $payment }}" name="payment_method" type="radio" class="custom_radio" value="{{ $payment }}" data-bvalidator="required"> {{ __('Flutterwave') }}</span></p>
                      <button class="btn btn-primary" type="submit">{{ __('Pay with Flutterwave') }}</button>
                    </div>
                    @endif
                    @if($payment == 'mercadopago')
                    <div class="card-body custompads font-size-sm custom-control custom-radio">
                      <p><span class='font-weight-medium'><input id="opt1-{{ $payment }}" name="payment_method" type="radio" class="custom_radio" value="{{ $payment }}" data-bvalidator="required"> {{ __('Mercadopago') }}</span></p>
                      <button class="btn btn-primary" type="submit">{{ __('Pay with Mercadopago') }}</button>
                    </div>
                    @endif
                    @if($payment == 'coinbase')
                    <div class="card-body custompads font-size-sm custom-control custom-radio">
                      <p><span class='font-weight-medium'><input id="opt1-{{ $payment }}" name="payment_method" type="radio" class="custom_radio" value="{{ $payment }}" data-bvalidator="required"> {{ __('Coinbase') }}</span></p>
                      <button class="btn btn-primary" type="submit">{{ __('Pay with Coinbase') }}</button>
                    </div>
                    @endif
                    @if($payment == 'cashfree')
                    <div class="card-body font-size-sm custom-control custom-radio">
                      <p><span class='font-weight-medium'><input id="opt1-{{ $payment }}" name="payment_method" type="radio" class="custom_radio" value="{{ $payment }}" data-bvalidator="required"> {{ __('Cashfree') }}</span></p>
                      <button class="btn btn-primary" type="submit">{{ __('Pay with Cashfree') }}</button>
                    </div>
                    @endif
                    @if($payment == 'nowpayments')
                    <div class="card-body font-size-sm custom-control custom-radio">
                      <p><span class='font-weight-medium'><input id="opt1-{{ $payment }}" name="payment_method" type="radio" class="custom_radio" value="{{ $payment }}" data-bvalidator="required"> {{ __('NowPayments') }}</span></p>
                      <button class="btn btn-primary" type="submit">{{ __('Pay with NowPayments') }}</button>
                    </div>
                    @endif
                    @if($payment == 'uddoktapay')
                    <div class="card-body font-size-sm custom-control custom-radio">
                      <p><span class='font-weight-medium'><input id="opt1-{{ $payment }}" name="payment_method" type="radio" class="custom_radio" value="{{ $payment }}" data-bvalidator="required"> {{ __('UddoktaPay') }}</span></p>
                      <button class="btn btn-primary" type="submit">{{ __('Pay with UddoktaPay') }}</button>
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
            
            <input type="hidden" name="website_url" value="{{ url('/') }}">
            <input type="hidden" name="user_subscr_id" value="{{ $subscr['view']->subscr_id }}">
            <input type="hidden" name="user_subscr_type" value="{{ $subscr['view']->subscr_name }}">
            <input type="hidden" name="user_subscr_date" value="{{ $subscr['view']->subscr_duration }}">
            <input type="hidden" name="user_subscr_item_level" value="{{ $subscr['view']->subscr_item_level }}">
            <input type="hidden" name="user_subscr_item" value="{{ $subscr['view']->subscr_item }}">
            <input type="hidden" name="token" class="token">
            <input type="hidden" name="reference" value="{{ Paystack::genTranxRef() }}">
            <input type="hidden" name="id" value="{{ $id }}">
            </form>
              </div>
                </div>
            </div>
        </div>
        </div>
      </div>
	</div>
@include('footer')
@include('script')
@if(!empty($stripe_publish))
<script src="https://js.stripe.com/v3/"></script>
@if($stripe_type == 'intents')
<script type="text/javascript">
$(document).ready(function(){
'use strict';
		$("#ifYes").hide();
        $('#stripe').click(function(){
            var value = "stripe";
            $("input[name=payment_method][value=" + value + "]").prop('checked', true);
		
            if ($("#opt1-stripe").is(":checked")) {
                $("#ifYes").show();

} else {
                $("#ifYes").hide();
            }
        });
    });
</script>
@else
<script type="text/javascript">

	$(document).ready(function(){
        'use strict';
		$("#ifYes").hide();
        $('#paypal').click(function(){
            var value = "paypal";
            $("input[name=payment_method][value=" + value + "]").prop('checked', true);
        });
		
		$('#stripe').click(function(){
            var value = "stripe";
            $("input[name=payment_method][value=" + value + "]").prop('checked', true);
			if ($("#opt1-stripe").is(":checked")) {
                $("#ifYes").show();
				
				/* stripe code */
				
				var stripe = Stripe('{{ $stripe_publish_key }}');
   
				var elements = stripe.elements();
					
				var style = {
				base: {
					color: '#32325d',
					lineHeight: '18px',
					fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
					fontSmoothing: 'antialiased',
					fontSize: '14px',
					'::placeholder': {
					color: '#aab7c4'
					}
				},
				invalid: {
					color: '#fa755a',
					iconColor: '#fa755a'
				}
				};
			 
				
				var card = elements.create('card', {style: style, hidePostalCode: true});
			 
				
				card.mount('#card-element');
			 
			   
				card.addEventListener('change', function(event) {
					var displayError = document.getElementById('card-errors');
					if (event.error) {
						displayError.textContent = event.error.message;
					} else {
						displayError.textContent = '';
					}
				});
			 
				
				var form = document.getElementById('checkout_form');
				form.addEventListener('submit', function(event) {
					/*event.preventDefault();*/
			        if ($("#opt1-stripe").is(":checked")) { event.preventDefault(); }
					stripe.createToken(card).then(function(result) {
					
						if (result.error) {
						
						var errorElement = document.getElementById('card-errors');
						errorElement.textContent = result.error.message;
						
						
						} else {
							
							document.querySelector('.token').value = result.token.id;
							 
							document.getElementById('checkout_form').submit();
						}
						/*document.querySelector('.token').value = result.token.id;
							 
							document.getElementById('checkout_form').submit();*/
						
					});
				});
							
						
			/* stripe code */	
				
				
				
            } else {
                $("#ifYes").hide();
            }
			
			
        });
	
	});
</script>
@endif
@endif
<script type="text/javascript">
$(document).ready(function(){
        $('#wallet').click(function(){
            var value = "wallet";
            $("input[name=payment_method][value=" + value + "]").prop('checked', true);
        });
  
        $('#twocheckout').click(function(){
            var value = "twocheckout";
            $("input[name=payment_method][value=" + value + "]").prop('checked', true);
        });
		
		$('#paystack').click(function(){
            var value = "paystack";
            $("input[name=payment_method][value=" + value + "]").prop('checked', true);
        });
		
		$('#localbank').click(function(){
            var value = "localbank";
            $("input[name=payment_method][value=" + value + "]").prop('checked', true);
        });
		
		$('#razorpay').click(function(){
            var value = "razorpay";
            $("input[name=payment_method][value=" + value + "]").prop('checked', true);
        });
		
		$('#payhere').click(function(){
            var value = "payhere";
            $("input[name=payment_method][value=" + value + "]").prop('checked', true);
        });
		
		$('#payumoney').click(function(){
            var value = "payumoney";
            $("input[name=payment_method][value=" + value + "]").prop('checked', true);
        });
		
		$('#iyzico').click(function(){
            var value = "iyzico";
            $("input[name=payment_method][value=" + value + "]").prop('checked', true);
        });
		
		$('#flutterwave').click(function(){
            var value = "flutterwave";
            $("input[name=payment_method][value=" + value + "]").prop('checked', true);
        });
		
		$('#coingate').click(function(){
            var value = "coingate";
            $("input[name=payment_method][value=" + value + "]").prop('checked', true);
        });
		
		$('#ipay').click(function(){
            var value = "ipay";
            $("input[name=payment_method][value=" + value + "]").prop('checked', true);
        });
		
		$('#payfast').click(function(){
            var value = "payfast";
            $("input[name=payment_method][value=" + value + "]").prop('checked', true);
        });
		
		$('#coinpayments').click(function(){
            var value = "coinpayments";
            $("input[name=payment_method][value=" + value + "]").prop('checked', true);
        });
		
		$('#payhere').click(function(){
            var value = "payhere";
            $("input[name=payment_method][value=" + value + "]").prop('checked', true);
        });
		
		$('#payfast').click(function(){
            var value = "payfast";
            $("input[name=payment_method][value=" + value + "]").prop('checked', true);
        });
		
		$('#flutterwave').click(function(){
            var value = "flutterwave";
            $("input[name=payment_method][value=" + value + "]").prop('checked', true);
        });
		
		$('#mercadopago').click(function(){
            var value = "mercadopago";
            $("input[name=payment_method][value=" + value + "]").prop('checked', true);
        });
		
		$('#coinbase').click(function(){
            var value = "coinbase";
            $("input[name=payment_method][value=" + value + "]").prop('checked', true);
        });
		$('#cashfree').click(function(){
            var value = "cashfree";
            $("input[name=payment_method][value=" + value + "]").prop('checked', true);
        });
		$('#nowpayments').click(function(){
            var value = "nowpayments";
            $("input[name=payment_method][value=" + value + "]").prop('checked', true);
        });
		$('#uddoktapay').click(function(){
            var value = "uddoktapay";
            $("input[name=payment_method][value=" + value + "]").prop('checked', true);
        });
});		
</script>  
</body>
</html>