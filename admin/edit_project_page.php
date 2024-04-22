<!DOCTYPE html>
<html>
<head>
<title>Edit Project</title>
	<?php
        include("./tools/base.php");
        include('./tools/includes.php');
		include('./tools/metas.php');
        include('./tools/links.php');
    ?>
    <link href="./admin/assets/plugins/SummerNote/summernote.css" rel="stylesheet">
    <link href="./admin/assets/plugins/DarkRoomCroppie/darkroom.css" rel="stylesheet">
</head>
<body>
<?php
    include('../sameparts/pre-loader.php');
    include("./pages/project/edit_project_page/functions/get_values.php");
    include("./pages/project/edit_project_page/functions/update_project.php");
	include('./sameparts/header.php');
	include('./sameparts/sidebar.php');
?>
	<div class="main-container">
		<div class="pd-ltr-20 height-100-p xs-pd-20-10">
            <div class="pd-20 bg-white border-radius-4 box-shadow mb-30">
	            <div class="clearfix">
	            	<div class="pull-left">
	            		<h4 class="text-blue">Update Project</h4>
	            	</div>
	            </div>
                <?php 
                    echo $ErrorMessage_show;
                    include("./pages/project/edit_project_page/form.php");
                    include("./pages/project/add_project/cropper.php");
                ?>
            </div>    
            
			<?php 
                // Footer
			    include('./sameparts/footer.php'); 
			?>
		</div>
	</div>

    <?php include('./tools/scripts.php'); ?>
    <script src="./admin/assets/plugins/SummerNote/summernote.js"></script>
    <script src="./admin/assets/plugins/SummerNote/summernote-image-title.js"></script>
    <script src="./admin/assets/plugins/DarkRoomCroppie/fabric.js"></script>
    <script src="./admin/assets/plugins/DarkRoomCroppie/darkroom.js"></script>
<!-- Rich Text -->
<script>
    // Ritch Text
    $(document).ready(function() {
        $('#summernote').summernote();
        var PostValue = $("#summernote").attr("post-value");
        $('#summernote').summernote('code', PostValue);
        
    });
    $('#summernote').summernote({
        imageTitle: {
          specificAltField: true,
        },
        lang: 'en-US',
        popover: {
            image: [
                ['resize', ['resizeFull', 'resizeHalf', 'resizeQuarter', 'resizeNone']],
                ['float', ['floatLeft', 'floatRight', 'floatNone']],
                ['remove', ['removeMedia']],
                ['custom', ['imageTitle']],
            ],
        },
        placeholder: 'Enter Project Blog Content...',
        tabsize: 2,
        height: 300,
        minHeight: 300,
        maxHeight: 500,
        focus: true,
        callbacks: {
            onImageUpload: function(image) {
                uploadImage(image[0]);
            }
            /*onMediaDelete: function(image) {
                deleteImage(image[0].src);
            },*/
        }
    });
    function uploadImage(image) {
        var data = new FormData();
        data.append("image", image);
        $.ajax({
            url: './admin/pages/project/add_project/functions/upload-image.php',
            cache: false,
            contentType: false,
            processData: false,
            data: data,
            type: "post",
            success: function(url) {
                var image = $('<img>').attr('src', url);
                $('#summernote').summernote("insertNode", image[0]);
            },
            error: function(data) {
                console.log(data);
            }
        });
    }
        /*function deleteImage(image) {
            $.ajax({
                url: './admin/pages/project/add_project/functions/delete-image.php',
                type: "post",
                data: { image: image},
                success: function(msg) {
                    if (msg != "ok") {
                        alert("Error\n"+msg);
                    }
                },
                error: function(data) {
                    console.log(data);
                }
            });
        }*/
</script>
<!-- Cropper -->
<script>
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
        $("#createProject").attr("disabled", true);
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
        var form = document.getElementById("ProjectForm");
        var ImageURL = MyBase64;
        var block = ImageURL.split(";");
        var contentType = block[0].split(":")[1];
        var realData = block[1].split(",")[1];
        var blob = b64toBlob(realData, contentType);
        var fd = new FormData(form);
        fd.append("image", blob);
        $.ajax({
            url:"./admin/pages/project/add_project/functions/upload-logo.php",
            data: fd,
            type:"POST",
            contentType:false,
            processData:false,
            cache:false,
            success: function(data){
                if (data != "Error") {
                    $("#project_logo").val(data);
                    $("#selectedImageName").html("Image Name: "+data);
                    $("#createProject").attr("disabled", false);
                }
            }
        });
    }




</script>


</body>
</html>