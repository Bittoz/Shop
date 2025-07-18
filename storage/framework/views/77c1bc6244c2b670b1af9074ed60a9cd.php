<?php if($message = Session::get('success')): ?>
<div class="toast-container toast-top-center">
      <div class="toast mb-3" id="cart-toast-success" data-delay="5000" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header bg-success text-white"><i class="dwg-check-circle mr-2"></i>
          <h6 class="font-size-sm text-white mb-0 mr-auto"><?php echo e(__('Success')); ?>!</h6>
          <button class="close text-white ml-2 mb-1" type="button" data-dismiss="toast" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        <div class="toast-body"><?php echo e($message); ?></div>
      </div>
    </div>
<?php endif; ?> 
<?php if($message = Session::get('error')): ?>
<div class="toast-container toast-top-center">
      <div class="toast mb-3" id="cart-toast-error" data-delay="5000" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header bg-danger text-white"><i class="dwg-close-circle mr-2"></i>
          <h6 class="font-size-sm text-white mb-0 mr-auto"><?php echo e(__('Error')); ?>!</h6>
          <button class="close text-white ml-2 mb-1" type="button" data-dismiss="toast" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        <div class="toast-body text-danger"><?php echo e($message); ?></div>
      </div>
    </div>
<?php endif; ?>
<?php if(!$errors->isEmpty()): ?>
<div class="toast-container toast-top-center">
      <div class="toast mb-3" id="cart-toast-error" data-delay="5000" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header bg-danger text-white"><i class="dwg-close-circle mr-2"></i>
          <h6 class="font-size-sm text-white mb-0 mr-auto"><?php echo e(__('Error')); ?>!</h6>
          <button class="close text-white ml-2 mb-1" type="button" data-dismiss="toast" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="toast-body text-danger">
        <?php echo e($error); ?>

        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </div>
    </div>
<?php endif; ?>
<footer class="bg-darker pt-5">
      <div <?php if($custom_settings->theme_layout == 'container'): ?> class="container-fluid" <?php else: ?> class="container" <?php endif; ?>>
        <div class="row pb-2">
          <div class="col-md-3 col-sm-4">
            <div class="widget widget-links widget-light pb-2 mb-4">
              <h3 class="widget-title text-dark font-weight-bold"><?php echo e(__('Categories')); ?></h3>
              <ul class="widget-list">
                <?php $__currentLoopData = $footer_menu['category']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $menu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li class="widget-list-item"><a class="widget-list-link" href="<?php echo e(URL::to('/shop/category')); ?>/<?php echo e($menu->category_slug); ?>"><?php echo e($menu->category_name); ?></a></li> 
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              </ul>
            </div>
          </div>
          <div class="col-md-3 col-sm-4">
            <div class="widget widget-links widget-light pb-2 mb-4">
              <h3 class="widget-title text-dark font-weight-bold"><?php echo e(__('More Info')); ?></h3>
              <ul class="widget-list">
                <?php if($allsettings->site_blog_display == 1): ?>
                <li class="widget-list-item"><a class="widget-list-link" href="<?php echo e(URL::to('/blog')); ?>"><?php echo e(__('Blog')); ?></a></li>
                <?php endif; ?>
                <li class="widget-list-item"><a class="widget-list-link" href="<?php echo e(URL::to('/shop')); ?>"><?php echo e(__('Shop')); ?></a></li>
                <li class="widget-list-item"><a class="widget-list-link" href="<?php echo e(URL::to('/my-favourite')); ?>"><?php echo e(__('My Favourite')); ?></a></li>
                <li class="widget-list-item"><a class="widget-list-link" href="<?php echo e(URL::to('/my-purchases')); ?>"><?php echo e(__('My Purchases')); ?></a></li>
                <li class="widget-list-item"><a class="widget-list-link" href="<?php echo e(URL::to('/contact')); ?>"><?php echo e(__('Contact')); ?></a></li>
              </ul>
            </div>
          </div>
          <div class="col-md-3 col-sm-4">
          <div class="widget widget-links widget-light pb-2 mb-4">
              <h3 class="widget-title text-dark font-weight-bold"><?php echo e(__('Pages')); ?></h3>
              <ul class="widget-list">
                <?php $__currentLoopData = $footerpages['pages']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pages): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li class="widget-list-item"><a class="widget-list-link" href="<?php echo e(URL::to('/')); ?>/<?php echo e($pages->page_slug); ?>"><?php echo e($pages->page_title); ?></a></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              </ul>
            </div>
          </div>
          <div class="col-md-3 col-sm-4">
            <?php if($allsettings->site_newsletter_display == 1): ?>
            <div class="widget pb-2 mb-4">
              <h3 class="widget-title text-dark font-weight-bold pb-1"><?php echo e(__('Newsletter')); ?></h3>
              <form class="validate" action="<?php echo e(route('newsletter')); ?>" method="post" name="mc-embedded-subscribe-form" id="footer_form" enctype="multipart/form-data">
                <?php echo e(csrf_field()); ?>

                <div class="input-group input-group-overlay flex-nowrap">
                  <div class="input-group-prepend-overlay"><span class="input-group-text text-muted font-size-base"><i class="dwg-mail"></i></span></div>
                  <input class="form-control prepended-form-control" type="email" id="mce-EMAIL" value="" placeholder="<?php echo e(__('Enter your email address')); ?>" data-bvalidator="required" name="news_email">
                  <div class="input-group-append">
                    <button class="btn btn-primary" type="submit" name="subscribe" id="mc-embedded-subscribe"><?php echo e(__('Subscribe')); ?></button>
                  </div>
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
                <div class="mt-2" align="left">  
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
                <small class="form-text text-dark opacity-40" id="mc-helper"><?php echo e(__('Want more script,themes & templates? Subscribe to our mailing list to receive an update when new items arrive')); ?>!</small>
                <div class="subscribe-status"></div>
              </form>
            </div>
            <?php endif; ?>
            <?php if($custom_settings->app_store_url != "" || $custom_settings->google_play_url): ?>
            <div class="widget pb-2 mb-4">
              <h3 class="widget-title text-dark font-weight-bold pb-1"><?php echo e(__('Download our app')); ?></h3>
              <div class="d-flex flex-wrap">
                <?php if($custom_settings->app_store_url != ""): ?>
                <div class="mr-2 mb-2"><a class="btn-market btn-apple" href="<?php echo e($custom_settings->app_store_url); ?>" role="button" target="_blank"><span class="btn-market-subtitle"><?php echo e(__('Download on the')); ?></span><span class="btn-market-title"><?php echo e(__('App Store')); ?></span></a></div>
                <?php endif; ?>
                <?php if($custom_settings->google_play_url != ""): ?>
                <div class="mb-2"><a class="btn-market btn-google" href="<?php echo e($custom_settings->google_play_url); ?>" role="button" target="_blank"><span class="btn-market-subtitle"><?php echo e(__('Download on the')); ?></span><span class="btn-market-title"><?php echo e(__('Google Play')); ?></span></a></div>
                <?php endif; ?>
              </div>
            </div>
            <?php endif; ?>
          </div>
        </div>
      </div>
      <div class="pt-5 bg-darker">
        <div <?php if($custom_settings->theme_layout == 'container'): ?> class="container-fluid" <?php else: ?> class="container" <?php endif; ?>>
          <hr class="hr-light pb-4 mb-3">
          <div class="row pb-2">
            <div class="col-md-6 text-center text-md-left mb-1">
              <div class="text-nowrap mb-4">
              <a class="d-inline-block align-middle mt-n1 mr-3 mb-3" href="<?php echo e(URL::to('/')); ?>">
                <?php if($allsettings->site_logo != ''): ?>
                <img class="d-block" width="180" src="<?php echo e(url('/')); ?>/public/storage/settings/<?php echo e($allsettings->site_logo); ?>" alt="<?php echo e($allsettings->site_title); ?>"/>
                <?php endif; ?>
                </a>
                <div class="d-flex flex-wrap justify-content-center justify-content-md-start">
                <?php if($custom_settings->item_sold_display == 1): ?>
                <h6 class="pr-3 mr-3"><span class="text-primary font-weight-bold"><?php if($allsettings->item_sold_count == ""): ?><?php echo e($count_sold); ?><?php else: ?><?php echo e($allsettings->item_sold_count); ?><?php endif; ?> </span><span class="font-weight-normal text-dark"><?php echo e(__('Item Sold')); ?></span></h6>
                <?php endif; ?>
                <?php if($custom_settings->members_count_display == 1): ?>
            <h6 class="mr-3"><span class="text-primary font-weight-bold"><?php if($allsettings->members_count == ""): ?><?php echo e($total_customer); ?><?php else: ?><?php echo e($allsettings->members_count); ?><?php endif; ?> </span><span class="font-weight-normal text-dark"><?php echo e(__('Members')); ?></span></h6>
            <?php endif; ?>
              </div>
              </div>
            </div>
            <div class="col-md-6 text-center text-md-right mb-1">
              <div class="mb-3">
                <?php if($allsettings->facebook_url != ''): ?>
                <a class="social-btn sb-outline sb-facebook mr-2 mb-2" href="<?php echo e($allsettings->facebook_url); ?>" target="_blank"><i class="dwg-facebook"></i></a>
                <?php endif; ?>
                <?php if($allsettings->twitter_url != ''): ?>
                <a class="social-btn sb-outline sb-twitter mr-2 mb-2" href="<?php echo e($allsettings->twitter_url); ?>" target="_blank"><i class="dwg-twitter"></i></a>
                <?php endif; ?>
                <?php if($allsettings->pinterest_url != ''): ?>
                <a class="social-btn sb-outline sb-pinterest mr-2 mb-2" href="<?php echo e($allsettings->pinterest_url); ?>" target="_blank"><i class="dwg-pinterest"></i></a>
                <?php endif; ?>
                <?php if($allsettings->gplus_url != ''): ?>
                <a class="social-btn sb-outline sb-dribbble mr-2 mb-2" href="<?php echo e($allsettings->gplus_url); ?>" target="_blank"><i class="fa fa-whatsapp"></i></a>
                <?php endif; ?>
                <?php if($allsettings->instagram_url != ''): ?>
                <a class="social-btn sb-outline sb-behance mb-2" href="<?php echo e($allsettings->instagram_url); ?>" target="_blank"><i class="dwg-instagram"></i></a>
                <?php endif; ?>
              </div>
              <div class="mt-2">
              <?php if(!empty($custom_settings->available_payment_methods)): ?><img class="d-inline-block" width="187" src="<?php echo e(url('/')); ?>/public/storage/settings/<?php echo e($custom_settings->available_payment_methods); ?>" alt="<?php echo e($allsettings->site_title); ?>"/><?php endif; ?>
              </div>
            </div>
          </div>
          <div class="pb-4 font-size-xs text-dark opacity-40 text-center text-md-left"><?php echo html_entity_decode($allsettings->site_copyright); ?> <?php echo e($allsettings->site_title); ?></div>
        </div>
      </div>
    </footer>
    <?php if($allsettings->cookie_popup == 1): ?>
    <div class="alert text-center cookiealert" role="alert">
        <?php echo e($allsettings->cookie_popup_text); ?>

        <button type="button" class="btn btn-primary btn-sm acceptcookies" aria-label="Close">
            <?php echo e($allsettings->cookie_popup_button); ?>

        </button>
    </div>
    <?php endif; ?>
    <a class="btn-scroll-top" href="#top" data-scroll><span class="btn-scroll-top-tooltip text-muted font-size-sm mr-2"><?php echo e(__('Top')); ?></span><i class="btn-scroll-top-icon dwg-arrow-up"></i></a><?php /**PATH /home/arixmyii/bittoz.shop/public_html/resources/views/footer.blade.php ENDPATH**/ ?>