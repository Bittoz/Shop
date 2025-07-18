<!DOCTYPE HTML>
<html lang="en">
<head>
<title>{{ __('Redeem Voucher') }} - {{ $allsettings->site_title }}</title>
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
              <li class="breadcrumb-item text-nowrap active" aria-current="page">{{ __('Redeem Voucher') }}</li>
              </li>
             </ol>
          </nav>
        </div>
        <div class="order-lg-1 pr-lg-4 text-center text-lg-left">
          <h1 class="h3 mb-0 text-white">{{ __('Redeem Voucher') }}</h1>
        </div>
      </div>
    </div>
<div class="container mb-5 pb-3">
      <div class="bg-light box-shadow-lg rounded-lg overflow-hidden">
        <div class="row">
          <!-- Sidebar-->
          <aside class="col-lg-4">
            <!-- Account menu toggler (hidden on screens larger 992px)-->
            <div class="d-block d-lg-none p-4">
            <a class="btn btn-outline-accent d-block" href="#account-menu" data-toggle="collapse"><i class="dwg-menu mr-2"></i>{{ __('Account menu') }}</a></div>
            <!-- Actual menu-->
            @include('dashboard-menu')
          </aside>
          <!-- Content-->
          <section class="col-lg-8 pt-lg-4 pb-4 mb-3">
            <div class="pt-2 px-4 pl-lg-0 pr-xl-5">
              <h2 class="h3 pt-2 pb-4 mb-0 text-center text-sm-left border-bottom">{{ __('Wallet Balance') }} : {{ $allsettings->site_currency_symbol }} {{ Auth::user()->earnings }}</h2>
              <!-- Product-->
               <div class="row">
                 <div class="col-lg-12 col-md-12 mb-3 mt-3">
                    @php echo html_entity_decode($allsettings->redeem_voucher_terms); @endphp
                  </div>
               </div>
               <div class="row">
                    <div class="col-lg-12 col-md-12 mb-3 mt-3">
                        <form method="POST" action="{{ route('add-money') }}" id="contact_form"  class="needs-validation mb-3" novalidate>
                                  @csrf
                                    <div class="row">
                                      <div class="col-sm-8">
                                        <div class="form-group">
                                          <label for="cf-name">{{ __('Enter Voucher Code') }} <span class="text-danger">*</span></label>
                                          <input class="form-control" type="text" id="voucher_code" name="voucher_code" data-bvalidator="required">
                                          <small>{{ __('To redeem. please enter the voucher secret code and click Add Money') }}</small>
                                        </div>
                                      </div>
                                    </div>
                           <button class="btn btn-primary pass-btn" type="submit">{{ __('Add Money') }}</button>
                        </form>
                     </div>
                </div> 
            </div>
          </section>
        </div>
      </div>
    </div>
@include('footer')
@include('script')
</body>
</html>