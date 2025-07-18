<!DOCTYPE HTML>
<html lang="en">
<head>
<title>{{ __('My Referral') }} - {{ $allsettings->site_title }}</title>
@include('meta')
@include('style')
</head>
<body>
@include('header')
<div class="page-title-overlap pt-4" style="background-image: url('{{ url('/') }}/public/storage/settings/{{ $allsettings->site_other_banner }}');">
      <div class="container d-lg-flex justify-content-between py-2 py-lg-3">
        <div class="order-lg-2 mb-3 mb-lg-0 pt-lg-2">
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-light flex-lg-nowrap justify-content-center justify-content-lg-star">
              <li class="breadcrumb-item"><a class="text-nowrap" href="{{ URL::to('/') }}"><i class="dwg-home"></i>{{ __('Home') }}</a></li>
              <li class="breadcrumb-item text-nowrap active" aria-current="page">{{ __('My Referral') }}</li>
            </ol>
          </nav>
        </div>
        <div class="order-lg-1 pr-lg-4 text-center text-lg-left">
          <h1 class="h3 mb-0 text-white">{{ __('My Referral') }}</h1>
        </div>
      </div>
    </div>
<div class="container pb-5 mb-2 mb-md-3">
      <div class="row">
        <!-- Sidebar-->
        <aside class="col-lg-4 pt-4 pt-lg-0">
          @include('dashboard-menu')
        </aside>
        <!-- Content  -->
        <section class="col-lg-8">
          <!-- Toolbar-->
          <div class="d-none d-lg-flex justify-content-between align-items-center pt-lg-3 pb-4 pb-lg-5 mb-lg-3">
            <h6 class="font-size-base text-light mb-0"></h6><a class="btn btn-primary btn-sm" href="{{ url('/logout') }}"><i class="dwg-sign-out mr-2"></i>{{ __('Logout') }}</a>
          </div>
          <div class="row mx-n2 pt-2 pb-4">
                <div class="col-md-6 col-sm-12 px-2 mb-6">
                  <div class="bg-secondary h-100 rounded-lg p-4 text-center">
                    <h3 class="font-size-sm text-muted">{{ __('Referral Commission') }}</h3>
                    <p class="h3 mb-2">{{ $allsettings->site_currency_symbol }}@if(Auth::user()->referral_amount == "")<span>0</span>@else{{ Auth::user()->referral_amount }}@endif</p>
                  </div>
                </div>
                <div class="col-md-6 col-sm-12 px-2 mb-6">
                  <div class="bg-secondary h-100 rounded-lg p-4 text-center">
                    <h3 class="font-size-sm text-muted">{{ __('Total Referrals') }}</h3>
                    <p class="h3 mb-2">{{ Auth::user()->referral_count }}</p>
                  </div>
                </div>
              </div>
              
          <!-- Profile form-->
          <div class="row">
              <div class="col-sm-6">
                <div class="form-group">
                  <label for="account-fn">{{ __('Affiliate Referral Url') }}</label>
                  <input type="text" value="{{ URL::to('/') }}/?ref={{ Auth::user()->id }}" id="myInput" class="form-control" readonly="readonly">
                </div>
                <a href="javascript:void(0)" onClick="myFunction()" class="btn btn-primary btn-sm">{{ __('Copy Url') }}</a>
              </div>
            </div>
        </section>
      </div>
    </div>
@include('footer')
@include('script')
</body>
</html>