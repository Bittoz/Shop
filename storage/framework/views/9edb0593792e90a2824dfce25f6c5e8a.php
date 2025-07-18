<!DOCTYPE HTML>
<html lang="en">
<head>
<title><?php echo e(__('Shop')); ?> - <?php echo e($allsettings->site_title); ?></title>
<?php if($meta_allow == 1): ?>
<meta name="keywords" content="<?php echo e($meta_keyword); ?>">
<meta name="description" content="<?php echo e($meta_desc); ?>">
<?php else: ?>
<?php echo $__env->make('meta', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php endif; ?>
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
              <li class="breadcrumb-item text-nowrap active" aria-current="page"><?php echo e(__('Shop')); ?></li>
            </ol>
          </nav>
        </div>
        <div class="order-lg-1 pr-lg-4 text-center text-lg-left">
          <h1 class="h3 mb-0 text-white"><?php echo e(__('Shop')); ?></h1>
        </div>
      </div>
      </div>
    </section>
<div <?php if($custom_settings->theme_layout == 'container'): ?> class="container-fluid py-5 mt-md-2 mb-2" <?php else: ?> class="container py-5 mt-md-2 mb-2" <?php endif; ?>>
      <div id="demo">
      <div class="row pt-3 mx-n2">
         <div class="col-12 col-xs-6 col-sm-12 col-md-4 col-lg-3 jplist-panel">
          <!-- Sidebar-->
          <div class="cz-sidebar rounded-lg box-shadow-lg" id="shop-sidebar">
            <div class="cz-sidebar-header box-shadow-sm">
              <button class="close ml-auto" type="button" data-dismiss="sidebar" aria-label="Close"><span class="d-inline-block font-size-xs font-weight-normal align-middle"><?php echo e(__('Close sidebar')); ?></span><span class="d-inline-block align-middle ml-2" aria-hidden="true">&times;</span></button>
            </div>
            <div class="cz-sidebar-body" data-simplebar data-simplebar-auto-hide="true">
              
              <!-- Filter by Brand-->
              
			  <!-- Categories-->
              <div class="widget cz-filter mb-4 pb-4 border-bottom">
                <h3 class="widget-title"><?php echo e(__('Categories')); ?></h3>
                <div class="input-group-overlay input-group-sm mb-2">
                  <input class="cz-filter-search form-control form-control-sm appended-form-control" type="text" placeholder="<?php echo e(__('Search')); ?>">
                  <div class="input-group-append-overlay"><span class="input-group-text"><i class="dwg-search"></i></span></div>
                </div>
                <?php if(count($category['view']) != 0): ?>
                <div 
                    class="jplist-group"
                    data-control-type="checkbox-group-filter"
						   data-control-action="filter"
						   data-control-name="categorysearch">
                <ul class="widget-list cz-filter-list list-unstyled pt-1" style="max-height: 12rem;" data-simplebar data-simplebar-auto-hide="false">
                  <?php $__currentLoopData = $category['view']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <li class="cz-filter-item d-flex justify-content-between align-items-center">
                      <div class="custom-control custom-checkbox">
                      <input id="<?php echo e('category_'.$cat->cat_id); ?>" data-path=".<?php echo e('category_'.$cat->cat_id); ?>" type="checkbox" class="custom-control-input" >
                      <label class="custom-control-label cz-filter-item-text" for="<?php echo e('category_'.$cat->cat_id); ?>"><?php echo e($cat->category_name); ?></label>
                      <?php $__currentLoopData = $cat->subcategory; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sub_category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                      <br/>
                      <span class="ml-2"><input id="<?php echo e('subcategory_'.$sub_category->subcat_id); ?>" data-path=".<?php echo e('subcategory_'.$sub_category->subcat_id); ?>" type="checkbox" class="custom-control-input" >
                      <label class="custom-control-label cz-filter-item-text" for="<?php echo e('subcategory_'.$sub_category->subcat_id); ?>"><?php echo e($sub_category->subcategory_name); ?></label>
                      </span>
                      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                  </li>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
                </ul>
                </div>
                <?php endif; ?>
              </div>
              <div class="widget cz-filter mb-4 pb-4 border-bottom">
                <h3 class="widget-title"><?php echo e(__('Sort By')); ?></h3>
                    <div 
                      data-control-type="sort-buttons-group"
                      data-control-name="sort-buttons-group-1"
                      data-control-action="sort"
                      data-mode="single">
                         <div class="custom-control custom-radio">
                         <input type="radio"
                            data-path=".popular-items"
                            data-type="number"
                            data-order="asc"
                            data-selected="true" name="jplist" id="popular-items" class="custom-control-input swroll" checked>
                            <label class="custom-control-label" for="popular-items"><?php echo e(__('Popular Items')); ?></label>
                        </div>
                        <div class="custom-control custom-radio">
                         <input type="radio"
                            data-path=".new-items"
                            data-type="number"
                            data-order="desc"  name="jplist" id="new-items" class="custom-control-input swroll">
                                <label class="custom-control-label" for="new-items"><?php echo e(__('New Items')); ?></label>
                       
                           </div>
                         <div class="custom-control custom-radio">
                      <input data-control-type="radio-buttons-filters" data-control-action="filter" data-control-name="free-items" data-path=".free-items" id="free-items" type="radio" name="jplist" class="custom-control-input swroll"/>
                      <label class="custom-control-label" for="free-items"><?php echo e(__('Free Items')); ?></label>
                    </div>
                  </div>
               </div>
               <div class="widget cz-filter mb-4 pb-4 border-bottom">
                <h3 class="widget-title"><?php echo e(__('Order By')); ?></h3>
                    <div 
                      data-control-type="sort-buttons-group"
                      data-control-name="sort-buttons-group-1"
                      data-control-action="sort"
                      data-mode="single">
                         <div class="custom-control custom-radio">
                         <input type="radio"
                            data-path=".like"
                            data-type="number"
                            data-order="asc"
                            data-selected="true" name="jplist1" id="orderbyasc" class="custom-control-input swroll">
                            <label class="custom-control-label" for="orderbyasc"><?php echo e(__('Price : Low to High')); ?></label>
                        </div>
                        <div class="custom-control custom-radio">
                         <input type="radio"
                            data-path=".like"
                            data-type="number"
                            data-order="desc"  name="jplist1" id="orderbydesc" class="custom-control-input swroll">
                                <label class="custom-control-label" for="orderbydesc"><?php echo e(__('Price : High to low')); ?></label>
                       
                           </div>
                         
                  </div>
               </div>
              <!-- Price range-->
              <?php if(count($itemData['item']) != 0): ?>
              <div class="widget mb-4 pb-4 border-bottom">
                <h3 class="widget-title"><?php echo e(__('Price')); ?></h3>
                <?php /*?><div class="cz-range-slider" data-start-min="{{ $minprice['price']->regular_price }}" data-start-max="{{ $maxprice['price']->extended_price }}" data-min="{{ $allsettings->site_range_min_price }}" data-max="{{ $allsettings->site_range_max_price }}" data-step="1"><?php */?>
                <div data-start-min="<?php echo e($minprice['price']->regular_price); ?>" data-start-max="<?php echo e($maxprice['price']->extended_price); ?>" data-min="<?php echo e($allsettings->site_range_min_price); ?>" data-max="<?php echo e($allsettings->site_range_max_price); ?>" data-step="1">
                  <div class="demo">
                      <input type="text" id="amount" class="range-price" />
                       <div id="slider-range"></div>
                        </div>
                  <div id="slider-range-min"></div>
                 </div>
              </div>
              <?php endif; ?>
             <?php if(in_array('shop',$sidebar_ads)): ?>
           <div class="mt-4" align="center">
           <?php echo html_entity_decode($allsettings->sidebar_ads); ?>
           </div>
           <?php endif; ?>
              <!-- Filter by Brand-->
           </div>
          </div>
        </div>
        <div class="col-12 col-xs-6 col-sm-12 col-md-8 col-lg-9">
          <div class="row pt-2 mx-n2 flash-sale list items box">
         <?php if(in_array('shop',$top_ads)): ?>
          <div class="mt-2 mb-2" align="center">
             <?php echo html_entity_decode($allsettings->top_ads); ?>
          </div>
          <?php endif; ?>
        <!-- Product-->
        <?php if(count($itemData['item']) != 0): ?>
        <?php $no = 1; ?>
        <?php $__currentLoopData = $itemData['item']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $featured): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php
        $price = Helper::price_info($featured->product_flash_sale,$featured->regular_price);
        $count_rating = Helper::count_rating($featured->ratings);
        ?>
        <div <?php if($custom_settings->theme_layout == 'container'): ?> class="col-6 col-xs-6 col-sm-6 col-md-4 col-lg-3 px-2 mb-3 list-item box" <?php else: ?> class="col-6 col-xs-6 col-sm-6 col-md-4 col-lg-4 px-2 mb-3 list-item box" <?php endif; ?> data-price="<?php echo e($price); ?>">
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
              <span class="<?php echo e($featured->product_type_cat_id); ?>" style="display:none;"><?php echo e($featured->product_type_cat_id); ?></span>
              <span class="popular-items" style="display:none;"><?php echo e($featured->product_liked); ?></span>
              <span class="new-items" style="display:none;"><?php echo e($featured->product_id); ?></span>
              <?php if($featured->product_free == 1): ?>
              <span class="free-items" style="display:none;"><?php echo e($featured->product_free); ?></span>
              <?php endif; ?>
              <span class="like" style="display:none;"><?php echo e($price); ?></span>
              <div class="text-muted font-size-xs mr-1"><a class="product-meta font-weight-medium" href="<?php echo e(URL::to('/shop')); ?>/category/<?php echo e(Helper::id_toget_category($featured->product_category_parent,'category_slug')); ?>"><?php echo e(Helper::id_toget_category($featured->product_category_parent,'category_name')); ?></a></div>
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
              <h3 class="product-title font-size-sm mb-2 title"><a href="<?php echo e(URL::to('/item')); ?>/<?php echo e($featured->product_slug); ?>"><?php echo e($featured->product_name); ?></a></h3>
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
       <div class="row">
                <div class="col-md-12" align="right">
                <div class="jplist-panel box panel-top">						
							
						<div 
						   class="jplist-label customlable" 
						   data-type="Page {current} of {pages}" 
						   data-control-type="pagination-info" 
						   data-control-name="paging" 
						   data-control-action="paging">
						</div>	

						<div 
						   class="jplist-pagination" 
						   data-control-type="pagination" 
						   data-control-name="paging" 
						   data-control-action="paging"
						   data-items-per-page="<?php echo e($allsettings->product_per_page); ?>">
						</div>			
						
					</div>
                    <!--<div class="pagination-area">
                           <div class="turn-page" id="pager"></div>
                        </div>-->
                </div>
            </div>
       <?php /*?><div class="text-right">
            <div class="turn-page" id="itempager"></div>
       </div><?php */?>
       <?php if(in_array('shop',$bottom_ads)): ?>
       <div class="mt-3 mb-4 pb-4" align="center">
         <?php echo html_entity_decode($allsettings->bottom_ads); ?>
       </div>
       <?php endif; ?>
       <?php else: ?>
       <div><?php echo e(__('No product found')); ?></div>
       <?php endif; ?>
       </div>
        </div>
      </div>
      </div>  
    </div>
<?php echo $__env->make('footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php echo $__env->make('script', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
</body>
</html><?php /**PATH /home/arixmyii/bittoz.shop/public_html/resources/views/pages/shop-ajax.blade.php ENDPATH**/ ?>