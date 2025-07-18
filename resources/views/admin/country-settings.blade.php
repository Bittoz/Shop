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
    @if(in_array('settings',$avilable))
    <div id="right-panel" class="right-panel">

        
                       @include('admin.header')
                       @if($demo_mode == 'on')
                     @include('admin.demo-mode')
                     @else
                     <form action="{{ route('admin.country-settings') }}" method="post" id="setting_form" enctype="multipart/form-data">
                     {{ csrf_field() }}
                     @endif
                       
        <div class="breadcrumbs">
            <div class="col-sm-4">
                <div class="page-header float-left">
                    <div class="page-title">
                        <h1>{{ __('Country') }}</h1>
                    </div>
                </div>
            </div>
            <div class="col-sm-8">
                <div class="page-header float-right">
                    <div class="page-title">
                        <ol class="breadcrumb text-right">
                            <a href="{{ url('/admin/add-country') }}" class="btn btn-success btn-sm"><i class="fa fa-plus"></i> {{ __('Add Country') }}</a>
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
                                <strong class="card-title">{{ __('Default VAT') }}(%)</strong>
                            </div>
                             <div class="card-body">
                                 @if($demo_mode == 'on')
                                 @include('admin.demo-mode')
                                 @else
                                 <form action="{{ route('admin.vat') }}" method="post" id="setting_form" enctype="multipart/form-data">
                                 {{ csrf_field() }}
                                 @endif
                                  
                                 <div class="col-md-6">
                                 
                                   
                                  <div class="form-group">
                                                <label for="name" class="control-label mb-1">{{ __('Default VAT') }}(%) </label>
                                                <input id="default_vat_price" name="default_vat_price" type="text" class="form-control" value="{{ $custom_settings->default_vat_price }}" data-bvalidator="number,min[0],required">
                                            </div> 
                                            
                                      </div>
                                      
                                      <div class="col-md-6">      
                                            
                                             
                                        </div>
                                        
                                        
                                        <div class="col-md-12">    
                                
                                                        <button type="submit" name="submit" class="btn btn-primary btn-sm">
                                                            <i class="fa fa-dot-circle-o"></i> {{ __('Submit') }}
                                                        </button>
                                                       
                                                 
                                                 </div>   
                     </form>
                     </div>
                     </div>                   
                </div>
                </div>
                <div class="row">

                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <strong class="card-title">{{ __('Country') }}</strong>
                            </div>
                            <div class="card-body">
                                <table id="example" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th><input type="checkbox" id="selectAll"></th>
                                            <th>{{ __('Sno') }}</th>
                                            <th>{{ __('Name') }}</th>
                                            <th>{{ __('VAT') }}(%)</th>
                                            <th>{{ __('Action') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @php $no = 1; @endphp
                                    @foreach($country['data'] as $country)
                                        <tr class="allChecked">
                                            <td><input type="checkbox" name="country_id[]" value="{{ $country->country_id }}"/></td>
                                            <td>{{ $no }}</td>
                                            <td>{{ $country->country_name }}</td>
                                            <td>@if(!empty($country->vat_price)){{ $country->vat_price }}@else<span>0</span>@endif%</td>
                                            <td><a href="edit-country/{{ $country->country_id }}" class="btn btn-success btn-sm"><i class="fa fa-edit"></i>&nbsp; {{ __('Edit') }}</a> 
                                            @if($demo_mode == 'on') 
                                            <a href="demo-mode" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i>&nbsp;{{ __('Delete') }}</a>
                                            @else
                                            <a href="country-settings/{{ $country->country_id }}" class="btn btn-danger btn-sm" onClick="return confirm('Are you sure you want to delete?');"><i class="fa fa-trash"></i>&nbsp;{{ __('Delete') }}</a>@endif
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
                        columns: [1, 2, 3]
                    },
					className: 'ml-4 mr-1',
					filename: '{{ $allsettings->site_title }} - Country-settings'
                },
                {
                    extend: 'csv',
                    exportOptions: {
                        columns: [1, 2, 3]
                    },
					className: 'mr-1',
					filename: '{{ $allsettings->site_title }} - Country-settings'
                },
                {
                    extend: 'excel',
                    exportOptions: {
                        columns: [1, 2, 3]
                    },
					className: 'mr-1',
					filename: '{{ $allsettings->site_title }} - Country-settings'
                },
				{
                    extend: 'pdf',
                    exportOptions: {
                        columns: [1, 2, 3]
                    },
					className: 'mr-1',
					filename: '{{ $allsettings->site_title }} - Country-settings'
                },
				{
                    extend: 'print',
                    exportOptions: {
                        columns: [1, 2, 3]
                    },
					className: 'mr-1',
					filename: '{{ $allsettings->site_title }} - Country-settings'
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
