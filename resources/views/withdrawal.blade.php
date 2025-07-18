@if($allsettings->maintenance_mode == 1)
@if (Auth::check())
@if(Auth::user()->id == 1)
@if($allsettings->site_withdrawal_display == 1)
@include('pages.withdrawal')
@else
@include('404')
@endif
@else
@include('503')
@endif
@else
@include('503')
@endif
@else
@include('pages.withdrawal')
@endif