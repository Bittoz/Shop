<header id="header" class="header">

            <div class="header-menu">

                <div class="col-sm-7">
                    <a id="menuToggle" class="menutoggle pull-left"><i class="fa fa fa-tasks"></i></a>
                    <div class="header-left">
                       <code><?php echo e(Helper::Current_Version()); ?></code> 
                    </div>
                </div>

                <div class="col-sm-5">
                    <div class="user-area dropdown float-right">
                        <a href="javascript:void();" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            
                            
                        <?php if(Auth::user()->user_photo != ''): ?>
                                                <img src="<?php echo e(url('/')); ?>/public/storage/users/<?php echo e(Auth::user()->user_photo); ?>"  class="user-avatar rounded-circle" alt="<?php echo e(Auth::user()->name); ?>"/><?php else: ?> <img src="<?php echo e(url('/')); ?>/public/img/no-user.png"  class="user-avatar rounded-circle" alt="<?php echo e(Auth::user()->name); ?>"/>  <?php endif; ?>
                        
                        </a>
<div class="user-menu dropdown-menu">
                            <a class="nav-link" href="<?php echo e(url('/admin/edit-profile')); ?>"><i class="fa fa-user"></i> <?php echo e(__('My Profile')); ?></a>
                            <?php if(in_array('settings',$avilable)): ?>
                            <a class="nav-link" href="<?php echo e(url('/admin/general-settings')); ?>"><i class="fa fa-cog"></i> <?php echo e(__('Settings')); ?></a>
                            <?php endif; ?>
                            <a class="nav-link" href="<?php echo e(url('/logout')); ?>"><i class="fa fa-power-off"></i> <?php echo e(__('Logout')); ?></a>
                        </div>
                        </div>
                        <?php if($allsettings->site_google_translate == 1): ?>
                       <div class="language-select dropdown" id="language-select">
                        <a class="dropdown-toggle" href="#" data-toggle="dropdown"  id="language" aria-haspopup="true" aria-expanded="true">
                            <span class="fa fa-language"></span> <?php echo e($current_locale); ?>

                        </a>
                        <div class="dropdown-menu" aria-labelledby="language">
                            <?php $__currentLoopData = $available_locales; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $locale_name => $available_locale): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="dropdown-item">
                                <a href="<?php echo e(URL::to('/language')); ?>/<?php echo e($available_locale); ?>"><?php echo e($locale_name); ?></a>
                            </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                   <?php endif; ?> 
                    

                </div>
            </div>

        </header>
                    <?php /**PATH /home/arixmyii/bittoz.shop/public_html/resources/views/admin/header.blade.php ENDPATH**/ ?>