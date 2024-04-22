<?php
include_once("../../../config/config.php");
// Session Info
session_start();
$email = $_SESSION["email"];
$id = GetID($conn, $email);
$PermissionRange = GetPermissionRange($conn, $id);
// end Session Info

// Get and Set Values
$ImageURL = "../../../../images/";
$ImageURL .= ClearVariable($_POST["image_url"], "normal");
$Delete_Message = DeleteImage($ImageURL, $PermissionRange, $id);
echo json_encode($Delete_Message);
// end Get and Set Values

/* Functions */
function DeleteImage($Image_URL, $self_permissionRange, $self_id){
    // Image Control
    if (file_exists($Image_URL)) {
            if ($self_permissionRange <= 2) {
                // Image Delete
                if (unlink($Image_URL)) {
                    // Delete is succesfully
                    $values["title"] = "Delete is Successfully";
                    $values["comment"] = "'".$Image_URL."' is deleted.";
                    $values["type"] = "success";
                    return $values;
                }
            }else {
                // Low Permission
                $values["title"] = "Low Permission";
                $values["comment"] = "You cannot delete someone more authoritative than you!";
                $values["type"] = "error-lp";
                // Account Banned
                if(AccountBanned($connect, $self_id, "You tried to find a bug in the site!", date("Y-m-d", strtotime("+3 day")))) { /* Account is banned **/ }
                return $values;
            }
    }else {
        // No Slider
        $values["title"] = "No Image";
        $values["comment"] = "Sorry, no such Image found!";
        $values["type"] = "error";
        return $values;
    }
}
/* end Functions */

?>