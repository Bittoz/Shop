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
    @if(in_array('manage-products',$avilable))
    <div id="right-panel" class="right-panel">

        
                       @include('admin.header')
                       

        <div class="breadcrumbs">
            <div class="col-sm-4">
                <div class="page-header float-left">
                    <div class="page-title">
                        <h1>{{ $product_details->product_name }} - {{ __('Rating & Reviews') }}</h1>
                    </div>
                </div>
            </div>
            <div class="col-sm-8">
                <div class="page-header float-right">
                     <ol class="breadcrumb text-right">
                            <a href="{{ url('/admin/products') }}" class="btn btn-primary btn-sm"><i class="fa fa-chevron-left"></i> {{ __('Back') }}</a>&nbsp;<a href="{{ url('/admin/add-reviews') }}/{{ $product_details->product_token }}" class="btn btn-success btn-sm"><i class="fa fa-plus"></i> {{ __('Add Reviews') }}</a>
                        </ol>
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
                                <strong class="card-title">{{ __('Rating & Reviews') }}</strong>
                            </div>
                            <div class="card-body">
                                <table id="bootstrap-data-table-export" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>{{ __('Sno') }}</th>
                                            <th>{{ __('Customers') }}</th>
                                            <th>{{ __('Rating') }}</th>
                                            <th>{{ __('Rating Reason') }}</th>
                                            <th>{{ __('Rating Comment') }}</th>
                                            <th>{{ __('Action') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @php $no = 1; @endphp
                                    @foreach($itemData['item'] as $rating)
                                        <tr>
                                            <td>{{ $no }}</td>
                                            <td>@if($rating->or_user_id == 0){{ $rating->or_username }}@else{{ Helper::Get_User_Name($rating->or_user_id) }}@endif</td>
                                            <td>{{ $rating->rating }} {{ __('Stars') }}</td>
                                            <td>{{ $rating->rating_reason }} </td>
                                            <td>{{ $rating->rating_comment }}</td>
                                            <td>
                                            <a href="{{ URL::to('/admin/edit-reviews') }}/{{ $rating->rating_id }}" class="btn btn-success btn-sm"><i class="fa fa-edit"></i>&nbsp; {{ __('Edit') }}</a> 
                                            @if($demo_mode == 'on') 
                                            <a href="{{ url('/admin') }}/demo-mode" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i>&nbsp;{{ __('Delete') }}</a>
                                            @else
                                            <a href="{{ URL::to('/admin/dropreviews') }}/{{ $rating->rating_id }}" class="btn btn-danger btn-sm" onClick="return confirm('Are you sure you want to delete?');"><i class="fa fa-close"></i>&nbsp; {{ __('Delete') }}</a>@endif
                                            
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
            </div>
        </div>


    </div>
    @else
    @include('admin.denied')
    @endif
    


   @include('admin.javascript')


</body>

</html>
