<!doctype html>
<html class="no-js" lang="en">
<head>
    <?php echo $__env->make('admin.stylesheet', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
</head>
<body>
    <?php echo $__env->make('admin.navigation', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <?php if(in_array('manage-products',$avilable)): ?>
    <div id="right-panel" class="right-panel">
        <?php echo $__env->make('admin.header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

        <?php if($demo_mode == 'on'): ?>
            <?php echo $__env->make('admin.demo-mode', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        <?php else: ?>
            <form action="<?php echo e(route('admin.products')); ?>" method="post" id="setting_form" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
        <?php endif; ?>

        <div class="breadcrumbs">
            <div class="col-sm-4">
                <div class="page-header float-left">
                    <div class="page-title">
                        <h1><?php echo e(__('Products')); ?></h1>
                    </div>
                </div>
            </div>
            <div class="col-sm-8">
                <div class="page-header float-right">
                    <div class="page-title">
                        <ol class="breadcrumb text-right">
                            <a href="<?php echo e(url('/admin/add-product')); ?>" class="btn btn-success btn-sm">
                                <i class="fa fa-plus"></i> <?php echo e(__('Add Product')); ?>

                            </a>
                            &nbsp;
                            <a href="<?php echo e(url('/admin/products-import-export')); ?>" class="btn btn-primary btn-sm">
                                <i class="fa fa-file-excel-o"></i> <?php echo e(__('Product Import / Export')); ?>

                            </a>
                            <input type="submit"
                                   value="<?php echo e(__('Delete All')); ?>"
                                   name="action"
                                   class="btn btn-danger btn-sm ml-1"
                                   id="checkBtn"
                                   onclick="return confirm('<?php echo e(__('Are you sure you want to delete?')); ?>');">
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <?php echo $__env->make('admin.warning', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

        <div class="content mt-3">
            <div class="animated fadeIn">
                <div class="row">
                  <div class="col-md-12">
                    <div class="card">
                      <div class="card-header">
                        <strong class="card-title"><?php echo e(__('Products')); ?></strong>
                      </div>
                      <div class="card-body">
                        <table id="example" class="table table-striped table-bordered">
                          <thead>
                            <tr>
                              <th><input type="checkbox" id="selectAll"></th>
                              <th><?php echo e(__('Sno')); ?></th>
                              <th><?php echo e(__('Image')); ?></th>
                              <th><?php echo e(__('Product Name')); ?></th>
                              <th><?php echo e(__('Type')); ?></th>
                              <th><?php echo e(__('Price')); ?></th>
                              <th><?php echo e(__('Featured')); ?></th>
                              <th><?php echo e(__('Free Download')); ?></th>
                              <th><?php echo e(__('Flash Sale')); ?></th>
                              <?php if($allsettings->subscription_mode == 1): ?>
                                <th><?php echo e(__('Subscription Item')); ?>?</th>
                              <?php endif; ?>
                              <th><?php echo e(__('Reviews')); ?></th>
                              <th><?php echo e(__('Status')); ?></th>
                              <th><?php echo e(__('Action')); ?></th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php $no = 1; ?>
                            <?php $__currentLoopData = $itemData['item']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                              <tr class="allChecked">
                                <td>
                                  <input type="checkbox" name="product_token[]" value="<?php echo e($product->product_token); ?>"/>
                                </td>
                                <td><?php echo e($no); ?></td>
                                <td>
                                  <?php if($product->product_image): ?>
                                    <img src="<?php echo e(url('/')); ?>/public/storage/product/<?php echo e($product->product_image); ?>"
                                         alt="<?php echo e($product->product_name); ?>"
                                         class="image-size"/>
                                  <?php else: ?>
                                    <img src="<?php echo e(url('/')); ?>/public/img/no-image.jpg"
                                         alt="<?php echo e($product->product_name); ?>"
                                         class="image-size"/>
                                  <?php endif; ?>
                                </td>
                                <td><?php echo e(mb_substr($product->product_name, 0, 50, 'UTF-8')); ?></td>
                                <td><?php echo e(ucfirst($product->type)); ?></td>
                                <td><?php echo e($allsettings->site_currency_symbol); ?> <?php echo e($product->regular_price); ?></td>
                                <td>
                                  <?php if($product->product_featured == 1): ?>
                                    <span class="badge badge-success"><?php echo e(__('Yes')); ?></span>
                                  <?php else: ?>
                                    <span class="badge badge-danger"><?php echo e(__('No')); ?></span>
                                  <?php endif; ?>
                                </td>
                                <td>
                                  <?php if($product->product_free == 1): ?>
                                    <span class="badge badge-success"><?php echo e(__('Yes')); ?></span>
                                  <?php else: ?>
                                    <span class="badge badge-danger"><?php echo e(__('No')); ?></span>
                                  <?php endif; ?>
                                </td>
                                <td>
                                  <?php if($product->product_flash_sale == 1): ?>
                                    <span class="badge badge-success"><?php echo e(__('Yes')); ?></span>
                                  <?php else: ?>
                                    <span class="badge badge-danger"><?php echo e(__('No')); ?></span>
                                  <?php endif; ?>
                                </td>
                                <?php if($allsettings->subscription_mode == 1): ?>
                                  <td>
                                    <?php if($product->subscription_item == 1): ?>
                                      <span class="badge badge-success"><?php echo e(__('On')); ?></span>
                                    <?php else: ?>
                                      <span class="badge badge-danger"><?php echo e(__('Off')); ?></span>
                                    <?php endif; ?>
                                  </td>
                                <?php endif; ?>
                                <td>
                                  <a href="<?php echo e(url('/admin/reviews/'.$product->product_token)); ?>"
                                     class="blue-color">
                                    <?php echo e(__('Reviews')); ?> [
                                      <?php echo e($reviews->has($product->product_id)
                                          ? count($reviews[$product->product_id])
                                          : 0); ?>

                                    ]
                                  </a>
                                </td>
                                <td>
                                  <?php if($product->product_status == 1): ?>
                                    <span class="badge badge-success"><?php echo e(__('Active')); ?></span>
                                  <?php else: ?>
                                    <span class="badge badge-danger"><?php echo e(__('InActive')); ?></span>
                                  <?php endif; ?>
                                </td>
                                <td>
                                  <a href="<?php echo e(url('/admin/edit-product/'.$product->product_token)); ?>"
                                     class="btn btn-success btn-sm">
                                    <i class="fa fa-edit"></i>&nbsp;<?php echo e(__('Edit')); ?>

                                  </a>
                                  <?php if($demo_mode == 'on'): ?>
                                    <a href="<?php echo e(url('/admin/demo-mode')); ?>"
                                       class="btn btn-danger btn-sm">
                                      <i class="fa fa-trash"></i>&nbsp;<?php echo e(__('Delete')); ?>

                                    </a>
                                  <?php else: ?>
                                    <a href="<?php echo e(url('/admin/products/'.$product->product_token)); ?>"
                                       class="btn btn-danger btn-sm"
                                       onclick="return confirm('<?php echo e(__('Are you sure you want to delete?')); ?>');">
                                      <i class="fa fa-trash"></i>&nbsp;<?php echo e(__('Delete')); ?>

                                    </a>
                                    <a href="<?php echo e(url('/admin/download/'.$product->product_token)); ?>"
                                       class="btn btn-primary btn-sm mt-1">
                                      <i class="fa fa-download"></i>&nbsp;<?php echo e(__('Download File')); ?>

                                    </a>
                                  <?php endif; ?>
                                </td>
                              </tr>
                              <?php $no++; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                </div>
            </div>
        </div>

        <?php if($demo_mode != 'on'): ?>
            </form>
        <?php endif; ?>

    </div> 
    <?php else: ?>
        <?php echo $__env->make('admin.denied', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php endif; ?>

    <?php echo $__env->make('admin.javascript', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <script>
    $(document).ready(function () {
        // DataTable init
        var oTable = $('#example').dataTable({
            stateSave: true,
            responsive: true,
            dom: 'Bfrtip',
            buttons: [
                { extend:'copy',  exportOptions:{ columns:[1,3,4,5,6,7,8,9,10] }, className:'ml-4 mr-1', filename:'<?php echo e($allsettings->site_title); ?> - Products' },
                { extend:'csv',   exportOptions:{ columns:[1,3,4,5,6,7,8,9,10] }, className:'mr-1', filename:'<?php echo e($allsettings->site_title); ?> - Products' },
                { extend:'excel', exportOptions:{ columns:[1,3,4,5,6,7,8,9,10] }, className:'mr-1', filename:'<?php echo e($allsettings->site_title); ?> - Products' },
                { extend:'pdf',   exportOptions:{ columns:[1,3,4,5,6,7,8,9,10] }, className:'mr-1', filename:'<?php echo e($allsettings->site_title); ?> - Products' },
                { extend:'print', exportOptions:{ columns:[1,3,4,5,6,7,8,9,10] }, className:'mr-1', filename:'<?php echo e($allsettings->site_title); ?> - Products' }
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
                alert("<?php echo e(__('You must check at least one checkbox.')); ?>");
                return false;
            }
        });
    });
    </script>
</body>
</html>
<?php /**PATH /home/arixmyii/bittoz.shop/public_html/resources/views/admin/products.blade.php ENDPATH**/ ?>