<!DOCTYPE html>
<html>
<head>
<title>Social Media</title>
	<?php
		include("./tools/base.php");
		include('./tools/includes.php');
		include('./tools/metas.php');
		include('./tools/links.php');
	?>
</head>
<body>
<?php
    include('../sameparts/pre-loader.php');
    include("./pages/contact_info/social_media/functions/save_social_media.php");
	include("./pages/contact_info/social_media/functions/get_values.php");
	include('./sameparts/header.php');
	include('./sameparts/sidebar.php');
?>
	<div class="main-container">
		<div class="pd-ltr-20 customscroll customscroll-10-p height-100-p xs-pd-20-10">
            <div class="pd-20 bg-white border-radius-4 box-shadow mb-30">
	            <div class="clearfix">
	            	<div class="pull-left">
	            		<h4 class="text-blue">Social Media</h4>
	            	</div>
	            </div>
                <?php 
                    echo $ErrorMessage_show;
                    include("./pages/contact_info/social_media/form.php");
                ?>
            </div>    
			<?php 
                // Footer
			    include('./sameparts/footer.php'); 
			?>
		</div>
	</div>

	<?php include('./tools/scripts.php'); ?>
</body>
</html>