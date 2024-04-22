<?php
include_once("./config/config.php");


// Get Values
$Blog_id = ClearVariable($_GET["blog_id"], "normal+number");
$GetBlogValues = GetBlogInfo($conn, $Blog_id);
$SelectedCategory = (isset($_POST["category"])) ? $_POST["category"] : $GetBlogValues["category"];
$Categories = GetCategories($conn, $SelectedCategory);
// end Get Values

/* Functions */
// Get Blog Info
function GetBlogInfo($connect, $blog_id){
    $values = array();
    $sql = "select * from blogs where id = ".(int)$blog_id."";
    $query = mysqli_query($connect, $sql);
    // Control Blog id
    if(mysqli_num_rows($query) > 0){
        // Get Values
        if($row = mysqli_fetch_array($query)){
            $values["main_image"] = $row["main_image"]; 
            $values["title"] = $row["title"];
            $values["content"] = $row["content"];
            $values["category"] = $row["category"];
            $values["seourl"] = $row["seourl"];
            $values["is_active"] = $row["is_active"];
            $values["fixed"] = $row["fixed"];
        }
    }else {
        // Wrong Blog id
        header("Location: dashboard.php");
    }

    return $values;
}
// Get Categories
function GetCategories($connect, $selectedCategory){
    $values = "";
    $sql = "SELECT 
    blog_categories.id as CategoryId, 
    blog_categories.name as CategoryName
    FROM `blog_categories`
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