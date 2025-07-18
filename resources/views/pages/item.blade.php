<!DOCTYPE HTML>
<html lang="en">
<head>
<title>{{ $item['view']->product_name }} - {{ $allsettings->site_title }}</title>
@if($slug != '')
@if($item['view']->product_allow_seo == 1)
<meta name="keywords" content="{{ $item['view']->product_seo_keyword }}">
<meta name="description" content="{{ $item['view']->product_seo_desc }}">
@else
@include('meta')
@endif
@else
@include('meta')
@endif
@include('style')
</head>
<body>
@include('header')
<div class="page-title-overlap pt-4" style="background-image: url('{{ url('/') }}/public/storage/settings/{{ $allsettings->site_other_banner }}');">
      <div class="container d-lg-flex justify-content-between py-2 py-lg-3">
        <div class="order-lg-2 mb-3 mb-lg-0 pt-lg-2">
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb flex-lg-nowrap justify-content-center justify-content-lg-star">
              <li class="breadcrumb-item"><a class="text-nowrap" href="{{ URL::to('/') }}"><i class="dwg-home"></i>{{ __('Home') }}</a></li>
              <li class="breadcrumb-item text-nowrap active" aria-current="page">{{ $item['view']->product_name }}</li>
             </ol>
          </nav>
        </div>
        <div class="order-lg-1 pr-lg-4 text-center text-lg-left">
          <h1 class="h3 mb-0 text-white">{{ $item['view']->product_name }}</h1>
          @if($item['view']->product_short_desc != "")
          <p class="product_short_desc">{{ $item['view']->product_short_desc }}</p>
          @endif
        </div>
      </div>
    </div>
<section class="container mb-3 pb-3">
      <div class="bg-light box-shadow-lg rounded-lg overflow-hidden">
        <div class="row">
          <!-- Content-->
          <section class="col-lg-8 pt-2 pt-lg-4 pb-4 mb-lg-3">
            <div class="pt-2 px-4 pr-lg-0 pl-xl-5">
              @if(in_array('item-details',$top_ads))
          	  <div class="mt-2 mb-4" align="center">
              @php echo html_entity_decode($allsettings->top_ads); @endphp
          	  </div>
         	  @endif
              <!-- Product gallery-->
              <div class="cz-gallery">
              @if($item['view']->product_preview!='')
              <a class="gallery-item rounded-lg mb-grid-gutter" href="{{ url('/') }}/public/storage/product/{{ $item['view']->product_preview }}" data-sub-html="{{ $item['view']->product_name }}"><img src="{{ url('/') }}/public/storage/product/{{ $item['view']->product_preview }}" alt="{{ $item['view']->product_name }}"/><span class="gallery-item-caption">{{ $item['view']->product_name }}</span></a>
              @else
               <img src="{{ url('/') }}/public/img/no-image.png" alt="{{ $item['view']->product_name }}" class="card-img-top featured-img">
                @endif
                @if($getcount != 0)
                <div class="row">
                  @foreach($getall['image'] as $image)
                  <div class="col-sm-2"><a class="gallery-item rounded-lg mb-grid-gutter" href="{{ url('/') }}/public/storage/product/{{ $image->product_gallery_image }}" data-sub-html="{{ $item['view']->product_name }}"><img src="{{ url('/') }}/public/storage/product/{{ $image->product_gallery_image }}" alt="{{ $image->product_gallery_image }}"/><span class="gallery-item-caption">{{ $item['view']->product_name }}</span></a></div>
                  @endforeach 
                </div>
                @endif
              </div>
              <!-- Wishlist + Sharing-->
              <div class="d-flex flex-wrap justify-content-between align-items-center border-top pt-3">
                <div class="py-2 mr-2">
                  @if($item['view']->product_demo_url != '')
                  @php
                  if($custom_settings->demo_url_preview == 0) { $demo_url = $item['view']->product_demo_url; } else { $demo_url = url('/preview').'/'.$item['view']->product_slug; }
                  @endphp 
                  <a class="btn btn-outline-accent btn-sm" href="{{ $demo_url }}" target="_blank"><i class="dwg-eye font-size-sm mr-2"></i>{{ __('Live Preview') }}</a>
                  @endif
                  @if($item['view']->product_video_url != '') 
                  <a class="btn btn-outline-accent btn-sm popupvideo" href="{{ $item['view']->product_video_url }}"><i class="dwg-video font-size-lg mr-2"></i>{{ __('Video') }}</a>
                  @endif
                  @if(Auth::guest())
                  <a class="btn btn-outline-accent btn-sm" href="{{ URL::to('/login') }}"><i class="dwg-heart font-size-lg mr-2"></i>{{ __('Add to Favorites') }}</a>
                  @endif
                  @if (Auth::check())
                  @if($item['view']->user_id != Auth::user()->id)
                  <a class="btn btn-outline-accent btn-sm" href="{{ url('/item') }}/{{ base64_encode($item['view']->product_id) }}/favorite/{{ base64_encode($item['view']->product_liked) }}"><i class="dwg-heart font-size-lg mr-2"></i>{{ __('Add to Favorites') }}</a>
                  @endif
                  @endif
                  </div>
                <div class="py-2"><i class="dwg-share-alt font-size-lg align-middle text-muted mr-2"></i>
                <a class="social-btn sb-outline sb-facebook sb-sm ml-2 share-button" data-share-url="{{ URL::to('/item') }}/{{ $item['view']->product_slug }}" data-share-network="facebook" data-share-text="{{ $item['view']->product_short_desc }}" data-share-title="{{ $item['view']->product_name }}" data-share-via="{{ $allsettings->site_title }}" data-share-tags="" data-share-media="{{ url('/') }}/public/storage/product/{{ $item['view']->product_preview }}" href="javascript:void(0)"><i class="dwg-facebook"></i></a>
                <a class="social-btn sb-outline sb-twitter sb-sm ml-2 share-button" data-share-url="{{ URL::to('/item') }}/{{ $item['view']->product_slug }}" data-share-network="twitter" data-share-text="{{ $item['view']->product_short_desc }}" data-share-title="{{ $item['view']->product_name }}" data-share-via="{{ $allsettings->site_title }}" data-share-tags="" data-share-media="{{ url('/') }}/public/storage/product/{{ $item['view']->product_preview }}" href="javascript:void(0)"><i class="dwg-twitter"></i></a>
                <a class="social-btn sb-outline sb-pinterest sb-sm ml-2 share-button" data-share-url="{{ URL::to('/item') }}/{{ $item['view']->product_slug }}" data-share-network="pinterest" data-share-text="{{ $item['view']->product_short_desc }}" data-share-title="{{ $item['view']->product_name }}" data-share-via="{{ $allsettings->site_title }}" data-share-tags="" data-share-media="{{ url('/') }}/public/storage/product/{{ $item['view']->product_preview }}" href="javascript:void(0)"><i class="dwg-pinterest"></i></a>
                <?php /*?><a class="social-btn sb-outline sb-linkedin sb-sm ml-2 share-button" data-share-url="{{ URL::to('/item') }}/{{ $item['view']->product_slug }}" data-share-network="linkedin" data-share-text="{{ $item['view']->product_short_desc }}" data-share-title="{{ $item['view']->product_name }}" data-share-via="{{ $allsettings->site_title }}" data-share-tags="" data-share-media="{{ url('/') }}/public/storage/product/{{ $item['view']->product_preview }}" href="javascript:void(0)"><i class="dwg-linkedin"></i></a><?php */?>
                 <a class="social-btn sb-outline sb-linkedin sb-sm ml-2 share-button" href="javascript:void(0)"  onClick="return popupwindow('https://api.whatsapp.com/send?text={{ URL::to('/item') }}/{{ $item['view']->product_slug }}','xtf','500','400');"><i class="fa fa-whatsapp"></i></a>
                </div>
                <div class="py-2">
                <?php /*?><i class="dwg-edit font-size-lg text-muted"></i> <a href="javascript:void(0);" data-toggle="modal" data-target="#form">Report this item</a><?php */?>
                <i class="dwg-edit font-size-lg text-muted"></i> <a href="{{ $allsettings->product_reporting_url }}" target="_blank">{{ __('Report this item') }}</a>
                </div>
 
 <div class="modal fade" id="form" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header border-bottom-0">
        <h5 class="modal-title" id="exampleModalLabel">{{ __('Report this item') }}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{ route('report') }}" class="support_form media-body needs-validation" id="issue_form" method="post" enctype="multipart/form-data">
       {{ csrf_field() }}
        <div class="modal-body">
          @if(Auth::guest())
          <div class="form-group">
            <label for="email1">{{ __('Full Name') }} <span class="text-danger">*</span></label>
            <input type="text" class="form-control" name="report_fullname" data-bvalidator="required">
            
          </div>
          <div class="form-group">
            <label for="email1">{{ __('Email') }} <span class="text-danger">*</span></label>
            <input type="email" class="form-control" name="report_email" data-bvalidator="required">
          </div>
          @else
          <input type="hidden" name="report_fullname" value="{{ Auth::user()->name }}">
          <input type="hidden" name="report_email" value="{{ Auth::user()->email }}">
          @endif
          <div class="form-group">
            <label for="password1">{{ __('Issue Type') }} <span class="text-danger">*</span></label>
            <select class="form-control" name="report_issue_type" data-bvalidator="required">
            <option value="Copyright Issue">{{ __('Copyright Issue') }}</option>
            <option value="Payment Issue">{{ __('Payment Issue') }}</option>
            <option value="Item or File Problem">{{ __('Item or File Problem') }}</option>
            <option value="General Issue">{{ __('General Issue') }}</option>
            <option value="Suggestion">{{ __('Suggestion') }}</option>
            </select>
          </div>
          <div class="form-group">
            <label for="email1">{{ __('Subject') }} <span class="text-danger">*</span></label>
            <input type="text" class="form-control" name="report_subject" data-bvalidator="required">
            
          </div>
          <div class="form-group">
            <label for="email1">{{ __('Message') }} <span class="text-danger">*</span></label>
            <textarea class="form-control" name="report_message" rows="3" data-bvalidator="required"></textarea>
            
          </div>
        </div>
        <input type="hidden" name="report_product_token" value="{{ $item['view']->product_token }}">
        <div class="modal-footer border-top-0 d-flex justify-content-center">
          <button type="submit" class="btn btn-success">{{ __('Submit') }}</button>
        </div>
      </form>
    </div>
  </div>
</div>
              </div>
            <div class="mt-4 mb-4 mb-lg-5">
      <!-- Nav tabs-->
      <ul class="nav nav-tabs" role="tablist">
        <li class="nav-item"><a class="nav-link p-4 active" href="#details" data-toggle="tab" role="tab">{{ __('Item Details') }}</a></li>
        <li class="nav-item"><a class="nav-link p-4" href="#comments" data-toggle="tab" role="tab">{{ __('Comments') }}</a></li>
        <li class="nav-item"><a class="nav-link p-4" href="#reviews" data-toggle="tab" role="tab">{{ __('Reviews') }}</a></li>
        <li class="nav-item"><a class="nav-link p-4" href="#suppport" data-toggle="tab" role="tab">{{ __('Support') }}</a></li>
      </ul>
      <div class="tab-content pt-2">
        <div class="tab-pane fade" id="suppport" role="tabpanel">
           <div class="row">
            <div class="col-lg-12">
               <h4>{{ __('Contact the Author') }}</h4>
               @if(Auth::guest())
                    <p>{{ __('Please') }} <a href="{{ URL::to('/login') }}" class="link-color">{{ __('Sign In') }}</a> {{ __('To Contact This Author') }}</p>
                    @endif
                    @if (Auth::check())
                    <form action="{{ route('support') }}" class="support_form media-body needs-validation" id="support_form" method="post" enctype="multipart/form-data">
                                            {{ csrf_field() }}
                                            <div class="form-group">
                                                    <label for="subj">{{ __('Subject') }}</label>
                                                    <input type="text" id="support_subject" name="support_subject" class="form-control" placeholder="{{ __('Enter your subject') }}" data-bvalidator="required"></div>
                                                <div class="form-group">
                                                    <label for="supmsg">{{ __('Message') }} </label>
                                                    <textarea class="form-control" id="support_msg" name="support_msg" rows="5" placeholder="{{ __('Enter your message') }}" data-bvalidator="required"></textarea></div>
                                                <input type="hidden" name="to_address" value="{{ $item['view']->email }}">
                                                <input type="hidden" name="to_name" value="{{ $item['view']->username }}">
                                                <input type="hidden" name="from_address" value="{{ Auth::user()->email }}">
                                                <input type="hidden" name="from_name" value="{{ Auth::user()->username }}">
                                                <input type="hidden" name="product_url" value="{{ URL::to('/item') }}/{{ $item['view']->product_slug }}">
                              <button type="submit" class="btn btn-primary btn-sm">{{ __('Submit Now') }}</button>
                      </form>
                @endif
            </div>
           </div> 
        </div>
        <!-- Product details tab-->
        <div class="tab-pane fade show active" id="details" role="tabpanel">
          <div class="row">
            <div class="col-lg-12">
              <p class="font-size-md mb-1">@php echo html_entity_decode($item['view']->product_desc); @endphp</p>
            </div>
          </div>
        </div>
        <!-- Reviews tab-->
        <div class="tab-pane fade" id="reviews" role="tabpanel">
         @if($review_count != 0)
         <div class="row pb-4">
            <!-- Reviews list-->
            <div class="col-md-12">
              <!-- Review-->
              @foreach($getreviewdata['view'] as $rating)
              <div class="product-review pb-4 mb-4 border-bottom review-item">
                <div class="d-flex mb-3">
                  <div class="media media-ie-fix align-items-center mr-4 pr-2">
                  @if($rating->or_user_id == 0)
                  <img class="rounded-circle" width="50" src="{{ url('/') }}/public/img/no-user.png" alt=""/>
                  @else
                  @if(Helper::Get_User_Photo($rating->or_user_id)!='')
                  <img class="rounded-circle" width="50" src="{{ url('/') }}/public/storage/users/{{ Helper::Get_User_Photo($rating->or_user_id) }}" alt=""/>
                  @else
                  <img class="rounded-circle" width="50" src="{{ url('/') }}/public/img/no-user.png" alt=""/>
                  @endif
                  @endif
                    <div class="media-body pl-3">
                      <h6 class="font-size-sm mb-0">@if($rating->or_user_id == 0){{ $rating->or_username }}@else{{ Helper::Get_User_Name($rating->or_user_id) }}@endif</h6><span class="font-size-ms text-muted">{{ date('d F Y H:i:s', strtotime($rating->rating_date)) }}</span></div>
                  </div>
                  <div>
                    <div class="star-rating">
                    @if($rating->rating == 0)
                    <i class="sr-star dwg-star"></i>
                    <i class="sr-star dwg-star"></i>
                    <i class="sr-star dwg-star"></i>
                    <i class="sr-star dwg-star"></i>
                    <i class="sr-star dwg-star"></i>
                    @endif
                    @if($rating->rating == 1)
                    <i class="sr-star dwg-star-filled active"></i>
                    <i class="sr-star dwg-star"></i>
                    <i class="sr-star dwg-star"></i>
                    <i class="sr-star dwg-star"></i>
                    <i class="sr-star dwg-star"></i>
                    @endif
                    @if($rating->rating == 2)
                    <i class="sr-star dwg-star-filled active"></i>
                    <i class="sr-star dwg-star-filled active"></i>
                    <i class="sr-star dwg-star"></i>
                    <i class="sr-star dwg-star"></i>
                    <i class="sr-star dwg-star"></i>
                    @endif
                    @if($rating->rating == 3)
                    <i class="sr-star dwg-star-filled active"></i>
                    <i class="sr-star dwg-star-filled active"></i>
                    <i class="sr-star dwg-star-filled active"></i>
                    <i class="sr-star dwg-star"></i>
                    <i class="sr-star dwg-star"></i>
                    @endif
                    @if($rating->rating == 4)
                    <i class="sr-star dwg-star-filled active"></i>
                    <i class="sr-star dwg-star-filled active"></i>
                    <i class="sr-star dwg-star-filled active"></i>
                    <i class="sr-star dwg-star-filled active"></i>
                    <i class="sr-star dwg-star"></i>
                    @endif
                    @if($rating->rating == 5)
                    <i class="sr-star dwg-star-filled active"></i>
                    <i class="sr-star dwg-star-filled active"></i>
                    <i class="sr-star dwg-star-filled active"></i>
                    <i class="sr-star dwg-star-filled active"></i>
                    <i class="sr-star dwg-star-filled active"></i>
                    @endif
                    </div>
                    <div class="review_tag">{{ $rating->rating_reason }}</div>
                  </div>
                </div>
                <p class="font-size-md mb-2">{{ $rating->rating_comment }}</p>
              </div>
              @endforeach
              <div class="float-right">
                 <div class="pagination-area">
                    <div class="turn-page" id="reviewpager"></div>
                    </div> 
              </div>
            </div>
            <!-- Leave review form-->
         </div>
         @endif
        </div>
        <!-- Comments tab-->
        <div class="tab-pane fade" id="comments" role="tabpanel">
          <div class="row thread">
            <div class="col-lg-12">
              <div class="media-list thread-list" id="listShow">
                                    @foreach ($comment['view'] as $parent)
                                        <div class="single-thread commli-item">
                                            <div class="media">
                                                <div class="media-left">
                                                    @if($parent->user_photo!='')
                                                    <img  src="{{ url('/') }}/public/storage/users/{{ $parent->user_photo }}" alt="{{ $parent->username }}" class="rounded-circle" width="50">@else
                                                    <img src="{{ url('/') }}/public/img/no-user.png" alt="{{ $parent->username }}" class="rounded-circle" width="50">
                                                    @endif
                                                </div>
                                                <div class="media-body">
                                                    <div>
                                                        <div class="media-heading">
                                                            <h6 class="font-size-md mb-0">{{ $parent->username }}</h6>
                                                        </div>
                                                        @if($parent->id == $item['view']->user_id)
                                                        <span class="comment-tag buyer">{{ __('Author') }}</span>
                                                        @endif
                                                        @if (Auth::check())
                                                        @if($item['view']->user_id == Auth::user()->id)
                                                        <a href="javascript:void(0);" class="nav-link-style font-size-sm font-weight-medium reply-link"><i class="dwg-reply mr-2">
                                                        </i>{{ __('Reply') }}</a>
                                                        @endif
                                                        @endif
                                                    </div>
                                                    <p class="font-size-md mb-1">{{ $parent->comm_text }}</p>
                                                    <span class="font-size-ms text-muted"><i class="dwg-time align-middle mr-2"></i>{{ date('d F Y, H:i:s', strtotime($parent->comm_date)) }}</span>
                                                </div>
                                            </div>
                                            <div class="children">
                                            @foreach ($parent->replycomment as $child)
                                                <div class="single-thread depth-2">
                                                    <div class="media">
                                                        <div class="media-left">
                                                    @if($child->user_photo!='')
                                                    <img  src="{{ url('/') }}/public/storage/users/{{ $child->user_photo }}" alt="{{ $child->username }}" class="rounded-circle" width="50">@else
                                                    <img src="{{ url('/') }}/public/img/no-user.png" alt="{{ $child->username }}" class="rounded-circle" width="50">
                                                    @endif
                                                    </div>
                                                        <div class="media-body">
                                                            <div class="media-heading">
                                                                <h6 class="font-size-md mb-0">{{ $child->username }}</h6>
                                                             </div>
                                                            @if($child->id == $item['view']->user_id)
                                                            <span class="comment-tag buyer">{{ __('Author') }}</span>
                                                            @endif
                                                            <p class="font-size-md mb-1">{{ $child->comm_text }}</p>
                                                            <span class="font-size-ms text-muted"><i class="dwg-time align-middle mr-2"></i>{{ date('d F Y, H:i:s', strtotime($child->comm_date)) }}</span></div>
                                                    </div>
                                                  </div>
                                                @endforeach
                                            </div>
                                            <!-- comment reply -->
                                            @if (Auth::check())
                                            <div class="media depth-2 reply-comment">
                                                <div class="media-left">
                                                    @if(Auth::user()->user_photo!='')
                                        <img  src="{{ url('/') }}/public/storage/users/{{ Auth::user()->user_photo }}" alt="{{ Auth::user()->username }}" class="rounded-circle" width="50">@else
                                        <img src="{{ url('/') }}/public/img/no-user.png" alt="{{ Auth::user()->username }}" class="rounded-circle" width="50">
                                        @endif
                                            </div>
                                                <div class="media-body">
                                                    <form action="{{ route('reply-post-comment') }}" class="comment-reply-form media-body needs-validation" method="post" enctype="multipart/form-data">
                                                    {{ csrf_field() }}
                                                    <textarea name="comm_text" class="form-control" placeholder="{{ __('Write your comment') }}..." required></textarea>
                                                    <input type="hidden" name="comm_user_id" value="{{ Auth::user()->id }}">
                                                    <input type="hidden" name="comm_product_user_id" value="{{ $item['view']->user_id }}">
                                                    <input type="hidden" name="comm_product_id" value="{{ $item['view']->product_id }}">
                                                    <input type="hidden" name="comm_id" value="{{ $parent->comm_id }}">
                                                    <input type="hidden" name="comm_product_url" value="{{ URL::to('/item') }}/{{ $item['view']->product_slug }}">
                                                   <button class="btn btn-primary btn-sm">{{ __('Post Comment') }}</button>
                                                </form>
                                                </div>
                                            </div>
                                            @endif
                                            <!-- comment reply -->
                                        </div>
                                       @endforeach
                                    </div>
                                   @if($comment_count != 0)
                                   <div class="float-right">
                                        <div class="pagination-area">
                                                <div class="turn-page" id="commpager"></div>
                                        </div> 
                                   </div>
                                   @endif
                  <div class="clearfix"></div>
                  @if (Auth::check())
                  @if($item['view']->user_id != Auth::user()->id)
                   <div class="card border-0 box-shadow my-2">
                   <h4 class="mt-4 ml-4">{{ __('Leave a comment') }}</h4>
                    <div class="card-body">
                      <div class="media">
                      @if(Auth::user()->user_photo != '')
                      <img class="rounded-circle" width="50" src="{{ url('/') }}/public/storage/users/{{ Auth::user()->user_photo }}" alt="{{ Auth::user()->name }}"/>
                      @else
                      <img class="rounded-circle" width="50" src="{{ url('/') }}/public/img/no-user.png" alt="{{ Auth::user()->name }}"/>
                      @endif
                      <form action="{{ route('post-comment') }}" class="comment-reply-form media-body needs-validation ml-3" id="item_form" method="post" enctype="multipart/form-data">
                        {{ csrf_field() }}
                          <div class="form-group">
                            <textarea class="form-control" rows="4" name="comm_text" placeholder="{{ __('Write comment') }}..." data-bvalidator="required"></textarea>
                            <input type="hidden" name="comm_user_id" value="{{ Auth::user()->id }}">

                            <input type="hidden" name="comm_product_user_id" value="{{ $item['view']->user_id }}">
                            <input type="hidden" name="comm_product_id" value="{{ $item['view']->product_id }}">
                            <input type="hidden" name="comm_product_url" value="{{ URL::to('/item') }}/{{ $item['view']->product_slug }}">
                            <div class="invalid-feedback">{{ __('Please write your comment') }}</div>
                          </div>
                          <button class="btn btn-primary btn-sm" type="submit">{{ __('Post Comment') }}</button>
                        </form>
                  </div>
                </div>
              </div>
              @endif
              @endif
            </div>
          </div>
        </div>
      </div>
    </div>
    @if(in_array('item-details',$bottom_ads))
     <div class="mt-3 mb-2" align="center">
     @php echo html_entity_decode($allsettings->bottom_ads); @endphp
     </div>
     @endif
     </div>
    </section>
          <!-- Sidebar-->
          <aside class="col-lg-4">
            <hr class="d-lg-none">
            <form action="{{ route('cart') }}" class="setting_form" method="post" id="order_form" enctype="multipart/form-data">
            {{ csrf_field() }} 
            <div class="cz-sidebar-static h-100 ml-auto border-left">
               @php if($item['view']->download_count == "") { $dcount = 0; } else { $dcount = $item['view']->download_count; } @endphp
               @if($item['view']->product_free == 1)
               <div class="bg-secondary rounded p-3 mb-4">
               <p>{{ __('This item is one of the') }} <strong>{{ __('free files') }}</strong>. {{ __('You are able to download this item for free for a limited time. Updates and support are only available if you purchase this item') }}</p>
               
               <div align="center">
                   @if (Auth::check())
                   <a href="{{ URL::to('/item') }}/download/{{ base64_encode($item['view']->product_token) }}" class="btn btn-primary btn-sm"> <i class="fa fa-download"></i> {{ __('Download this file for free') }} ({{ $dcount }})</a>
                   @endif
                   @if(Auth::guest())
                   <a href="{{ URL::to('/login') }}" class="btn btn-primary btn-sm"> <i class="fa fa-download"></i> {{ __('Download this file for free') }} ({{ $dcount }})</a>
                   @endif
                </div>
               </div>
               @else
               @if($allsettings->subscription_mode == 1)
                   @if (Auth::check())
                   @if(Auth::user()->user_subscr_type != "")
                   @if(Auth::user()->user_subscr_date >= date('Y-m-d'))
                   @if($item['view']->subscription_item == 1)
                   <div class="bg-secondary rounded p-3 mb-4">
                   <p>{{ __('This product is one of the Subscribe Users Free Download Files. You are able to download this product for free for a Unlimited time. Updates and support are only available if you purchase this item') }}</p>
                   <div align="center">
                   <a href="{{ URL::to('/item') }}/download/{{ base64_encode($item['view']->product_token) }}" class="btn btn-primary btn-sm"> <i class="fa fa-download"></i> {{ __('Download this file for free') }} ({{ $dcount }})</a>
                   </div>
                   </div>
                   @endif
                   @else
                   @if($item['view']->subscription_item == 1)
                   <div class="bg-secondary rounded p-3 mb-4">
                   <p>{{ __('Subscribe to unlock this product, plus millions of creative assets with unlimited downloads') }}</p>
                   <div align="center">
                   <a href="{{ URL::to('/subscription') }}" class="btn btn-primary btn-sm"> <i class="fa fa-download"></i> {{ __('Renew Subscription') }} ({{ $dcount }})</a>
                   </div>
                   </div>
                   @endif
                   @endif
                   @else
                   @if($item['view']->subscription_item == 1)
                   <div class="bg-secondary rounded p-3 mb-4">
                   <p>{{ __('Subscribe to unlock this product, plus millions of creative assets with unlimited downloads') }}</p>
                   <div align="center">
                   <a href="{{ URL::to('/subscription') }}" class="btn btn-primary btn-sm"> <i class="fa fa-download"></i> {{ __('Subscribe to download') }} ({{ $dcount }})</a>
                   </div>
                   </div>
                   @endif
                   @endif
                   @endif
                   @if(Auth::guest())
                   @if($item['view']->subscription_item == 1)
                   <div class="bg-secondary rounded p-3 mb-4">
                   <p>{{ __('Subscribe to unlock this product, plus millions of creative assets with unlimited downloads') }}</p>
                   <div align="center">
                   <a href="{{ URL::to('/subscription') }}" class="btn btn-primary btn-sm"> <i class="fa fa-download"></i> {{ __('Subscribe to download') }} ({{ $dcount }})</a>
                   </div>
                   </div>
                   @endif
                   @endif
               @endif
               @endif 
                <?php /*?>@php if($item['view']->product_flash_sale == 1)
                { 
                $regprice = ($allsettings->site_flash_sale_discount * $item['view']->regular_price) / 100;
                $exprice = ($allsettings->site_flash_sale_discount * $item['view']->extended_price) / 100;
                $item_price = round($regprice,2);
                $extend_item_price = round($exprice,2);
                } 
                else 
                { 
                $item_price = $item['view']->regular_price;
                $extend_item_price = $item['view']->extended_price; 
                } 
                @endphp<?php */?>
              @php
              $item_price = Helper::price_info($item['view']->product_flash_sale,$item['view']->regular_price);
                $extend_item_price = Helper::price_info($item['view']->product_flash_sale,$item['view']->extended_price);
               @endphp 
              <div class="accordion" id="licenses">
                <div class="card border-top-0 border-left-0 border-right-0">
                  <div class="card-header d-flex justify-content-between align-items-center py-3 border-0">
                    <div class="custom-control custom-radio">
                      <input class="custom-control-input" type="radio" name="item_price" value="{{ base64_encode($item_price) }}_regular" id="license-std" checked>
                      <label class="custom-control-label font-weight-medium text-dark" for="license-std" data-toggle="collapse" data-target="#standard-license">{{ __('Regular license') }}</label>
                    </div>
                    <h5 class="mb-0 text-accent font-weight-normal">@if($item['view']->product_flash_sale == 1)<del class="price-old fontsize17">{{ $allsettings->site_currency_symbol }}{{ $item['view']->regular_price }}</del>@endif <span class="bg-faded-accent rounded-sm py-1 px-2 fontsize17">{{ $allsettings->site_currency_symbol }}{{ $item_price }}</span>
                    </h5>
                  </div>
                  <div class="collapse show" id="standard-license" data-parent="#licenses">
                    <div class="card-body py-0 pb-2">
                      <ul class="list-unstyled font-size-sm">
                        <li class="d-flex align-items-center"><i class="dwg-check-circle text-success mr-1"></i><span class="font-size-ms">{{ __('Quality checked by') }} {{ $allsettings->site_title }}</span></li>
                        @if($item['view']->future_update == 1) 
                        <li class="d-flex align-items-center"><i class="dwg-check-circle text-success mr-1"></i><span class="font-size-ms">{{ __('Future updates') }}</span></li>
                        @else
                        <li class="d-flex align-items-center"><i class="dwg-close-circle text-danger mr-1"></i><span class="font-size-ms">{{ __('Future updates') }}</span></li>
                        @endif
                        @if($item['view']->item_support == 1)
                        <li class="d-flex align-items-center"><i class="dwg-check-circle text-success mr-1"></i><span class="font-size-ms">{{ __('6 Months support') }}</span></li>
                        @else
                        <li class="d-flex align-items-center"><i class="dwg-close-circle text-danger mr-1"></i><span class="font-size-ms">{{ __('6 Months support') }}</span></li>
                        @endif
                      </ul>
                    </div>
                  </div>
                </div>
                @if($item['view']->extended_price != 0)
                <div class="card border-bottom-0 border-left-0 border-right-0">
                  <div class="card-header d-flex justify-content-between align-items-center py-3 border-0">
                    <div class="custom-control custom-radio">
                      <input class="custom-control-input" type="radio" name="item_price" id="license-ext" value="{{ base64_encode($extend_item_price) }}_extended">
                      <label class="custom-control-label font-weight-medium text-dark" for="license-ext" data-toggle="collapse" data-target="#extended-license">{{ __('Extended license') }}</label>
                    </div>
                    <h5 class="mb-0 text-accent font-weight-normal">@if($item['view']->product_flash_sale == 1)<del class="price-old fontsize17">{{ $allsettings->site_currency_symbol }}{{ $item['view']->extended_price }}</del>@endif <span class="bg-faded-accent  rounded-sm py-1 px-2 fontsize17">{{ $allsettings->site_currency_symbol }}{{ $extend_item_price }}</span></h5>
                  </div>
                  <div class="collapse" id="extended-license" data-parent="#licenses">
                    <div class="card-body py-0 pb-2">
                      <ul class="list-unstyled font-size-sm">
                        <li class="d-flex align-items-center"><i class="dwg-check-circle text-success mr-1"></i><span class="font-size-ms">{{ __('Quality checked by') }} {{ $allsettings->site_title }}</span></li>
                        @if($item['view']->future_update == 1) 
                        <li class="d-flex align-items-center"><i class="dwg-check-circle text-success mr-1"></i><span class="font-size-ms">{{ __('Future updates') }}</span></li>
                        @else
                        <li class="d-flex align-items-center"><i class="dwg-close-circle text-danger mr-1"></i><span class="font-size-ms">{{ __('Future updates') }}</span></li>
                        @endif
                        @if($item['view']->item_support == 1)
                        <li class="d-flex align-items-center"><i class="dwg-check-circle text-success mr-1"></i><span class="font-size-ms">{{ __('12 Months support') }}</span></li>
                        @else
                        <li class="d-flex align-items-center"><i class="dwg-close-circle text-danger mr-1"></i><span class="font-size-ms">{{ __('12 Months support') }}</span></li>
                        @endif
                      </ul>
                    </div>
                  </div>
                </div>
                @endif
              </div>
              <hr>
              @if($allsettings->product_support_link !='')
              <p class="mt-2 mb-3"><a href="javascript:void(0)" data-toggle="modal" data-target="#myModal" class="font-size-xs">{{ $page['view']->page_title }}</a></p>
                <div class="modal fade" id="myModal">
                    <div class="modal-dialog modal-xl">
                      <div class="modal-content">
                         <div class="modal-header">
                          <h4 class="modal-title">{{ $page['view']->page_title }}</h4>
                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body">
                         @php echo html_entity_decode($page['view']->page_desc); @endphp
                        </div>
                       </div>
                    </div>
                  </div>
                @endif
                <input type="hidden" name="product_id" value="{{ $item['view']->product_id }}">
                <input type="hidden" name="product_name" value="{{ $item['view']->product_name }}">
                <input type="hidden" name="product_user_id" value="{{ $item['view']->user_id }}">
                <input type="hidden" name="product_token" value="{{ $item['view']->product_token }}">
                @if(Auth::guest())
                <button type="submit" class="btn btn-primary btn-shadow btn-block mt-4"><i class="dwg-cart font-size-lg mr-2"></i>{{ __('Add to Cart') }}</button>
                @endif
                @if (Auth::check())
                @if($item['view']->user_id == Auth::user()->id)
                <a href="{{ URL::to('/admin/edit-product') }}/{{ $item['view']->product_token }}" class="btn btn-primary btn-shadow btn-block mt-4"><i class="dwg-cart font-size-lg mr-2"></i>{{ __('Edit Product') }}</a>
                @else
                <?php /*?><input type="hidden" name="user_id" value="{{ Auth::user()->id }}"><?php */?>
                @if($checkif_purchased == 0)
                @if(Auth::user()->id != 1)
                <button type="submit" class="btn btn-primary btn-shadow btn-block mt-4"><i class="dwg-cart font-size-lg mr-2"></i>{{ __('Add to Cart') }}</button>
                @endif 
                @endif    
                @endif
                @endif 
                @php if($item['view']->product_sold == 0){ $sale_text = "Sale"; } else  { $sale_text = "Sales"; } @endphp
              @if($custom_settings->product_sale_count == 1)
              <div class="bg-secondary rounded p-3 mt-4 mb-2"><i class="dwg-download h5 text-muted align-middle mb-0 mt-n1 mr-2"></i><span class="d-inline-block h6 mb-0 mr-1">{{ $item['view']->product_sold }}</span><span class="font-size-sm">{{ $sale_text }}</span></div>
              @endif
              <div class="bg-secondary rounded p-3 mb-2">
                <div class="star-rating">
                @if($getreview == 0)
                <i class="sr-star dwg-star"></i>
                <i class="sr-star dwg-star"></i>
                <i class="sr-star dwg-star"></i>
                <i class="sr-star dwg-star"></i>
                <i class="sr-star dwg-star"></i>
                @else
                @if($count_rating == 0)
                <i class="sr-star dwg-star"></i>
                <i class="sr-star dwg-star"></i>
                <i class="sr-star dwg-star"></i>
                <i class="sr-star dwg-star"></i>
                <i class="sr-star dwg-star"></i>
                @endif
                @if($count_rating == 1)
                <i class="sr-star dwg-star-filled active"></i>
                <i class="sr-star dwg-star"></i>
                <i class="sr-star dwg-star"></i>
                <i class="sr-star dwg-star"></i>
                <i class="sr-star dwg-star"></i>
                @endif
                @if($count_rating == 2)
                <i class="sr-star dwg-star-filled active"></i>
                <i class="sr-star dwg-star-filled active"></i>
                <i class="sr-star dwg-star"></i>
                <i class="sr-star dwg-star"></i>
                <i class="sr-star dwg-star"></i>
                @endif
                @if($count_rating == 3)
                <i class="sr-star dwg-star-filled active"></i>
                <i class="sr-star dwg-star-filled active"></i>
                <i class="sr-star dwg-star-filled active"></i>
                <i class="sr-star dwg-star"></i>
                <i class="sr-star dwg-star"></i>
                @endif
                @if($count_rating == 4)
                <i class="sr-star dwg-star-filled active"></i>
                <i class="sr-star dwg-star-filled active"></i>
                <i class="sr-star dwg-star-filled active"></i>
                <i class="sr-star dwg-star-filled active"></i>
                <i class="sr-star dwg-star"></i>
                @endif
                @if($count_rating == 5)
                <i class="sr-star dwg-star-filled active"></i>
                <i class="sr-star dwg-star-filled active"></i>
                <i class="sr-star dwg-star-filled active"></i>
                <i class="sr-star dwg-star-filled active"></i>
                <i class="sr-star dwg-star-filled active"></i>
                @endif
                @endif
                </div>
                @if(!empty($item['view']->product_fake_stars))
                <div class="font-size-ms text-muted">{{ $item['view']->product_fake_stars }} {{ __('Ratings') }}</div>
                @else
                <div class="font-size-ms text-muted">{{ $getreview }} {{ __('Ratings') }}</div>
                @endif
              </div>
              <div class="bg-secondary rounded p-3 mb-4"><i class="dwg-chat h5 text-muted align-middle mb-0 mt-n1 mr-2"></i><span class="d-inline-block h6 mb-0 mr-1">{{ $comment_count }}</span><span class="font-size-sm">{{ __('Comments') }}</span></div>
              <ul class="list-unstyled font-size-sm">
                <li class="d-flex justify-content-between mb-3 pb-3 border-bottom"><span class="text-dark font-weight-medium">{{ __('Last update') }}</span><span class="text-muted">{{ date('d M Y', strtotime($item['view']->product_update)) }}</span></li>
                <li class="d-flex justify-content-between mb-3 pb-3 border-bottom"><span class="text-dark font-weight-medium">{{ __('Created') }}</span><span class="text-muted">{{ date('d M Y', strtotime($item['view']->product_date)) }}</span></li>
                <li class="d-flex justify-content-between mb-3 pb-3 border-bottom"><span class="text-dark font-weight-medium">{{ __('Category') }}</span><a class="product-meta" href="{{ URL::to('/shop/category') }}/{{ $item['view']->category_slug }}">{{ $item['view']->category_name }}</a></li>
                <?php /*?><li class="d-flex justify-content-between mb-3 pb-3 border-bottom"><span class="text-dark font-weight-medium title-width">{{ __('Package Includes') }}</span><span class="text-muted text-right">
                    @php $pack_info = ""; @endphp
                    @foreach($package['view'] as $package)
                    @php $checkpackage = explode(',',$item['view']->package_includes); @endphp
                    @php if(in_array($package->package_id,$checkpackage)){ $pack_info .= $package->package_name.', '; } @endphp
                    @endforeach 
                    {{ rtrim($pack_info,", ") }}
                    </span></li><?php */?>
                <?php /*?><li class="d-flex justify-content-between mb-3 pb-3 border-bottom"><span class="text-dark font-weight-medium title-width">{{ __('Compatible Browsers') }}</span><span class="text-muted text-right">       @php $browse_info = ""; @endphp
                    @foreach($browser['view'] as $package)
                    @php $checkpackage = explode(',',$item['view']->compatible_browsers); @endphp
                    @php if(in_array($package->browser_id,$checkpackage)){ $browse_info .= $package->browser_name.', '; } @endphp
                    @endforeach 
                    {{ rtrim($browse_info,", ") }}
                    </span></li><?php */?>
                    @if(count($viewattribute['details']) != 0)
                @foreach($viewattribute['details'] as $view_attribute)
                @if($view_attribute->product_attribute_values != "")
                <li class="d-flex justify-content-between mb-3 pb-3 border-bottom"><span class="text-dark font-weight-medium">{{ $view_attribute->product_attribute_label }}</span><span class="text-muted">@php echo str_replace(',', ',<br />', $view_attribute->product_attribute_values); @endphp </span></li>
                @endif
                @endforeach
                @endif
                    @if($item['view']->product_tags != '')
                 <li class="justify-content-between pb-3 border-bottom"><span class="text-dark font-weight-medium">{{ __('Tags') }}</span><br/>
                 @php $item_tags = explode(',',$item['view']->product_tags); @endphp
                 @foreach($item_tags as $tags)
                 <span class="text-right"><a href="{{ url('/tag') }}/item/{{ strtolower(str_replace(' ','-',$tags)) }}" class="link-color">{{ $tags.',' }}</a></span>
                 @endforeach
                 </li>
                 @endif
              </ul>
              @if(in_array('item-details',$sidebar_ads))
          	<div class="mt-3 mb-2" align="center">
            @php echo html_entity_decode($allsettings->sidebar_ads); @endphp
          	</div>
         	@endif
            </div>
            </form>
          </aside>
        </div>
      </div>
    </section>
    
    <section @if($custom_settings->theme_layout == 'container') class="container-fluid mb-5 pb-lg-3" @else class="container mb-5 pb-lg-3" @endif>
      <div class="d-flex flex-wrap justify-content-between align-items-center border-bottom pb-4 mb-4">
        <h2 class="h3 mb-0 pt-2">{{ __('Related Products') }}</h2>
      </div>
      <div class="row pt-2 mx-n2">
        <!-- Product-->
        @php $no = 1; @endphp
        @foreach($related['product'] as $featured)
        @php
        $price = Helper::price_info($featured->product_flash_sale,$featured->regular_price);
        $count_rating = Helper::count_rating($featured->ratings);
        @endphp
        <div @if($custom_settings->theme_layout == 'container') class="col-6 col-xs-6 col-sm-6 col-md-4 col-lg-2 px-2 mb-grid-gutter prod-item" @else class="col-6 col-xs-6 col-sm-6 col-md-4 col-lg-3 px-2 mb-grid-gutter prod-item" @endif>
          <!-- Product-->
          <div class="card product-card-alt">
            <div class="product-thumb">
              @if(Auth::guest()) 
              <a class="btn-wishlist btn-sm" href="{{ URL::to('/login') }}"><i class="dwg-heart"></i></a>
              @endif
              @if (Auth::check())
              @if($featured->user_id != Auth::user()->id)
              <a class="btn-wishlist btn-sm" href="{{ url('/item') }}/{{ base64_encode($featured->product_id) }}/favorite/{{ base64_encode($featured->product_liked) }}"><i class="dwg-heart"></i></a>
              @endif
              @endif
              <div class="product-card-actions"><a class="btn btn-light btn-icon btn-shadow font-size-base mx-2" href="{{ URL::to('/item') }}/{{ $featured->product_slug }}"><i class="dwg-eye"></i></a>
              @php
              $checkif_purchased = Helper::if_purchased($featured->product_token);
              @endphp
              @if($checkif_purchased == 0)
              @if (Auth::check())
              @if(Auth::user()->id != 1)
              <a class="btn btn-light btn-icon btn-shadow font-size-base mx-2" href="{{ URL::to('/add-to-cart') }}/{{ $featured->product_slug }}"><i class="dwg-cart"></i></a>
              @endif
              @else
              <a class="btn btn-light btn-icon btn-shadow font-size-base mx-2" href="{{ URL::to('/add-to-cart') }}/{{ $featured->product_slug }}"><i class="dwg-cart"></i></a>
              @endif
              @endif
              </div><a class="product-thumb-overlay" href="{{ URL::to('/item') }}/{{ $featured->product_slug }}"></a>
              @if($featured->product_image!='')
              <img src="{{ url('/') }}/public/storage/product/{{ $featured->product_image }}" alt="{{ $featured->product_name }}">
              @else
              <img src="{{ url('/') }}/public/img/no-image.png" alt="{{ $featured->product_name }}">
              @endif
            </div>
            <div class="card-body">
              <div class="d-flex flex-wrap justify-content-between align-items-start pb-2">
                <div class="text-muted font-size-xs mr-1"><a class="product-meta font-weight-medium" href="{{ URL::to('/shop') }}/category/{{ $featured->category_slug }}">{{ $featured->category_name }}</a></div>
                <div class="star-rating">
                    @if($count_rating == 0)
                    <i class="sr-star dwg-star"></i>
                    <i class="sr-star dwg-star"></i>
                    <i class="sr-star dwg-star"></i>
                    <i class="sr-star dwg-star"></i>
                    <i class="sr-star dwg-star"></i>
                    @endif
                    @if($count_rating == 1)
                    <i class="sr-star dwg-star-filled active"></i>
                    <i class="sr-star dwg-star"></i>
                    <i class="sr-star dwg-star"></i>
                    <i class="sr-star dwg-star"></i>
                    <i class="sr-star dwg-star"></i>
                    @endif
                    @if($count_rating == 2)
                    <i class="sr-star dwg-star-filled active"></i>
                    <i class="sr-star dwg-star-filled active"></i>
                    <i class="sr-star dwg-star"></i>
                    <i class="sr-star dwg-star"></i>
                    <i class="sr-star dwg-star"></i>
                    @endif
                    @if($count_rating == 3)
                    <i class="sr-star dwg-star-filled active"></i>
                    <i class="sr-star dwg-star-filled active"></i>
                    <i class="sr-star dwg-star-filled active"></i>
                    <i class="sr-star dwg-star"></i>
                    <i class="sr-star dwg-star"></i>
                    @endif
                    @if($count_rating == 4)
                    <i class="sr-star dwg-star-filled active"></i>
                    <i class="sr-star dwg-star-filled active"></i>
                    <i class="sr-star dwg-star-filled active"></i>
                    <i class="sr-star dwg-star-filled active"></i>
                    <i class="sr-star dwg-star"></i>
                    @endif
                    @if($count_rating == 5)
                    <i class="sr-star dwg-star-filled active"></i>
                    <i class="sr-star dwg-star-filled active"></i>
                    <i class="sr-star dwg-star-filled active"></i>
                    <i class="sr-star dwg-star-filled active"></i>
                    <i class="sr-star dwg-star-filled active"></i>
                    @endif
                </div>
               </div>
              <h3 class="product-title font-size-sm mb-2"><a href="{{ URL::to('/item') }}/{{ $featured->product_slug }}">{{ $featured->product_name }}</a></h3>
              <div class="d-flex flex-wrap justify-content-between align-items-center">
                <div class="font-size-sm mr-2"><i class="dwg-download text-muted mr-1"></i>{{ $featured->product_sold }}<span class="font-size-xs ml-1">{{ __('Sales') }}</span>
                </div>
                <div>@if($featured->product_flash_sale == 1)<del class="price-old">{{ $allsettings->site_currency_symbol }}{{ $featured->regular_price }}</del>@endif <span class="bg-faded-accent text-accent rounded-sm py-1 px-2">{{ $allsettings->site_currency_symbol }}{{ $price }}</span></div>
              </div>
            </div>
          </div>
        </div>
        <!-- Product-->
        @php $no++; @endphp
	    @endforeach
       </div>
   </section>
@include('footer')
@include('script')
</body>
</html>