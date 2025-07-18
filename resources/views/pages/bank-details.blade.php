<!DOCTYPE HTML>
<html lang="en">
<head>
<title>{{ __('Thank You') }} - {{ $allsettings->site_title }}</title>
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
              <li class="breadcrumb-item text-nowrap active" aria-current="page">{{ __('Thank You') }}</li>
            </ol>
          </nav>
        </div>
        <div class="order-lg-1 pr-lg-4 text-center text-lg-left">
          <h1 class="h3 mb-0 text-white">{{ __('Thank You') }}</h1>
        </div>
      </div>
      </div>
    </section>
<div @if($custom_settings->theme_layout == 'container') class="container-fluid py-5 mt-md-2 mb-2" @else class="container py-5 mt-md-2 mb-2" @endif>
      @if(in_array('pages',$top_ads))
      <div class="row">
          <div class="col-lg-12 mb-4" align="center">
             @php echo html_entity_decode($allsettings->top_ads); @endphp
          </div>
       </div>   
       @endif
      <div class="row">
        <div class="col-lg-12" data-aos="fade-up" data-aos-delay="200">
          <div class="panel-body mb-5 pb-5">
                        <h3>{{ __('Your details has been sent. Once received payment will confirm your order') }}</h3>
                        <h5 class="mt-3">{{ __('Your Purchase id') }} : {{ $purchase_token }}</h5>
						</div>
                        <div class="panel-body mb-5 pb-5">
                        <h3>{{ __('Below are you amount transaction details') }}</h3>
                        <h5 class="mt-3 pb-2">{{ __('Bank Details') }}</h5>
						<p>@php echo nl2br($bank_details) @endphp</p>	
				</div>
         </div>
      </div>
      @if(in_array('pages',$bottom_ads))
       <div class="row">
          <div class="col-lg-12 mb-4" align="center">
             @php echo html_entity_decode($allsettings->bottom_ads); @endphp
          </div>
       </div>   
       @endif
    </div>
@include('footer')
@include('script')
</body>
</html>