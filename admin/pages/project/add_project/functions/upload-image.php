<?php
// Get File
$image = empty($_FILES['image']) ? '' : $_FILES['image'];
// File Check
if (!empty($image))
{
    if ($image['size'] > 0)
    {
        $newname = date("YmdHis")."_".rand(0, 999);
        $imageSource = uploadImages($image, $newname, "", "./images/project/");
        echo $imageSource;
    }
}

/* Functions */
function uploadImages($file, $newName, $uploadFile, $locationUrl){
    $destination = "../../../../../images/project/".$newName.".webp";
    $upload = move_uploaded_file($file['tmp_name'], $destination);
    if (!empty($upload))
    {
        // here is the url to locate we image
        return $locationUrl.$newName.".webp";
    }
}
/* end Functions */
?>