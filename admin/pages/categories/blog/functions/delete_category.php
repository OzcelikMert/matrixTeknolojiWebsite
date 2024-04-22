<?php
include_once("../../../../config/config.php");
// Session Info
session_start();
$email = $_SESSION["email"];
$id = GetID($conn, $email);
$PermissionRange = GetPermissionRange($conn, $id);
// end Session Info

// Get and Set Values
$CategoryID = ClearVariable($_POST["categoryid"], "normal+number");
$Delete_Message = DeleteCategory($conn, $CategoryID, $PermissionRange);
echo json_encode($Delete_Message);
// end Get and Set Values

/* Functions */
function DeleteCategory($connect, $categoryID, $self_permissionRange){
    $sql_categoryInfo = "select * from blog_categories where id = '$categoryID'";
    $query_categoryInfo = mysqli_query($connect, $sql_categoryInfo);
    if (mysqli_num_rows($query_categoryInfo) > 0) {
        if ($row_categoryInfo = mysqli_fetch_array($query_categoryInfo)) {
            if ($self_permissionRange < 2) {
                $sql_categoryDelete = "delete from blog_categories where id = $categoryID";
                if (mysqli_query($connect, $sql_categoryDelete)) {
                    // Delete is succesfully
                    $values["title"] = "Delete is Successfully";
                    $values["comment"] = "'".$row_categoryInfo["name"]."' is deleted.";
                    $values["type"] = "success";
                    return $values;
                }
            }else {
                // Low Permission
                $values["title"] = "Low Permission";
                $values["comment"] = "You cannot delete someone more authoritative than you!";
                $values["type"] = "error";
                return $values;
            }
        }
    }else {
        // No Account
        $values["title"] = "No Category";
        $values["comment"] = "Sorry, no such category found!";
        $values["type"] = "error";
        return $values;
    }
}
/* end Functions */
?>