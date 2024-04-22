<!DOCTYPE html>
<html>
<head>
<title>Show Projects</title>
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
    include("./pages/project/add_project/functions/create_project.php");
    include("./pages/project/show_projects/functions/get_values.php");
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
                                    // Projects
                                    include("./pages/project/show_projects/projects.php");
                                    // Project Count Buttons
                                    include("./pages/project/show_projects/project_count_buttons.php");
                                ?>
                            </div>
                            <?php
                                // Project Categories
                                include("./pages/project/show_projects/categories.php");
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
<!-- Project Delete -->
<script>
 function ProjectDelete(ProjectID){
    var project_name = $("#Project_"+ ProjectID).attr("project-title");
    Swal.fire({
        title: 'Are you sure?',
        text: "You want to delete \'"+project_name+"\'?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'No, cancel!',
        confirmButtonClass: 'btn btn-success margin-5',
        cancelButtonClass: 'btn btn-danger margin-5',
        buttonsStyling: false
    }).then(function (dismiss) {
        if (ProjectID != "" && ProjectID > 0 && dismiss.value) {
			// OKAY
			$.ajax ({
        		url: "./admin/pages/project/show_projects/functions/delete_project.php",
        		method: "POST",
        		data: { project_id: ProjectID },
        		success: function(data_msg){
					// OKAY MESSAGE
					var data_message = $.parseJSON(data_msg);
					if(data_message.type == "success"){
						$("#Project_"+ ProjectID).remove();
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