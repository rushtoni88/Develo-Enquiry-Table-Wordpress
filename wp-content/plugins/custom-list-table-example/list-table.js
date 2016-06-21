jQuery('.status').on( 'change', function ajaxSubmit() {
	
	alert("IT WORKED!");
		
		$.ajax({

        type: "POST",

        url: "/wp-admin/admin-ajax.php",

        data: newCustomaerForm,

        success: function() {

            jQuery

        }
		
	})
});