<?php
include_once("./config/config.php");
// sameparts/accounts_settings -> have: $email, $id , $permission and all permissions
// GET Values
$get_category_value = ClearVariable($_GET["project_category"], "normal");
$get_page_number = ClearVariable($_GET["page"], "normal+number");
$get_page_number = (!empty($get_page_number)) ? $get_page_number : 0;
// end GET Values


// Values //
$SortCount = 6;
$Buttons = GetPageButtons($conn, $get_category_value, $get_page_number);
// Page Number Max Min Control
if($get_page_number < $Buttons["min"]){
    $get_page_number = $Buttons["min"];
}else if ($get_page_number > $Buttons["max"]){
    $get_page_number = $Buttons["max"];
}
$min = ($get_page_number - 1 >= 0) ? $SortCount * ($get_page_number - 1) : 0;
$max = $SortCount;
// end Page Number Max Min Control
$Projects = GetProjects($conn, $permission, $NormalUser, $get_category_value, $min, $max);
$Categories = GetCategories($conn, $get_category_value);
// end Values //

/* Functions */
// Get Projects
function GetProjects($connect, $permission, $maxPermission, $wanted_category, $min, $max){
    $where_category = (!empty($wanted_category)) ? "where project_categories.seourl = '".$wanted_category."'" : "";
    $values = "";
    $sql = "
    select 
    projects.id as Project_Id,
    projects.main_image as Project_Logo,
    projects.title as Project_Title,
    projects.date as Project_Date,
    projects.is_active as Project_Active,
    project_categories.name as Project_Category,
    project_categories.seourl as Project_Category_Seourl,
    accounts.nickname as Project_SharedName
    from projects
    LEFT JOIN project_categories ON project_categories.id = projects.category
    INNER JOIN accounts ON accounts.id = projects.shared_aid
    $where_category 
    ORDER BY Project_Active ASC, projects.date DESC
    LIMIT $min, $max
    ";
    $query = mysqli_query($connect, $sql);
    while ($row = mysqli_fetch_array($query)) {
        $li_bg = "#ffffff";
        $Delete_src = "";
        $Edit_src = "";
        $projectCategory = $row["Project_Category"];
        $projectCategory_url = './admin/show_projects.php?project_category='.$row["Project_Category_Seourl"].'';
        // Is Active Control
        if($row["Project_Active"] != "1") {
            $li_bg = "#ffd6ab";
        }
        // Permission Control
        if ($permission < $maxPermission) {
            $Edit_src = '<a href="./admin/edit_project_page.php?project_id='.$row["Project_Id"].'" class="btn btn-outline-primary">Edit</a>';
            $Delete_src = '<a href="javascript:ProjectDelete('.$row["Project_Id"].');" class="btn btn-outline-danger">Delete</a>';
        }
        // Category Control
        if(empty($projectCategory)){
            $projectCategory = "<font color='red'>Null Category</font>";
            $projectCategory_url = "javascript:void(0);";
        }

        $values .= '
        <li id="Project_'.$row["Project_Id"].'" project-title="'.$row["Project_Title"].'" style="background-color: '.$li_bg.';">
			<div class="row no-gutters">
				<div class="col-lg-4 col-md-12 col-sm-12">
					<div class="blog-img" style="background: url(\'./images/project/logo/'.$row["Project_Logo"].'\'); center center no-repeat;">
						<img src="./images/project/logo/'.$row["Project_Logo"].'" alt="'.$row["Project_Title"].'" class="bg_img" style="display: none;">
					</div>
				</div>
				<div class="col-lg-8 col-md-12 col-sm-12">
                    <div class="blog-caption">
                        '.$fixed.'
						<h4><a href="#">'.$row["Project_Title"].'</a></h4>
						<div class="blog-by">
							<p>Date:  <small>'.$row["Project_Date"].'</small></p>
							<p>Category: <a href="'.$projectCategory_url.'"><b>'.$projectCategory.'</b></a></p>
							<p>Shared by: <b>'.$row["Project_SharedName"].'</b></p>
							<div class="pt-10">
								'.$Edit_src.'
								'.$Delete_src.'
							</div>
						</div>
					</div>
				</div>
			</div>
		</li>
        ';
    }
    return $values;
}
// Get Categories
function GetCategories($connect, $GET_value){
    $values = "";
    $sql = '
    select
    project_categories.name as ProjectCategory_Name,
    project_categories.seourl as ProjectCategory_Seourl,
    Count(projects.id) as TotalCount
    from project_categories
    LEFT JOIN projects ON projects.category = project_categories.id
    GROUP BY project_categories.id
    ORDER BY ProjectCategory_Name ASC
    ';
    $query = mysqli_query($connect, $sql);
    while ($row = mysqli_fetch_array($query)) {
        // Href GET Link
        $href = 'project_category='.$row["ProjectCategory_Seourl"].'';
        // Active Control
        $active = "";
        if($GET_value == $row["ProjectCategory_Seourl"]){
            $active = "active"; 
            $href = "";
        }
        // Get Count
        $category_count = 0;
        $category_count = $row["TotalCount"];
        // Get Values
        $values .= '
        <a href="./admin/show_projects.php?'.$href.'" class="list-group-item d-flex align-items-center justify-content-between '.$active.'">
            '.$row["ProjectCategory_Name"].' 
            <span class="badge badge-primary badge-pill">
            '.$category_count.'
            </span>
        </a>
        ';
    }
    return $values;
}
// Get Page Buttons
function GetPageButtons($connect, $wanted_category, $page_number){
    $values = array();
    $values["min"] = 1;

    // GET Control
    $link_category = (!empty($wanted_category)) ? "&project_category=" . $wanted_category : "";
    $where_category = (!empty($wanted_category)) ? "where project_categories.seourl = '".$wanted_category."'" : "";
    // end GET Control

    // Get Count
    $count = 0;
    $sql = "
    select 
    count(*) as Count_
    from projects
    LEFT JOIN project_categories ON project_categories.id = projects.category
    INNER JOIN accounts ON accounts.id = projects.shared_aid
    $where_category";
    $query = mysqli_query($connect, $sql);
    if($row = mysqli_fetch_array($query)){
        $count = $row["Count_"];
    }
    // end Get Count

    if($count > 0){
        // Calculate Buttons
        $values["max"] = ceil($count / 6);
        // Max Min Control
        if($page_number < $values["min"]){
            $page_number = $values["min"];
        }else if ($page_number > $values["max"]){
            $page_number = $values["max"];
        }
        // end Max Min Control
        $values["buttons"] .= '<a href="./admin/show_projects.php?'.$link_category.'&page='.$values["min"].'" class="btn btn-outline-primary prev"><i class="fa fa-angle-double-left"></i></a>';
        for ($i=1; $i <= $values["max"]; $i++) {
            $button_range = $i - $page_number;
            if(($button_range >= -2 ) && ($button_range <= 2 )){
                if(($i) == $page_number){
                    // Equals Page number
                    $values["buttons"] .= '<span class="btn btn-primary current">'.$i.'</span>';
                }else{
                    // Normal Page Button Button
                    $values["buttons"] .= '<a href="./admin/show_projects.php?'.$link_category.'&page='.$i.'" class="btn btn-outline-primary">'.$i.'</a>';
                }
            }
        }
        $values["buttons"] .= '<a href="./admin/show_projects.php?'.$link_category.'&page='.$values["max"].'" class="btn btn-outline-primary prev"><i class="fa fa-angle-double-right"></i></a>';
        // end Calculate Buttons
    }

    return $values;
}
/* end Functions */
?>