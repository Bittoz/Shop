@if ($message = Session::get('success'))
<div class="toast-container toast-top-center">
      <div class="toast mb-3" id="cart-toast-success" data-delay="5000" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header bg-success text-white"><i class="dwg-check-circle mr-2"></i>
          <h6 class="font-size-sm text-white mb-0 mr-auto">{{ __('Success') }}!</h6>
          <button class="close text-white ml-2 mb-1" type="button" data-dismiss="toast" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        <div class="toast-body">{{ $message }}</div>
      </div>
    </div>
@endif 
@if ($message = Session::get('error'))
<div class="toast-container toast-top-center">
      <div class="toast mb-3" id="cart-toast-error" data-delay="5000" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header bg-danger text-white"><i class="dwg-close-circle mr-2"></i>
          <h6 class="font-size-sm text-white mb-0 mr-auto">{{ __('Error') }}!</h6>
          <button class="close text-white ml-2 mb-1" type="button" data-dismiss="toast" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        <div class="toast-body text-danger">{{ $message }}</div>
      </div>
    </div>
@endif
@if (!$errors->isEmpty())
<div class="toast-container toast-top-center">
      <div class="toast mb-3" id="cart-toast-error" data-delay="5000" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header bg-danger text-white"><i class="dwg-close-circle mr-2"></i>
          <h6 class="font-size-sm text-white mb-0 mr-auto">{{ __('Error') }}!</h6>
          <button class="close text-white ml-2 mb-1" type="button" data-dismiss="toast" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        @foreach ($errors->all() as $error)
        <div class="toast-body text-danger">
        {{ $error }}
        </div>
        @endforeach
      </div>
    </div>
@endif
<footer class="bg-darker pt-5">
      <div @if($custom_settings->theme_layout == 'container') class="container-fluid" @else class="container" @endif>
        <div class="row pb-2">
          <div class="col-md-3 col-sm-4">
            <div class="widget widget-links widget-light pb-2 mb-4">
              <h3 class="widget-title text-dark font-weight-bold">{{ __('Categories') }}</h3>
              <ul class="widget-list">
                @foreach($footer_menu['category'] as $menu)
                <li class="widget-list-item"><a class="widget-list-link" href="{{ URL::to('/shop/category') }}/{{ $menu->category_slug }}">{{ $menu->category_name }}</a></li> 
                @endforeach
              </ul>
            </div>
          </div>
          <div class="col-md-3 col-sm-4">
            <div class="widget widget-links widget-light pb-2 mb-4">
              <h3 class="widget-title text-dark font-weight-bold">{{ __('More Info') }}</h3>
              <ul class="widget-list">
                @if($allsettings->site_blog_display == 1)
                <li class="widget-list-item"><a class="widget-list-link" href="{{ URL::to('/blog') }}">{{ __('Blog') }}</a></li>
                @endif
                <li class="widget-list-item"><a class="widget-list-link" href="{{ URL::to('/shop') }}">{{ __('Shop') }}</a></li>
                <li class="widget-list-item"><a class="widget-list-link" href="{{ URL::to('/my-favourite') }}">{{ __('My Favourite') }}</a></li>
                <li class="widget-list-item"><a class="widget-list-link" href="{{ URL::to('/my-purchases') }}">{{ __('My Purchases') }}</a></li>
                <li class="widget-list-item"><a class="widget-list-link" href="{{ URL::to('/contact') }}">{{ __('Contact') }}</a></li>
              </ul>
            </div>
          </div>
          <div class="col-md-3 col-sm-4">
          <div class="widget widget-links widget-light pb-2 mb-4">
              <h3 class="widget-title text-dark font-weight-bold">{{ __('Pages') }}</h3>
              <ul class="widget-list">
                @foreach($footerpages['pages'] as $pages)
                <li class="widget-list-item"><a class="widget-list-link" href="{{ URL::to('/') }}/{{ $pages->page_slug }}">{{ $pages->page_title }}</a></li>
                @endforeach
              </ul>
            </div>
          </div>
          <div class="col-md-3 col-sm-4">
            @if($allsettings->site_newsletter_display == 1)
            <div class="widget pb-2 mb-4">
              <h3 class="widget-title text-dark font-weight-bold pb-1">{{ __('Newsletter') }}</h3>
              <form class="validate" action="{{ route('newsletter') }}" method="post" name="mc-embedded-subscribe-form" id="footer_form" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="input-group input-group-overlay flex-nowrap">
                  <div class="input-group-prepend-overlay"><span class="input-group-text text-muted font-size-base"><i class="dwg-mail"></i></span></div>
                  <input class="form-control prepended-form-control" type="email" id="mce-EMAIL" value="" placeholder="{{ __('Enter your email address') }}" data-bvalidator="required" name="news_email">
                  <div class="input-group-append">
                    <button class="btn btn-primary" type="submit" name="subscribe" id="mc-embedded-subscribe">{{ __('Subscribe') }}</button>
                  </div>
                </div>
                @if($allsettings->site_google_recaptcha == 1)
                @if($custom_settings->google_captcha_version == 'v3')
                <div class="col-sm-12">
                  <div class="form-group{{ $errors->has('g-recaptcha-response') ? ' has-error' : '' }}">
                                <div class="col-sm-12">
                                    {!! RecaptchaV3::field('register') !!}
                                    @if ($errors->has('g-recaptcha-response'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('g-recaptcha-response') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                  </div>
                  @else
                <div class="mt-2" align="left">  
                             <div class="form-group {{ $errors->has('g-recaptcha-response') ? ' has-error' : '' }}">
                                   
                                    {!! app('captcha')->display() !!}
                                @if ($errors->has('g-recaptcha-response'))
                                    <span class="help-block">
                                        <strong class="red">{{ $errors->first('g-recaptcha-response') }}</strong>
                                    </span>
                                @endif
                                
                                </div>
                                </div>
                 @endif
                 @endif               
                <small class="form-text text-dark opacity-40" id="mc-helper">{{ __('Want more script,themes & templates? Subscribe to our mailing list to receive an update when new items arrive') }}!</small>
                <div class="subscribe-status"></div>
              </form>
            </div>
            @endif
            @if($custom_settings->app_store_url != "" || $custom_settings->google_play_url)
            <div class="widget pb-2 mb-4">
              <h3 class="widget-title text-dark font-weight-bold pb-1">{{ __('Download our app') }}</h3>
              <div class="d-flex flex-wrap">
                @if($custom_settings->app_store_url != "")
                <div class="mr-2 mb-2"><a class="btn-market btn-apple" href="{{ $custom_settings->app_store_url }}" role="button" target="_blank"><span class="btn-market-subtitle">{{ __('Download on the') }}</span><span class="btn-market-title">{{ __('App Store') }}</span></a></div>
                @endif
                @if($custom_settings->google_play_url != "")
                <div class="mb-2"><a class="btn-market btn-google" href="{{ $custom_settings->google_play_url }}" role="button" target="_blank"><span class="btn-market-subtitle">{{ __('Download on the') }}</span><span class="btn-market-title">{{ __('Google Play') }}</span></a></div>
                @endif
              </div>
            </div>
            @endif
          </div>
        </div>
      </div>
      <div class="pt-5 bg-darker">
        <div @if($custom_settings->theme_layout == 'container') class="container-fluid" @else class="container" @endif>
          <hr class="hr-light pb-4 mb-3">
          <div class="row pb-2">
            <div class="col-md-6 text-center text-md-left mb-1">
              <div class="text-nowrap mb-4">
              <a class="d-inline-block align-middle mt-n1 mr-3 mb-3" href="{{ URL::to('/') }}">
                @if($allsettings->site_logo != '')
                <img class="d-block" width="180" src="{{ url('/') }}/public/storage/settings/{{ $allsettings->site_logo }}" alt="{{ $allsettings->site_title }}"/>
                @endif
                </a>
                <div class="d-flex flex-wrap justify-content-center justify-content-md-start">
                @if($custom_settings->item_sold_display == 1)
                <h6 class="pr-3 mr-3"><span class="text-primary font-weight-bold">@if($allsettings->item_sold_count == ""){{ $count_sold }}@else{{ $allsettings->item_sold_count }}@endif </span><span class="font-weight-normal text-dark">{{ __('Item Sold') }}</span></h6>
                @endif
                @if($custom_settings->members_count_display == 1)
            <h6 class="mr-3"><span class="text-primary font-weight-bold">@if($allsettings->members_count == ""){{ $total_customer }}@else{{ $allsettings->members_count }}@endif </span><span class="font-weight-normal text-dark">{{ __('Members') }}</span></h6>
            @endif
              </div>
              </div>
            </div>
            <div class="col-md-6 text-center text-md-right mb-1">
              <div class="mb-3">
                @if($allsettings->facebook_url != '')
                <a class="social-btn sb-outline sb-facebook mr-2 mb-2" href="{{ $allsettings->facebook_url }}" target="_blank"><i class="dwg-facebook"></i></a>
                @endif
                @if($allsettings->twitter_url != '')
                <a class="social-btn sb-outline sb-twitter mr-2 mb-2" href="{{ $allsettings->twitter_url }}" target="_blank"><i class="dwg-twitter"></i></a>
                @endif
                @if($allsettings->pinterest_url != '')
                <a class="social-btn sb-outline sb-pinterest mr-2 mb-2" href="{{ $allsettings->pinterest_url }}" target="_blank"><i class="dwg-pinterest"></i></a>
                @endif
                @if($allsettings->gplus_url != '')
                <a class="social-btn sb-outline sb-dribbble mr-2 mb-2" href="{{ $allsettings->gplus_url }}" target="_blank"><i class="fa fa-whatsapp"></i></a>
                @endif
                @if($allsettings->instagram_url != '')
                <a class="social-btn sb-outline sb-behance mb-2" href="{{ $allsettings->instagram_url }}" target="_blank"><i class="dwg-instagram"></i></a>
                @endif
              </div>
              <div class="mt-2">
              @if(!empty($custom_settings->available_payment_methods))<img class="d-inline-block" width="187" src="{{ url('/') }}/public/storage/settings/{{ $custom_settings->available_payment_methods }}" alt="{{ $allsettings->site_title }}"/>@endif
              </div>
            </div>
          </div>
          <div class="pb-4 font-size-xs text-dark opacity-40 text-center text-md-left">@php echo html_entity_decode($allsettings->site_copyright); @endphp {{ $allsettings->site_title }}</div>
        </div>
      </div>
    </footer>
    @if($allsettings->cookie_popup == 1)
    <div class="alert text-center cookiealert" role="alert">
        {{ $allsettings->cookie_popup_text }}
        <button type="button" class="btn btn-primary btn-sm acceptcookies" aria-label="Close">
            {{ $allsettings->cookie_popup_button }}
        </button>
    </div>
    @endif
    <a class="btn-scroll-top" href="#top" data-scroll><span class="btn-scroll-top-tooltip text-muted font-size-sm mr-2">{{ __('Top') }}</span><i class="btn-scroll-top-icon dwg-arrow-up"></i></a>