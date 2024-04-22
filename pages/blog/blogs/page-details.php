<!--
=====================================================
	Blog Page Details
=====================================================
-->
<article class="blog-details-page">
	<div class="container">
        <div class="theme-title">
			<h2>Bloglar</h2>
		</div>
		<div class="col-lg-8 col-md-8 col-sm-12 col-xs-12 p-fix">
            <div id="blog-section">
                <div class="clear-fix">
                    <?php echo $Blog_Values; ?>
		        </div>
			</div>
			<!-- Page Count Buttons -->
			<?php include("./pages/blog/blogs/blog_count_buttons.php"); ?>
		</div>
		<?php include("./pages/blog/sameparts/sidebar.php"); ?>
	</div>
</article>