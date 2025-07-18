@if($allsettings->maintenance_mode == 0)
<!DOCTYPE HTML>
<html lang="en">
<head>
<title>{{ $allsettings->site_title }} - @if($custom_settings->verify_mode == 1) {{ __('Verify Purchase') }} @else {{ __('404 Not Found') }} @endif</title>
@include('meta')
@include('style')
</head>
<body>
@include('header')
@if($custom_settings->verify_mode == 1)
<section class="bg-position-center-top" style="background-image: url('{{ url('/') }}/public/storage/settings/{{ $allsettings->site_other_banner }}');">
      <div class="py-4">
        <div @if($custom_settings->theme_layout == 'container') class="container-fluid d-lg-flex justify-content-between py-2 py-lg-3" @else class="container d-lg-flex justify-content-between py-2 py-lg-3" @endif>
        <div class="order-lg-2 mb-3 mb-lg-0 pt-lg-2">
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb flex-lg-nowrap justify-content-center justify-content-lg-star">
              <li class="breadcrumb-item"><a class="text-nowrap" href="{{ URL::to('/') }}"><i class="dwg-home"></i>{{ __('Home') }}</a></li>
              <li class="breadcrumb-item text-nowrap active" aria-current="page">{{ __('Verify Purchase') }}</li>
            </ol>
          </nav>
        </div>
        <div class="order-lg-1 pr-lg-4 text-center text-lg-left">
          <h1 class="h3 mb-0 text-white">{{ __('Verify Purchase') }}</h1>
        </div>
      </div>
      </div>
    </section>
<div @if($custom_settings->theme_layout == 'container') class="container-fluid py-4 py-lg-5 my-4" @else class="container py-4 py-lg-5 my-4" @endif>
      @if(in_array('pages',$top_ads))
      <div class="row">
          <div class="col-lg-12 mb-4" align="center">
             @php echo html_entity_decode($allsettings->top_ads); @endphp
          </div>
       </div>   
       @endif
      <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10">
          <div class="card py-2 mt-4">
            <form method="POST" action="{{ route('verify') }}"  id="login_form" class="card-body needs-validation">
               @csrf 
              <div class="form-group">
                <label for="recover-email">{{ __('Enter Purchase Code') }}</label>
                <input class="form-control" type="text" id="recover-email" name="purchase_code" value="@if(!empty($purchase_code)){{ $purchase_code }}@endif"  data-bvalidator="required">
              </div>
              <button class="btn btn-primary" type="submit">{{ __('Verify Purchase') }}</button>
            </form>
          </div>
          @if($checkverify != 0)
          <div class="mt-4">
          <table class="table table-bordered">
             <thead>
             <tr>
                 <th>{{ __('Title') }}</th>
                 <th>{{ __('Value') }}</th>
             </tr> 
             </thead>
             <tbody>
             <tr>
             <td>{{ __('Product Name') }}</td>
             <td>{{ $sold->product_name }}</td>
             </tr>
             <tr>
             <td>{{ __('Order ID') }}</td><td>{{ $sold->purchase_token }}</td>
             </tr>
             <tr><td>{{ __('Purchase Date') }}</td><td>{{ date("d F Y", strtotime($sold->start_date)) }}</td>
             </tr>
             <tr>
             <td>{{ __('Buyer Name') }}</td><td>{{ $sold->name }}</td>
             </tr>
             <tr>
             <td>{{ __('License Type') }}</td><td class="captext">{{ $sold->license }} {{ __('License') }}</td>
             </tr>
             <tr>
             <td>{{ __('Supported Until') }}</td><td>{{ date("d F Y", strtotime($sold->end_date)) }}</td>
             </tr>
             </tbody>
             </table>
          </div>
          @endif
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
@else
@include('not-found')
@endif    
@include('footer')
@include('script')
</body>
</html>
@else
@include('503')
@endif