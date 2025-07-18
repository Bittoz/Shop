<!DOCTYPE HTML>
<html lang="en">
<head>
<title>{{ __('Shop') }} - {{ $allsettings->site_title }}</title>
@if($meta_allow == 1)
<meta name="keywords" content="{{ $meta_keyword }}">
<meta name="description" content="{{ $meta_desc }}">
@else
@include('meta')
@endif
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
              <li class="breadcrumb-item text-nowrap active" aria-current="page">{{ __('Shop') }}</li>
            </ol>
          </nav>
        </div>
        <div class="order-lg-1 pr-lg-4 text-center text-lg-left">
          <h1 class="h3 mb-0 text-white">{{ __('Shop') }}</h1>
        </div>
      </div>
      </div>
    </section>
<div @if($custom_settings->theme_layout == 'container') class="container-fluid py-5 mt-md-2 mb-2" @else class="container py-5 mt-md-2 mb-2" @endif>
      <div class="row pt-3 mx-n2">
         <aside class="col-12 col-xs-6 col-sm-12 col-md-4 col-lg-3">
          <!-- Sidebar-->
          <form action="{{ route('shop') }}" id="search_form2" method="post"  enctype="multipart/form-data">
          {{ csrf_field() }}
          <div class="cz-sidebar rounded-lg box-shadow-lg" id="shop-sidebar">
            <div class="cz-sidebar-header box-shadow-sm">
              <button class="close ml-auto" type="button" data-dismiss="sidebar" aria-label="Close"><span class="d-inline-block font-size-xs font-weight-normal align-middle">{{ __('Close sidebar') }}</span><span class="d-inline-block align-middle ml-2" aria-hidden="true">&times;</span></button>
            </div>
            <div class="cz-sidebar-body" data-simplebar data-simplebar-auto-hide="true">
              <!-- Categories-->
              <div class="widget cz-filter mb-4 pb-4 border-bottom">
                <h3 class="widget-title">{{ __('Categories') }}</h3>
                <div class="input-group-overlay input-group-sm mb-2">
                  <input class="cz-filter-search form-control form-control-sm appended-form-control" type="text" placeholder="Search">
                  <div class="input-group-append-overlay"><span class="input-group-text"><i class="dwg-search"></i></span></div>
                </div>
                <?php /*?>@if(count($category['view']) != 0)
                <ul class="widget-list cz-filter-list list-unstyled pt-1" style="max-height: 12rem;" data-simplebar data-simplebar-auto-hide="false">
                  @foreach($category['view'] as $cat)
                  <li class="cz-filter-item d-flex justify-content-between align-items-center mb-1">
                    <div class="custom-control custom-checkbox">
                      <input class="custom-control-input" type="checkbox" id="{{ $cat->cat_id }}" name="category_names[]" value="{{ $cat->cat_id }}">
                      <label class="custom-control-label cz-filter-item-text" for="{{ $cat->cat_id }}">{{ $cat->category_name }}</label>
                    </div><span class="font-size-xs text-muted">{{ $count_item->has($cat->cat_id) ? count($count_item[$cat->cat_id]) : 0 }}</span>
                  </li>
                  @endforeach 
                </ul>
                @endif<?php */?>
                @if(count($category['view']) != 0)
                <ul class="widget-list cz-filter-list list-unstyled pt-1" style="max-height: 12rem;" data-simplebar data-simplebar-auto-hide="false">
                  @foreach($category['view'] as $cat)
                  <li class="cz-filter-item d-flex justify-content-between align-items-center mb-1">
                    <div class="custom-control custom-checkbox">
                      <input class="custom-control-input" type="checkbox" id="{{ $cat->cat_id }}" name="category_names[]" value="{{ 'category_'.$cat->cat_id }}">
                      <label class="custom-control-label cz-filter-item-text" for="{{ $cat->cat_id }}">{{ $cat->category_name }}</label>
                      @foreach($cat->subcategory as $sub_category)
                      <br/>
                      <span class="ml-2"><input class="custom-control-input" type="checkbox" id="{{ $sub_category->subcat_id }}" name="category_names[]" value="{{ 'subcategory_'.$sub_category->subcat_id }}">
                      <label class="custom-control-label cz-filter-item-text" for="{{ $sub_category->subcat_id }}">{{ $sub_category->subcategory_name }}</label>
                      </span>
                      @endforeach
                    </div>
                    
                  </li>
                  @endforeach 
                </ul>
                @endif
              </div>
              <div class="widget cz-filter mb-4 pb-4 border-bottom">
                <h3 class="widget-title">{{ __('Sort by') }}</h3>
                <div class="input-group-overlay input-group-sm mb-2">
                  <select class="cz-filter-search form-control form-control-sm appended-form-control" name="orderby">
                  <option value="desc">{{ __('Default') }}</option>
                  <option value="asc">{{ __('Price : Low to High') }}</option>
                  <option value="desc">{{ __('Price : High to low') }}</option>
                 </select>            
                </div>
              </div>
              <!-- Price range-->
              <div class="widget mb-4 pb-4 border-bottom">
                <h3 class="widget-title">{{ __('Price') }}</h3>
                <div class="cz-range-slider" data-start-min="{{ $minprice['price']->regular_price }}" data-start-max="{{ $maxprice['price']->extended_price }}" data-min="{{ $allsettings->site_range_min_price }}" data-max="{{ $allsettings->site_range_max_price }}" data-step="1">
                  <div class="cz-range-slider-ui"></div>
                  <div class="d-flex pb-1">
                    <div class="w-50 pr-2 mr-2">
                      <div class="input-group input-group-sm">
                        <div class="input-group-prepend"><span class="input-group-text">{{ $allsettings->site_currency_symbol }}</span></div>
                        <input class="form-control cz-range-slider-value-min" type="text" name="min_price">
                      </div>
                    </div>
                    <div class="w-50 pl-2">
                      <div class="input-group input-group-sm">
                        <div class="input-group-prepend"><span class="input-group-text">{{ $allsettings->site_currency_symbol }}</span></div>
                        <input class="form-control cz-range-slider-value-max" type="text" name="max_price">
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="input-group-append">
                  <button class="btn btn-primary btn-sm font-size-base" type="submit">{{ __('Search') }}</button>
             </div>
              <!-- Filter by Brand-->
              @if(in_array('shop',$sidebar_ads))
           <div class="mt-4" align="center">
           @php echo html_entity_decode($allsettings->sidebar_ads); @endphp
           </div>
           @endif
           </div>
          </div>
          </form>
        </aside>
        <div class="col-12 col-xs-6 col-sm-12 col-md-8 col-lg-9">
         <div class="row pt-2 mx-n2">
         @if(in_array('shop',$top_ads))
          <div class="mt-2 mb-2" align="center">
             @php echo html_entity_decode($allsettings->top_ads); @endphp
          </div>
          @endif
        <!-- Product-->
        @if(count($itemData['item']) != 0)
        @php $no = 1; @endphp
        @foreach($itemData['item'] as $featured)
        @php
        $price = Helper::price_info($featured->product_flash_sale,$featured->regular_price);
        $count_rating = Helper::count_rating($featured->ratings);
        @endphp
        <div @if($custom_settings->theme_layout == 'container') class="col-6 col-xs-6 col-sm-6 col-md-4 col-lg-3 px-2 mb-3 prod-item" @else class="col-6 col-xs-6 col-sm-6 col-md-4 col-lg-4 px-2 mb-3 prod-item" @endif>
          <!-- Product-->
          <div class="card product-card-alt">
            <div class="product-thumb">
              @if(Auth::guest()) 
              <a class="btn-wishlist btn-sm" href="{{ URL::to('/login') }}"><i class="dwg-heart"></i></a>
              @endif
              @if (Auth::check())
              @if($featured->user_id != Auth::user()->id)
              <a class="btn-wishlist btn-sm" href="{{ url('/item') }}/{{ base64_encode($featured->product_id) }}/favorite/{{ base64_encode($featured->product_liked) }}"><i class="dwg-heart"></i></a>
              @endif
              @endif
              <div class="product-card-actions"><a class="btn btn-light btn-icon btn-shadow font-size-base mx-2" href="{{ URL::to('/item') }}/{{ $featured->product_slug }}"><i class="dwg-eye"></i></a>
              @php
              $checkif_purchased = Helper::if_purchased($featured->product_token);
              @endphp
              @if($checkif_purchased == 0)
              @if (Auth::check())
              @if(Auth::user()->id != 1)
              <a class="btn btn-light btn-icon btn-shadow font-size-base mx-2" href="{{ URL::to('/add-to-cart') }}/{{ $featured->product_slug }}"><i class="dwg-cart"></i></a>
              @endif
              @else
              <a class="btn btn-light btn-icon btn-shadow font-size-base mx-2" href="{{ URL::to('/add-to-cart') }}/{{ $featured->product_slug }}"><i class="dwg-cart"></i></a>
              @endif
              @endif  
              </div><a class="product-thumb-overlay" href="{{ URL::to('/item') }}/{{ $featured->product_slug }}"></a>
              @if($featured->product_image!='')
              <img src="{{ url('/') }}/public/storage/product/{{ $featured->product_image }}" alt="{{ $featured->product_name }}">
              @else
              <img src="{{ url('/') }}/public/img/no-image.png" alt="{{ $featured->product_name }}">
              @endif
            </div>
            <div class="card-body">
              <div class="d-flex flex-wrap justify-content-between align-items-start pb-2">
                <div class="text-muted font-size-xs mr-1"><a class="product-meta font-weight-medium" href="{{ URL::to('/shop') }}/category/{{ Helper::id_toget_category($featured->product_category_parent,'category_slug') }}">{{ Helper::id_toget_category($featured->product_category_parent,'category_name') }}</a></div>
                <div class="star-rating">
                    @if($count_rating == 0)
                    <i class="sr-star dwg-star"></i>
                    <i class="sr-star dwg-star"></i>
                    <i class="sr-star dwg-star"></i>
                    <i class="sr-star dwg-star"></i>
                    <i class="sr-star dwg-star"></i>
                    @endif
                    @if($count_rating == 1)
                    <i class="sr-star dwg-star-filled active"></i>
                    <i class="sr-star dwg-star"></i>
                    <i class="sr-star dwg-star"></i>
                    <i class="sr-star dwg-star"></i>
                    <i class="sr-star dwg-star"></i>
                    @endif
                    @if($count_rating == 2)
                    <i class="sr-star dwg-star-filled active"></i>
                    <i class="sr-star dwg-star-filled active"></i>
                    <i class="sr-star dwg-star"></i>
                    <i class="sr-star dwg-star"></i>
                    <i class="sr-star dwg-star"></i>
                    @endif
                    @if($count_rating == 3)
                    <i class="sr-star dwg-star-filled active"></i>
                    <i class="sr-star dwg-star-filled active"></i>
                    <i class="sr-star dwg-star-filled active"></i>
                    <i class="sr-star dwg-star"></i>
                    <i class="sr-star dwg-star"></i>
                    @endif
                    @if($count_rating == 4)
                    <i class="sr-star dwg-star-filled active"></i>
                    <i class="sr-star dwg-star-filled active"></i>
                    <i class="sr-star dwg-star-filled active"></i>
                    <i class="sr-star dwg-star-filled active"></i>
                    <i class="sr-star dwg-star"></i>
                    @endif
                    @if($count_rating == 5)
                    <i class="sr-star dwg-star-filled active"></i>
                    <i class="sr-star dwg-star-filled active"></i>
                    <i class="sr-star dwg-star-filled active"></i>
                    <i class="sr-star dwg-star-filled active"></i>
                    <i class="sr-star dwg-star-filled active"></i>
                    @endif
                </div>
               </div>
              <h3 class="product-title font-size-sm mb-2 title"><a href="{{ URL::to('/item') }}/{{ $featured->product_slug }}">{{ $featured->product_name }}</a></h3>
              <div class="d-flex flex-wrap justify-content-between align-items-center">
                <div class="font-size-sm mr-2">
                @if($custom_settings->product_sale_count == 1)
                <i class="dwg-download text-muted mr-1"></i>{{ $featured->product_sold }}<span class="font-size-xs ml-1">{{ __('Sales') }}</span>
                @endif
                </div>
                <div>@if($featured->product_flash_sale == 1)<del class="price-old">{{ $allsettings->site_currency_symbol }}{{ $featured->regular_price }}</del>@endif <span class="bg-faded-accent text-accent rounded-sm py-1 px-2">{{ $allsettings->site_currency_symbol }}{{ $price }}</span></div>
              </div>
            </div>
          </div>
        </div>
        <!-- Product-->
        @php $no++; @endphp
	    @endforeach
       </div>
       @if($method == 'get')
       {{ $itemData['item']->links('pagination::bootstrap-4') }}
       @endif
       <?php /*?><div class="text-right">
            <div class="turn-page" id="itempager"></div>
       </div><?php */?>
       @if(in_array('shop',$bottom_ads))
       <div class="mt-3 mb-4 pb-4" align="center">
         @php echo html_entity_decode($allsettings->bottom_ads); @endphp
       </div>
       @endif
       @else
       <div>{{ __('No product found') }}</div>
       @endif
       </div>
        </div>
      </div>
    </div>
@include('footer')
@include('script')
</body>
</html>