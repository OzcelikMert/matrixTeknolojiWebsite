<?php
include_once("./config/config.php");


// Get Values
$Selected_Category = ClearVariable($_POST["category"], "normal+number");
$Categories = GetCategories($conn, $Selected_Category);
// end Get Values

/* Functions */
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