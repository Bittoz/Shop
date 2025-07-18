<!doctype html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js" lang="en">
<!--<![endif]-->

<head>
    
    @include('admin.stylesheet')
</head>

<body>
    
    @include('admin.navigation')

    <!-- Right Panel -->
    @if(in_array('settings',$avilable))
    <div id="right-panel" class="right-panel">

       
                       @include('admin.header')
                       

        <div class="breadcrumbs">
            <div class="col-sm-4">
                <div class="page-header float-left">
                    <div class="page-title">
                        <h1>{{ __('Payment Settings') }}</h1>
                    </div>
                </div>
            </div>
            <div class="col-sm-8">
                <div class="page-header float-right">
                    
                </div>
            </div>
        </div>
        
        @include('admin.warning')

        <div class="content mt-3">
            <div class="animated fadeIn">
                <div class="row">

                    <div class="col-md-12">
                       
                        
                        
                      
                        <div class="card">
                           @if($demo_mode == 'on')
                           @include('admin.demo-mode')
                           @else
                           <form action="{{ route('admin.payment-settings') }}" method="post" id="setting_form" enctype="multipart/form-data">
                           {{ csrf_field() }}
                          @endif
                           <div class="col-md-6">
                           
                            <div class="card-body">
                                <!-- Credit Card -->
                                <div id="pay-invoice">
                                    <div class="card-body">
                                       
                                        
                                            
                                            <div class="form-group">
                                                <label for="site_title" class="control-label mb-1">{{ __('Processing Fee') }} ({{ __('extra fee') }}) <span class="require">*</span></label>
                                                <input id="site_extra_fee" name="site_extra_fee" type="text" class="form-control noscroll_textarea" value="{{ $setting['setting']->site_extra_fee }}" data-bvalidator="required,min[0]"><small>(if you will set <strong>"0"</strong> processing fee is <strong>OFF</strong>)</small>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label for="site_title" class="control-label mb-1">{{ __('Minimum withdrawal amount') }} ({{ $setting['setting']->site_currency_symbol }})<span class="require">*</span></label>
                                                <input id="site_minimum_withdrawal" name="site_minimum_withdrawal" type="text" class="form-control noscroll_textarea" value="{{ $setting['setting']->site_minimum_withdrawal }}" data-bvalidator="required,digit,min[1]">
                                            </div> 
                                            
                                                                                          
                                          <div class="form-group">
                                                <label for="site_title" class="control-label mb-1">{{ __('Flash Sale Discount Percentage') }} (%)<span class="require">*</span></label>
                                                <input id="site_flash_sale_discount" name="site_flash_sale_discount" type="text" class="form-control noscroll_textarea" value="{{ $setting['setting']->site_flash_sale_discount }}" data-bvalidator="required,number,min[1],max[99]">
                                            </div> 
                                                
                                        
                                    </div>
                                </div>

                            </div>
                            </div>
                            
                            
                            
                             <div class="col-md-6">
                             
                             
                             <div class="card-body">
                                <!-- Credit Card -->
                                <div id="pay-invoice">
                                    <div class="card-body">
                                                
                                            <div class="form-group">
                                              <label for="product_approval" class="control-label mb-1">{{ __('Affiliate Referral') }}?<span class="require">*</span></label><br/>
                                              <select name="affiliate_referral" class="form-control" required>
                                                        <option value=""></option>
                                                        <option value="1" @if($custom_settings->affiliate_referral == 1) selected @endif>{{ __('ON') }}</option>
                                                        <option value="0" @if($custom_settings->affiliate_referral == 0) selected @endif>{{ __('OFF') }}</option>
                                              </select>
                                              
                                            </div>
                                                
                                                
                                                <div class="form-group">
                                                <label for="site_title" class="control-label mb-1">{{ __('Sign Up') }} {{ __('Referral Commission') }} ({{ $setting['setting']->site_currency_symbol }})<span class="require">*</span></label>
                                                
                                                <input id="site_referral_commission" name="site_referral_commission" type="text" class="form-control noscroll_textarea" value="{{ $setting['setting']->site_referral_commission }}"  data-bvalidator="required,number,min[0]"></div>
                                                
                                                
                                                <div class="form-group">
                                                <label for="site_title" class="control-label mb-1">{{ __('Per Sale Referral Commission Type') }}<span class="require">*</span></label>
                                                <select name="per_sale_referral_commission_type" id="per_sale_referral_commission_type" class="form-control" required>
                                                <option value="fixed" @if($custom_settings->per_sale_referral_commission_type == 'fixed') selected @endif>{{ __('Fixed') }}</option>
                                                <option value="percentage" @if($custom_settings->per_sale_referral_commission_type == 'percentage') selected @endif>{{ __('Percentage') }}</option>
                                                </select>
                                            </div>
                                                
                                                <div class="form-group"><label for="site_title" class="control-label mb-1">{{ __('Per Sale Referral Commission') }} <span id="nfixed" @if($custom_settings->per_sale_referral_commission_type == 'fixed') class="inline-block" @else  class="display-none" @endif>({{ $setting['setting']->site_currency_symbol }})</span><span id="npercentage" @if($custom_settings->per_sale_referral_commission_type == 'percentage') class="inline-block" @else  class="display-none" @endif>(%)</span><span class="require">*</span></label>
                                                <input id="per_sale_referral_commission" name="per_sale_referral_commission" type="text" class="form-control noscroll_textarea" value="{{ $setting['setting']->per_sale_referral_commission }}"  data-bvalidator="required,number,min[0]"></div>
                                                
                                                <input type="hidden" name="sid" value="1">
                             
                             
                             </div>
                                </div>

                            </div>
                             
                             
                             
                             </div>
                             
                             
                             
                             <div style="clear:both;"></div>
                             
                             
                             <div class="col-md-6">
                           
                            <div class="card-body">
                                <!-- Credit Card -->
                                <div id="pay-invoice">
                                    <div class="card-body">
                                       
                                        
                                            
                                            <div class="form-group">
                                                <label for="site_title" class="control-label mb-1">{{ __('Payment Methods') }} </label><br/>
                                                @foreach($payment_option as $payment)
                                                <input id="payment_option" name="payment_option[]" type="checkbox" @if(in_array($payment,$get_payment)) checked @endif class="noscroll_textarea" value="{{ $payment }}"> {{ str_replace("-"," ",$payment) }}<br/>
                                                @endforeach
                                             </div>
                                            
                                      
                                        
                                    </div>
                                </div>

                            </div>
                            </div>
                            
                            
                            
                            
                            <div class="col-md-6">
                           
                            <div class="card-body">
                                <!-- Credit Card -->
                                <div id="pay-invoice">
                                    <div class="card-body">
                                       
                                        
                                            
                                            <div class="form-group">
                                                <label for="site_title" class="control-label mb-1">{{ __('Withdraw Methods') }} </label><br/>
                                                @foreach($withdraw_option as $withdraw)
                                                <input id="withdraw_option" name="withdraw_option[]" type="checkbox" @if(in_array($withdraw->withdrawal_key,$get_withdraw)) checked @endif class="noscroll_textarea" value="{{ $withdraw->withdrawal_key }}" data-bvalidator="required"> {{ $withdraw->withdrawal_name }}<br/>
                                                @endforeach
                                             </div>
                                            
                                          
                                                
                                        
                                    </div>
                                </div>

                            </div>
                            </div>
                             
                             
                             <div class="col-md-12"><div class="card-body"><h4>{{ __('Paypal Settings') }}</h4></div></div>
                             
                             
                             <div class="col-md-6">
                           
                            <div class="card-body">
                                <!-- Credit Card -->
                                <div id="pay-invoice">
                                    <div class="card-body">
                                       
                                        
                                            
                                            <div class="form-group">
                                                <label for="site_title" class="control-label mb-1">{{ __('Paypal Email Id') }} <span class="require">*</span></label><br/>
                                               <input id="paypal_email" name="paypal_email" type="text" class="form-control noscroll_textarea" value="{{ $setting['setting']->paypal_email }}" data-bvalidator="required,email">
                                                
                                                
                                             </div>
                                            
                                      
                                        
                                    </div>
                                </div>

                            </div>
                            </div>
                            
                            
                            
                            
                            <div class="col-md-6">
                           
                            <div class="card-body">
                                <!-- Credit Card -->
                                <div id="pay-invoice">
                                    <div class="card-body">
                                       
                                        
                                            
                                             <div class="form-group">
                                                <label for="site_title" class="control-label mb-1">{{ __('Paypal Mode') }} <span class="require">*</span></label><br/>
                                               
                                                <select name="paypal_mode" class="form-control" data-bvalidator="required">
                                                <option value=""></option>
                                                <option value="1" @if($setting['setting']->paypal_mode == 1) selected @endif>Live</option>
                                                <option value="0" @if($setting['setting']->paypal_mode == 0) selected @endif>Demo</option>
                                                </select>
                                                
                                             </div>
                                            
                                          
                                                
                                        
                                    </div>
                                </div>

                            </div>
                            </div>
                             
                             
                             
                             <div class="col-md-12"><div class="card-body"><h4>{{ __('Paystack Settings') }}</h4></div></div>
                            <div class="col-md-6">
                           
                            <div class="card-body">
                                <!-- Credit Card -->
                                <div id="pay-invoice">
                                    <div class="card-body">
                                    <div class="form-group">
                                                <label for="site_title" class="control-label mb-1">{{ __('Paystack Default Currency Code') }} <span class="require">*</span></label><br/>
                                               <input id="paystack_default_currency" name="paystack_default_currency" type="text" class="form-control noscroll_textarea" value="{{ $setting['setting']->paystack_default_currency }}" data-bvalidator="required">
                                                <small>Example : NGN</small>
                                                
                                             </div>
                                             
                                              <div class="form-group">
                                                <label for="site_title" class="control-label mb-1">{{ __('Paystack Merchant Email') }} <span class="require">*</span></label><br/>
                                               <input id="paystack_merchant_email" name="paystack_merchant_email" type="text" class="form-control noscroll_textarea" value="{{ $setting['setting']->paystack_merchant_email }}" data-bvalidator="required">
                                                
                                                
                                             </div>
                                    
                                    
                                         
                                        
                                    </div>
                                </div>

                            </div>
                            </div>
                            <div class="col-md-6">
                           
                            <div class="card-body">
                                <!-- Credit Card -->
                                <div id="pay-invoice">
                                    <div class="card-body">
                                    
                                    <div class="form-group">
                                                <label for="site_title" class="control-label mb-1">{{ __('Paystack Public Key') }} <span class="require">*</span></label><br/>
                                               <input id="paystack_public_key" name="paystack_public_key" type="text" class="form-control noscroll_textarea" value="{{ $setting['setting']->paystack_public_key }}" data-bvalidator="required">
                                                
                                                
                                             </div>
                                           
                                           
                                            <div class="form-group">
                                                <label for="site_title" class="control-label mb-1">{{ __('Paystack Secret Key') }} <span class="require">*</span></label><br/>
                                               <input id="paystack_secret_key" name="paystack_secret_key" type="text" class="form-control noscroll_textarea" value="{{ $setting['setting']->paystack_secret_key }}" data-bvalidator="required">
                                                
                                                
                                             </div>
                                   
                                         
                                    </div>
                                </div>

                            </div>
                            </div>
                            <div class="col-md-12"><div class="card-body"><h4>{{ __('Bank Settings') }}</h4></div></div>
                            <div class="col-md-6">
                           
                            <div class="card-body">
                                <!-- Credit Card -->
                                <div id="pay-invoice">
                                    <div class="card-body">
                                    
                                    
                                    
                                    <div class="form-group">
                                              <div style="height:0px;"></div>
                                                
                                             </div>
                                             
                                             
                                             <div class="form-group">
                                                <label for="site_title" class="control-label mb-1">{{ __('Local Bank Details') }} <span class="require">*</span></label><br/>
                                               <textarea name="local_bank_details" class="form-control noscroll_textarea" data-bvalidator="required" rows="5" cols="20">{{ $setting['setting']->local_bank_details }}</textarea>
                                                
                                                
                                             </div>
                                           
                                           
                                            
                                         
                                        
                                    </div>
                                </div>

                            </div>
                            </div>
                            <div class="col-md-6">
                           
                            <div class="card-body">
                                <!-- Credit Card -->
                                <div id="pay-invoice">
                                    <div class="card-body">
                                    
                                    
                                    
                                    <div class="form-group">
                                              <div style="height:0px;"></div>
                                                
                                             </div>
                                             <div class="form-group">
                                               <strong>{{ __('example') }}:<br/><br/>

                                                {{ __('Bank Name') }} : Test Bank<br/>
                                                {{ __('Branch Name') }} : Test Branch<br/>
                                                {{ __('Branch Code') }} : 00000<br/>
                                                {{ __('IFSC Code') }} : 63632EF</strong>
                                              </div>
                                         
                                        
                                    </div>
                                </div>

                            </div>
                            </div>
                             <div class="col-md-12"><div class="card-body"><h4>{{ __('Offline Payment Settings') }}</h4></div></div>
                             <div class="col-md-6">
                           
                            <div class="card-body">
                                <!-- Credit Card -->
                                <div id="pay-invoice">
                                    <div class="card-body">
                                    
                                    
                                    
                                    <div class="form-group">
                                              <div style="height:0px;"></div>
                                                
                                             </div>
                                             
                                             
                                             <div class="form-group">
                                                <label for="site_title" class="control-label mb-1">{{ __('Offline Payment Details') }}</label><br/>
                                               <textarea name="offline_payment_details" class="form-control noscroll_textarea" rows="5" cols="20">{{ $custom_settings->offline_payment_details }}</textarea>
                                                
                                                
                                             </div>
                                           
                                           
                                            
                                         
                                        
                                    </div>
                                </div>

                            </div>
                            </div>
                             <div class="col-md-12"><div class="card-body"><h4>{{ __('Razorpay Settings') }}</h4></div></div>
                            <div class="col-md-6">
                           
                            <div class="card-body">
                                <!-- Credit Card -->
                                <div id="pay-invoice">
                                    <div class="card-body">
                                    
                                    
                                    <div class="form-group">
                                                <label for="site_title" class="control-label mb-1">{{ __('Razorpay Key Id') }} <span class="require">*</span></label><br/>
                                               <input id="razorpay_key" name="razorpay_key" type="text" class="form-control noscroll_textarea" value="{{ $setting['setting']->razorpay_key }}" data-bvalidator="required">
                                                
                                                
                                             </div>
                                           
                                           
                                            
                                         
                                        
                                    </div>
                                </div>

                            </div>
                            </div>
                            <div class="col-md-6">
                           
                            <div class="card-body">
                                <!-- Credit Card -->
                                <div id="pay-invoice">
                                    <div class="card-body">
                                    
                                    
                                    <div class="form-group">
                                                <label for="site_title" class="control-label mb-1">{{ __('Razorpay Secret Key') }}<span class="require">*</span></label><br/>
                                               <input id="razorpay_secret" name="razorpay_secret" type="text" class="form-control noscroll_textarea" value="{{ $setting['setting']->razorpay_secret }}" data-bvalidator="required">
                                                
                                                
                                             </div>
                                         
                                    </div>
                                </div>

                            </div>
                            </div>
                             <div class="col-md-12"><div class="card-body"><h4>{{ __('Coingate Settings') }}</h4></div></div>
                             <div class="col-md-6">
                           
                            <div class="card-body">
                                <!-- Credit Card -->
                                <div id="pay-invoice">
                                    <div class="card-body">
                                       
                                        
                                            
                                            <div class="form-group">
                                                <label for="site_title" class="control-label mb-1">{{ __('Coingate Mode') }} <span class="require">*</span></label><br/>
                                               
                                                <select name="coingate_mode" class="form-control" data-bvalidator="required">
                                                <option value=""></option>
                                                <option value="1" @if($setting['setting']->coingate_mode == 1) selected @endif>Live</option>
                                                <option value="0" @if($setting['setting']->coingate_mode == 0) selected @endif>Demo</option>
                                                </select>
                                                
                                             </div>
                                             
                                             
                                    </div>
                                </div>

                            </div>
                            </div>
                             <div class="col-md-6">
                           
                            <div class="card-body">
                                <!-- Credit Card -->
                                <div id="pay-invoice">
                                    <div class="card-body">
                                    
                                    
                                    <div class="form-group">
                                                <label for="site_title" class="control-label mb-1">{{ __('Coingate Auth Token') }} <span class="require">*</span></label><br/>
                                               <input id="coingate_auth_token" name="coingate_auth_token" type="text" class="form-control noscroll_textarea" value="{{ $setting['setting']->coingate_auth_token }}" data-bvalidator="required">
                                                
                                                
                                             </div>
                                           
                                           
                                            
                                         
                                        
                                    </div>
                                </div>

                            </div>
                            </div>
                            
                            
                            <div class="col-md-12"><div class="card-body"><h4>{{ __('CoinPayments') }}</h4></div></div>
                            <div class="col-md-6">
                           
                            <div class="card-body">
                                <!-- Credit Card -->
                                <div id="pay-invoice">
                                    <div class="card-body">
                                    
                                    
                                    <div class="form-group">
                                                <label for="site_title" class="control-label mb-1">{{ __('CoinPayments Merchant ID') }} <span class="require">*</span></label><br/>
                                               <input id="coinpayments_merchant_id" name="coinpayments_merchant_id" type="text" class="form-control noscroll_textarea" value="{{ $setting['setting']->coinpayments_merchant_id }}" data-bvalidator="required">
                                                
                                                
                                             </div>
                                           
                                           
                                            
                                         
                                        
                                    </div>
                                </div>

                            </div>
                            </div>
                            <div class="col-md-6">
                           
                            <div class="card-body">
                                <!-- Credit Card -->
                                <div id="pay-invoice">
                                    <div class="card-body">
                                    
                                    </div>
                                </div>

                            </div>
                            </div>
                             <div class="col-md-12"><div class="card-body"><h4>{{ __('Payhere Settings') }}</h4></div></div>
                             <div class="col-md-6">
                           
                            <div class="card-body">
                                <!-- Credit Card -->
                                <div id="pay-invoice">
                                    <div class="card-body">
                                       
                                        
                                            
                                            <div class="form-group">
                                                <label for="site_title" class="control-label mb-1">{{ __('Payhere Mode') }} </label><br/>
                                               
                                                <select name="payhere_mode" class="form-control" required>
                                                <option value=""></option>
                                                <option value="1" @if($setting['setting']->payhere_mode == 1) selected @endif>Live</option>
                                                <option value="0" @if($setting['setting']->payhere_mode == 0) selected @endif>Demo</option>
                                                </select>
                                                
                                             </div>
                                             
                                             
                                             
                                    </div>
                                </div>

                            </div>
                            </div>
                            <div class="col-md-6">
                           
                            <div class="card-body">
                                <!-- Credit Card -->
                                <div id="pay-invoice">
                                    <div class="card-body">
                                    
                                    
                                    <div class="form-group">
                                                <label for="site_title" class="control-label mb-1">{{ __('Payhere Merchant Id') }} <span class="require">*</span></label><br/>
                                               <input id="payhere_merchant_id" name="payhere_merchant_id" type="text" class="form-control noscroll_textarea" value="{{ $setting['setting']->payhere_merchant_id }}" data-bvalidator="required">
                                                
                                                
                                             </div>
                                         
                                    </div>
                                </div>

                            </div>
                            </div>
                            <div class="col-md-12"><div class="card-body"><h4>{{ __('PayFast Settings') }}</h4></div></div>
                            <div class="col-md-6">
                           
                            <div class="card-body">
                                <!-- Credit Card -->
                                <div id="pay-invoice">
                                    <div class="card-body">
                                    
                                    
                                    <div class="form-group">
                                                <label for="site_title" class="control-label mb-1">{{ __('PayFast Mode') }} <span class="require">*</span></label><br/>
                                               
                                                <select name="payfast_mode" class="form-control" data-bvalidator="required">
                                                <option value=""></option>
                                                <option value="1" @if($setting['setting']->payfast_mode == 1) selected @endif>Live</option>
                                                <option value="0" @if($setting['setting']->payfast_mode == 0) selected @endif>Demo</option>
                                                </select>
                                                
                                             </div>
                                         
                                        
                                    </div>
                                </div>

                            </div>
                            </div>
                            <div class="col-md-6">
                           
                            <div class="card-body">
                                <!-- Credit Card -->
                                <div id="pay-invoice">
                                    <div class="card-body">
                                    
                                    <div class="form-group">
                                                <label for="site_title" class="control-label mb-1">{{ __('PayFast Merchant Id') }} <span class="require">*</span></label><br/>
                                               <input id="payfast_merchant_id" name="payfast_merchant_id" type="text" class="form-control noscroll_textarea" value="{{ $setting['setting']->payfast_merchant_id }}" data-bvalidator="required">
                                                
                                                
                                             </div>
                                           
                                           
                                            <div class="form-group">
                                                <label for="site_title" class="control-label mb-1">{{ __('PayFast Merchant Key') }} <span class="require">*</span></label><br/>
                                               <input id="payfast_merchant_key" name="payfast_merchant_key" type="text" class="form-control noscroll_textarea" value="{{ $setting['setting']->payfast_merchant_key }}" data-bvalidator="required">
                                                
                                                
                                             </div>
                                    
                                    
                                         
                                    </div>
                                </div>

                            </div>
                            </div>
                            <div class="col-md-12"><div class="card-body"><h4>{{ __('Flutterwave Settings') }}</h4></div></div>
                            <div class="col-md-6">
                           
                            <div class="card-body">
                                <!-- Credit Card -->
                                <div id="pay-invoice">
                                    <div class="card-body">
                                    <div class="form-group">
                                                <label for="site_title" class="control-label mb-1">{{ __('Flutterwave Default Currency Code') }} <span class="require">*</span></label><br/>
                                               <input id="flutterwave_default_currency" name="flutterwave_default_currency" type="text" class="form-control noscroll_textarea" value="{{ $setting['setting']->flutterwave_default_currency }}" data-bvalidator="required">
                                                <small>Example : NGN</small>
                                                
                                             </div>
                                    
                                    <div class="form-group">
                                                <label for="site_title" class="control-label mb-1">{{ __('Flutterwave Public Key') }} <span class="require">*</span></label><br/>
                                               <input id="flutterwave_public_key" name="flutterwave_public_key" type="text" class="form-control noscroll_textarea" value="{{ $setting['setting']->flutterwave_public_key }}" data-bvalidator="required">
                                                
                                                
                                             </div>
                                           
                                           
                                            
                                         
                                        
                                    </div>
                                </div>

                            </div>
                            </div>
                            <div class="col-md-6">
                           
                            <div class="card-body">
                                <!-- Credit Card -->
                                <div id="pay-invoice">
                                    <div class="card-body">
                                    
                                    
                                    <div class="form-group">
                                                <label for="site_title" class="control-label mb-1">{{ __('Flutterwave Secret Key') }} <span class="require">*</span></label><br/>
                                               <input id="flutterwave_secret_key" name="flutterwave_secret_key" type="text" class="form-control noscroll_textarea" value="{{ $setting['setting']->flutterwave_secret_key }}" data-bvalidator="required">
                                                
                                                
                                             </div>
                                         
                                    </div>
                                </div>

                            </div>
                            </div>
                            <div class="col-md-12"><div class="card-body"><h4>{{ __('Mercadopago Settings') }}</h4></div></div>
                             
                             <div class="col-md-6">
                           
                            <div class="card-body">
                                
                                <div id="pay-invoice">
                                    <div class="card-body">
                                       
                                        
                                            
                                            <div class="form-group">
                                                <label for="site_title" class="control-label mb-1">{{ __('Mercadopago Public Key') }}</label><br/>
                                            <input id="mercadopago_client_id" name="mercadopago_client_id" type="text" class="form-control noscroll_textarea" value="{{ $custom_settings->mercadopago_client_id }}">
                                                
                                                
                                             </div>
                                            
                                          
                                          <div class="form-group">
                                                <label for="site_title" class="control-label mb-1">{{ __('Mercadopago Access Token') }}</label><br/>
                                  <input id="mercadopago_client_secret" name="mercadopago_client_secret" type="text" class="form-control noscroll_textarea" value="{{ $custom_settings->mercadopago_client_secret }}">
                                                
                                                
                                             </div>
                                        
                                    </div>
                                </div>

                            </div>
                            </div>
                            <div class="col-md-6">
                           
                            <div class="card-body">
                                
                                <div id="pay-invoice">
                                    <div class="card-body">
                                       
                                        
                                            
                                             <div class="form-group">
                                                <label for="site_title" class="control-label mb-1">{{ __('Mercadopago Mode') }}</label><br/>
                                               
                                                <select name="mercadopago_mode" class="form-control">
                                                <option value="1" @if($custom_settings->mercadopago_mode == 1) selected @endif>{{ __('Live') }}</option>
                                                <option value="0" @if($custom_settings->mercadopago_mode == 0) selected @endif>{{ __('Demo') }}</option>
                                                </select>
                                                
                                             </div>
                                            
                                          
                                                
                                        
                                    </div>
                                </div>

                            </div>
                            </div>
                            
                            <div class="col-md-12"><div class="card-body"><h4>{{ __('Coinbase Settings') }}</h4></div></div>
                            
                            <div class="col-md-6">
                           
                            <div class="card-body">
                                
                                <div id="pay-invoice">
                                    <div class="card-body">
                                       
                                        
                                            
                                            <div class="form-group">
                                                <label for="site_title" class="control-label mb-1">{{ __('Coinbase Api Key') }}</label><br/>
                                               <input id="coinbase_api_key" name="coinbase_api_key" type="text" class="form-control noscroll_textarea" value="{{ $custom_settings->coinbase_api_key }}">
                                                
                                                
                                             </div>
                                            
                                            <br/>
                                             
                                         
                                        
                                    </div>
                                </div>

                            </div>
                            </div>
                            
                            
                            
                            
                            <div class="col-md-6">
                           
                            <div class="card-body">
                                
                                <div id="pay-invoice">
                                    <div class="card-body">
                                       
                                        
                                            
                                             <div class="form-group">
                                                <label for="site_title" class="control-label mb-1">{{ __('Coinbase Secret Key') }}</label><br/>
                                               
                                                <input id="coinbase_secret_key" name="coinbase_secret_key" type="text" class="form-control noscroll_textarea" value="{{ $custom_settings->coinbase_secret_key }}">
                                                
                                             </div>
                                            
                                          
                                                
                                        
                                    </div>
                                </div>

                            </div>
                            </div>
                            
                            <div class="col-md-12">
                            <div class="card-body">
                            <div id="pay-invoice">
                            <div class="card-body">
                            <div class="form-group">
                            <p>{{ __('Coinbase Checkout Webhook URL') }} : <code>{{ url('/') }}/webhooks/coinbase-checkout</code></p>
                            <p><a href="javascript:void(0);" data-toggle="modal" data-target="#myModal_three" class="blue-color">{{ __('How to configure webhooks url') }}?</a></p>
                             </div>
                            </div>
                            </div>                
                                </div>            
                            </div>
                            
                            <div class="col-md-12"><div class="card-body"><h4>{{ __('Cashfree Settings') }}</h4></div></div>
                            <div class="col-md-6">
                           
                            <div class="card-body">
                                <!-- Credit Card -->
                                <div id="pay-invoice">
                                    <div class="card-body">
                                    
                                    <div class="form-group">
                                                <label for="site_title" class="control-label mb-1">{{ __('Cashfree Mode') }} <span class="require">*</span></label><br/>
                                               
                                                <select name="cashfree_mode" class="form-control" data-bvalidator="required">
                                                <option value=""></option>
                                                <option value="1" @if($custom_settings->cashfree_mode == 1) selected @endif>Live</option>
                                                <option value="0" @if($custom_settings->cashfree_mode == 0) selected @endif>Demo</option>
                                                </select>
                                                
                                             </div>
                                    
                                    <div class="form-group">
                                                <label for="site_title" class="control-label mb-1">{{ __('Cashfree API Key') }} <span class="require">*</span></label><br/>
                                               <input id="cashfree_api_key" name="cashfree_api_key" type="text" class="form-control noscroll_textarea" value="{{ $custom_settings->cashfree_api_key }}" data-bvalidator="required">
                                                
                                                
                                             </div>
                                           
                                           
                                            
                                         
                                        
                                    </div>
                                </div>

                            </div>
                            </div>
                            <div class="col-md-6">
                           
                            <div class="card-body">
                                <!-- Credit Card -->
                                <div id="pay-invoice">
                                    <div class="card-body">
                                    
                                    
                                    <div class="form-group">
                                                <label for="site_title" class="control-label mb-1">{{ __('Cashfree API Secret') }} <span class="require">*</span></label><br/>
                                               <input id="cashfree_api_secret" name="cashfree_api_secret" type="text" class="form-control noscroll_textarea" value="{{ $custom_settings->cashfree_api_secret }}" data-bvalidator="required">
                                                
                                                
                                             </div>
                                         
                                    </div>
                                </div>

                            </div>
                            </div>
                            <div class="col-md-12">
                            <div class="card-body">
                            <div id="pay-invoice">
                            <div class="card-body">
                            <div class="form-group">
                            <p>{{ __('Go To Whitelisting URL') }} : <code>https://merchant.cashfree.com/merchants/pg/developers/whitelisting?env=prod</code></p>
                            <p><a href="javascript:void(0);" data-toggle="modal" data-target="#myModal_four" class="blue-color">{{ __('How To Put My Domain') }}?</a></p>
                             </div>
                            </div>
                            </div>                
                                </div>            
                            </div>
                            
                            
                            <div class="col-md-12"><div class="card-body"><h4>{{ __('NowPayments Settings') }}</h4></div></div>
                            <div class="col-md-6">
                           
                            <div class="card-body">
                                <!-- Credit Card -->
                                <div id="pay-invoice">
                                    <div class="card-body">
                                    
                                    <div class="form-group">
                                                <label for="site_title" class="control-label mb-1">{{ __('NowPayments Mode') }}</label><br/>
                                               
                                                <select name="nowpayments_mode" class="form-control">
                                                <option value="1" @if($custom_settings->nowpayments_mode == 1) selected @endif>{{ __('Live') }}</option>
                                                <option value="0" @if($custom_settings->nowpayments_mode == 0) selected @endif>{{ __('Demo') }}</option>
                                                </select>
                                                
                                             </div>
                                    
                                    <div class="form-group">
                                                <label for="site_title" class="control-label mb-1">{{ __('NowPayments API Key') }}</label><br/>
                                               <input id="nowpayments_api_key" name="nowpayments_api_key" type="text" class="form-control noscroll_textarea" value="{{ $custom_settings->nowpayments_api_key }}">
                                                
                                                
                                             </div>
                                           
                                           
                                            
                                         
                                        
                                    </div>
                                </div>

                            </div>
                            </div>
                            <div class="col-md-6">
                           
                            <div class="card-body">
                                <!-- Credit Card -->
                                <div id="pay-invoice">
                                    <div class="card-body">
                                    
                                    
                                    <div class="form-group">
                                                <label for="site_title" class="control-label mb-1">{{ __('NowPayments IPN Secret') }}</label><br/>
                                               <input id="nowpayments_ipn_secret" name="nowpayments_ipn_secret" type="text" class="form-control noscroll_textarea" value="{{ $custom_settings->nowpayments_ipn_secret }}">
                                                
                                                
                                             </div>
                                         
                                    </div>
                                </div>

                            </div>
                            </div>
                            <div class="col-md-12"><div class="card-body"><h4>{{ __('UddoktaPay Settings') }}</h4></div></div>
                            <div class="col-md-6">
                           
                            <div class="card-body">
                                <!-- Credit Card -->
                                <div id="pay-invoice">
                                    <div class="card-body">
                                    
                                    <div class="form-group">
                                                <label for="site_title" class="control-label mb-1">{{ __('UddoktaPay API Key') }}</label><br/>
                                               <input id="uddoktapay_api_key" name="uddoktapay_api_key" type="text" class="form-control noscroll_textarea" value="{{ $custom_settings->uddoktapay_api_key }}">
                                                
                                                
                                             </div>
                                           
                                           
                                            
                                         
                                        
                                    </div>
                                </div>

                            </div>
                            </div>
                            <div class="col-md-6">
                           
                            <div class="card-body">
                                <!-- Credit Card -->
                                <div id="pay-invoice">
                                    <div class="card-body">
                                    
                                    
                                    <div class="form-group">
                                                <label for="site_title" class="control-label mb-1">{{ __('UddoktaPay API URL') }}</label><br/>
                                               <input id="uddoktapay_api_url" name="uddoktapay_api_url" type="text" class="form-control noscroll_textarea" value="{{ $custom_settings->uddoktapay_api_url }}">
                                                <small>Example : https://sandbox.uddoktapay.com/api/checkout-v2</small>
                                                
                                             </div>
                                         
                                    </div>
                                </div>

                            </div>
                            </div>
                            
                             <div class="col-md-12"><div class="card-body"><h4>{{ __('Stripe Settings') }}</h4></div></div>
                             
                             
                              <div class="col-md-6">
                           
                            <div class="card-body">
                                <!-- Credit Card -->
                                <div id="pay-invoice">
                                    <div class="card-body">
                                       
                                        
                                            
                                            <div class="form-group">
                                                <label for="site_title" class="control-label mb-1">{{ __('Stripe Mode') }} <span class="require">*</span></label><br/>
                                               
                                                <select name="stripe_mode" class="form-control" data-bvalidator="required">
                                                <option value=""></option>
                                                <option value="1" @if($setting['setting']->stripe_mode == 1) selected @endif>Live</option>
                                                <option value="0" @if($setting['setting']->stripe_mode == 0) selected @endif>Demo</option>
                                                </select>
                                                
                                             </div>
                                             
                                             
                                             <div class="form-group">
                                                <label for="site_title" class="control-label mb-1">{{ __('Test Publishable Key') }} <span class="require">*</span></label><br/>
                                               <input id="test_publish_key" name="test_publish_key" type="text" class="form-control noscroll_textarea" value="{{ $setting['setting']->test_publish_key }}" data-bvalidator="required">
                                                
                                                
                                             </div>
                                             
                                             
                                             <div class="form-group">
                                                <label for="site_title" class="control-label mb-1">{{ __('Live Publishable Key') }} <span class="require">*</span></label><br/>
                                               <input id="live_publish_key" name="live_publish_key" type="text" class="form-control noscroll_textarea" value="{{ $setting['setting']->live_publish_key }}" data-bvalidator="required">
                                                
                                                
                                             </div>
                                            
                                      
                                        
                                    </div>
                                </div>

                            </div>
                            </div>
                            
                            
                            
                            
                            <div class="col-md-6">
                           
                            <div class="card-body">
                                <!-- Credit Card -->
                                <div id="pay-invoice">
                                    <div class="card-body">
                                    
                                    
                                    
                                    <div class="form-group">
                                                <label for="site_title" class="control-label mb-1">{{ __('Stripe Payment Type') }} </label><br/>
                                               
                                                <select name="stripe_type" class="form-control">
                                                <option value="charges" @if($setting['setting']->stripe_type == 'charges') selected @endif>{{ __('Charges API') }}</option>
                                                <option value="intents" @if($setting['setting']->stripe_type == 'intents') selected @endif>{{ __('Intents API') }}</option>
                                                </select>
                                                
                                             </div>
                                             
                                             
                                             <div class="form-group">
                                                <label for="site_title" class="control-label mb-1">{{ __('Test Secret Key') }} <span class="require">*</span></label><br/>
                                               <input id="test_secret_key" name="test_secret_key" type="text" class="form-control noscroll_textarea" value="{{ $setting['setting']->test_secret_key }}" data-bvalidator="required">
                                                
                                                
                                             </div>
                                           
                                           
                                            <div class="form-group">
                                                <label for="site_title" class="control-label mb-1">{{ __('Live Secret Key') }} <span class="require">*</span></label><br/>
                                               <input id="live_secret_key" name="live_secret_key" type="text" class="form-control noscroll_textarea" value="{{ $setting['setting']->live_secret_key }}" data-bvalidator="required">
                                                
                                                
                                             </div>
                                         
                                        
                                    </div>
                                </div>

                            </div>
                            </div>
                             <div class="col-md-12 no-padding">
                             <div class="card-footer">
                                                        <button type="submit" name="submit" class="btn btn-primary btn-sm">
                                                            <i class="fa fa-dot-circle-o"></i> {{ __('Submit') }}
                                                        </button>
                                                        <button type="reset" class="btn btn-danger btn-sm">
                                                            <i class="fa fa-ban"></i> {{ __('Reset') }}
                                                        </button>
                                                    </div>
                             
                             </div>
                             
                            
                            </form>
                            
                                                    
                                                    
                                                 
                            
                        </div> 

                     
                    
                    
                    </div>
                    

                </div>
            </div><!-- .animated -->
        </div><!-- .content -->


    </div><!-- /#right-panel -->
    @else
    @include('admin.denied')
    @endif
    <!-- Right Panel -->


   @include('admin.javascript')

<div id="myModal_three" class="modal fade 2checkout" tabindex="-1" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-body">
            <img class="lazy" width="1223" height="678" src="{{ url('/') }}/resources/views/theme/img/coinbase_info.png"  class="img-responsive">
        </div>
    </div>
  </div>
</div>
<div id="myModal_four" class="modal fade 2checkout" tabindex="-1" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-body">
            <img class="lazy" width="1223" height="678" src="{{ url('/') }}/resources/views/theme/img/cashfree1.png"  class="img-responsive">
            <img class="lazy" width="1223" height="678" src="{{ url('/') }}/resources/views/theme/img/cashfree2.png"  class="img-responsive">
        </div>
    </div>
  </div>
</div>
</body>

</html>
