<!DOCTYPE html>
<html>
<head>
<title>Show Users</title>
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
	include("./pages/users/show_users/functions/get_values.php");
	include('./sameparts/header.php');
	include('./sameparts/sidebar.php');
?>
<div class="main-container">
	<div class="pd-ltr-20 height-100-p xs-pd-20-10">
            <div class="container pd-0">
				<div class="contact-directory-list">
					<ul class="row">
						<?php echo $Accounts; ?>
					</ul>
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
<script>
	function ViewProfile(){
		$("#ViewSubmit").trigger();
	}
    function deleteAccount(accountID){
		var user_name = $("#user_"+ accountID).attr("user-name");
        Swal.fire({
            title: 'Are you sure?',
            text: "You want to delete \'"+user_name+"\'?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'No, cancel!',
            confirmButtonClass: 'btn btn-success margin-5',
            cancelButtonClass: 'btn btn-danger margin-5',
            buttonsStyling: false
        }).then(function (dismiss) {
            if (accountID != "" && accountID > 0 && dismiss.value) {
				// OKAY
				$.ajax ({
            		url: "./admin/pages/users/show_users/functions/delete_account.php",
            		method: "POST",
            		data: { accountid: accountID },
            		success: function(data_msg){
						// OKAY MESSAGE
						var data_message = $.parseJSON(data_msg);
						if(data_message.type != "error"){
							$("#user_"+ accountID).remove();
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