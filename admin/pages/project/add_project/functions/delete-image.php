<?php
// Get File
$image = empty($_POST['image']) ? '' : $_POST['image'];
// File Check
if (!empty($image))
{
        $image = str_replace("https://".$_SERVER["SERVER_NAME"], '', $image);
        $imageSource = deleteImages($image);
}

/* Functions */
function deleteImages($name){
    $destination = "../../../../..".$name;
    if(unlink($destination)){
        echo "ok";
    }else {
        echo "error";
    }
}
/* end Functions */
?>