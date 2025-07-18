<aside id="left-panel" class="left-panel">
        <nav class="navbar navbar-expand-sm navbar-default">
            <div class="navbar-header">
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#main-menu" aria-controls="main-menu" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="fa fa-bars"></i>
                </button>
                @if($allsettings->site_logo != '')
                <a class="navbar-brand" href="{{ url('/') }}">{{ mb_substr($allsettings->site_title, 0, 10, 'UTF-8') }}<?php /*?><img src="{{ url('/') }}/public/storage/settings/{{ $allsettings->site_logo }}"  alt="{{ $allsettings->site_title }}" width="180"/><?php */?></a>
                @else
                <a class="navbar-brand" href="{{ url('/') }}">{{ mb_substr($allsettings->site_title, 0, 10, 'UTF-8') }}</a>
                @endif
                @if($allsettings->site_favicon != '')
                <a class="navbar-brand hidden" href="{{ url('/') }}"><img src="{{ url('/') }}/public/storage/settings/{{ $allsettings->site_favicon }}"  alt="{{ $allsettings->site_title }}" width="24"/></a>
                @else
                <a class="navbar-brand hidden" href="{{ url('/') }}">{{ mb_substr($allsettings->site_title, 0, 1, 'UTF-8') }}</a>
                @endif
            </div>
            <div id="main-menu" class="main-menu collapse navbar-collapse">
                @if($custom_settings->$dg_ver == 1) 
                <ul class="nav navbar-nav">
                    @if(in_array('dashboard',$avilable))
                    <li>
                        <a href="{{ url('/admin') }}"> <i class="menu-icon fa fa-dashboard"></i>{{ __('Dashboard') }} </a>
                    </li>
                    @endif
                    @if(in_array('settings',$avilable))
                    <li class="menu-item-has-children dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-gears"></i>{{ __('Settings') }}</a>
                        <ul class="sub-menu children dropdown-menu">
                            <li><i class="fa fa-gear"></i><a href="{{ url('/admin/general-settings') }}">{{ __('General Settings') }}</a></li>
                            <li><i class="fa fa-gear"></i><a href="{{ url('/admin/color-settings') }}">{{ __('Color Settings') }}</a></li>
                            <li><i class="fa fa-gear"></i><a href="{{ url('/admin/email-settings') }}">{{ __('Email Settings') }}</a></li>
                            <li><i class="fa fa-gear"></i><a href="{{ url('/admin/media-settings') }}">{{ __('Media Settings') }}</a></li>
                            <li><i class="fa fa-gear"></i><a href="{{ url('/admin/currency-settings') }}">{{ __('Currency Settings') }}</a></li>
                            <li><i class="fa fa-gear"></i><a href="{{ url('/admin/payment-settings') }}">{{ __('Payment Settings') }}</a></li>
                            <li><i class="fa fa-gear"></i><a href="{{ url('/admin/social-settings') }}">{{ __('Social Settings') }}</a></li>
                            <li><i class="fa fa-gear"></i><a href="{{ url('/admin/limitation-settings') }}">{{ __('Limitation Settings') }}</a></li>
                            <li><i class="fa fa-gear"></i><a href="{{ url('/admin/preferred-settings') }}">{{ __('Preferred Settings') }}</a></li>
                            <li><i class="fa fa-gear"></i><a href="{{ url('/admin/pwa-settings') }}">{{ __('PWA Settings') }}</a></li>
                            <li><i class="fa fa-gear"></i><a href="{{ url('/admin/theme-settings') }}">{{ __('Theme Settings') }}</a></li>
                        </ul>
                    </li>
                    @endif
                    @if(in_array('country',$avilable))
                    <li>
                        <a href="{{ url('/admin/country-settings') }}"> <i class="menu-icon fa fa-flag"></i>{{ __('Country') }}</a>
                    </li>
                    @endif
                    @if(Auth::user()->id == 1)
                    <li>
                        <a href="{{ url('/admin/administrator') }}"> <i class="menu-icon ti-user"></i>{{ __('Sub Administrator') }} </a>
                    </li>
                    @endif
                    @if(in_array('customers',$avilable))
                    <li>
                        <a href="{{ url('/admin/customer') }}"> <i class="menu-icon ti-user"></i>{{ __('Customers') }} </a>
                    </li>
                    @endif
                    <?php /*?>@if(in_array('category',$avilable))
                    <li>
                        <a href="{{ url('/admin/category') }}"> <i class="menu-icon fa fa-location-arrow"></i>{{ __('Category') }} </a>
                    </li>
                    @endif<?php */?>
                    @if(in_array('subscription',$avilable))
                    @if($allsettings->subscription_mode == 1)
                    <li>
                        <a href="{{ url('/admin/subscription') }}"> <i class="menu-icon fa fa-user"></i>{{ __('Subscription') }} </a>
                    </li>
                    @endif
                    @endif
                    @if(in_array('manage-products',$avilable))
                    <li class="menu-item-has-children dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-shopping-cart"></i>{{ __('Manage Products') }}</a>
                        <ul class="sub-menu children dropdown-menu">
                            <li><i class="menu-icon fa fa-location-arrow"></i><a href="{{ url('/admin/category') }}">{{ __('Category') }}</a></li>
                            <li><i class="menu-icon fa fa-location-arrow"></i><a href="{{ url('/admin/sub-category') }}">{{ __('Sub Category') }}</a></li>
                            <li><i class="menu-icon fa fa-location-arrow"></i><a href="{{ url('/admin/products') }}">{{ __('Products') }}</a></li>
                            <?php /*?><li><i class="menu-icon fa fa-shopping-cart"></i><a href="{{ url('/admin/package-includes') }}">{{ __('Package Includes') }}</a></li>
                            <li><i class="menu-icon fa fa-shopping-cart"></i><a href="{{ url('/admin/compatible-browsers') }}">{{ __('Compatible Browsers') }}</a></li><?php */?>
                            <li><i class="menu-icon fa fa-location-arrow"></i><a href="{{ url('/admin/attributes') }}">{{ __('Attributes') }}</a></li>
                            <?php /*?><li><i class="menu-icon fa fa-location-arrow"></i><a href="{{ url('/admin/reports') }}">{{ __('Reports') }}</a></li><?php */?>
                            
                        </ul>
                    </li>
                    @endif
                    @if(in_array('orders',$avilable))
                    <li>
                        <a href="{{ url('/admin/orders') }}"> <i class="menu-icon fa fa-first-order"></i>{{ __('Orders') }} </a>
                    </li>
                    @endif
                    @if($allsettings->site_refund_display == 1)
                    @if(in_array('refund-request',$avilable))
                    <li>
                        <a href="{{ url('/admin/refund') }}"> <i class="menu-icon fa fa-undo"></i>{{ __('Refund Request') }} </a>
                    </li>
                    @endif
                    @endif
                    <?php /*?>@if(in_array('rating-reviews',$avilable))
                    <li>
                        <a href="{{ url('/admin/rating') }}"> <i class="menu-icon fa fa-star"></i>{{ __('Rating & Reviews') }}</a>
                    </li>
                    @endif<?php */?>
                    @if($allsettings->site_withdrawal_display == 1)
                    @if(in_array('withdrawal',$avilable)) 
                    <li class="menu-item-has-children dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-money"></i>{{ __('Withdrawals') }}</a>
                        <ul class="sub-menu children dropdown-menu">
                            <li><i class="menu-icon fa fa-location-arrow"></i><a href="{{ url('/admin/withdrawal') }}">{{ __('Withdrawal Request') }}</a></li>
                            <li><i class="menu-icon fa fa-location-arrow"></i><a href="{{ url('/admin/withdrawal-methods') }}">{{ __('Withdraw Methods') }}</a></li>
                        </ul>
                    </li>
                    @endif
                    @endif
                    @if($allsettings->site_blog_display == 1)
                    @if(in_array('blog',$avilable))  
                    <li class="menu-item-has-children dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-comments-o"></i>{{ __('Blog') }}</a>
                        <ul class="sub-menu children dropdown-menu">
                            <li><i class="menu-icon fa fa-comments-o"></i><a href="{{ url('/admin/blog-category') }}">{{ __('Category') }}</a></li>
                            <li><i class="menu-icon fa fa-comments-o"></i><a href="{{ url('/admin/post') }}">{{ __('Post') }}</a></li>
                        </ul>
                    </li>
                    @endif
                    @endif
                    @if($allsettings->google_ads == 1)
                    @if(in_array('ads',$avilable)) 
                    <li>
                        <a href="{{ url('/admin/ads') }}"> <i class="menu-icon fa fa-file-image-o"></i>{{ __('Ads') }} </a>
                    </li>
                    @endif
                    @endif
                    @if(in_array('voucher',$avilable))
                    <li>
                        <a href="{{ url('/admin/voucher-code') }}"> <i class="menu-icon fa fa-gift"></i>{{ __('Prepaid Vouchers') }} </a>
                    </li>
                    @endif
                    @if(in_array('coupons',$avilable))
                    <li>
                        <a href="{{ url('/admin/coupons') }}"> <i class="menu-icon fa fa-percent"></i>{{ __('Discount Coupons') }} </a>
                    </li>
                    @endif
                    @if(in_array('tickets',$avilable))
                    <li>
                        <a href="{{ url('/admin/tickets') }}"> <i class="menu-icon fa fa-ticket"></i>{{ __('Support Tickets') }} </a>
                    </li>
                    @endif
                    @if(in_array('pages',$avilable)) 
                    <li>
                        <a href="{{ url('/admin/pages') }}"> <i class="menu-icon fa fa-file-text-o"></i>{{ __('Pages') }} </a>
                    </li>
                    @endif
                    @if(in_array('contact',$avilable))
                    <li>
                        <a href="{{ url('/admin/contact') }}"> <i class="menu-icon fa fa-address-book-o"></i>{{ __('Contact') }} </a>
                    </li>
                    @endif
                    @if(in_array('etemplate',$avilable))
                    <li>
                        <a href="{{ url('/admin/email-template') }}"> <i class="menu-icon fa fa-envelope"></i>{{ __('Email Template') }} </a>
                    </li>
                    @endif
                    @if(in_array('maintenance',$avilable))
                    <li>
                        <a href="{{ url('/admin/website-maintenance') }}"> <i class="menu-icon fa fa-wrench"></i>{{ __('Website Maintenance') }} </a>
                    </li>
                    @endif
                    @if($allsettings->site_newsletter_display == 1)
                    @if(in_array('newsletter',$avilable))
                    <li>
                        <a href="{{ url('/admin/newsletter') }}"> <i class="menu-icon fa fa-newspaper-o"></i>{{ __('Newsletter') }} </a>
                    </li>
                    @endif
                    @endif
                    @if(in_array('clear-cache',$avilable))
                    <li>
                        <a href="{{ url('/admin/clear-cache') }}" onClick="return confirm('{{ __('Are you sure you want to clear cache') }}?');"> <i class="menu-icon fa fa-trash"></i>{{ __('Clear Cache') }} </a>
                    </li>
                    @endif
                    @if(in_array('upgrade',$avilable))
                    <li>
                        <a href="{{ url('/admin/upgrade') }}"> <i class="menu-icon fa fa-refresh"></i>{{ __('Upgrade') }} </a>
                    </li>
                    @endif
                    @if(in_array('backups',$avilable))
                    <li>
                        <a href="{{ url('/admin/backup') }}"> <i class="menu-icon fa fa-hdd-o"></i>{{ __('Backups') }} </a>
                    </li>
                    @endif
                  </ul>
                  @endif
            </div><!-- /.navbar-collapse -->
        </nav>
    </aside>