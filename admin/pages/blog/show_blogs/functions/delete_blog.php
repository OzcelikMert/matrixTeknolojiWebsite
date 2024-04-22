<?php
include_once("../../../../config/config.php");
// Session Info
session_start();
$email = $_SESSION["email"];
$id = GetID($conn, $email);
$PermissionRange = GetPermissionRange($conn, $id);
// end Session Info

// Get and Set Values
$BlogID = ClearVariable($_POST["blog_id"], "normal+number");
$Delete_Message = DeleteBlog($conn, $BlogID, $PermissionRange, $id);
echo json_encode($Delete_Message);
// end Get and Set Values

/* Functions */
function DeleteBlog($connect, $Blog_ID, $self_permissionRange, $self_id){
    // Blog Control
    $sql_blogInfo = "select * from blogs where id = ".(int)$Blog_ID."";
    $query_blogInfo = mysqli_query($connect, $sql_blogInfo);
    if (mysqli_num_rows($query_blogInfo) > 0) {
        if ($row_blogInfo = mysqli_fetch_array($query_blogInfo)) {
            if ($self_permissionRange <= 2) {
                // Delete Blog
                $sql_blogDelete = "delete from blogs where id = ".(int)$Blog_ID."";
                if (mysqli_query($connect, $sql_blogDelete)) {
                    // Delete is succesfully
                    $values["title"] = "Delete is Successfully";
                    $values["comment"] = "'".$row_blogInfo["title"]."' is deleted.";
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
        // No Blog
        $values["title"] = "No Blog";
        $values["comment"] = "Sorry, no such blog found!";
        $values["type"] = "error";
        return $values;
    }
}
/* end Functions */
?>