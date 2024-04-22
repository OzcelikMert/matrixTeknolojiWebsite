<?php
#Contact Info Values
$comment_ = (empty($_POST["comment"])) ? $ContactValues["comment"]: $_POST["comment"];
$map_ = (empty($_POST["map"])) ? trim($ContactValues["map"]): $_POST["map"];
$address_ = (empty($_POST["address"])) ? $ContactValues["address"]: $_POST["address"];
$phone_ = (empty($_POST["phone"])) ? $ContactValues["phone"]: $_POST["phone"];
$email_ = (empty($_POST["email"])) ? $ContactValues["email"]: $_POST["email"];
?>

<form method="post">
	<div class="form-group row">
		<label class="col-sm-12 col-md-2 col-form-label">Comment</label>
		<div class="col-sm-12 col-md-10">
			<input class="form-control" maxlength="2000" name="comment" type="text" placeholder="Comment" value="<?php echo $comment_; ?>">
		</div>
	</div>
	<div class="form-group row">
		<label class="col-sm-12 col-md-2 col-form-label">Map</label>
		<div class="col-sm-12 col-md-10">
			<input class="form-control" maxlength="2000" name="map" type="text" placeholder="<iframe src='Map'></iframe>" value='<?php echo $map_; ?>'>
		</div>
	</div>
    <div class="form-group row">
		<label class="col-sm-12 col-md-2 col-form-label">Address</label>
		<div class="col-sm-12 col-md-10">
			<input class="form-control" maxlength="150" name="address" type="text" placeholder="Address" value="<?php echo $address_; ?>">
		</div>
	</div>
	<div class="form-group row">
		<label class="col-sm-12 col-md-2 col-form-label">Phone</label>
		<div class="col-sm-12 col-md-10">
			<input class="form-control" maxlength="11" name="phone" placeholder="02121231231" type="tel" value="<?php echo $phone_; ?>">
		</div>
	</div>
	<div class="form-group row">
		<label class="col-sm-12 col-md-2 col-form-label">Email</label>
		<div class="col-sm-12 col-md-10">
			<input class="form-control" maxlength="100" name="email" placeholder="example@example.com" type="email" value="<?php echo $email_; ?>">
		</div>
	</div>
    <div class="text-right">
        <input class="btn btn-primary" style="padding-left: 35px; padding-right: 35px;" type="submit" value="Save">
    </div>
</form>