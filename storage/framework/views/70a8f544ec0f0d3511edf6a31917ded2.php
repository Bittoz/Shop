<!DOCTYPE HTML>
<html lang="en">
<head>
<title><?php if($allsettings->site_blog_display == 1): ?> <?php echo e($slug); ?> <?php else: ?> <?php echo e(__('404 Not Found')); ?> <?php endif; ?> - <?php echo e($allsettings->site_title); ?></title>
<?php if($category_allow_seo == 1): ?>
<meta name="keywords" content="<?php echo e($category_seo_keyword); ?>">
<meta name="description" content="<?php echo e($category_seo_desc); ?>">
<?php else: ?>
<?php echo $__env->make('meta', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php endif; ?>
<?php echo $__env->make('style', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
</head>
<body>
<?php echo $__env->make('header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php if($allsettings->site_blog_display == 1): ?>
<section class="bg-position-center-top" style="background-image: url('<?php echo e(url('/')); ?>/public/storage/settings/<?php echo e($allsettings->site_other_banner); ?>');">
      <div class="py-4">
        <div <?php if($custom_settings->theme_layout == 'container'): ?> class="container-fluid d-lg-flex justify-content-between py-2 py-lg-3" <?php else: ?> class="container d-lg-flex justify-content-between py-2 py-lg-3" <?php endif; ?>>
        <div class="order-lg-2 mb-3 mb-lg-0 pt-lg-2">
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb flex-lg-nowrap justify-content-center justify-content-lg-star">
              <li class="breadcrumb-item"><a class="text-nowrap" href="<?php echo e(URL::to('/')); ?>"><i class="dwg-home"></i><?php echo e(__('Home')); ?></a></li>
              <li class="breadcrumb-item text-nowrap active" aria-current="page"><?php echo e($slug); ?></li>
            </ol>
          </nav>
        </div>
        <div class="order-lg-1 pr-lg-4 text-center text-lg-left">
          <h1 class="h3 mb-0 text-white"><?php echo e(__('Blog')); ?></h1>
        </div>
      </div>
      </div>
    </section>
<div <?php if($custom_settings->theme_layout == 'container'): ?> class="container-fluid pb-5 mb-2 mb-md-4" <?php else: ?> class="container pb-5 mb-2 mb-md-4" <?php endif; ?>>
      
      <div class="row pt-5 mt-2">
       <!-- Entries list-->
        <section <?php if($custom_settings->theme_layout == 'container'): ?> class="col-lg-9" <?php else: ?> class="col-lg-8" <?php endif; ?>>
          <?php if(in_array('blog',$top_ads)): ?>
          <div class="mt-2 mb-2" align="center">
             <?php echo html_entity_decode($allsettings->top_ads); ?>
          </div>
          <?php endif; ?>
          <!-- Entry-->
          <?php $__currentLoopData = $blogData['post']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <article class="blog-list border-bottom pb-4 mb-5 li-item" data-aos="fade-up" data-aos-delay="200">
            <div class="left-column">
              <div class="d-flex align-items-center font-size-sm pb-2 mb-1">
                 <div class="blog-entry-meta-link">
                  <i class="dwg-time"></i><?php echo e(date('d M Y', strtotime($post->post_date))); ?>

                  </div>
                  <span class="blog-entry-meta-divider"></span>
                  <span class="blog-entry-meta-link text-nowrap"><i class="dwg-message"></i><?php echo e($comments->has($post->post_id) ? count($comments[$post->post_id]) : 0); ?></span>
                  <span class="blog-entry-meta-divider"></span>
                  <span class="blog-entry-meta-link text-nowrap"><i class="dwg-eye"></i><?php echo e($post->post_view); ?></span>
                  </div>
              <h2 class="h5 blog-entry-title"><a href="<?php echo e(URL::to('/single')); ?>/<?php echo e($post->post_slug); ?>"><?php echo e($post->post_title); ?></a></h2>
            </div>
            <div class="right-column cz-gallery">
              <a class="blog-entry-thumb mb-3 gallery-item rounded-lg mb-grid-gutter" href="<?php echo e(url('/')); ?>/public/storage/post/<?php echo e($post->post_image); ?>" data-sub-html="<?php echo e($post->post_title); ?>">
              <?php if($post->post_image!=''): ?>
              <img src="<?php echo e(url('/')); ?>/public/storage/post/<?php echo e($post->post_image); ?>" alt="<?php echo e($post->post_title); ?>">
              <?php else: ?>
              <img src="<?php echo e(url('/')); ?>/public/img/no-image.png" alt="<?php echo e($post->post_title); ?>">
              <?php endif; ?>
              <span class="gallery-item-caption"><?php echo e($post->post_title); ?></span>
              </a>
              <div class="d-flex justify-content-between mb-1">
                <div class="font-size-sm text-muted pr-2 mb-2">
                <a href="<?php echo e(URL::to('/blog')); ?>/category/<?php echo e($post->blog_cat_id); ?>/<?php echo e($post->blog_category_slug); ?>" class="blog-entry-meta-link">
                <i class="dwg-menu-circle"></i><?php echo e($post->blog_category_name); ?></a></div>
              </div>
              <p class="font-size-sm"><?php echo e(mb_substr($post->post_short_desc, 0, 300, 'UTF-8')); ?></p>
            </div>
          </article>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          <div class="text-right">
            <div class="turn-page" id="post-pager"></div>
          </div>
          <?php if(in_array('blog',$bottom_ads)): ?>
          <div class="mt-2 mb-2" align="center">
             <?php echo html_entity_decode($allsettings->bottom_ads); ?>
          </div>
          <?php endif; ?>
        </section>
        <aside <?php if($custom_settings->theme_layout == 'container'): ?> class="col-lg-3" <?php else: ?>  class="col-lg-4" <?php endif; ?>>
          <!-- Sidebar-->
          <div class="cz-sidebar border-left ml-lg-auto" id="blog-sidebar">
             <div class="cz-sidebar-body py-lg-1" data-simplebar data-simplebar-auto-hide="true">
              <!-- Categories-->
              <div class="widget widget-links mb-grid-gutter pb-grid-gutter border-bottom">
                <h3 class="widget-title"><?php echo e(__('Categories')); ?></h3>
                <ul class="widget-list">
                  <?php $__currentLoopData = $catData['post']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <li class="widget-list-item">
                  <a class="widget-list-link d-flex justify-content-between align-items-center" href="<?php echo e(URL::to('/blog')); ?>/category/<?php echo e($post->blog_cat_id); ?>/<?php echo e($post->blog_category_slug); ?>"><span><?php echo e($post->blog_category_name); ?></span><span class="font-size-xs text-muted ml-3"><?php echo e($category_count->has($post->blog_cat_id) ? count($category_count[$post->blog_cat_id]) : 0); ?></span></a></li>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
              </div>
              <!-- Trending posts-->
              <div class="widget mb-grid-gutter pb-grid-gutter border-bottom">
                <h3 class="widget-title"><?php echo e(__('Latest Posts')); ?></h3>
                <?php $__currentLoopData = $blogPost['latest']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="media align-items-center mb-3">
                <a href="<?php echo e(URL::to('/single')); ?>/<?php echo e($post->post_slug); ?>" title="<?php echo e($post->post_title); ?>">
                   <?php if($post->post_image!=''): ?>
                   <img class="rounded" src="<?php echo e(url('/')); ?>/public/storage/post/<?php echo e($post->post_image); ?>" width="64" alt="<?php echo e($post->post_title); ?>">
                   <?php else: ?>
                   <img src="<?php echo e(url('/')); ?>/public/img/no-image.png" alt="<?php echo e($post->post_title); ?>" width="64">
                   <?php endif; ?>
                </a>
                <div class="media-body pl-3">
                    <h6 class="blog-entry-title font-size-sm mb-0"><a href="<?php echo e(URL::to('/single')); ?>/<?php echo e($post->post_slug); ?>"><?php echo e($post->post_title); ?></a></h6><span class="font-size-ms text-muted"><span class='blog-entry-meta-link'><i class="dwg-time"></i><?php echo e(date('d M Y', strtotime($post->post_date))); ?></span></span>
                  </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
               </div>
              <?php if(in_array('blog',$sidebar_ads)): ?>
             <div class="mt-2" align="center">
             <?php echo html_entity_decode($allsettings->sidebar_ads); ?>
             </div>
             <?php endif; ?>
            </div>
          </div>
        </aside>
      </div>
    </div>
<?php else: ?>
<?php echo $__env->make('not-found', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php endif; ?>
<?php echo $__env->make('footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php echo $__env->make('script', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
</body>
</html>
<?php /**PATH /home/arixmyii/bittoz.shop/public_html/resources/views/pages/blog.blade.php ENDPATH**/ ?>