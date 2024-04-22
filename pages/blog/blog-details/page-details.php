<!--
=====================================================
	Blog Page Details
=====================================================
-->
<article class="blog-details-page">
	<div class="container">
		<div class="col-lg-8 col-md-8 col-sm-12 col-xs-12 p-fix">
			<div class="blog-details-post-wrapper" style="word-break: break-word; overflow: hidden;">
				<?php
					echo $Blog_Values;
                ?>
			</div>
		</div>
		<?php include("./pages/blog/sameparts/sidebar.php"); ?>
	</div>
</article>