<?php if($allsettings->maintenance_mode == 1): ?>
<?php if(Auth::check()): ?>
<?php if(Auth::user()->id == 1): ?>
<?php echo $__env->make('pages.tag', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php else: ?>
<?php echo $__env->make('503', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php endif; ?>
<?php else: ?>
<?php echo $__env->make('503', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php endif; ?>
<?php else: ?>
<?php echo $__env->make('pages.tag', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php endif; ?><?php /**PATH /home/arixmyii/bittoz.shop/public_html/resources/views/tag.blade.php ENDPATH**/ ?>