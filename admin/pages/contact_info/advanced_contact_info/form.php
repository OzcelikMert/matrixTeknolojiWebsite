<?php
#Contact Info Values
$email_ = (empty($_POST["email"])) ? $ContactValues["contact_form_email"]: $_POST["email"];
$password_ = (empty($_POST["password"])) ? $ContactValues["contact_form_password"]: $_POST["password"];
$host_ = (empty($_POST["host"])) ? $ContactValues["contact_form_host"]: $_POST["host"];
$title_ = (empty($_POST["title"])) ? $ContactValues["contact_form_title"]: $_POST["title"];
?>

<form method="post">
	<div class="form-group row">
		<label class="col-sm-12 col-md-2 col-form-label">Contact Form Email</label>
		<div class="col-sm-12 col-md-10">
			<input class="form-control" maxlength="100" name="email" type="text" placeholder="abc@xyz.com" value="<?php echo $email_; ?>" required>
		</div>
	</div>
	<div class="form-group row">
		<label class="col-sm-12 col-md-2 col-form-label">Contact Form Password</label>
		<div class="col-sm-12 col-md-10">
			<input class="form-control" maxlength="150" name="password" type="password" placeholder="***********" value="<?php echo $password_; ?>" required>
		</div>
	</div>
    <div class="form-group row">
		<label class="col-sm-12 col-md-2 col-form-label">Contact Form Host</label>
		<div class="col-sm-12 col-md-10">
			<input class="form-control" maxlength="75" name="host" type="text" placeholder="mail.example.com" value="<?php echo $host_; ?>" required>
		</div>
	</div>
	<div class="form-group row">
		<label class="col-sm-12 col-md-2 col-form-label">Send Mail Title</label>
		<div class="col-sm-12 col-md-10">
			<input class="form-control" maxlength="75" name="title" placeholder="Example Businness" type="text" value="<?php echo $title_; ?>" required>
		</div>
	</div>
    <div class="text-right">
        <input class="btn btn-primary" style="padding-left: 35px; padding-right: 35px;" type="submit" value="Save">
    </div>
</form>