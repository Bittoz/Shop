<div class="cz-sidebar-static rounded-lg box-shadow-lg px-0 pb-0 mb-5 mb-lg-0">
            <div class="px-4 mb-4">
              <div class="media align-items-center">
                <div class="img-thumbnail rounded-circle position-relative" style="width: 6.375rem;">
                @if(!empty(Auth::user()->user_photo))
                <img class="rounded-circle" src="{{ url('/') }}/public/storage/users/{{ Auth::user()->user_photo }}" alt="{{ Auth::user()->name }}">
                @else
                <img class="rounded-circle" src="{{ url('/') }}/public/img/no-user.png" alt="{{ Auth::user()->name }}">
                @endif
                </div>
                <div class="media-body pl-3">
                  <h3 class="font-size-base mb-0">{{ Auth::user()->name }}</h3><span class="text-accent font-size-sm">{{ Auth::user()->email }}</span>
                  @if($allsettings->subscription_mode == 1)
                  @if(Auth::user()->user_subscr_type != '')<span class="badge badge-info">{{ Auth::user()->user_subscr_type }} {{ __('Membership') }}</span><br/>
                  @if(Helper::lifeTime(Auth::user()->id) == 0)
                  <span class="expire_on"><i class="dwg-time"></i> {{ __('Expire On') }} {{ date('d M Y',strtotime(Auth::user()->user_subscr_date)) }}</span>
                  @endif
                  @endif
                  @endif
                </div>
              </div>
            </div>
            <div class="bg-secondary px-4 py-3">
              <h3 class="font-size-sm mb-0 text-muted">{{ __('Account') }}</h3>
            </div>
            <ul class="list-unstyled mb-0">
                  <li class="border-bottom mb-0"><a class="nav-link-style d-flex align-items-center px-4 py-3" href="{{ url('/my-profile') }}"><i class="dwg-settings opacity-60 mr-2"></i>{{ __('My Profile') }}</a></li>
                  <li class="border-bottom mb-0"><a class="nav-link-style d-flex align-items-center px-4 py-3" href="{{ url('/my-purchases') }}"><i class="dwg-basket opacity-60 mr-2"></i>{{ __('My Purchases') }}</a></li>
                  <li class="border-bottom mb-0"><a class="nav-link-style d-flex align-items-center px-4 py-3" href="{{ url('/my-favourite') }}"><i class="dwg-heart opacity-60 mr-2"></i>{{ __('My Favourite') }}</a></li>
                  <li class="border-bottom mb-0"><a class="nav-link-style d-flex align-items-center px-4 py-3" href="{{ URL::to('/redeem-voucher') }}"><i class="dwg-gift opacity-60 mr-2"></i>{{ __('Redeem Voucher') }}</a></li>
                  <li class="border-bottom mb-0"><a class="nav-link-style d-flex align-items-center px-4 py-3" href="{{ url('/my-referral') }}"><i class="dwg-share opacity-60 mr-2"></i>{{ __('My Referral') }}</a></li>
                  <li class="border-bottom mb-0"><a class="nav-link-style d-flex align-items-center px-4 py-3" href="{{ URL::to('/my-tickets') }}"><i class="fa fa-ticket opacity-60 mr-2"></i>{{ __('Support Tickets') }}</a></li>
                  @if($allsettings->site_withdrawal_display == 1)
                  <li class="border-bottom mb-0"><a class="nav-link-style d-flex align-items-center px-4 py-3" href="{{ url('/withdrawal') }}"><i class="dwg-currency-exchange opacity-60 mr-2"></i>{{ __('Withdrawal') }}</a></li>
                  @endif
                  <li class="mb-0"><a class="nav-link-style d-flex align-items-center px-4 py-3" href="{{ url('/logout') }}"><i class="dwg-sign-out opacity-60 mr-2"></i>{{ __('Logout') }}</a></li>
                </ul>
           </div>