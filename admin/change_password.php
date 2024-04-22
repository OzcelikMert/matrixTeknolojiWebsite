<!DOCTYPE html>
<html>
<head>
<title>Change Password</title>
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
    include("./pages/settings/change_password/functions/update_password.php");
	include('./sameparts/header.php');
	include('./sameparts/sidebar.php');
?>
	<div class="main-container">
		<div class="pd-ltr-20 height-100-p xs-pd-20-10">
            <div class="pd-20 bg-white border-radius-4 box-shadow mb-30">
	            <div class="clearfix">
	            	<div class="pull-left">
	            		<h4 class="text-blue">Change Password</h4>
	            	</div>
	            </div>
                <?php 
                    echo $ErrorMessage_show;
                    include("./pages/settings/change_password/form.php");
                ?>
            </div>    
			<?php 
                // Footer
			    include('./sameparts/footer.php'); 
			?>
		</div>
	</div>

	<?php include('./tools/scripts.php'); ?>
    <script>
    function equalPassword(){
        var password_1 = $("#newpassword").val();
        var password_2 = $("#newpassword_2").val();
        if(password_2 != password_1){
            $("#errorMessage").css("display", "block");
            $("#changePassword_button").attr("disabled", true);
        }else{
            $("#errorMessage").css("display", "none");
            $("#changePassword_button").attr("disabled", false);
        }
    }
    </script>
</body>
</html>