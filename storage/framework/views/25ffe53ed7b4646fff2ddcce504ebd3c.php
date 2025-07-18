<!DOCTYPE HTML>
<html lang="en">
<head>
<title><?php echo e(__('Updates')); ?> - <?php echo e($allsettings->site_title); ?></title>
<?php echo $__env->make('meta', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php echo $__env->make('style', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
</head>
<body>
<?php echo $__env->make('header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<section class="bg-position-center-top" style="background-image: url('<?php echo e(url('/')); ?>/public/storage/settings/<?php echo e($allsettings->site_other_banner); ?>');">
      <div class="py-4">
        <div <?php if($custom_settings->theme_layout == 'container'): ?> class="container-fluid d-lg-flex justify-content-between py-2 py-lg-3" <?php else: ?> class="container d-lg-flex justify-content-between py-2 py-lg-3" <?php endif; ?>>
        <div class="order-lg-2 mb-3 mb-lg-0 pt-lg-2">
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb flex-lg-nowrap justify-content-center justify-content-lg-star">
              <li class="breadcrumb-item"><a class="text-nowrap" href="<?php echo e(URL::to('/')); ?>"><i class="dwg-home"></i><?php echo e(__('Home')); ?></a></li>
              <li class="breadcrumb-item text-nowrap active" aria-current="page"><?php echo e(__('Updates')); ?></li>
            </ol>
          </nav>
        </div>
        <div class="order-lg-1 pr-lg-4 text-center text-lg-left">
          <h1 class="h3 mb-0 text-white"><?php echo e(__('Updates')); ?></h1>
        </div>
      </div>
      </div>
    </section>
<div <?php if($custom_settings->theme_layout == 'container'): ?> class="container-fluid py-5 mt-md-2 mb-2" <?php else: ?> class="container py-5 mt-md-2 mb-2" <?php endif; ?>>
     <?php if(in_array('shop',$top_ads)): ?>
      <div class="row">
          <div class="col-lg-12 mb-4" align="center">
             <?php echo html_entity_decode($allsettings->top_ads); ?>
          </div>
       </div>   
       <?php endif; ?>
      <div class="row">
        <div class="col-lg-12" data-aos="fade-up" data-aos-delay="200">
           <h4 align="center"><?php echo e(__('Products Updated Today - Full Changelog')); ?></h4>
           <p align="center"><?php echo e(__('We update our inventory daily even twice a day and on weekends too. Our inventory is growing and in the future, you can expect some increment in the price as well. So, make sure to join a good membership plan to save tons of money')); ?></p>
           <table id="example" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th><?php echo e(__('Thumbnail')); ?></th>
                                            <th><?php echo e(__('Title')); ?></th>
                                            <th><?php echo e(__('Updated On')); ?></th>
                                            <th><?php echo e(__('Price')); ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    
                                    <?php $__currentLoopData = $updates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php
                                    $price = Helper::price_info($product->product_flash_sale,$product->regular_price);
                                    ?>
                                        
                                        <tr class="tupdates">
                                            <td>
                                            <a href="<?php echo e(URL::to('/item')); ?>/<?php echo e($product->product_slug); ?>">
                                            <?php if($product->product_image != ''): ?> <img src="<?php echo e(url('/')); ?>/public/storage/product/<?php echo e($product->product_image); ?>" alt="<?php echo e($product->product_name); ?>" class="image-size"/><?php else: ?> <img src="<?php echo e(url('/')); ?>/public/img/no-image.jpg" alt="<?php echo e($product->product_name); ?>" class="image-size"/>  <?php endif; ?>
                                            </a>
                                            </td>
                                            <td>
                                            <a href="<?php echo e(URL::to('/item')); ?>/<?php echo e($product->product_slug); ?>">
                                            <?php echo e(mb_substr($product->product_name, 0, 200, 'UTF-8')); ?>

                                            </a>
                                            </td>
                                            <td>
                                            <a href="<?php echo e(URL::to('/item')); ?>/<?php echo e($product->product_slug); ?>">
                                            <?php echo e(date("F j, Y",strtotime($product->product_update))); ?>

                                            </a>
                                            </td>
                                            <td>
                                            <a href="<?php echo e(URL::to('/item')); ?>/<?php echo e($product->product_slug); ?>" class="pricevalue">
                                            <?php echo e($allsettings->site_currency_symbol); ?><?php echo e($price); ?>

                                            </a>
                                            </td>
                                        </tr>
                                        
                                   <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>     
                                        
                                    </tbody>
                                </table>
         </div>
      </div>
      <?php if(in_array('shop',$bottom_ads)): ?>
       <div class="row">
          <div class="col-lg-12 mb-4" align="center">
            <?php echo html_entity_decode($allsettings->bottom_ads); ?>
          </div>
       </div>   
       <?php endif; ?>
    </div>
<?php echo $__env->make('footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php echo $__env->make('script', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
</body>
</html><?php /**PATH /home/arixmyii/bittoz.shop/public_html/resources/views/pages/updates.blade.php ENDPATH**/ ?>