<script src="{{ URL::to('resources/views/admin/template/vendors/jquery/dist/jquery.min.js') }}"></script>
<script src="{{ URL::to('resources/views/admin/template/vendors/popper.js/dist/umd/popper.min.js') }}"></script>
<script src="{{ URL::to('resources/views/admin/template/vendors/bootstrap/dist/js/bootstrap.min.js') }}"></script>
<script src="{{ URL::to('resources/views/admin/template/assets/js/main.js') }}"></script>
<script src="{{ URL::to('resources/views/admin/template/assets/js/jquery.min.js') }}"></script>
<script src="{{ URL::to('resources/views/admin/template/vendors/chart.js/dist/Chart.bundle.min.js') }}"></script>
<!--<script src="{{ URL::to('resources/views/admin/template/assets/js/init-scripts/chart-js/chartjs-init.js') }}"></script>-->
<script src="{{ URL::to('resources/views/admin/template/assets/js/dashboard.js') }}"></script>
<script src="{{ URL::to('resources/views/admin/template/assets/js/widgets.js') }}"></script>
<script src="{{ URL::to('resources/views/admin/template/vendors/jqvmap/dist/jquery.vmap.min.js') }}"></script>
<script src="{{ URL::to('resources/views/admin/template/vendors/jqvmap/examples/js/jquery.vmap.sampledata.js') }}"></script>
<script src="{{ URL::to('resources/views/admin/template/vendors/jqvmap/dist/maps/jquery.vmap.world.js') }}"></script>
<script>
        (function($) {
            "use strict";

            jQuery('#vmap').vectorMap({
                map: 'world_en',
                backgroundColor: null,
                color: '#ffffff',
                hoverOpacity: 0.7,
                selectedColor: '#1de9b6',
                enableZoom: true,
                showTooltip: true,
                values: sample_data,
                scaleColors: ['#1de9b6', '#03a9f5'],
                normalizeFunction: 'polynomial'
            });
        })(jQuery);
</script>
<script src="{{ URL::to('resources/views/admin/template/vendors/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ URL::to('resources/views/admin/template/vendors/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ URL::to('resources/views/admin/template/vendors/datatables.net-buttons/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ URL::to('resources/views/admin/template/vendors/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js') }}"></script>
<script src="{{ URL::to('resources/views/admin/template/vendors/jszip/dist/jszip.min.js') }}"></script>
<script src="{{ URL::to('resources/views/admin/template/vendors/pdfmake/build/pdfmake.min.js') }}"></script>
<script src="{{ URL::to('resources/views/admin/template/vendors/pdfmake/build/vfs_fonts.js') }}"></script>
<script src="{{ URL::to('resources/views/admin/template/vendors/datatables.net-buttons/js/buttons.html5.min.js') }}"></script>
<script src="{{ URL::to('resources/views/admin/template/vendors/datatables.net-buttons/js/buttons.print.min.js') }}"></script>
<script src="{{ URL::to('resources/views/admin/template/vendors/datatables.net-buttons/js/buttons.colVis.min.js') }}"></script>
<script src="{{ URL::to('resources/views/admin/template/assets/js/init-scripts/data-table/datatables-init.js') }}"></script>
<link rel="stylesheet" type="text/css" href="{{ URL::to('resources/views/admin/template/assets/css/datatables.css') }}">
<script type="text/javascript" charset="utf8" src="{{ URL::to('resources/views/admin/template/assets/js/datatables.js') }}"></script>

<script src="{{url('vendor/tinymce/jquery.tinymce.min.js')}}"></script>
<script src="{{url('vendor/tinymce/tinymce.min.js')}}"></script>
<script>
  tinymce.init({
    
	selector: '#summary-ckeditor', 
    
		plugins : 'advlist anchor autolinkcharmap code colorpicker contextmenu fullscreen hr image insertdatetime link lists media pagebreak preview print searchreplace tabfocus table textcolor',
	toolbar: [
		'newdocument | print preview | searchreplace | undo redo | link unlink anchor image media | alignleft aligncenter alignright alignjustify | code',
		'formatselect fontselect fontsizeselect | bold italic underline strikethrough | forecolor backcolor',
		'removeformat | hr pagebreak | charmap subscript superscript insertdatetime | bullist numlist | outdent indent blockquote | table'
	],
	menubar : false,
	browser_spellcheck : true,
	branding: false,
	width: '100%',
	height : "480"
    
 
  
  });

</script>
<script src="{{ URL::to('resources/views/theme/validate/jquery.bvalidator.min.js') }}"></script>
<script src="{{ URL::to('resources/views/theme/validate/themes/presenters/default.min.js') }}"></script>
<script src="{{ URL::to('resources/views/theme/validate/themes/red/red.js') }}"></script>
<link href="{{ URL::to('resources/views/theme/validate/themes/red/red.css') }}" rel="stylesheet" />
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

    $('#item_form').bValidator(options);
	$('#profile_form').bValidator(options);
	$('#comment_form').bValidator(options);
	$('#support_form').bValidator(options);
	$('#order_form').bValidator(options);
	$('#checkout_form').bValidator(options);
	$('#setting_form').bValidator(options);
	$('#category_form').bValidator(options);
    });
	$(function () {
	    /*$("#ifseo").hide(); */
        $("#product_allow_seo").change(function () {
            if ($(this).val() == "1") {
                $("#ifseo").show();
            } else {
                $("#ifseo").hide();
            }
        });
		$("#page_allow_seo").change(function () {
            if ($(this).val() == "1") {
                $("#ifseo").show();
            } else {
                $("#ifseo").hide();
            }
        });
		$("#post_allow_seo").change(function () {
            if ($(this).val() == "1") {
                $("#ifseo").show();
            } else {
                $("#ifseo").hide();
            }
        });	
		$("#category_allow_seo").change(function () {
            if ($(this).val() == "1") {
                $("#ifseo").show();
            } else {
                $("#ifseo").hide();
            }
        });	
    });
	$(function () {
	    $("#watermark_repeat").change(function () {
		
		    if ($(this).val() == "0") 
			{
                
				$("#ifwatermark").show();
				
            }
			else
			{
			   $("#ifwatermark").hide();
			}
		
		});
		$('#subscr_item_level').on('change', function() {
		  if ( this.value == 'limited')
		  
		  {
			$("#limit_item").show();
			
		  }
		  
		  else
		  {
			$("#limit_item").hide();
		  }
		});
		$('#m_mode_background').on('change', function() {
		  if ( this.value == 'color')
		  
		  {
			$("#m_mode_color").show();
			$("#m_mode_image").hide();
		  }
		  
		  else
		  {
			$("#m_mode_color").hide();
			$("#m_mode_image").show();
			
		  }
		});
		$('#product_file_type1').on('change', function() {
		  if ( this.value == 'file')
		  {
			$("#main_file").show();
			$("#main_link").hide();
			
			
		  }
		  else if(this.value == 'link')
		  {
			$("#main_file").hide();
			$("#main_link").show();
			
		  }
		  else
		  {
			$("#main_file").hide();
			$("#main_link").hide();
			
		  }
        });
		$('#product_free').on('change', function() {
			  if ( this.value == '0')
			  {
				
				
				$("#subscription_box").show();
			  }
			  else
			  {
				
				
				$("#subscription_box").hide();
				
			  }
         });
		$("#per_sale_referral_commission_type").change(function () {
            if ($(this).val() == "fixed") {
                $("#nfixed").show();
				$("#npercentage").hide();
            } else {
                $("#npercentage").show();
				$("#nfixed").hide();
            }
        });	
		
    });
</script>
@if($view_name == 'admin-add-voucher-code')
<script type="text/javascript" src="{{ URL::to('resources/views/admin/template/picker/jquery-ui.min.js') }}"></script>
<script type="text/javascript" src="{{ URL::to('resources/views/admin/template/picker/jquery-ui-timepicker-addon.js') }}"></script>
<script type="text/javascript">
$(document).ready(function(){
  $("#event_start_date_time").datetimepicker({
    timeFormat: "hh:mm tt", minDate: 0, dateFormat: 'dd-M-yy',
    onSelect: function (selected) {
      var dt = new Date(selected);
      dt.setDate(dt.getDate() + 1);
 $("#event_end_date_time").datetimepicker("option", "minDate", dt);
}                                 
});
  
});
</script>
@endif
<script type="text/javascript">
$(document).ready(function(){
    $('#select_all').on('click',function(){
        if(this.checked){
            $('.checkbox').each(function(){
                this.checked = true;
            });
        }else{
             $('.checkbox').each(function(){
                this.checked = false;
            });
        }
    });
    
    $('.checkbox').on('click',function(){
        if($('.checkbox:checked').length == $('.checkbox').length){
            $('#select_all').prop('checked',true);
        }else{
            $('#select_all').prop('checked',false);
        }
    });
});
</script>
@if($view_name == 'admin-general-settings' || $view_name == 'admin-add-coupon' || $view_name == 'admin-edit-coupon')
<script type="text/javascript" src="{{ URL::to('resources/views/admin/template/datepicker/picker.js') }}"></script>
<script>
  $( function() {
    $( "#site_flash_end_date" ).datepicker({ minDate: 0, dateFormat: 'yy-mm-dd' });
	$( "#site_free_end_date" ).datepicker({ minDate: 0, dateFormat: 'yy-mm-dd' });
  } );
</script>
@endif
<script src="{{ URL::to('resources/views/admin/template/dropzone/min/dropzone.min.js')}}" type="text/javascript"></script>