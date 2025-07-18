<div id="right-panel" class="right-panel">
@include('admin.header')
@if($view_name == 'admin-index')
@else
<h1 align="center" class="display-404">{{ __('404') }}</h1>
<h3 align="center" class="mt-3 pt-3">{{ __('We can not seem to find the page you are looking for') }}</h3>
@endif
</div>