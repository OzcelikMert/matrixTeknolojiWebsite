<!--
=====================================================
	Blog Section
=====================================================
-->
<?php 
if(!empty($Get_Reference)){
	echo '
	<div id="blog-section">
		<div class="container">
			<div class="theme-title">
				<h2>Son Bloglar</h2>
				<p>Etkinliklerimizi, projelerimizi, attığımız her adımı blog yapıp paylaşıyoruz.</p>
			</div>
			<div class="clear-fix">
				'.$Get_Blog.'
			</div>
		</div>
	</div>
	';
}
?>