<!DOCTYPE HTML>
<html lang="en">
<head>
  <title>{{ __('My Purchases') }} - {{ $allsettings->site_title }}</title>
  @include('meta')
  @include('style')
</head>
<body>
  @include('header')

  <div class="page-title-overlap pt-4"
       style="background-image: url('{{ url('/') }}/public/storage/settings/{{ $allsettings->site_other_banner }}');">
    <div class="container d-lg-flex justify-content-between py-2 py-lg-3">
      <div class="order-lg-2 mb-3 mb-lg-0 pt-lg-2">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb breadcrumb-light flex-lg-nowrap justify-content-center justify-content-lg-star">
            <li class="breadcrumb-item">
              <a class="text-nowrap" href="{{ URL::to('/') }}">
                <i class="dwg-home"></i>{{ __('Home') }}
              </a>
            </li>
            <li class="breadcrumb-item text-nowrap active"
                aria-current="page">{{ __('My Purchases') }}</li>
          </ol>
        </nav>
      </div>
      <div class="order-lg-1 pr-lg-4 text-center text-lg-left">
        <h1 class="h3 mb-0 text-white">{{ __('My Purchases') }}</h1>
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
        @if(count($orderData['item']) != 0)
        <section class="col-lg-8 pt-lg-4 pb-4 mb-3">
          <div class="pt-2 px-4 pl-lg-0 pr-xl-5">
            @foreach($orderData['item'] as $item)

              {{-- Only show credentials for non-downloadable --}}
              @if($item->type === 'non_downloadable')
                @php
                  $accounts = \DB::table('account_inventories')
                                 ->where('order_id', $item->ord_id)
                                 ->get();
                @endphp
                @if($accounts->count())
                  <div class="mt-3 p-3 border rounded bg-light">
                    <strong>Account Credentials:</strong><br>
                    @foreach($accounts as $acc)
                      <div class="mb-2">
                        <strong>Username:</strong> {{ $acc->username }}<br>
                        <strong>Password:</strong> {{ $acc->password }}<br>
                        @if($acc->note)
                          <strong>Note:</strong> {{ $acc->note }}<br>
                        @endif
                      </div>
                    @endforeach
                  </div>
                @endif
              @endif

              <div class="media d-block d-sm-flex align-items-center py-4 border-bottom">
                <a class="d-block mb-3 mb-sm-0 mr-sm-4 mx-auto"
                   href="{{ url('/item/'.$item->product_slug) }}"
                   style="width: 12.5rem;">
                  @if($item->product_image)
                    <img class="rounded-lg"
                         src="{{ url('/') }}/public/storage/product/{{ $item->product_image }}"
                         alt="{{ $item->product_name }}">
                  @else
                    <img class="rounded-lg"
                         src="{{ url('/') }}/public/img/no-image.png"
                         alt="{{ $item->product_name }}">
                  @endif
                </a>
                <div class="d-block mb-3 mb-sm-0 mr-sm-4 mx-auto">
                  <h3 class="h6 product-title mb-2">
                    <a href="{{ url('/item/'.$item->product_slug) }}">{{ $item->product_name }}</a>
                  </h3>
                  <div class="text-accent font-size-sm">
                    <strong>{{ __('Price') }}:</strong>
                    {{ $allsettings->site_currency_symbol }}{{ $item->product_price }}
                  </div>
                  <div class="d-flex align-items-center justify-content-center justify-content-sm-start">
                    @if($item->approval_status != 'payment released to customer')
                      @php $r = $item->rating; @endphp
                      <a class="d-block text-muted text-center my-2"
                         href="javascript:void(0);"
                         data-toggle="modal"
                         data-target="#myModal_{{ $item->ord_id }}">
                        <div class="star-rating">
                          @for($i=1; $i<=5; $i++)
                            <i class="sr-star dwg-star{{ $i <= $r ? '-filled active' : '' }}"></i>
                          @endfor
                        </div>
                        <div class="font-size-xs">{{ __('Rate this product') }}</div>
                      </a>
                    @endif
                  </div>
                  @if($item->approval_status != 'payment released to customer')
                    <div class="d-flex">
                      <a href="{{ url('/my-purchases/'.$item->product_token) }}"
                         class="btn btn-primary btn-sm mr-3">
                        <i class="dwg-download mr-1"></i>{{ __('Download File') }}
                      </a>
                      <a href="{{ url('/invoice/'.$item->product_token.'/'.$item->ord_id) }}"
                         class="btn btn-danger btn-sm mr-3">
                        <i class="dwg-download mr-1"></i>{{ __('Invoice') }}
                      </a>
                    </div>
                  @endif
                </div>
                <div class="d-block mb-3 mb-sm-0 mr-sm-4 mx-auto">
                  <div class="text-accent font-size-sm mb-1">
                    <strong>{{ __('Order Id') }}</strong> {{ $item->ord_id }}
                  </div>
                  <div class="text-accent font-size-sm mb-1">
                    <strong>{{ __('Purchase Id') }}</strong> {{ $item->purchase_token }}
                  </div>
                  <div class="text-accent font-size-sm mb-1">
                    <strong>{{ __('Purchase Date') }}</strong>
                    {{ date("d M Y", strtotime($item->start_date)) }}
                  </div>
                  <div class="text-accent font-size-sm mb-1">
                    <strong>{{ __('Expiry date') }}</strong>
                    {{ date("d M Y", strtotime($item->end_date)) }}
                  </div>
                  <div class="text-accent font-size-sm mb-1">
                    <strong>{{ __('Licence') }}</strong> {{ $item->license }}
                  </div>
                  @if($allsettings->site_refund_display == 1
                      && $item->approval_status != 'payment released to customer')
                    <div class="text-accent font-size-sm mb-1">
                      <strong>{{ __('Refund Request') }}</strong>
                      <a href="javascript:void(0);"
                         data-toggle="modal"
                         data-target="#refund_{{ $item->ord_id }}">
                        {{ __('Send Request') }}
                      </a>
                    </div>
                  @endif
                </div>
              </div>

              {{-- Rating Modal --}}
              <div class="modal fade" id="myModal_{{ $item->ord_id }}"
                   tabindex="-1" role="dialog"
                   aria-labelledby="ratingModalLabel_{{ $item->ord_id }}"
                   aria-hidden="true">
                <div class="modal-dialog" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title">
                        {{ __('Rating this Item') }}
                      </h5>
                      <button type="button" class="close"
                              data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <form action="{{ route('my-purchases') }}"
                          method="post" id="profile_form"
                          enctype="multipart/form-data">
                      @csrf
                      <div class="modal-body">
                        <input type="hidden" name="product_id"      value="{{ $item->product_id }}">
                        <input type="hidden" name="ord_id"           value="{{ $item->ord_id }}">
                        <input type="hidden" name="product_token"    value="{{ $item->product_token }}">
                        <input type="hidden" name="user_id"          value="{{ $item->user_id }}">
                        <input type="hidden" name="product_user_id"  value="{{ $item->product_user_id }}">
                        <input type="hidden" name="product_url"
                               value="{{ url('/item/'.$item->product_slug) }}">

                        <div class="form-group">
                          <label>{{ __('Your Rating') }}</label>
                          <select name="rating" class="form-control" required>
                            @for($s=1; $s<=5; $s++)
                              <option value="{{ $s }}"
                                {{ $item->rating == $s ? 'selected' : '' }}>
                                {{ $s }}
                              </option>
                            @endfor
                          </select>
                        </div>
                        <div class="form-group">
                          <label>{{ __('Rating Reason') }}</label>
                          <select name="rating_reason" class="form-control" required>
                            <option value="design"         {{ $item->rating_reason=='design'?'selected':'' }}>
                              {{ __('Design Quality') }}
                            </option>
                            <option value="customization"  {{ $item->rating_reason=='customization'?'selected':'' }}>
                              {{ __('Customization') }}
                            </option>
                            <option value="support"        {{ $item->rating_reason=='support'?'selected':'' }}>
                              {{ __('Support') }}
                            </option>
                            <option value="performance"    {{ $item->rating_reason=='performance'?'selected':'' }}>
                              {{ __('Performance') }}
                            </option>
                            <option value="documentation"  {{ $item->rating_reason=='documentation'?'selected':'' }}>
                              {{ __('Well Documented') }}
                            </option>
                          </select>
                        </div>
                        <div class="form-group">
                          <label>{{ __('Comments') }}</label>
                          <textarea name="rating_comment"
                                    class="form-control"
                                    required>{{ $item->rating_comment }}</textarea>
                          <p>
                            {{ __('Your review will be public visible and seller may reply to your comments') }}
                          </p>
                        </div>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm"
                                data-dismiss="modal">{{ __('Close') }}</button>
                        <button type="submit" class="btn btn-primary btn-sm">
                          {{ __('Submit Rating') }}
                        </button>
                      </div>
                    </form>
                  </div>
                </div>
              </div>

              {{-- Refund Request Modal --}}
              <div class="modal fade" id="refund_{{ $item->ord_id }}"
                   tabindex="-1" role="dialog"
                   aria-labelledby="refundModalLabel_{{ $item->ord_id }}"
                   aria-hidden="true">
                <div class="modal-dialog" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title">{{ __('Refund Request') }}</h5>
                      <button type="button" class="close"
                              data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <form action="{{ route('refund') }}"
                          method="post" id="refund_form"
                          enctype="multipart/form-data">
                      @csrf
                      <div class="modal-body">
                        <input type="hidden" name="product_id"       value="{{ $item->product_id }}">
                        <input type="hidden" name="ord_id"            value="{{ $item->ord_id }}">
                        <input type="hidden" name="purchased_token"   value="{{ $item->purchase_token }}">
                        <input type="hidden" name="product_token"     value="{{ $item->product_token }}">
                        <input type="hidden" name="user_id"           value="{{ $item->user_id }}">
                        <input type="hidden" name="product_user_id"   value="{{ $item->product_user_id }}">
                        <input type="hidden" name="product_url"
                               value="{{ url('/item/'.$item->product_slug) }}">

                        <div class="form-group">
                          <label>{{ __('Refund Reason') }}</label>
                          <select name="refund_reason" class="form-control" required>
                            <option value="Item is not as described or the item does not work the way it should">
                              {{ __('Item is not as described or the item does not work the way it should') }}
                            </option>
                            <option value="Item has a security vulnerability">
                              {{ __('Item has a security vulnerability') }}
                            </option>
                            <option value="Item support is promised but not provided">
                              {{ __('Item support is promised but not provided') }}
                            </option>
                            <option value="Item support extension not used">
                              {{ __('Item support extension not used') }}
                            </option>
                            <option value="Items that have not been downloaded">
                              {{ __('Items that have not been downloaded') }}
                            </option>
                          </select>
                        </div>
                        <div class="form-group">
                          <label>{{ __('Comments') }}</label>
                          <textarea name="refund_comment"
                                    class="form-control"
                                    required></textarea>
                        </div>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm"
                                data-dismiss="modal">{{ __('Close') }}</button>
                        <button type="submit" class="btn btn-primary btn-sm">
                          {{ __('Submit Request') }}
                        </button>
                      </div>
                    </form>
                  </div>
                </div>
              </div>

            @endforeach
          </div>
        </section>
        @else
        <section class="col-lg-8 pt-lg-4 pb-4 mb-3">
          <div class="pt-2 px-4 pl-lg-0 pr-xl-5 text-center">
            {{ __('No Data Found') }}
          </div>
        </section>
        @endif
      </div>
    </div>
  </div>

  @include('footer')
  @include('script')
</body>
</html>
