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
    @if(in_array('manage-products',$avilable))
    <div id="right-panel" class="right-panel">

       
                       @include('admin.header')
                       

        <div class="breadcrumbs">
            <div class="col-sm-4">
                <div class="page-header float-left">
                    <div class="page-title">
                        <h1>{{ $product_details->product_name }} - {{ __('Add Reviews') }}</h1>
                    </div>
                </div>
            </div>
            <div class="col-sm-8">
                <div class="page-header float-right">
                <ol class="breadcrumb text-right">
                    <a href="{{ url('/admin/reviews') }}/{{ $product_details->product_token }}" class="btn btn-primary btn-sm"><i class="fa fa-chevron-left"></i> {{ __('Back') }}</a>
                    </ol>
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
                           <form action="{{ route('admin.add-reviews') }}" method="post" id="setting_form" enctype="multipart/form-data">
                           {{ csrf_field() }}
                           @endif
                           
                           <input type="hidden" name="or_product_id" value="{{ $product_details->product_id }}">
                           <input type="hidden" name="or_product_token" value="{{ $product_details->product_token }}">
                           <input type="hidden" name="or_product_user_id" value="1">
                           <div class="col-md-6">
                           
                            <div class="card-body">
                                <!-- Credit Card -->
                                <div id="pay-invoice">
                                    <div class="card-body">
                                    
                                    <div class="form-group">
                                                <label for="site_title" class="control-label mb-1"><strong>{{ __('Product Name') }} : </strong></label>
                                                {{ $product_details->product_name }}
                                            </div> 
                                           
                                             <div class="form-group">
                                                <label for="site_title" class="control-label mb-1">{{ __('Customers') }} <span class="require">*</span></label>
                                                <input type="text" id="or_username" name="or_username" class="form-control"  data-bvalidator="required" >
                                                
                                            </div> 
                                            
                                            <div class="form-group">
                                                <label for="site_title" class="control-label mb-1">{{ __('Rating Comment') }} <span class="require">*</span></label>
                                                <textarea name="rating_comment" id="rating_comment" class="form-control" rows="6" data-bvalidator="required"></textarea>
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
                                                <label for="site_title" class="control-label mb-1">{{ __('Rating') }} <span class="require">*</span></label>
                                                <select name="rating" class="form-control" data-bvalidator="required">
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                    </select>
                                            </div> 
                                            
                                            
                                            <div class="form-group">
                                                <label for="site_title" class="control-label mb-1">{{ __('Rating Reason') }} <span class="require">*</span></label>
                                                <select name="rating_reason" class="form-control" data-bvalidator="required">
                                            <option value="design">{{ __('Design Quality') }}</option>
                                            <option value="customization">{{ __('Customization') }}</option>
                                            <option value="support">{{ __('Support') }}</option>
                                            <option value="performance">{{ __('Performance') }}</option>
                                            <option value="documentation">{{ __('Well Documented') }}</option>
                                        </select>
                                            </div>  
                                            
                                           
                                    
                             
                             </div>
                                </div>

                            </div>
                             
                             
                             
                             </div>
                             
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
