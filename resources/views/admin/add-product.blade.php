<!doctype html>
<html class="no-js" lang="en">
<head>
    @include('admin.stylesheet')
</head>
<body>
    @include('admin.navigation')

    @if(in_array('manage-products',$avilable))
    <div id="right-panel" class="right-panel">
        @include('admin.header')

        <div class="breadcrumbs">
            <div class="col-sm-4">
                <div class="page-header float-left">
                    <div class="page-title"><h1>{{ __('Add Product') }}</h1></div>
                </div>
            </div>
            <div class="col-sm-8"><div class="page-header float-right"></div></div>
        </div>

        @include('admin.warning')

        <div class="content mt-3">
            <div class="animated fadeIn">
                <div class="row">

                    {{-- Dropzone (downloadable only) --}}
                    <div class="col-md-12" id="downloadable-dropzone">
                        <div class="card">
                            <div class="card-body">
                                <label class="control-label mb-1">
                                    {{ __('Files') }}
                                    @if($demo_mode=='on')<span class="require">{{ $demo_text }}</span>@endif
                                </label>
                                <form action="{{ route('fileupload') }}" class="dropzone" enctype="multipart/form-data">
                                    <input type="hidden" name="product_token" value="">
                                </form>
                            </div>
                        </div>
                    </div>

                    @if($demo_mode!='on')
                        <form action="{{ route('admin.add-product') }}"
                              method="post"
                              id="category_form"
                              enctype="multipart/form-data">
                            @csrf
                    @endif

                    {{-- Left column --}}
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">

                                {{-- Product Type --}}
                                <div class="form-group">
                                    <label class="control-label mb-1">{{ __('Product Type') }} <span class="require">*</span></label>
                                    <select name="type" id="type" class="form-control" data-bvalidator="required">
                                        <option value="downloadable">Downloadable</option>
                                        <option value="non_downloadable">Non-downloadable</option>
                                    </select>
                                </div>

                                {{-- Name --}}
                                <div class="form-group">
                                    <label class="control-label mb-1">{{ __('Product Name') }} <span class="require">*</span></label>
                                    <input name="product_name"
                                           type="text"
                                           class="form-control"
                                           data-bvalidator="required,maxlen[100]">
                                </div>

                                {{-- Slug --}}
                                <div class="form-group">
                                    <label class="control-label mb-1">{{ __('Product Slug') }}</label>
                                    <input name="product_slug" type="text" class="form-control">
                                    <small>
                                        ({{ __("if leave empty, it's automatically get product name to slug") }})
                                    </small>
                                </div>

                                {{-- Short Description --}}
                                <div class="form-group">
                                    <label class="control-label mb-1">{{ __('Short Description') }} <span class="require">*</span></label>
                                    <textarea name="product_short_desc"
                                              rows="4"
                                              class="form-control noscroll_textarea"
                                              data-bvalidator="required,maxlen[160]"></textarea>
                                </div>

                                {{-- Description --}}
                                <div class="form-group">
                                    <label class="control-label mb-1">{{ __('Description') }} <span class="require">*</span></label>
                                    <textarea name="product_desc"
                                              id="summary-ckeditor"
                                              rows="6"
                                              class="form-control"
                                              data-bvalidator="required"></textarea>
                                </div>

                                {{-- Category --}}
                                <div class="form-group">
                                    <label class="control-label mb-1">{{ __('Category') }} <span class="require">*</span></label>
                                    <select name="product_category"
                                            class="form-control"
                                            data-bvalidator="required">
                                        <option value=""></option>
                                        @foreach($re_categories['menu'] as $menu)
                                            <option value="category_{{ $menu->cat_id }}">
                                                {{ $menu->category_name }}
                                            </option>
                                            @foreach($menu->subcategory as $sub)
                                                <option value="subcategory_{{ $sub->subcat_id }}">
                                                    - {{ $sub->subcategory_name }}
                                                </option>
                                            @endforeach
                                        @endforeach
                                    </select>
                                </div>

                                {{-- Dynamic Attributes --}}
                                @foreach($attribute['fields'] as $attr)
                                    <div class="form-group">
                                        <label class="control-label mb-1">{{ $attr->attr_label }}</label>
                                        @php $vals = explode(',',$attr->attr_field_value); @endphp
                                        @if($attr->attr_field_type=='multi-select')
                                            <select name="attributes_{{ $attr->attr_id }}[]"
                                                    class="form-control"
                                                    multiple>
                                                @foreach($vals as $v)
                                                    <option value="{{ $v }}">{{ $v }}</option>
                                                @endforeach
                                            </select>
                                        @elseif($attr->attr_field_type=='single-select')
                                            <select name="attributes_{{ $attr->attr_id }}[]"
                                                    class="form-control">
                                                <option value=""></option>
                                                @foreach($vals as $v)
                                                    <option value="{{ $v }}">{{ $v }}</option>
                                                @endforeach
                                            </select>
                                        @else
                                            <input type="text"
                                                   name="attributes_{{ $attr->attr_id }}[]"
                                                   class="form-control">
                                        @endif
                                    </div>
                                @endforeach

                                {{-- Pricing --}}
                                <div class="form-group">
                                    <label class="control-label mb-1">
                                        {{ __('Regular License Price') }}
                                        ({{ __('6 Months Support') }})
                                        ({{ $allsettings->site_currency_symbol }})
                                        <span class="require">*</span>
                                    </label>
                                    <input name="regular_price"
                                           type="text"
                                           class="form-control"
                                           data-bvalidator="required,min[1]">
                                </div>
                                <div class="form-group">
                                    <label class="control-label mb-1">
                                        {{ __('Extended License Price') }}
                                        ({{ __('12 Months Support') }})
                                        ({{ $allsettings->site_currency_symbol }})
                                    </label>
                                    <input name="extended_price"
                                           type="text"
                                           class="form-control"
                                           data-bvalidator="min[1]">
                                </div>

                            </div>
                        </div>
                    </div>

                    {{-- Right column --}}
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">

                                {{-- Thumbnail --}}
                                <div class="form-group">
                                    <label class="control-label mb-1">
                                        {{ __('Upload Thumbnail Image') }} (296×200)
                                        <span class="require">*</span>
                                    </label>
                                    <select name="product_image1"
                                            class="form-control"
                                            data-bvalidator="required">
                                        <option value=""></option>
                                        @foreach($getdata1['first'] as $g)
                                            <option value="{{ $g->product_file_name }}">
                                                {{ $g->original_file_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                {{-- Preview --}}
                                <div class="form-group">
                                    <label class="control-label mb-1">
                                        {{ __('Upload Preview Image') }} (762×508)
                                        <span class="require">*</span>
                                    </label>
                                    <select name="product_preview1"
                                            class="form-control"
                                            data-bvalidator="required">
                                        <option value=""></option>
                                        @foreach($getdata4 as $g)
                                            <option value="{{ $g->product_file_name }}">
                                                {{ $g->original_file_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                {{-- Main File Type --}}
                                <div class="form-group">
                                    <label class="control-label mb-1">{{ __('Upload Main File Type') }}</label>
                                    <select name="product_file_type1"
                                            id="product_file_type1"
                                            class="form-control">
                                        <option value=""></option>
                                        <option value="file">{{ __('File') }}</option>
                                        <option value="link">{{ __('Link / URL') }}</option>
                                    </select>
                                </div>

                                {{-- ZIP upload --}}
                                <div class="form-group" id="main_file">
                                    <label class="control-label mb-1">
                                        {{ __('Upload Main File') }} (Zip only)
                                    </label>
                                    <select name="product_file1" class="form-control">
                                        <option value=""></option>
                                        @foreach($getdata2['second'] as $g)
                                            <option value="{{ $g->product_file_name }}">
                                                {{ $g->original_file_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                {{-- URL link --}}
                                <div class="form-group" id="main_link">
                                    <label class="control-label mb-1">{{ __('Main File Link/URL') }}</label>
                                    <input type="text" name="product_file_link1" class="form-control">
                                </div>

                                {{-- Gallery --}}
                                <div class="form-group">
                                    <label class="control-label mb-1">{{ __('Upload Gallery Images') }} (Multiselect)</label>
                                    <select name="product_gallery[]" class="form-control" multiple>
                                        @foreach($getdata3['third'] as $g)
                                            <option value="{{ $g->product_file_name }}">
                                                {{ $g->original_file_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                            </div>
                        </div>
                    </div>

                    {{-- Future Update --}}
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="control-label mb-1">{{ __('Future Update') }}</label>
                            <select name="future_update" class="form-control">
                                <option value=""></option>
                                <option value="1">Yes</option>
                                <option value="0">No</option>
                            </select>
                        </div>
                    </div>

                    {{-- Product Support --}}
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>{{ __('Product Support') }} <span class="require">*</span></label>
                            <select name="item_support"
                                    class="form-control"
                                    data-bvalidator="required">
                                <option value=""></option>
                                <option value="1">Yes</option>
                                <option value="0">No</option>
                            </select>
                        </div>

                        {{-- Tags --}}
                        <div class="form-group">
                            <label>{{ __('Tags') }}</label>
                            <textarea name="product_tags"
                                      rows="4"
                                      class="form-control noscroll_textarea"
                                      placeholder="separate tag with commas"></textarea>
                        </div>

                        {{-- Featured, Flash Sale, Free Download --}}
                        <div class="form-group">
                            <label>{{ __('Featured') }} <span class="require">*</span></label>
                            <select name="product_featured" class="form-control" data-bvalidator="required">
                                <option value=""></option>
                                <option value="1">Yes</option>
                                <option value="0">No</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>{{ __('Flash Sale') }} <span class="require">*</span></label>
                            <select name="product_flash_sale" class="form-control" data-bvalidator="required">
                                <option value=""></option>
                                <option value="1">Yes</option>
                                <option value="0">No</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>{{ __('Free Download') }} <span class="require">*</span></label>
                            <select name="product_free" id="product_free" class="form-control" data-bvalidator="required">
                                <option value=""></option>
                                <option value="1">Yes</option>
                                <option value="0">No</option>
                            </select>
                        </div>

                        {{-- Subscription Item (defaults to Off) --}}
                        @if($allsettings->subscription_mode == 1)
                            <div class="form-group" id="subscription_box">
                                <label>{{ __('Subscription Item') }}? <span class="require">*</span></label>
                                <select name="subscription_item" class="form-control" data-bvalidator="required">
                                    <option value="0" selected>{{ __('Off') }}</option>
                                    <option value="1">{{ __('On') }}</option>
                                </select>
                                <small>
                                    ({{ __('if Yes means subscription user will allowed free download this product') }})
                                </small>
                            </div>
                        @else
                            <input type="hidden" name="subscription_item" value="0">
                        @endif

                        {{-- Demo Url --}}
                        <div class="form-group">
                            <label>{{ __('Demo Url') }}</label>
                            <input name="product_demo_url" type="text" class="form-control" data-bvalidator="url">
                        </div>

                        {{-- SEO --}}
                        <div class="form-group">
                            <label>{{ __('Allow Seo') }}? <span class="require">*</span></label>
                            <select name="product_allow_seo" id="product_allow_seo" class="form-control" data-bvalidator="required">
                                <option value=""></option>
                                <option value="1">Yes</option>
                                <option value="0">No</option>
                            </select>
                        </div>
                        <div id="ifseo">
                            <div class="form-group">
                                <label>{{ __('SEO Meta Keywords') }} (max 160 chars) <span class="require">*</span></label>
                                <textarea name="product_seo_keyword"
                                          rows="4"
                                          class="form-control noscroll_textarea"
                                          data-bvalidator="required,maxlen[160]"></textarea>
                            </div>
                            <div class="form-group">
                                <label>{{ __('SEO Meta Description') }} (max 160 chars) <span class="require">*</span></label>
                                <textarea name="product_seo_desc"
                                          rows="4"
                                          class="form-control noscroll_textarea"
                                          data-bvalidator="required,maxlen[160]"></textarea>
                            </div>
                        </div>

                        {{-- Sold, Stars, Video --}}
                        <div class="form-group">
                            <label>{{ __('Product Sold') }}</label>
                            <input name="product_sold" type="text" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>{{ __('Fake Stars') }} (Count)</label>
                            <input name="product_fake_stars" type="text" class="form-control">
                            <small>(if leave blank automatic star count will be showing)</small>
                        </div>
                        <div class="form-group">
                            <label>{{ __('Video Url') }}</label>
                            <input name="product_video_url"
                                   type="text"
                                   class="form-control"
                                   placeholder="https://www.youtube.com/watch?v=…">
                        </div>

                    </div> {{-- /.col-md-12 --}}

                    {{-- Hidden fields & buttons --}}
                    <input type="hidden" name="image_size" value="{{ $allsettings->site_max_image_size }}">
                    <input type="hidden" name="zip_size"   value="{{ $allsettings->site_max_zip_size }}">
                    <input type="hidden" name="user_id"    value="1">

                    <div class="col-md-12 no-padding">
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary btn-sm">
                                <i class="fa fa-dot-circle-o"></i> {{ __('Submit') }}
                            </button>
                            <button type="reset" class="btn btn-danger btn-sm">
                                <i class="fa fa-ban"></i> {{ __('Reset') }}
                            </button>
                        </div>
                    </div>

                    @if($demo_mode!='on')
                        </form>
                    @endif

                </div> {{-- /.row --}}
            </div> {{-- /.animated --}}
        </div> {{-- /.content --}}
    </div> {{-- /#right-panel --}}
    @else
        @include('admin.denied')
    @endif

    @push('scripts')
    <script>
    document.addEventListener('DOMContentLoaded', function(){
        // Toggle Dropzone
        var typeEl     = document.getElementById('type'),
            dropzone   = document.getElementById('downloadable-dropzone');
        function toggleDropzone(){
            dropzone.style.display = (typeEl.value==='downloadable') ? 'block' : 'none';
        }
        typeEl.addEventListener('change', toggleDropzone);
        toggleDropzone();

        // Toggle Main File vs Link
        var ftEl       = document.getElementById('product_file_type1'),
            mainFileEl = document.getElementById('main_file'),
            mainLinkEl = document.getElementById('main_link');
        function toggleMainInputs(){
            var v = ftEl.value;
            mainFileEl.style.display = (v==='file') ? 'block' : 'none';
            mainLinkEl.style.display = (v==='link') ? 'block' : 'none';
        }
        ftEl.addEventListener('change', toggleMainInputs);
        toggleMainInputs();
    });
    </script>
    @endpush

    @include('admin.javascript')
    @include('admin.zone')
</body>
</html>
