	<div class="left-side-bar">
		<div class="brand-logo">
			<a href="./admin/index.php">
				<img src="./admin/assets/images/matrix_logo.png" alt="Matrix Teknoloji" title="Matrix Teknoloji">
			</a>
		</div>
		<div class="menu-block customscroll">
			<div class="sidebar-menu">
				<ul id="accordion-menu">
					<!-- Home Pages -->
					<li class="dropdown">
						<a href="javascript:void(0);" class="dropdown-toggle">
							<span class="fa fa-home"></span><span class="mtext">Home</span>
						</a>
						<ul class="submenu">
							<li><a href="./admin/dashboard.php">Dashboard</a></li>
							<li><a href="index.php">Home Page</a></li>
						</ul>
					</li>
					<?php 
						// Get $Sidebars = sameparts -> account_settings.php
						echo $Sidebar;
					?>
					<li class="dropdown">
						<a href="javascript:void(0);" class="dropdown-toggle">
							<span class="fa fa-cog"></span><span class="mtext">Settings</span>
						</a>
						<ul class="submenu">
							<li><a href="./admin/change_password.php">Change Password</a></li>
						</ul>
					</li>
				</ul>
			</div>
		</div>
	</div>