<!--
=====================================================
	Top SLider
=====================================================
-->
<?php 
if(!empty($Get_TopSlider)){
	echo '
	<div id="home" class="banner">
		<div class="rev_slider_wrapper">
				<div id="main-banner-slider" class="rev_slider video-slider" data-version="5.0.7">
					<ul>
						'.$Get_TopSlider.'
					</ul>	
				</div>
			</div>
	</div>
	';
}
?>