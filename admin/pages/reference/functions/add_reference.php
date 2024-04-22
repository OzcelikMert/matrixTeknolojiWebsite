<?php
include_once("./config/config.php");
// Session and Permission Control
$email = $_SESSION["email"];
$id = GetID($conn, $email);
$PermissionRange = GetPermissionRange($conn, $id);
// end Session and Permission Control

if ($_POST) {
    $reference_title = ClearVariable($_POST["title"], "normal");
    $reference_image = $_FILES["image"]["tmp_name"];
    // check permission get_Values.php -> maxpermissionrange
    if ($PermissionRange <= $maxPermissionRange) {
        // Value Control
        $ErrorMessage = valueControl($reference_title, $reference_image);
        if (empty($ErrorMessage)) {
            // Add Reference
            $newName = date("YmdHis")."_".rand(0, 999).".jpeg";
            if (AddNew_Category($conn, $reference_title, $newName)) {
                Upload_ReferenceImage($reference_image, $newName);
                header("Location: reference.php");
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
            <h4>Low permission!</h4>
        </div>
        ';
    }
}

/* Functions */
// Add New Blog Category
function AddNew_Category($connect, $title, $image){
    $sql = "insert into reference(id, title, image)
    values (null, '".$title."', '".$image."')
    ";
    if (mysqli_query($connect, $sql)) {
        return true;
    }else {
        return false;
    }
}
// Category Name control
function valueControl($title, $image){
    $errorMessage = "";

    // Reference Title Control
    if (empty($title)) {
        $errorMessage .= "<li>Please fill in the reference title!</li>";
    }else if(strlen($title) > 75){
        $errorMessage .= "<li>Reference title is very long!</li>";
    }

    // Reference Image Control
    if (empty($image)) {
        $errorMessage .= "<li>Please select a reference logo!</li>";
    }

    return $errorMessage;
}
// Upload Slider Image
function Upload_ReferenceImage($file, $newName){
    $destination = "../images/reference/".$newName;
    move_uploaded_file($file, $destination);
}
/* end Functions */
?>