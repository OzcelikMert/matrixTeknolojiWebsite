<!DOCTYPE html>
<html lang="tr">
	<head>
		<?php 
			include("./tools/metas.php");
			include("./tools/links.php");
			include("./sameparts/languages/language.php");
		?>
		<title>Matrix Teknoloji - Anasayfa</title>	
	</head>
	<body>
		<div class="main-page-wrapper">
		<?php 
			// Sameparts Folder
			include("./sameparts/pre-loader.php");
			include("./pages/index/functions/get_values.php");
			include("./sameparts/header-home.php");
			// Pages - Index folder
			include("./pages/index/slider.php");
			include("./pages/index/about.php");
			include("./pages/index/service.php");
			include("./pages/index/project.php");
			include("./pages/index/middle-banner.php");
			//include("./pages/index/team.php");
			//include("./pages/index/skill.php");
			//include("./pages/index/client.php");
			//include("./pages/index/pricing.php");
			include("./pages/index/blog.php");
			include("./pages/index/reference.php");
			include("./pages/index/contact.php");
			// Sameparts Folder
			include("./sameparts/functions/get_social_media_values.php");
			include("./sameparts/footer.php");
			include("./sameparts/scroll-top-button.php");
		?>	
		</div>
		<?php include("./tools/scripts.php"); ?>

		<!-- Follower Registration -->
		<script>
		// Register
		function FollowerRegister(){
			var email = $("#follower_email").val();
			if(CheckEmail(email)){
				$.ajax({
					url: "./pages/index/functions/register_follower.php",
					method: "POST",
					data: {email: email},
					success: function(result){
						if(result == "success"){
							$("#follower_Input").remove();
							$("#follower_SuccessMessage").css("display", "block");
						}else{
							$("#follower_email").css("border", "2px solid red");
							alert(result);
						}
					}
				});
			}else{
				$("#follower_email").css("border", "2px solid red");
			}
		}

		// Check Email
		function CheckEmail(email) {
  			var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
  			return regex.test(email);
		}
		</script>
	</body>
</html>