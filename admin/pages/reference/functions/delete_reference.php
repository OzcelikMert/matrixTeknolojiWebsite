<?php
include_once("../../../config/config.php");
// Session Info
session_start();
$email = $_SESSION["email"];
$id = GetID($conn, $email);
$PermissionRange = GetPermissionRange($conn, $id);
// end Session Info

// Get and Set Values
$ReferenceID = ClearVariable($_POST["referenceid"], "normal+number");
$Delete_Message = DeleteReference($conn, $id, $ReferenceID, $PermissionRange);
echo json_encode($Delete_Message);
// end Get and Set Values

/* Functions */
function DeleteReference($connect, $self_id, $referenceID, $self_permissionRange){
    // Reference Control
    $sql_referenceInfo = "select * from reference where id = $referenceID";
    $query_referenceInfo = mysqli_query($connect, $sql_referenceInfo);
    if (mysqli_num_rows($query_referenceInfo) > 0) {
        // Get Reference Values
        if ($row_referenceInfo = mysqli_fetch_array($query_referenceInfo)) {
            // Permission Control
            if ($self_permissionRange < 2) {
                // Delete Reference
                $sql_referenceDelete = "delete from reference where id = $referenceID";
                if (mysqli_query($connect, $sql_referenceDelete)) {
                    // Delete is succesfully
                    $values["title"] = "Delete is Successfully";
                    $values["comment"] = "'".$row_referenceInfo["title"]."' is deleted.";
                    $values["type"] = "success";
                    return $values;
                }
            }else {
                // Low Permission
                $values["title"] = "Low Permission";
                $values["comment"] = "You cannot delete someone more authoritative than you!";
                $values["type"] = "error";
                if(AccountBanned($connect, $self_id, "You tried to find a bug in the site!", date("Y-m-d", strtotime("+3 day")))) { /* Account is banned **/ }
                return $values;
            }
        }
    }else {
        // No Account
        $values["title"] = "No Reference";
        $values["comment"] = "Sorry, no such reference found!";
        $values["type"] = "error";
        return $values;
    }
}
/* end Functions */
?>