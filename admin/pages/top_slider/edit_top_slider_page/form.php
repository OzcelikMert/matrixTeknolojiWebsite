<?php
$image_ = (isset($_POST["slider_logo"])) ? $_POST["slider_logo"] : $GetSliderValues["image"];
$duration_ = (isset($_POST["duration"])) ? $_POST["duration"] : $GetSliderValues["duration"];
$title_ = (isset($_POST["title"])) ? $_POST["title"] : $GetSliderValues["title"];
$post_now_ = (isset($_POST["post_now"])) ? $_POST["post_now"] : $GetSliderValues["is_active"];
$rank_ = (isset($_POST["rank"])) ? $_POST["rank"] : $GetSliderValues["rank"];
?>

<form method="post" style="margin-top: 10px;" id="TopSliderForm" enctype="multipart/form-data">
    <div class="form-group">
        <div class="col-md-6 col-sm-12" style="padding-left:0px;">
			<label for="customFile">Slider Image</label>
			<div class="custom-file">
				<input type="file" class="custom-file-input" id="customFile" name="image">
				<input type="hidden" name="slider_logo" id="slider_logo" value="<?php echo $image_; ?>">
				<label class="custom-file-label" id="selectedImageName">Image Name: <?php echo $image_; ?></label>
			</div>
		</div>
	</div>
    <div class="form-group">
        <div class="col-md-6 col-sm-12" style="padding-left:0px;">
            <label for="customFile">Image Zoom Duration(1000 = 1 second)</label>
            <input class="form-control" type="number" max="50000" min="1000" name="duration" placeholder="1000" value="<?php echo $duration_; ?>">
        </div>
    </div>
	<div class="form-group">
		<label>Thumb Line Title</label>
		<input class="form-control" type="text" maxlength="50" name="title" placeholder="Slider Title" value="<?php echo $title_; ?>">
	</div>
    <div id="div-layers">
        <div class="form-group" id="layer">
	    	<label>Layer (<a href="javascript:AddLayer();" style="color:blue;">Add More Layers</a>)</label>
	    	<input class="form-control" type="text" maxlength="50" name="layer[]" placeholder="Slider Layer (Please enter type HTML code)" value='<?php /* update_slider_page.php in mainlayer -> */ echo $MainLayer; ?>'>
	    </div>
        <?php /* add_slider.php in morelayer -> */ echo $MoreLayer; ?>
    </div>
    <div class="form-group">
        <div class="custom-control custom-checkbox">
	    	<input type="checkbox" class="custom-control-input" id="postNow" name="post_now" value="1" <?php if($post_now_ == 1){echo "checked";} ?>>
	    	<label class="custom-control-label" for="postNow">Now Publish</label>
	    </div>
	</div>
	<div class="form-group">
        <input class="btn btn-primary" id="createSlider" type="submit" value="Add Top Slider">
	</div>
	<div class="form-group">
        <div class="col-md-6 col-sm-12" style="padding-left:0px;">
            <label for="customFile">Rank Index</label>
            <input class="form-control" type="number" min="1" name="rank" placeholder="1" value="<?php echo $rank_; ?>">
        </div>
    </div>
</form>