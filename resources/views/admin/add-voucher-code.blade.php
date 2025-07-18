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
    @if(in_array('voucher',$avilable))
    <div id="right-panel" class="right-panel">
      @include('admin.header')
       <div class="breadcrumbs">
            <div class="col-sm-4">
                <div class="page-header float-left">
                    <div class="page-title">
                        <h1>{{ __('Add Voucher Code') }}</h1>
                    </div>
                </div>
            </div>
            <div class="col-sm-8">
                <div class="page-header float-right">
                    
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
                           <form action="{{ route('admin.add-voucher-code') }}" method="post" id="item_form" enctype="multipart/form-data">
                           {{ csrf_field() }}
                           @endif
                           <div class="col-md-6">
                           <div class="card-body">
                                <!-- Credit Card -->
                                <div id="pay-invoice">
                                    <div class="card-body">
                                       
                                            <div class="form-group">
                                                <label for="site_title" class="control-label mb-1">{{ __('Creation Rules') }}</label>
                                                 <input id="voucher_code" name="voucher_code" type="text" class="form-control" placeholder="e.g. CARD*#@D@*#@*@#@" data-bvalidator="rangelen[16:25]">
                                                 <small>Minimum 16-25 characters. "@" represents any random English characters, "#" represents any random number, "*' represents any characters or number <br/>Example : CARD*#@D@*#@*@#@ <span class="blue-color">(if 'leave blank' automatically generate voucher code)</span></small> 
                                            </div>
                                            <div class="form-group">
                                                <label for="site_title" class="control-label mb-1">{{ __('Voucher Face Value') }} <span class="require">*</span></label>
                                                 <input id="voucher_price" name="voucher_price" type="text" class="form-control" placeholder="e.g. 10,20,30" data-bvalidator="required">
                                            </div>
                                            <div class="form-group">
                                                <label for="site_title" class="control-label mb-1">{{ __('Bonus Credits') }} <span class="require">*</span></label>
                                                <input id="voucher_bonus" name="voucher_bonus" type="text" class="form-control" placeholder="e.g. 0,1,2" data-bvalidator="required">
                                                <small>if 0, no bonus credits will be added</small>
                                            </div> 
                                            <div class="form-group">
                                                <label for="site_title" class="control-label mb-1">{{ __('Total Vouchers') }}</label>
                                                <input id="total_voucher" name="total_voucher" type="text" class="form-control" placeholder="e.g. 10 or 50 or 100" data-bvalidator="digit">
                                                <small>{{ __('Enter the count of vouchers to be generated based on the above rule. e.g. 10 or 50 or 100') }}</small>
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
                                           <label for="site_title" class="control-label mb-1">{{ __('Expiry date') }}</label>
                                                <input id="event_start_date_time" name="voucher_expiry_date" type="text" class="form-control">
                                                <small>if 'leave blank' valid for 1 year from the date of generation</small>
                                            </div> 
                                            <div class="form-group">
                                                <label for="site_title" class="control-label mb-1">{{ __('Import Predefined Codes') }}</label>
                                                <textarea name="import_codes" id="import_codes" rows="3" class="form-control noscroll_textarea"></textarea>
                                                <small>If you already have a list of codes which you want to use as voucher codes, they can be imported here. The code must have a minimum of 16 characters. Enter each code one below the another in a separate line. Note : Creation Rules and Total Vouchers Fields must be blank while using this method <br/> e.g <br/> RslQisbD4p1woOXx <br/> 1yP02oBvRkTInD82 <br/> Jvh2hcqNdETsZAZA</small>
                                            </div>
                                            <div class="form-group">
                                                <label for="site_title" class="control-label mb-1">{{ __('Note') }}</label>
                                                <textarea name="voucher_notes" id="voucher_notes" rows="3" class="form-control noscroll_textarea"></textarea>
                                                
                                            </div>
                                      </div>
                                </div>
                             </div>
                             </div>
                             <div class="col-md-12 no-padding">
                             <div class="card-footer">
                                    <button type="submit" name="submit" class="btn btn-primary btn-sm">
                                        <i class="fa fa-dot-circle-o"></i> {{ __('Submit') }}
                                    </button>
                                    <button type="reset" class="btn btn-danger btn-sm">
                                          <i class="fa fa-ban"></i> {{ __('Reset') }}
                                    </button>
                                 </div>
                              </div>
                             </form>
                          </div> 
                      </div>
                 </div>
            </div><!-- .animated -->
        </div><!-- .content -->
     </div>
    @else
    @include('admin.denied')
    @endif
    @include('admin.javascript')
    <script type="text/javascript">
	function randomString() {
				//define a variable consisting alphabets in small and capital letter
		var characters = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
				
				//specify the length for the new string
		var lenString = 16;
		var randomstring = '';
	
				//loop to select a new character in each iteration
		for (var i=0; i<lenString; i++) {
			var rnum = Math.floor(Math.random() * characters.length);
			randomstring += characters.substring(rnum, rnum+1);
		}
	
				 //display the generated string 
		document.getElementById("voucher_code").value = randomstring;
	}
	</script>
</body>
</html>