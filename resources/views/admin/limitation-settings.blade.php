<!doctype html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js" lang="en">
<!--<![endif]-->

<head>
    
    @include('admin.stylesheet')
</head>

<body>
    
    @include('admin.navigation')

    <!-- Right Panel -->
    @if(in_array('settings',$avilable))
    <div id="right-panel" class="right-panel">

       
                       @include('admin.header')
                       

        <div class="breadcrumbs">
            <div class="col-sm-4">
                <div class="page-header float-left">
                    <div class="page-title">
                        <h1>{{ __('Limitation Settings') }}</h1>
                    </div>
                </div>
            </div>
            <div class="col-sm-8">
                <div class="page-header float-right">
                    
                </div>
            </div>
        </div>
        
        @include('admin.warning')

        <div class="content mt-3">
            <div class="animated fadeIn">
                <div class="row">

                    <div class="col-md-12">
                       
                        
                        
                      
                        <div class="card">
                           @if($demo_mode == 'on')
                           @include('admin.demo-mode')
                           @else
                           <form action="{{ route('admin.limitation-settings') }}" method="post" id="setting_form" enctype="multipart/form-data">
                           {{ csrf_field() }}
                           @endif
                          
                           <div class="col-md-6">
                           
                            <div class="card-body">
                                <!-- Credit Card -->
                                <div id="pay-invoice">
                                    <div class="card-body">
                                           
                                              
                                            
                                            <div class="form-group">
                                                <label for="product_per_page" class="control-label mb-1">{{ __('Product per page') }}<span class="require">*</span></label>
                                                <input id="product_per_page" name="product_per_page" type="text" class="form-control noscroll_textarea" value="{{ $setting['setting']->product_per_page }}" data-bvalidator="required,min[1]">
                                            </div> 
                                            
                                            <div class="form-group">
                                                <label for="comment_per_page" class="control-label mb-1">{{ __('Comment per page') }}<span class="require">*</span></label>
                                                <input id="comment_per_page" name="comment_per_page" type="text" class="form-control noscroll_textarea" value="{{ $setting['setting']->comment_per_page }}" data-bvalidator="required,min[1]">
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
                                                <label for="post_per_page" class="control-label mb-1">{{ __('Post per page') }}<span class="require">*</span></label>
                                                <input id="post_per_page" name="post_per_page" type="text" class="form-control noscroll_textarea" value="{{ $setting['setting']->post_per_page }}" data-bvalidator="required,min[1]">
                                            </div> 
                                            
                                             <div class="form-group">
                                                <label for="review_per_page" class="control-label mb-1">{{ __('Review per page') }}<span class="require">*</span></label>
                                                <input id="review_per_page" name="review_per_page" type="text" class="form-control noscroll_textarea" value="{{ $setting['setting']->review_per_page }}" data-bvalidator="required,min[1]">
                                            </div> 
                                            
                                           <input type="hidden" name="sid" value="1">
                             
                             
                             </div>
                                </div>

                            </div>
                             
                             
                             
                             </div>
                             
                             <div class="col-md-12"><div class="card-body"><h4>{{ __('Main Menu Category Limitation') }}</h4></div></div>
                             
                             <div class="col-md-6">
                           
                            <div class="card-body">
                                <!-- Credit Card -->
                                <div id="pay-invoice">
                                    <div class="card-body">
                                       
                                        
                                            
                                            <div class="form-group">
                                                <label for="site_title" class="control-label mb-1">{{ __('How many categories display on main menu') }}? <span class="require">*</span></label><br/>
                                               <input id="menu_display_categories" name="menu_display_categories" type="text" class="form-control noscroll_textarea" value="{{ $setting['setting']->menu_display_categories }}" data-bvalidator="required">
                                                
                                                
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
                                                <label for="site_loader_display" class="control-label mb-1">{{ __('Category display on order') }}?<span class="require">*</span></label><br/>
                                               
                                                <select name="menu_categories_order" class="form-control" data-bvalidator="required">
                                                <option value=""></option>
                                                <option value="asc" @if($setting['setting']->menu_categories_order == 'asc') selected @endif>ASC</option>
                                                <option value="desc" @if($setting['setting']->menu_categories_order == 'desc') selected @endif>DESC</option>
                                                </select>
                                                
                                             </div>
                                             <small>ASC - ascending order | DESC - descending order</small>
                                             
                                             
                                             
                                    </div>
                                </div>

                            </div>
                            </div>
                            
                            
                            <div class="col-md-12"><div class="card-body"><h4>{{ __('Footer Menu Category Limitation') }}</h4></div></div>
                            
                            <div class="col-md-6">
                           
                            <div class="card-body">
                                <!-- Credit Card -->
                                <div id="pay-invoice">
                                    <div class="card-body">
                                       
                                        
                                            
                                            <div class="form-group">
                                                <label for="site_title" class="control-label mb-1">{{ __('How many categories display on footer menu') }}? <span class="require">*</span></label><br/>
                                               <input id="footer_menu_display_categories" name="footer_menu_display_categories" type="text" class="form-control noscroll_textarea" value="{{ $setting['setting']->footer_menu_display_categories }}" data-bvalidator="required">
                                                
                                                
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
                                                <label for="site_loader_display" class="control-label mb-1">{{ __('Category display on order') }}?<span class="require">*</span></label><br/>
                                               
                                                <select name="footer_menu_categories_order" class="form-control" data-bvalidator="required">
                                                <option value=""></option>
                                                <option value="asc" @if($setting['setting']->footer_menu_categories_order == 'asc') selected @endif>ASC</option>
                                                <option value="desc" @if($setting['setting']->footer_menu_categories_order == 'desc') selected @endif>DESC</option>
                                                </select>
                                                
                                             </div>
                                             <small>ASC - ascending order | DESC - descending order</small>
                                             
                                             
                                             
                                    </div>
                                </div>

                            </div>
                            </div>
                             
                             
                             <div class="col-md-12"><div class="card-body"><h4>{{ __('Home Page Item Limitation') }}</h4></div></div>
                             
                             
                             <div class="col-md-6">
                           
                            <div class="card-body">
                                <!-- Credit Card -->
                                <div id="pay-invoice">
                                    <div class="card-body">
                                            
                                            <div class="form-group">
                                                <label for="site_title" class="control-label mb-1">{{ __('How many categories icon display') }} <span class="require">*</span></label><br/>
                                               <input id="home_categories_icon" name="home_categories_icon" type="text" class="form-control noscroll_textarea" value="{{ $setting['setting']->home_categories_icon }}" data-bvalidator="required">
                                                
                                                
                                             </div>
                                        
                                            
                                            <div class="form-group">
                                                <label for="site_title" class="control-label mb-1">{{ __('How many featured items display') }} <span class="require">*</span></label><br/>
                                               <input id="home_featured_items" name="home_featured_items" type="text" class="form-control noscroll_textarea" value="{{ $setting['setting']->home_featured_items }}" data-bvalidator="required">
                                                
                                                
                                             </div>
                                             
                                             <div class="form-group">
                                                <label for="site_title" class="control-label mb-1">{{ __('How many subscriber downloads items display') }} <span class="require">*</span></label><br/>
                                               <input id="home_subscriber_items" name="home_subscriber_items" type="text" class="form-control noscroll_textarea" value="{{ $setting['setting']->home_subscriber_items }}" data-bvalidator="required">
                                                
                                                
                                             </div>
                                             
                                             
                                             <div class="form-group">
                                                <label for="site_title" class="control-label mb-1">{{ __('How many flash items display') }} <span class="require">*</span></label><br/>
                                               <input id="home_flash_items" name="home_flash_items" type="text" class="form-control noscroll_textarea" value="{{ $setting['setting']->home_flash_items }}" data-bvalidator="required">
                                                
                                                
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
                                                <label for="site_title" class="control-label mb-1">{{ __('How many blog post display') }} <span class="require">*</span></label><br/>
                                               <input id="home_blog_post" name="home_blog_post" type="text" class="form-control noscroll_textarea" value="{{ $setting['setting']->home_blog_post }}" data-bvalidator="required">
                                                
                                                
                                             </div>
                                            
                                             <div class="form-group">
                                                <label for="site_title" class="control-label mb-1">{{ __('How many popular items display') }} <span class="require">*</span></label><br/>
                                               <input id="home_popular_items" name="home_popular_items" type="text" class="form-control noscroll_textarea" value="{{ $setting['setting']->home_popular_items }}" data-bvalidator="required">
                                                
                                                
                                             </div>
                                            
                                          <div class="form-group">
                                                <label for="site_title" class="control-label mb-1">{{ __('How many new items display') }} <span class="require">*</span></label><br/>
                                               <input id="home_new_items" name="home_new_items" type="text" class="form-control noscroll_textarea" value="{{ $setting['setting']->home_new_items }}" data-bvalidator="required">
                                                
                                                
                                             </div>
                                             
                                             
                                             
                                              <div class="form-group">
                                                <label for="site_title" class="control-label mb-1">{{ __('How many free items display') }} <span class="require">*</span></label><br/>
                                               <input id="home_free_items" name="home_free_items" type="text" class="form-control noscroll_textarea" value="{{ $setting['setting']->home_free_items }}" data-bvalidator="required">
                                                
                                                
                                             </div>
                                                
                                        
                                    </div>
                                </div>

                            </div>
                            </div>
                             
                              <div class="col-md-12"><div class="card-body"><h4>{{ __('Shop Page') }}</h4></div></div>
                              
                              
                              <div class="col-md-6">
                           
                            <div class="card-body">
                                <!-- Credit Card -->
                                <div id="pay-invoice">
                                    <div class="card-body">
                                       
                                        
                                            
                                             <div class="form-group">
                                                <label for="site_title" class="control-label mb-1">{{ __('Price range min price') }} <span class="require">*</span></label><br/>
                                               <input id="site_range_min_price" name="site_range_min_price" type="text" class="form-control noscroll_textarea" value="{{ $setting['setting']->site_range_min_price }}" data-bvalidator="required">
                                                
                                                
                                             </div>
                                             <div class="form-group">
                                                <label for="site_loader_display" class="control-label mb-1">{{ __('Search Type') }}? <span class="require">*</span></label><br/>
                                               
                                                <select name="shop_search_type" class="form-control" data-bvalidator="required">
                                                <option value=""></option>
                                                <option value="normal" @if($custom_settings->shop_search_type == 'normal') selected @endif>{{ __('Normal') }}</option>
                                                <option value="ajax" @if($custom_settings->shop_search_type == 'ajax') selected @endif>{{ __('Ajax') }}</option>
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
                                                <label for="site_title" class="control-label mb-1">{{ __('Price range max price') }} <span class="require">*</span></label><br/>
                                               <input id="site_range_max_price" name="site_range_max_price" type="text" class="form-control noscroll_textarea" value="{{ $setting['setting']->site_range_max_price }}" data-bvalidator="required">
                                                
                                                
                                             </div>
                                            
                                          
                                                
                                        
                                    </div>
                                </div>

                            </div>
                            </div>
                              
                              <div class="col-md-12"><div class="card-body"><h4>{{ __('Footer Widget') }}</h4></div></div>
                              
                              
                              <div class="col-md-6">
                           
                            <div class="card-body">
                                <!-- Credit Card -->
                                <div id="pay-invoice">
                                    <div class="card-body">
                                       
                                       
                                             <div class="form-group">
                                                <label for="site_loader_display" class="control-label mb-1">{{ __('Item Sold Display') }}? <span class="require">*</span></label><br/>
                                               
                                                <select name="item_sold_display" class="form-control" data-bvalidator="required">
                                                <option value=""></option>
                                                <option value="1" @if($custom_settings->item_sold_display == 1) selected @endif>{{ __('ON') }}</option>
                                                <option value="0" @if($custom_settings->item_sold_display == 0) selected @endif>{{ __('OFF') }}</option>
                                                </select>
                                                
                                             </div>
                                        
                                            
                                             <div class="form-group">
                                                <label for="site_title" class="control-label mb-1">{{ __('Item Sold Count') }} </label><br/>
                                               <input id="item_sold_count" name="item_sold_count" type="text" class="form-control noscroll_textarea" value="{{ $setting['setting']->item_sold_count }}">
                                                
                                                <small>(if leave "blank" automatic count will be showing)</small>
                                             </div>
                                            
                                            <div class="form-group">
                                                <label for="site_title" class="control-label mb-1">{{ __('App Store URL') }}</label>
                                                <input id="app_store_url" name="app_store_url" type="text" class="form-control noscroll_textarea" data-bvalidator="url" value="{{ $custom_settings->app_store_url }}">
                                            </div> 
                                                
                                            <div class="form-group">
                                                <label for="site_logo" class="control-label mb-1">{{ __('Available Payment Methods') }}</label>
                                                
                                            <input type="file" id="available_payment_methods" name="available_payment_methods" class="form-control-file"  data-bvalidator="extension[jpg:png:jpeg:svg]" data-bvalidator-msg="Please select file of type .jpg, .png, .jpeg or .svg"><br/>
                                            @if($custom_settings->available_payment_methods != '')
                                            <img height="30" src="{{ url('/') }}/public/storage/settings/{{ $custom_settings->available_payment_methods }}" />
                                            @endif
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
                                                <label for="site_loader_display" class="control-label mb-1">{{ __('Members Count Display') }}? <span class="require">*</span></label><br/>
                                               
                                                <select name="members_count_display" class="form-control" data-bvalidator="required">
                                                <option value=""></option>
                                                <option value="1" @if($custom_settings->members_count_display == 1) selected @endif>{{ __('ON') }}</option>
                                                <option value="0" @if($custom_settings->members_count_display == 0) selected @endif>{{ __('OFF') }}</option>
                                                </select>
                                                
                                             </div>
                                            
                                             <div class="form-group">
                                                <label for="site_title" class="control-label mb-1">{{ __('Members Count') }} </label><br/>
                                               <input id="members_count" name="members_count" type="text" class="form-control noscroll_textarea" value="{{ $setting['setting']->members_count }}">
                                                <small>(if leave "blank" automatic count will be showing)</small>
                                                
                                             </div>
                                            
                                          <div class="form-group">
                                                <label for="site_title" class="control-label mb-1">{{ __('Google Play URL') }}</label>
                                                <input id="google_play_url" name="google_play_url" type="text" class="form-control noscroll_textarea" data-bvalidator="url" value="{{ $custom_settings->google_play_url }}">
                                            </div> 
                                                
                                        
                                    </div>
                                </div>

                            </div>
                            </div>
                              
                             <input type="hidden" name="save_payment_methods" value="{{ $custom_settings->available_payment_methods }}">
                             <div class="col-md-12 no-padding">
                             <div class="card-footer">
                                 <button type="submit" name="submit" class="btn btn-primary btn-sm"><i class="fa fa-dot-circle-o"></i> {{ __('Submit') }}</button>
                                 <button type="reset" class="btn btn-danger btn-sm"><i class="fa fa-ban"></i> {{ __('Reset') }} </button>
                             </div>
                             
                             </div>
                             
                            
                            </form>
                            
                                                    
                                                    
                                                 
                            
                        </div> 

                     
                    
                    
                    </div>
                    

                </div>
            </div><!-- .animated -->
        </div><!-- .content -->


    </div><!-- /#right-panel -->
    @else
    @include('admin.denied')
    @endif
    <!-- Right Panel -->


   @include('admin.javascript')


</body>

</html>
