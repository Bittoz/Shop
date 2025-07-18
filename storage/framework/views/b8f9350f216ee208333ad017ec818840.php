<aside id="left-panel" class="left-panel">
        <nav class="navbar navbar-expand-sm navbar-default">
            <div class="navbar-header">
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#main-menu" aria-controls="main-menu" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="fa fa-bars"></i>
                </button>
                <?php if($allsettings->site_logo != ''): ?>
                <a class="navbar-brand" href="<?php echo e(url('/')); ?>"><?php echo e(mb_substr($allsettings->site_title, 0, 10, 'UTF-8')); ?><?php /*?><img src="{{ url('/') }}/public/storage/settings/{{ $allsettings->site_logo }}"  alt="{{ $allsettings->site_title }}" width="180"/><?php */?></a>
                <?php else: ?>
                <a class="navbar-brand" href="<?php echo e(url('/')); ?>"><?php echo e(mb_substr($allsettings->site_title, 0, 10, 'UTF-8')); ?></a>
                <?php endif; ?>
                <?php if($allsettings->site_favicon != ''): ?>
                <a class="navbar-brand hidden" href="<?php echo e(url('/')); ?>"><img src="<?php echo e(url('/')); ?>/public/storage/settings/<?php echo e($allsettings->site_favicon); ?>"  alt="<?php echo e($allsettings->site_title); ?>" width="24"/></a>
                <?php else: ?>
                <a class="navbar-brand hidden" href="<?php echo e(url('/')); ?>"><?php echo e(mb_substr($allsettings->site_title, 0, 1, 'UTF-8')); ?></a>
                <?php endif; ?>
            </div>
            <div id="main-menu" class="main-menu collapse navbar-collapse">
                <?php if($custom_settings->$dg_ver == 1): ?> 
                <ul class="nav navbar-nav">
                    <?php if(in_array('dashboard',$avilable)): ?>
                    <li>
                        <a href="<?php echo e(url('/admin')); ?>"> <i class="menu-icon fa fa-dashboard"></i><?php echo e(__('Dashboard')); ?> </a>
                    </li>
                    <?php endif; ?>
                    <?php if(in_array('settings',$avilable)): ?>
                    <li class="menu-item-has-children dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-gears"></i><?php echo e(__('Settings')); ?></a>
                        <ul class="sub-menu children dropdown-menu">
                            <li><i class="fa fa-gear"></i><a href="<?php echo e(url('/admin/general-settings')); ?>"><?php echo e(__('General Settings')); ?></a></li>
                            <li><i class="fa fa-gear"></i><a href="<?php echo e(url('/admin/color-settings')); ?>"><?php echo e(__('Color Settings')); ?></a></li>
                            <li><i class="fa fa-gear"></i><a href="<?php echo e(url('/admin/email-settings')); ?>"><?php echo e(__('Email Settings')); ?></a></li>
                            <li><i class="fa fa-gear"></i><a href="<?php echo e(url('/admin/media-settings')); ?>"><?php echo e(__('Media Settings')); ?></a></li>
                            <li><i class="fa fa-gear"></i><a href="<?php echo e(url('/admin/currency-settings')); ?>"><?php echo e(__('Currency Settings')); ?></a></li>
                            <li><i class="fa fa-gear"></i><a href="<?php echo e(url('/admin/payment-settings')); ?>"><?php echo e(__('Payment Settings')); ?></a></li>
                            <li><i class="fa fa-gear"></i><a href="<?php echo e(url('/admin/social-settings')); ?>"><?php echo e(__('Social Settings')); ?></a></li>
                            <li><i class="fa fa-gear"></i><a href="<?php echo e(url('/admin/limitation-settings')); ?>"><?php echo e(__('Limitation Settings')); ?></a></li>
                            <li><i class="fa fa-gear"></i><a href="<?php echo e(url('/admin/preferred-settings')); ?>"><?php echo e(__('Preferred Settings')); ?></a></li>
                            <li><i class="fa fa-gear"></i><a href="<?php echo e(url('/admin/pwa-settings')); ?>"><?php echo e(__('PWA Settings')); ?></a></li>
                            <li><i class="fa fa-gear"></i><a href="<?php echo e(url('/admin/theme-settings')); ?>"><?php echo e(__('Theme Settings')); ?></a></li>
                        </ul>
                    </li>
                    <?php endif; ?>
                    <?php if(in_array('country',$avilable)): ?>
                    <li>
                        <a href="<?php echo e(url('/admin/country-settings')); ?>"> <i class="menu-icon fa fa-flag"></i><?php echo e(__('Country')); ?></a>
                    </li>
                    <?php endif; ?>
                    <?php if(Auth::user()->id == 1): ?>
                    <li>
                        <a href="<?php echo e(url('/admin/administrator')); ?>"> <i class="menu-icon ti-user"></i><?php echo e(__('Sub Administrator')); ?> </a>
                    </li>
                    <?php endif; ?>
                    <?php if(in_array('customers',$avilable)): ?>
                    <li>
                        <a href="<?php echo e(url('/admin/customer')); ?>"> <i class="menu-icon ti-user"></i><?php echo e(__('Customers')); ?> </a>
                    </li>
                    <?php endif; ?>
                    <?php /*?>@if(in_array('category',$avilable))
                    <li>
                        <a href="{{ url('/admin/category') }}"> <i class="menu-icon fa fa-location-arrow"></i>{{ __('Category') }} </a>
                    </li>
                    @endif<?php */?>
                    <?php if(in_array('subscription',$avilable)): ?>
                    <?php if($allsettings->subscription_mode == 1): ?>
                    <li>
                        <a href="<?php echo e(url('/admin/subscription')); ?>"> <i class="menu-icon fa fa-user"></i><?php echo e(__('Subscription')); ?> </a>
                    </li>
                    <?php endif; ?>
                    <?php endif; ?>
                    <?php if(in_array('manage-products',$avilable)): ?>
                    <li class="menu-item-has-children dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-shopping-cart"></i><?php echo e(__('Manage Products')); ?></a>
                        <ul class="sub-menu children dropdown-menu">
                            <li><i class="menu-icon fa fa-location-arrow"></i><a href="<?php echo e(url('/admin/category')); ?>"><?php echo e(__('Category')); ?></a></li>
                            <li><i class="menu-icon fa fa-location-arrow"></i><a href="<?php echo e(url('/admin/sub-category')); ?>"><?php echo e(__('Sub Category')); ?></a></li>
                            <li><i class="menu-icon fa fa-location-arrow"></i><a href="<?php echo e(url('/admin/products')); ?>"><?php echo e(__('Products')); ?></a></li>
                            <?php /*?><li><i class="menu-icon fa fa-shopping-cart"></i><a href="{{ url('/admin/package-includes') }}">{{ __('Package Includes') }}</a></li>
                            <li><i class="menu-icon fa fa-shopping-cart"></i><a href="{{ url('/admin/compatible-browsers') }}">{{ __('Compatible Browsers') }}</a></li><?php */?>
                            <li><i class="menu-icon fa fa-location-arrow"></i><a href="<?php echo e(url('/admin/attributes')); ?>"><?php echo e(__('Attributes')); ?></a></li>
                            <?php /*?><li><i class="menu-icon fa fa-location-arrow"></i><a href="{{ url('/admin/reports') }}">{{ __('Reports') }}</a></li><?php */?>
                            
                        </ul>
                    </li>
                    <?php endif; ?>
                    <?php if(in_array('orders',$avilable)): ?>
                    <li>
                        <a href="<?php echo e(url('/admin/orders')); ?>"> <i class="menu-icon fa fa-first-order"></i><?php echo e(__('Orders')); ?> </a>
                    </li>
                    <?php endif; ?>
                    <?php if($allsettings->site_refund_display == 1): ?>
                    <?php if(in_array('refund-request',$avilable)): ?>
                    <li>
                        <a href="<?php echo e(url('/admin/refund')); ?>"> <i class="menu-icon fa fa-undo"></i><?php echo e(__('Refund Request')); ?> </a>
                    </li>
                    <?php endif; ?>
                    <?php endif; ?>
                    <?php /*?>@if(in_array('rating-reviews',$avilable))
                    <li>
                        <a href="{{ url('/admin/rating') }}"> <i class="menu-icon fa fa-star"></i>{{ __('Rating & Reviews') }}</a>
                    </li>
                    @endif<?php */?>
                    <?php if($allsettings->site_withdrawal_display == 1): ?>
                    <?php if(in_array('withdrawal',$avilable)): ?> 
                    <li class="menu-item-has-children dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-money"></i><?php echo e(__('Withdrawals')); ?></a>
                        <ul class="sub-menu children dropdown-menu">
                            <li><i class="menu-icon fa fa-location-arrow"></i><a href="<?php echo e(url('/admin/withdrawal')); ?>"><?php echo e(__('Withdrawal Request')); ?></a></li>
                            <li><i class="menu-icon fa fa-location-arrow"></i><a href="<?php echo e(url('/admin/withdrawal-methods')); ?>"><?php echo e(__('Withdraw Methods')); ?></a></li>
                        </ul>
                    </li>
                    <?php endif; ?>
                    <?php endif; ?>
                    <?php if($allsettings->site_blog_display == 1): ?>
                    <?php if(in_array('blog',$avilable)): ?>  
                    <li class="menu-item-has-children dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-comments-o"></i><?php echo e(__('Blog')); ?></a>
                        <ul class="sub-menu children dropdown-menu">
                            <li><i class="menu-icon fa fa-comments-o"></i><a href="<?php echo e(url('/admin/blog-category')); ?>"><?php echo e(__('Category')); ?></a></li>
                            <li><i class="menu-icon fa fa-comments-o"></i><a href="<?php echo e(url('/admin/post')); ?>"><?php echo e(__('Post')); ?></a></li>
                        </ul>
                    </li>
                    <?php endif; ?>
                    <?php endif; ?>
                    <?php if($allsettings->google_ads == 1): ?>
                    <?php if(in_array('ads',$avilable)): ?> 
                    <li>
                        <a href="<?php echo e(url('/admin/ads')); ?>"> <i class="menu-icon fa fa-file-image-o"></i><?php echo e(__('Ads')); ?> </a>
                    </li>
                    <?php endif; ?>
                    <?php endif; ?>
                    <?php if(in_array('voucher',$avilable)): ?>
                    <li>
                        <a href="<?php echo e(url('/admin/voucher-code')); ?>"> <i class="menu-icon fa fa-gift"></i><?php echo e(__('Prepaid Vouchers')); ?> </a>
                    </li>
                    <?php endif; ?>
                    <?php if(in_array('coupons',$avilable)): ?>
                    <li>
                        <a href="<?php echo e(url('/admin/coupons')); ?>"> <i class="menu-icon fa fa-percent"></i><?php echo e(__('Discount Coupons')); ?> </a>
                    </li>
                    <?php endif; ?>
                    <?php if(in_array('tickets',$avilable)): ?>
                    <li>
                        <a href="<?php echo e(url('/admin/tickets')); ?>"> <i class="menu-icon fa fa-ticket"></i><?php echo e(__('Support Tickets')); ?> </a>
                    </li>
                    <?php endif; ?>
                    <?php if(in_array('pages',$avilable)): ?> 
                    <li>
                        <a href="<?php echo e(url('/admin/pages')); ?>"> <i class="menu-icon fa fa-file-text-o"></i><?php echo e(__('Pages')); ?> </a>
                    </li>
                    <?php endif; ?>
                    <?php if(in_array('contact',$avilable)): ?>
                    <li>
                        <a href="<?php echo e(url('/admin/contact')); ?>"> <i class="menu-icon fa fa-address-book-o"></i><?php echo e(__('Contact')); ?> </a>
                    </li>
                    <?php endif; ?>
                    <?php if(in_array('etemplate',$avilable)): ?>
                    <li>
                        <a href="<?php echo e(url('/admin/email-template')); ?>"> <i class="menu-icon fa fa-envelope"></i><?php echo e(__('Email Template')); ?> </a>
                    </li>
                    <?php endif; ?>
                    <?php if(in_array('maintenance',$avilable)): ?>
                    <li>
                        <a href="<?php echo e(url('/admin/website-maintenance')); ?>"> <i class="menu-icon fa fa-wrench"></i><?php echo e(__('Website Maintenance')); ?> </a>
                    </li>
                    <?php endif; ?>
                    <?php if($allsettings->site_newsletter_display == 1): ?>
                    <?php if(in_array('newsletter',$avilable)): ?>
                    <li>
                        <a href="<?php echo e(url('/admin/newsletter')); ?>"> <i class="menu-icon fa fa-newspaper-o"></i><?php echo e(__('Newsletter')); ?> </a>
                    </li>
                    <?php endif; ?>
                    <?php endif; ?>
                    <?php if(in_array('clear-cache',$avilable)): ?>
                    <li>
                        <a href="<?php echo e(url('/admin/clear-cache')); ?>" onClick="return confirm('<?php echo e(__('Are you sure you want to clear cache')); ?>?');"> <i class="menu-icon fa fa-trash"></i><?php echo e(__('Clear Cache')); ?> </a>
                    </li>
                    <?php endif; ?>
                    <?php if(in_array('upgrade',$avilable)): ?>
                    <li>
                        <a href="<?php echo e(url('/admin/upgrade')); ?>"> <i class="menu-icon fa fa-refresh"></i><?php echo e(__('Upgrade')); ?> </a>
                    </li>
                    <?php endif; ?>
                    <?php if(in_array('backups',$avilable)): ?>
                    <li>
                        <a href="<?php echo e(url('/admin/backup')); ?>"> <i class="menu-icon fa fa-hdd-o"></i><?php echo e(__('Backups')); ?> </a>
                    </li>
                    <?php endif; ?>
                  </ul>
                  <?php endif; ?>
            </div><!-- /.navbar-collapse -->
        </nav>
    </aside><?php /**PATH /home/arixmyii/bittoz.shop/public_html/resources/views/admin/navigation.blade.php ENDPATH**/ ?>