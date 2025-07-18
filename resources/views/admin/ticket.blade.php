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
    @if(in_array('tickets',$avilable))
    <div id="right-panel" class="right-panel">

       
                       @include('admin.header')
                       

        <div class="breadcrumbs">
            <div class="col-sm-4">
                <div class="page-header float-left">
                    <div class="page-title">
                        <h1>{{ __('View Ticket') }}</h1>
                    </div>
                </div>
            </div>
            <div class="col-sm-8">
                <div class="page-header float-right">
                   <div class="page-title">
                        <ol class="breadcrumb text-right">
                        <a href="{{ URL::to('/admin/tickets') }}" class="btn btn-success btn-sm"><i class="fa fa-ticket"></i> {{ __('All Tickets') }}</a>&nbsp;
                    @if($single_ticket->ticket_status != 'close')
                 <a class="btn btn-danger btn-sm" href="{{ URL::to('/admin/close-ticket') }}/{{ $single_ticket->ticket_token }}" onClick="return confirm('{{ __('Are you sure to close this ticket') }}?');"><i class="dwg-close-circle font-size-xs mr-1 ml-n1"></i> {{ __('Close Ticket') }}</a>
                 @endif
                        </ol>
                    </div>
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
                           <form action="{{ route('admin.ticket') }}" method="post" id="setting_form" enctype="multipart/form-data">
                           {{ csrf_field() }}
                           @endif
                          <div class="col-md-12 mt-3"><h5>{{ __('Ticket') }}#{{ $ticket }} <span @if($single_ticket->ticket_status == 'open') class="badge badge-success font-size-md badge-position" @elseif($single_ticket->ticket_status == 'close') class="badge badge-secondary font-size-md badge-position" @else class="badge badge-warning font-size-md badge-position" @endif>{{ $single_ticket->ticket_status }}</span></h5></div>
                           <div class="col-md-6">
                           
                            <div class="card-body">
                                <!-- Credit Card -->
                                <div id="pay-invoice">
                                    <div class="card-body">
                                           
                                           <div class="form-group">
                                                <label for="site_desc" class="control-label mb-1">{{ __('Message') }} <span class="require">*</span></label>
                                                
                                            <textarea name="tickets_message" id="tickets_message" rows="6" class="form-control noscroll_textarea" data-bvalidator="required"></textarea>
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
                                                <label for="site_desc" class="control-label mb-1">{{ __('Upload') }}</label>
                                                
                                            <input class="form-control-file" type="file" id="unp-product-files" name="tickets_file" data-bvalidator="extension[jpg:png:jpeg:pdf]" data-bvalidator-msg="{{ __('Please select file of type .jpg, .png, .jpeg or .pdf') }}"><small>({{ __('Upload only') }} : Jpg, png, pdf)</small>
                                            </div>
                                            
                                           
                             
                             
                             </div>
                                </div>

                            </div>
                             
                             
                             
                             </div>
                           
                             
                            
                             
                             
                            <input type="hidden" name="tickets_user_token" value="{{ Auth::user()->user_token }}">
                            <input type="hidden" name="tickets_token" value="{{ $single_ticket->ticket_token }}">
                              <input type="hidden" name="image_size" value="{{ $allsettings->site_max_image_size }}"> 
                             <div class="col-md-12 no-padding">
                             <div class="card-footer">
                                 <button type="submit" name="submit" class="btn btn-primary btn-sm"><i class="fa fa-dot-circle-o"></i> {{ __('Reply') }}</button>
                                 
                             </div>
                             
                             </div>
                             
                            
                            </form>
                            
                                                    
                                                    
                                                 
                            
                        </div> 

                     
                    
                    
                    </div>
                    
                  <div class="col-md-12">
                  
                     <div class="mt-3  ticket_background">
                      @foreach($reply_ticket as $ticket)
                      <div class="media py-4 border-bottom"> 
                      @if(Helper::User_Photo($ticket->tickets_user_token)!='')
                      <img class="rounded-circle" width="50" src="{{ url('/') }}/public/storage/users/{{ Helper::User_Photo($ticket->tickets_user_token) }}" alt=""/>
                      @else
                      <img class="rounded-circle" width="50" src="{{ url('/') }}/public/img/no-user.png" alt=""/>
                      @endif
                      <div class="media-body pl-3"> 
                         <div class="d-flex justify-content-between align-items-center mb-2"> 
                            <h6 class="font-size-md mb-0">{{  Helper::User_Name($ticket->tickets_user_token) }}</h6> 
                         </div> <p class="font-size-md mb-1">{{ $ticket->tickets_message }}</p>
                         <span class="font-size-ms text-muted"><i class="fa fa-clock-o align-middle mr-2"></i>{{ Helper::timeAgo(strtotime($ticket->tickets_date_time)) }}</span> <br/>
                         @if(!empty($ticket->tickets_file))
                         <a href="{{ URL::to('/download-ticket-file') }}/{{ $ticket->tickets_token }}/{{ $encrypter->encrypt($ticket->tickets_file) }}" class="font-size-xs red-color"><i class="fa fa-download mr-1 ml-n1"></i> {{ __('Download File') }}</a>
                         @endif
                         </div> 
                      </div>
                      @endforeach
                      </div>
                  
                      <div class="mt-0  ticket_background">
                          <div class="media py-4 border-bottom">
                          @if(Helper::User_Photo($single_ticket->ticket_user_token)!='')
                          <img class="rounded-circle" width="50" src="{{ url('/') }}/public/storage/users/{{ Helper::User_Photo($single_ticket->ticket_user_token) }}" alt=""/>
                          @else
                          <img class="rounded-circle" width="50" src="{{ url('/') }}/public/img/no-user.png" alt=""/>
                          @endif 
                          <div class="media-body pl-3"> 
                             <div class="d-flex justify-content-between align-items-center mb-2"> 
                                <h6 class="font-size-md mb-0">{{  Helper::User_Name($single_ticket->ticket_user_token) }}</h6> 
                             </div> <p class="font-size-md mb-1">{{ $single_ticket->ticket_message }}</p>
                             <span class="font-size-ms text-muted"><i class="fa fa-clock-o align-middle mr-2"></i>{{ Helper::timeAgo(strtotime($single_ticket->ticket_date_time)) }}</span> <br/>
                             @if(!empty($single_ticket->ticket_file))
                             <a href="{{ URL::to('/download-ticket-file') }}/{{ $single_ticket->ticket_token }}/{{ $encrypter->encrypt($single_ticket->ticket_file) }}" class="font-size-xs red-color"><i class="fa fa-download mr-1 ml-n1"></i> {{ __('Download File') }}</a>
                             @endif
                             </div> 
                          </div>
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
