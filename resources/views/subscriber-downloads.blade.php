@if($allsettings->maintenance_mode == 1)
@if (Auth::check())
@if(Auth::user()->id == 1)
@if($allsettings->subscription_mode == 1)
@include('pages.subscriber-downloads')
@endif
@else
@include('503')
@endif
@else
@include('503')
@endif
@else
@if($allsettings->subscription_mode == 1)
@include('pages.subscriber-downloads')
@endif
@endif