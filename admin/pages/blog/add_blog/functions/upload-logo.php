<?php
// Get File
$image = empty($_FILES['image']['tmp_name']) ? '' : $_FILES['image']['tmp_name'];

$newname = date("YmdHis")."_".rand(0, 999);
$imageSource = uploadImages($image, $newname, "", "../../../../../images/blog/logo/");

/* Functions */
function uploadImages($file, $newName, $uploadFile, $locationUrl){
    $destination = $locationUrl.$newName.".jpeg";
    $upload = move_uploaded_file($file, $destination);
    if (!empty($upload))
    {
        // here is the url to locate your image, you need to change it.
        echo $newName;
        
    }else {
        echo "Error";
    }
}
/* end Functions */
?>