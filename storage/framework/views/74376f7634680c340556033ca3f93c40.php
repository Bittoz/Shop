
<!doctype html>
<html class="no-js" lang="en">
<head>
    <?php echo $__env->make('admin.stylesheet', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
</head>
<body>
    <?php echo $__env->make('admin.navigation', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <?php if(in_array('manage-products',$avilable)): ?>
    <div id="right-panel" class="right-panel">
        <?php echo $__env->make('admin.header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

        <div class="breadcrumbs">
            <div class="col-sm-4">
                <div class="page-header float-left">
                    <div class="page-title"><h1><?php echo e(__('Edit Product')); ?></h1></div>
                </div>
            </div>
            <div class="col-sm-8"><div class="page-header float-right"></div></div>
        </div>
        <?php echo $__env->make('admin.warning', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

        <div class="content mt-3">
            <div class="animated fadeIn">
                <div class="row">

                    
                    <div class="col-md-12">
                        <div class="card-body">
                            <div class="form-group">
                                <label class="control-label mb-1"><?php echo e(__('Files')); ?>

                                    <?php if($demo_mode=='on'): ?><span class="require"><?php echo e($demo_text); ?></span><?php endif; ?>
                                </label>
                                <form action="<?php echo e(route('fileupload')); ?>" class="dropzone" enctype="multipart/form-data">
                                    <input type="hidden" name="product_token" value="<?php echo e($edit['product']->product_token); ?>">
                                </form>
                            </div>
                        </div>
                    </div>

                    <?php if($demo_mode!='on'): ?>
                    <form action="<?php echo e(route('admin.edit-product')); ?>" method="post" id="category_form" enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>
                    <?php endif; ?>

                    
                    <div class="col-md-6">
                        <div class="card-body">

                            
                            <div class="form-group">
                                <label class="control-label mb-1"><?php echo e(__('Product Type')); ?> <span class="require">*</span></label>
                                <select name="type" id="type" class="form-control" data-bvalidator="required">
                                    <option value="downloadable"   <?php echo e($edit['product']->type=='downloadable'   ? 'selected':''); ?>><?php echo e(__('Downloadable')); ?></option>
                                    <option value="non_downloadable"<?php echo e($edit['product']->type=='non_downloadable'? 'selected':''); ?>><?php echo e(__('Non-downloadable')); ?></option>
                                </select>
                            </div>

                            
                            <div class="form-group">
                                <label class="control-label mb-1"><?php echo e(__('Product Name')); ?> <span class="require">*</span></label>
                                <input name="product_name" type="text" class="form-control" data-bvalidator="required,maxlen[100]" value="<?php echo e($edit['product']->product_name); ?>">
                            </div>

                            
                            <div class="form-group">
                                <label class="control-label mb-1"><?php echo e(__('Product Slug')); ?></label>
                                <input name="product_slug" type="text" class="form-control" value="<?php echo e($edit['product']->product_slug); ?>">
                                <small>(<?php echo e(__("if leave empty, it's automatically get product name to slug")); ?>)</small>
                            </div>

                            
                            <div class="form-group">
                                <label class="control-label mb-1"><?php echo e(__('Short Description')); ?> <span class="require">*</span></label>
                                <textarea name="product_short_desc" rows="4" class="form-control noscroll_textarea" data-bvalidator="required,maxlen[160]"><?php echo e($edit['product']->product_short_desc); ?></textarea>
                            </div>

                            
                            <div class="form-group">
                                <label class="control-label mb-1"><?php echo e(__('Description')); ?> <span class="require">*</span></label>
                                <textarea name="product_desc" id="summary-ckeditor" rows="6" class="form-control" data-bvalidator="required"><?php echo html_entity_decode($edit['product']->product_desc); ?></textarea>
                            </div>

                            
                            <div class="form-group">
                                <label class="control-label mb-1"><?php echo e(__('Category')); ?> <span class="require">*</span></label>
                                <select name="product_category" class="form-control" data-bvalidator="required">
                                    <option value=""><?php echo e(__('Select')); ?></option>
                                    <?php $__currentLoopData = $re_categories['menu']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $menu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="category_<?php echo e($menu->cat_id); ?>"
                                            <?php if($cat_name=='category' && $cat_id==$menu->cat_id): ?> selected <?php endif; ?>>
                                            <?php echo e($menu->category_name); ?>

                                        </option>
                                        <?php $__currentLoopData = $menu->subcategory; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sub): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="subcategory_<?php echo e($sub->subcat_id); ?>"
                                                <?php if($cat_name=='subcategory' && $cat_id==$sub->subcat_id): ?> selected <?php endif; ?>>
                                                - <?php echo e($sub->subcategory_name); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>

                            
                            <?php $__currentLoopData = $attri_field['display']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $attribute_field): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                    $values   = explode(',', $attribute_field->attr_field_value);
                                    $selected = collect(Helper::SelectedButes($product_token, $attribute_field->attr_id)
                                                  ->pluck('product_attribute_values')->toArray())
                                                  ->flatMap(fn($v) => explode(',', $v))
                                                  ->toArray();
                                ?>
                                <div class="form-group">
                                    <label class="control-label mb-1"><?php echo e($attribute_field->attr_label); ?></label>
                                    <?php if($attribute_field->attr_field_type=='multi-select'): ?>
                                        <select name="attributes_<?php echo e($attribute_field->attr_id); ?>[]" class="form-control" multiple>
                                            <?php $__currentLoopData = $values; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($v); ?>" <?php if(in_array($v,$selected)): ?> selected <?php endif; ?>><?php echo e($v); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    <?php elseif($attribute_field->attr_field_type=='single-select'): ?>
                                        <select name="attributes_<?php echo e($attribute_field->attr_id); ?>[]" class="form-control">
                                            <option value=""></option>
                                            <?php $__currentLoopData = $values; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($v); ?>" <?php if(in_array($v,$selected)): ?> selected <?php endif; ?>><?php echo e($v); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    <?php else: ?>
                                        <input type="text" name="attributes_<?php echo e($attribute_field->attr_id); ?>[]" class="form-control">
                                    <?php endif; ?>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                            
                            <div class="form-group">
                                <label class="control-label mb-1">
                                    <?php echo e(__('Regular License Price')); ?> (<?php echo e(__('6 Months Support')); ?>) (<?php echo e($allsettings->site_currency_symbol); ?>) <span class="require">*</span>
                                </label>
                                <input name="regular_price" type="text" class="form-control" data-bvalidator="required,min[1]" value="<?php echo e($edit['product']->regular_price); ?>">
                            </div>
                            <div class="form-group">
                                <label class="control-label mb-1">
                                    <?php echo e(__('Extended License Price')); ?> (<?php echo e(__('12 Months Support')); ?>) (<?php echo e($allsettings->site_currency_symbol); ?>)
                                </label>
                                <input name="extended_price" type="text" class="form-control" data-bvalidator="min[1]" value="<?php echo e($edit['product']->extended_price?:''); ?>">
                            </div>

                        </div>
                    </div>
                    

                    
                    <div class="col-md-6">
                        <div class="card-body">

                            
                            <div class="form-group">
                                <label class="control-label mb-1"><?php echo e(__('Upload Thumbnail Image')); ?> (296×200) <span class="require">*</span></label>
                                <select name="product_image1" class="form-control" <?php if(!$edit['product']->product_image): ?> data-bvalidator="required" <?php endif; ?>>
                                    <option value=""></option>
                                    <?php $__currentLoopData = $getdata1['first']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $g): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($g->product_file_name); ?>"><?php echo e($g->original_file_name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                                <?php if($edit['product']->product_image): ?>
                                    <img src="<?php echo e(url('/')); ?>/public/storage/product/<?php echo e($edit['product']->product_image); ?>" class="item-thumb">
                                <?php else: ?>
                                    <img src="<?php echo e(url('/')); ?>/public/img/no-image.png" class="item-thumb">
                                <?php endif; ?>
                            </div>

                            
                            <div class="form-group">
                                <label class="control-label mb-1"><?php echo e(__('Upload Preview Image')); ?> (762×508) <span class="require">*</span></label>
                                <select name="product_preview1" class="form-control" <?php if(!$edit['product']->product_preview): ?> data-bvalidator="required" <?php endif; ?>>
                                    <option value=""></option>
                                    <?php $__currentLoopData = $getdata4; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $g): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($g->product_file_name); ?>"><?php echo e($g->original_file_name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                                <?php if($edit['product']->product_preview): ?>
                                    <img src="<?php echo e(url('/')); ?>/public/storage/product/<?php echo e($edit['product']->product_preview); ?>" class="item-thumb">
                                <?php else: ?>
                                    <img src="<?php echo e(url('/')); ?>/public/img/no-image.png" class="item-thumb">
                                <?php endif; ?>
                            </div>

                            
                            <div id="downloadable-fields" style="<?php echo e($edit['product']->type=='non_downloadable'?'display:none':''); ?>">
                                
                                <div class="form-group">
                                    <label class="control-label mb-1"><?php echo e(__('Upload Main File Type')); ?></label>
                                    <select name="product_file_type1" id="product_file_type1" class="form-control">
                                        <option value=""></option>
                                        <option value="file" <?php echo e($edit['product']->product_file_type=='file'?'selected':''); ?>><?php echo e(__('File')); ?></option>
                                        <option value="link" <?php echo e($edit['product']->product_file_type=='link'?'selected':''); ?>><?php echo e(__('Link / URL')); ?></option>
                                    </select>
                                </div>

                                
                                <div id="main_file" class="form-group" style="<?php echo e($edit['product']->product_file_type=='file'?'display:block':'display:none'); ?>">
                                    <label class="control-label mb-1"><?php echo e(__('Upload Main File')); ?> (<?php echo e(__('Zip Format Only')); ?>)</label>
                                    <select name="product_file1" class="form-control">
                                        <option value=""></option>
                                        <?php $__currentLoopData = $getdata2['second']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $g): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($g->product_file_name); ?>"><?php echo e($g->original_file_name); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                    <span class="require"><?php echo e($edit['product']->product_file); ?></span>
                                </div>

                                
                                <div id="main_link" class="form-group" style="<?php echo e($edit['product']->product_file_type=='link'?'display:block':'display:none'); ?>">
                                    <label class="control-label mb-1"><?php echo e(__('Main File Link/URL')); ?></label>
                                    <input type="text" name="product_file_link1" class="form-control" value="<?php echo e($edit['product']->product_file_link); ?>">
                                </div>

                                
                                <div class="form-group">
                                    <label class="control-label mb-1"><?php echo e(__('Upload Gallery Images')); ?> (<?php echo e(__('Multiselect')); ?>)</label>
                                    <select name="product_gallery[]" class="form-control" multiple>
                                        <?php $__currentLoopData = $getdata3['third']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $g): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($g->product_file_name); ?>"><?php echo e($g->original_file_name); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                    <div class="gallery-preview">
                                        <?php $__currentLoopData = $product_image['view']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $img): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <div class="item-img">
                                                <img src="<?php echo e(url('/')); ?>/public/storage/product/<?php echo e($img->product_gallery_image); ?>" class="item-thumb">
                                                <a href="<?php echo e(url('/admin/edit-product/dropimg/'.base64_encode($img->prod_gal_id))); ?>"
                                                   onClick="return confirm('Are you sure?');" class="drop-icon">
                                                    <span class="ti-trash"></span>
                                                </a>
                                            </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div>
                                </div>
                            </div>
                            

                            
                            <div class="form-group">
                                <label class="control-label mb-1"><?php echo e(__('Future Update')); ?></label>
                                <select name="future_update" class="form-control">
                                    <option value=""></option>
                                    <option value="1" <?php echo e($edit['product']->future_update==1?'selected':''); ?>>Yes</option>
                                    <option value="0" <?php echo e($edit['product']->future_update==0?'selected':''); ?>>No</option>
                                </select>
                            </div>

                            
                            <div class="form-group">
                                <label class="control-label mb-1"><?php echo e(__('Product Support')); ?> <span class="require">*</span></label>
                                <select name="item_support" class="form-control" data-bvalidator="required">
                                    <option value=""></option>
                                    <option value="1" <?php echo e($edit['product']->item_support==1?'selected':''); ?>>Yes</option>
                                    <option value="0" <?php echo e($edit['product']->item_support==0?'selected':''); ?>>No</option>
                                </select>
                            </div>

                            

                            
                            <input type="hidden" name="image_size" value="<?php echo e($allsettings->site_max_image_size); ?>">
                            <input type="hidden" name="zip_size"   value="<?php echo e($allsettings->site_max_zip_size); ?>">
                            <input type="hidden" name="user_id"    value="1">
                            <input type="hidden" name="save_product_image"   value="<?php echo e($edit['product']->product_image); ?>">
                            <input type="hidden" name="save_product_preview" value="<?php echo e($edit['product']->product_preview); ?>">
                            <input type="hidden" name="save_product_file"    value="<?php echo e($edit['product']->product_file); ?>">
                            <input type="hidden" name="product_token"         value="<?php echo e($edit['product']->product_token); ?>">
                            <input type="hidden" name="save_file_type"        value="<?php echo e($edit['product']->product_file_type); ?>">

                            
                            <div class="col-md-12 no-padding">
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary btn-sm">
                                        <i class="fa fa-dot-circle-o"></i> <?php echo e(__('Submit')); ?>

                                    </button>
                                    <button type="reset" class="btn btn-danger btn-sm">
                                        <i class="fa fa-ban"></i> <?php echo e(__('Reset')); ?>

                                    </button>
                                </div>
                            </div>

                        <?php if($demo_mode!='on'): ?>
                        </form>
                        <?php endif; ?>

                        </div>
                    </div>
                    

                </div>
            </div>
        </div>
    </div>
    <?php else: ?>
        <?php echo $__env->make('admin.denied', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php endif; ?>

    <?php echo $__env->make('admin.javascript', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php echo $__env->make('admin.zone', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <script>
    document.addEventListener('DOMContentLoaded', function(){
        // Toggle downloadable block
        let typeEl = document.getElementById('type'),
            dlEl   = document.getElementById('downloadable-fields');
        function toggleDownloadable(){
            dlEl.style.display = (typeEl.value==='downloadable') ? '' : 'none';
        }
        typeEl.addEventListener('change', toggleDownloadable);
        toggleDownloadable();

        // Toggle main file vs link inputs
        let ftEl = document.getElementById('product_file_type1'),
            mf   = document.getElementById('main_file'),
            ml   = document.getElementById('main_link');
        function toggleFileLink(){
            let v = ftEl.value;
            mf.style.display = (v==='file') ? 'block' : 'none';
            ml.style.display = (v==='link') ? 'block' : 'none';
        }
        ftEl.addEventListener('change', toggleFileLink);
        toggleFileLink();
    });
    </script>

</body>
</html>
<?php /**PATH /home/arixmyii/bittoz.shop/public_html/resources/views/admin/edit-product.blade.php ENDPATH**/ ?>