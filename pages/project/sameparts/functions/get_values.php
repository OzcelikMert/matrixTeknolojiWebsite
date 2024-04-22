<?php
include_once("./admin/config/config.php");

// GET Values
$get_category_value = ClearVariable($_GET["project_category"], "normal");
// end GET Values

// Get Variables
$Category_Values = GetCategory_Values($conn, $get_category_value);
$RecentProject_Values = GetRecentProject_Values($conn);
// end Get Variables


/* Functions */

// Get Categories
function GetCategory_Values($connect, $GET_value){
    $values = "";
    $sql = '
    select
    project_categories.name as ProjectCategory_Name,
    project_categories.seourl as ProjectCategory_Seourl,
    Count(projects.id) as TotalCount
    from project_categories
    INNER JOIN projects ON projects.category = project_categories.id
    where projects.is_active = "1"
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
        <li>
            <a href="projects.php?'.$href.'" class="tran3s '.$active.'">
                <i class="fa fa-hand-o-right" aria-hidden="true"></i>
                <span class="badge" style="background-color: #d73e4d;">
                    '.$row["TotalCount"].'
                </span> 
                '.$row["ProjectCategory_Name"].'
            </a>
        </li>
        ';
    }

    return $values;
}

// Get Recent Projects
function GetRecentProject_Values($connect){
    $values = "";
    $sql = "
    select 
    projects.main_image as Project_Logo,
    projects.title as Project_Title,
    projects.seourl as Project_Seourl,
    projects.date as Project_Date,
    project_categories.name as Project_Category,
    project_categories.seourl as Project_Category_Seourl
    from projects 
    INNER JOIN project_categories ON project_categories.id = projects.category 
    INNER JOIN accounts ON accounts.id = projects.shared_aid 
    where projects.is_active = '1' 
    ORDER BY Project_Date DESC 
    LIMIT 0, 5
    ";
    $query = mysqli_query($connect, $sql);
    while($row = mysqli_fetch_array($query)){
        $values .= '
        <div class="recent-single-post clear-fix">
	    	<img src="./images/project/logo/'.$row["Project_Logo"].'" alt="'.$row["Project_Title"].'" class="float-left" style="width: 50px; height: 50px;">
	    	<div class="post float-left">
	    		<a href="./project-detail.php?project='.$row["Project_Seourl"].'" class="tran3s">'.$row["Project_Title"].'</a> | 
	    		<span>'.substr($row["Project_Date"], 0, 10).'</span>
	    	</div>
	    </div>
        ';
    }

    return $values;
}

/* end Functions */
?>