@if($allsettings->maintenance_mode == 1)
@if (Auth::check())
@if(Auth::user()->id == 1)
@if($custom_settings->shop_search_type == 'normal')
@include('pages.shop-normal')
@else
@include('pages.shop-ajax')
@endif
@else
@include('503')
@endif
@else
@include('503')
@endif
@else
@if($custom_settings->shop_search_type == 'normal')
@include('pages.shop-normal')
@else
@include('pages.shop-ajax')
@endif
@endif