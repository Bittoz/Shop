<!doctype html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js" lang="en">
<!--<![endif]-->

<head>
    
    <?php echo $__env->make('admin.stylesheet', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
</head>

<body>
    
    <?php echo $__env->make('admin.navigation', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <!-- Right Panel -->
    <?php if(in_array('customers',$avilable)): ?>
    <div id="right-panel" class="right-panel">

        
                       <?php echo $__env->make('admin.header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                     <?php if($demo_mode == 'on'): ?>
                     <?php echo $__env->make('admin.demo-mode', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                     <?php else: ?>
                     <form action="<?php echo e(route('admin.customer')); ?>" method="post" id="setting_form" enctype="multipart/form-data">
                     <?php echo e(csrf_field()); ?>

                     <?php endif; ?>

        <div class="breadcrumbs">
            <div class="col-sm-4">
                <div class="page-header float-left">
                    <div class="page-title">
                        <h1><?php echo e(__('Customers')); ?></h1>
                    </div>
                </div>
            </div>
            <div class="col-sm-8">
                <div class="page-header float-right">
                    <div class="page-title">
                        <ol class="breadcrumb text-right">
                            <a href="<?php echo e(url('/admin/add-customer')); ?>" class="btn btn-success btn-sm"><i class="fa fa-plus"></i> <?php echo e(__('Add Customer')); ?></a>
                            <input type="submit" value="Delete All" name="action" class="btn btn-danger btn-sm ml-1" id="checkBtn" onClick="return confirm('Are you sure you want to delete?');">
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
                                <strong class="card-title"><?php echo e(__('Customers')); ?></strong>
                            </div>
                            <div class="card-body">
                                <table id="example" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th><input type="checkbox" id="selectAll"></th>
                                            <th><?php echo e(__('Sno')); ?></th>
                                            <th><?php echo e(__('Name')); ?></th>
                                            <th><?php echo e(__('Email')); ?></th>
                                            <th><?php echo e(__('Photo')); ?></th>
                                            <th><?php echo e(__('Email Verified')); ?></th>
                                            <th><?php echo e(__('SignUp Type')); ?></th>
                                            <?php if($allsettings->subscription_mode == 1): ?>
                                            <th><?php echo e(__('Subscription Details')); ?></th>
                                            <th><?php echo e(__('Payment Status')); ?></th>
                                            <?php endif; ?>
                                            <th><?php echo e(__('Earnings')); ?></th>
                                            <th><?php echo e(__('Action')); ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php $no = 1; ?>
                                    <?php $__currentLoopData = $userData['data']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr class="allChecked">
                                            <td><input type="checkbox" name="user_token[]" value="<?php echo e($user->user_token); ?>"/></td>
                                            <td><?php echo e($no); ?></td>
                                            <td><?php echo e($user->name); ?></td>
                                            <td><?php echo e($user->email); ?></td>
                                            <td><?php if($user->user_photo != ''): ?> <img height="50" src="<?php echo e(url('/')); ?>/public/storage/users/<?php echo e($user->user_photo); ?>" alt="<?php echo e($user->name); ?>" class="userphoto"/><?php else: ?> <img height="50" src="<?php echo e(url('/')); ?>/public/img/no-user.png" alt="<?php echo e($user->name); ?>" class="userphoto"/>  <?php endif; ?></td>
                                            <td><?php if($user->verified == 1): ?> <span class="badge badge-success"><?php echo e(__('verified')); ?></span> <?php else: ?> <span class="badge badge-danger"><?php echo e(__('unverified')); ?></span> <?php endif; ?></td>
                                            <td><?php if($user->provider == ''): ?><span class="badge badge-success"><?php echo e(__('Email')); ?></span><?php else: ?> <?php if($user->provider == 'facebook'): ?><span class="badge badge-primary"><?php echo e(__('Facebook')); ?></span><?php endif; ?> <?php if($user->provider == 'google'): ?><span class="badge badge-danger"><?php echo e(__('Google')); ?></span><?php endif; ?> <?php endif; ?></td>
                                            <?php if($allsettings->subscription_mode == 1): ?>
                                            <td>
                                            <?php if($user->user_subscr_type != ''): ?>
                                            <a href="<?php echo e(url('/admin')); ?>/subscription-payment-details/<?php echo e($user->user_token); ?>" class="btn btn-info btn-sm"><i class="fa fa-id-card"></i> <?php echo e(__('View')); ?></a>
                                            <?php else: ?>
                                            <span>----</span>
                                            <?php endif; ?>
                                            </td>
                                            <td><?php if($user->user_subscr_payment_status == 'completed'): ?> <span class="badge badge-success"><?php echo e(__('Completed')); ?></span> <?php else: ?> <span class="badge badge-danger"><?php echo e(__('Pending')); ?></span> <?php endif; ?></td>
                                            <?php endif; ?>
                                            <td><?php echo e($allsettings->site_currency_symbol); ?> <?php echo e($user->earnings); ?></td>
                                            <td><a href="<?php echo e(url('/admin')); ?>/edit-customer/<?php echo e($user->user_token); ?>" class="btn btn-success btn-sm"><i class="fa fa-edit"></i>&nbsp; <?php echo e(__('Edit')); ?></a> 
                                            <?php if($demo_mode == 'on'): ?> 
                                            <a href="<?php echo e(URL::to('/admin/demo-mode')); ?>" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i>&nbsp;<?php echo e(__('Delete')); ?></a>
                                            <?php else: ?>
                                            <a href="<?php echo e(url('/admin')); ?>/customer/<?php echo e($user->user_token); ?>" class="btn btn-danger btn-sm" onClick="return confirm('Are you sure you want to delete?');"><i class="fa fa-trash"></i>&nbsp;<?php echo e(__('Delete')); ?></a>
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
            </div><!-- .animated -->
        </div><!-- .content -->

    </form>
    </div><!-- /#right-panel -->
    <?php else: ?>
    <?php echo $__env->make('admin.denied', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php endif; ?>
    <!-- Right Panel -->


   <?php echo $__env->make('admin.javascript', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
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
                        columns: [1, 2, 3, 5, 6, 8, 9]
                    },
					className: 'ml-4 mr-1',
					filename: '<?php echo e($allsettings->site_title); ?> - Customer'
                },
                {
                    extend: 'csv',
                    exportOptions: {
                        columns: [1, 2, 3, 5, 6, 8, 9]
                    },
					className: 'mr-1',
					filename: '<?php echo e($allsettings->site_title); ?> - Customer'
                },
                {
                    extend: 'excel',
                    exportOptions: {
                        columns: [1, 2, 3, 5, 6, 8, 9]
                    },
					className: 'mr-1',
					filename: '<?php echo e($allsettings->site_title); ?> - Customer'
                },
				{
                    extend: 'pdf',
                    exportOptions: {
                        columns: [1, 2, 3, 5, 6, 8, 9]
                    },
					className: 'mr-1',
					filename: '<?php echo e($allsettings->site_title); ?> - Customer'
                },
				{
                    extend: 'print',
                    exportOptions: {
                        columns: [1, 2, 3, 5, 6, 8, 9]
                    },
					className: 'mr-1',
					filename: '<?php echo e($allsettings->site_title); ?> - Customer'
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
<?php /**PATH /home/arixmyii/bittoz.shop/public_html/resources/views/admin/customer.blade.php ENDPATH**/ ?>