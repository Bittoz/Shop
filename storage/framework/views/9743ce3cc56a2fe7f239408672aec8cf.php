<!DOCTYPE HTML>
<html lang="en">
<head>
<title><?php echo e($allsettings->site_home_title); ?> - <?php echo e($allsettings->site_title); ?></title>
<?php echo $__env->make('meta', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php echo $__env->make('style', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
</head>
<body>
<?php echo $__env->make('header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
 <section class="bg-position-center-top bg-no-repeat py-5" style="background-image: url('<?php echo e(url('/')); ?>/public/storage/settings/<?php echo e($allsettings->site_banner); ?>');">
      <div class="mb-lg-3 pb-4 pt-5">
        <div class="container">
          <div class="row mb-4 mb-sm-5">
            <div class="col-lg-7 col-md-9 text-center text-sm-left">
              <h1 class="text-black line-height-base"><?php echo e($allsettings->site_banner_heading); ?></h1>
              <h2 class="h5 text-black font-weight-light"><?php echo e($allsettings->site_banner_sub_heading); ?></h2>
            </div>
          </div>
          <form action="<?php echo e(route('shop')); ?>" id="search_form" method="post" class="form-noborder searchbox" enctype="multipart/form-data">
          <?php echo e(csrf_field()); ?>

          <div class="row pb-lg-5 mb-4 mb-sm-5">
            <div class="col-lg-6 col-md-8">
              <div class="input-group input-group-overlay input-group-lg">
                <div class="input-group-prepend-overlay"><span class="input-group-text"><i class="dwg-search"></i></span></div>
                <input class="form-control form-control-lg prepended-form-control rounded-right-0" type="text" id="product_item" name="product_item" placeholder="<?php echo e(__('Search your products')); ?>..."><div class="input-group-append">
                  <button class="btn btn-primary btn-lg font-size-base" type="submit"><?php echo e(__('Search Now')); ?></button>
                </div>
              </div>
            </div>
          </div>
          </form>
        </div>
      </div>
    </section>
    <?php if(in_array('home',$top_ads)): ?>
    <section <?php if($custom_settings->theme_layout == 'container'): ?> class="container-fluid mb-lg-1" <?php else: ?> class="container mb-lg-1" <?php endif; ?> data-aos="fade-up" data-aos-delay="200">
      <div class="row">
          <div class="col-lg-12 mb-1" align="center">
             <?php echo html_entity_decode($allsettings->top_ads); ?>
          </div>
       </div>   
    </section>   
    <?php endif; ?>
    <section <?php if($custom_settings->theme_layout == 'container'): ?> class="container-fluid mb-lg-1" <?php else: ?> class="container mb-lg-1" <?php endif; ?> data-aos="fade-up" data-aos-delay="200">
      <!-- Heading-->
      <div class="d-flex flex-wrap justify-content-between align-items-center pt-1 border-bottom pb-4 mb-4">
        <h2 class="h3 mb-0 pt-3 mr-2" data-aos="fade-down" data-aos-delay="100"><?php echo e(__('Categories')); ?></h2>
        <div class="pt-3" data-aos="fade-down" data-aos-delay="100">
          <a class="btn btn-outline-accent" href="<?php echo e(URL::to('/shop')); ?>"><?php echo e(__('View All')); ?><i class="dwg-arrow-right font-size-ms ml-1"></i></a>
        </div>
      </div>
      <!-- Grid-->
      <div class="row pt-2 mx-n2">
       <div class="container-fluid">
        <div class="row">
        <?php $__currentLoopData = $category_box; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $categorybox): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div <?php if($custom_settings->theme_layout == 'container'): ?> class="col-6 col-xs-6 col-sm-6 col-md-4 col-lg-2" <?php else: ?> class="col-6 col-xs-6 col-sm-6 col-md-4 col-lg-3" <?php endif; ?>>
        <a href="<?php echo e(URL::to('/shop/category/')); ?>/<?php echo e($categorybox->category_slug); ?>" class="feature-box aos aos-init aos-animate" data-aos="fade-up">
        <div class="feature-icon">
        <span>
        <img src="<?php echo e(url('/')); ?>/public/storage/category/<?php echo e($categorybox->category_icon); ?>" alt="<?php echo e($categorybox->category_name); ?>">
        </span>
        </div>
        <h5><?php echo e($categorybox->category_name); ?></h5>
        <div class="feature-overlay">
        <img src="<?php echo e(url('/')); ?>/public/storage/category/<?php echo e($categorybox->category_image); ?>" alt="<?php echo e($categorybox->category_name); ?>">
        </div>
        </a>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
       </div>
      </div>
     </div>
    </section>
<?php if(count($featured_products) != 0): ?>
<section <?php if($custom_settings->theme_layout == 'container'): ?> class="container-fluid mb-lg-1" <?php else: ?> class="container mb-lg-1" <?php endif; ?> data-aos="fade-up" data-aos-delay="200">
      <!-- Heading-->
      <div class="d-flex flex-wrap justify-content-between align-items-center pt-1 border-bottom pb-4 mb-4">
        <h2 class="h3 mb-0 pt-3 mr-2" data-aos="fade-down" data-aos-delay="100"><?php echo e(__('Featured Items')); ?></h2>
        <div class="pt-3" data-aos="fade-down" data-aos-delay="100">
          <a class="btn btn-outline-accent" href="<?php echo e(URL::to('/featured-items')); ?>"><?php echo e(__('Browse All Items')); ?><i class="dwg-arrow-right font-size-ms ml-1"></i></a>
        </div>
      </div>
      <!-- Grid-->
      <div class="row pt-2 mx-n2">
        <!-- Product-->
        <?php $no = 1; ?>
        <?php $__currentLoopData = $featured_products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $featured): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php
        $price = Helper::price_info($featured->product_flash_sale,$featured->regular_price);
        $count_rating = Helper::count_rating($featured->ratings);
        
        ?>
        
        <div <?php if($custom_settings->theme_layout == 'container'): ?> class="col-6 col-xs-6 col-sm-6 col-md-4 col-lg-2 px-2 mb-grid-gutter" <?php else: ?> class="col-6 col-xs-6 col-sm-6 col-md-4 col-lg-3 px-2 mb-grid-gutter" <?php endif; ?>>
          <!-- Product-->
          <div class="card product-card-alt">
            <div class="product-thumb">
              <?php if(Auth::guest()): ?> 
              <a class="btn-wishlist btn-sm" href="<?php echo e(URL::to('/login')); ?>"><i class="dwg-heart"></i></a>
              <?php endif; ?>
              <?php if(Auth::check()): ?>
              <?php if($featured->user_id != Auth::user()->id): ?>
              <a class="btn-wishlist btn-sm" href="<?php echo e(url('/item')); ?>/<?php echo e(base64_encode($featured->product_id)); ?>/favorite/<?php echo e(base64_encode($featured->product_liked)); ?>"><i class="dwg-heart"></i></a>
              <?php endif; ?>
              <?php endif; ?>
              <div class="product-card-actions"><a class="btn btn-light btn-icon btn-shadow font-size-base mx-2" href="<?php echo e(URL::to('/item')); ?>/<?php echo e($featured->product_slug); ?>"><i class="dwg-eye"></i></a>
              <?php
              $checkif_purchased = Helper::if_purchased($featured->product_token);
              ?>
              <?php if($checkif_purchased == 0): ?>
              <?php if(Auth::check()): ?>
              <?php if(Auth::user()->id != 1): ?>
              <a class="btn btn-light btn-icon btn-shadow font-size-base mx-2" href="<?php echo e(URL::to('/add-to-cart')); ?>/<?php echo e($featured->product_slug); ?>"><i class="dwg-cart"></i></a>
              <?php endif; ?>
              <?php else: ?>
              <a class="btn btn-light btn-icon btn-shadow font-size-base mx-2" href="<?php echo e(URL::to('/add-to-cart')); ?>/<?php echo e($featured->product_slug); ?>"><i class="dwg-cart"></i></a>
              <?php endif; ?>
              <?php endif; ?>
              </div><a class="product-thumb-overlay" href="<?php echo e(URL::to('/item')); ?>/<?php echo e($featured->product_slug); ?>"></a>
              <?php if($featured->product_image!=''): ?>
              <img src="<?php echo e(url('/')); ?>/public/storage/product/<?php echo e($featured->product_image); ?>" alt="<?php echo e($featured->product_name); ?>">
              <?php else: ?>
              <img src="<?php echo e(url('/')); ?>/public/img/no-image.png" alt="<?php echo e($featured->product_name); ?>">
              <?php endif; ?>
            </div>
            <div class="card-body">
              <div class="d-flex flex-wrap justify-content-between align-items-start pb-2">
                <div class="text-muted font-size-xs mr-1"><a class="product-meta font-weight-medium" href="<?php echo e(URL::to('/shop')); ?>/category/<?php echo e($featured->category_slug); ?>"><?php echo e($featured->category_name); ?></a></div>
                <div class="star-rating">
                    <?php if($count_rating == 0): ?>
                    <i class="sr-star dwg-star"></i>
                    <i class="sr-star dwg-star"></i>
                    <i class="sr-star dwg-star"></i>
                    <i class="sr-star dwg-star"></i>
                    <i class="sr-star dwg-star"></i>
                    <?php endif; ?>
                    <?php if($count_rating == 1): ?>
                    <i class="sr-star dwg-star-filled active"></i>
                    <i class="sr-star dwg-star"></i>
                    <i class="sr-star dwg-star"></i>
                    <i class="sr-star dwg-star"></i>
                    <i class="sr-star dwg-star"></i>
                    <?php endif; ?>
                    <?php if($count_rating == 2): ?>
                    <i class="sr-star dwg-star-filled active"></i>
                    <i class="sr-star dwg-star-filled active"></i>
                    <i class="sr-star dwg-star"></i>
                    <i class="sr-star dwg-star"></i>
                    <i class="sr-star dwg-star"></i>
                    <?php endif; ?>
                    <?php if($count_rating == 3): ?>
                    <i class="sr-star dwg-star-filled active"></i>
                    <i class="sr-star dwg-star-filled active"></i>
                    <i class="sr-star dwg-star-filled active"></i>
                    <i class="sr-star dwg-star"></i>
                    <i class="sr-star dwg-star"></i>
                    <?php endif; ?>
                    <?php if($count_rating == 4): ?>
                    <i class="sr-star dwg-star-filled active"></i>
                    <i class="sr-star dwg-star-filled active"></i>
                    <i class="sr-star dwg-star-filled active"></i>
                    <i class="sr-star dwg-star-filled active"></i>
                    <i class="sr-star dwg-star"></i>
                    <?php endif; ?>
                    <?php if($count_rating == 5): ?>
                    <i class="sr-star dwg-star-filled active"></i>
                    <i class="sr-star dwg-star-filled active"></i>
                    <i class="sr-star dwg-star-filled active"></i>
                    <i class="sr-star dwg-star-filled active"></i>
                    <i class="sr-star dwg-star-filled active"></i>
                    <?php endif; ?>
                </div>
               </div>
              <h3 class="product-title font-size-sm mb-2"><a href="<?php echo e(URL::to('/item')); ?>/<?php echo e($featured->product_slug); ?>"><?php echo e($featured->product_name); ?></a></h3>
              <div class="d-flex flex-wrap justify-content-between align-items-center">
                <div class="font-size-sm mr-2">
                <?php if($custom_settings->product_sale_count == 1): ?>
                <i class="dwg-download text-muted mr-1"></i><?php echo e($featured->product_sold); ?><span class="font-size-xs ml-1"><?php echo e(__('Sales')); ?></span>
                <?php endif; ?>
                </div>
                <div><?php if($featured->product_flash_sale == 1): ?><del class="price-old"><?php echo e($allsettings->site_currency_symbol); ?><?php echo e($featured->regular_price); ?></del><?php endif; ?> <span class="bg-faded-accent text-accent rounded-sm py-1 px-2"><?php echo e($allsettings->site_currency_symbol); ?><?php echo e($price); ?></span></div>
              </div>
            </div>
          </div>
        </div>
        <!-- Product-->
        <?php $no++; ?>
	    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
       </div>
    </section>
    <?php endif; ?>
    <?php if(count($popular_product) != 0): ?>
    <section <?php if($custom_settings->theme_layout == 'container'): ?> class="container-fluid mb-lg-1" <?php else: ?> class="container mb-lg-1" <?php endif; ?> data-aos="fade-up" data-aos-delay="200">
      <!-- Heading-->
      <div class="d-flex flex-wrap justify-content-between align-items-center pt-1 border-bottom pb-4 mb-4">
        <h2 class="h3 mb-0 pt-3 mr-2" data-aos="fade-down" data-aos-delay="100"><?php echo e(__('Popular Items')); ?></h2>
        <div class="pt-3" data-aos="fade-down" data-aos-delay="100">
          <a class="btn btn-outline-accent" href="<?php echo e(URL::to('/popular-items')); ?>"><?php echo e(__('Browse All Items')); ?><i class="dwg-arrow-right font-size-ms ml-1"></i></a>
        </div>
      </div>
      <!-- Grid-->
      <div class="row pt-2 mx-n2">
        <!-- Product-->
        <?php $no = 1; ?>
        <?php $__currentLoopData = $popular_product; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $featured): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php
        $price = Helper::price_info($featured->product_flash_sale,$featured->regular_price);
        $count_rating = Helper::count_rating($featured->ratings);
        ?>
        <div <?php if($custom_settings->theme_layout == 'container'): ?> class="col-6 col-xs-6 col-sm-6 col-md-4 col-lg-2 px-2 mb-grid-gutter" <?php else: ?> class="col-6 col-xs-6 col-sm-6 col-md-4 col-lg-3 px-2 mb-grid-gutter" <?php endif; ?>>
          <!-- Product-->
          <div class="card product-card-alt">
            <div class="product-thumb">
              <?php if(Auth::guest()): ?> 
              <a class="btn-wishlist btn-sm" href="<?php echo e(URL::to('/login')); ?>"><i class="dwg-heart"></i></a>
              <?php endif; ?>
              <?php if(Auth::check()): ?>
              <?php if($featured->user_id != Auth::user()->id): ?>
              <a class="btn-wishlist btn-sm" href="<?php echo e(url('/item')); ?>/<?php echo e(base64_encode($featured->product_id)); ?>/favorite/<?php echo e(base64_encode($featured->product_liked)); ?>"><i class="dwg-heart"></i></a>
              <?php endif; ?>
              <?php endif; ?>
              <div class="product-card-actions"><a class="btn btn-light btn-icon btn-shadow font-size-base mx-2" href="<?php echo e(URL::to('/item')); ?>/<?php echo e($featured->product_slug); ?>"><i class="dwg-eye"></i></a>
              <?php
              $checkif_purchased = Helper::if_purchased($featured->product_token);
              ?>
              <?php if($checkif_purchased == 0): ?>
              <?php if(Auth::check()): ?>
              <?php if(Auth::user()->id != 1): ?>
              <a class="btn btn-light btn-icon btn-shadow font-size-base mx-2" href="<?php echo e(URL::to('/add-to-cart')); ?>/<?php echo e($featured->product_slug); ?>"><i class="dwg-cart"></i></a>
              <?php endif; ?>
              <?php else: ?>
              <a class="btn btn-light btn-icon btn-shadow font-size-base mx-2" href="<?php echo e(URL::to('/add-to-cart')); ?>/<?php echo e($featured->product_slug); ?>"><i class="dwg-cart"></i></a>
              <?php endif; ?>
              <?php endif; ?>
              </div><a class="product-thumb-overlay" href="<?php echo e(URL::to('/item')); ?>/<?php echo e($featured->product_slug); ?>"></a>
              <?php if($featured->product_image!=''): ?>
              <img src="<?php echo e(url('/')); ?>/public/storage/product/<?php echo e($featured->product_image); ?>" alt="<?php echo e($featured->product_name); ?>">
              <?php else: ?>
              <img src="<?php echo e(url('/')); ?>/public/img/no-image.png" alt="<?php echo e($featured->product_name); ?>">
              <?php endif; ?>
            </div>
            <div class="card-body">
              <div class="d-flex flex-wrap justify-content-between align-items-start pb-2">
                <div class="text-muted font-size-xs mr-1"><a class="product-meta font-weight-medium" href="<?php echo e(URL::to('/shop')); ?>/category/<?php echo e($featured->category_slug); ?>"><?php echo e($featured->category_name); ?></a></div>
                <div class="star-rating">
                    <?php if($count_rating == 0): ?>
                    <i class="sr-star dwg-star"></i>
                    <i class="sr-star dwg-star"></i>
                    <i class="sr-star dwg-star"></i>
                    <i class="sr-star dwg-star"></i>
                    <i class="sr-star dwg-star"></i>
                    <?php endif; ?>
                    <?php if($count_rating == 1): ?>
                    <i class="sr-star dwg-star-filled active"></i>
                    <i class="sr-star dwg-star"></i>
                    <i class="sr-star dwg-star"></i>
                    <i class="sr-star dwg-star"></i>
                    <i class="sr-star dwg-star"></i>
                    <?php endif; ?>
                    <?php if($count_rating == 2): ?>
                    <i class="sr-star dwg-star-filled active"></i>
                    <i class="sr-star dwg-star-filled active"></i>
                    <i class="sr-star dwg-star"></i>
                    <i class="sr-star dwg-star"></i>
                    <i class="sr-star dwg-star"></i>
                    <?php endif; ?>
                    <?php if($count_rating == 3): ?>
                    <i class="sr-star dwg-star-filled active"></i>
                    <i class="sr-star dwg-star-filled active"></i>
                    <i class="sr-star dwg-star-filled active"></i>
                    <i class="sr-star dwg-star"></i>
                    <i class="sr-star dwg-star"></i>
                    <?php endif; ?>
                    <?php if($count_rating == 4): ?>
                    <i class="sr-star dwg-star-filled active"></i>
                    <i class="sr-star dwg-star-filled active"></i>
                    <i class="sr-star dwg-star-filled active"></i>
                    <i class="sr-star dwg-star-filled active"></i>
                    <i class="sr-star dwg-star"></i>
                    <?php endif; ?>
                    <?php if($count_rating == 5): ?>
                    <i class="sr-star dwg-star-filled active"></i>
                    <i class="sr-star dwg-star-filled active"></i>
                    <i class="sr-star dwg-star-filled active"></i>
                    <i class="sr-star dwg-star-filled active"></i>
                    <i class="sr-star dwg-star-filled active"></i>
                    <?php endif; ?>
                </div>
               </div>
              <h3 class="product-title font-size-sm mb-2"><a href="<?php echo e(URL::to('/item')); ?>/<?php echo e($featured->product_slug); ?>"><?php echo e($featured->product_name); ?></a></h3>
              <div class="d-flex flex-wrap justify-content-between align-items-center">
                <div class="font-size-sm mr-2">
                <?php if($custom_settings->product_sale_count == 1): ?>
                <i class="dwg-download text-muted mr-1"></i><?php echo e($featured->product_sold); ?><span class="font-size-xs ml-1"><?php echo e(__('Sales')); ?></span>
                <?php endif; ?>
                </div>
                <div><?php if($featured->product_flash_sale == 1): ?><del class="price-old"><?php echo e($allsettings->site_currency_symbol); ?><?php echo e($featured->regular_price); ?></del><?php endif; ?> <span class="bg-faded-accent text-accent rounded-sm py-1 px-2"><?php echo e($allsettings->site_currency_symbol); ?><?php echo e($price); ?></span></div>
              </div>
            </div>
          </div>
        </div>
        <!-- Product-->
        <?php $no++; ?>
	    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
       </div>
    </section>
    <?php endif; ?>
    <?php if($allsettings->subscription_mode == 1): ?>
    <?php if(count($subscribe_downloads) != 0): ?>
    <section <?php if($custom_settings->theme_layout == 'container'): ?> class="container-fluid mb-lg-1" <?php else: ?> class="container mb-lg-1" <?php endif; ?> data-aos="fade-up" data-aos-delay="200">
      <!-- Heading-->
      <div class="d-flex flex-wrap justify-content-between align-items-center pt-1 border-bottom pb-4 mb-4">
        <h2 class="h3 mb-0 pt-3 mr-2" data-aos="fade-down" data-aos-delay="100"><?php echo e(__('Subscriber Downloads')); ?></h2>
        <div class="pt-3" data-aos="fade-down" data-aos-delay="100">
          <a class="btn btn-outline-accent" href="<?php echo e(URL::to('/subscriber-downloads')); ?>"><?php echo e(__('Browse All Items')); ?><i class="dwg-arrow-right font-size-ms ml-1"></i></a>
        </div>
      </div>
      <!-- Grid-->
      <div class="row pt-2 mx-n2">
        <!-- Product-->
        <?php $no = 1; ?>
        <?php $__currentLoopData = $subscribe_downloads; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $featured): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php
        $price = Helper::price_info($featured->product_flash_sale,$featured->regular_price);
        $count_rating = Helper::count_rating($featured->ratings);
        ?>
        <div <?php if($custom_settings->theme_layout == 'container'): ?> class="col-6 col-xs-6 col-sm-6 col-md-4 col-lg-2 px-2 mb-grid-gutter" <?php else: ?> class="col-6 col-xs-6 col-sm-6 col-md-4 col-lg-3 px-2 mb-grid-gutter" <?php endif; ?>>
          <!-- Product-->
          <div class="card product-card-alt">
            <div class="product-thumb">
              <?php if(Auth::guest()): ?> 
              <a class="btn-wishlist btn-sm" href="<?php echo e(URL::to('/login')); ?>"><i class="dwg-heart"></i></a>
              <?php endif; ?>
              <?php if(Auth::check()): ?>
              <?php if($featured->user_id != Auth::user()->id): ?>
              <a class="btn-wishlist btn-sm" href="<?php echo e(url('/item')); ?>/<?php echo e(base64_encode($featured->product_id)); ?>/favorite/<?php echo e(base64_encode($featured->product_liked)); ?>"><i class="dwg-heart"></i></a>
              <?php endif; ?>
              <?php endif; ?>
              <div class="product-card-actions"><a class="btn btn-light btn-icon btn-shadow font-size-base mx-2" href="<?php echo e(URL::to('/item')); ?>/<?php echo e($featured->product_slug); ?>"><i class="dwg-eye"></i></a>
              <?php
              $checkif_purchased = Helper::if_purchased($featured->product_token);
              ?>
              <?php if($checkif_purchased == 0): ?>
              <?php if(Auth::check()): ?>
              <?php if(Auth::user()->id != 1): ?>
              <a class="btn btn-light btn-icon btn-shadow font-size-base mx-2" href="<?php echo e(URL::to('/add-to-cart')); ?>/<?php echo e($featured->product_slug); ?>"><i class="dwg-cart"></i></a>
              <?php endif; ?>
              <?php else: ?>
              <a class="btn btn-light btn-icon btn-shadow font-size-base mx-2" href="<?php echo e(URL::to('/add-to-cart')); ?>/<?php echo e($featured->product_slug); ?>"><i class="dwg-cart"></i></a>
              <?php endif; ?>
              <?php endif; ?>
              </div><a class="product-thumb-overlay" href="<?php echo e(URL::to('/item')); ?>/<?php echo e($featured->product_slug); ?>"></a>
              <?php if($featured->product_image!=''): ?>
              <img src="<?php echo e(url('/')); ?>/public/storage/product/<?php echo e($featured->product_image); ?>" alt="<?php echo e($featured->product_name); ?>">
              <?php else: ?>
              <img src="<?php echo e(url('/')); ?>/public/img/no-image.png" alt="<?php echo e($featured->product_name); ?>">
              <?php endif; ?>
            </div>
            <div class="card-body">
              <div class="d-flex flex-wrap justify-content-between align-items-start pb-2">
                <div class="text-muted font-size-xs mr-1"><a class="product-meta font-weight-medium" href="<?php echo e(URL::to('/shop')); ?>/category/<?php echo e($featured->category_slug); ?>"><?php echo e($featured->category_name); ?></a></div>
                <div class="star-rating">
                    <?php if($count_rating == 0): ?>
                    <i class="sr-star dwg-star"></i>
                    <i class="sr-star dwg-star"></i>
                    <i class="sr-star dwg-star"></i>
                    <i class="sr-star dwg-star"></i>
                    <i class="sr-star dwg-star"></i>
                    <?php endif; ?>
                    <?php if($count_rating == 1): ?>
                    <i class="sr-star dwg-star-filled active"></i>
                    <i class="sr-star dwg-star"></i>
                    <i class="sr-star dwg-star"></i>
                    <i class="sr-star dwg-star"></i>
                    <i class="sr-star dwg-star"></i>
                    <?php endif; ?>
                    <?php if($count_rating == 2): ?>
                    <i class="sr-star dwg-star-filled active"></i>
                    <i class="sr-star dwg-star-filled active"></i>
                    <i class="sr-star dwg-star"></i>
                    <i class="sr-star dwg-star"></i>
                    <i class="sr-star dwg-star"></i>
                    <?php endif; ?>
                    <?php if($count_rating == 3): ?>
                    <i class="sr-star dwg-star-filled active"></i>
                    <i class="sr-star dwg-star-filled active"></i>
                    <i class="sr-star dwg-star-filled active"></i>
                    <i class="sr-star dwg-star"></i>
                    <i class="sr-star dwg-star"></i>
                    <?php endif; ?>
                    <?php if($count_rating == 4): ?>
                    <i class="sr-star dwg-star-filled active"></i>
                    <i class="sr-star dwg-star-filled active"></i>
                    <i class="sr-star dwg-star-filled active"></i>
                    <i class="sr-star dwg-star-filled active"></i>
                    <i class="sr-star dwg-star"></i>
                    <?php endif; ?>
                    <?php if($count_rating == 5): ?>
                    <i class="sr-star dwg-star-filled active"></i>
                    <i class="sr-star dwg-star-filled active"></i>
                    <i class="sr-star dwg-star-filled active"></i>
                    <i class="sr-star dwg-star-filled active"></i>
                    <i class="sr-star dwg-star-filled active"></i>
                    <?php endif; ?>
                </div>
               </div>
              <h3 class="product-title font-size-sm mb-2"><a href="<?php echo e(URL::to('/item')); ?>/<?php echo e($featured->product_slug); ?>"><?php echo e($featured->product_name); ?></a></h3>
              <div class="d-flex flex-wrap justify-content-between align-items-center">
                <div class="font-size-sm mr-2">
                <?php if($custom_settings->product_sale_count == 1): ?>
                <i class="dwg-download text-muted mr-1"></i><?php echo e($featured->product_sold); ?><span class="font-size-xs ml-1"><?php echo e(__('Sales')); ?></span>
                <?php endif; ?>
                </div>
                <div><?php if($featured->product_flash_sale == 1): ?><del class="price-old"><?php echo e($allsettings->site_currency_symbol); ?><?php echo e($featured->regular_price); ?></del><?php endif; ?> <span class="bg-faded-accent text-accent rounded-sm py-1 px-2"><?php echo e($allsettings->site_currency_symbol); ?><?php echo e($price); ?></span></div>
              </div>
            </div>
          </div>
        </div>
        <!-- Product-->
        <?php $no++; ?>
	    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
       </div>
    </section>
    <?php endif; ?>
    <?php endif; ?>
    <?php if(count($flash_product) != 0): ?>
    <section <?php if($custom_settings->theme_layout == 'container'): ?> class="container-fluid mb-lg-1 flash-sale" <?php else: ?> class="container mb-lg-1 flash-sale" <?php endif; ?> data-aos="fade-up" data-aos-delay="200">
      <!-- Heading-->
      <div class="d-flex flex-wrap justify-content-between align-items-center pt-1 border-bottom pb-4 mb-4">
        <h2 class="h3 mb-0 pt-3 mr-2" data-aos="fade-down" data-aos-delay="100"><?php echo e(__('Flash Sale')); ?></h2>
        <div class="pt-3" data-aos="fade-down" data-aos-delay="100">
          <a class="btn btn-outline-accent" href="<?php echo e(URL::to('/sale')); ?>"><?php echo e(__('Browse All Items')); ?><i class="dwg-arrow-right font-size-ms ml-1"></i></a>
        </div>
      </div>
      <!-- Grid-->
      <div class="row pt-2 mx-n2">
        <!-- Product-->
        <?php $no = 1; ?>
        <?php $__currentLoopData = $flash_product; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $featured): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php
        $price = Helper::price_info($featured->product_flash_sale,$featured->regular_price);
        $count_rating = Helper::count_rating($featured->ratings);
        ?>
        <div <?php if($custom_settings->theme_layout == 'container'): ?> class="col-6 col-xs-6 col-sm-6 col-md-4 col-lg-2 px-2 mb-grid-gutter" <?php else: ?> class="col-6 col-xs-6 col-sm-6 col-md-4 col-lg-3 px-2 mb-grid-gutter" <?php endif; ?>>
          <!-- Product-->
          <div class="card product-card-alt">
            <div class="product-thumb">
              <?php if(Auth::guest()): ?> 
              <a class="btn-wishlist btn-sm" href="<?php echo e(URL::to('/login')); ?>"><i class="dwg-heart"></i></a>
              <?php endif; ?>
              <?php if(Auth::check()): ?>
              <?php if($featured->user_id != Auth::user()->id): ?>
              <a class="btn-wishlist btn-sm" href="<?php echo e(url('/item')); ?>/<?php echo e(base64_encode($featured->product_id)); ?>/favorite/<?php echo e(base64_encode($featured->product_liked)); ?>"><i class="dwg-heart"></i></a>
              <?php endif; ?>
              <?php endif; ?>
              <div class="product-card-actions"><a class="btn btn-light btn-icon btn-shadow font-size-base mx-2" href="<?php echo e(URL::to('/item')); ?>/<?php echo e($featured->product_slug); ?>"><i class="dwg-eye"></i></a>
              <?php
              $checkif_purchased = Helper::if_purchased($featured->product_token);
              ?>
              <?php if($checkif_purchased == 0): ?>
              <?php if(Auth::check()): ?>
              <?php if(Auth::user()->id != 1): ?>
              <a class="btn btn-light btn-icon btn-shadow font-size-base mx-2" href="<?php echo e(URL::to('/add-to-cart')); ?>/<?php echo e($featured->product_slug); ?>"><i class="dwg-cart"></i></a>
              <?php endif; ?>
              <?php else: ?>
              <a class="btn btn-light btn-icon btn-shadow font-size-base mx-2" href="<?php echo e(URL::to('/add-to-cart')); ?>/<?php echo e($featured->product_slug); ?>"><i class="dwg-cart"></i></a>
              <?php endif; ?>
              <?php endif; ?>
              </div><a class="product-thumb-overlay" href="<?php echo e(URL::to('/item')); ?>/<?php echo e($featured->product_slug); ?>"></a>
              <?php if($featured->product_image!=''): ?>
              <img src="<?php echo e(url('/')); ?>/public/storage/product/<?php echo e($featured->product_image); ?>" alt="<?php echo e($featured->product_name); ?>">
              <?php else: ?>
              <img src="<?php echo e(url('/')); ?>/public/img/no-image.png" alt="<?php echo e($featured->product_name); ?>">
              <?php endif; ?>
            </div>
            <div class="card-body">
              <div class="d-flex flex-wrap justify-content-between align-items-start pb-2">
                <div class="text-muted font-size-xs mr-1"><a class="product-meta font-weight-medium" href="<?php echo e(URL::to('/shop')); ?>/category/<?php echo e($featured->category_slug); ?>"><?php echo e($featured->category_name); ?></a></div>
                <div class="star-rating">
                    <?php if($count_rating == 0): ?>
                    <i class="sr-star dwg-star"></i>
                    <i class="sr-star dwg-star"></i>
                    <i class="sr-star dwg-star"></i>
                    <i class="sr-star dwg-star"></i>
                    <i class="sr-star dwg-star"></i>
                    <?php endif; ?>
                    <?php if($count_rating == 1): ?>
                    <i class="sr-star dwg-star-filled active"></i>
                    <i class="sr-star dwg-star"></i>
                    <i class="sr-star dwg-star"></i>
                    <i class="sr-star dwg-star"></i>
                    <i class="sr-star dwg-star"></i>
                    <?php endif; ?>
                    <?php if($count_rating == 2): ?>
                    <i class="sr-star dwg-star-filled active"></i>
                    <i class="sr-star dwg-star-filled active"></i>
                    <i class="sr-star dwg-star"></i>
                    <i class="sr-star dwg-star"></i>
                    <i class="sr-star dwg-star"></i>
                    <?php endif; ?>
                    <?php if($count_rating == 3): ?>
                    <i class="sr-star dwg-star-filled active"></i>
                    <i class="sr-star dwg-star-filled active"></i>
                    <i class="sr-star dwg-star-filled active"></i>
                    <i class="sr-star dwg-star"></i>
                    <i class="sr-star dwg-star"></i>
                    <?php endif; ?>
                    <?php if($count_rating == 4): ?>
                    <i class="sr-star dwg-star-filled active"></i>
                    <i class="sr-star dwg-star-filled active"></i>
                    <i class="sr-star dwg-star-filled active"></i>
                    <i class="sr-star dwg-star-filled active"></i>
                    <i class="sr-star dwg-star"></i>
                    <?php endif; ?>
                    <?php if($count_rating == 5): ?>
                    <i class="sr-star dwg-star-filled active"></i>
                    <i class="sr-star dwg-star-filled active"></i>
                    <i class="sr-star dwg-star-filled active"></i>
                    <i class="sr-star dwg-star-filled active"></i>
                    <i class="sr-star dwg-star-filled active"></i>
                    <?php endif; ?>
                </div>
               </div>
              <h3 class="product-title font-size-sm mb-2"><a href="<?php echo e(URL::to('/item')); ?>/<?php echo e($featured->product_slug); ?>"><?php echo e($featured->product_name); ?></a></h3>
              <div class="d-flex flex-wrap justify-content-between align-items-center">
                <div class="font-size-sm mr-2">
                <?php if($custom_settings->product_sale_count == 1): ?>
                <i class="dwg-download text-muted mr-1"></i><?php echo e($featured->product_sold); ?><span class="font-size-xs ml-1"><?php echo e(__('Sales')); ?></span>
                <?php endif; ?>
                </div>
                <div><?php if($featured->product_flash_sale == 1): ?><del class="price-old"><?php echo e($allsettings->site_currency_symbol); ?><?php echo e($featured->regular_price); ?></del><?php endif; ?> <span class="price-badge rounded-sm py-1 px-2"><?php echo e($allsettings->site_currency_symbol); ?><?php echo e($price); ?></span></div>
              </div>
            </div>
          </div>
        </div>
        <!-- Product-->
        <?php $no++; ?>
	    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
       </div>
    </section>
    <?php endif; ?>
    <?php if(count($free_product) != 0): ?>
    <section <?php if($custom_settings->theme_layout == 'container'): ?> class="container-fluid mb-lg-1 flash-sale" <?php else: ?> class="container mb-lg-1 flash-sale" <?php endif; ?> data-aos="fade-up" data-aos-delay="200">
      <!-- Heading-->
      <div class="d-flex flex-wrap justify-content-between align-items-center pt-1 border-bottom pb-4 mb-4">
        <h2 class="h3 mb-0 pt-3 mr-2" data-aos="fade-down" data-aos-delay="100"><?php echo e(__('Free Items')); ?></h2>
        <div class="pt-3" data-aos="fade-down" data-aos-delay="100">
          <a class="btn btn-outline-accent" href="<?php echo e(URL::to('/free-items')); ?>"><?php echo e(__('Browse All Items')); ?><i class="dwg-arrow-right font-size-ms ml-1"></i></a>
        </div>
      </div>
      <!-- Grid-->
      <div class="row pt-2 mx-n2">
        <!-- Product-->
        <?php $no = 1; ?>
        <?php $__currentLoopData = $free_product; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $featured): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php
        $price = Helper::price_info($featured->product_flash_sale,$featured->regular_price);
        $count_rating = Helper::count_rating($featured->ratings);
        ?>
        <div <?php if($custom_settings->theme_layout == 'container'): ?> class="col-6 col-xs-6 col-sm-6 col-md-4 col-lg-2 px-2 mb-grid-gutter" <?php else: ?> class="col-6 col-xs-6 col-sm-6 col-md-4 col-lg-3 px-2 mb-grid-gutter" <?php endif; ?>>
          <!-- Product-->
          <div class="card product-card-alt">
            <div class="product-thumb">
              <?php if(Auth::guest()): ?> 
              <a class="btn-wishlist btn-sm" href="<?php echo e(URL::to('/login')); ?>"><i class="dwg-heart"></i></a>
              <?php endif; ?>
              <?php if(Auth::check()): ?>
              <?php if($featured->user_id != Auth::user()->id): ?>
              <a class="btn-wishlist btn-sm" href="<?php echo e(url('/item')); ?>/<?php echo e(base64_encode($featured->product_id)); ?>/favorite/<?php echo e(base64_encode($featured->product_liked)); ?>"><i class="dwg-heart"></i></a>
              <?php endif; ?>
              <?php endif; ?>
              <div class="product-card-actions"><a class="btn btn-light btn-icon btn-shadow font-size-base mx-2" href="<?php echo e(URL::to('/item')); ?>/<?php echo e($featured->product_slug); ?>"><i class="dwg-eye"></i></a>
              <?php
              $checkif_purchased = Helper::if_purchased($featured->product_token);
              ?>
              <?php if($checkif_purchased == 0): ?>
              <?php if(Auth::check()): ?>
              <?php if(Auth::user()->id != 1): ?>
              <a class="btn btn-light btn-icon btn-shadow font-size-base mx-2" href="<?php echo e(URL::to('/add-to-cart')); ?>/<?php echo e($featured->product_slug); ?>"><i class="dwg-cart"></i></a>
              <?php endif; ?>
              <?php else: ?>
              <a class="btn btn-light btn-icon btn-shadow font-size-base mx-2" href="<?php echo e(URL::to('/add-to-cart')); ?>/<?php echo e($featured->product_slug); ?>"><i class="dwg-cart"></i></a>
              <?php endif; ?>
              <?php endif; ?>
              </div><a class="product-thumb-overlay" href="<?php echo e(URL::to('/item')); ?>/<?php echo e($featured->product_slug); ?>"></a>
              <?php if($featured->product_image!=''): ?>
              <img src="<?php echo e(url('/')); ?>/public/storage/product/<?php echo e($featured->product_image); ?>" alt="<?php echo e($featured->product_name); ?>">
              <?php else: ?>
              <img src="<?php echo e(url('/')); ?>/public/img/no-image.png" alt="<?php echo e($featured->product_name); ?>">
              <?php endif; ?>
            </div>
            <div class="card-body">
              <div class="d-flex flex-wrap justify-content-between align-items-start pb-2">
                <div class="text-muted font-size-xs mr-1"><a class="product-meta font-weight-medium" href="<?php echo e(URL::to('/shop')); ?>/category/<?php echo e($featured->category_slug); ?>"><?php echo e($featured->category_name); ?></a></div>
                <div class="star-rating">
                    <?php if($count_rating == 0): ?>
                    <i class="sr-star dwg-star"></i>
                    <i class="sr-star dwg-star"></i>
                    <i class="sr-star dwg-star"></i>
                    <i class="sr-star dwg-star"></i>
                    <i class="sr-star dwg-star"></i>
                    <?php endif; ?>
                    <?php if($count_rating == 1): ?>
                    <i class="sr-star dwg-star-filled active"></i>
                    <i class="sr-star dwg-star"></i>
                    <i class="sr-star dwg-star"></i>
                    <i class="sr-star dwg-star"></i>
                    <i class="sr-star dwg-star"></i>
                    <?php endif; ?>
                    <?php if($count_rating == 2): ?>
                    <i class="sr-star dwg-star-filled active"></i>
                    <i class="sr-star dwg-star-filled active"></i>
                    <i class="sr-star dwg-star"></i>
                    <i class="sr-star dwg-star"></i>
                    <i class="sr-star dwg-star"></i>
                    <?php endif; ?>
                    <?php if($count_rating == 3): ?>
                    <i class="sr-star dwg-star-filled active"></i>
                    <i class="sr-star dwg-star-filled active"></i>
                    <i class="sr-star dwg-star-filled active"></i>
                    <i class="sr-star dwg-star"></i>
                    <i class="sr-star dwg-star"></i>
                    <?php endif; ?>
                    <?php if($count_rating == 4): ?>
                    <i class="sr-star dwg-star-filled active"></i>
                    <i class="sr-star dwg-star-filled active"></i>
                    <i class="sr-star dwg-star-filled active"></i>
                    <i class="sr-star dwg-star-filled active"></i>
                    <i class="sr-star dwg-star"></i>
                    <?php endif; ?>
                    <?php if($count_rating == 5): ?>
                    <i class="sr-star dwg-star-filled active"></i>
                    <i class="sr-star dwg-star-filled active"></i>
                    <i class="sr-star dwg-star-filled active"></i>
                    <i class="sr-star dwg-star-filled active"></i>
                    <i class="sr-star dwg-star-filled active"></i>
                    <?php endif; ?>
                </div>
               </div>
              <h3 class="product-title font-size-sm mb-2"><a href="<?php echo e(URL::to('/item')); ?>/<?php echo e($featured->product_slug); ?>"><?php echo e($featured->product_name); ?></a></h3>
              <div class="d-flex flex-wrap justify-content-between align-items-center">
                <div class="font-size-sm mr-2">
                <?php if($custom_settings->product_sale_count == 1): ?>
                <i class="dwg-download text-muted mr-1"></i><?php echo e($featured->product_sold); ?><span class="font-size-xs ml-1"><?php echo e(__('Sales')); ?></span>
                <?php endif; ?>
                </div>
                <div><?php if($featured->product_flash_sale == 1): ?><del class="price-old"><?php echo e($allsettings->site_currency_symbol); ?><?php echo e($price); ?></del> <?php else: ?> <del class="price-old"><?php echo e($allsettings->site_currency_symbol); ?><?php echo e($featured->regular_price); ?></del> <?php endif; ?> <span class="price-badge rounded-sm py-1 px-2"><?php echo e(__('Free')); ?></span></div>
              </div>
            </div>
          </div>
        </div>
        <!-- Product-->
        <?php $no++; ?>
	    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
       </div>
    </section>
    <?php endif; ?>
    <?php if(count($newest_product) != 0): ?>
    <section <?php if($custom_settings->theme_layout == 'container'): ?> class="container-fluid pb-4 pb-md-5" <?php else: ?> class="container pb-4 pb-md-5" <?php endif; ?> data-aos="fade-up" data-aos-delay="200">
      <div class="d-flex flex-wrap justify-content-between align-items-center pt-1 border-bottom pb-4 mb-4">
        <h2 class="h3 mb-0 pt-3 mr-2" data-aos="fade-down" data-aos-delay="100"><?php echo e(__('New Releases')); ?></h2>
        <div class="pt-3" data-aos="fade-down" data-aos-delay="100">
          <a class="btn btn-outline-accent" href="<?php echo e(URL::to('/new-releases')); ?>"><?php echo e(__('Browse All Items')); ?><i class="dwg-arrow-right font-size-ms ml-1"></i></a>
        </div>
      </div>
      <div class="row">
        <!-- Bestsellers-->
            <?php $no = 1; ?>
            <?php $__currentLoopData = $newest_product; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $featured): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php
            $price = Helper::price_info($featured->product_flash_sale,$featured->regular_price);
            $count_rating = Helper::count_rating($featured->ratings);
            ?>
          <div <?php if($custom_settings->theme_layout == 'container'): ?> class="col-lg-3 col-md-6 mb-2 py-3" <?php else: ?> class="col-lg-4 col-md-6 mb-2 py-3" <?php endif; ?>>
           <div class="widget">    
            <div class="media align-items-center pb-2 border-bottom">
            <a class="d-block mr-2" href="<?php echo e(URL::to('/item')); ?>/<?php echo e($featured->product_slug); ?>">
            <?php if($featured->product_image!=''): ?>
            <img width="64" src="<?php echo e(url('/')); ?>/public/storage/product/<?php echo e($featured->product_image); ?>" alt="<?php echo e($featured->product_name); ?>">
            <?php else: ?>
            <img width="64" src="<?php echo e(url('/')); ?>/public/img/no-image.png" alt="<?php echo e($featured->product_name); ?>">
            <?php endif; ?>
            </a>
              <div class="media-body">
                <h6 class="widget-product-title"><a href="<?php echo e(URL::to('/item')); ?>/<?php echo e($featured->product_slug); ?>"><?php echo e($featured->product_name); ?></a></h6>
                <div class="widget-product-meta"><span class="text-accent"><?php echo e($allsettings->site_currency_symbol); ?><?php echo e($price); ?></span> <?php if($featured->product_flash_sale == 1): ?><del class="price-old"><?php echo e($allsettings->site_currency_symbol); ?><?php echo e($featured->regular_price); ?></del><?php endif; ?></div>
              </div>
            </div>
           </div>
        </div>
            <?php $no++; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
       </div>
    </section>
    <?php endif; ?>
    <?php if($allsettings->site_blog_display == 1): ?>
    <?php if(count($latestpost['view']) != 0): ?>
    <section <?php if($custom_settings->theme_layout == 'container'): ?> class="container-fluid pb-2 pb-md-5 homeblog" <?php else: ?> class="container pb-2 pb-md-5 homeblog" <?php endif; ?> data-aos="fade-up" data-aos-delay="200">
      <div class="d-flex flex-wrap justify-content-between align-items-center pt-1 border-bottom pb-4 mb-4">
        <h2 class="h3 mb-0 pt-3 mr-2" data-aos="fade-down" data-aos-delay="100"><?php echo e(__('Our Blog')); ?></h2>
        <div class="pt-3" data-aos="fade-down" data-aos-delay="100">
          <a class="btn btn-outline-accent" href="<?php echo e(URL::to('/blog')); ?>"><?php echo e(__('Read more posts')); ?><i class="dwg-arrow-right font-size-ms ml-1"></i></a>
        </div>
      </div>
        <div class="row">
          <?php $no = 1; ?>
          <?php $__currentLoopData = $latestpost['view']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div <?php if($custom_settings->theme_layout == 'container'): ?> class="col-12 col-xs-12 col-sm-12 col-md-4 col-lg-3 mb-1 py-3" <?php else: ?> class="col-12 col-xs-12 col-sm-12 col-md-4 col-lg-4 mb-1 py-3" <?php endif; ?>>
              <div class="card">
              <a class="blog-entry-thumb" href="<?php echo e(URL::to('/single')); ?>/<?php echo e($post->post_slug); ?>" title="<?php echo e($post->post_title); ?>">
              <?php if($post->post_image!=''): ?>
              <img class="card-img-top" src="<?php echo e(url('/')); ?>/public/storage/post/<?php echo e($post->post_image); ?>" alt="<?php echo e($post->post_title); ?>">
              <?php else: ?>
              <img class="card-img-top" src="<?php echo e(url('/')); ?>/public/img/no-image.png" alt="<?php echo e($post->post_title); ?>">
              <?php endif; ?>
              </a>
                <div class="card-body">
                  <h2 class="h6 blog-entry-title"><a href="<?php echo e(URL::to('/single')); ?>/<?php echo e($post->post_slug); ?>"><?php echo e($post->post_title); ?></a></h2>
                  <p class="font-size-sm"><?php echo e(mb_substr($post->post_short_desc, 0, 80, 'UTF-8')); ?></p>
                  <div class="font-size-xs text-nowrap"><span class="blog-entry-meta-link text-nowrap"><?php echo e(date('d M Y', strtotime($post->post_date))); ?></span><span class="blog-entry-meta-divider mx-2"></span><span class="blog-entry-meta-link text-nowrap"><i class="dwg-message"></i><?php echo e($comments->has($post->post_id) ? count($comments[$post->post_id]) : 0); ?></span></div>
                </div>
              </div>
            </div>
            <?php $no++; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
         </div>
        <!-- More button-->
     </section>
     <?php endif; ?>
     <?php endif; ?>   
     <?php if(in_array('home',$bottom_ads)): ?>
    <section <?php if($custom_settings->theme_layout == 'container'): ?> class="container-fluid pt-2" <?php else: ?> class="container pt-2" <?php endif; ?> data-aos="fade-up" data-aos-delay="200">
      <div class="row">
          <div class="col-lg-12 mb-3" align="center">
             <?php echo html_entity_decode($allsettings->bottom_ads); ?>
          </div>
       </div>   
    </section>   
    <?php endif; ?> 
<?php echo $__env->make('footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php echo $__env->make('script', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<script type="text/javascript">

</script>
</body>
</html><?php /**PATH /home/arixmyii/bittoz.shop/public_html/resources/views/pages/index.blade.php ENDPATH**/ ?>