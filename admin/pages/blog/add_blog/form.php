<form method="post" style="margin-top: 10px;" id="BlogForm">
	<div class="form-group">
		<label>Title</label>
		<input class="form-control" type="text" maxlength="50" name="title" placeholder="Blog Title" value="<?php echo $_POST["title"]; ?>">
	</div>
	<div class="form-group">
		<label>Content</label>
        <textarea id="summernote" name="content" post-value='<?php echo $_POST["content"]; ?>'></textarea>
    </div>
    <div class="form-group">
        <label for="blogOption" style="width: 100%;text-align:center;font-size: 20px;font-weight: 600;color: #4f31f7;">Blog Options</label>
        <div class="row" id="blogOption">
			<div class="col-md-6 col-sm-12">
				<label for="customFile">Blog Main Image</label>
				<div class="custom-file">
					<input type="hidden" name="blog_logo" id="blog_logo" value="<?php echo $_POST["blog_logo"]; ?>">
					<input type="file" class="custom-file-input" id="customFile">
					<label class="custom-file-label" id="selectedImageName">Image Name: <?php echo $_POST["blog_logo"]; ?></label>
				</div>
			</div>
			<div class="col-md-6 col-sm-12">
			    <label for="sharedEmail">Choose Category</label>
                <select class="form-control" name="category">
                    <option>Category...</option>
					<?php echo $Categories; ?>
                </select>
			</div>
		</div>
	</div>
    <div class="form-group">
		<div class="custom-control custom-checkbox">
	    	<input type="checkbox" class="custom-control-input" id="shareEmails" name="share_emails" value="1" <?php if($_POST["share_emails"] == 1){echo "checked";} ?>>
	    	<label class="custom-control-label" for="shareEmails">Share new blog with followers</label>
	    </div>
	</div>
    <div class="form-group">
        <div class="custom-control custom-checkbox">
	    	<input type="checkbox" class="custom-control-input" id="postNow" name="post_now" value="1" <?php if($_POST["post_now"] == 1){echo "checked";} ?>>
	    	<label class="custom-control-label" for="postNow">Now Publish</label>
	    </div>
	</div>
	<div class="form-group">
        <div class="custom-control custom-checkbox">
	    	<input type="checkbox" class="custom-control-input" id="fixed" name="fixed" value="1" <?php if($_POST["fixed"] == 1){echo "checked";} ?>>
	    	<label class="custom-control-label" for="fixed">Fixed Blog</label>
	    </div>
	</div>
	<div class="form-group">
        <input class="btn btn-primary" id="createBlog" type="submit" value="Share Blog">
	</div>
</form>