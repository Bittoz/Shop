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
    @if(in_array('orders',$avilable))
    <div id="right-panel" class="right-panel">

        
                       @include('admin.header')
                       

        <div class="breadcrumbs">
            <div class="col-sm-4">
                <div class="page-header float-left">
                    <div class="page-title">
                        <h1>{{ __('Order Details') }}</h1>
                    </div>
                </div>
            </div>
            <div class="col-sm-8">
                <div class="page-header float-right">
                    <div class="page-title">
                        <ol class="breadcrumb text-right">
                            <a href="{{ url('/admin/orders') }}" class="btn btn-success btn-sm"><i class="fa fa-chevron-left"></i> {{ __('Back') }}</a>
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
                                <strong class="card-title">{{ __('Order Details') }}</strong>
                            </div>
                            <div class="card-body">
                                <table id="example" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>{{ __('Sno') }}</th>
                                            <th>{{ __('Product Name') }}</th>
                                            <th>{{ __('License') }}</th>
                                            <th>{{ __('Purchased Date') }}</th>
                                            <th>{{ __('Expiry Date') }}</th>
                                            <th>{{ __('Coupon Code') }}</th>
                                            <th>{{ __('Coupon Type') }}</th>
                                            <th>{{ __('Discount Amount') }}</th>
                                            <th>{{ __('Amount') }}</th>
                                            <th>{{ __('Payment Status') }}</th>
                                            <th>{{ __('Payment Approval') }}?</th>
                                            <th>{{ __('More Info') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @php $no = 1; @endphp
                                    @foreach($itemData['item'] as $order)
                                        <tr>
                                            <td>{{ $no }}</td>
                                            <td>{{ $order->product_name }} </td>
                                            <td>{{ $order->license }} </td>
                                            <td>{{ date('d F Y', strtotime($order->start_date)) }} </td>
                                            <td>{{ date('d F Y', strtotime($order->end_date)) }} </td>
                                            @if($order->coupon_code != "")
                                            <td>{{ $order->coupon_code }} </td>
                                            @else
                                            <td align="center">-</td>
                                            @endif
                                            @if($order->coupon_type != "")
                                            <td>{{ $order->coupon_type }} </td>
                                            @else
                                            <td align="center">-</td>
                                            @endif
                                            @if($order->coupon_type != "")
                                            @if($order->coupon_type == 'fixed')
                                            <td>{{ $allsettings->site_currency_symbol }}{{ $order->coupon_value }} </td>
                                            @else
                                            @php
                                            $equ = $order->product_price - $order->discount_price;
                                            $final = $order->discount_price+$allsettings->site_extra_fee; 
                                            @endphp
                                            <td>{{ $allsettings->site_currency_symbol }}{{ $equ }} </td>
                                            @endif
                                            @else
                                            @php
                                            $final = $order->product_price+$allsettings->site_extra_fee; 
                                            @endphp
                                            <td align="center">-</td>
                                            @endif
                                            <td>{{ $allsettings->site_currency_symbol }} {{ $final }}</td>
                                            <td>@if($order->order_status == 'completed') <span class="badge badge-success">{{ __('Completed') }}</span> @else <span class="badge badge-danger">{{ __('Pending') }}</span> @endif</td>
                                            <td>
                                            
                                            {{ $order->approval_status }}
                                            
                                            </td>
                                            <td><a href="{{ URL::to('/admin/more-info') }}/{{ $order->purchase_token }}" class="btn btn-primary btn-sm"><i class="fa fa-eye"></i>&nbsp; {{ __('More Info') }}</a></td>
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
                        columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10]
                    },
					className: 'ml-4 mr-1',
					filename: '{{ $allsettings->site_title }} - Order-details'
                },
                {
                    extend: 'csv',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10]
                    },
					className: 'mr-1',
					filename: '{{ $allsettings->site_title }} - Order-details'
                },
                {
                    extend: 'excel',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10]
                    },
					className: 'mr-1',
					filename: '{{ $allsettings->site_title }} - Order-details'
                },
				{
                    extend: 'pdf',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10]
                    },
					className: 'mr-1',
					filename: '{{ $allsettings->site_title }} - Order-details'
                },
				{
                    extend: 'print',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10]
                    },
					className: 'mr-1',
					filename: '{{ $allsettings->site_title }} - Order-details'
                }
                
            ]
    });

    

      

	
	
	});

</script>

</body>

</html>
