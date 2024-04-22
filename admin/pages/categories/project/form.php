<form method="post" style="margin-top: 10px;">
	<div class="form-group row">
		<div class="col-sm-12 col-md-5">
			<input class="form-control" maxlength="75" name="name" type="text" placeholder="New Project Category Name" value="<?php echo $_POST["name"]; ?>" required>
		</div>
        <div class="col-sm-12 col-md-5 align_right_btn_mobile">
            <input class="btn btn-primary" type="submit" value="Add New Category">
        </div>
	</div>
</form>