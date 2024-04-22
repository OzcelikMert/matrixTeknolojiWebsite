<!DOCTYPE html>
<html lang="tr">
	<head>
		<?php 
			include("./tools/metas.php");
			include("./tools/links.php");
			include("./sameparts/languages/language.php");
		?>
		<title>Matrix Teknoloji - Projeler</title>	
	</head>

	<body>
		<div class="main-page-wrapper">
			<?php 
				// Sameparts Folder
				include("./sameparts/pre-loader.php");
				include("./sameparts/header-other.php");
				// Pages - Project folder
				include("./pages/project/projects/functions/get_values.php");
				include("./pages/project/sameparts/functions/get_values.php");
				include("./pages/project/sameparts/inner-banner.php");
				include("./pages/project/projects/page-details.php");
				// Sameparts Folder
				include("./sameparts/functions/get_social_media_values.php");
				include("./sameparts/footer.php");
				include("./sameparts/scroll-top-button.php");
			?>	
		</div>
		<?php include("./tools/scripts.php"); ?>
	</body>
</html>