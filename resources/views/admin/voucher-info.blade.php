<!doctype html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js" lang="en">
<!--<![endif]-->
<head>
@include('admin.stylesheet')
</head>
<body>
    @include('admin.navigation')
    <!-- Right Panel -->
    @if(in_array('voucher',$avilable)) 
    <div id="right-panel" class="right-panel">
    @include('admin.header')
      <div class="breadcrumbs">
            <div class="col-sm-4">
                <div class="page-header float-left">
                    <div class="page-title">
                        <h1>{{ __('More Info') }}</h1>
                    </div>
                </div>
            </div>
            <div class="col-sm-8">
                <div class="page-header float-right">
                    <div class="page-title">
                        <ol class="breadcrumb text-right">
                            <a href="{{ url('/admin/voucher-code') }}/" class="btn btn-success btn-sm"><i class="fa fa-chevron-left"></i> {{ __('Back') }}</a>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        @include('admin.warning')
        <div class="content mt-3">
            <div class="animated fadeIn">
                <div class="row">
                  <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <strong class="card-title" v-if="headerText">{{ __('More Info') }}</strong>
                        </div>
                        <div class="card-body p-0">
                            <table class="table table-hover table-striped table-align-middle mb-0">
                                <tbody>
                                    <tr>
                                        <td>
                                            {{ __('Voucher Code') }}
                                        </td>
                                        
                                        <td>
                                            {{ $voucher->voucher_code }}
                                        </td>
                                    </tr>
                                    
                                    <tr>
                                        <td>
                                            {{ __('Price') }}
                                        </td>
                                        
                                        <td>
                                            {{ $voucher->voucher_price }} {{ $allsettings->site_currency_code }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            {{ __('Bonus') }}
                                        </td>
                                        
                                        <td>
                                            {{ $voucher->voucher_bonus }} {{ $allsettings->site_currency_code }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            {{ __('Status') }}
                                        </td>
                                        
                                        <td>
                                        @if(strtotime($voucher->voucher_expiry_date) < strtotime(date('Y-m-d h:i:s')))
                                        {{ __('Expired') }}
                                        @else
                                            {{ $voucher->voucher_status }}
                                        @endif    
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            {{ __('Create Date') }}
                                        </td>
                                        
                                        <td>
                                            {{ $voucher->voucher_create_date }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            {{ __('Expiry date') }}
                                        </td>
                                        
                                        <td>
                                            {{ date("d-M-Y h:i a", strtotime($voucher->voucher_expiry_date)) }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            {{ __('Redemption Date') }}
                                        </td>
                                        
                                        <td>
                                            @if($voucher->voucher_redeem_date != ""){{ $voucher->voucher_redeem_date }}@else <span>---</span> @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            {{ __('Redeemed User') }}
                                        </td>
                                        
                                        <td>
                                            @if($redeem_user != ""){{ $redeem_user }}@else <span>---</span> @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            {{ __('Note') }}
                                        </td>
                                        
                                        <td>
                                            {{ $voucher->voucher_notes }}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
              </div>
            </div>
        </div>
    </div>
    @else
    @include('admin.denied')
    @endif
    @include('admin.javascript')
</body>
</html>