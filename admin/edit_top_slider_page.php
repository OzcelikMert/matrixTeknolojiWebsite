<!DOCTYPE html>
<html>
<head>
<title>Add Top Slider</title>
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
    include("./pages/top_slider/edit_top_slider_page/functions/get_values.php");
    include("./pages/top_slider/edit_top_slider_page/functions/update_slider.php");
	include('./sameparts/header.php');
	include('./sameparts/sidebar.php');
?>
	<div class="main-container">
		<div class="pd-ltr-20 height-100-p xs-pd-20-10">
            <div class="pd-20 bg-white border-radius-4 box-shadow mb-30">
	            <div class="clearfix">
	            	<div class="pull-left">
	            		<h4 class="text-blue">Edit Top Slider</h4>
	            	</div>
	            </div>
                <?php 
                    echo $ErrorMessage_show;
                    include("./pages/top_slider/edit_top_slider_page/form.php");
                ?>
            </div>    
            
			<?php 
                // Footer
			    include('./sameparts/footer.php'); 
			?>
		</div>
	</div>
    
    <?php include('./tools/scripts.php'); ?>
<!-- Layers -->
<script>
// Add Layer
function AddLayer(){
    var layer_count = $("#div-layers #layer").length;
    var Random = Math.floor(Math.random() * 9999) + layer_count;
    Random += layer_count;
    $("#div-layers").append('<div class="form-group layer-'+Random+'" id="layer"><label>(<a href="javascript:DeleteLayer('+Random+');" style="color:red;">Delete Layer</a>)</label><input class="form-control" type="text" maxlength="50" name="layer[]" placeholder="Slider Layer (Please enter type HTML code)"></div>');
}
// Delete Layer
function DeleteLayer(layer_count){
    $(".layer-"+layer_count+"").remove();
}
// Selected Image and Change Label Text
$("#customFile").change(function (){
       var fileName = $(this).val();
       $("#selectedImageName").html("Image Name: " + fileName);
       $("#slider_logo").val(fileName);
});
</script>

</body>
</html>