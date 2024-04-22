<!DOCTYPE html>
<html>
<head>
<title>Gallery</title>
	<?php
        include("./tools/base.php");
        include('./tools/includes.php');
		include('./tools/metas.php');
        include('./tools/links.php');
    ?>
    <link rel="stylesheet" type="text/css" href="./admin/assets/plugins/SweetAlert/sweetalert2.css"/>
</head>
<body>
<?php
    include('../sameparts/pre-loader.php');
    include("./pages/gallery/functions/get_values.php");
	include('./sameparts/header.php');
	include('./sameparts/sidebar.php');
?>
	<div class="main-container">
		<div class="pd-ltr-20 height-100-p xs-pd-20-10">
            <div class="min-height-200px">
	            <div class="gallery-wrap">
                    <?php 
                        // Images
                        include("./pages/gallery/images.php");
                    ?>
			    </div>
            </div>
			<?php 
                // Footer
			    include('./sameparts/footer.php'); 
			?>
		</div>
	</div>

    <?php include('./tools/scripts.php'); ?>
    <script src="./admin/assets/plugins/SweetAlert/sweetalert2.all.js"></script>
<!-- Image Delete -->
<script>
 function ImageDelete(ImageID){
    var Image_url = $("#Image_"+ ImageID).attr("image-url");
    Swal.fire({
        title: 'Are you sure?',
        text: "You want to delete \'"+Image_url+"\'?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'No, cancel!',
        confirmButtonClass: 'btn btn-success margin-5',
        cancelButtonClass: 'btn btn-danger margin-5',
        buttonsStyling: false
    }).then(function (dismiss) {
        if (ImageID != "" && ImageID > 0 && dismiss.value) {
			// OKAY
			$.ajax ({
        		url: "./admin/pages/gallery/functions/delete_image.php",
        		method: "POST",
        		data: {image_url: Image_url},
        		success: function(data_msg){
					// OKAY MESSAGE
					var data_message = $.parseJSON(data_msg);
					if(data_message.type == "success"){
						$("#Image_"+ ImageID).remove();
					}else if(data_message.type == "error-lp"){
                        setTimeout(
                            function() {
                                location.reload();
                        }, 2000);
                    }
					Swal.fire(
						data_message.title,
						data_message.comment,
						data_message.type
					)
        		}
			});
			// end OKAY
        }
    })
 }
</script>

</body>
</html>