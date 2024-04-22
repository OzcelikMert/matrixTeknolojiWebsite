<!DOCTYPE html>
<html>
<head>
<title>Profile</title>
	<?php
		include("./tools/base.php");
		include('./tools/includes.php');
		include('./tools/metas.php');
		include('./tools/links.php');
	?>
    <link href="./admin/assets/plugins/DarkRoomCroppie/darkroom.css" rel="stylesheet">

    <style>
        .profile-div{
            display: flex;
        }
        @media only screen and (max-width: 770px) {
        .profile-div{
            display: block;
            }
        }
    </style>
</head>
<body>
<?php
    include('../sameparts/pre-loader.php');
    include("./pages/profile/functions/update_profile.php");
	include('./sameparts/header.php');
	include('./sameparts/sidebar.php');
?>
	<div class="main-container">
		<div class="pd-ltr-20 height-100-p xs-pd-20-10">
        <div class="profile-div">
        <!-- Profile Image -->
            <div class="col-xl-3 col-lg-4 col-md-4 col-sm-12 mb-30">
	            <div class="pd-20 bg-white border-radius-4 box-shadow" style="height: 100%;">
                    <?php include("./pages/profile/image.php"); ?>
                </div>
            </div>
        <!-- Profile Values -->
            <div class="pd-20 bg-white border-radius-4 box-shadow mb-30" style="width: 100%;">
	            <div class="clearfix">
	            	<div class="pull-left">
	            		<h4 class="text-blue">Profile</h4>
	            	</div>
	            </div>
                <?php 
                    echo $ErrorMessage_show;
                    include("./pages/profile/form.php");
                ?>
            </div>
        </div>   
			<?php 
                // Footer
			    include('./sameparts/footer.php'); 
			?>
		</div>
	</div>

	<?php include('./tools/scripts.php'); ?>
    <script src="./admin/assets/plugins/DarkRoomCroppie/fabric.js"></script>
    <script src="./admin/assets/plugins/DarkRoomCroppie/darkroom.js"></script>
<!-- Cropper -->
<script>
    function OpenFileDialog(){
        $("#customFile").trigger("click");
    }

    $("#customFile").change(function(){
        var image = document.getElementById("customFile");
        if (image.files && image.files[0]){
            var fileType = image.files[0].type;
            if (fileType === "image/jpeg" || fileType === "image/jpg" || fileType === "image/png") {
                var data = new FileReader();
                data.onload=function() {
                    var address = data.result;
                    $('#target').remove();
                    $('#ImageCropper').html('<img src="'+address+'" alt="Deneme" id="target" class="canvas-img" style="display: none;"/>');
                    Cropper();
                    $("#CroppedPopup").trigger("click");
                    $("#CroppedOkay").attr("disabled", true);
                }
                data.readAsDataURL(image.files[0]);
            }else{
                $("#customFile").val("");
            }
        }
    });

    // Cropper
    function Cropper(){
        var dkrm = new Darkroom('#target', {
              // Size options
              minWidth: 600,
              minHeight: 600,
              maxWidth: 600,
              maxHeight: 600,
              ratio: 4/3,
              backgroundColor: '#000',
              // Plugins options
              plugins: {
                //save: false,
                crop: {
                  quickCropKey: 67 //key "c"
                  /*minHeight: 120,
                  minWidth: 350,
                  ratio: 4/3*/
                }
              },
              // Post initialize script
              initialize: function() {
                var cropPlugin = this.plugins['crop'];
                cropPlugin.requireFocus();
              }
        });
    }

    $("#CroppedOkay").on("click", function() {
        UploadFile($("#ImageCropper").find("img").attr("src"));
    });

    function b64toBlob(b64Data, contentType, sliceSize) {
        contentType = contentType || '';
        sliceSize = sliceSize || 512;
        var byteCharacters = atob(b64Data);
        var byteArrays = [];
        for (var offset = 0; offset < byteCharacters.length; offset += sliceSize) {
            var slice = byteCharacters.slice(offset, offset + sliceSize);
            var byteNumbers = new Array(slice.length);
            for (var i = 0; i < slice.length; i++) {
                byteNumbers[i] = slice.charCodeAt(i);
            }
            var byteArray = new Uint8Array(byteNumbers);
            byteArrays.push(byteArray);
        }

        var blob = new Blob(byteArrays, {type: contentType});
        return blob;
    }

    function UploadFile(MyBase64) {
        // Get the form
        var form = document.getElementById("ProfileForm");
        var ImageURL = MyBase64;
        var block = ImageURL.split(";");
        var contentType = block[0].split(":")[1];
        var realData = block[1].split(",")[1];
        var blob = b64toBlob(realData, contentType);
        var fd = new FormData(form);
        fd.append("image", blob);
        $.ajax({
            url:"./admin/pages/profile/functions/update_image.php",
            data: fd,
            type:"POST",
            contentType:false,
            processData:false,
            cache:false,
            success: function(imageName){
                $("#avatar-image").attr("src", "./images/account/"+imageName.replace(" ", "")+"");
            }
        });
    }
</script>
</body>
</html>