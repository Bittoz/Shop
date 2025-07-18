<!doctype html>
<html class="no-js" lang="en">
<head>
<title><?php echo e(__('Login')); ?> - <?php echo e($allsettings->site_title); ?></title>
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
              <li class="breadcrumb-item text-nowrap active" aria-current="page"><?php echo e(__('Login')); ?></li>
            </ol>
          </nav>
        </div>
        <div class="order-lg-1 pr-lg-4 text-center text-lg-left">
          <h1 class="h3 mb-0 text-white"><?php echo e(__('Login')); ?></h1>
        </div>
      </div>
      </div>
    </section>
<div class="container py-4 py-lg-5 my-4">
      <div class="row">
        <div class="col-md-6 mx-auto">
          <div class="card border-0 box-shadow">
            <div class="card-body">
            <?php if($allsettings->display_social_login == 1): ?>
              <h2 class="h4 mb-1"><?php echo e(__('Login')); ?></h2>
              <div class="py-3">
                <h3 class="d-inline-block align-middle font-size-base font-weight-semibold mb-2 mr-2"><?php echo e(__('With social account')); ?>:</h3>
                <div class="d-inline-block align-middle">
                <a class="social-btn sb-google mr-2 mb-2" href="<?php echo e(url('/login/google')); ?>" data-toggle="tooltip" title="Sign in with Google"><i class="dwg-google"></i></a>
                <a class="social-btn sb-facebook mr-2 mb-2" href="<?php echo e(url('/login/facebook')); ?>" data-toggle="tooltip" title="Sign in with Facebook"><i class="dwg-facebook"></i></a>
                </div>
              </div>
              <hr>
              <h3 class="font-size-base pt-4 pb-2"><?php echo e(__('Or using login form below')); ?></h3>
              <?php endif; ?>
              <form action="<?php echo e(route('login')); ?>" method="POST" id="login_form" class="<?php if($allsettings->display_social_login == 0): ?> py-3 <?php endif; ?>">
                <?php echo csrf_field(); ?>
                <div class="input-group-overlay form-group">
                  <div class="input-group-prepend-overlay"><span class="input-group-text"><i class="dwg-mail"></i></span></div>
                  <input class="form-control prepended-form-control" type="text" name="email" placeholder="<?php echo e(__('E-Mail Address / Username')); ?>" data-bvalidator="required">
                </div>
                <div class="input-group-overlay form-group">
                  <div class="input-group-prepend-overlay"><span class="input-group-text"><i class="dwg-locked"></i></span></div>
                  <div class="password-toggle">
                    <input class="form-control prepended-form-control" type="password" name="password" placeholder="<?php echo e(__('Password')); ?>" data-bvalidator="required">
                    <label class="password-toggle-btn">
                      <input class="custom-control-input" type="checkbox"><i class="dwg-eye password-toggle-indicator"></i><span class="sr-only"><?php echo e(__('Show password')); ?></span>
                    </label>
                  </div>
                </div>
                <div class="d-flex flex-wrap justify-content-between">
                  <div>
                  <a href="<?php echo e(URL::to('/register')); ?>" class="nav-link-inline font-size-sm"><?php echo e(__("Don't have an account")); ?>?</a>
                  </div><a class="nav-link-inline font-size-sm" href="<?php echo e(URL::to('/forgot')); ?>"><?php echo e(__('Forgot password')); ?>?</a>
                </div>
                <hr class="mt-4">
                <div class="text-right pt-4">
                  <button class="btn btn-primary" type="submit"><i class="dwg-sign-in mr-2 ml-n21"></i><?php echo e(__('Sign In')); ?></button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
<?php echo $__env->make('footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php echo $__env->make('script', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
</body>
</html><?php /**PATH /home/arixmyii/bittoz.shop/public_html/resources/views/auth/login.blade.php ENDPATH**/ ?>