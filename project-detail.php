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
				// Pages - Project Detail folder
				include("./pages/project/project-details/functions/get_values.php");
				include("./pages/project/sameparts/functions/get_values.php");
				include("./pages/project/sameparts/inner-banner.php");
				include("./pages/project/project-details/page-details.php");
				// Sameparts Folder
				include("./sameparts/footer.php");
				include("./sameparts/scroll-top-button.php");
			?>
		</div>
		<?php include("./tools/scripts.php"); ?>
	</body>
</html>