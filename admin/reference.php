<!DOCTYPE html>
<html>
<head>
<title>Reference</title>
	<?php
        include("./tools/base.php");
        include('./tools/includes.php');
		include('./tools/metas.php');
		include('./tools/links.php');
	?>
    <style>
    @media only screen and (max-width: 765px){
        .responsive-mt-5{
            margin-top: 5px;
        }
    }
    .hover-link:hover{
        text-decoration: underline;
    }
    </style>
    <link rel="stylesheet" type="text/css" href="./admin/assets/plugins/SweetAlert/sweetalert2.css"/>
</head>
<body>
<?php
    include('../sameparts/pre-loader.php');
    include("./pages/reference/functions/get_values.php");
    include("./pages/reference/functions/add_reference.php");
	include('./sameparts/header.php');
	include('./sameparts/sidebar.php');
?>
	<div class="main-container">
		<div class="pd-ltr-20 height-100-p xs-pd-20-10">
            <div class="pd-20 bg-white border-radius-4 box-shadow mb-30">
	            <div class="clearfix">
	            	<div class="pull-left">
	            		<h4 class="text-blue">Add Reference</h4>
	            	</div>
	            </div>
                <?php
                    echo $ErrorMessage_show;
                    include("./pages/reference/form.php");
                    include("./pages/reference/references.php");
                ?>
            </div>    
			<?php 
                // Footer
			    include('./sameparts/footer.php'); 
			?>
		</div>
	</div>

    <?php include('./tools/scripts.php'); ?>
<script src="./admin/assets/plugins/SweetAlert/sweetalert2.all.js"></script>
<script>
    // Delete Reference
    function deleteReference(referenceID){
		var reference_title = $("#reference_"+ referenceID).attr("reference-title");
        Swal.fire({
            title: 'Are you sure?',
            text: "You want to delete \'"+reference_title+"\'?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'No, cancel!',
            confirmButtonClass: 'btn btn-success margin-5',
            cancelButtonClass: 'btn btn-danger margin-5',
            buttonsStyling: false
        }).then(function (dismiss) {
            if (referenceID != "" && referenceID > 0 && dismiss.value) {
				// OKAY
				$.ajax ({
            		url: "./admin/pages/reference/functions/delete_reference.php",
            		method: "POST",
            		data: { referenceid: referenceID },
            		success: function(data_msg){
						// OKAY MESSAGE
						var data_message = $.parseJSON(data_msg);
						if(data_message.type != "error"){
							$("#reference_"+ referenceID).remove();
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

    // Update Reference
    function updateReference(referenceID){
        var reference_title = $("#reference_"+ referenceID).attr("reference-title");
        var reference_image = $("#reference_"+ referenceID).attr("reference-image");
        Swal.fire({
          title: 'Change Reference',
          html: '<img src="./images/reference/' + reference_image + '" alt="' + reference_title + '" height="150" style="width:50%;">',
          input: 'text',
          inputAttributes: {
            autocapitalize: 'off'
          },
          inputPlaceholder: "New Reference Title",
          inputValue: reference_title,
          showCancelButton: true,
          confirmButtonText: 'Update',
          showLoaderOnConfirm: true,
          preConfirm: function (referenceTitle) {
                // Reference Name Control
                return new Promise(function (resolve){
                $.ajax ({
            		url: "./admin/pages/reference/functions/update_reference.php",
            		method: "POST",
            		data: { referenceid: referenceID, referencetitle: referenceTitle },
            		success: function(data_msg){
                        // OKAY MESSAGE
						var data_message = $.parseJSON(data_msg);
                        console.log(data_message);
						if(data_message.type == "error"){
                            Swal.showValidationMessage(
                                data_message.title+": "+data_message.comment
                            )
                            resolve(true);
						}else{
                            $("#reference_"+referenceID+"_name").html(referenceTitle);
                            $("#reference_"+ referenceID).attr("reference-title", referenceTitle);
						    Swal.fire(
						    	data_message.title,
						    	data_message.comment,
						    	data_message.type
                            )
                        }
            		}
                })
            })
            // end Reference Name Control
          },
          allowOutsideClick: false
        });
    }

    // Selected Image and Change Label Text
    $("#customFile").change(function (){
       var fileName = $(this).val();
       $("#selectedImageName").html("Image Name: " + fileName);
       $("#reference_logo").val(fileName);
    });
</script>
</body>
</html>