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
      <div id="demo">
      <div class="row pt-3 mx-n2">
         <div class="col-12 col-xs-6 col-sm-12 col-md-4 col-lg-3 jplist-panel">
          <!-- Sidebar-->
          <div class="cz-sidebar rounded-lg box-shadow-lg" id="shop-sidebar">
            <div class="cz-sidebar-header box-shadow-sm">
              <button class="close ml-auto" type="button" data-dismiss="sidebar" aria-label="Close"><span class="d-inline-block font-size-xs font-weight-normal align-middle">{{ __('Close sidebar') }}</span><span class="d-inline-block align-middle ml-2" aria-hidden="true">&times;</span></button>
            </div>
            <div class="cz-sidebar-body" data-simplebar data-simplebar-auto-hide="true">
              
              <!-- Filter by Brand-->
              
			  <!-- Categories-->
              <div class="widget cz-filter mb-4 pb-4 border-bottom">
                <h3 class="widget-title">{{ __('Categories') }}</h3>
                <div class="input-group-overlay input-group-sm mb-2">
                  <input class="cz-filter-search form-control form-control-sm appended-form-control" type="text" placeholder="{{ __('Search') }}">
                  <div class="input-group-append-overlay"><span class="input-group-text"><i class="dwg-search"></i></span></div>
                </div>
                @if(count($category['view']) != 0)
                <div 
                    class="jplist-group"
                    data-control-type="checkbox-group-filter"
						   data-control-action="filter"
						   data-control-name="categorysearch">
                <ul class="widget-list cz-filter-list list-unstyled pt-1" style="max-height: 12rem;" data-simplebar data-simplebar-auto-hide="false">
                  @foreach($category['view'] as $cat)
                  <li class="cz-filter-item d-flex justify-content-between align-items-center">
                      <div class="custom-control custom-checkbox">
                      <input id="{{ 'category_'.$cat->cat_id }}" data-path=".{{ 'category_'.$cat->cat_id }}" type="checkbox" class="custom-control-input" >
                      <label class="custom-control-label cz-filter-item-text" for="{{ 'category_'.$cat->cat_id }}">{{ $cat->category_name }}</label>
                      @foreach($cat->subcategory as $sub_category)
                      <br/>
                      <span class="ml-2"><input id="{{ 'subcategory_'.$sub_category->subcat_id }}" data-path=".{{ 'subcategory_'.$sub_category->subcat_id }}" type="checkbox" class="custom-control-input" >
                      <label class="custom-control-label cz-filter-item-text" for="{{ 'subcategory_'.$sub_category->subcat_id }}">{{ $sub_category->subcategory_name }}</label>
                      </span>
                      @endforeach
                    </div>
                  </li>
                  @endforeach 
                </ul>
                </div>
                @endif
              </div>
              <div class="widget cz-filter mb-4 pb-4 border-bottom">
                <h3 class="widget-title">{{ __('Sort By') }}</h3>
                    <div 
                      data-control-type="sort-buttons-group"
                      data-control-name="sort-buttons-group-1"
                      data-control-action="sort"
                      data-mode="single">
                         <div class="custom-control custom-radio">
                         <input type="radio"
                            data-path=".popular-items"
                            data-type="number"
                            data-order="asc"
                            data-selected="true" name="jplist" id="popular-items" class="custom-control-input swroll" checked>
                            <label class="custom-control-label" for="popular-items">{{ __('Popular Items') }}</label>
                        </div>
                        <div class="custom-control custom-radio">
                         <input type="radio"
                            data-path=".new-items"
                            data-type="number"
                            data-order="desc"  name="jplist" id="new-items" class="custom-control-input swroll">
                                <label class="custom-control-label" for="new-items">{{ __('New Items') }}</label>
                       
                           </div>
                         <div class="custom-control custom-radio">
                      <input data-control-type="radio-buttons-filters" data-control-action="filter" data-control-name="free-items" data-path=".free-items" id="free-items" type="radio" name="jplist" class="custom-control-input swroll"/>
                      <label class="custom-control-label" for="free-items">{{ __('Free Items') }}</label>
                    </div>
                  </div>
               </div>
               <div class="widget cz-filter mb-4 pb-4 border-bottom">
                <h3 class="widget-title">{{ __('Order By') }}</h3>
                    <div 
                      data-control-type="sort-buttons-group"
                      data-control-name="sort-buttons-group-1"
                      data-control-action="sort"
                      data-mode="single">
                         <div class="custom-control custom-radio">
                         <input type="radio"
                            data-path=".like"
                            data-type="number"
                            data-order="asc"
                            data-selected="true" name="jplist1" id="orderbyasc" class="custom-control-input swroll">
                            <label class="custom-control-label" for="orderbyasc">{{ __('Price : Low to High') }}</label>
                        </div>
                        <div class="custom-control custom-radio">
                         <input type="radio"
                            data-path=".like"
                            data-type="number"
                            data-order="desc"  name="jplist1" id="orderbydesc" class="custom-control-input swroll">
                                <label class="custom-control-label" for="orderbydesc">{{ __('Price : High to low') }}</label>
                       
                           </div>
                         
                  </div>
               </div>
              <!-- Price range-->
              @if(count($itemData['item']) != 0)
              <div class="widget mb-4 pb-4 border-bottom">
                <h3 class="widget-title">{{ __('Price') }}</h3>
                <?php /*?><div class="cz-range-slider" data-start-min="{{ $minprice['price']->regular_price }}" data-start-max="{{ $maxprice['price']->extended_price }}" data-min="{{ $allsettings->site_range_min_price }}" data-max="{{ $allsettings->site_range_max_price }}" data-step="1"><?php */?>
                <div data-start-min="{{ $minprice['price']->regular_price }}" data-start-max="{{ $maxprice['price']->extended_price }}" data-min="{{ $allsettings->site_range_min_price }}" data-max="{{ $allsettings->site_range_max_price }}" data-step="1">
                  <div class="demo">
                      <input type="text" id="amount" class="range-price" />
                       <div id="slider-range"></div>
                        </div>
                  <div id="slider-range-min"></div>
                 </div>
              </div>
              @endif
             @if(in_array('shop',$sidebar_ads))
           <div class="mt-4" align="center">
           @php echo html_entity_decode($allsettings->sidebar_ads); @endphp
           </div>
           @endif
              <!-- Filter by Brand-->
           </div>
          </div>
        </div>
        <div class="col-12 col-xs-6 col-sm-12 col-md-8 col-lg-9">
          <div class="row pt-2 mx-n2 flash-sale list items box">
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
        <div @if($custom_settings->theme_layout == 'container') class="col-6 col-xs-6 col-sm-6 col-md-4 col-lg-3 px-2 mb-3 list-item box" @else class="col-6 col-xs-6 col-sm-6 col-md-4 col-lg-4 px-2 mb-3 list-item box" @endif data-price="{{ $price }}">
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
              <span class="{{ $featured->product_type_cat_id }}" style="display:none;">{{ $featured->product_type_cat_id }}</span>
              <span class="popular-items" style="display:none;">{{ $featured->product_liked }}</span>
              <span class="new-items" style="display:none;">{{ $featured->product_id }}</span>
              @if($featured->product_free == 1)
              <span class="free-items" style="display:none;">{{ $featured->product_free }}</span>
              @endif
              <span class="like" style="display:none;">{{ $price }}</span>
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
       <div class="row">
                <div class="col-md-12" align="right">
                <div class="jplist-panel box panel-top">						
							
						<div 
						   class="jplist-label customlable" 
						   data-type="Page {current} of {pages}" 
						   data-control-type="pagination-info" 
						   data-control-name="paging" 
						   data-control-action="paging">
						</div>	

						<div 
						   class="jplist-pagination" 
						   data-control-type="pagination" 
						   data-control-name="paging" 
						   data-control-action="paging"
						   data-items-per-page="{{ $allsettings->product_per_page }}">
						</div>			
						
					</div>
                    <!--<div class="pagination-area">
                           <div class="turn-page" id="pager"></div>
                        </div>-->
                </div>
            </div>
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
    </div>
@include('footer')
@include('script')
</body>
</html>