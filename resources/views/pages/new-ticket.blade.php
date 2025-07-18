<!DOCTYPE HTML>
<html lang="en">
<head>
<title>{{ __('Open Ticket') }} - {{ $allsettings->site_title }}</title>
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
              <li class="breadcrumb-item text-nowrap active" aria-current="page">{{ __('Open Ticket') }}</li>
            </ol>
          </nav>
        </div>
        <div class="order-lg-1 pr-lg-4 text-center text-lg-left">
          <h1 class="h3 mb-0 text-white">{{ __('Open Ticket') }}</h1>
        </div>
      </div>
    </div>
<div class="container mb-5 pb-3">
      <div class="bg-light box-shadow-lg rounded-lg overflow-hidden">
        <div class="row">
          <!-- Sidebar-->
          <aside class="col-lg-4">
             @include('dashboard-menu')
          </aside>
          <!-- Content-->
          <section class="col-lg-8 pt-lg-4 pb-4 mb-3">
          <!-- Toolbar-->
          <div class="pt-2 px-4 pl-lg-0 pr-xl-5">
          <h2 class="h3 pt-2 pb-4 mb-0 text-center text-sm-left border-bottom">{{ __('Open Ticket') }}</h2>
          <div class="row">
                 <div class="col-lg-12 col-md-12 text-right mb-3 mt-3">
                 <a href="{{ URL::to('/my-tickets') }}" class="btn btn-success btn-sm">{{ __('My Tickets') }}</a>
                 </div>
                 </div>
          <form action="{{ route('new-ticket') }}" class="needs-validation" id="profile_form" method="post" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="row">
              <div class="col-sm-6">
                <div class="form-group">
                  <label for="account-fn">{{ __('Subject') }} <span class="required">*</span></label>
                  <input id="ticket_subject" name="ticket_subject" type="text" class="form-control" data-bvalidator="required">
                </div>
              </div>
              <div class="col-sm-6">
                <div class="form-group">
                  <label for="account-ln">{{ __('Priority') }} <span class="required">*</span></label>
                  <select name="ticket_priority" id="ticket_priority" class="form-control" data-bvalidator="required">
                  <option value=""></option>
                  <option value="{{ __('High') }}">High</option>
                  <option value="{{ __('Medium') }}">Medium</option>
                  <option value="{{ __('Low') }}">Low</option>
                  </select>
                </div>
              </div>
              <div class="col-sm-6">
                <div class="form-group">
                  <label for="account-email">{{ __('Message') }} <span class="required">*</span></label>
                  <textarea id="ticket_message" name="ticket_message" rows="5" class="form-control" data-bvalidator="required"></textarea>
                </div>
              </div>
              
              
              <div class="col-sm-6">
              <div class="form-group pb-2">
                  <label for="account-confirm-pass">{{ __('Upload') }}</label>
                  <div class="custom-file">
                    <input class="custom-file-input" type="file" id="unp-product-files" name="ticket_file" data-bvalidator="extension[jpg:png:jpeg:pdf]" data-bvalidator-msg="{{ __('Please select file of type .jpg, .png, .jpeg or .pdf') }}">
                    <label class="custom-file-label" for="unp-product-files"></label>
                    <small>({{ __('Upload only') }} : Jpg, png, pdf)</small>
                  </div>
                </div>
              </div> 
              <input type="hidden" name="ticket_user_token" value="{{ Auth::user()->user_token }}">
              <input type="hidden" name="image_size" value="{{ $allsettings->site_max_image_size }}"> 
              <div class="col-12">
                <div class="d-flex flex-wrap justify-content-between align-items-center">
                  <button class="btn btn-primary mt-3 mt-sm-0" type="submit">{{ __('Submit') }}</button>
                </div>
              </div>
            </div>
          </form>
          </div>
          <!-- Profile form-->
        </section>
          
        </div>
      </div>
    </div>
@include('footer')
@include('script')
</body>
</html>