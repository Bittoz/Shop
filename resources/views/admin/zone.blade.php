@php
if($demo_mode == 'on'){ $upsizier = 1; } else { $upsizier = 10000; }
@endphp
<script>
    var CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').getAttribute("content");

    Dropzone.autoDiscover = false;
    var myDropzone = new Dropzone(".dropzone",{ 
        maxFilesize: {{ $upsizier }},  // 1000 mb
        acceptedFiles: ".jpeg,.jpg,.png,.zip",
		/*maxFiles: 1,*/
		/*addRemoveLinks: true,*/
    });
    myDropzone.on("sending", function(file, xhr, formData) {
	   
       formData.append("_token", CSRF_TOKEN);
	   
	   
         
    }); 
	myDropzone.on("error", function(file, response) {
    console.log(response);
});

// on success
myDropzone.on("success", function(file, response) {
    // get response from successful ajax request
    $('#hide_message').hide();
	$('#display_message').html(response.record);
	$('#product_file_link1').val('');
	$("#product_file_type1 option[value='']").attr('selected', true)
    // submit the form after images upload
    // (if u want yo submit rest of the inputs in the form)
    //document.getElementById("dropzone-form").submit();
});
</script>