<?php
include_once("../../../../config/config.php");
// Session Info
session_start();
$email = $_SESSION["email"];
$id = GetID($conn, $email);
$PermissionRange = GetPermissionRange($conn, $id);
// end Session Info

// Get and Set Values
$ProjectID = ClearVariable($_POST["project_id"], "normal+number");
$Delete_Message = DeleteProject($conn, $ProjectID, $PermissionRange, $id);
echo json_encode($Delete_Message);
// end Get and Set Values

/* Functions */
function DeleteProject($connect, $Project_ID, $self_permissionRange, $self_id){
    // Project Control
    $sql_projectInfo = "select * from projects where id = ".(int)$Project_ID."";
    $query_projectInfo = mysqli_query($connect, $sql_projectInfo);
    if (mysqli_num_rows($query_projectInfo) > 0) {
        if ($row_projectInfo = mysqli_fetch_array($query_projectInfo)) {
            if ($self_permissionRange <= 2) {
                // Delete Project
                $sql_projectDelete = "delete from projects where id = ".(int)$Project_ID."";
                if (mysqli_query($connect, $sql_projectDelete)) {
                    // Delete is succesfully
                    $values["title"] = "Delete is Successfully";
                    $values["comment"] = "'".$row_projectInfo["title"]."' is deleted.";
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
        // No Project
        $values["title"] = "No Project";
        $values["comment"] = "Sorry, no such project found!";
        $values["type"] = "error";
        return $values;
    }
}
/* end Functions */
?>