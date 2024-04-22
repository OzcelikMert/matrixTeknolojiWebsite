<?php
include_once("./config/config.php");


// Get Values
$Project_id = ClearVariable($_GET["project_id"], "normal+number");
$GetProjectValues = GetProjectInfo($conn, $Project_id);
$SelectedCategory = (isset($_POST["category"])) ? $_POST["category"] : $GetProjectValues["category"];
$Categories = GetCategories($conn, $SelectedCategory);
// end Get Values

/* Functions */
// Get Project Info
function GetProjectInfo($connect, $project_id){
    $values = array();
    $sql = "select * from projects where id = ".(int)$project_id."";
    $query = mysqli_query($connect, $sql);
    // Control Project id
    if(mysqli_num_rows($query) > 0){
        // Get Values
        if($row = mysqli_fetch_array($query)){
            $values["main_image"] = $row["main_image"]; 
            $values["title"] = $row["title"];
            $values["content"] = $row["content"];
            $values["category"] = $row["category"];
            $values["seourl"] = $row["seourl"];
            $values["is_active"] = $row["is_active"];
        }
    }else {
        // Wrong Project id
        header("Location: dashboard.php");
    }

    return $values;
}
// Get Categories
function GetCategories($connect, $selectedCategory){
    $values = "";
    $sql = "SELECT 
    project_categories.id as CategoryId, 
    project_categories.name as CategoryName
    FROM `project_categories`
    ORDER BY CategoryName asc";
    $query = mysqli_query($connect, $sql);
    while ($row = mysqli_fetch_array($query)) {
        $selected = "";
        if ($selectedCategory == $row["CategoryId"]) {
            $selected = "selected";
        }
        $values .= '
        <option value="'.$row["CategoryId"].'" '.$selected.'>'.$row["CategoryName"].'</option>
        ';
    }
    return $values;
}
/* end Functions */
?>