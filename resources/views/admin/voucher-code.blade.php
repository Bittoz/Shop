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
    @if($demo_mode == 'on')
                     @include('admin.demo-mode')
                     @else
                     <form action="{{ route('admin.voucher-code') }}" method="post" id="setting_form" enctype="multipart/form-data">
                     {{ csrf_field() }}
                     @endif
     <div class="breadcrumbs">
            <div class="col-sm-4">
                <div class="page-header float-left">
                    <div class="page-title">
                        <h1>{{ __('Prepaid Vouchers') }}</h1>
                    </div>
                </div>
            </div>
            <div class="col-sm-8">
                <div class="page-header float-right">
                    <div class="page-title">
                        <ol class="breadcrumb text-right">
                        <input type="submit" value="Export XLSX" name="action" class="btn btn-primary btn-sm ml-1">
                            <?php /*?><a href="{{ url('/admin/export-voucher-code/xlsx') }}" class="btn btn-primary btn-sm"><i class="fa fa-download"></i> {{ __('Export XLSX') }}</a><?php */?>&nbsp;
                            <a href="{{ url('/admin/add-voucher-code') }}" class="btn btn-success btn-sm"><i class="fa fa-plus"></i> {{ __('Add Voucher Code') }}</a>
                            <input type="submit" value="Delete All" name="action" class="btn btn-danger btn-sm ml-1" id="checkBtn" onClick="return confirm('Are you sure you want to delete?');">
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
                                <strong class="card-title">{{ __('Prepaid Vouchers') }}</strong>
                            </div>
                            <div class="card-body">
                                <table id="example" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th><input type="checkbox" id="selectAll"></th>
                                            <th>{{ __('Sno') }}</th>
                                            <th>{{ __('Voucher Code') }}</th>
                                            <th>{{ __('Redeemed User') }}</th>
                                            <th>{{ __('Price') }}</th>
                                            <th>{{ __('Bonus') }}</th>
                                            <th>{{ __('Status') }}</th>
                                            <th>{{ __('Create Date') }}</th>
                                            <th>{{ __('Expiry date') }}</th>
                                            <th>{{ __('Redemption Date') }}</th>
                                            <th>{{ __('Action') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @php $no = 1; @endphp
                                    @foreach($voucher as $code)
                                   
                                        <tr class="allChecked">
                                            <td><input type="checkbox" name="vid[]" value="{{ $code->voucher_token }}"/></td>
                                            <td>{{ $no }}</td>
                                            <td>{{ $code->voucher_code }} </td>
                                            <td>{{ Helper::Redeem_User($code->voucher_redeem_user_id) }} </td>
                                            <td>{{ $code->voucher_price }} {{ $allsettings->site_currency_code }}</td>
                                            <td>{{ $code->voucher_bonus }} {{ $allsettings->site_currency_code }}</td>
                                            <td>
                                            @if(strtotime($code->voucher_expiry_date) < strtotime(date('Y-m-d h:i:s')))
                                            <span class="badge badge-danger">{{ __('Expired') }}</span>
                                            @else
                                            @if($code->voucher_status == "Unused") <span class="badge badge-success">{{ $code->voucher_status }}</span> @else <span class="badge badge-danger">{{ $code->voucher_status }}</span> @endif
                                            @endif
                                            </td>
                                            <td>{{ $code->voucher_create_date }}</td>
                                            <td>{{ date("d-M-Y h:i a", strtotime($code->voucher_expiry_date)) }}</td> 
                                            <td>@if($code->voucher_redeem_date != ""){{ $code->voucher_redeem_date }}@else <span>---</span> @endif</td> 
                                            <td>
                                            <a href="{{ URL::to('/admin/voucher-info') }}/{{ $code->vid }}" class="btn btn-primary btn-sm"><i class="fa fa-eye"></i>&nbsp; {{ __('More Info') }}</a>
                                            @if($demo_mode == 'on') 
                                            <a href="{{ url('/admin') }}/demo-mode" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i>&nbsp;{{ __('Delete') }}</a>
                                            @else
                                            <a href="{{ url('/admin') }}/voucher-code/{{ $code->voucher_token }}" class="btn btn-danger btn-sm" onClick="return confirm('{{ __('Are you sure you want to delete') }}?');"><i class="fa fa-trash"></i>&nbsp;{{ __('Delete') }}</a>@endif
                                            </td>
                                        </tr>
                                        @php $no++; @endphp
                                    @endforeach     
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                  </div>
            </div><!-- .animated -->
        </div><!-- .content -->
        </form>
    </div><!-- /#right-panel -->
    @else
    @include('admin.denied')
    @endif
    <!-- Right Panel -->
   @include('admin.javascript')
   <script type="text/javascript">
      $(document).ready(function () { 
    var oTable = $('#example').dataTable({
        stateSave: true,
		responsive: true,
		dom: 'Bfrtip',
        buttons: [
                {
                    extend: 'copy',
                    exportOptions: {
                        columns: [1, 2, 3, 4, 5, 6, 7, 8, 9]
                    },
					className: 'ml-4 mr-1',
					filename: '{{ $allsettings->site_title }} - Voucher-code'
                },
                {
                    extend: 'csv',
                    exportOptions: {
                        columns: [1, 2, 3, 4, 5, 6, 7, 8, 9]
                    },
					className: 'mr-1',
					filename: '{{ $allsettings->site_title }} - Voucher-code'
                },
                {
                    extend: 'excel',
                    exportOptions: {
                        columns: [1, 2, 3, 4, 5, 6, 7, 8, 9]
                    },
					className: 'mr-1',
					filename: '{{ $allsettings->site_title }} - Voucher-code'
                },
				{
                    extend: 'pdf',
                    exportOptions: {
                        columns: [1, 2, 3, 4, 5, 6, 7, 8, 9]
                    },
					className: 'mr-1',
					filename: '{{ $allsettings->site_title }} - Voucher-code'
                },
				{
                    extend: 'print',
                    exportOptions: {
                        columns: [1, 2, 3, 4, 5, 6, 7, 8, 9]
                    },
					className: 'mr-1',
					filename: '{{ $allsettings->site_title }} - Voucher-code'
                }
                
            ]
    });

    var allPages = oTable.fnGetNodes();

    $('body').on('click', '#selectAll', function () {
        if ($(this).hasClass('allChecked')) {
            $('input[type="checkbox"]', allPages).prop('checked', false);
        } else {
            $('input[type="checkbox"]', allPages).prop('checked', true);
        }
        $(this).toggleClass('allChecked');
    })
});

      

$(document).ready(function () {
    $('#checkBtn').click(function() {
      checked = $("input[type=checkbox]:checked").length;

      if(!checked) {
        alert("You must check at least one checkbox.");
        return false;
      }

    });
	
	
	
	});

</script>
</body>
</html>