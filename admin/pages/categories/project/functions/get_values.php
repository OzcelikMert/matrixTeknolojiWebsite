<?php
include_once("./config/config.php");


// Get Values
$Categories = GetCategories($conn);
// end Get Values

/* Functions */
function GetCategories($connect){
    $values = "";
    $sql = "SELECT 
    project_categories.id as CategoryId, 
    project_categories.name as CategoryName, 
    count(projects.category) as CategoryUseNumber
    FROM `project_categories`
    LEFT JOIN projects ON projects.category = project_categories.id
    GROUP BY CategoryId
    ORDER BY CategoryUseNumber desc, CategoryId asc";
    $query = mysqli_query($connect, $sql);
    while ($row = mysqli_fetch_array($query)) {
        $values .= '
        <tr id="category_'.$row["CategoryId"].'" category-name="'.$row["CategoryName"].'">
			<th scope="row" id="category_'.$row["CategoryId"].'_name">'.$row["CategoryName"].'</th>
			<th scope="row">'.$row["CategoryUseNumber"].'</th>
			<th scope="row"><a href="javascript:deleteCategory('.$row["CategoryId"].');" class="hover-link" style="color: #d70000;">Delete</a></th>
			<th scope="row"><a href="javascript:updateCategory('.$row["CategoryId"].');" class="hover-link" style="color: #0449e5;">Update</a></th>
	  	</tr>
        ';
    }
    return $values;
}
/* end Functions */
?>