<!DOCTYPE HTML>
<html lang="en">
<head>
<title>{{ __('Support Tickets') }} - {{ $allsettings->site_title }}</title>
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
              <li class="breadcrumb-item text-nowrap active" aria-current="page">{{ __('Support Tickets') }}</li>
            </ol>
          </nav>
        </div>
        <div class="order-lg-1 pr-lg-4 text-center text-lg-left">
          <h1 class="h3 mb-0 text-white">{{ __('Support Tickets') }}</h1>
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
          <h2 class="h3 pt-2 pb-4 mb-0 text-center text-sm-left border-bottom">{{ __('Support Tickets') }}</h2>
          <div class="row">
                 <div class="col-lg-12 col-md-12 text-right mb-3 mt-3">
                 <a href="{{ URL::to('/new-ticket') }}" class="btn btn-success btn-sm">{{ __('Open New Ticket') }}</a>
                 </div>
                 </div>
          <div class="table-responsive">
                <table class="table table-fixed font-size-sm mb-0">
                  <thead>
                    <tr>
                      <th>{{ __('Ticket Id') }}</th>
                      <th>{{ __('Subject') }}</th>
                      <th>{{ __('Status') }}</th>
                      <th>{{ __('Priority') }}</th>
                      <th>{{ __('Action') }}</th>
                    </tr>
                  </thead>
                  <tbody>
                   @foreach($tickets as $ticket)
                                        <tr>
                                            <td>#{{ $ticket->ticket_token }}</td>
                                            <td>{{ $ticket->ticket_subject }}</td>
                                            <td><span @if($ticket->ticket_status == 'open') class="badge badge-success" @elseif($ticket->ticket_status == 'close') class="badge badge-secondary" @else class="badge badge-info" @endif>{{ $ticket->ticket_status }}</span></td>
                                            <td><span @if($ticket->ticket_priority == 'High') class="badge badge-danger" @elseif($ticket->ticket_priority == 'Medium') class="badge badge-warning" @else class="badge badge-primary" @endif>{{ $ticket->ticket_priority }}</span></td>
                                            <td><a href="{{ URL::to('/ticket') }}/{{ $ticket->ticket_token }}" class="btn btn-success btn-sm">{{ __('Details') }}</a>
                                            <br/><span class="font-size-xs">{{ Helper::timeAgo(strtotime($ticket->ticket_date_time)) }}</span>
                                            </td>
                                        </tr>
                                        
                     @endforeach
                  </tbody>
                </table>
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