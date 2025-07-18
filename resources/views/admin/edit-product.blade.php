{{-- File: resources/views/admin/edit-product.blade.php --}}
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
                    <div class="page-title"><h1>{{ __('Edit Product') }}</h1></div>
                </div>
            </div>
            <div class="col-sm-8"><div class="page-header float-right"></div></div>
        </div>
        @include('admin.warning')

        <div class="content mt-3">
            <div class="animated fadeIn">
                <div class="row">

                    {{-- Files Dropzone --}}
                    <div class="col-md-12">
                        <div class="card-body">
                            <div class="form-group">
                                <label class="control-label mb-1">{{ __('Files') }}
                                    @if($demo_mode=='on')<span class="require">{{ $demo_text }}</span>@endif
                                </label>
                                <form action="{{ route('fileupload') }}" class="dropzone" enctype="multipart/form-data">
                                    <input type="hidden" name="product_token" value="{{ $edit['product']->product_token }}">
                                </form>
                            </div>
                        </div>
                    </div>

                    @if($demo_mode!='on')
                    <form action="{{ route('admin.edit-product') }}" method="post" id="category_form" enctype="multipart/form-data">
                        @csrf
                    @endif

                    {{-- Left column --}}
                    <div class="col-md-6">
                        <div class="card-body">

                            {{-- PRODUCT TYPE --}}
                            <div class="form-group">
                                <label class="control-label mb-1">{{ __('Product Type') }} <span class="require">*</span></label>
                                <select name="type" id="type" class="form-control" data-bvalidator="required">
                                    <option value="downloadable"   {{ $edit['product']->type=='downloadable'   ? 'selected':'' }}>{{ __('Downloadable') }}</option>
                                    <option value="non_downloadable"{{ $edit['product']->type=='non_downloadable'? 'selected':'' }}>{{ __('Non-downloadable') }}</option>
                                </select>
                            </div>

                            {{-- PRODUCT NAME --}}
                            <div class="form-group">
                                <label class="control-label mb-1">{{ __('Product Name') }} <span class="require">*</span></label>
                                <input name="product_name" type="text" class="form-control" data-bvalidator="required,maxlen[100]" value="{{ $edit['product']->product_name }}">
                            </div>

                            {{-- PRODUCT SLUG --}}
                            <div class="form-group">
                                <label class="control-label mb-1">{{ __('Product Slug') }}</label>
                                <input name="product_slug" type="text" class="form-control" value="{{ $edit['product']->product_slug }}">
                                <small>({{ __("if leave empty, it's automatically get product name to slug") }})</small>
                            </div>

                            {{-- SHORT DESCRIPTION --}}
                            <div class="form-group">
                                <label class="control-label mb-1">{{ __('Short Description') }} <span class="require">*</span></label>
                                <textarea name="product_short_desc" rows="4" class="form-control noscroll_textarea" data-bvalidator="required,maxlen[160]">{{ $edit['product']->product_short_desc }}</textarea>
                            </div>

                            {{-- DESCRIPTION --}}
                            <div class="form-group">
                                <label class="control-label mb-1">{{ __('Description') }} <span class="require">*</span></label>
                                <textarea name="product_desc" id="summary-ckeditor" rows="6" class="form-control" data-bvalidator="required">{!! html_entity_decode($edit['product']->product_desc) !!}</textarea>
                            </div>

                            {{-- CATEGORY --}}
                            <div class="form-group">
                                <label class="control-label mb-1">{{ __('Category') }} <span class="require">*</span></label>
                                <select name="product_category" class="form-control" data-bvalidator="required">
                                    <option value="">{{ __('Select') }}</option>
                                    @foreach($re_categories['menu'] as $menu)
                                        <option value="category_{{ $menu->cat_id }}"
                                            @if($cat_name=='category' && $cat_id==$menu->cat_id) selected @endif>
                                            {{ $menu->category_name }}
                                        </option>
                                        @foreach($menu->subcategory as $sub)
                                            <option value="subcategory_{{ $sub->subcat_id }}"
                                                @if($cat_name=='subcategory' && $cat_id==$sub->subcat_id) selected @endif>
                                                - {{ $sub->subcategory_name }}
                                            </option>
                                        @endforeach
                                    @endforeach
                                </select>
                            </div>

                            {{-- DYNAMIC ATTRIBUTES --}}
                            @foreach($attri_field['display'] as $attribute_field)
                                @php
                                    $values   = explode(',', $attribute_field->attr_field_value);
                                    $selected = collect(Helper::SelectedButes($product_token, $attribute_field->attr_id)
                                                  ->pluck('product_attribute_values')->toArray())
                                                  ->flatMap(fn($v) => explode(',', $v))
                                                  ->toArray();
                                @endphp
                                <div class="form-group">
                                    <label class="control-label mb-1">{{ $attribute_field->attr_label }}</label>
                                    @if($attribute_field->attr_field_type=='multi-select')
                                        <select name="attributes_{{ $attribute_field->attr_id }}[]" class="form-control" multiple>
                                            @foreach($values as $v)
                                                <option value="{{ $v }}" @if(in_array($v,$selected)) selected @endif>{{ $v }}</option>
                                            @endforeach
                                        </select>
                                    @elseif($attribute_field->attr_field_type=='single-select')
                                        <select name="attributes_{{ $attribute_field->attr_id }}[]" class="form-control">
                                            <option value=""></option>
                                            @foreach($values as $v)
                                                <option value="{{ $v }}" @if(in_array($v,$selected)) selected @endif>{{ $v }}</option>
                                            @endforeach
                                        </select>
                                    @else
                                        <input type="text" name="attributes_{{ $attribute_field->attr_id }}[]" class="form-control">
                                    @endif
                                </div>
                            @endforeach

                            {{-- PRICES --}}
                            <div class="form-group">
                                <label class="control-label mb-1">
                                    {{ __('Regular License Price') }} ({{ __('6 Months Support') }}) ({{ $allsettings->site_currency_symbol }}) <span class="require">*</span>
                                </label>
                                <input name="regular_price" type="text" class="form-control" data-bvalidator="required,min[1]" value="{{ $edit['product']->regular_price }}">
                            </div>
                            <div class="form-group">
                                <label class="control-label mb-1">
                                    {{ __('Extended License Price') }} ({{ __('12 Months Support') }}) ({{ $allsettings->site_currency_symbol }})
                                </label>
                                <input name="extended_price" type="text" class="form-control" data-bvalidator="min[1]" value="{{ $edit['product']->extended_price?:'' }}">
                            </div>

                        </div>
                    </div>
                    {{-- /Left column --}}

                    {{-- Right column --}}
                    <div class="col-md-6">
                        <div class="card-body">

                            {{-- Always show Thumbnail --}}
                            <div class="form-group">
                                <label class="control-label mb-1">{{ __('Upload Thumbnail Image') }} (296×200) <span class="require">*</span></label>
                                <select name="product_image1" class="form-control" @if(!$edit['product']->product_image) data-bvalidator="required" @endif>
                                    <option value=""></option>
                                    @foreach($getdata1['first'] as $g)
                                        <option value="{{ $g->product_file_name }}">{{ $g->original_file_name }}</option>
                                    @endforeach
                                </select>
                                @if($edit['product']->product_image)
                                    <img src="{{ url('/') }}/public/storage/product/{{ $edit['product']->product_image }}" class="item-thumb">
                                @else
                                    <img src="{{ url('/') }}/public/img/no-image.png" class="item-thumb">
                                @endif
                            </div>

                            {{-- Always show Preview --}}
                            <div class="form-group">
                                <label class="control-label mb-1">{{ __('Upload Preview Image') }} (762×508) <span class="require">*</span></label>
                                <select name="product_preview1" class="form-control" @if(!$edit['product']->product_preview) data-bvalidator="required" @endif>
                                    <option value=""></option>
                                    @foreach($getdata4 as $g)
                                        <option value="{{ $g->product_file_name }}">{{ $g->original_file_name }}</option>
                                    @endforeach
                                </select>
                                @if($edit['product']->product_preview)
                                    <img src="{{ url('/') }}/public/storage/product/{{ $edit['product']->product_preview }}" class="item-thumb">
                                @else
                                    <img src="{{ url('/') }}/public/img/no-image.png" class="item-thumb">
                                @endif
                            </div>

                            {{-- Downloadable-only fields --}}
                            <div id="downloadable-fields" style="{{ $edit['product']->type=='non_downloadable'?'display:none':'' }}">
                                {{-- Main File Type --}}
                                <div class="form-group">
                                    <label class="control-label mb-1">{{ __('Upload Main File Type') }}</label>
                                    <select name="product_file_type1" id="product_file_type1" class="form-control">
                                        <option value=""></option>
                                        <option value="file" {{ $edit['product']->product_file_type=='file'?'selected':'' }}>{{ __('File') }}</option>
                                        <option value="link" {{ $edit['product']->product_file_type=='link'?'selected':'' }}>{{ __('Link / URL') }}</option>
                                    </select>
                                </div>

                                {{-- Main File Upload --}}
                                <div id="main_file" class="form-group" style="{{ $edit['product']->product_file_type=='file'?'display:block':'display:none' }}">
                                    <label class="control-label mb-1">{{ __('Upload Main File') }} ({{ __('Zip Format Only') }})</label>
                                    <select name="product_file1" class="form-control">
                                        <option value=""></option>
                                        @foreach($getdata2['second'] as $g)
                                            <option value="{{ $g->product_file_name }}">{{ $g->original_file_name }}</option>
                                        @endforeach
                                    </select>
                                    <span class="require">{{ $edit['product']->product_file }}</span>
                                </div>

                                {{-- Main File Link --}}
                                <div id="main_link" class="form-group" style="{{ $edit['product']->product_file_type=='link'?'display:block':'display:none' }}">
                                    <label class="control-label mb-1">{{ __('Main File Link/URL') }}</label>
                                    <input type="text" name="product_file_link1" class="form-control" value="{{ $edit['product']->product_file_link }}">
                                </div>

                                {{-- Gallery --}}
                                <div class="form-group">
                                    <label class="control-label mb-1">{{ __('Upload Gallery Images') }} ({{ __('Multiselect') }})</label>
                                    <select name="product_gallery[]" class="form-control" multiple>
                                        @foreach($getdata3['third'] as $g)
                                            <option value="{{ $g->product_file_name }}">{{ $g->original_file_name }}</option>
                                        @endforeach
                                    </select>
                                    <div class="gallery-preview">
                                        @foreach($product_image['view'] as $img)
                                            <div class="item-img">
                                                <img src="{{ url('/') }}/public/storage/product/{{ $img->product_gallery_image }}" class="item-thumb">
                                                <a href="{{ url('/admin/edit-product/dropimg/'.base64_encode($img->prod_gal_id)) }}"
                                                   onClick="return confirm('Are you sure?');" class="drop-icon">
                                                    <span class="ti-trash"></span>
                                                </a>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            {{-- /downloadable-only fields --}}

                            {{-- Future Update --}}
                            <div class="form-group">
                                <label class="control-label mb-1">{{ __('Future Update') }}</label>
                                <select name="future_update" class="form-control">
                                    <option value=""></option>
                                    <option value="1" {{ $edit['product']->future_update==1?'selected':'' }}>Yes</option>
                                    <option value="0" {{ $edit['product']->future_update==0?'selected':'' }}>No</option>
                                </select>
                            </div>

                            {{-- Product Support --}}
                            <div class="form-group">
                                <label class="control-label mb-1">{{ __('Product Support') }} <span class="require">*</span></label>
                                <select name="item_support" class="form-control" data-bvalidator="required">
                                    <option value=""></option>
                                    <option value="1" {{ $edit['product']->item_support==1?'selected':'' }}>Yes</option>
                                    <option value="0" {{ $edit['product']->item_support==0?'selected':'' }}>No</option>
                                </select>
                            </div>

                            {{-- (All other fields—tags, featured, flash sale, etc.—remain unchanged) --}}

                            {{-- Hidden --}}
                            <input type="hidden" name="image_size" value="{{ $allsettings->site_max_image_size }}">
                            <input type="hidden" name="zip_size"   value="{{ $allsettings->site_max_zip_size }}">
                            <input type="hidden" name="user_id"    value="1">
                            <input type="hidden" name="save_product_image"   value="{{ $edit['product']->product_image }}">
                            <input type="hidden" name="save_product_preview" value="{{ $edit['product']->product_preview }}">
                            <input type="hidden" name="save_product_file"    value="{{ $edit['product']->product_file }}">
                            <input type="hidden" name="product_token"         value="{{ $edit['product']->product_token }}">
                            <input type="hidden" name="save_file_type"        value="{{ $edit['product']->product_file_type }}">

                            {{-- Submit --}}
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

                        </div>
                    </div>
                    {{-- /Right column --}}

                </div>
            </div>
        </div>
    </div>
    @else
        @include('admin.denied')
    @endif

    @include('admin.javascript')
    @include('admin.zone')

    <script>
    document.addEventListener('DOMContentLoaded', function(){
        // Toggle downloadable block
        let typeEl = document.getElementById('type'),
            dlEl   = document.getElementById('downloadable-fields');
        function toggleDownloadable(){
            dlEl.style.display = (typeEl.value==='downloadable') ? '' : 'none';
        }
        typeEl.addEventListener('change', toggleDownloadable);
        toggleDownloadable();

        // Toggle main file vs link inputs
        let ftEl = document.getElementById('product_file_type1'),
            mf   = document.getElementById('main_file'),
            ml   = document.getElementById('main_link');
        function toggleFileLink(){
            let v = ftEl.value;
            mf.style.display = (v==='file') ? 'block' : 'none';
            ml.style.display = (v==='link') ? 'block' : 'none';
        }
        ftEl.addEventListener('change', toggleFileLink);
        toggleFileLink();
    });
    </script>

</body>
</html>
