<?php echo $__env->make('version', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
<title><?php echo e($allsettings->site_title); ?></title>
<?php if($allsettings->site_favicon != ''): ?>
<link rel="apple-touch-icon" href="<?php echo e(url('/')); ?>/public/storage/settings/<?php echo e($allsettings->site_favicon); ?>">
<link rel="shortcut icon" href="<?php echo e(url('/')); ?>/public/storage/settings/<?php echo e($allsettings->site_favicon); ?>">
<?php endif; ?>
<link rel="stylesheet" href="<?php echo e(URL::to('resources/views/admin/template/vendors/bootstrap/dist/css/bootstrap.min.css')); ?>">
<link rel="stylesheet" href="<?php echo e(URL::to('resources/views/admin/template/vendors/font-awesome/css/font-awesome.min.css')); ?>">
<link rel="stylesheet" href="<?php echo e(URL::to('resources/views/admin/template/vendors/themify-icons/css/themify-icons.css')); ?>">
<link rel="stylesheet" href="<?php echo e(URL::to('resources/views/admin/template/vendors/flag-icon-css/css/flag-icon.min.css')); ?>">
<link rel="stylesheet" href="<?php echo e(URL::to('resources/views/admin/template/vendors/selectFX/css/cs-skin-elastic.css')); ?>">
<link rel="stylesheet" href="<?php echo e(URL::to('resources/views/admin/template/vendors/jqvmap/dist/jqvmap.min.css')); ?>">
<link rel="stylesheet" href="<?php echo e(URL::to('resources/views/admin/template/vendors/datatables.net-bs4/css/dataTables.bootstrap4.min.css')); ?>">
<link rel="stylesheet" href="<?php echo e(URL::to('resources/views/admin/template/vendors/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css')); ?>">
<link rel="stylesheet" href="<?php echo e(URL::to('resources/views/admin/template/assets/css/style.css')); ?>">
<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="<?php echo e(URL::to('resources/views/admin/template/picker/jquery-ui-timepicker-addon.css')); ?>">
<link rel="stylesheet" href="<?php echo e(URL::to('resources/views/admin/template/picker/jquery-ui.css')); ?>" />
<link rel="stylesheet" type="text/css" href="<?php echo e(URL::to('resources/views/admin/template/dropzone/min/dropzone.min.css')); ?>">

    
<?php /**PATH /home/arixmyii/bittoz.shop/public_html/resources/views/admin/stylesheet.blade.php ENDPATH**/ ?>