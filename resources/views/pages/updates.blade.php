<!DOCTYPE HTML>
<html lang="en">
<head>
<title>{{ __('Updates') }} - {{ $allsettings->site_title }}</title>
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
              <li class="breadcrumb-item text-nowrap active" aria-current="page">{{ __('Updates') }}</li>
            </ol>
          </nav>
        </div>
        <div class="order-lg-1 pr-lg-4 text-center text-lg-left">
          <h1 class="h3 mb-0 text-white">{{ __('Updates') }}</h1>
        </div>
      </div>
      </div>
    </section>
<div @if($custom_settings->theme_layout == 'container') class="container-fluid py-5 mt-md-2 mb-2" @else class="container py-5 mt-md-2 mb-2" @endif>
     @if(in_array('shop',$top_ads))
      <div class="row">
          <div class="col-lg-12 mb-4" align="center">
             @php echo html_entity_decode($allsettings->top_ads); @endphp
          </div>
       </div>   
       @endif
      <div class="row">
        <div class="col-lg-12" data-aos="fade-up" data-aos-delay="200">
           <h4 align="center">{{ __('Products Updated Today - Full Changelog') }}</h4>
           <p align="center">{{ __('We update our inventory daily even twice a day and on weekends too. Our inventory is growing and in the future, you can expect some increment in the price as well. So, make sure to join a good membership plan to save tons of money') }}</p>
           <table id="example" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>{{ __('Thumbnail') }}</th>
                                            <th>{{ __('Title') }}</th>
                                            <th>{{ __('Updated On') }}</th>
                                            <th>{{ __('Price') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    
                                    @foreach($updates as $product)
                                    @php
                                    $price = Helper::price_info($product->product_flash_sale,$product->regular_price);
                                    @endphp
                                        
                                        <tr class="tupdates">
                                            <td>
                                            <a href="{{ URL::to('/item') }}/{{ $product->product_slug }}">
                                            @if($product->product_image != '') <img src="{{ url('/') }}/public/storage/product/{{ $product->product_image }}" alt="{{ $product->product_name }}" class="image-size"/>@else <img src="{{ url('/') }}/public/img/no-image.jpg" alt="{{ $product->product_name }}" class="image-size"/>  @endif
                                            </a>
                                            </td>
                                            <td>
                                            <a href="{{ URL::to('/item') }}/{{ $product->product_slug }}">
                                            {{ mb_substr($product->product_name, 0, 200, 'UTF-8') }}
                                            </a>
                                            </td>
                                            <td>
                                            <a href="{{ URL::to('/item') }}/{{ $product->product_slug }}">
                                            {{ date("F j, Y",strtotime($product->product_update)) }}
                                            </a>
                                            </td>
                                            <td>
                                            <a href="{{ URL::to('/item') }}/{{ $product->product_slug }}" class="pricevalue">
                                            {{ $allsettings->site_currency_symbol }}{{ $price }}
                                            </a>
                                            </td>
                                        </tr>
                                        
                                   @endforeach     
                                        
                                    </tbody>
                                </table>
         </div>
      </div>
      @if(in_array('shop',$bottom_ads))
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