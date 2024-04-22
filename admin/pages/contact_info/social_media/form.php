<?php
#Social Media Values
$facebook_ = (empty($_POST["facebook"])) ? $SocialMediaValues["facebook"]: $_POST["facebook"];
$twitter_ = (empty($_POST["twitter"])) ? $SocialMediaValues["twitter"]: $_POST["twitter"];
$instagram_ = (empty($_POST["instagram"])) ? $SocialMediaValues["instagram"]: $_POST["instagram"];
?>

<form method="post">
	<div class="form-group row">
		<label class="col-sm-12 col-md-2 col-form-label">Facebook</label>
		<div class="col-sm-12 col-md-10">
			<input class="form-control" maxlength="75" name="facebook" type="text" placeholder="https://facebook.com/" value="<?php echo $facebook_; ?>">
		</div>
	</div>
	<div class="form-group row">
		<label class="col-sm-12 col-md-2 col-form-label">Twitter</label>
		<div class="col-sm-12 col-md-10">
			<input class="form-control" maxlength="75" name="twitter" type="text" placeholder="https://twitter.com/" value='<?php echo $twitter_; ?>'>
		</div>
	</div>
    <div class="form-group row">
		<label class="col-sm-12 col-md-2 col-form-label">Instagram</label>
		<div class="col-sm-12 col-md-10">
			<input class="form-control" maxlength="75" name="instagram" type="text" placeholder="https://instagram.com/" value="<?php echo $instagram_; ?>">
		</div>
	</div>
    <div class="text-right">
        <input class="btn btn-primary" style="padding-left: 35px; padding-right: 35px;" type="submit" value="Save">
    </div>
</form>