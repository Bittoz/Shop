<!DOCTYPE HTML>
<html lang="en">
<head>
<title>{{ __('My Profile') }} - {{ $allsettings->site_title }}</title>
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
              <li class="breadcrumb-item text-nowrap active" aria-current="page">{{ __('My Profile') }}</li>
            </ol>
          </nav>
        </div>
        <div class="order-lg-1 pr-lg-4 text-center text-lg-left">
          <h1 class="h3 mb-0 text-white">{{ __('My Profile') }}</h1>
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
            <h6 class="font-size-base text-light mb-0">{{ __('Update you profile details below') }}</h6><a class="btn btn-primary btn-sm" href="{{ url('/logout') }}"><i class="dwg-sign-out mr-2"></i>{{ __('Logout') }}</a>
          </div>
          @if($allsettings->subscription_mode == 1)
          @if(Auth::user()->user_subscr_type != '')
          <h4 class="h4 py-2 text-center text-sm-left">{{ Auth::user()->user_subscr_type }} {{ __('Membership') }}</h4>
          <div class="row mx-n2 pt-2 pb-4">
                <div class="col-md-6 col-sm-12 px-2 mb-6">
                  <div class="bg-secondary h-100 rounded-lg p-4 text-center">
                    <h3 class="font-size-sm text-muted">{{ __('Download products per day') }}</h3>
                    @if(Auth::user()->user_subscr_item_level == 'limited')
                    <p class="h3 mb-2">{{ Auth::user()->user_subscr_item }}</p>
                    @else
                    <p class="h3 mb-2">{{ __('Unlimited') }}</p>
                    @endif
                  </div>
                </div>
                <div class="col-md-6 col-sm-12 px-2 mb-6">
                  <div class="bg-secondary h-100 rounded-lg p-4 text-center">
                    <h3 class="font-size-sm text-muted">{{ __('Expire On') }}</h3>
                    @if(Helper::lifeTime(Auth::user()->id) == 0)
                    <p class="h3 mb-2">{{ date('d M Y',strtotime(Auth::user()->user_subscr_date)) }}</p>
                    @else
                    <p class="h3 mb-2">{{ __('Life Time') }}</p>
                    @endif
                  </div>
                </div>
              </div>
              @endif
             @endif 
          <!-- Profile form-->
          <form action="{{ route('my-profile') }}" class="needs-validation" id="profile_form" method="post" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="row">
              <div class="col-sm-6">
                <div class="form-group">
                  <label for="account-fn">{{ __('Name') }}</label>
                  <input id="name" name="name" type="text" class="form-control" value="{{ Auth::user()->name }}" data-bvalidator="required">
                </div>
              </div>
              <div class="col-sm-6">
                <div class="form-group">
                  <label for="account-ln">{{ __('Username') }}</label>
                  <input id="username" name="username" type="text" class="form-control" value="{{ Auth::user()->username }}" data-bvalidator="required">
                </div>
              </div>
              <div class="col-sm-6">
                <div class="form-group">
                  <label for="account-email">{{ __('Email address') }}</label>
                  <input id="email" name="email" type="text" class="form-control" value="{{ Auth::user()->email }}" data-bvalidator="email,required">
                </div>
              </div>
              <div class="col-sm-6">
                <div class="form-group">
                  <label for="account-pass">{{ __('Password') }}</label>
                  <div class="password-toggle">
                    <input id="password" name="password" type="text" class="form-control" data-bvalidator="min[6]">
                    <label class="password-toggle-btn">
                      <input class="custom-control-input" type="checkbox"><i class="dwg-eye password-toggle-indicator"></i><span class="sr-only">{{ __('Show password') }}</span>
                    </label>
                  </div>
                </div>
              </div>
              <div class="col-sm-6">
                <div class="form-group">
                  <label for="account-email">{{ __('Country') }} <span class="require">*</span></label>
                  <select name="country" id="country" class="form-control" data-bvalidator="required">
                                    <option value=""></option>
                                    @foreach($countries as $country)
                                    <option value="{{ $country->country_id }}" @if(Auth::user()->user_country == $country->country_id ) selected="selected" @endif>{{ $country->country_name }}</option>
                             @endforeach
                     </select>       
                </div>
              </div>
              <div class="col-sm-6">
              <div class="form-group pb-2">
                  <label for="account-confirm-pass">{{ __('Upload Photo') }}</label>
                  <div class="custom-file">
                    <input class="custom-file-input" type="file" id="unp-product-files" name="user_photo" data-bvalidator="extension[jpg:png:jpeg:svg]" data-bvalidator-msg="{{ __('Please select file of type .jpg, .png, .jpeg or .svg') }}">
                    <label class="custom-file-label" for="unp-product-files"></label>
                  </div>
                </div>
              </div> 
              <input type="hidden" name="save_photo" value="{{ Auth::user()->user_photo }}">
              <input type="hidden" name="save_password" value="{{ Auth::user()->password }}">
              <input type="hidden" name="user_token" value="{{ Auth::user()->user_token }}">
              <input type="hidden" name="image_size" value="{{ $allsettings->site_max_image_size }}"> 
              <div class="col-12">
                <div class="d-flex flex-wrap justify-content-between align-items-center">
                  <button class="btn btn-primary mt-3 mt-sm-0" type="submit">{{ __('Update profile') }}</button>
                </div>
              </div>
            </div>
          </form>
        </section>
      </div>
    </div>
@include('footer')
@include('script')
</body>
</html>