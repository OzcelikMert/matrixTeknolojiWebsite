<?php
include_once("../../../config/config.php");
session_start();
// Account Control
$email = $_SESSION["email"];
$id = GetID($conn, $email);
// end Account Control
if ($_POST) {
    // Cleaning Variable
    $image = $_FILES["image"]["tmp_name"];
    if(!empty($image)){
        $newName = date("YmdHis")."_".rand(0, 999).".webp";
        if(Update_AccountImage($conn, $newName, $id)){
            Upload_Image($image, $newName);
            echo $newName;
        }
    }
}

/* Functions */
// Update Account Image
function Update_AccountImage($connect, $image, $id){
    $sql = "update accounts set image = '".$image."' where id=".(int)$id."";
    if (mysqli_query($connect, $sql)) {
        return "Success";
    }else {
        return "Error: ".mysqli_error($connect);
    }
}
// end Update Account Image

// Upload Image
function Upload_Image($file, $newName){
    $destination = "../../../../images/account/".$newName;
    move_uploaded_file($file, $destination);
}
// end Upload Image
/* end Functions */
?>