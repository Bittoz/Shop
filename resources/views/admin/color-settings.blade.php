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
                        <h1>{{ __('Color Settings') }}</h1>
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
                           <form action="{{ route('admin.color-settings') }}" method="post" id="setting_form" enctype="multipart/form-data">
                           {{ csrf_field() }}
                           @endif
                           <div class="col-md-6">
                           
                            <div class="card-body">
                                <!-- Credit Card -->
                                <div id="pay-invoice">
                                    <div class="card-body">
                                       
                                        
                                            
                                            <div class="form-group">
                                                <label for="site_title" class="control-label mb-1">{{ __('Site Theme Color') }} <span class="require">*</span></label>
                                                <input id="site_theme_color" name="site_theme_color" type="text" class="form-control noscroll_textarea" value="{{ $setting['setting']->site_theme_color }}" data-bvalidator="required"> <small>(example color code : #666000 )</small>
                                            </div>
                                            
                                           
                                            
                                            <div class="form-group">
                                                <label for="site_title" class="control-label mb-1">{{ __('Site Button Color') }} <span class="require">*</span></label>
                                                <input id="site_button_color" name="site_button_color" type="text" class="form-control noscroll_textarea" value="{{ $setting['setting']->site_button_color }}" data-bvalidator="required"> <small>(example color code : #666000 )</small>
                                            </div>
                                             
                                            
                                             <div class="form-group">
                                                <label for="site_title" class="control-label mb-1">{{ __('Header Top Bar BgColor') }} <span class="require">*</span></label>
                                                <input id="site_header_color" name="site_header_color" type="text" class="form-control noscroll_textarea" value="{{ $setting['setting']->site_header_color }}" data-bvalidator="required"> <small>(example color code : #666000 )</small>
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
                                                <label for="site_title" class="control-label mb-1">{{ __('Site Button Hover Color') }} <span class="require">*</span></label>
                                                <input id="site_button_hover" name="site_button_hover" type="text" class="form-control noscroll_textarea" value="{{ $setting['setting']->site_button_hover }}" data-bvalidator="required"> <small>(example color code : #666000 )</small>
                                            </div>
                                            
                                            
                                            
                                            
                                             <div class="form-group">
                                                <label for="site_title" class="control-label mb-1">{{ __('Footer BgColor') }} <span class="require">*</span></label>
                                                <input id="site_footer_color" name="site_footer_color" type="text" class="form-control noscroll_textarea" value="{{ $setting['setting']->site_footer_color }}" data-bvalidator="required"> <small>(example color code : #666000 )</small>
                                            </div>
                                             
                                                 
                                                
                                                <input type="hidden" name="sid" value="1">
                             
                             
                             </div>
                                </div>

                            </div>
                             
                             
                             
                             </div>
                             
                             
                             
                             
                             
                             
                             <div class="col-md-12 no-padding">
                             <div class="card-footer">
                                                        <button type="submit" name="submit" class="btn btn-primary btn-sm">
                                                            <i class="fa fa-dot-circle-o"></i> {{ __('Submit') }}
                                                        </button>
                                                        <button type="reset" class="btn btn-danger btn-sm">
                                                            <i class="fa fa-ban"></i> {{ __('Reset') }}
                                                        </button>
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
