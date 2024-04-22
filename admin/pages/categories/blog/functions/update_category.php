<?php
include_once("../../../../config/config.php");
// Session Info
session_start();
$email = $_SESSION["email"];
$id = GetID($conn, $email);
$PermissionRange = GetPermissionRange($conn, $id);
// end Session Info

// Get and Set Values
$CategoryID = ClearVariable($_POST["categoryid"], "normal+number");
$CategoryName = ClearVariable($_POST["categoryname"], "normal");
$Update_Message = UpdateCategory($conn, $CategoryID, $CategoryName, $PermissionRange);
echo json_encode($Update_Message);
// end Get and Set Values

/* Functions */
function UpdateCategory($connect, $categoryID, $New_categoryName, $self_permissionRange){
    if(strlen($New_categoryName) < 1){
        // Min Reference name character
        $values["title"] = "Empty category name";
        $values["comment"] = "Category name is empty! please fill the category name.";
        $values["type"] = "error";
        return $values;
    } else if($New_categoryName > 50){
        // Max Catergory name character
        $values["title"] = "Max Length";
        $values["comment"] = "Category name is very long!";
        $values["type"] = "error";
        return $values;
    }
    // convert category name to seo name and Control
    $new_categorySeoName = convertUrl($New_categoryName);
    if (!CategoryControl($connect, $new_categorySeoName)) {
        // Not Already Exist
        if ($self_permissionRange < 2) {
            // Permission OKAY
            $sql = "
            UPDATE blog_categories
            SET name = '$New_categoryName', seourl = '$new_categorySeoName'
            WHERE id = $categoryID
            ";
            if (mysqli_query($connect, $sql)) {
                // Update is succesfully
                $values["title"] = "Update is Successfully";
                $values["comment"] = "Category name changed to '".$New_categoryName."'.";
                $values["type"] = "success";
                return $values;
            }
        }else {
            // Low Permission
            $values["title"] = "Low Permission";
            $values["comment"] = "You cannot delete someone more authoritative than you!";
            $values["type"] = "error";
            return $values;
        }
    }else {
        // Already Exist
        $values["title"] = "Already Exist";
        $values["comment"] = "Such a category already exists!";
        $values["type"] = "error";
        return $values;
    }
}
// Convert Seo Url
function convertUrl($url) {
    // Convert Seo Url
    $tr = array('ş','Ş','ı','I','İ','ğ','Ğ','ü','Ü','ö','Ö','Ç','ç','(',')','/',':',',','!');
    $eng = array('s','s','i','i','i','g','g','u','u','o','o','c','c','','','-','-','','');
    $url = str_replace($tr, $eng, $url);
    $url = strtolower($url);
    $url = preg_replace('/&amp;amp;amp;amp;amp;amp;amp;amp;amp;.+?;/', '', $url);
    $url = preg_replace('/\s+/', '-', $url);
    $url = preg_replace('|-+|', '-', $url);
    $url = preg_replace('/#/', '', $url);
    $url = str_replace('.', '', $url);
    $url = str_replace("'", '', $url);
    $url = trim($url, '-');
    // end Convert Seo Url

    return $url;
}
// Category Control
function CategoryControl($connect, $seo_name_){
    $sql="SELECT * FROM blog_categories where seourl = '$seo_name_'";
    if($result = mysqli_query($connect, $sql)){
        if(mysqli_num_rows($result) > 0){
            return true;
        }else{
            return false;
        }
    }
}
/* end Functions */
?>