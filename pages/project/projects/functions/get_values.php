<?php
include_once("./admin/config/config.php");

// GET Values
$get_category_value = ClearVariable($_GET["project_category"], "normal");
$get_text_value = ClearVariable($_GET["wanted_text"], "normal");
$get_page_number = ClearVariable($_GET["page"], "normal+number");
$get_page_number = (!empty($get_page_number)) ? $get_page_number : 0;
// end GET Values

// Values //
$SortCount = 6;
$Button_Values = GetPageButton_Values($conn, $get_text_value, $get_category_value, $get_page_number);

// Page Number Max Min Control
if($get_page_number < $Button_Values["min"]){
    $get_page_number = $Button_Values["min"];
}else if ($get_page_number > $Button_Values["max"]){
    $get_page_number = $Button_Values["max"];
}
$min = ($get_page_number - 1 >= 0) ? $SortCount * ($get_page_number - 1) : 0;
$max = $SortCount;
// end Page Number Max Min Control

$Project_Values = GetProject_Values($conn, $get_text_value, $get_category_value, $min, $max);
// end Values //


/* Functions */

// Get All Projects
function GetProject_Values($connect, $wanted_text, $wanted_category, $min, $max){
    $where_category = (!empty($wanted_category)) ? " and project_categories.seourl = '".$wanted_category."'" : "";
    $where_category .= (!empty($wanted_text)) ? " and projects.title like '%".$wanted_text."%'" : "";
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
    where projects.is_active = '1' $where_category
    ORDER BY Project_Date DESC 
    LIMIT $min, $max
    ";
    $query = mysqli_query($connect, $sql);
    while ($row = mysqli_fetch_array($query)) {
        $values .= '
        <div class="mix grid-item '.$row["Project_Category_Seourl"].'" style="padding-bottom: 0px;">
			<div class="single-img" style="margin-top: 55px;">
				<img src="./images/project/logo/'.$row["Project_Logo"].'" alt="'.$row["Project_Title"].'" style="min-height: 240px; max-height: 240px;">
				<div class="opacity">
					<div class="border-shape">
						<div>
							<div>
								<h6><a href="project-detail.php?project='.$row["Project_Seourl"].'">'.$row["Project_Title"].'</a></h6>
								<ul>
									<li>'.$row["Project_Category"].' / </li>
									<li>'.substr($row["Project_Date"], 0, 10).'</li>
								</ul>
							</div>
						</div>
					</div>
				</div>
			</div>
        </div>
        ';
	}
    
    if(empty($values)){
        $values .= "<p style='color: red; font-size: 20px;'>Üzgünüz. Hiç bir sonuç bulunamadı!</p>";
    }

    return $values;
}
// end Get All Projects

// Get Page Buttons
function GetPageButton_Values($connect, $wanted_text, $wanted_category, $page_number){
    $values = array();
    $values["min"] = 1;

    // GET Control
    $link_category = (!empty($wanted_category)) ? "&project_category=" . $wanted_category : "";
    $link_category .= (!empty($wanted_text)) ? "&wanted_text=" . $wanted_text : "";

    $where_category = (!empty($wanted_category)) ? " and project_categories.seourl = '".$wanted_category."'" : "";
    $where_category .= (!empty($wanted_text)) ? " and projects.title like '%".$wanted_text."%'" : "";
    // end GET Control

    // Get Count
    $count = 0;
    $sql = "
    select 
    count(*) as Count_
    from projects
    LEFT JOIN project_categories ON project_categories.id = projects.category
    INNER JOIN accounts ON accounts.id = projects.shared_aid
    where projects.is_active = '1' $where_category
	";
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
        $values["buttons"] .= '<a href="./projects.php?'.$link_category.'&page='.$values["min"].'" class="btn btn-outline-primary"><i class="fa fa-angle-double-left"></i></a>';
        for ($i=1; $i <= $values["max"]; $i++) {
            $button_range = $i - $page_number;
            if(($button_range >= -2 ) && ($button_range <= 2 )){
                if(($i) == $page_number){
                    // Equals Page number
                    $values["buttons"] .= '<span class="btn btn-primary">'.$i.'</span>';
                }else{
                    // Normal Page Button Button
                    $values["buttons"] .= '<a href="./projects.php?'.$link_category.'&page='.$i.'" class="btn btn-outline-primary">'.$i.'</a>';
                }
            }
        }
        $values["buttons"] .= '<a href="./projects.php?'.$link_category.'&page='.$values["max"].'" class="btn btn-outline-primary"><i class="fa fa-angle-double-right"></i></a>';
        // end Calculate Buttons
    }

    return $values;
}
// end Get Page Buttons

/* end Functions */
?>