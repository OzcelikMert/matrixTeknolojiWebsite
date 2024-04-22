<!DOCTYPE html>
<html>
<head>
<title>Admin Panel</title>
	<?php
		include("./tools/base.php");
		include('./tools/metas.php');
		include('./tools/links.php');
	?>
</head>
<body>
	<?php
		include("../sameparts/pre-loader.php"); 
		$rand_image = rand(1, 3);
	?>
	<div class="login-wrap d-flex align-items-center flex-wrap justify-content-center pd-20" style="min-height: 100vh;background: url(./admin/assets/images/index/bg-<?php echo $rand_image; ?>.jpg); background-size: cover;">
		<div class="login-box box-shadow pd-30 border-radius-5" style="background-color: #ffffffde;">
			<!--img src="vendors/images/login-img.png" alt="login" class="login-img"-->
			<h2 class="text-center mb-30">Login</h2>
			<?php
				include("./pages/index/functions/login_control.php");
				include("./pages/index/form.php");
				echo $ErrorMessage_show;
			?>
		</div>
	</div>
	<?php include('./tools/scripts.php'); ?>
</body>
</html>