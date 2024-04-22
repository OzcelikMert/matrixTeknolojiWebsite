<?php
include_once("../../../../config/config.php");
// Session Info
session_start();
$email = $_SESSION["email"];
$id = GetID($conn, $email);
$PermissionRange = GetPermissionRange($conn, $id);
// end Session Info

// Get and Set Values
$SliderID = ClearVariable($_POST["slider_id"], "normal+number");
$Delete_Message = DeleteSlider($conn, $SliderID, $PermissionRange, $id);
echo json_encode($Delete_Message);
// end Get and Set Values

/* Functions */
function DeleteSlider($connect, $Slider_ID, $self_permissionRange, $self_id){
    // Slider Control
    $sql_sliderInfo = "select * from top_slider where id = ".(int)$Slider_ID."";
    $query_sliderInfo = mysqli_query($connect, $sql_sliderInfo);
    if (mysqli_num_rows($query_sliderInfo) > 0) {
        if ($row_sliderInfo = mysqli_fetch_array($query_sliderInfo)) {
            if ($self_permissionRange <= 2) {
                // Delete Slider
                $sql_sliderDelete = "delete from top_slider where id = ".(int)$Slider_ID."";
                if (mysqli_query($connect, $sql_sliderDelete)) {
                    // Delete is succesfully
                    UpdateSliderRank($connect);
                    $values["title"] = "Delete is Successfully";
                    $values["comment"] = "'".$row_sliderInfo["title"]."' is deleted.";
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
        }
    }else {
        // No Slider
        $values["title"] = "No Slider";
        $values["comment"] = "Sorry, no such slider found!";
        $values["type"] = "error";
        return $values;
    }
}
// Update Other Slider rank
function UpdateSliderRank($connect){
    $sql_show = "select id, rank from top_slider order by rank asc";
    $query_show = mysqli_query($connect, $sql_show);
    $rank = 0;
    while($row = mysqli_fetch_array($query_show)){
        $rank++;
        $sql_update = "update top_slider set rank = '".$rank."' where id = ".$row["id"]."";
        if(mysqli_query($connect, $sql_update)){ /* Updated new rank */ }
    }
}
/* end Functions */

?>