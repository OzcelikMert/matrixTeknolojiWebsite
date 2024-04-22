<?php
include_once("./config/config.php");
// Session and Permission Control
$email = $_SESSION["email"];
$id = GetID($conn, $email);
$PermissionRange = GetPermissionRange($conn, $id);
// end Session and Permission Control

if ($_POST) {
    $category_name = ClearVariable($_POST["name"], "normal");
    $category_seo_name = convertUrl($category_name);
    if ($PermissionRange <= 1) {
        // Add Category
        $ErrorMessage = valueControl($conn, $category_name, $category_seo_name);
        if (empty($ErrorMessage)) {
            if (AddNew_Category($conn, $category_name, $category_seo_name)) {
                $ErrorMessage_show = '
                <div class="alert alert-success" role="alert" style="margin-top:10px;">
                    <h4>User is successfully registered!</h4>
                </div>
                ';
            }else {
                $ErrorMessage_show = '
                <div class="alert alert-danger" role="alert" style="margin-top:10px;">
                    <h4>Unknown error occurred please report to support.</h4>
                </div>
                ';
            }
        }else {
            $ErrorMessage_show = '
            <div class="alert alert-danger" role="alert" style="margin-top:10px;">
                '.$ErrorMessage.'
            </div>
            ';
        }
    }else {
        $ErrorMessage_show = '
        <div class="alert alert-danger" role="alert" style="margin-top:10px;">
            <h4>Insufficient permission!</h4>
        </div>
        ';
    }
}

/* Functions */
// Add New Blog Category
function AddNew_Category($connect, $c_name, $seourl){
    $sql = "insert into blog_categories(id, name, seourl)
    values (null, '".$c_name."', '".$seourl."')
    ";
    if (mysqli_query($connect, $sql)) {
        return true;
    }else {
        return false;
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
// Category Name control
function valueControl($connect ,$category_name_, $category_seo_name_){
    $errorMessage = "";
    // Category Name Control
    if (empty($category_name_)) {
        $errorMessage .= "<li>Please fill in the category name!</li>";
    }else if(strlen($category_name_) > 50){
        $errorMessage .= "<li>Category name is very long!</li>";
    }
    // Category Seo Name Control
    if (CategoryControl($connect, $category_seo_name_)) {
        $errorMessage .= '<li>The same category already exists!</li>';
    }
    return $errorMessage;
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