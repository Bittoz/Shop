<script src="<?php echo e(asset('resources/views/theme/js/vendor.min.js')); ?>"></script>
<script src="<?php echo e(asset('resources/views/theme/js/theme.min.js')); ?>"></script>
<?php if($message = Session::get('success')): ?>
<script type="text/javascript">
$('#cart-toast-success').toast('show')
</script>
<?php endif; ?>
<?php if($message = Session::get('error')): ?>
<script type="text/javascript">
$('#cart-toast-error').toast('show')
</script>
<?php endif; ?>
<!-- pagination --->
<script src="<?php echo e(URL::to('resources/views/theme/pagination/pagination.js')); ?>"></script>
<script type="text/javascript">
    $(document).ready(function() {
      $(this).cPager({
            pageSize: <?php echo e($allsettings->post_per_page); ?>, 
            pageid: "post-pager", 
            itemClass: "li-item",
			pageIndex: 1
 
        });
	$(this).cPager({
            pageSize: <?php echo e($allsettings->comment_per_page); ?>, 
            pageid: "commpager", 
            itemClass: "commli-item",
			pageIndex: 1
 
        });	
		
	$(this).cPager({
            pageSize: <?php echo e($allsettings->review_per_page); ?>, 
            pageid: "reviewpager", 
            itemClass: "review-item",
			pageIndex: 1
 
        });	
		
	$(this).cPager({
            pageSize: <?php echo e($allsettings->product_per_page); ?>, 
            pageid: "itempager", 
            itemClass: "prod-item",
			pageIndex: 1
 
        });	
});
function myFunction() {
  'use strict'; 
  /* Get the text field */
  var copyText = document.getElementById("myInput");

  /* Select the text field */
  copyText.select();
  copyText.setSelectionRange(0, 99999); /*For mobile devices*/

  /* Copy the text inside the text field */
  document.execCommand("copy");

  
}
</script>
<!--- pagination --->
<script type="text/javascript">
function popupwindow(url, title, w, h) {
  var left = (screen.width/2)-(w/2);
  var top = (screen.height/2)-(h/2);
  return window.open(url, title, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=no, width='+w+', height='+h+', top='+top+', left='+left);
} 
</script>
<!-- share code -->
<script src="<?php echo e(asset('resources/views/theme/share/share.js')); ?>"></script> 
<script type="text/javascript">
$(document).ready(function(){

		$('.share-button').simpleSocialShare();

	});
</script> 
<!-- share code -->
<!-- validation code -->
<script src="<?php echo e(URL::to('resources/views/theme/validate/jquery.bvalidator.min.js')); ?>"></script>
<script src="<?php echo e(URL::to('resources/views/theme/validate/themes/presenters/default.min.js')); ?>"></script>
<script src="<?php echo e(URL::to('resources/views/theme/validate/themes/red/red.js')); ?>"></script>
<script type="text/javascript">
    $(document).ready(function () {
        
		var options = {
		
		offset:              {x:5, y:-2},
		position:            {x:'left', y:'center'},
        themes: {
            'red': {
                 showClose: true
            },
		
        }
    };

    $('#login_form').bValidator(options);
	$('#contact_form').bValidator(options);
	$('#subscribe_form').bValidator(options);
	$('#footer_form').bValidator(options);
	$('#comment_form').bValidator(options);
	$('#reset_form').bValidator(options);
	$('#support_form').bValidator(options);
	$('#item_form').bValidator(options);
	$('#search_form').bValidator(options);
	$('#checkout_form').bValidator(options);
	$('#profile_form').bValidator(options);
	$('#withdrawal_form').bValidator(options);
	$('#issue_form').bValidator(options);
    });
</script>
<!-- validation code -->
<!-- countdown -->
<script type="text/javascript" src="<?php echo e(asset('resources/views/theme/countdown/jquery.countdown.js?v=1.0.0.0')); ?>"></script>
<!-- countdown -->
<!--- video code --->
<script type="text/javascript" src="<?php echo e(URL::to('resources/views/theme/video/video.js')); ?>"></script>
<script type="text/javascript">
		jQuery(function(){
			jQuery("a.popupvideo").YouTubePopUp( { autoplay: 0 } ); // Disable autoplay
		});
</script>
<!--  video code --->
<!--- auto search -->
<script src="<?php echo e(URL::to('resources/views/theme/autosearch/jquery-ui.js')); ?>"></script>
<script type="text/javascript">
   $(document).ready(function() {
    src = "<?php echo e(route('searchajax')); ?>";
     $("#product_item").autocomplete({
        source: function(request, response) {
            $.ajax({
                url: src,
                dataType: "json",
                data: {
                    term : request.term
                },
                success: function(data) {
                    response(data);
                   
                }
            });
        },
        minLength: 1,
       
    });
});
</script>
<script type="text/javascript">
   $(document).ready(function() {
    src = "<?php echo e(route('searchajax')); ?>";
     $("#product_item_top").autocomplete({
        source: function(request, response) {
            $.ajax({
                url: src,
                dataType: "json",
                data: {
                    term : request.term
                },
                success: function(data) {
                    response(data);
                   
                }
            });
        },
        minLength: 1,
       
    });
});
</script>
<!--- auto search -->
<!--- common code -->
<script type="text/javascript">

$(document).ready(function() {


  var $tabButtonItem = $('#tab-button li'),
      $tabSelect = $('#tab-select'),
      $tabContents = $('.tab-contents'),
      activeClass = 'is-active';

  $tabButtonItem.first().addClass(activeClass);
  $tabContents.not(':first').hide();

  $tabButtonItem.find('a').on('click', function(e) {
    var target = $(this).attr('href');

    $tabButtonItem.removeClass(activeClass);
    $(this).parent().addClass(activeClass);
    $tabSelect.val(target);
    $tabContents.hide();
    $(target).show();
    e.preventDefault();
  });

  $tabSelect.on('change', function() {
    var target = $(this).val(),
        targetSelectNum = $(this).prop('selectedIndex');

    $tabButtonItem.removeClass(activeClass);
    $tabButtonItem.eq(targetSelectNum).addClass(activeClass);
    $tabContents.hide();
    $(target).show();
  });

/* Reply comment area js goes here */
    var $replyForm = $('.reply-comment'),
        $replylink = $('.reply-link');

    $replyForm.hide();
    $replylink.on('click', function (e) {
        e.preventDefault();
        $(this).parents('.media').siblings('.reply-comment').toggle().find('textarea').focus();
    });

}); 


$(function () {
'use strict';
$("#ifstripe").hide();
$("#ifpaystack").hide();
$("#ifpaypal").hide();
$("#iflocalbank").hide();
$("#ifpayfast").hide();
$("#ifpaytm").hide();
$("#ifupi").hide();
$("#ifskrill").hide();
$("#ifcrypto").hide();
$("input[name='withdrawal']").click(function () {
		
            if ($("#withdrawal-paypal").is(":checked")) 
			{
			   $("#ifpaypal").show();
			   $("#ifpaytm").hide();
			   $("#ifupi").hide();
			   $("#ifskrill").hide();
			   $("#iflocalbank").hide();
			   $("#ifpayfast").hide();
			   $("#ifstripe").hide();
			   $("#ifpaystack").hide();
			   $("#ifcrypto").hide();
			}
			else if ($("#withdrawal-stripe").is(":checked"))
			{
			  $("#ifstripe").show();
			  $("#ifpaytm").hide();
			  $("#ifupi").hide();
			  $("#ifskrill").hide();
			  $("#iflocalbank").hide();
			  $("#ifpayfast").hide();
			  $("#ifpaypal").hide();
			  $("#ifpaystack").hide();
			  $("#ifcrypto").hide();
			}
			else if ($("#withdrawal-paystack").is(":checked"))
			{
			  $("#ifpaystack").show();
			  $("#ifpaytm").hide();
			  $("#ifupi").hide();
			  $("#ifskrill").hide();
			  $("#iflocalbank").hide();
			  $("#ifpayfast").hide();
			  $("#ifpaypal").hide();
			  $("#ifstripe").hide();
			  $("#ifcrypto").hide();
			  
			}
			else if ($("#withdrawal-localbank").is(":checked"))
			{
			   $("#iflocalbank").show();
			   $("#ifpaytm").hide();
			   $("#ifupi").hide();
			   $("#ifskrill").hide();
			   $("#ifpayfast").hide();
			   $("#ifpaypal").hide();
			   $("#ifstripe").hide();
			   $("#ifpaystack").hide();
			   $("#ifcrypto").hide();
			}
			else if ($("#withdrawal-payfast").is(":checked"))
			{
			  $("#ifpayfast").show();
			  $("#ifpaytm").hide();
			  $("#ifupi").hide();
			  $("#ifskrill").hide();
			  $("#ifpaystack").hide();
			  $("#iflocalbank").hide();
			  $("#ifpaypal").hide();
			  $("#ifstripe").hide();
			  $("#ifcrypto").hide();
			  
			}
			else if ($("#withdrawal-paytm").is(":checked"))
			{
			  $("#ifpaytm").show();
			  $("#ifupi").hide();
			  $("#ifskrill").hide();
			  $("#ifpayfast").hide();
			  $("#ifpaypal").hide();
			  $("#ifstripe").hide();
			  $("#ifpaystack").hide();
			  $("#iflocalbank").hide();
			  $("#ifcrypto").hide();
			  
			}
			else if ($("#withdrawal-UPI").is(":checked"))
			{
			  $("#ifupi").show();
			  $("#ifskrill").hide();
			  $("#ifpaytm").hide();
              $("#ifpayfast").hide();
			  $("#ifpaypal").hide();
			  $("#ifstripe").hide();
			  $("#ifpaystack").hide();
			  $("#iflocalbank").hide();
			  $("#ifcrypto").hide();
			}
			else if ($("#withdrawal-skrill").is(":checked"))
			{
			  $("#ifskrill").show();
			  $("#ifpaytm").hide();
              $("#ifupi").hide();
              $("#ifpayfast").hide();
			  $("#ifpaypal").hide();
			  $("#ifstripe").hide();
			  $("#ifpaystack").hide();
			  $("#iflocalbank").hide();
			  $("#ifcrypto").hide();
			  
			}
			else if ($("#withdrawal-crypto").is(":checked"))
			{
			  $("#ifcrypto").show();
			  $("#ifskrill").hide();
			  $("#ifpaytm").hide();
              $("#ifupi").hide();
              $("#ifpayfast").hide();
			  $("#ifpaypal").hide();
			  $("#ifstripe").hide();
			  $("#ifpaystack").hide();
			  $("#iflocalbank").hide();
			  
			}
			else
			{
			$("#ifpaypal").hide();
			$("#ifstripe").hide();
			$("#ifpaystack").hide();
			$("#iflocalbank").hide();
			$("#ifpayfast").hide();
			$("#ifpaytm").hide();
            $("#ifupi").hide();
            $("#ifskrill").hide();
			$("#ifcrypto").hide();
			}
		});
    });
</script>
<!--- common code -->
<?php if($view_name == 'checkout'): ?>
<!-- stripe code -->
<?php if(!empty($stripe_publish)): ?>
<script src="https://js.stripe.com/v3/"></script>
<?php if($stripe_type == 'intents'): ?>
<script type="text/javascript">
$(document).ready(function(){
'use strict';
		$("#ifYes").hide();
        $('#stripe').click(function(){
            var value = "stripe";
            $("input[name=payment_method][value=" + value + "]").prop('checked', true);
		
            if ($("#opt1-stripe").is(":checked")) {
                $("#ifYes").show();

} else {
                $("#ifYes").hide();
            }
        });
    });
</script>
<?php else: ?>
<script type="text/javascript">

	$(document).ready(function(){
        'use strict';
		$("#ifYes").hide();
        $('#paypal').click(function(){
            var value = "paypal";
            $("input[name=payment_method][value=" + value + "]").prop('checked', true);
        });
		
		$('#stripe').click(function(){
            var value = "stripe";
            $("input[name=payment_method][value=" + value + "]").prop('checked', true);
			if ($("#opt1-stripe").is(":checked")) {
                $("#ifYes").show();
				
				/* stripe code */
				
				var stripe = Stripe('<?php echo e($stripe_publish_key); ?>');
   
				var elements = stripe.elements();
					
				var style = {
				base: {
					color: '#32325d',
					lineHeight: '18px',
					fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
					fontSmoothing: 'antialiased',
					fontSize: '14px',
					'::placeholder': {
					color: '#aab7c4'
					}
				},
				invalid: {
					color: '#fa755a',
					iconColor: '#fa755a'
				}
				};
			 
				
				var card = elements.create('card', {style: style, hidePostalCode: true});
			 
				
				card.mount('#card-element');
			 
			   
				card.addEventListener('change', function(event) {
					var displayError = document.getElementById('card-errors');
					if (event.error) {
						displayError.textContent = event.error.message;
					} else {
						displayError.textContent = '';
					}
				});
			 
				
				var form = document.getElementById('checkout_form');
				form.addEventListener('submit', function(event) {
					/*event.preventDefault();*/
			        if ($("#opt1-stripe").is(":checked")) { event.preventDefault(); }
					stripe.createToken(card).then(function(result) {
					
						if (result.error) {
						
						var errorElement = document.getElementById('card-errors');
						errorElement.textContent = result.error.message;
						
						
						} else {
							
							document.querySelector('.token').value = result.token.id;
							 
							document.getElementById('checkout_form').submit();
						}
						/*document.querySelector('.token').value = result.token.id;
							 
							document.getElementById('checkout_form').submit();*/
						
					});
				});
							
						
			/* stripe code */	
				
				
				
            } else {
                $("#ifYes").hide();
            }
			
			
        });
	
	});
</script>
<?php endif; ?>
<?php endif; ?>
<script type="text/javascript">
$(document).ready(function(){
        'use strict';
		$('#wallet').click(function(){
            var value = "wallet";
            $("input[name=payment_method][value=" + value + "]").prop('checked', true);
        });
        
        $('#twocheckout').click(function(){
            var value = "twocheckout";
            $("input[name=payment_method][value=" + value + "]").prop('checked', true);
        });
		
		$('#paystack').click(function(){
            var value = "paystack";
            $("input[name=payment_method][value=" + value + "]").prop('checked', true);
        });
		
		$('#localbank').click(function(){
            var value = "localbank";
            $("input[name=payment_method][value=" + value + "]").prop('checked', true);
        });
		
		$('#offline').click(function(){
            var value = "offline";
            $("input[name=payment_method][value=" + value + "]").prop('checked', true);
        });
		
		$('#razorpay').click(function(){
            var value = "razorpay";
            $("input[name=payment_method][value=" + value + "]").prop('checked', true);
        });
		
		$('#payhere').click(function(){
            var value = "payhere";
            $("input[name=payment_method][value=" + value + "]").prop('checked', true);
        });
		
		$('#payumoney').click(function(){
            var value = "payumoney";
            $("input[name=payment_method][value=" + value + "]").prop('checked', true);
        });
		
		$('#iyzico').click(function(){
            var value = "iyzico";
            $("input[name=payment_method][value=" + value + "]").prop('checked', true);
        });
		
		$('#flutterwave').click(function(){
            var value = "flutterwave";
            $("input[name=payment_method][value=" + value + "]").prop('checked', true);
        });
		
		$('#coingate').click(function(){
            var value = "coingate";
            $("input[name=payment_method][value=" + value + "]").prop('checked', true);
        });
		
		$('#ipay').click(function(){
            var value = "ipay";
            $("input[name=payment_method][value=" + value + "]").prop('checked', true);
        });
		
		$('#payfast').click(function(){
            var value = "payfast";
            $("input[name=payment_method][value=" + value + "]").prop('checked', true);
        });
		
		$('#coinpayments').click(function(){
            var value = "coinpayments";
            $("input[name=payment_method][value=" + value + "]").prop('checked', true);
        });
		
		$('#payhere').click(function(){
            var value = "payhere";
            $("input[name=payment_method][value=" + value + "]").prop('checked', true);
        });
		
		$('#payfast').click(function(){
            var value = "payfast";
            $("input[name=payment_method][value=" + value + "]").prop('checked', true);
        });
		
		$('#flutterwave').click(function(){
            var value = "flutterwave";
            $("input[name=payment_method][value=" + value + "]").prop('checked', true);
        });
		$('#mercadopago').click(function(){
            var value = "mercadopago";
            $("input[name=payment_method][value=" + value + "]").prop('checked', true);
        });
		$('#coinbase').click(function(){
            var value = "coinbase";
            $("input[name=payment_method][value=" + value + "]").prop('checked', true);
        });
		$('#cashfree').click(function(){
            var value = "cashfree";
            $("input[name=payment_method][value=" + value + "]").prop('checked', true);
        });
		$('#nowpayments').click(function(){
            var value = "nowpayments";
            $("input[name=payment_method][value=" + value + "]").prop('checked', true);
        });
		$('#uddoktapay').click(function(){
            var value = "uddoktapay";
            $("input[name=payment_method][value=" + value + "]").prop('checked', true);
        });
});		
</script>
<?php /*?><script>
$(function () {
$("#ifYes").hide();
        $("input[name='payment_method']").click(function () {
		
            if ($("#opt1-stripe").is(":checked")) {
                $("#ifYes").show();
				
				
				
				var stripe = Stripe('{{ $stripe_publish_key }}');
   
				var elements = stripe.elements();
					
				var style = {
				base: {
					color: '#32325d',
					lineHeight: '18px',
					fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
					fontSmoothing: 'antialiased',
					fontSize: '14px',
					'::placeholder': {
					color: '#aab7c4'
					}
				},
				invalid: {
					color: '#fa755a',
					iconColor: '#fa755a'
				}
				};
			 
				
				var card = elements.create('card', {style: style, hidePostalCode: true});
			 
				
				card.mount('#card-element');
			 
			   
				card.addEventListener('change', function(event) {
					var displayError = document.getElementById('card-errors');
					if (event.error) {
						displayError.textContent = event.error.message;
					} else {
						displayError.textContent = '';
					}
				});
			 
				
				var form = document.getElementById('checkout_form');
				form.addEventListener('submit', function(event) {
					
			        if ($("#opt1-stripe").is(":checked")) { event.preventDefault(); }
					stripe.createToken(card).then(function(result) {
					
						if (result.error) {
						
						var errorElement = document.getElementById('card-errors');
						errorElement.textContent = result.error.message;
						
						
						} else {
							
							document.querySelector('.token').value = result.token.id;
							 
							document.getElementById('checkout_form').submit();
						}
						
						
					});
				});
							
						
			
				
				
				
            } else {
                $("#ifYes").hide();
            }
        });
    });
	

</script><?php */?>
<!-- stripe code -->
<?php endif; ?>
<!-- cookie -->
<script type="text/javascript" src="<?php echo e(asset('resources/views/theme/cookie/cookiealert.js')); ?>"></script>
<!-- cookie -->
<!-- loading gif code -->
<?php if($allsettings->site_loader_display == 1): ?>
<script type='text/javascript' src="<?php echo e(URL::to('resources/views/theme/loader/jquery.LoadingBox.js')); ?>"></script>
<script>
    $(function(){
        var lb = new $.LoadingBox({loadingImageSrc: "<?php echo e(url('/')); ?>/public/storage/settings/<?php echo e($allsettings->site_loader_image); ?>",});

        setTimeout(function(){
            lb.close();
        }, 1000);
    });
</script>
<?php endif; ?>
<!-- loading gif code -->
<!-- animation code -->
<script src="<?php echo e(URL::to('resources/views/theme/animate/aos.js')); ?>"></script>
<script>
      AOS.init({
        easing: 'ease-in-out-sine'
      });
</script>
<!-- animation code -->
<?php if($allsettings->google_analytics != ""): ?>
<!-- Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=<?php echo e($allsettings->google_analytics); ?>"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', '<?php echo e($allsettings->google_analytics); ?>');
</script>
<!-- End Google Analytics -->
<?php endif; ?>
<?php if($allsettings->site_tawk_chat != ""): ?>
<script type="text/javascript">
var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
(function(){
var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
s1.async=true;
s1.src='<?php echo e($allsettings->site_tawk_chat); ?>';
s1.charset='UTF-8';
s1.setAttribute('crossorigin','*');
s0.parentNode.insertBefore(s1,s0);
})();
</script>
<?php endif; ?>
<script src="<?php echo e(URL::to('resources/views/admin/template/vendors/datatables.net/js/jquery.dataTables.min.js')); ?>"></script>
<script src="<?php echo e(URL::to('resources/views/admin/template/vendors/datatables.net-bs4/js/dataTables.bootstrap4.min.js')); ?>"></script>
<script src="<?php echo e(URL::to('resources/views/admin/template/vendors/datatables.net-buttons/js/dataTables.buttons.min.js')); ?>"></script>
<script src="<?php echo e(URL::to('resources/views/admin/template/vendors/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js')); ?>"></script>
<script src="<?php echo e(URL::to('resources/views/admin/template/vendors/datatables.net-buttons/js/buttons.html5.min.js')); ?>"></script>
<script src="<?php echo e(URL::to('resources/views/admin/template/vendors/datatables.net-buttons/js/buttons.print.min.js')); ?>"></script>
<script src="<?php echo e(URL::to('resources/views/admin/template/vendors/datatables.net-buttons/js/buttons.colVis.min.js')); ?>"></script>
<script src="<?php echo e(URL::to('resources/views/admin/template/assets/js/init-scripts/data-table/datatables-init.js')); ?>"></script>

<link rel="stylesheet" type="text/css" href="<?php echo e(URL::to('resources/views/admin/template/assets/css/datatables.css')); ?>">
<script type="text/javascript" charset="utf8" src="<?php echo e(URL::to('resources/views/admin/template/assets/js/datatables.js')); ?>"></script>
<script type="text/javascript">
$('#example').dataTable( {
  
  pageLength: 50,
   responsive: true
} );
</script>
<?php if($custom_settings->shop_search_type == 'ajax'): ?>
<script src="<?php echo e(asset('resources/views/theme/filter/jplist.core.min.js')); ?>"></script>
<script src="<?php echo e(asset('resources/views/theme/filter/jplist.sort-bundle.min.js')); ?>"></script>
<script src="<?php echo e(asset('resources/views/theme/filter/jplist.sort-buttons.min.js')); ?>"></script>
<script src="<?php echo e(asset('resources/views/theme/filter/jplist.textbox-filter.min.js')); ?>"></script>
<script src="<?php echo e(asset('resources/views/theme/filter/jplist.filter-toggle-bundle.min.js')); ?>"></script>
<script src="<?php echo e(asset('resources/views/theme/filter/jplist.pagination-bundle.min.js')); ?>"></script>
<script src="<?php echo e(asset('resources/views/theme/filter/jplist.filter-dropdown-bundle.min.js')); ?>"></script>
<script type="text/javascript">
        $('document').ready(function(){

            $('#demo').jplist({
                itemsBox: '.list'
                ,itemPath: '.list-item'
                ,panelPath: '.jplist-panel'

            });
        });
</script>
<?php if(!empty($minprice_count) && !empty($maxprice_count)): ?> 
<script type="text/javascript">
  function showProducts(minPrice, maxPrice) 
  {
    $(".items .list-item").hide().filter(function() 
	{
        var price = parseInt($(this).data("price"), 10);
        return price >= minPrice && price <= maxPrice;
    }).show();
  }

$(function() 
{
    var options = 
	{
        range: true,
        min: <?php echo e($allsettings->site_range_min_price); ?>,
        max: <?php echo e($allsettings->site_range_max_price); ?>,
        values: [<?php echo e($allsettings->site_range_min_price); ?>, <?php echo e($allsettings->site_range_max_price); ?>],
        slide: function(event, ui) {
            var min = ui.values[0],
                max = ui.values[1];

            $("#amount").val("<?php echo e($allsettings->site_currency_symbol); ?> " + min + " - <?php echo e($allsettings->site_currency_symbol); ?> " + max);
            showProducts(min, max);
       }
    }, min, max;

    $("#slider-range").slider(options);

    min = $("#slider-range").slider("values", 0);
    max = $("#slider-range").slider("values", 1);

    $("#amount").val("<?php echo e($allsettings->site_currency_symbol); ?> " + min + " - <?php echo e($allsettings->site_currency_symbol); ?> " + max);

    showProducts(min, max);
});
</script>
<?php endif; ?>
<?php endif; ?>
<?php if($custom_settings->disable_view_source == 0): ?>
<script type="text/javascript">
$(document).ready(function(){
     $(document).bind("contextmenu",function(e){
        return false;
    });
	
});
document.onkeydown = function(e) {
        if (e.ctrlKey && 
            (e.keyCode === 67 || 
             e.keyCode === 86 || 
             e.keyCode === 85 || 
			 e.keyCode === 73 ||
             e.keyCode === 117)) {
            return false;
        }
		else if(e.keyCode == 123) {
            return false;
        }
		else {
            return true;
        }
};
$(document).keypress("u",function(e) {
  if(e.ctrlKey)
  {
return false;
}
else
{
return true;
}
});
</script>
<?php endif; ?><?php /**PATH /home/arixmyii/bittoz.shop/public_html/resources/views/script.blade.php ENDPATH**/ ?>