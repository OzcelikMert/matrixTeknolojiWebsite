<!DOCTYPE html>
<html>
<head>
<title>Dashboard</title>
	<?php
		include("./tools/base.php");
		include('./tools/includes.php');
		include('./tools/metas.php');
		include('./tools/links.php');
	?>
	<link rel="stylesheet" href="./admin/assets/vendors/styles/vendor.bundle.addons.css">
</head>
<body>
<?php
	include('../sameparts/pre-loader.php');
	include("./pages/dashboard/functions/get_values.php");
	include('./sameparts/header.php');
	include('./sameparts/sidebar.php');
?>
	<div class="main-container">
		<div class="pd-ltr-20 height-100-p xs-pd-20-10">
			<?php
				// sameparts/account_settings.php -> permission and all permissions
				if($permission < $Author){
					include("./pages/dashboard/charts.php");
				}
				include("./pages/dashboard/latest_blogs.php");
				include("./pages/dashboard/latest_projects.php");
				include("./pages/dashboard/latest_registereds.php");
				// Footer
				include('./sameparts/footer.php'); 
			?>
		</div>
	</div>

	<?php include('./tools/scripts.php'); ?>
	<script src="./admin/assets/vendors/scripts/vendor.bundle.addons.js"></script>
	<script src="./admin/assets/scripts/dashboard.js"></script>
	<script src="./admin/assets/plugins/fancybox/dist/jquery.fancybox.js"></script>
</body>
</html>