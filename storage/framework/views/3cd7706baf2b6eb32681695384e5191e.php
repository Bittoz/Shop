<!DOCTYPE HTML>
<html lang="en">
<head>
<title><?php echo e($page['page']->page_title); ?> - <?php echo e($allsettings->site_title); ?></title>
<?php if($page['page']->page_allow_seo == 1): ?>
<meta name="Keywords" content="<?php echo e($page['page']->page_seo_keyword); ?>">
<meta name="Description" content="<?php echo e($page['page']->page_seo_desc); ?>">
<?php else: ?>
<?php echo $__env->make('meta', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php endif; ?>
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
              <li class="breadcrumb-item text-nowrap active" aria-current="page"><?php echo e($page['page']->page_title); ?></li>
            </ol>
          </nav>
        </div>
        <div class="order-lg-1 pr-lg-4 text-center text-lg-left">
          <h1 class="h3 mb-0 text-white"><?php echo e($page['page']->page_title); ?></h1>
        </div>
      </div>
      </div>
    </section>
<div <?php if($custom_settings->theme_layout == 'container'): ?> class="container-fluid py-5 mt-md-2 mb-2" <?php else: ?> class="container py-5 mt-md-2 mb-2" <?php endif; ?>>
      <?php if(in_array('pages',$top_ads)): ?>
      <div class="row">
          <div class="col-lg-12 mb-4" align="center">
             <?php echo html_entity_decode($allsettings->top_ads); ?>
          </div>
       </div>   
       <?php endif; ?>
      <div class="row">
        <div class="col-lg-12" data-aos="fade-up" data-aos-delay="200">
          <div class="font-size-md"><?php echo html_entity_decode($page['page']->page_desc); ?></div>
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
<?php echo $__env->make('footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php echo $__env->make('script', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
</body>
</html><?php /**PATH /home/arixmyii/bittoz.shop/public_html/resources/views/pages/page.blade.php ENDPATH**/ ?>