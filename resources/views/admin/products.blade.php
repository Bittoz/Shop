<!doctype html>
<html class="no-js" lang="en">
<head>
    @include('admin.stylesheet')
</head>
<body>
    @include('admin.navigation')

    @if(in_array('manage-products',$avilable))
    <div id="right-panel" class="right-panel">
        @include('admin.header')

        @if($demo_mode == 'on')
            @include('admin.demo-mode')
        @else
            <form action="{{ route('admin.products') }}" method="post" id="setting_form" enctype="multipart/form-data">
                @csrf
        @endif

        <div class="breadcrumbs">
            <div class="col-sm-4">
                <div class="page-header float-left">
                    <div class="page-title">
                        <h1>{{ __('Products') }}</h1>
                    </div>
                </div>
            </div>
            <div class="col-sm-8">
                <div class="page-header float-right">
                    <div class="page-title">
                        <ol class="breadcrumb text-right">
                            <a href="{{ url('/admin/add-product') }}" class="btn btn-success btn-sm">
                                <i class="fa fa-plus"></i> {{ __('Add Product') }}
                            </a>
                            &nbsp;
                            <a href="{{ url('/admin/products-import-export') }}" class="btn btn-primary btn-sm">
                                <i class="fa fa-file-excel-o"></i> {{ __('Product Import / Export') }}
                            </a>
                            <input type="submit"
                                   value="{{ __('Delete All') }}"
                                   name="action"
                                   class="btn btn-danger btn-sm ml-1"
                                   id="checkBtn"
                                   onclick="return confirm('{{ __('Are you sure you want to delete?') }}');">
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
                        <strong class="card-title">{{ __('Products') }}</strong>
                      </div>
                      <div class="card-body">
                        <table id="example" class="table table-striped table-bordered">
                          <thead>
                            <tr>
                              <th><input type="checkbox" id="selectAll"></th>
                              <th>{{ __('Sno') }}</th>
                              <th>{{ __('Image') }}</th>
                              <th>{{ __('Product Name') }}</th>
                              <th>{{ __('Type') }}</th>
                              <th>{{ __('Price') }}</th>
                              <th>{{ __('Featured') }}</th>
                              <th>{{ __('Free Download') }}</th>
                              <th>{{ __('Flash Sale') }}</th>
                              @if($allsettings->subscription_mode == 1)
                                <th>{{ __('Subscription Item') }}?</th>
                              @endif
                              <th>{{ __('Reviews') }}</th>
                              <th>{{ __('Status') }}</th>
                              <th>{{ __('Action') }}</th>
                            </tr>
                          </thead>
                          <tbody>
                            @php $no = 1; @endphp
                            @foreach($itemData['item'] as $product)
                              <tr class="allChecked">
                                <td>
                                  <input type="checkbox" name="product_token[]" value="{{ $product->product_token }}"/>
                                </td>
                                <td>{{ $no }}</td>
                                <td>
                                  @if($product->product_image)
                                    <img src="{{ url('/') }}/public/storage/product/{{ $product->product_image }}"
                                         alt="{{ $product->product_name }}"
                                         class="image-size"/>
                                  @else
                                    <img src="{{ url('/') }}/public/img/no-image.jpg"
                                         alt="{{ $product->product_name }}"
                                         class="image-size"/>
                                  @endif
                                </td>
                                <td>{{ mb_substr($product->product_name, 0, 50, 'UTF-8') }}</td>
                                <td>{{ ucfirst($product->type) }}</td>
                                <td>{{ $allsettings->site_currency_symbol }} {{ $product->regular_price }}</td>
                                <td>
                                  @if($product->product_featured == 1)
                                    <span class="badge badge-success">{{ __('Yes') }}</span>
                                  @else
                                    <span class="badge badge-danger">{{ __('No') }}</span>
                                  @endif
                                </td>
                                <td>
                                  @if($product->product_free == 1)
                                    <span class="badge badge-success">{{ __('Yes') }}</span>
                                  @else
                                    <span class="badge badge-danger">{{ __('No') }}</span>
                                  @endif
                                </td>
                                <td>
                                  @if($product->product_flash_sale == 1)
                                    <span class="badge badge-success">{{ __('Yes') }}</span>
                                  @else
                                    <span class="badge badge-danger">{{ __('No') }}</span>
                                  @endif
                                </td>
                                @if($allsettings->subscription_mode == 1)
                                  <td>
                                    @if($product->subscription_item == 1)
                                      <span class="badge badge-success">{{ __('On') }}</span>
                                    @else
                                      <span class="badge badge-danger">{{ __('Off') }}</span>
                                    @endif
                                  </td>
                                @endif
                                <td>
                                  <a href="{{ url('/admin/reviews/'.$product->product_token) }}"
                                     class="blue-color">
                                    {{ __('Reviews') }} [
                                      {{ $reviews->has($product->product_id)
                                          ? count($reviews[$product->product_id])
                                          : 0
                                      }}
                                    ]
                                  </a>
                                </td>
                                <td>
                                  @if($product->product_status == 1)
                                    <span class="badge badge-success">{{ __('Active') }}</span>
                                  @else
                                    <span class="badge badge-danger">{{ __('InActive') }}</span>
                                  @endif
                                </td>
                                <td>
                                  <a href="{{ url('/admin/edit-product/'.$product->product_token) }}"
                                     class="btn btn-success btn-sm">
                                    <i class="fa fa-edit"></i>&nbsp;{{ __('Edit') }}
                                  </a>
                                  @if($demo_mode == 'on')
                                    <a href="{{ url('/admin/demo-mode') }}"
                                       class="btn btn-danger btn-sm">
                                      <i class="fa fa-trash"></i>&nbsp;{{ __('Delete') }}
                                    </a>
                                  @else
                                    <a href="{{ url('/admin/products/'.$product->product_token) }}"
                                       class="btn btn-danger btn-sm"
                                       onclick="return confirm('{{ __('Are you sure you want to delete?') }}');">
                                      <i class="fa fa-trash"></i>&nbsp;{{ __('Delete') }}
                                    </a>
                                    <a href="{{ url('/admin/download/'.$product->product_token) }}"
                                       class="btn btn-primary btn-sm mt-1">
                                      <i class="fa fa-download"></i>&nbsp;{{ __('Download File') }}
                                    </a>
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
            </div>
        </div>

        @if($demo_mode != 'on')
            </form>
        @endif

    </div> {{-- /#right-panel --}}
    @else
        @include('admin.denied')
    @endif

    @include('admin.javascript')
    <script>
    $(document).ready(function () {
        // DataTable init
        var oTable = $('#example').dataTable({
            stateSave: true,
            responsive: true,
            dom: 'Bfrtip',
            buttons: [
                { extend:'copy',  exportOptions:{ columns:[1,3,4,5,6,7,8,9,10] }, className:'ml-4 mr-1', filename:'{{ $allsettings->site_title }} - Products' },
                { extend:'csv',   exportOptions:{ columns:[1,3,4,5,6,7,8,9,10] }, className:'mr-1', filename:'{{ $allsettings->site_title }} - Products' },
                { extend:'excel', exportOptions:{ columns:[1,3,4,5,6,7,8,9,10] }, className:'mr-1', filename:'{{ $allsettings->site_title }} - Products' },
                { extend:'pdf',   exportOptions:{ columns:[1,3,4,5,6,7,8,9,10] }, className:'mr-1', filename:'{{ $allsettings->site_title }} - Products' },
                { extend:'print', exportOptions:{ columns:[1,3,4,5,6,7,8,9,10] }, className:'mr-1', filename:'{{ $allsettings->site_title }} - Products' }
            ]
        });

        // Select All checkboxes
        var allPages = oTable.fnGetNodes();
        $('body').on('click', '#selectAll', function () {
            var checked = $(this).hasClass('allChecked');
            $('input[type="checkbox"]', allPages).prop('checked', !checked);
            $(this).toggleClass('allChecked');
        });

        // Bulk delete validation
        $('#checkBtn').click(function() {
            if (!$("input[type=checkbox]:checked").length) {
                alert("{{ __('You must check at least one checkbox.') }}");
                return false;
            }
        });
    });
    </script>
</body>
</html>
