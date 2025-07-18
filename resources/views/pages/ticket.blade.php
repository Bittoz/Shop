<!DOCTYPE HTML>
<html lang="en">
<head>
<title>{{ __('View Ticket') }} - {{ $allsettings->site_title }}</title>
@include('meta')
@include('style')
</head>
<body>
@include('header')
<div class="page-title-overlap pt-4" style="background-image: url('{{ url('/') }}/public/storage/settings/{{ $allsettings->site_other_banner }}');">
      <div class="container d-lg-flex justify-content-between py-2 py-lg-3">
        <div class="order-lg-2 mb-3 mb-lg-0 pt-lg-2">
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-light flex-lg-nowrap justify-content-center justify-content-lg-star">
              <li class="breadcrumb-item"><a class="text-nowrap" href="{{ URL::to('/') }}"><i class="dwg-home"></i>{{ __('Home') }}</a></li>
              <li class="breadcrumb-item text-nowrap active" aria-current="page">{{ __('View Ticket') }}</li>
            </ol>
          </nav>
        </div>
        <div class="order-lg-1 pr-lg-4 text-center text-lg-left">
          <h1 class="h3 mb-0 text-white">{{ __('View Ticket') }}</h1>
        </div>
      </div>
    </div>
<div class="container mb-5 pb-3">
      <div class="bg-light box-shadow-lg rounded-lg overflow-hidden">
        <div class="row">
          <!-- Sidebar-->
          <aside class="col-lg-4">
             @include('dashboard-menu')
          </aside>
          <!-- Content-->
          <section class="col-lg-8 pt-lg-4 pb-4 mb-3">
          <!-- Toolbar-->
          <div class="pt-2 px-4 pl-lg-0 pr-xl-5">
          <h2 class="h3 pt-2 pb-4 mb-0 text-center text-sm-left border-bottom">{{ __('Ticket') }}#{{ $ticket }} <span @if($single_ticket->ticket_status == 'open') class="badge badge-success font-size-md badge-position" @elseif($single_ticket->ticket_status == 'close') class="badge badge-secondary font-size-md badge-position" @else class="badge badge-warning font-size-md badge-position" @endif>{{ $single_ticket->ticket_status }}</span></h2>
          
          <div class="row">
                 <div class="col-lg-12 col-md-12 text-right mb-3 mt-3">
                 <a href="{{ URL::to('/my-tickets') }}" class="btn btn-success btn-sm"><i class="fa fa-ticket font-size-xs mr-1 ml-n1"></i> {{ __('My Tickets') }}</a>
                 @if($single_ticket->ticket_status != 'close')
                 <a class="btn btn-danger btn-sm" href="{{ URL::to('/close-ticket') }}/{{ $single_ticket->ticket_token }}" onClick="return confirm('{{ __('Are you sure to close this ticket') }}?');"><i class="dwg-close-circle font-size-xs mr-1 ml-n1"></i> {{ __('Close Ticket') }}</a>
                 @endif
                 </div> 
                 </div>
                 <form action="{{ route('ticket') }}" class="needs-validation" id="profile_form" method="post" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="row">
              
              
              <div class="col-sm-12">
                <div class="form-group">
                  <label for="account-email">{{ __('Message') }} <span class="required">*</span></label>
                  <textarea id="tickets_message" name="tickets_message" rows="5" class="form-control" data-bvalidator="required"></textarea>
                </div>
              </div>
              
              
              <div class="col-sm-12">
              <div class="form-group pb-2">
                  <label for="account-confirm-pass">{{ __('Upload') }}</label>
                  <div class="custom-file">
                    <input class="custom-file-input" type="file" id="unp-product-files" name="tickets_file" data-bvalidator="extension[jpg:png:jpeg:pdf]" data-bvalidator-msg="{{ __('Please select file of type .jpg, .png, .jpeg or .pdf') }}">
                    <label class="custom-file-label" for="unp-product-files"></label>
                    <small>({{ __('Upload only') }} : Jpg, png, pdf)</small>
                  </div>
                </div>
              </div> 
              <input type="hidden" name="tickets_user_token" value="{{ Auth::user()->user_token }}">
              <input type="hidden" name="tickets_token" value="{{ $single_ticket->ticket_token }}">
              <input type="hidden" name="image_size" value="{{ $allsettings->site_max_image_size }}"> 
              <div class="col-12">
                <div class="d-flex flex-wrap justify-content-between align-items-center">
                  <button class="btn btn-primary mt-3 mt-sm-0" type="submit">{{ __('Reply') }}</button>
                  
                </div>
              </div>
            </div>
          </form>
          
          <div class="mt-3">
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
             <span class="font-size-ms text-muted"><i class="dwg-time align-middle mr-2"></i>{{ Helper::timeAgo(strtotime($ticket->tickets_date_time)) }}</span> <br/>
             @if(!empty($ticket->tickets_file))
             <a href="{{ URL::to('/download-ticket-file') }}/{{ $ticket->tickets_token }}/{{ $encrypter->encrypt($ticket->tickets_file) }}" class="font-size-xs red-color"><i class="dwg-download mr-1 ml-n1"></i> {{ __('Download File') }}</a>
             @endif
             </div> 
          </div>
          @endforeach
          </div>
          
          <div class="mt-3">
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
             <span class="font-size-ms text-muted"><i class="dwg-time align-middle mr-2"></i>{{ Helper::timeAgo(strtotime($single_ticket->ticket_date_time)) }}</span> <br/>
             @if(!empty($single_ticket->ticket_file))
             <a href="{{ URL::to('/download-ticket-file') }}/{{ $single_ticket->ticket_token }}/{{ $encrypter->encrypt($single_ticket->ticket_file) }}" class="font-size-xs red-color"><i class="dwg-download mr-1 ml-n1"></i> {{ __('Download File') }}</a>
             @endif
             </div> 
          </div>
          </div>
          
          </div>
          <!-- Profile form-->
        </section>
          
        </div>
      </div>
    </div>
@include('footer')
@include('script')
</body>
</html>