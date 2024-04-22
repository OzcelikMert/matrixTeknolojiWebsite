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
$ReferenceName = ClearVariable($_POST["referencetitle"], "normal");
$Update_Message = UpdateReference($conn, $id, $ReferenceID, $ReferenceName, $PermissionRange);
echo json_encode($Update_Message);
// end Get and Set Values

/* Functions */
function UpdateReference($connect, $self_id, $referenceID, $New_referenceName, $self_permissionRange){
    if(strlen($New_referenceName) < 1){
        // Min Reference name character
        $values["title"] = "Empty Reference";
        $values["comment"] = "Reference name is empty! please fill the reference name.";
        $values["type"] = "error";
        return $values;
    } else if(strlen($New_referenceName) > 50){
        // Max Reference name character
        $values["title"] = "Max Length";
        $values["comment"] = "Reference name is very long!";
        $values["type"] = "error";
        return $values;
    }

    if ($self_permissionRange < 2) {
        // Permission OKAY
        $sql = "
        UPDATE reference
        SET title = '$New_referenceName'
        WHERE id = $referenceID
        ";
        if (mysqli_query($connect, $sql)) {
            // Update is succesfully
            $values["title"] = "Update is Successfully";
            $values["comment"] = "Reference name changed to '".$New_referenceName."'.";
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
/* end Functions */
?>