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
    @if(Auth::user()->id == 1)
    <div id="right-panel" class="right-panel">
      @include('admin.header')
      @if($demo_mode == 'on')
      @include('admin.demo-mode')
      @else
      <form action="{{ route('admin.administrator') }}" method="post" id="setting_form" enctype="multipart/form-data">
      {{ csrf_field() }}
      @endif
       <div class="breadcrumbs">
            <div class="col-sm-4">
                <div class="page-header float-left">
                    <div class="page-title">
                        <h1>{{ __('Sub Administrators') }}</h1>
                    </div>
                </div>
            </div>
            <div class="col-sm-8">
                <div class="page-header float-right">
                    <div class="page-title">
                        <ol class="breadcrumb text-right">
                            <a href="{{ url('/admin/add-administrator') }}" class="btn btn-success btn-sm"><i class="fa fa-plus"></i> {{ __('Add Sub Administrator') }}</a>
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
                                <strong class="card-title">{{ __('Sub Administrators') }}</strong>
                            </div>
                            <div class="card-body">
                                <table id="example" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th><input type="checkbox" id="selectAll"></th>
                                            <th>{{ __('Sno') }}</th>
                                            <th>{{ __('Name') }}</th>
                                            <th>{{ __('Email') }}</th>
                                            <th>{{ __('Photo') }}</th>
                                            <th>{{ __('Action') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @php $no = 1; @endphp
                                    @foreach($userData['data'] as $user)
                                        <tr class="allChecked">
                                            <td><input type="checkbox" name="user_token[]" value="{{ $user->user_token }}"/></td>
                                            <td>{{ $no }}</td>
                                            <td>{{ $user->name }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td>@if($user->user_photo != '') <img height="50" src="{{ url('/') }}/public/storage/users/{{ $user->user_photo }}" alt="{{ $user->name }}" class="userphoto"/>@else <img height="50" src="{{ url('/') }}/public/img/no-user.png" alt="{{ $user->name }}" class="userphoto"/>  @endif</td>
                                            <td><a href="{{ url('/admin') }}/edit-administrator/{{ $user->user_token }}" class="btn btn-success btn-sm"><i class="fa fa-edit"></i>&nbsp; {{ __('Edit') }}</a> 
                                            @if($demo_mode == 'on') 
                                            <a href="{{ URL::to('/admin/demo-mode') }}" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i>&nbsp;{{ __('Delete') }}</a>
                                            @else
                                            <a href="{{ url('/admin') }}/administrator/{{ $user->user_token }}" class="btn btn-danger btn-sm" onClick="return confirm('Are you sure you want to delete?');"><i class="fa fa-trash"></i>&nbsp;{{ __('Delete') }}</a>
                                            @endif
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
					filename: '{{ $allsettings->site_title }} - Administrator'
                },
                {
                    extend: 'csv',
                    exportOptions: {
                        columns: [1, 2, 3]
                    },
					className: 'mr-1',
					filename: '{{ $allsettings->site_title }} - Administrator'
                },
                {
                    extend: 'excel',
                    exportOptions: {
                        columns: [1, 2, 3]
                    },
					className: 'mr-1',
					filename: '{{ $allsettings->site_title }} - Administrator'
                },
				{
                    extend: 'pdf',
                    exportOptions: {
                        columns: [1, 2, 3]
                    },
					className: 'mr-1',
					filename: '{{ $allsettings->site_title }} - Administrator'
                },
				{
                    extend: 'print',
                    exportOptions: {
                        columns: [1, 2, 3]
                    },
					className: 'mr-1',
					filename: '{{ $allsettings->site_title }} - Administrator'
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