<!DOCTYPE HTML>
<html lang="en">
<head>
<title><?php echo e($allsettings->site_title); ?> - <?php echo e(__('Subscription')); ?></title>
<?php echo $__env->make('meta', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php echo $__env->make('style', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
</head>
<body>
<?php echo $__env->make('header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php if($allsettings->subscription_mode == 1): ?>
<section class="bg-position-center-top" style="background-image: url('<?php echo e(url('/')); ?>/public/storage/settings/<?php echo e($allsettings->site_other_banner); ?>');">
      <div class="py-4">
        <div <?php if($custom_settings->theme_layout == 'container'): ?> class="container-fluid d-lg-flex justify-content-between py-2 py-lg-3" <?php else: ?> class="container d-lg-flex justify-content-between py-2 py-lg-3" <?php endif; ?>>
        <div class="order-lg-2 mb-3 mb-lg-0 pt-lg-2">
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb flex-lg-nowrap justify-content-center justify-content-lg-star">
              <li class="breadcrumb-item"><a class="text-nowrap" href="<?php echo e(URL::to('/')); ?>"><i class="dwg-home"></i><?php echo e(__('Home')); ?></a></li>
              <li class="breadcrumb-item text-nowrap active" aria-current="page"><?php echo e(__('Subscription')); ?></li>
            </ol>
          </nav>
        </div>
        <div class="order-lg-1 pr-lg-4 text-center text-lg-left">
          <h1 class="h3 mb-0 text-white"><?php echo e(__('Subscription')); ?></h1>
        </div>
      </div>
      </div>
    </section>
<div class="faq-section section-padding">
		<div <?php if($custom_settings->theme_layout == 'container'): ?> class="container-fluid py-5 mt-md-2 mb-2" <?php else: ?> class="container py-5 mt-md-2 mb-2" <?php endif; ?>>
            <div class="row">
                <?php $__currentLoopData = $subscription['view']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subscription): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
 				<div <?php if($custom_settings->theme_layout == 'container'): ?> class="col-lg-3 col-md-4" <?php else: ?> class="col-lg-4 col-md-4" <?php endif; ?> data-aos="fade-up" data-aos-delay="200">
 					<div class="single-price-item wow fadeInLeft" data-wow-delay=".3s" style="visibility: visible; animation-delay: 0.3s; animation-name: fadeInLeft;">
 						<h5><?php echo e($subscription->subscr_name); ?></h5>
 						<div class="price-box">
 							<p><b><?php echo e($allsettings->site_currency_symbol); ?><?php echo e($subscription->subscr_price); ?></b>/ <?php if($subscription->subscr_duration == '1000 Year'): ?><?php echo e(__('Life Time')); ?><?php else: ?><?php echo e($subscription->subscr_duration); ?><?php endif; ?></p>
 						</div>
                        <hr>
 						<div class="price-list">
 							<ul>
                                <?php if($subscription->subscr_item_level == 'limited'): ?>
 								<li><i class="fa fa-check" aria-hidden="true"></i> <?php echo e(__('Download')); ?> <?php echo e($subscription->subscr_item); ?> <?php echo e(__('products per day')); ?></li>
                                <?php else: ?>
                                <li><i class="fa fa-check" aria-hidden="true"></i> <?php echo e(__('Unlimited Download Products')); ?></li>
                                <?php endif; ?>
                                <li><i class="fa fa-check" aria-hidden="true"></i> <?php echo e(__('Direct Download Links')); ?></li>
                                <li><i class="fa fa-check" aria-hidden="true"></i> <?php echo e(__('Email Support')); ?></li>										
								<li><i class="fa fa-check" aria-hidden="true"></i> <?php echo e(__('Support 24 x 7')); ?></li>
 							</ul>
 						</div>
 						<?php if(Auth::guest()): ?>																			
						<a href="<?php echo e(URL::to('/login')); ?>" class="main-btn small-btn">
						<span><?php echo e(__('Upgrade')); ?></span> <i class="fa fa-caret-right" aria-hidden="true"></i>
						</a>
                        <?php else: ?>
                        <?php if(Auth::user()->id != 1): ?>
                        <?php /*?>@if(Auth::user()->user_subscr_date < date('Y-m-d'))<?php */?>
                        <?php if(Auth::user()->user_subscr_type == $subscription->subscr_name): ?>
                        <a href="javascript:void(0)" class="main-btn small-btn inactiveLink">
						<span><?php echo e(__('Upgrade')); ?></span> <i class="fa fa-caret-right" aria-hidden="true"></i>
						</a>
                        <?php else: ?>
                        <a href="<?php echo e(URL::to('/confirm-subscription')); ?>/<?php echo e(base64_encode($subscription->subscr_id)); ?>" class="main-btn small-btn">
						<span><?php echo e(__('Upgrade')); ?></span> <i class="fa fa-caret-right" aria-hidden="true"></i>
						</a>
                        <?php endif; ?>
                        <?php /*?>@endif<?php */?>
                        <?php endif; ?>
                        <?php endif; ?>
 					</div>
 				</div>
 				<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>	
 			</div>
		</div>
	</div>
    <?php else: ?>
    <?php echo $__env->make('not-found', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php endif; ?>
<?php echo $__env->make('footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php echo $__env->make('script', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
</body>
</html><?php /**PATH /home/arixmyii/bittoz.shop/public_html/resources/views/pages/subscription.blade.php ENDPATH**/ ?>