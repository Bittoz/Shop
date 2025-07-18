<?php if($allsettings->maintenance_mode == 1): ?>
<?php if(Auth::check()): ?>
<?php if(Auth::user()->id == 1): ?>
<?php if($custom_settings->shop_search_type == 'normal'): ?>
<?php echo $__env->make('pages.shop-normal', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php else: ?>
<?php echo $__env->make('pages.shop-ajax', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php endif; ?>
<?php else: ?>
<?php echo $__env->make('503', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php endif; ?>
<?php else: ?>
<?php echo $__env->make('503', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php endif; ?>
<?php else: ?>
<?php if($custom_settings->shop_search_type == 'normal'): ?>
<?php echo $__env->make('pages.shop-normal', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php else: ?>
<?php echo $__env->make('pages.shop-ajax', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php endif; ?>
<?php endif; ?><?php /**PATH /home/arixmyii/bittoz.shop/public_html/resources/views/shop.blade.php ENDPATH**/ ?>