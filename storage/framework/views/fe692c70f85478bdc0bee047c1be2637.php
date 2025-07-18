<?php if($allsettings->maintenance_mode == 0): ?>
<!DOCTYPE HTML>
<html lang="en">
<head>
<title><?php echo e($allsettings->site_title); ?> - <?php if($custom_settings->verify_mode == 1): ?> <?php echo e(__('Verify Purchase')); ?> <?php else: ?> <?php echo e(__('404 Not Found')); ?> <?php endif; ?></title>
<?php echo $__env->make('meta', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php echo $__env->make('style', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
</head>
<body>
<?php echo $__env->make('header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php if($custom_settings->verify_mode == 1): ?>
<section class="bg-position-center-top" style="background-image: url('<?php echo e(url('/')); ?>/public/storage/settings/<?php echo e($allsettings->site_other_banner); ?>');">
      <div class="py-4">
        <div <?php if($custom_settings->theme_layout == 'container'): ?> class="container-fluid d-lg-flex justify-content-between py-2 py-lg-3" <?php else: ?> class="container d-lg-flex justify-content-between py-2 py-lg-3" <?php endif; ?>>
        <div class="order-lg-2 mb-3 mb-lg-0 pt-lg-2">
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb flex-lg-nowrap justify-content-center justify-content-lg-star">
              <li class="breadcrumb-item"><a class="text-nowrap" href="<?php echo e(URL::to('/')); ?>"><i class="dwg-home"></i><?php echo e(__('Home')); ?></a></li>
              <li class="breadcrumb-item text-nowrap active" aria-current="page"><?php echo e(__('Verify Purchase')); ?></li>
            </ol>
          </nav>
        </div>
        <div class="order-lg-1 pr-lg-4 text-center text-lg-left">
          <h1 class="h3 mb-0 text-white"><?php echo e(__('Verify Purchase')); ?></h1>
        </div>
      </div>
      </div>
    </section>
<div <?php if($custom_settings->theme_layout == 'container'): ?> class="container-fluid py-4 py-lg-5 my-4" <?php else: ?> class="container py-4 py-lg-5 my-4" <?php endif; ?>>
      <?php if(in_array('pages',$top_ads)): ?>
      <div class="row">
          <div class="col-lg-12 mb-4" align="center">
             <?php echo html_entity_decode($allsettings->top_ads); ?>
          </div>
       </div>   
       <?php endif; ?>
      <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10">
          <div class="card py-2 mt-4">
            <form method="POST" action="<?php echo e(route('verify')); ?>"  id="login_form" class="card-body needs-validation">
               <?php echo csrf_field(); ?> 
              <div class="form-group">
                <label for="recover-email"><?php echo e(__('Enter Purchase Code')); ?></label>
                <input class="form-control" type="text" id="recover-email" name="purchase_code" value="<?php if(!empty($purchase_code)): ?><?php echo e($purchase_code); ?><?php endif; ?>"  data-bvalidator="required">
              </div>
              <button class="btn btn-primary" type="submit"><?php echo e(__('Verify Purchase')); ?></button>
            </form>
          </div>
          <?php if($checkverify != 0): ?>
          <div class="mt-4">
          <table class="table table-bordered">
             <thead>
             <tr>
                 <th><?php echo e(__('Title')); ?></th>
                 <th><?php echo e(__('Value')); ?></th>
             </tr> 
             </thead>
             <tbody>
             <tr>
             <td><?php echo e(__('Product Name')); ?></td>
             <td><?php echo e($sold->product_name); ?></td>
             </tr>
             <tr>
             <td><?php echo e(__('Order ID')); ?></td><td><?php echo e($sold->purchase_token); ?></td>
             </tr>
             <tr><td><?php echo e(__('Purchase Date')); ?></td><td><?php echo e(date("d F Y", strtotime($sold->start_date))); ?></td>
             </tr>
             <tr>
             <td><?php echo e(__('Buyer Name')); ?></td><td><?php echo e($sold->name); ?></td>
             </tr>
             <tr>
             <td><?php echo e(__('License Type')); ?></td><td class="captext"><?php echo e($sold->license); ?> <?php echo e(__('License')); ?></td>
             </tr>
             <tr>
             <td><?php echo e(__('Supported Until')); ?></td><td><?php echo e(date("d F Y", strtotime($sold->end_date))); ?></td>
             </tr>
             </tbody>
             </table>
          </div>
          <?php endif; ?>
        </div>
      </div>
      <?php if(in_array('pages',$bottom_ads)): ?>
       <div class="row">
          <div class="col-lg-12 mb-4" align="center">
             <?php echo html_entity_decode($allsettings->bottom_ads); ?>
          </div>
       </div>   
       <?php endif; ?>
    </div>
<?php else: ?>
<?php echo $__env->make('not-found', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php endif; ?>    
<?php echo $__env->make('footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php echo $__env->make('script', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
</body>
</html>
<?php else: ?>
<?php echo $__env->make('503', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php endif; ?><?php /**PATH /home/arixmyii/bittoz.shop/public_html/resources/views/verify.blade.php ENDPATH**/ ?>