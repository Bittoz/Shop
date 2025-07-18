<!DOCTYPE HTML>
<html lang="en">
<head>
<title><?php echo e($item['view']->product_name); ?> - <?php echo e($allsettings->site_title); ?></title>
<?php if($slug != ''): ?>
<?php if($item['view']->product_allow_seo == 1): ?>
<meta name="keywords" content="<?php echo e($item['view']->product_seo_keyword); ?>">
<meta name="description" content="<?php echo e($item['view']->product_seo_desc); ?>">
<?php else: ?>
<?php echo $__env->make('meta', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php endif; ?>
<?php else: ?>
<?php echo $__env->make('meta', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php endif; ?>
<?php echo $__env->make('style', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
</head>
<body>
<?php echo $__env->make('header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<div class="page-title-overlap pt-4" style="background-image: url('<?php echo e(url('/')); ?>/public/storage/settings/<?php echo e($allsettings->site_other_banner); ?>');">
      <div class="container d-lg-flex justify-content-between py-2 py-lg-3">
        <div class="order-lg-2 mb-3 mb-lg-0 pt-lg-2">
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb flex-lg-nowrap justify-content-center justify-content-lg-star">
              <li class="breadcrumb-item"><a class="text-nowrap" href="<?php echo e(URL::to('/')); ?>"><i class="dwg-home"></i><?php echo e(__('Home')); ?></a></li>
              <li class="breadcrumb-item text-nowrap active" aria-current="page"><?php echo e($item['view']->product_name); ?></li>
             </ol>
          </nav>
        </div>
        <div class="order-lg-1 pr-lg-4 text-center text-lg-left">
          <h1 class="h3 mb-0 text-white"><?php echo e($item['view']->product_name); ?></h1>
          <?php if($item['view']->product_short_desc != ""): ?>
          <p class="product_short_desc"><?php echo e($item['view']->product_short_desc); ?></p>
          <?php endif; ?>
        </div>
      </div>
    </div>
<section class="container mb-3 pb-3">
      <div class="bg-light box-shadow-lg rounded-lg overflow-hidden">
        <div class="row">
          <!-- Content-->
          <section class="col-lg-8 pt-2 pt-lg-4 pb-4 mb-lg-3">
            <div class="pt-2 px-4 pr-lg-0 pl-xl-5">
              <?php if(in_array('item-details',$top_ads)): ?>
          	  <div class="mt-2 mb-4" align="center">
              <?php echo html_entity_decode($allsettings->top_ads); ?>
          	  </div>
         	  <?php endif; ?>
              <!-- Product gallery-->
              <div class="cz-gallery">
              <?php if($item['view']->product_preview!=''): ?>
              <a class="gallery-item rounded-lg mb-grid-gutter" href="<?php echo e(url('/')); ?>/public/storage/product/<?php echo e($item['view']->product_preview); ?>" data-sub-html="<?php echo e($item['view']->product_name); ?>"><img src="<?php echo e(url('/')); ?>/public/storage/product/<?php echo e($item['view']->product_preview); ?>" alt="<?php echo e($item['view']->product_name); ?>"/><span class="gallery-item-caption"><?php echo e($item['view']->product_name); ?></span></a>
              <?php else: ?>
               <img src="<?php echo e(url('/')); ?>/public/img/no-image.png" alt="<?php echo e($item['view']->product_name); ?>" class="card-img-top featured-img">
                <?php endif; ?>
                <?php if($getcount != 0): ?>
                <div class="row">
                  <?php $__currentLoopData = $getall['image']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <div class="col-sm-2"><a class="gallery-item rounded-lg mb-grid-gutter" href="<?php echo e(url('/')); ?>/public/storage/product/<?php echo e($image->product_gallery_image); ?>" data-sub-html="<?php echo e($item['view']->product_name); ?>"><img src="<?php echo e(url('/')); ?>/public/storage/product/<?php echo e($image->product_gallery_image); ?>" alt="<?php echo e($image->product_gallery_image); ?>"/><span class="gallery-item-caption"><?php echo e($item['view']->product_name); ?></span></a></div>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
                </div>
                <?php endif; ?>
              </div>
              <!-- Wishlist + Sharing-->
              <div class="d-flex flex-wrap justify-content-between align-items-center border-top pt-3">
                <div class="py-2 mr-2">
                  <?php if($item['view']->product_demo_url != ''): ?>
                  <?php
                  if($custom_settings->demo_url_preview == 0) { $demo_url = $item['view']->product_demo_url; } else { $demo_url = url('/preview').'/'.$item['view']->product_slug; }
                  ?> 
                  <a class="btn btn-outline-accent btn-sm" href="<?php echo e($demo_url); ?>" target="_blank"><i class="dwg-eye font-size-sm mr-2"></i><?php echo e(__('Live Preview')); ?></a>
                  <?php endif; ?>
                  <?php if($item['view']->product_video_url != ''): ?> 
                  <a class="btn btn-outline-accent btn-sm popupvideo" href="<?php echo e($item['view']->product_video_url); ?>"><i class="dwg-video font-size-lg mr-2"></i><?php echo e(__('Video')); ?></a>
                  <?php endif; ?>
                  <?php if(Auth::guest()): ?>
                  <a class="btn btn-outline-accent btn-sm" href="<?php echo e(URL::to('/login')); ?>"><i class="dwg-heart font-size-lg mr-2"></i><?php echo e(__('Add to Favorites')); ?></a>
                  <?php endif; ?>
                  <?php if(Auth::check()): ?>
                  <?php if($item['view']->user_id != Auth::user()->id): ?>
                  <a class="btn btn-outline-accent btn-sm" href="<?php echo e(url('/item')); ?>/<?php echo e(base64_encode($item['view']->product_id)); ?>/favorite/<?php echo e(base64_encode($item['view']->product_liked)); ?>"><i class="dwg-heart font-size-lg mr-2"></i><?php echo e(__('Add to Favorites')); ?></a>
                  <?php endif; ?>
                  <?php endif; ?>
                  </div>
                <div class="py-2"><i class="dwg-share-alt font-size-lg align-middle text-muted mr-2"></i>
                <a class="social-btn sb-outline sb-facebook sb-sm ml-2 share-button" data-share-url="<?php echo e(URL::to('/item')); ?>/<?php echo e($item['view']->product_slug); ?>" data-share-network="facebook" data-share-text="<?php echo e($item['view']->product_short_desc); ?>" data-share-title="<?php echo e($item['view']->product_name); ?>" data-share-via="<?php echo e($allsettings->site_title); ?>" data-share-tags="" data-share-media="<?php echo e(url('/')); ?>/public/storage/product/<?php echo e($item['view']->product_preview); ?>" href="javascript:void(0)"><i class="dwg-facebook"></i></a>
                <a class="social-btn sb-outline sb-twitter sb-sm ml-2 share-button" data-share-url="<?php echo e(URL::to('/item')); ?>/<?php echo e($item['view']->product_slug); ?>" data-share-network="twitter" data-share-text="<?php echo e($item['view']->product_short_desc); ?>" data-share-title="<?php echo e($item['view']->product_name); ?>" data-share-via="<?php echo e($allsettings->site_title); ?>" data-share-tags="" data-share-media="<?php echo e(url('/')); ?>/public/storage/product/<?php echo e($item['view']->product_preview); ?>" href="javascript:void(0)"><i class="dwg-twitter"></i></a>
                <a class="social-btn sb-outline sb-pinterest sb-sm ml-2 share-button" data-share-url="<?php echo e(URL::to('/item')); ?>/<?php echo e($item['view']->product_slug); ?>" data-share-network="pinterest" data-share-text="<?php echo e($item['view']->product_short_desc); ?>" data-share-title="<?php echo e($item['view']->product_name); ?>" data-share-via="<?php echo e($allsettings->site_title); ?>" data-share-tags="" data-share-media="<?php echo e(url('/')); ?>/public/storage/product/<?php echo e($item['view']->product_preview); ?>" href="javascript:void(0)"><i class="dwg-pinterest"></i></a>
                <?php /*?><a class="social-btn sb-outline sb-linkedin sb-sm ml-2 share-button" data-share-url="{{ URL::to('/item') }}/{{ $item['view']->product_slug }}" data-share-network="linkedin" data-share-text="{{ $item['view']->product_short_desc }}" data-share-title="{{ $item['view']->product_name }}" data-share-via="{{ $allsettings->site_title }}" data-share-tags="" data-share-media="{{ url('/') }}/public/storage/product/{{ $item['view']->product_preview }}" href="javascript:void(0)"><i class="dwg-linkedin"></i></a><?php */?>
                 <a class="social-btn sb-outline sb-linkedin sb-sm ml-2 share-button" href="javascript:void(0)"  onClick="return popupwindow('https://api.whatsapp.com/send?text=<?php echo e(URL::to('/item')); ?>/<?php echo e($item['view']->product_slug); ?>','xtf','500','400');"><i class="fa fa-whatsapp"></i></a>
                </div>
                <div class="py-2">
                <?php /*?><i class="dwg-edit font-size-lg text-muted"></i> <a href="javascript:void(0);" data-toggle="modal" data-target="#form">Report this item</a><?php */?>
                <i class="dwg-edit font-size-lg text-muted"></i> <a href="<?php echo e($allsettings->product_reporting_url); ?>" target="_blank"><?php echo e(__('Report this item')); ?></a>
                </div>
 
 <div class="modal fade" id="form" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header border-bottom-0">
        <h5 class="modal-title" id="exampleModalLabel"><?php echo e(__('Report this item')); ?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="<?php echo e(route('report')); ?>" class="support_form media-body needs-validation" id="issue_form" method="post" enctype="multipart/form-data">
       <?php echo e(csrf_field()); ?>

        <div class="modal-body">
          <?php if(Auth::guest()): ?>
          <div class="form-group">
            <label for="email1"><?php echo e(__('Full Name')); ?> <span class="text-danger">*</span></label>
            <input type="text" class="form-control" name="report_fullname" data-bvalidator="required">
            
          </div>
          <div class="form-group">
            <label for="email1"><?php echo e(__('Email')); ?> <span class="text-danger">*</span></label>
            <input type="email" class="form-control" name="report_email" data-bvalidator="required">
          </div>
          <?php else: ?>
          <input type="hidden" name="report_fullname" value="<?php echo e(Auth::user()->name); ?>">
          <input type="hidden" name="report_email" value="<?php echo e(Auth::user()->email); ?>">
          <?php endif; ?>
          <div class="form-group">
            <label for="password1"><?php echo e(__('Issue Type')); ?> <span class="text-danger">*</span></label>
            <select class="form-control" name="report_issue_type" data-bvalidator="required">
            <option value="Copyright Issue"><?php echo e(__('Copyright Issue')); ?></option>
            <option value="Payment Issue"><?php echo e(__('Payment Issue')); ?></option>
            <option value="Item or File Problem"><?php echo e(__('Item or File Problem')); ?></option>
            <option value="General Issue"><?php echo e(__('General Issue')); ?></option>
            <option value="Suggestion"><?php echo e(__('Suggestion')); ?></option>
            </select>
          </div>
          <div class="form-group">
            <label for="email1"><?php echo e(__('Subject')); ?> <span class="text-danger">*</span></label>
            <input type="text" class="form-control" name="report_subject" data-bvalidator="required">
            
          </div>
          <div class="form-group">
            <label for="email1"><?php echo e(__('Message')); ?> <span class="text-danger">*</span></label>
            <textarea class="form-control" name="report_message" rows="3" data-bvalidator="required"></textarea>
            
          </div>
        </div>
        <input type="hidden" name="report_product_token" value="<?php echo e($item['view']->product_token); ?>">
        <div class="modal-footer border-top-0 d-flex justify-content-center">
          <button type="submit" class="btn btn-success"><?php echo e(__('Submit')); ?></button>
        </div>
      </form>
    </div>
  </div>
</div>
              </div>
            <div class="mt-4 mb-4 mb-lg-5">
      <!-- Nav tabs-->
      <ul class="nav nav-tabs" role="tablist">
        <li class="nav-item"><a class="nav-link p-4 active" href="#details" data-toggle="tab" role="tab"><?php echo e(__('Item Details')); ?></a></li>
        <li class="nav-item"><a class="nav-link p-4" href="#comments" data-toggle="tab" role="tab"><?php echo e(__('Comments')); ?></a></li>
        <li class="nav-item"><a class="nav-link p-4" href="#reviews" data-toggle="tab" role="tab"><?php echo e(__('Reviews')); ?></a></li>
        <li class="nav-item"><a class="nav-link p-4" href="#suppport" data-toggle="tab" role="tab"><?php echo e(__('Support')); ?></a></li>
      </ul>
      <div class="tab-content pt-2">
        <div class="tab-pane fade" id="suppport" role="tabpanel">
           <div class="row">
            <div class="col-lg-12">
               <h4><?php echo e(__('Contact the Author')); ?></h4>
               <?php if(Auth::guest()): ?>
                    <p><?php echo e(__('Please')); ?> <a href="<?php echo e(URL::to('/login')); ?>" class="link-color"><?php echo e(__('Sign In')); ?></a> <?php echo e(__('To Contact This Author')); ?></p>
                    <?php endif; ?>
                    <?php if(Auth::check()): ?>
                    <form action="<?php echo e(route('support')); ?>" class="support_form media-body needs-validation" id="support_form" method="post" enctype="multipart/form-data">
                                            <?php echo e(csrf_field()); ?>

                                            <div class="form-group">
                                                    <label for="subj"><?php echo e(__('Subject')); ?></label>
                                                    <input type="text" id="support_subject" name="support_subject" class="form-control" placeholder="<?php echo e(__('Enter your subject')); ?>" data-bvalidator="required"></div>
                                                <div class="form-group">
                                                    <label for="supmsg"><?php echo e(__('Message')); ?> </label>
                                                    <textarea class="form-control" id="support_msg" name="support_msg" rows="5" placeholder="<?php echo e(__('Enter your message')); ?>" data-bvalidator="required"></textarea></div>
                                                <input type="hidden" name="to_address" value="<?php echo e($item['view']->email); ?>">
                                                <input type="hidden" name="to_name" value="<?php echo e($item['view']->username); ?>">
                                                <input type="hidden" name="from_address" value="<?php echo e(Auth::user()->email); ?>">
                                                <input type="hidden" name="from_name" value="<?php echo e(Auth::user()->username); ?>">
                                                <input type="hidden" name="product_url" value="<?php echo e(URL::to('/item')); ?>/<?php echo e($item['view']->product_slug); ?>">
                              <button type="submit" class="btn btn-primary btn-sm"><?php echo e(__('Submit Now')); ?></button>
                      </form>
                <?php endif; ?>
            </div>
           </div> 
        </div>
        <!-- Product details tab-->
        <div class="tab-pane fade show active" id="details" role="tabpanel">
          <div class="row">
            <div class="col-lg-12">
              <p class="font-size-md mb-1"><?php echo html_entity_decode($item['view']->product_desc); ?></p>
            </div>
          </div>
        </div>
        <!-- Reviews tab-->
        <div class="tab-pane fade" id="reviews" role="tabpanel">
         <?php if($review_count != 0): ?>
         <div class="row pb-4">
            <!-- Reviews list-->
            <div class="col-md-12">
              <!-- Review-->
              <?php $__currentLoopData = $getreviewdata['view']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rating): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <div class="product-review pb-4 mb-4 border-bottom review-item">
                <div class="d-flex mb-3">
                  <div class="media media-ie-fix align-items-center mr-4 pr-2">
                  <?php if($rating->or_user_id == 0): ?>
                  <img class="rounded-circle" width="50" src="<?php echo e(url('/')); ?>/public/img/no-user.png" alt=""/>
                  <?php else: ?>
                  <?php if(Helper::Get_User_Photo($rating->or_user_id)!=''): ?>
                  <img class="rounded-circle" width="50" src="<?php echo e(url('/')); ?>/public/storage/users/<?php echo e(Helper::Get_User_Photo($rating->or_user_id)); ?>" alt=""/>
                  <?php else: ?>
                  <img class="rounded-circle" width="50" src="<?php echo e(url('/')); ?>/public/img/no-user.png" alt=""/>
                  <?php endif; ?>
                  <?php endif; ?>
                    <div class="media-body pl-3">
                      <h6 class="font-size-sm mb-0"><?php if($rating->or_user_id == 0): ?><?php echo e($rating->or_username); ?><?php else: ?><?php echo e(Helper::Get_User_Name($rating->or_user_id)); ?><?php endif; ?></h6><span class="font-size-ms text-muted"><?php echo e(date('d F Y H:i:s', strtotime($rating->rating_date))); ?></span></div>
                  </div>
                  <div>
                    <div class="star-rating">
                    <?php if($rating->rating == 0): ?>
                    <i class="sr-star dwg-star"></i>
                    <i class="sr-star dwg-star"></i>
                    <i class="sr-star dwg-star"></i>
                    <i class="sr-star dwg-star"></i>
                    <i class="sr-star dwg-star"></i>
                    <?php endif; ?>
                    <?php if($rating->rating == 1): ?>
                    <i class="sr-star dwg-star-filled active"></i>
                    <i class="sr-star dwg-star"></i>
                    <i class="sr-star dwg-star"></i>
                    <i class="sr-star dwg-star"></i>
                    <i class="sr-star dwg-star"></i>
                    <?php endif; ?>
                    <?php if($rating->rating == 2): ?>
                    <i class="sr-star dwg-star-filled active"></i>
                    <i class="sr-star dwg-star-filled active"></i>
                    <i class="sr-star dwg-star"></i>
                    <i class="sr-star dwg-star"></i>
                    <i class="sr-star dwg-star"></i>
                    <?php endif; ?>
                    <?php if($rating->rating == 3): ?>
                    <i class="sr-star dwg-star-filled active"></i>
                    <i class="sr-star dwg-star-filled active"></i>
                    <i class="sr-star dwg-star-filled active"></i>
                    <i class="sr-star dwg-star"></i>
                    <i class="sr-star dwg-star"></i>
                    <?php endif; ?>
                    <?php if($rating->rating == 4): ?>
                    <i class="sr-star dwg-star-filled active"></i>
                    <i class="sr-star dwg-star-filled active"></i>
                    <i class="sr-star dwg-star-filled active"></i>
                    <i class="sr-star dwg-star-filled active"></i>
                    <i class="sr-star dwg-star"></i>
                    <?php endif; ?>
                    <?php if($rating->rating == 5): ?>
                    <i class="sr-star dwg-star-filled active"></i>
                    <i class="sr-star dwg-star-filled active"></i>
                    <i class="sr-star dwg-star-filled active"></i>
                    <i class="sr-star dwg-star-filled active"></i>
                    <i class="sr-star dwg-star-filled active"></i>
                    <?php endif; ?>
                    </div>
                    <div class="review_tag"><?php echo e($rating->rating_reason); ?></div>
                  </div>
                </div>
                <p class="font-size-md mb-2"><?php echo e($rating->rating_comment); ?></p>
              </div>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              <div class="float-right">
                 <div class="pagination-area">
                    <div class="turn-page" id="reviewpager"></div>
                    </div> 
              </div>
            </div>
            <!-- Leave review form-->
         </div>
         <?php endif; ?>
        </div>
        <!-- Comments tab-->
        <div class="tab-pane fade" id="comments" role="tabpanel">
          <div class="row thread">
            <div class="col-lg-12">
              <div class="media-list thread-list" id="listShow">
                                    <?php $__currentLoopData = $comment['view']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $parent): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="single-thread commli-item">
                                            <div class="media">
                                                <div class="media-left">
                                                    <?php if($parent->user_photo!=''): ?>
                                                    <img  src="<?php echo e(url('/')); ?>/public/storage/users/<?php echo e($parent->user_photo); ?>" alt="<?php echo e($parent->username); ?>" class="rounded-circle" width="50"><?php else: ?>
                                                    <img src="<?php echo e(url('/')); ?>/public/img/no-user.png" alt="<?php echo e($parent->username); ?>" class="rounded-circle" width="50">
                                                    <?php endif; ?>
                                                </div>
                                                <div class="media-body">
                                                    <div>
                                                        <div class="media-heading">
                                                            <h6 class="font-size-md mb-0"><?php echo e($parent->username); ?></h6>
                                                        </div>
                                                        <?php if($parent->id == $item['view']->user_id): ?>
                                                        <span class="comment-tag buyer"><?php echo e(__('Author')); ?></span>
                                                        <?php endif; ?>
                                                        <?php if(Auth::check()): ?>
                                                        <?php if($item['view']->user_id == Auth::user()->id): ?>
                                                        <a href="javascript:void(0);" class="nav-link-style font-size-sm font-weight-medium reply-link"><i class="dwg-reply mr-2">
                                                        </i><?php echo e(__('Reply')); ?></a>
                                                        <?php endif; ?>
                                                        <?php endif; ?>
                                                    </div>
                                                    <p class="font-size-md mb-1"><?php echo e($parent->comm_text); ?></p>
                                                    <span class="font-size-ms text-muted"><i class="dwg-time align-middle mr-2"></i><?php echo e(date('d F Y, H:i:s', strtotime($parent->comm_date))); ?></span>
                                                </div>
                                            </div>
                                            <div class="children">
                                            <?php $__currentLoopData = $parent->replycomment; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $child): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <div class="single-thread depth-2">
                                                    <div class="media">
                                                        <div class="media-left">
                                                    <?php if($child->user_photo!=''): ?>
                                                    <img  src="<?php echo e(url('/')); ?>/public/storage/users/<?php echo e($child->user_photo); ?>" alt="<?php echo e($child->username); ?>" class="rounded-circle" width="50"><?php else: ?>
                                                    <img src="<?php echo e(url('/')); ?>/public/img/no-user.png" alt="<?php echo e($child->username); ?>" class="rounded-circle" width="50">
                                                    <?php endif; ?>
                                                    </div>
                                                        <div class="media-body">
                                                            <div class="media-heading">
                                                                <h6 class="font-size-md mb-0"><?php echo e($child->username); ?></h6>
                                                             </div>
                                                            <?php if($child->id == $item['view']->user_id): ?>
                                                            <span class="comment-tag buyer"><?php echo e(__('Author')); ?></span>
                                                            <?php endif; ?>
                                                            <p class="font-size-md mb-1"><?php echo e($child->comm_text); ?></p>
                                                            <span class="font-size-ms text-muted"><i class="dwg-time align-middle mr-2"></i><?php echo e(date('d F Y, H:i:s', strtotime($child->comm_date))); ?></span></div>
                                                    </div>
                                                  </div>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </div>
                                            <!-- comment reply -->
                                            <?php if(Auth::check()): ?>
                                            <div class="media depth-2 reply-comment">
                                                <div class="media-left">
                                                    <?php if(Auth::user()->user_photo!=''): ?>
                                        <img  src="<?php echo e(url('/')); ?>/public/storage/users/<?php echo e(Auth::user()->user_photo); ?>" alt="<?php echo e(Auth::user()->username); ?>" class="rounded-circle" width="50"><?php else: ?>
                                        <img src="<?php echo e(url('/')); ?>/public/img/no-user.png" alt="<?php echo e(Auth::user()->username); ?>" class="rounded-circle" width="50">
                                        <?php endif; ?>
                                            </div>
                                                <div class="media-body">
                                                    <form action="<?php echo e(route('reply-post-comment')); ?>" class="comment-reply-form media-body needs-validation" method="post" enctype="multipart/form-data">
                                                    <?php echo e(csrf_field()); ?>

                                                    <textarea name="comm_text" class="form-control" placeholder="<?php echo e(__('Write your comment')); ?>..." required></textarea>
                                                    <input type="hidden" name="comm_user_id" value="<?php echo e(Auth::user()->id); ?>">
                                                    <input type="hidden" name="comm_product_user_id" value="<?php echo e($item['view']->user_id); ?>">
                                                    <input type="hidden" name="comm_product_id" value="<?php echo e($item['view']->product_id); ?>">
                                                    <input type="hidden" name="comm_id" value="<?php echo e($parent->comm_id); ?>">
                                                    <input type="hidden" name="comm_product_url" value="<?php echo e(URL::to('/item')); ?>/<?php echo e($item['view']->product_slug); ?>">
                                                   <button class="btn btn-primary btn-sm"><?php echo e(__('Post Comment')); ?></button>
                                                </form>
                                                </div>
                                            </div>
                                            <?php endif; ?>
                                            <!-- comment reply -->
                                        </div>
                                       <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div>
                                   <?php if($comment_count != 0): ?>
                                   <div class="float-right">
                                        <div class="pagination-area">
                                                <div class="turn-page" id="commpager"></div>
                                        </div> 
                                   </div>
                                   <?php endif; ?>
                  <div class="clearfix"></div>
                  <?php if(Auth::check()): ?>
                  <?php if($item['view']->user_id != Auth::user()->id): ?>
                   <div class="card border-0 box-shadow my-2">
                   <h4 class="mt-4 ml-4"><?php echo e(__('Leave a comment')); ?></h4>
                    <div class="card-body">
                      <div class="media">
                      <?php if(Auth::user()->user_photo != ''): ?>
                      <img class="rounded-circle" width="50" src="<?php echo e(url('/')); ?>/public/storage/users/<?php echo e(Auth::user()->user_photo); ?>" alt="<?php echo e(Auth::user()->name); ?>"/>
                      <?php else: ?>
                      <img class="rounded-circle" width="50" src="<?php echo e(url('/')); ?>/public/img/no-user.png" alt="<?php echo e(Auth::user()->name); ?>"/>
                      <?php endif; ?>
                      <form action="<?php echo e(route('post-comment')); ?>" class="comment-reply-form media-body needs-validation ml-3" id="item_form" method="post" enctype="multipart/form-data">
                        <?php echo e(csrf_field()); ?>

                          <div class="form-group">
                            <textarea class="form-control" rows="4" name="comm_text" placeholder="<?php echo e(__('Write comment')); ?>..." data-bvalidator="required"></textarea>
                            <input type="hidden" name="comm_user_id" value="<?php echo e(Auth::user()->id); ?>">

                            <input type="hidden" name="comm_product_user_id" value="<?php echo e($item['view']->user_id); ?>">
                            <input type="hidden" name="comm_product_id" value="<?php echo e($item['view']->product_id); ?>">
                            <input type="hidden" name="comm_product_url" value="<?php echo e(URL::to('/item')); ?>/<?php echo e($item['view']->product_slug); ?>">
                            <div class="invalid-feedback"><?php echo e(__('Please write your comment')); ?></div>
                          </div>
                          <button class="btn btn-primary btn-sm" type="submit"><?php echo e(__('Post Comment')); ?></button>
                        </form>
                  </div>
                </div>
              </div>
              <?php endif; ?>
              <?php endif; ?>
            </div>
          </div>
        </div>
      </div>
    </div>
    <?php if(in_array('item-details',$bottom_ads)): ?>
     <div class="mt-3 mb-2" align="center">
     <?php echo html_entity_decode($allsettings->bottom_ads); ?>
     </div>
     <?php endif; ?>
     </div>
    </section>
          <!-- Sidebar-->
          <aside class="col-lg-4">
            <hr class="d-lg-none">
            <form action="<?php echo e(route('cart')); ?>" class="setting_form" method="post" id="order_form" enctype="multipart/form-data">
            <?php echo e(csrf_field()); ?> 
            <div class="cz-sidebar-static h-100 ml-auto border-left">
               <?php if($item['view']->download_count == "") { $dcount = 0; } else { $dcount = $item['view']->download_count; } ?>
               <?php if($item['view']->product_free == 1): ?>
               <div class="bg-secondary rounded p-3 mb-4">
               <p><?php echo e(__('This item is one of the')); ?> <strong><?php echo e(__('free files')); ?></strong>. <?php echo e(__('You are able to download this item for free for a limited time. Updates and support are only available if you purchase this item')); ?></p>
               
               <div align="center">
                   <?php if(Auth::check()): ?>
                   <a href="<?php echo e(URL::to('/item')); ?>/download/<?php echo e(base64_encode($item['view']->product_token)); ?>" class="btn btn-primary btn-sm"> <i class="fa fa-download"></i> <?php echo e(__('Download this file for free')); ?> (<?php echo e($dcount); ?>)</a>
                   <?php endif; ?>
                   <?php if(Auth::guest()): ?>
                   <a href="<?php echo e(URL::to('/login')); ?>" class="btn btn-primary btn-sm"> <i class="fa fa-download"></i> <?php echo e(__('Download this file for free')); ?> (<?php echo e($dcount); ?>)</a>
                   <?php endif; ?>
                </div>
               </div>
               <?php else: ?>
               <?php if($allsettings->subscription_mode == 1): ?>
                   <?php if(Auth::check()): ?>
                   <?php if(Auth::user()->user_subscr_type != ""): ?>
                   <?php if(Auth::user()->user_subscr_date >= date('Y-m-d')): ?>
                   <?php if($item['view']->subscription_item == 1): ?>
                   <div class="bg-secondary rounded p-3 mb-4">
                   <p><?php echo e(__('This product is one of the Subscribe Users Free Download Files. You are able to download this product for free for a Unlimited time. Updates and support are only available if you purchase this item')); ?></p>
                   <div align="center">
                   <a href="<?php echo e(URL::to('/item')); ?>/download/<?php echo e(base64_encode($item['view']->product_token)); ?>" class="btn btn-primary btn-sm"> <i class="fa fa-download"></i> <?php echo e(__('Download this file for free')); ?> (<?php echo e($dcount); ?>)</a>
                   </div>
                   </div>
                   <?php endif; ?>
                   <?php else: ?>
                   <?php if($item['view']->subscription_item == 1): ?>
                   <div class="bg-secondary rounded p-3 mb-4">
                   <p><?php echo e(__('Subscribe to unlock this product, plus millions of creative assets with unlimited downloads')); ?></p>
                   <div align="center">
                   <a href="<?php echo e(URL::to('/subscription')); ?>" class="btn btn-primary btn-sm"> <i class="fa fa-download"></i> <?php echo e(__('Renew Subscription')); ?> (<?php echo e($dcount); ?>)</a>
                   </div>
                   </div>
                   <?php endif; ?>
                   <?php endif; ?>
                   <?php else: ?>
                   <?php if($item['view']->subscription_item == 1): ?>
                   <div class="bg-secondary rounded p-3 mb-4">
                   <p><?php echo e(__('Subscribe to unlock this product, plus millions of creative assets with unlimited downloads')); ?></p>
                   <div align="center">
                   <a href="<?php echo e(URL::to('/subscription')); ?>" class="btn btn-primary btn-sm"> <i class="fa fa-download"></i> <?php echo e(__('Subscribe to download')); ?> (<?php echo e($dcount); ?>)</a>
                   </div>
                   </div>
                   <?php endif; ?>
                   <?php endif; ?>
                   <?php endif; ?>
                   <?php if(Auth::guest()): ?>
                   <?php if($item['view']->subscription_item == 1): ?>
                   <div class="bg-secondary rounded p-3 mb-4">
                   <p><?php echo e(__('Subscribe to unlock this product, plus millions of creative assets with unlimited downloads')); ?></p>
                   <div align="center">
                   <a href="<?php echo e(URL::to('/subscription')); ?>" class="btn btn-primary btn-sm"> <i class="fa fa-download"></i> <?php echo e(__('Subscribe to download')); ?> (<?php echo e($dcount); ?>)</a>
                   </div>
                   </div>
                   <?php endif; ?>
                   <?php endif; ?>
               <?php endif; ?>
               <?php endif; ?> 
                <?php /*?><?php if($item['view']->product_flash_sale == 1)
                { 
                $regprice = ($allsettings->site_flash_sale_discount * $item['view']->regular_price) / 100;
                $exprice = ($allsettings->site_flash_sale_discount * $item['view']->extended_price) / 100;
                $item_price = round($regprice,2);
                $extend_item_price = round($exprice,2);
                } 
                else 
                { 
                $item_price = $item['view']->regular_price;
                $extend_item_price = $item['view']->extended_price; 
                } 
                ?><?php */?>
              <?php
              $item_price = Helper::price_info($item['view']->product_flash_sale,$item['view']->regular_price);
                $extend_item_price = Helper::price_info($item['view']->product_flash_sale,$item['view']->extended_price);
               ?> 
              <div class="accordion" id="licenses">
                <div class="card border-top-0 border-left-0 border-right-0">
                  <div class="card-header d-flex justify-content-between align-items-center py-3 border-0">
                    <div class="custom-control custom-radio">
                      <input class="custom-control-input" type="radio" name="item_price" value="<?php echo e(base64_encode($item_price)); ?>_regular" id="license-std" checked>
                      <label class="custom-control-label font-weight-medium text-dark" for="license-std" data-toggle="collapse" data-target="#standard-license"><?php echo e(__('Regular license')); ?></label>
                    </div>
                    <h5 class="mb-0 text-accent font-weight-normal"><?php if($item['view']->product_flash_sale == 1): ?><del class="price-old fontsize17"><?php echo e($allsettings->site_currency_symbol); ?><?php echo e($item['view']->regular_price); ?></del><?php endif; ?> <span class="bg-faded-accent rounded-sm py-1 px-2 fontsize17"><?php echo e($allsettings->site_currency_symbol); ?><?php echo e($item_price); ?></span>
                    </h5>
                  </div>
                  <div class="collapse show" id="standard-license" data-parent="#licenses">
                    <div class="card-body py-0 pb-2">
                      <ul class="list-unstyled font-size-sm">
                        <li class="d-flex align-items-center"><i class="dwg-check-circle text-success mr-1"></i><span class="font-size-ms"><?php echo e(__('Quality checked by')); ?> <?php echo e($allsettings->site_title); ?></span></li>
                        <?php if($item['view']->future_update == 1): ?> 
                        <li class="d-flex align-items-center"><i class="dwg-check-circle text-success mr-1"></i><span class="font-size-ms"><?php echo e(__('Future updates')); ?></span></li>
                        <?php else: ?>
                        <li class="d-flex align-items-center"><i class="dwg-close-circle text-danger mr-1"></i><span class="font-size-ms"><?php echo e(__('Future updates')); ?></span></li>
                        <?php endif; ?>
                        <?php if($item['view']->item_support == 1): ?>
                        <li class="d-flex align-items-center"><i class="dwg-check-circle text-success mr-1"></i><span class="font-size-ms"><?php echo e(__('6 Months support')); ?></span></li>
                        <?php else: ?>
                        <li class="d-flex align-items-center"><i class="dwg-close-circle text-danger mr-1"></i><span class="font-size-ms"><?php echo e(__('6 Months support')); ?></span></li>
                        <?php endif; ?>
                      </ul>
                    </div>
                  </div>
                </div>
                <?php if($item['view']->extended_price != 0): ?>
                <div class="card border-bottom-0 border-left-0 border-right-0">
                  <div class="card-header d-flex justify-content-between align-items-center py-3 border-0">
                    <div class="custom-control custom-radio">
                      <input class="custom-control-input" type="radio" name="item_price" id="license-ext" value="<?php echo e(base64_encode($extend_item_price)); ?>_extended">
                      <label class="custom-control-label font-weight-medium text-dark" for="license-ext" data-toggle="collapse" data-target="#extended-license"><?php echo e(__('Extended license')); ?></label>
                    </div>
                    <h5 class="mb-0 text-accent font-weight-normal"><?php if($item['view']->product_flash_sale == 1): ?><del class="price-old fontsize17"><?php echo e($allsettings->site_currency_symbol); ?><?php echo e($item['view']->extended_price); ?></del><?php endif; ?> <span class="bg-faded-accent  rounded-sm py-1 px-2 fontsize17"><?php echo e($allsettings->site_currency_symbol); ?><?php echo e($extend_item_price); ?></span></h5>
                  </div>
                  <div class="collapse" id="extended-license" data-parent="#licenses">
                    <div class="card-body py-0 pb-2">
                      <ul class="list-unstyled font-size-sm">
                        <li class="d-flex align-items-center"><i class="dwg-check-circle text-success mr-1"></i><span class="font-size-ms"><?php echo e(__('Quality checked by')); ?> <?php echo e($allsettings->site_title); ?></span></li>
                        <?php if($item['view']->future_update == 1): ?> 
                        <li class="d-flex align-items-center"><i class="dwg-check-circle text-success mr-1"></i><span class="font-size-ms"><?php echo e(__('Future updates')); ?></span></li>
                        <?php else: ?>
                        <li class="d-flex align-items-center"><i class="dwg-close-circle text-danger mr-1"></i><span class="font-size-ms"><?php echo e(__('Future updates')); ?></span></li>
                        <?php endif; ?>
                        <?php if($item['view']->item_support == 1): ?>
                        <li class="d-flex align-items-center"><i class="dwg-check-circle text-success mr-1"></i><span class="font-size-ms"><?php echo e(__('12 Months support')); ?></span></li>
                        <?php else: ?>
                        <li class="d-flex align-items-center"><i class="dwg-close-circle text-danger mr-1"></i><span class="font-size-ms"><?php echo e(__('12 Months support')); ?></span></li>
                        <?php endif; ?>
                      </ul>
                    </div>
                  </div>
                </div>
                <?php endif; ?>
              </div>
              <hr>
              <?php if($allsettings->product_support_link !=''): ?>
              <p class="mt-2 mb-3"><a href="javascript:void(0)" data-toggle="modal" data-target="#myModal" class="font-size-xs"><?php echo e($page['view']->page_title); ?></a></p>
                <div class="modal fade" id="myModal">
                    <div class="modal-dialog modal-xl">
                      <div class="modal-content">
                         <div class="modal-header">
                          <h4 class="modal-title"><?php echo e($page['view']->page_title); ?></h4>
                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body">
                         <?php echo html_entity_decode($page['view']->page_desc); ?>
                        </div>
                       </div>
                    </div>
                  </div>
                <?php endif; ?>
                <input type="hidden" name="product_id" value="<?php echo e($item['view']->product_id); ?>">
                <input type="hidden" name="product_name" value="<?php echo e($item['view']->product_name); ?>">
                <input type="hidden" name="product_user_id" value="<?php echo e($item['view']->user_id); ?>">
                <input type="hidden" name="product_token" value="<?php echo e($item['view']->product_token); ?>">
                <?php if(Auth::guest()): ?>
                <button type="submit" class="btn btn-primary btn-shadow btn-block mt-4"><i class="dwg-cart font-size-lg mr-2"></i><?php echo e(__('Add to Cart')); ?></button>
                <?php endif; ?>
                <?php if(Auth::check()): ?>
                <?php if($item['view']->user_id == Auth::user()->id): ?>
                <a href="<?php echo e(URL::to('/admin/edit-product')); ?>/<?php echo e($item['view']->product_token); ?>" class="btn btn-primary btn-shadow btn-block mt-4"><i class="dwg-cart font-size-lg mr-2"></i><?php echo e(__('Edit Product')); ?></a>
                <?php else: ?>
                <?php /*?><input type="hidden" name="user_id" value="{{ Auth::user()->id }}"><?php */?>
                <?php if($checkif_purchased == 0): ?>
                <?php if(Auth::user()->id != 1): ?>
                <button type="submit" class="btn btn-primary btn-shadow btn-block mt-4"><i class="dwg-cart font-size-lg mr-2"></i><?php echo e(__('Add to Cart')); ?></button>
                <?php endif; ?> 
                <?php endif; ?>    
                <?php endif; ?>
                <?php endif; ?> 
                <?php if($item['view']->product_sold == 0){ $sale_text = "Sale"; } else  { $sale_text = "Sales"; } ?>
              <?php if($custom_settings->product_sale_count == 1): ?>
              <div class="bg-secondary rounded p-3 mt-4 mb-2"><i class="dwg-download h5 text-muted align-middle mb-0 mt-n1 mr-2"></i><span class="d-inline-block h6 mb-0 mr-1"><?php echo e($item['view']->product_sold); ?></span><span class="font-size-sm"><?php echo e($sale_text); ?></span></div>
              <?php endif; ?>
              <div class="bg-secondary rounded p-3 mb-2">
                <div class="star-rating">
                <?php if($getreview == 0): ?>
                <i class="sr-star dwg-star"></i>
                <i class="sr-star dwg-star"></i>
                <i class="sr-star dwg-star"></i>
                <i class="sr-star dwg-star"></i>
                <i class="sr-star dwg-star"></i>
                <?php else: ?>
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
                <?php endif; ?>
                </div>
                <?php if(!empty($item['view']->product_fake_stars)): ?>
                <div class="font-size-ms text-muted"><?php echo e($item['view']->product_fake_stars); ?> <?php echo e(__('Ratings')); ?></div>
                <?php else: ?>
                <div class="font-size-ms text-muted"><?php echo e($getreview); ?> <?php echo e(__('Ratings')); ?></div>
                <?php endif; ?>
              </div>
              <div class="bg-secondary rounded p-3 mb-4"><i class="dwg-chat h5 text-muted align-middle mb-0 mt-n1 mr-2"></i><span class="d-inline-block h6 mb-0 mr-1"><?php echo e($comment_count); ?></span><span class="font-size-sm"><?php echo e(__('Comments')); ?></span></div>
              <ul class="list-unstyled font-size-sm">
                <li class="d-flex justify-content-between mb-3 pb-3 border-bottom"><span class="text-dark font-weight-medium"><?php echo e(__('Last update')); ?></span><span class="text-muted"><?php echo e(date('d M Y', strtotime($item['view']->product_update))); ?></span></li>
                <li class="d-flex justify-content-between mb-3 pb-3 border-bottom"><span class="text-dark font-weight-medium"><?php echo e(__('Created')); ?></span><span class="text-muted"><?php echo e(date('d M Y', strtotime($item['view']->product_date))); ?></span></li>
                <li class="d-flex justify-content-between mb-3 pb-3 border-bottom"><span class="text-dark font-weight-medium"><?php echo e(__('Category')); ?></span><a class="product-meta" href="<?php echo e(URL::to('/shop/category')); ?>/<?php echo e($item['view']->category_slug); ?>"><?php echo e($item['view']->category_name); ?></a></li>
                <?php /*?><li class="d-flex justify-content-between mb-3 pb-3 border-bottom"><span class="text-dark font-weight-medium title-width">{{ __('Package Includes') }}</span><span class="text-muted text-right">
                    <?php $pack_info = ""; ?>
                    @foreach($package['view'] as $package)
                    <?php $checkpackage = explode(',',$item['view']->package_includes); ?>
                    <?php if(in_array($package->package_id,$checkpackage)){ $pack_info .= $package->package_name.', '; } ?>
                    @endforeach 
                    {{ rtrim($pack_info,", ") }}
                    </span></li><?php */?>
                <?php /*?><li class="d-flex justify-content-between mb-3 pb-3 border-bottom"><span class="text-dark font-weight-medium title-width">{{ __('Compatible Browsers') }}</span><span class="text-muted text-right">       <?php $browse_info = ""; ?>
                    @foreach($browser['view'] as $package)
                    <?php $checkpackage = explode(',',$item['view']->compatible_browsers); ?>
                    <?php if(in_array($package->browser_id,$checkpackage)){ $browse_info .= $package->browser_name.', '; } ?>
                    @endforeach 
                    {{ rtrim($browse_info,", ") }}
                    </span></li><?php */?>
                    <?php if(count($viewattribute['details']) != 0): ?>
                <?php $__currentLoopData = $viewattribute['details']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $view_attribute): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php if($view_attribute->product_attribute_values != ""): ?>
                <li class="d-flex justify-content-between mb-3 pb-3 border-bottom"><span class="text-dark font-weight-medium"><?php echo e($view_attribute->product_attribute_label); ?></span><span class="text-muted"><?php echo str_replace(',', ',<br />', $view_attribute->product_attribute_values); ?> </span></li>
                <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endif; ?>
                    <?php if($item['view']->product_tags != ''): ?>
                 <li class="justify-content-between pb-3 border-bottom"><span class="text-dark font-weight-medium"><?php echo e(__('Tags')); ?></span><br/>
                 <?php $item_tags = explode(',',$item['view']->product_tags); ?>
                 <?php $__currentLoopData = $item_tags; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tags): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                 <span class="text-right"><a href="<?php echo e(url('/tag')); ?>/item/<?php echo e(strtolower(str_replace(' ','-',$tags))); ?>" class="link-color"><?php echo e($tags.','); ?></a></span>
                 <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                 </li>
                 <?php endif; ?>
              </ul>
              <?php if(in_array('item-details',$sidebar_ads)): ?>
          	<div class="mt-3 mb-2" align="center">
            <?php echo html_entity_decode($allsettings->sidebar_ads); ?>
          	</div>
         	<?php endif; ?>
            </div>
            </form>
          </aside>
        </div>
      </div>
    </section>
    
    <section <?php if($custom_settings->theme_layout == 'container'): ?> class="container-fluid mb-5 pb-lg-3" <?php else: ?> class="container mb-5 pb-lg-3" <?php endif; ?>>
      <div class="d-flex flex-wrap justify-content-between align-items-center border-bottom pb-4 mb-4">
        <h2 class="h3 mb-0 pt-2"><?php echo e(__('Related Products')); ?></h2>
      </div>
      <div class="row pt-2 mx-n2">
        <!-- Product-->
        <?php $no = 1; ?>
        <?php $__currentLoopData = $related['product']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $featured): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php
        $price = Helper::price_info($featured->product_flash_sale,$featured->regular_price);
        $count_rating = Helper::count_rating($featured->ratings);
        ?>
        <div <?php if($custom_settings->theme_layout == 'container'): ?> class="col-6 col-xs-6 col-sm-6 col-md-4 col-lg-2 px-2 mb-grid-gutter prod-item" <?php else: ?> class="col-6 col-xs-6 col-sm-6 col-md-4 col-lg-3 px-2 mb-grid-gutter prod-item" <?php endif; ?>>
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
                <div class="font-size-sm mr-2"><i class="dwg-download text-muted mr-1"></i><?php echo e($featured->product_sold); ?><span class="font-size-xs ml-1"><?php echo e(__('Sales')); ?></span>
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
<?php echo $__env->make('footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php echo $__env->make('script', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
</body>
</html><?php /**PATH /home/arixmyii/bittoz.shop/public_html/resources/views/pages/item.blade.php ENDPATH**/ ?>