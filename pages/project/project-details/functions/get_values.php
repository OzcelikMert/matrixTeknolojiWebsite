<?php
include_once("./admin/config/config.php");

// GET Values
$project_seo_name = ClearVariable($_GET["project"], "normal");
// end GET Values

// Values //
$Project_Values = GetProject_Values($conn, $project_seo_name);

// Values Empty Control
if(empty($Project_Values)){
    header("Location: projects.php");
}
// end Values //


/* Functions */

// Get Project
function GetProject_Values($connect, $project_seo_name){
    $values = "";
    $sql = "
    select 
    projects.main_image as Project_Logo,
    projects.title as Project_Title,
    projects.content as Project_Content,
    projects.date as Project_Date,
    project_categories.name as Project_Category,
    project_categories.seourl as Project_Category_Seourl
    from projects 
    INNER JOIN project_categories ON project_categories.id = projects.category 
    INNER JOIN accounts ON accounts.id = projects.shared_aid 
    where projects.seourl = '$project_seo_name'
    ";
    $query = mysqli_query($connect, $sql);
    if ($row = mysqli_fetch_array($query)) {
		$values .= '
        <img src="images/project/logo/'.$row["Project_Logo"].'" alt="'.$row["Project_Title"].'" title="'.$row["Project_Title"].'">
        <div class="post-heading">
        	<h4>'.$row["Project_Title"].'</h4>
        	<span>Tarih: '.$row["Project_Date"].' | <a href="./projects.php?project_category='.$row["Project_Category_Seourl"].'" class="tran3s active">'.$row["Project_Category"].'</a></span>
        </div>
        '.$row["Project_Content"].'
        ';
	}

    return $values;
}
// end Get Project

/* end Functions */
?>