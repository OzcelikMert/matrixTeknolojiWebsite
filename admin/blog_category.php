<!DOCTYPE html>
<html>
<head>
<title>Blog Category</title>
	<?php
        include("./tools/base.php");
        include('./tools/includes.php');
		include('./tools/metas.php');
		include('./tools/links.php');
	?>
    <style>
    @media only screen and (max-width: 765px){
        .align_right_btn_mobile{
            text-align:right;
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
    include("./pages/categories/blog/functions/add_category.php");
	include("./pages/categories/blog/functions/get_values.php");
	include('./sameparts/header.php');
	include('./sameparts/sidebar.php');
?>
	<div class="main-container">
		<div class="pd-ltr-20 height-100-p xs-pd-20-10">
            <div class="pd-20 bg-white border-radius-4 box-shadow mb-30">
	            <div class="clearfix">
	            	<div class="pull-left">
	            		<h4 class="text-blue">Blog Category</h4>
	            	</div>
	            </div>
                <?php 
                    echo $ErrorMessage_show;
                    include("./pages/categories/blog/form.php");
                    include("./pages/categories/blog/categories.php");
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
    // Delete Category
    function deleteCategory(categoryID){
		var category_name = $("#category_"+ categoryID).attr("category-name");
        Swal.fire({
            title: 'Are you sure?',
            text: "You want to delete \'"+category_name+"\'?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'No, cancel!',
            confirmButtonClass: 'btn btn-success margin-5',
            cancelButtonClass: 'btn btn-danger margin-5',
            buttonsStyling: false
        }).then(function (dismiss) {
            if (categoryID != "" && categoryID > 0 && dismiss.value) {
				// OKAY
				$.ajax ({
            		url: "./admin/pages/categories/blog/functions/delete_category.php",
            		method: "POST",
            		data: { categoryid: categoryID },
            		success: function(data_msg){
						// OKAY MESSAGE
						var data_message = $.parseJSON(data_msg);
						if(data_message.type != "error"){
							$("#category_"+ categoryID).remove();
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

    // Update Category
    function updateCategory(categoryID){
        var category_name = $("#category_"+ categoryID).attr("category-name");
        Swal.fire({
          title: 'Change Category Name',
          input: 'text',
          inputAttributes: {
            autocapitalize: 'off'
          },
          inputPlaceholder: "New Category Name",
          inputValue: category_name,
          showCancelButton: true,
          confirmButtonText: 'Update',
          showLoaderOnConfirm: true,
          preConfirm: function (categoryName) {
                //alert("Name: "+categoryName+"| Id: "+categoryID);
                // Category Name Control
                return new Promise(function (resolve){
                $.ajax ({
            		url: "./admin/pages/categories/blog/functions/update_category.php",
            		method: "POST",
            		data: { categoryid: categoryID, categoryname: categoryName },
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
                            $("#category_"+categoryID+"_name").html(categoryName);
                            $("#category_"+ categoryID).attr("category-name", categoryName);
						    Swal.fire(
						    	data_message.title,
						    	data_message.comment,
						    	data_message.type
                            )
                        }
            		}
                })
            })
            // end Category Name Control
          },
          allowOutsideClick: false
        });
    }
</script>
</body>
</html>