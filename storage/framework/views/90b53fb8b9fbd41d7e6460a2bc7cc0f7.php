<!DOCTYPE HTML>
<html lang="en">
<head>
<title><?php echo e(__('Contact')); ?> - <?php echo e($allsettings->site_title); ?></title>
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
              <li class="breadcrumb-item text-nowrap active" aria-current="page"><?php echo e(__('Contact')); ?></li>
            </ol>
          </nav>
        </div>
        <div class="order-lg-1 pr-lg-4 text-center text-lg-left">
          <h1 class="h3 mb-0 text-white"><?php echo e(__('Contact')); ?></h1>
        </div>
      </div>
      </div>
    </section>
   <!-- Outlet stores-->
    <div class="container px-0" id="map">
      <?php if(in_array('contact',$top_ads)): ?>
      <div class="row">
          <div class="col-lg-12 mt-4" align="center">
             <?php echo html_entity_decode($allsettings->top_ads); ?>
          </div>
       </div>   
       <?php endif; ?>
      <div class="row">
        <div class="col-lg-5 px-4 px-xl-5 py-5">
          <form method="POST" action="<?php echo e(route('contact')); ?>" id="contact_form"  class="needs-validation mb-3" novalidate>
          <?php echo csrf_field(); ?>
            <div class="row">
              <div class="col-sm-6">
                <div class="form-group">
                  <label for="cf-name"><?php echo e(__('Full Name')); ?> <span class="text-danger">*</span></label>
                  <input class="form-control" type="text" id="from_name" name="from_name" data-bvalidator="required">
                </div>
              </div>
              <div class="col-sm-6">
                <div class="form-group">
                  <label for="cf-email"><?php echo e(__('Email address')); ?> <span class="text-danger">*</span></label>
                  <input class="form-control" type="text" id="cf-email" name="from_email" data-bvalidator="email,required">
                </div>
              </div>
            </div>
            <div class="form-group">
              <label for="cf-message"><?php echo e(__('Message')); ?> <span class="text-danger">*</span></label>
              <textarea class="form-control" id="cf-message" rows="6" name="message_text" data-bvalidator="required"></textarea>
            </div>
            <?php if($allsettings->site_google_recaptcha == 1): ?>
            <?php if($custom_settings->google_captcha_version == 'v3'): ?>
              <div class="col-sm-12">
              <div class="form-group<?php echo e($errors->has('g-recaptcha-response') ? ' has-error' : ''); ?>">
                            <div class="col-sm-12">
                                <?php echo RecaptchaV3::field('register'); ?>

                                <?php if($errors->has('g-recaptcha-response')): ?>
                                    <span class="help-block">
                                        <strong><?php echo e($errors->first('g-recaptcha-response')); ?></strong>
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>
              </div>
              <?php else: ?>
              <div align="left">  
                <div class="form-group <?php echo e($errors->has('g-recaptcha-response') ? ' has-error' : ''); ?>">
                <?php echo app('captcha')->display(); ?>

                <?php if($errors->has('g-recaptcha-response')): ?>
                <span class="help-block">
                <strong class="red"><?php echo e($errors->first('g-recaptcha-response')); ?></strong>
                </span>
                <?php endif; ?>
                </div>
                </div>
              <?php endif; ?>
              <?php endif; ?>
            <button class="btn btn-primary" type="submit"><?php echo e(__('Send message')); ?></button>
          </form>
        </div>
        <div class="col-lg-7 px-4 px-xl-5 py-5">
           <div class="row">
           <div class="col-md-6 mb-grid-gutter">
           <div class="card">
            <div class="card-body text-center"><i class="dwg-location h3 mt-2 mb-4 text-primary"></i>
              <h3 class="h6 mb-2"><?php echo e(__('Address')); ?></h3>
              <p class="font-size-sm text-muted"><?php echo e($allsettings->office_address); ?></p>
             </div>
            </div>
            </div>
            <div class="col-md-6 mb-grid-gutter"><a class="card" href="mailto:<?php echo e($allsettings->office_email); ?>">
          <div class="card-body text-center"><i class="dwg-mail h3 mt-2 mb-4 text-primary"></i>
              <h3 class="h6 mb-3"><?php echo e(__('Email address')); ?></h3>
              <p class="font-size-sm text-muted"><?php echo e($allsettings->office_email); ?></p>
             </div>
            </a>
          </div>
          <div class="col-md-6 mb-grid-gutter"><a class="card" href="tel:<?php echo e($allsettings->office_phone); ?>">
            <div class="card-body text-center"><i class="dwg-phone h3 mt-2 mb-4 text-primary"></i>
              <h3 class="h6 mb-2"><?php echo e(__('Phone')); ?></h3>
              <p class="font-size-sm text-muted"><?php echo e($allsettings->office_phone); ?></p>
            </div></a>
            </div>
          </div>
        </div>
        </div>
        <?php if(in_array('contact',$bottom_ads)): ?>
        <div class="row">
          <div class="col-lg-12 mt-2 mb-2" align="center">
             <?php echo html_entity_decode($allsettings->bottom_ads); ?>
          </div>
       </div>   
       <?php endif; ?>
    </div>
<?php echo $__env->make('footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php echo $__env->make('script', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
</body>
</html><?php /**PATH /home/arixmyii/bittoz.shop/public_html/resources/views/pages/contact.blade.php ENDPATH**/ ?>