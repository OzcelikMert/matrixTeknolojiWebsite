<!DOCTYPE html>
<html>
<head>
<title>Show Blogs</title>
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
    include("./pages/blog/add_blog/functions/create_blog.php");
    include("./pages/blog/show_blogs/functions/get_values.php");
	include('./sameparts/header.php');
	include('./sameparts/sidebar.php');
?>
	<div class="main-container">
		<div class="pd-ltr-20 height-100-p xs-pd-20-10">
            <div class="min-height-200px">
	            <div class="blog-wrap">
		            <div class="container pd-0">
			            <div class="row">
				            <div class="col-md-8 col-sm-12">
                                <?php 
                                    // Blogs
                                    include("./pages/blog/show_blogs/blogs.php");
                                    // Blog Count Buttons
                                    include("./pages/blog/show_blogs/blog_count_buttons.php");
                                ?>
                            </div>
                            <?php
                                // Blog Categories
                                include("./pages/blog/show_blogs/categories.php");
                            ?>
			            </div>
		            </div>
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
<!-- Blog Delete -->
<script>
 function BlogDelete(BlogID){
    var blog_name = $("#Blog_"+ BlogID).attr("blog-title");
    Swal.fire({
        title: 'Are you sure?',
        text: "You want to delete \'"+blog_name+"\'?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'No, cancel!',
        confirmButtonClass: 'btn btn-success margin-5',
        cancelButtonClass: 'btn btn-danger margin-5',
        buttonsStyling: false
    }).then(function (dismiss) {
        if (BlogID != "" && BlogID > 0 && dismiss.value) {
			// OKAY
			$.ajax ({
        		url: "./admin/pages/blog/show_blogs/functions/delete_blog.php",
        		method: "POST",
        		data: { blog_id: BlogID },
        		success: function(data_msg){
					// OKAY MESSAGE
					var data_message = $.parseJSON(data_msg);
					if(data_message.type == "success"){
						$("#Blog_"+ BlogID).remove();
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