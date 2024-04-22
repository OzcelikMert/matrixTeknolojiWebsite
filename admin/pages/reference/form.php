<form method="post" style="margin-top: 10px;" enctype="multipart/form-data">
	<div class="form-group">
        <div class="row">
			<div class="col-md-6 col-sm-12">
				<input class="form-control" maxlength="75" name="title" type="text" placeholder="Reference Title" value="<?php $_POST["title"]; ?>" required>
			</div>
			<div class="col-md-6 col-sm-12 responsive-mt-5">
				<div class="custom-file">
					<input type="file" class="custom-file-input" id="customFile" name="image" required>
					<input type="hidden" name="reference_logo" id="reference_logo" value="<?php echo $_POST["reference_logo"]; ?>">
					<label class="custom-file-label" id="selectedImageName">Reference Logo Name: <?php echo $_POST["reference_logo"]; ?></label>
				</div>
			</div>
		</div>
	</div>
	<div class="form-group" style="text-align:right;">
        <input class="btn btn-primary" id="shareReference" type="submit" value="Share Reference">
	</div>
</form>