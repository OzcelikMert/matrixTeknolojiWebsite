<form method="post" style="margin-top: 10px;" id="TopSliderForm" enctype="multipart/form-data">
    <div class="form-group">
        <div class="col-md-6 col-sm-12" style="padding-left:0px;">
			<label for="customFile">Slider Image</label>
			<div class="custom-file">
				<input type="file" class="custom-file-input" id="customFile" name="image">
				<input type="hidden" name="slider_logo" id="slider_logo">
				<label class="custom-file-label" id="selectedImageName">Image Name: <?php echo $_POST["slider_logo"]; ?></label>
			</div>
		</div>
	</div>
    <div class="form-group">
        <div class="col-md-6 col-sm-12" style="padding-left:0px;">
            <label for="customFile">Image Zoom Duration(1000 = 1 second)</label>
            <input class="form-control" type="number" max="50000" min="1000" name="duration" placeholder="1000" value="<?php echo $_POST["duration"]; ?>">
        </div>
    </div>
	<div class="form-group">
		<label>Thumb Line Title</label>
		<input class="form-control" type="text" maxlength="50" name="title" placeholder="Slider Title" value="<?php echo $_POST["title"]; ?>">
	</div>
    <div id="div-layers">
        <div class="form-group" id="layer">
	    	<label>Layer (<a href="javascript:AddLayer();" style="color:blue;">Add More Layers</a>)</label>
	    	<input class="form-control" type="text" maxlength="500" name="layer[]" placeholder="Slider Layer (Please enter type HTML code)" value="<?php /* add_slider.php in mainlayer -> */ echo $MainLayer; ?>">
	    </div>
        <?php /* add_slider.php in morelayer -> */ echo $MoreLayer; ?>
    </div>
    <div class="form-group">
        <div class="custom-control custom-checkbox">
	    	<input type="checkbox" class="custom-control-input" id="postNow" name="post_now" value="1" <?php if($_POST["post_now"] == 1){echo "checked";} ?>>
	    	<label class="custom-control-label" for="postNow">Now Publish</label>
	    </div>
	</div>
	<div class="form-group">
        <input class="btn btn-primary" id="createSlider" type="submit" value="Add Top Slider">
	</div>
</form>