<form method="post">
	<div class="form-group row">
		<label class="col-sm-12 col-md-2 col-form-label">Now Password</label>
		<div class="col-sm-12 col-md-10">
			<input class="form-control" maxlength="75" name="nowpassword" type="password" placeholder="*********" required>
		</div>
	</div>
    <div class="form-group row">
		<label class="col-sm-12 col-md-2 col-form-label">New Password</label>
		<div class="col-sm-12 col-md-10">
			<input class="form-control" maxlength="75" id="newpassword" name="newpassword" type="password" placeholder="*********" onkeyup="equalPassword()" required>
		</div>
	</div>
    <div class="form-group row">
		<label class="col-sm-12 col-md-2 col-form-label">Re New Password</label>
		<div class="col-sm-12 col-md-10">
			<input class="form-control" maxlength="75" id="newpassword_2" name="newpassword_2" type="password" placeholder="*********" onkeyup="equalPassword()" required>
            <p id='errorMessage' style='color: red; display: none;'>New passwords are not equals</p>
        </div>
	</div>
    <div class="text-right">
        <input class="btn btn-primary" type="submit" id="changePassword_button" value="Add User" disabled="true">
    </div>
</form>