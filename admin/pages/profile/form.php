<?php
#Profile Values
// Get $Account_Info = sameparts -> account_settings.php
$name_ = (empty($_POST["name"])) ? $Account_Info["name"]: $_POST["name"];
$surname_ = (empty($_POST["surname"])) ? $Account_Info["surname"]: $_POST["surname"];
$nickname_ = (empty($_POST["nickname"])) ? $Account_Info["nickname"]: $_POST["nickname"];
$tel_ = (empty($_POST["telephone"])) ? $Account_Info["tel"]: $_POST["telephone"];
$email_ = (empty($_POST["email"])) ? $Account_Info["email"]: $_POST["email"];
?>
<form method="post" id="ProfileForm">
	<div class="form-group row">
		<label class="col-sm-12 col-md-2 col-form-label">Name</label>
		<div class="col-sm-12 col-md-10">
			<input class="form-control" maxlength="75" name="name" type="text" placeholder="Name" value="<?php echo $name_; ?>" required>
		</div>
	</div>
	<div class="form-group row">
		<label class="col-sm-12 col-md-2 col-form-label">Surname</label>
		<div class="col-sm-12 col-md-10">
			<input class="form-control" maxlength="50" name="surname" type="text" placeholder="Surname" value="<?php echo $surname_; ?>" required>
		</div>
	</div>
    <div class="form-group row">
		<label class="col-sm-12 col-md-2 col-form-label">Nickname</label>
		<div class="col-sm-12 col-md-10">
			<input class="form-control" type="text" value="<?php echo $nickname_; ?>" disabled>
		</div>
	</div>
	<div class="form-group row">
		<label class="col-sm-12 col-md-2 col-form-label">Telephone</label>
		<div class="col-sm-12 col-md-10">
			<input class="form-control" maxlength="11" name="telephone" placeholder="05431234567" type="tel" value="<?php echo $tel_; ?>" required>
		</div>
	</div>
	<div class="form-group row">
		<label class="col-sm-12 col-md-2 col-form-label">Email</label>
		<div class="col-sm-12 col-md-10">
			<input class="form-control" type="text" value="<?php echo $email_; ?>" disabled>
		</div>
	</div>
    <div class="text-right">
        <input class="btn btn-primary" type="submit" value="Update Profile">
    </div>
</form>