<!--
=====================================================
	Project Section
=====================================================
-->
<?php 
if(!empty($Get_Project["projects"])){
	echo '
	<div id="project-section">
		<div class="container">
			<div class="theme-title">
				<h2>Projelerimiz</h2>
				<p>Yaptığımız projelerden bazılarını listeledik.</p>
			</div>
			<div class="project-menu">
				<ul>
					<li class="filter active tran3s" data-filter="all">Hepsi</li>
					'.$Get_Project["categories"].'
				</ul>
			</div>
			<div class="project-gallery clear-fix">
				'.$Get_Project["projects"].'
			</div>
		</div>
	</div>
	';
}
?>