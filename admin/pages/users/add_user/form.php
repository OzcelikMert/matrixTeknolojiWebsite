<form method="post">
	<div class="form-group row">
		<label class="col-sm-12 col-md-2 col-form-label">Name</label>
		<div class="col-sm-12 col-md-10">
			<input class="form-control" maxlength="75" name="name" type="text" placeholder="User Name" value="<?php echo $_POST["name"]; ?>" required>
		</div>
	</div>
	<div class="form-group row">
		<label class="col-sm-12 col-md-2 col-form-label">Surname</label>
		<div class="col-sm-12 col-md-10">
			<input class="form-control" maxlength="50" name="surname" type="text" placeholder="User Surname" value="<?php echo $_POST["surname"]; ?>" required>
		</div>
	</div>
    <div class="form-group row">
		<label class="col-sm-12 col-md-2 col-form-label">Nickname</label>
		<div class="col-sm-12 col-md-10">
			<input class="form-control" maxlength="50" name="nickname" type="text" placeholder="User Nickname" value="<?php echo $_POST["nickname"]; ?>" required>
		</div>
	</div>
	<div class="form-group row">
		<label class="col-sm-12 col-md-2 col-form-label">Telephone</label>
		<div class="col-sm-12 col-md-10">
			<input class="form-control" maxlength="11" name="telephone" placeholder="05431234567" type="tel" value="<?php echo $_POST["telephone"]; ?>" required>
		</div>
	</div>
	<div class="form-group row">
		<label class="col-sm-12 col-md-2 col-form-label">Email</label>
		<div class="col-sm-12 col-md-10">
			<input class="form-control" maxlength="75" name="email" placeholder="example@example.com" type="email" value="<?php echo $_POST["email"]; ?>" required>
		</div>
	</div>
	<div class="form-group row">
		<label class="col-sm-12 col-md-2 col-form-label">Password</label>
		<div class="col-sm-12 col-md-10">
			<input class="form-control" maxlength="50" name="password" placeholder="Password" type="password" required>
		</div>
	</div>
    <div class="form-group row">
		<label class="col-sm-12 col-md-2 col-form-label">Password</label>
		<div class="col-sm-12 col-md-10">
			<input class="form-control" maxlength="50" name="confirm_password" placeholder="Confirm Password" type="password" required>
		</div>
	</div>
	<div class="form-group row">
		<label class="col-sm-12 col-md-2 col-form-label">Permission</label>
		<div class="col-sm-12 col-md-10">
			<select class="custom-select col-12" name="permission" required>
				<option selected>Choose...</option>
                <?php echo $Permissions; ?>
			</select>
		</div>
	</div>
    <div class="text-right">
        <input class="btn btn-primary" type="submit" value="Add User">
    </div>
</form>