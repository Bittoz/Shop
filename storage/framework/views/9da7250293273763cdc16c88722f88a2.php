<!doctype html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js" lang="en">
<!--<![endif]-->

<head>
    
    <?php echo $__env->make('admin.stylesheet', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
</head>

<body>
    
    <?php echo $__env->make('admin.navigation', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <!-- Right Panel -->
    <?php if(in_array('settings',$avilable)): ?>
    <div id="right-panel" class="right-panel">

       
                       <?php echo $__env->make('admin.header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                       

        <div class="breadcrumbs">
            <div class="col-sm-4">
                <div class="page-header float-left">
                    <div class="page-title">
                        <h1><?php echo e(__('General Settings')); ?></h1>
                    </div>
                </div>
            </div>
            <div class="col-sm-8">
                <div class="page-header float-right">
                    
                </div>
            </div>
        </div>
        
        <?php echo $__env->make('admin.warning', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

        <div class="content mt-3">
            <div class="animated fadeIn">
                <div class="row">

                    <div class="col-md-12">
                       
                        
                        
                      
                        <div class="card">
                           <?php if($demo_mode == 'on'): ?>
                           <?php echo $__env->make('admin.demo-mode', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                           <?php else: ?>
                           <form action="<?php echo e(route('admin.general-settings')); ?>" method="post" id="setting_form" enctype="multipart/form-data">
                           <?php echo e(csrf_field()); ?>

                           <?php endif; ?>
                          
                           <div class="col-md-6">
                           
                            <div class="card-body">
                                <!-- Credit Card -->
                                <div id="pay-invoice">
                                    <div class="card-body">
                                       
                                        
                                            
                                            <div class="form-group">
                                                <label for="site_title" class="control-label mb-1"><?php echo e(__('Site Name')); ?> <span class="require">*</span></label>
                                                <input id="site_title" name="site_title" type="text" class="form-control noscroll_textarea" value="<?php echo e($setting['setting']->site_title); ?>" data-bvalidator="required">
                                            </div>
                                            
                                            <div class="form-group">
                                                <label for="site_title" class="control-label mb-1"><?php echo e(__('Home Page Title')); ?> <span class="require">*</span></label>
                                                <input id="site_home_title" name="site_home_title" type="text" class="form-control noscroll_textarea" value="<?php echo e($setting['setting']->site_home_title); ?>" data-bvalidator="required">
                                            </div>
                                            
                                             <div class="form-group">
                                                <label for="site_desc" class="control-label mb-1"><?php echo e(__('Meta Description')); ?> (<?php echo e(__('max 160 chars')); ?>) <span class="require">*</span></label>
                                                
                                            <textarea name="site_desc" id="site_desc" rows="6" placeholder="site description" class="form-control noscroll_textarea" data-bvalidator="required,maxlen[160]"><?php echo e($setting['setting']->site_desc); ?></textarea>
                                            </div>
                                                
                                               <div class="form-group">
                                                <label for="site_keywords" class="control-label mb-1"><?php echo e(__('Meta Keywords')); ?> (<?php echo e(__('max 160 chars')); ?>) <span class="require">*</span></label>
                                                
                                            <textarea name="site_keywords" id="site_keywords" rows="6" placeholder="separate keywords with commas" class="form-control noscroll_textarea" data-bvalidator="required,maxlen[160]"><?php echo e($setting['setting']->site_keywords); ?></textarea>
                                            </div>  
                                                
                                                
                                              
                                           
                                            
                                            
                                            <div class="form-group">
                                                <label for="site_copyright" class="control-label mb-1"><?php echo e(__('Copyright')); ?><span class="require">*</span></label>
                                                <input id="site_copyright" name="site_copyright" type="text" class="form-control noscroll_textarea" value="<?php echo e($setting['setting']->site_copyright); ?>" data-bvalidator="required">
                                            </div>  
                                            
                                                                                  
                                             
                                             <div class="form-group">
                                                <label for="site_title" class="control-label mb-1"><?php echo e(__('Site Email')); ?> <span class="require">*</span></label>
                                                <input id="office_email" name="office_email" type="text" class="form-control noscroll_textarea" value="<?php echo e($setting['setting']->office_email); ?>" data-bvalidator="required,email">
                                            </div>
                                                
                                             <div class="form-group">
                                                <label for="site_title" class="control-label mb-1"><?php echo e(__('Site Phone Number')); ?> <span class="require">*</span></label>
                                                <input id="office_phone" name="office_phone" type="text" class="form-control noscroll_textarea" value="<?php echo e($setting['setting']->office_phone); ?>" data-bvalidator="required">
                                            </div> 
                                            
                                               <div class="form-group">
                                                <label for="site_desc" class="control-label mb-1"><?php echo e(__('Address')); ?> <span class="require">*</span></label>
                                                
                                            <textarea name="office_address" id="office_address" rows="4" class="form-control noscroll_textarea" data-bvalidator="required"><?php echo e($setting['setting']->office_address); ?></textarea>
                                            </div> 
                                            
                                            
                                            <div class="form-group">
                                                <label for="site_loader_display" class="control-label mb-1"><?php echo e(__('Select Product License Details Page')); ?> <span class="require">*</span></label><br/>
                                               
                                                <select name="product_support_link" class="form-control" data-bvalidator="required">
                                                <option value=""></option>
                                                <?php $__currentLoopData = $page['view']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($page->page_slug); ?>" <?php if($setting['setting']->product_support_link == $page->page_slug): ?> selected <?php endif; ?>><?php echo e($page->page_title); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>
                                                <small>(this page used on single product details page)</small>
                                             </div>
                                             
                                             <div class="form-group">
                                                <label for="site_desc" class="control-label mb-1"><?php echo e(__('Cookie Popup Text')); ?> <span class="require">*</span></label>
                                                
                                            <textarea name="cookie_popup_text" id="cookie_popup_text" rows="4" class="form-control noscroll_textarea" data-bvalidator="required"><?php echo e($setting['setting']->cookie_popup_text); ?></textarea>
                                            </div> 
                                            
                                            <div class="form-group">
                                                <label for="site_title" class="control-label mb-1"><?php echo e(__('Header Top Bar')); ?> <span class="require">*</span></label>
                                                <select name="site_header_top_bar" class="form-control" data-bvalidator="required">
                                                <option value=""></option>
                                                <option value="1" <?php if($setting['setting']->site_header_top_bar == 1): ?> selected <?php endif; ?>>Show</option>
                                                <option value="0" <?php if($setting['setting']->site_header_top_bar == 0): ?> selected <?php endif; ?>>Hide</option>
                                                </select>
                                            </div>
                                            
                                            
                                            
                                            <div class="form-group">
                                              <label for="product_approval" class="control-label mb-1"><?php echo e(__('New Registration For Email Verification')); ?>? <span class="require">*</span></label><br/><select name="email_verification" class="form-control" required>
                                                        <option value=""></option>
                                                        <option value="1" <?php if($setting['setting']->email_verification == 1): ?> selected <?php endif; ?>><?php echo e(__('ON')); ?></option>
                                                        <option value="0" <?php if($setting['setting']->email_verification == 0): ?> selected <?php endif; ?>><?php echo e(__('OFF')); ?></option>
                                                        </select>
                                                        <small>(<?php echo e(__('If selected "OFF" automatically verified customers')); ?>)</small>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label for="site_desc" class="control-label mb-1"><?php echo e(__('Live Chat Code')); ?> (Tawk.to) <span class="require">*</span></label>
                                                
        <input type="text" name="site_tawk_chat" id="site_tawk_chat" class="form-control noscroll_textarea" value="<?php echo e($setting['setting']->site_tawk_chat); ?>" required /><small><strong>Example:</strong> https://embed.tawk.to/609bc139b1d5182476b83612/1fdsadaewr</small>
                                            </div>
                                            
                                             
                                            
                                            <div class="form-group">
                                                <label for="site_desc" class="control-label mb-1"><?php echo e(__('Redeem Voucher Term & Conditions')); ?> <span class="require">*</span></label>
                                            <textarea name="redeem_voucher_terms" id="summary-ckeditor" rows="6" placeholder="Term & Conditions" class="form-control"><?php echo e(html_entity_decode($allsettings->redeem_voucher_terms)); ?></textarea>
                                            </div>
                                            
                                            <div class="form-group">
                                              <label for="product_approval" class="control-label mb-1"><?php echo e(__('Demo URL Preview')); ?> <span class="require">*</span></label><br/>
                                              <select name="demo_url_preview" class="form-control" required>
                                                        <option value=""></option>
                                                        <option value="0" <?php if($custom_settings->demo_url_preview == 0): ?> selected <?php endif; ?>><?php echo e(__('Normal')); ?></option>
                                                        <option value="1" <?php if($custom_settings->demo_url_preview == 1): ?> selected <?php endif; ?>><?php echo e(__('Iframe')); ?></option>
                                              </select>
                                            </div>
                                            
                                    </div>
                                </div>

                            </div>
                            </div>
                            
                            
                            
                             <div class="col-md-6">
                             
                             
                             <div class="card-body">
                                <!-- Credit Card -->
                                <div id="pay-invoice">
                                    <div class="card-body">
                             
                               
                             
                             
                             <div class="form-group">
                                                <label for="site_favicon" class="control-label mb-1"><?php echo e(__('Favicon')); ?> (max 24 x 24) <span class="require">*</span></label>
                                                
                                            <input type="file" id="site_favicon" name="site_favicon" class="form-control-file" <?php if($setting['setting']->site_favicon == ''): ?> data-bvalidator="required,extension[jpg:png:jpeg:svg]" data-bvalidator-msg="Please select file of type .jpg, .png, .jpeg or .svg" <?php else: ?> data-bvalidator="extension[jpg:png:jpeg:svg]" data-bvalidator-msg="Please select file of type .jpg, .png, .jpeg or .svg" <?php endif; ?>>
                                            <?php if($setting['setting']->site_favicon != ''): ?>
                                                <img height="24" src="<?php echo e(url('/')); ?>/public/storage/settings/<?php echo e($setting['setting']->site_favicon); ?>" />
                                                <?php endif; ?>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label for="site_logo" class="control-label mb-1"><?php echo e(__('Logo')); ?> (size 200 x 56) <span class="require">*</span></label>
                                                
                                            <input type="file" id="site_logo" name="site_logo" class="form-control-file" <?php if($setting['setting']->site_logo == ''): ?> data-bvalidator="required,extension[jpg:png:jpeg:svg]" data-bvalidator-msg="Please select file of type .jpg, .png, .jpeg or .svg" <?php else: ?> data-bvalidator="extension[jpg:png:jpeg:svg]" data-bvalidator-msg="Please select file of type .jpg, .png, .jpeg or .svg" <?php endif; ?>>
                                            <?php if($setting['setting']->site_logo != ''): ?>
                                                <img height="24" src="<?php echo e(url('/')); ?>/public/storage/settings/<?php echo e($setting['setting']->site_logo); ?>" />
                                                <?php endif; ?>
                                            </div>
                                            
                                            
                                            <div class="form-group">
                                                <label for="site_logo" class="control-label mb-1"><?php echo e(__('Home Page Header Image')); ?> <span class="require">*</span></label>
                                                
                                            <input type="file" id="site_banner" name="site_banner" class="form-control-file" <?php if($setting['setting']->site_banner == ''): ?> data-bvalidator="required,extension[jpg:png:jpeg:svg]" data-bvalidator-msg="Please select file of type .jpg, .png, .jpeg or .svg" <?php else: ?> data-bvalidator="extension[jpg:png:jpeg:svg]" data-bvalidator-msg="Please select file of type .jpg, .png, .jpeg or .svg" <?php endif; ?>>
                                            <?php if($setting['setting']->site_banner != ''): ?>
                                                <img height="50" src="<?php echo e(url('/')); ?>/public/storage/settings/<?php echo e($setting['setting']->site_banner); ?>" />
                                                <?php endif; ?>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label for="site_logo" class="control-label mb-1"><?php echo e(__('Other Page Header Image')); ?> <span class="require">*</span></label>
                                                
                                            <input type="file" id="site_other_banner" name="site_other_banner" class="form-control-file" <?php if($setting['setting']->site_other_banner == ''): ?> data-bvalidator="required,extension[jpg:png:jpeg:svg]" data-bvalidator-msg="Please select file of type .jpg, .png, .jpeg or .svg" <?php else: ?> data-bvalidator="extension[jpg:png:jpeg:svg]" data-bvalidator-msg="Please select file of type .jpg, .png, .jpeg or .svg" <?php endif; ?>>
                                            <?php if($setting['setting']->site_other_banner != ''): ?>
                                                <img height="50" width="200" src="<?php echo e(url('/')); ?>/public/storage/settings/<?php echo e($setting['setting']->site_other_banner); ?>" />
                                                <?php endif; ?>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label for="site_title" class="control-label mb-1"><?php echo e(__('Banner Heading')); ?> <span class="require">*</span></label>
                                                <input id="site_banner_heading" name="site_banner_heading" type="text" class="form-control noscroll_textarea" value="<?php echo e($setting['setting']->site_banner_heading); ?>" data-bvalidator="required">
                                            </div>
                                            
                                            <div class="form-group">
                                                <label for="site_title" class="control-label mb-1"><?php echo e(__('Banner Sub Heading')); ?> <span class="require">*</span></label>
                                                <input id="site_banner_sub_heading" name="site_banner_sub_heading" type="text" class="form-control noscroll_textarea" value="<?php echo e($setting['setting']->site_banner_sub_heading); ?>" data-bvalidator="required">
                                            </div>
                                            
                                            <div class="form-group">
                                                <label for="site_loader_image" class="control-label mb-1"><?php echo e(__('Page Loader GIF')); ?> (200 X 200) <span class="require">*</span></label>
                                                
                                            <input type="file" id="site_loader_image" name="site_loader_image" class="form-control-file" <?php if($setting['setting']->site_loader_image == ''): ?> data-bvalidator="required,extension[gif]" data-bvalidator-msg="Please select file of type .gif" <?php else: ?> data-bvalidator="extension[gif]" data-bvalidator-msg="Please select file of type .gif" <?php endif; ?>>
                                            <?php if($setting['setting']->site_loader_image != ''): ?>
                                                <img height="50" src="<?php echo e(url('/')); ?>/public/storage/settings/<?php echo e($setting['setting']->site_loader_image); ?>" />
                                                <?php endif; ?>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label for="site_loader_display" class="control-label mb-1"><?php echo e(__('Page Loader')); ?> <span class="require">*</span></label><br/>
                                               
                                                <select name="site_loader_display" class="form-control" data-bvalidator="required">
                                                <option value=""></option>
                                                <option value="1" <?php if($setting['setting']->site_loader_display == 1): ?> selected <?php endif; ?>><?php echo e(__('ON')); ?></option>
                                                <option value="0" <?php if($setting['setting']->site_loader_display == 0): ?> selected <?php endif; ?>><?php echo e(__('OFF')); ?></option>
                                                </select>
                                                
                                             </div>
                                            
                                            <div class="form-group">
                                              <label for="product_approval" class="control-label mb-1"><?php echo e(__('Google Recaptcha')); ?>? <span class="require">*</span></label><br/>
                                              <select name="site_google_recaptcha" class="form-control" required>
                                                        <option value=""></option>
                                                        <option value="1" <?php if($setting['setting']->site_google_recaptcha == 1): ?> selected <?php endif; ?>><?php echo e(__('ON')); ?></option>
                                                        <option value="0" <?php if($setting['setting']->site_google_recaptcha == 0): ?> selected <?php endif; ?>><?php echo e(__('OFF')); ?></option>
                                              </select>
                                            </div>
                                            
                                            <div class="form-group">
                                              <label for="product_approval" class="control-label mb-1"><?php echo e(__('Google Recaptcha Version')); ?>? <span class="require">*</span></label><br/>
                                              <select name="google_captcha_version" class="form-control" required>
                                                        <option value=""></option>
                                                        <option value="v2" <?php if($custom_settings->google_captcha_version == 'v2'): ?> selected <?php endif; ?>><?php echo e(__('V2')); ?></option>
                                                        <option value="v3" <?php if($custom_settings->google_captcha_version == 'v3'): ?> selected <?php endif; ?>><?php echo e(__('V3')); ?></option>
                                              </select>
                                            </div>
                                            <div class="form-group mt-3">
                                             <label for="site_title" class="control-label mb-1"><?php echo e(__('Google Recaptcha Site Key')); ?> <span class="require">*</span></label>
                                             <input id="google_recaptcha_site_key" name="google_recaptcha_site_key" type="text" class="form-control noscroll_textarea" value="<?php echo e($custom_settings->google_recaptcha_site_key); ?>" data-bvalidator="required">
                                        </div>
                                        <div class="form-group">
                                             <label for="site_title" class="control-label mb-1"><?php echo e(__('Google Recaptcha Secret Key')); ?> <span class="require">*</span></label>
                                             <input id="google_recaptcha_secret_key" name="google_recaptcha_secret_key" type="text" class="form-control noscroll_textarea" value="<?php echo e($custom_settings->google_recaptcha_secret_key); ?>" data-bvalidator="required">
                                        </div>
                                        
                                            <div class="form-group">
                                              <label for="product_approval" class="control-label mb-1"><?php echo e(__('Product Updates Menu Item')); ?>? <span class="require">*</span></label><br/>
                                              <select name="product_updates_tabs" class="form-control" required>
                                                        <option value=""></option>
                                                        <option value="1" <?php if($setting['setting']->product_updates_tabs == 1): ?> selected <?php endif; ?>><?php echo e(__('ON')); ?></option>
                                                        <option value="0" <?php if($setting['setting']->product_updates_tabs == 0): ?> selected <?php endif; ?>><?php echo e(__('OFF')); ?></option>
                                              </select>
                                              <small>(if "ON" <span class="red-color">Updates</span> menu item will showing on header)</small>
                                            </div>
                                            
                                           <?php /*?><div class="form-group">
                                                <label for="site_favicon" class="control-label mb-1">Footer Payment Gateways Image (size 284 x 30)</label>
                                                
                                            <input type="file" id="site_footer_payment" name="site_footer_payment" class="form-control-file" data-bvalidator="extension[jpg:png:jpeg]" data-bvalidator-msg="Please select file of type .jpg, .png or .jpeg">
                                            @if($setting['setting']->site_footer_payment != '')
                                                <img width="200" height="30" src="{{ url('/') }}/public/storage/settings/{{ $setting['setting']->site_footer_payment }}" />
                                                @endif
                                            </div><?php */?>
                                            
                                            
                                           <div class="form-group">
                                                <label for="site_title" class="control-label mb-1"><?php echo e(__('Flash Sale End Date')); ?> <span class="require">*</span></label>
                                                <input id="site_flash_end_date" name="site_flash_end_date" type="text" class="form-control noscroll_textarea" value="<?php echo e($setting['setting']->site_flash_end_date); ?>" data-bvalidator="required">
                                            </div>
                                           
                                            
                                            <div class="form-group">
                                                <label for="site_loader_display" class="control-label mb-1"><?php echo e(__('Cookie Popup')); ?> <span class="require">*</span></label><br/>
                                               
                                                <select name="cookie_popup" class="form-control" data-bvalidator="required">
                                                <option value=""></option>
                                                
                                                <option value="1" <?php if($setting['setting']->cookie_popup == 1): ?> selected <?php endif; ?>>Yes</option>
                                                <option value="0" <?php if($setting['setting']->cookie_popup == 0): ?> selected <?php endif; ?>>No</option>
                                                </select>
                                              </div>
                                             
                                               
                                               <div class="form-group">
                                                <label for="site_title" class="control-label mb-1"><?php echo e(__('Cookie Button Text')); ?> <span class="require">*</span></label>
                                                <input id="cookie_popup_button" name="cookie_popup_button" type="text" class="form-control noscroll_textarea" value="<?php echo e($setting['setting']->cookie_popup_button); ?>" data-bvalidator="required">
                                            </div>
                                            
                                            <div class="form-group">
                                                <label for="site_title" class="control-label mb-1"><?php echo e(__('Google Analytics')); ?></label>
                                                <input id="google_analytics" name="google_analytics" type="text" class="form-control noscroll_textarea" value="<?php echo e($setting['setting']->google_analytics); ?>">
                                                <span>Example : UA-XXXXX-Y</span>
                                            </div>
                                               
                                               
                                            <div class="form-group">
                                                <label for="site_title" class="control-label mb-1"><?php echo e(__('Reminder of Subscription renewal before days')); ?> (<?php echo e(__('Email')); ?>)</label>
                                                <input id="reminder_renewal_before_days" name="reminder_renewal_before_days" type="text" class="form-control noscroll_textarea" value="<?php echo e($setting['setting']->reminder_renewal_before_days); ?>">
                                                <span>(<?php echo e(__('days')); ?>)</span>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label for="site_title" class="control-label mb-1"><?php echo e(__('Product Reporting URL')); ?></label>
                                                <input id="product_reporting_url" name="product_reporting_url" type="text" class="form-control noscroll_textarea" value="<?php echo e($setting['setting']->product_reporting_url); ?>">
                                                <span>Example : <?php echo e(url('/contact')); ?></span>
                                            </div> 
                                            
                                             <input type="hidden" name="save_footer_payment" value="<?php echo e($setting['setting']->site_footer_payment); ?>">
                                                <input type="hidden" name="save_loader_image" value="<?php echo e($setting['setting']->site_loader_image); ?>">
                                                <input type="hidden" name="image_size" value="<?php echo e($setting['setting']->site_max_image_size); ?>">
                                                <input type="hidden" name="save_logo" value="<?php echo e($setting['setting']->site_logo); ?>">
                                                <input type="hidden" name="save_favicon" value="<?php echo e($setting['setting']->site_favicon); ?>">
                                                <input type="hidden" name="save_banner" value="<?php echo e($setting['setting']->site_banner); ?>">
                                                <input type="hidden" name="save_other_banner" value="<?php echo e($setting['setting']->site_other_banner); ?>">
                                                <input type="hidden" name="sid" value="1">
                             
                             
                             </div>
                                </div>

                            </div>
                             
                             
                             
                             </div>
                             
                             <div class="col-md-12 no-padding">
                             <div class="card-footer">
                                 <button type="submit" name="submit" class="btn btn-primary btn-sm"><i class="fa fa-dot-circle-o"></i> <?php echo e(__('Submit')); ?></button>
                                 <button type="reset" class="btn btn-danger btn-sm"><i class="fa fa-ban"></i> <?php echo e(__('Reset')); ?> </button>
                             </div>
                             
                             </div>
                             
                            
                            </form>
                            
                                                    
                                                    
                                                 
                            
                        </div> 

                     
                    
                    
                    </div>
                    

                </div>
            </div><!-- .animated -->
        </div><!-- .content -->


    </div><!-- /#right-panel -->
    <?php else: ?>
    <?php echo $__env->make('admin.denied', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php endif; ?>
    <!-- Right Panel -->


   <?php echo $__env->make('admin.javascript', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>


</body>

</html>
<?php /**PATH /home/arixmyii/bittoz.shop/public_html/resources/views/admin/general-settings.blade.php ENDPATH**/ ?>