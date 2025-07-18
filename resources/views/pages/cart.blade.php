<!DOCTYPE HTML>
<html lang="en">
<head>
<title>{{ __('My Cart') }} - {{ $allsettings->site_title }}</title>
@include('meta')
@include('style')
</head>
<body>
@include('header')
@if($cart_count != 0) 
<div class="page-title-overlap pt-4" style="background-image: url('{{ url('/') }}/public/storage/settings/{{ $allsettings->site_other_banner }}');">
      <div class="container d-lg-flex justify-content-between py-2 py-lg-3">
        <div class="order-lg-2 mb-3 mb-lg-0 pt-lg-2">
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb flex-lg-nowrap justify-content-center justify-content-lg-star">
              <li class="breadcrumb-item"><a class="text-nowrap" href="{{ URL::to('/') }}"><i class="dwg-home"></i>{{ __('Home') }}</a></li>
              <li class="breadcrumb-item text-nowrap active" aria-current="page">{{ __('My Cart') }}</li>
              </li>
             </ol>
          </nav>
        </div>
        <div class="order-lg-1 pr-lg-4 text-center text-lg-left">
          <h1 class="h3 mb-0 text-white">{{ __('My Cart') }}</h1>
        </div>
      </div>
    </div>
<div class="container mb-5 pb-3">
      <div class="bg-light box-shadow-lg rounded-lg overflow-hidden">
        <div class="row">
          <!-- Content-->
          <section class="col-lg-8 pt-2 pt-lg-4 pb-4 mb-3">
            <div class="pt-2 px-4 pr-lg-0 pl-xl-5">
              <!-- Header-->
              <div class="d-flex flex-wrap justify-content-between align-items-center border-bottom pb-3">
                <div class="py-1"><a class="btn btn-outline-accent btn-sm" href="{{ url('/shop') }}"><i class="dwg-arrow-left mr-1 ml-n1"></i>{{ __('Back to shopping') }}</a></div>
                <div class="d-none d-sm-block py-1 font-size-ms">{{ __('You have') }} {{ $cart_count }} {{ __('products in your cart') }}</div>
                <div class="py-1"><a class="btn btn-outline-danger btn-sm" href="{{ url('/clear-cart') }}" onClick="return confirm('{{ __('Are you sure you want to clear cart') }}');"><i class="dwg-close font-size-xs mr-1 ml-n1"></i>{{ __('Clear cart') }}</a></div>
              </div>
              <!-- Product-->
              @php 
              $coupon_code = ""; 
              $subtotal = 0;
              $new_price = 0;
              $coupon_type = "";
              $coupon_value = 0; 
              @endphp
              @foreach($cart['item'] as $cart)
              @php
              if($cart->discount_price != 0)
              {
                   $price = $cart->discount_price;
                   $new_price += $cart->discount_price;
                   $coupon_code = $cart->coupon_code;
                   $coupon_type = $cart->coupon_type;
                   $coupon_value = $cart->coupon_value;
              }
              else
              {
                 $price = $cart->product_price;
                 $new_price += $cart->product_price;
                 $coupon_type = $cart->coupon_type;
                 $coupon_value = $cart->coupon_value;
              }
              @endphp 
              <div class="media d-block d-sm-flex align-items-center py-4 border-bottom">
              <a class="d-block position-relative mb-3 mb-sm-0 mr-sm-4 mx-auto cart-img" href="{{ url('/cart') }}/{{ base64_encode($cart->ord_id) }}" onClick="return confirm('{{ __('Are you sure you want to delete') }}?');">
              @if($cart->product_image!='')
              <img class="rounded-lg" src="{{ url('/') }}/public/storage/product/{{ $cart->product_image }}" alt="{{ $cart->product_name }}">
              @else
              <img src="{{ url('/') }}/public/img/no-image.png" alt="{{ $cart->product_name }}" width="70" class="rounded-lg">
              @endif
              <span class="close-floating" data-toggle="tooltip" title="Remove from Cart"><i class="dwg-close"></i></span></a>
                <div class="media-body text-center text-sm-left">
                  <h3 class="h6 product-title mb-2"><a href="{{ url('/item') }}/{{ $cart->product_slug }}">{{ $cart->product_name }}</a></h3>
                  <div class="d-inline-block text-accent">{{ $allsettings->site_currency_symbol }} {{ $cart->product_price }}</div><a class="d-inline-block text-accent font-size-ms border-left ml-2 pl-2" href="{{ url('/item') }}/{{ $cart->product_slug }}">{{ $cart->license }}@if($cart->license == 'regular') ({{ __('6 months') }}) @elseif($cart->license == 'extended') ({{ __('12 months') }}) @endif</a>
                </div>
              </div>
              @php $subtotal += $cart->product_price; @endphp
              @endforeach
            </div>
            <div class="float-right">
        <a class="btn btn-primary btn-shadow btn-block mt-4" href="{{ url('/checkout') }}"><i class="dwg-locked font-size-lg mr-2"></i>{{ __('Proceed To Checkout') }}</a>
        </div>
          </section>
          @php $total_price = $subtotal + $allsettings->site_extra_fee; @endphp
          <!-- Sidebar-->
          <aside class="col-lg-4">
            <hr class="d-lg-none">
            <div class="cz-sidebar-static h-100 ml-auto border-left">
              <ul class="list-unstyled font-size-sm pt-3 pb-2 border-bottom">
                  <li class="d-flex justify-content-between align-items-center"><span class="mr-2">{{ __('Sub total price') }}</span><span class="text-right">{{ $allsettings->site_currency_symbol }} {{ $subtotal }}</span></li>
                  @if($allsettings->site_extra_fee != 0)
                  <li class="d-flex justify-content-between align-items-center"><span class="mr-2">{{ __('Processing Fee') }}</span><span class="text-right">{{ $allsettings->site_currency_symbol }} {{ $allsettings->site_extra_fee }}</span></li>
                  @endif
                  @if($coupon_code != "")
                  @php 
                  $coupon_discount = $subtotal - $new_price;
                  $final = $new_price+$allsettings->site_extra_fee; 
                  @endphp
                  <li class="d-flex justify-content-between align-items-center"><span class="mr-2">{{ __('Discount Price') }}</span><span class="text-right"><strong class="green">( {{ $coupon_code }} )</strong> <a href="{{ URL::to('/cart/') }}/remove/{{ $coupon_code }}" class="red fs14" onClick="return confirm('Are you sure you want to delete?');" title="{{ __('Remove') }}"> <i class="dwg-close font-size-xs"></i> </a></span>{{ $allsettings->site_currency_symbol }} {{ $coupon_discount }}</span></li>
                  @else
                  @php $final = $subtotal+$allsettings->site_extra_fee; @endphp
                  @endif
                </ul>
              <div class="text-center mb-4 pb-3 border-bottom">
                <h2 class="h6 mb-3 pb-1">{{ __('Cart total') }}</h2>
                <h3 class="font-weight-normal">{{ $allsettings->site_currency_symbol }} {{ $final }}</h3>
              </div>
              <form action="{{ route('coupon') }}" class="setting_form" id="coupon_form" method="post" enctype="multipart/form-data">
              {{ csrf_field() }} 
              <div class="text-center mb-4 pb-3 border-bottom">
                <h2 class="h6 mb-3 pb-1">{{ __('Coupon Code') }}</h2>
                  <div class="form-group">
                    <input class="form-control" type="text" placeholder="{{ __('Coupon Code') }}" id="coupon" name="coupon" required>
                  </div>
                  <button class="btn btn-secondary btn-block" type="submit">{{ __('Apply Coupon') }}</button>
              </div>
             </form>
              <?php /*?><div class="text-center mb-4 pb-3 border-bottom">
                <h2 class="h6 mb-3 pb-1">Promo code</h2>
                <form class="needs-validation pb-2" method="post" novalidate>
                  <div class="form-group">
                    <input class="form-control" type="text" placeholder="Promo code" required>
                    <div class="invalid-feedback">Please provide promo code.</div>
                  </div>
                  <button class="btn btn-secondary btn-block" type="submit">Apply promo code</button>
                </form>
              </div><?php */?>
              <?php /*?><div class="text-center pt-2"><small class="text-form text-muted">{{ __('100% money back guarantee') }}</small></div><?php */?>
            </div>
          </aside>
        </div>
      </div>
    </div>
    @else
    <section class="bg-position-center-top" style="background-image: url('{{ url('/') }}/public/storage/settings/{{ $allsettings->site_other_banner }}');">
      <div class="py-4">
        <div class="container d-lg-flex justify-content-between py-2 py-lg-3">
        <div class="order-lg-2 mb-3 mb-lg-0 pt-lg-2">
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb flex-lg-nowrap justify-content-center justify-content-lg-star">
              <li class="breadcrumb-item"><a class="text-nowrap" href="{{ URL::to('/') }}"><i class="dwg-home"></i>{{ __('Home') }}</a></li>
              <li class="breadcrumb-item text-nowrap active" aria-current="page">{{ __('My Cart') }}</li>
            </ol>
          </nav>
        </div>
        <div class="order-lg-1 pr-lg-4 text-center text-lg-left">
          <h1 class="h3 mb-0 text-white">{{ __('My Cart') }}</h1>
        </div>
      </div>
      </div>
    </section>
<div class="container py-5 mt-md-2 mb-2">
      <div class="row">
        <div class="col-lg-12">
          <div class="font-size-md">{{ __('Your cart is empty') }}</div>
         </div>
      </div>
    </div>    
    @endif
@include('footer')
@include('script')
</body>
</html>