<?php 
include_once("./config/config.php");
// sameparts/accounts_settings -> have: $email, $id , $permission and all permissions
/* GET Values */
$Blogs = GetBlogs($conn, $permission, $NormalUser);
$Projects = GetProjects($conn, $permission, $NormalUser);
$Registereds = getRegistereds($conn, $permission, $Author);

if($permission < $Author){
	$TotalView = getTotal_view($conn);
	$TotalBlog = getTotal_blog($conn);
}
/* end GET Values */

/*	Functions */

// Get Blogs
function GetBlogs($connect, $permission, $maxPermission){
    $values = "";
    $sql = "
    select 
    blogs.id as Blog_Id,
    blogs.main_image as Blog_Logo,
	blogs.title as Blog_Title,
	blogs.content as Blog_Content,
    blogs.date as Blog_Date,
    blogs.is_active as Blog_Active,
    blogs.fixed as Blog_Fixed,
	blog_categories.name as Blog_Category,
	blog_categories.seourl as Blog_Category_Seourl,
    accounts.nickname as Blog_SharedName
    from blogs
    INNER JOIN blog_categories ON blog_categories.id = blogs.category
    INNER JOIN accounts ON accounts.id = blogs.shared_aid
    ORDER BY blogs.date DESC
    LIMIT 0, 3
    ";
    $query = mysqli_query($connect, $sql);
    while ($row = mysqli_fetch_array($query)) {
        $fixed = "";
		$li_bg = "#ffffff";
		$blogCategory = $row["Blog_Category"];
		$blogCategory_url = './admin/edit_blog.php?blog_category='.$row["Blog_Category_Seourl"].'';
		$editBlog = "";
        // Is Active Control
        if($row["Blog_Active"] != "1") {
            $li_bg = "#ffd6ab";
        }
        // Fixed Control
        if($row["Blog_Fixed"] == "1") {
            $fixed = '| <i class="fa fa-thumb-tack" style="color: blue;" title="Fixed"></i>';
		}
		// Category Control
        if(empty($blogCategory)){
            $blogCategory = "<font color='red'>Null Category</font>";
            $blogCategory_url = "javasciprt:void(0);";
		}
		// Permission Control
		if($permission < $maxPermission){
			$editBlog = '<li class="pl-1"><a href="./admin/edit_blog_page.php?blog_id='.$row["Blog_Id"].'" title="Edit"><i class="fa fa-edit"></i></a></li>';
		}
		
        $values .= '
        <div class="card">
            <div class="da-card">
                <div class="da-card-photo">
        	        <img class="card-img-top" src="./images/blog/logo/'.$row["Blog_Logo"].'" alt="'.$row["Blog_Title"].'" title="'.$row["Blog_Title"].'" style="max-height: 300px; min-height: 300px;">
                    <div class="da-overlay">
    		    	    <div class="da-social">
    		    	    	<ul class="clearfix">
    		    	    		<li><a href="#" title="Show"><i class="fa fa-eye"></i></a></li>
    		    	    		'.$editBlog.'
    		    	    	</ul>
    		    	    </div>
                    </div>
                </div>
            </div>
        	<div class="card-body">
        		<h5 class="card-title">'.$row["Blog_Title"].'</h5>
        		<p class="card-text">'.strip_tags(substr($row["Blog_Content"], 0, 50)).'</p>
        		<p class="card-text"><small class="text-muted">'.$row["Blog_Date"].' | <a href="'.$blogCategory_url.'" style="color:#0e23bb;">'.$blogCategory.'</a> | '.$row["Blog_SharedName"].' '.$fixed.'</small></p>
        	</div>
        </div>
        ';
    }
    return $values;
}

// Get Projects
function GetProjects($connect, $permission, $maxPermission){
    $values = "";
    $sql = "
    select 
    projects.id as Project_Id,
    projects.main_image as Project_Logo,
	projects.title as Project_Title,
	projects.content as Project_Content,
    projects.date as Project_Date,
    projects.is_active as Project_Active,
	project_categories.name as Project_Category,
	project_categories.seourl as Project_Category_Seourl,
    accounts.nickname as Project_SharedName
    from projects
    LEFT JOIN project_categories ON project_categories.id = projects.category
    INNER JOIN accounts ON accounts.id = projects.shared_aid
    ORDER BY projects.date DESC
    LIMIT 0, 3
    ";
    $query = mysqli_query($connect, $sql);
    while ($row = mysqli_fetch_array($query)) {
		$projectCategory = $row["Project_Category"];
		$projectCategory_url = './admin/edit_project.php?project_category='.$row["Project_Category_Seourl"].'';
		$editProject = "";
        // Category Control
        if(empty($projectCategory)){
            $projectCategory = "<font color='red'>Null Category</font>";
            $projectCategory_url = "javascript:void(0);";
        }

        $li_bg = "#ffffff";
        // Is Active Control
        if($row["Project_Active"] != "1") {
            $li_bg = "#ffd6ab";
		}

		// Project Content
		$projectContent = substr($row["Project_Content"], 0, 50);
		$projectContent = strip_tags($projectContent);

		// Permission Control
		if($permission < $maxPermission){
			$editProject = '<li class="pl-1"><a href="./admin/edit_project_page.php?project_id='.$row["Project_Id"].'" title="Edit"><i class="fa fa-edit"></i></a></li>';
		}

        $values .= '
        <div class="card">
            <div class="da-card">
                <div class="da-card-photo">
        	        <img class="card-img-top" src="./images/project/logo/'.$row["Project_Logo"].'" alt="'.$row["Project_Title"].'" title="'.$row["Project_Title"].'" style="max-height: 300px; min-height: 300px;">
                    <div class="da-overlay">
    		    	    <div class="da-social">
    		    	    	<ul class="clearfix">
    		    	    		<li><a href="#" title="Show"><i class="fa fa-eye"></i></a></li>
    		    	    		'.$editProject.'
    		    	    	</ul>
    		    	    </div>
                    </div>
                </div>
            </div>
        	<div class="card-body">
        		<h5 class="card-title">'.$row["Project_Title"].'</h5>
        		<p class="card-text">'.$projectContent.'</p>
        		<p class="card-text"><small class="text-muted">'.$row["Project_Date"].' | <a href="'.$projectCategory_url.'" style="color:#0e23bb;">'.$projectCategory.'</a> | '.$row["Project_SharedName"].'</small></p>
        	</div>
        </div>
        ';
    }
    return $values;
}

// GET REGISTEREDS
function getRegistereds($connect, $permission, $maxPermission){
	$registereds = "";
	$sql = "select 
	accounts.name as AccountName,
	accounts.surname as AccountSurname,
	accounts.nickname as AccountNickname,
	accounts.email as AccountEmail,
	accounts.register_date as AccountRegisterDate,
	permissions.name as PermissionName
	from accounts 
	INNER JOIN permissions ON permissions.id = accounts.permission
	order by register_date desc limit 0, 7";
	$query = mysqli_query($connect, $sql);
	while($row = mysqli_fetch_array($query)){
		$permissionName = "Hidden";
		// Permission Control
		if($permission < $maxPermission){
			$permissionName = $row["PermissionName"];
		}

		$registereds .= '
		<tr>
			<th scope="row">'.$row["AccountName"]." ".$row["AccountSurname"].'</th>
			<th scope="row">'.$row["AccountNickname"].'</th>
			<th scope="row">'.$row["AccountEmail"].'</th>
			<th scope="row">'.$permissionName.'</th>
			<th scope="row">'.$row["AccountRegisterDate"].'</th>
	  	</tr>
		';
	}
	return $registereds;
}
// end GET REGISTEREDS

// Get Total View
function getTotal_view($connect){
	$count = 0;
	$sql = "select count(*) as Count_ from view_list";
	$query = mysqli_query($connect, $sql);
	if($row = mysqli_fetch_array($query)){
		$count = $row["Count_"];
	}
	return $count;
}
// end Get Total View

// Get Total View
function getTotal_blog($connect){
	$count = 0;
	$sql = "select count(*) as Count_ from blogs";
	$query = mysqli_query($connect, $sql);
	if($row = mysqli_fetch_array($query)){
		$count = $row["Count_"];
	}
	return $count;
}
// end Get Total View

/* end Functions */
?>