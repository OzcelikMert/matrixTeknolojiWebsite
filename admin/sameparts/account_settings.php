<?php
include_once("./config/config.php");
include_once("./sameparts/file_info.php");
// SESSION Control
session_start();
$email = $_SESSION["email"];
$id = GetID($conn, $email);
$permission = GetPermissionRange($conn, $id);
// end SESSION Control

// Get Values
$Account_Info = GetAccount_Info($conn, $id);

// Permission Account Controls
$Page_Name = GetFileName();
// Variables
$SuperAdmin = 0;
$Admin = 1;
$Author = 2;
$NormalUser = 3;
// end Variables
AccountPermission_LoginPage_Control($Page_Name, $permission, $SuperAdmin, $Admin, $Author, $NormalUser);
$Sidebar = GetSidebarValues_forPermission($DomainName, $permission, $SuperAdmin, $Admin, $Author, $NormalUser);
// end Permission Account Controls

// end Get Values


/* Functions */
// Get Account Values
function GetAccount_Info($connect, $id){
    $values = array();
    $sql = '
    select 
    accounts.image as image,
    accounts.nickname as nickname,
    accounts.name as name,
    accounts.surname as surname,
    accounts.tel as tel,
    accounts.email as email,
    accounts.register_date as register_date,
    accounts.lock_rate as lock_rate,
    permissions.name as permission
    from accounts
    LEFT JOIN permissions ON permissions.id = accounts.permission
    where accounts.id = '.(int)$id.'
    ';
    $query = mysqli_query($connect, $sql);
    if($row = mysqli_fetch_array($query)){
        $values["image"] = $row["image"];
        $values["nickname"] = $row["nickname"];
        $values["name"] = $row["name"];
        $values["surname"] = $row["surname"];
        $values["tel"] = $row["tel"];
        $values["email"] = $row["email"];
        $values["register_date"] = $row["register_date"];
        $values["lock_rate"] = $row["lock_rate"];
        $values["permission"] = $row["permission"];
    }

    return $values;
}
// Check Account For Page Permission
function AccountPermission_LoginPage_Control($page_name, $permission, $SuperAdmin, $Admin, $Author, $NormalUser){

    switch($page_name){
        // Blog Page
        case "add_blog":
            if($permission > $Author){
                header("Location: dashboard.php");
            }
        break;
        case "show_blogs":
            if($permission > $NormalUser){
                header("Location: dashboard.php");
            }
        break;
        // Project Page
        case "add_project":
            if($permission > $Author){
                header("Location: dashboard.php");
            }
        break;
        case "show_projects":
            if($permission > $NormalUser){
                header("Location: dashboard.php");
            }
        break;
        // Top Slider Page
        case "add_top_slider":
            if($permission > $Admin){
                header("Location: dashboard.php");
            }
        break;
        case "show_top_sliders":
            if($permission > $Admin){
                header("Location: dashboard.php");
            }
        break;
        // Reference Page
        case "reference":
            if($permission > $Admin){
                header("Location: dashboard.php");
            }
        break;
        // Gallery Page
        case "gallery":
            if($permission > $Author){
                header("Location: dashboard.php");
            }
        break;
        // Contact Info Page
        case "contact_info":
            if($permission > $Admin){
                header("Location: dashboard.php");
            }
        break;
        case "advanced_contact_info":
            if($permission > $SuperAdmin){
                header("Location: dashboard.php");
            }
        break;
        case "social_media":
            if($permission > $Author){
                header("Location: dashboard.php");
            }
        break;
        // Categories Page
        case "project_category":
            if($permission > $Author){
                header("Location: dashboard.php");
            }
        break;
        case "blog_category":
            if($permission > $Author){
                header("Location: dashboard.php");
            }
        break;
        // Users Page
        case "add_user":
            if($permission > $Admin){
                header("Location: dashboard.php");
            }
        break;
        case "show_users":
            if($permission > $NormalUser){
                header("Location: dashboard.php");
            }
        break;
    }
}
// Check Account For Siderbar Permission
function GetSidebarValues_forPermission($DomainName, $permission, $SuperAdmin, $Admin, $Author, $NormalUser){
    $sidebar = "";

    switch($permission){
        /*
        =============
         Super Admin
        =============
        */
        case $SuperAdmin:
            $sidebar = '
            <li class="dropdown">
				<a href="javascript:;" class="dropdown-toggle">
					<span class="fa fa-pencil"></span><span class="mtext">Blog</span>
				</a>
				<ul class="submenu">
					<li><a href="./admin/add_blog.php">Add Blog</a></li>
					<li><a href="./admin/show_blogs.php">Show Blogs</a></li>
				</ul>
			</li>
			<li class="dropdown">
				<a href="javascript:void(0);" class="dropdown-toggle">
					<span class="fa fa-folder-o"></span><span class="mtext">Projects</span>
				</a>
				<ul class="submenu">
					<li><a href="./admin/add_project.php">Add Project</a></li>
					<li><a href="./admin/show_projects.php">Show Projects</a></li>
				</ul>
			</li>
			<li class="dropdown">
				<a href="javascript:void(0);" class="dropdown-toggle">
					<span class="fa fa-image"></span><span class="mtext">Top Slider</span>
				</a>
				<ul class="submenu">
					<li><a href="./admin/add_top_slider.php">Add Top Slider</a></li>
					<li><a href="./admin/show_top_sliders.php">Show Top Sliders</a></li>
				</ul>
			</li>
			<li>
				<a href="./admin/reference.php" class="dropdown-toggle no-arrow">
					<span class="fa fa-handshake-o"></span><span class="mtext">Reference</span>
				</a>
			</li>
			<li class="dropdown">
				<a href="javascript:void(0);" class="dropdown-toggle">
					<span class="fa fa-file-image-o"></span><span class="mtext">Gallery</span>
				</a>
				<ul class="submenu">
					<li><a href="./admin/gallery.php?gallery_name=top-slider">Top Slider Images</a></li>
					<li><a href="./admin/gallery.php?gallery_name=reference">Reference Images</a></li>
					<li><a href="./admin/gallery.php?gallery_name=blog-logo">Blog Logo Images</a></li>
					<li><a href="./admin/gallery.php?gallery_name=blog">Blog Images</a></li>
					<li><a href="./admin/gallery.php?gallery_name=project-logo">Project Logo Images</a></li>
					<li><a href="./admin/gallery.php?gallery_name=project">Project Images</a></li>
					<li><a href="./admin/gallery.php?gallery_name=account">Account Images</a></li>
				</ul>
			</li>
			<li class="dropdown">
				<a href="javascript:void(0);" class="dropdown-toggle">
					<span class="fa fa-address-card-o"></span><span class="mtext">Contact Info</span>
				</a>
				<ul class="submenu">
					<li><a href="./admin/contact_info.php">Contact Info</a></li>
					<li><a href="./admin/advanced_contact_info.php">Advanced Contact Info</a></li>
					<li><a href="./admin/social_media.php">Social Media</a></li>
				</ul>
			</li>
			<li class="dropdown">
				<a href="javascript:void(0);" class="dropdown-toggle">
					<span class="fa fa-tags"></span><span class="mtext">Categories</span>
				</a>
				<ul class="submenu">
					<li><a href="./admin/project_category.php">Project Category</a></li>
					<li><a href="./admin/blog_category.php">Blog Category</a></li>
				</ul>
			</li>
			<li class="dropdown">
				<a href="javascript:void(0);" class="dropdown-toggle">
					<span class="fa fa-users"></span><span class="mtext">Users</span>
				</a>
				<ul class="submenu">
					<li><a href="./admin/add_user.php">Add User</a></li>
					<li><a href="./admin/show_users.php">Show Users</a></li>
				</ul>
			</li>';
        break;
        /*
        =============
         Admin
        =============
        */
        case $Admin:
            $sidebar = '
            <li class="dropdown">
				<a href="javascript:;" class="dropdown-toggle">
					<span class="fa fa-pencil"></span><span class="mtext">Blog</span>
				</a>
				<ul class="submenu">
					<li><a href="./admin/add_blog.php">Add Blog</a></li>
					<li><a href="./admin/show_blogs.php">Show Blogs</a></li>
				</ul>
			</li>
			<li class="dropdown">
				<a href="javascript:void(0);" class="dropdown-toggle">
					<span class="fa fa-folder-o"></span><span class="mtext">Projects</span>
				</a>
				<ul class="submenu">
					<li><a href="./admin/add_project.php">Add Project</a></li>
					<li><a href="./admin/show_projects.php">Show Projects</a></li>
				</ul>
			</li>
			<li class="dropdown">
				<a href="javascript:void(0);" class="dropdown-toggle">
					<span class="fa fa-image"></span><span class="mtext">Top Slider</span>
				</a>
				<ul class="submenu">
					<li><a href="./admin/add_top_slider.php">Add Top Slider</a></li>
					<li><a href="./admin/show_top_sliders.php">Show Top Sliders</a></li>
				</ul>
			</li>
			<li>
				<a href="./admin/reference.php" class="dropdown-toggle no-arrow">
					<span class="fa fa-handshake-o"></span><span class="mtext">Reference</span>
				</a>
			</li>
			<li class="dropdown">
				<a href="javascript:void(0);" class="dropdown-toggle">
					<span class="fa fa-file-image-o"></span><span class="mtext">Gallery</span>
				</a>
				<ul class="submenu">
					<li><a href="./admin/gallery.php?gallery_name=top-slider">Top Slider Images</a></li>
					<li><a href="./admin/gallery.php?gallery_name=reference">Reference Images</a></li>
					<li><a href="./admin/gallery.php?gallery_name=blog-logo">Blog Logo Images</a></li>
					<li><a href="./admin/gallery.php?gallery_name=blog">Blog Images</a></li>
					<li><a href="./admin/gallery.php?gallery_name=project-logo">Project Logo Images</a></li>
					<li><a href="./admin/gallery.php?gallery_name=project">Project Images</a></li>
					<li><a href="./admin/gallery.php?gallery_name=account">Account Images</a></li>
				</ul>
			</li>
			<li class="dropdown">
				<a href="javascript:void(0);" class="dropdown-toggle">
					<span class="fa fa-address-card-o"></span><span class="mtext">Contact Info</span>
				</a>
				<ul class="submenu">
					<li><a href="./admin/contact_info.php">Contact Info</a></li>
					<li><a href="./admin/social_media.php">Social Media</a></li>
				</ul>
			</li>
			<li class="dropdown">
				<a href="javascript:void(0);" class="dropdown-toggle">
					<span class="fa fa-tags"></span><span class="mtext">Categories</span>
				</a>
				<ul class="submenu">
					<li><a href="./admin/project_category.php">Project Category</a></li>
					<li><a href="./admin/blog_category.php">Blog Category</a></li>
				</ul>
			</li>
			<li class="dropdown">
				<a href="javascript:void(0);" class="dropdown-toggle">
					<span class="fa fa-users"></span><span class="mtext">Users</span>
				</a>
				<ul class="submenu">
					<li><a href="./admin/add_user.php">Add User</a></li>
					<li><a href="./admin/show_users.php">Show Users</a></li>
				</ul>
			</li>';
        break;
        /*
        =============
         Author
        =============
        */
        case $Author:
            $sidebar = '
            <li class="dropdown">
				<a href="javascript:;" class="dropdown-toggle">
					<span class="fa fa-pencil"></span><span class="mtext">Blog</span>
				</a>
				<ul class="submenu">
					<li><a href="./admin/add_blog.php">Add Blog</a></li>
					<li><a href="./admin/show_blogs.php">Show Blogs</a></li>
				</ul>
			</li>
			<li class="dropdown">
				<a href="javascript:void(0);" class="dropdown-toggle">
					<span class="fa fa-folder-o"></span><span class="mtext">Projects</span>
				</a>
				<ul class="submenu">
					<li><a href="./admin/add_project.php">Add Project</a></li>
					<li><a href="./admin/show_projects.php">Show Projects</a></li>
				</ul>
			</li>
			<li class="dropdown">
				<a href="javascript:void(0);" class="dropdown-toggle">
					<span class="fa fa-file-image-o"></span><span class="mtext">Gallery</span>
				</a>
				<ul class="submenu">
					<li><a href="./admin/gallery.php?gallery_name=blog-logo">Blog Logo Images</a></li>
					<li><a href="./admin/gallery.php?gallery_name=blog">Blog Images</a></li>
					<li><a href="./admin/gallery.php?gallery_name=project-logo">Project Logo Images</a></li>
					<li><a href="./admin/gallery.php?gallery_name=project">Project Images</a></li>
				</ul>
			</li>
			<li class="dropdown">
				<a href="javascript:void(0);" class="dropdown-toggle">
					<span class="fa fa-address-card-o"></span><span class="mtext">Contact Info</span>
				</a>
				<ul class="submenu">
					<li><a href="./admin/social_media.php">Social Media</a></li>
				</ul>
			</li>
			<li class="dropdown">
				<a href="javascript:void(0);" class="dropdown-toggle">
					<span class="fa fa-tags"></span><span class="mtext">Categories</span>
				</a>
				<ul class="submenu">
					<li><a href="./admin/project_category.php">Project Category</a></li>
					<li><a href="./admin/blog_category.php">Blog Category</a></li>
				</ul>
			</li>
			<li class="dropdown">
				<a href="javascript:void(0);" class="dropdown-toggle">
					<span class="fa fa-users"></span><span class="mtext">Users</span>
				</a>
				<ul class="submenu">
					<li><a href="./admin/show_users.php">Show Users</a></li>
				</ul>
			</li>';
        break;
        /*
        =============
         Normal User
        =============
        */
        case $NormalUser:
            $sidebar = '
            <li class="dropdown">
				<a href="javascript:;" class="dropdown-toggle">
					<span class="fa fa-pencil"></span><span class="mtext">Blog</span>
				</a>
				<ul class="submenu">
					<li><a href="./admin/show_blogs.php">Show Blogs</a></li>
				</ul>
			</li>
			<li class="dropdown">
				<a href="javascript:void(0);" class="dropdown-toggle">
					<span class="fa fa-folder-o"></span><span class="mtext">Projects</span>
				</a>
				<ul class="submenu">
					<li><a href="./admin/show_projects.php">Show Projects</a></li>
				</ul>
			</li>
			<li class="dropdown">
				<a href="javascript:void(0);" class="dropdown-toggle">
					<span class="fa fa-users"></span><span class="mtext">Users</span>
				</a>
				<ul class="submenu">
					<li><a href="./admin/show_users.php">Show Users</a></li>
				</ul>
			</li>';
        break;
    }

    return $sidebar;
}
/* end Functions */
?>