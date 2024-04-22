<div class="header clearfix">
	<div class="header-right">
		<div class="brand-logo">
			<a href="./admin/index.php">
				<img src="./admin/assets/images/matrix_logo_mini.png" alt="Matrix Teknoloji" title="Matrix Teknoloji" class="mobile-logo" style="max-width: 50px;">
			</a>
		</div>
		<div class="menu-icon">
			<span></span>
			<span></span>
			<span></span>
			<span></span>
		</div>
		<div class="user-info-dropdown">
			<div class="dropdown">
				<a class="dropdown-toggle" href="#" role="button" data-toggle="dropdown">
					<span class="user-icon"><i class="fa fa-user-o"></i></span>
					<span class="user-name"><?php /* sameparts -> account_settings.php -> */ echo $Account_Info["name"] . " " . $Account_Info["surname"]; ?></span>
				</a>
				<div class="dropdown-menu dropdown-menu-right">
					<a class="dropdown-item" href="./admin/profile.php"><i class="fa fa-user-md" aria-hidden="true"></i> Profile</a>
					<a class="dropdown-item" href="./admin/change_password.php"><i class="fa fa-cog" aria-hidden="true"></i> Setting</a>
					<a class="dropdown-item" href="javascript:void(0);"><i class="fa fa-question" aria-hidden="true"></i> Help</a>
					<a class="dropdown-item" href="./admin/<?php include_once("./sameparts/file_info.php"); echo $path_info.".php";?>?exit=true"><i class="fa fa-sign-out" aria-hidden="true"></i> Log Out</a>
				</div>
			</div>
		</div>
	</div>
</div>