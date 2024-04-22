<!--
=====================================================
	Project Page Details
=====================================================
-->
<article class="blog-details-page">
	<div class="container">
        <div class="theme-title">
			<h2>Projeler</h2>
		</div>
		<div class="col-lg-8 col-md-8 col-sm-12 col-xs-12 p-fix">
    		<div id="project-section">
				<div class="project-gallery clear-fix">
					<?php echo $Project_Values; ?>
				</div>
			</div>
			<!-- Page Count Buttons -->
			<?php include("./pages/project/projects/project_count_buttons.php"); ?>
		</div>
		<?php include("./pages/project/sameparts/sidebar.php"); ?>
	</div>
</article>