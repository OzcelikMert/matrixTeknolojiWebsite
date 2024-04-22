<?php
$title_ = (isset($_POST["title"])) ? $_POST["title"] : $GetBlogValues["title"];
$content_ = (isset($_POST["content"])) ? $_POST["content"] : $GetBlogValues["content"];
$main_image_ = (isset($_POST["blog_logo"])) ? $_POST["blog_logo"] : $GetBlogValues["main_image"];
$post_now_ = (isset($_POST["post_now"])) ? $_POST["post_now"] : $GetBlogValues["is_active"];
$fixed_ = (isset($_POST["fixed"])) ? $_POST["fixed"] : $GetBlogValues["fixed"];
?>

<form method="post" style="margin-top: 10px;" id="BlogForm">
	<div class="form-group">
		<label>Title</label>
		<input class="form-control" type="text" maxlength="50" name="title" placeholder="Blog Title" value="<?php echo $title_; ?>">
	</div>
	<div class="form-group">
		<label>Content</label>
        <textarea id="summernote" name="content" post-value='<?php echo $content_; ?>'></textarea>
    </div>
    <div class="form-group">
        <label for="blogOption" style="width: 100%;text-align:center;font-size: 20px;font-weight: 600;color: #4f31f7;">Blog Options</label>
        <div class="row" id="blogOption">
			<div class="col-md-6 col-sm-12">
				<label for="customFile">Blog Main Image</label>
				<div class="custom-file">
					<input type="hidden" name="blog_logo" id="blog_logo" value="<?php echo $main_image_; ?>">
					<input type="file" class="custom-file-input" id="customFile">
					<label class="custom-file-label" id="selectedImageName">Image Name: <?php echo $main_image_; ?></label>
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
	    	<input type="checkbox" class="custom-control-input" id="postNow" name="post_now" value="1" <?php if($post_now_ == 1 || $post_now_ == "1"){echo "checked";} ?>>
	    	<label class="custom-control-label" for="postNow">Now Publish</label>
	    </div>
	</div>
    <div class="form-group">
        <div class="custom-control custom-checkbox">
	    	<input type="checkbox" class="custom-control-input" id="fixed" name="fixed" value="1" <?php if($fixed_ == 1 || $fixed_ == "1"){echo "checked";} ?>>
	    	<label class="custom-control-label" for="fixed">Fixed Blog</label>
	    </div>
	</div>
	<div class="form-group">
        <input class="btn btn-primary" id="createBlog" type="submit" value="Share Blog">
	</div>
</form>