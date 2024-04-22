<?php
include_once("../../../../config/config.php");
// Session Info
session_start();
$email = $_SESSION["email"];
$id = GetID($conn, $email);
$PermissionRange = GetPermissionRange($conn, $id);
// end Session Info

// Get and Set Values
$AccountID = ClearVariable($_POST["accountid"], "normal+number");
$Delete_Message = DeleteAccount($conn, $AccountID, $PermissionRange);
echo json_encode($Delete_Message);
// end Get and Set Values

/* Functions */
function DeleteAccount($connect, $accountID, $self_permissionRange){
    $sql_accountInfo = "
    select
    accounts.name as AccountName,
    accounts.surname as AccountSurname,
    permissions.name as PermissionName,
    permissions.permission_range as PermissionRange
    from accounts
    INNER JOIN permissions ON permissions.id = accounts.permission
    where accounts.id = $accountID
    ";
    $query_accountInfo = mysqli_query($connect, $sql_accountInfo);
    if (mysqli_num_rows($query_accountInfo) > 0) {
        if ($row_accountInfo = mysqli_fetch_array($query_accountInfo)) {
            if ($self_permissionRange < $row_accountInfo["PermissionRange"]) {
                $sql_accountDelete = "delete from accounts where id = $accountID";
                if (mysqli_query($connect, $sql_accountDelete)) {
                    // Delete is succesfully
                    $values["title"] = "Delete is Successfully";
                    $values["comment"] = "\'".$row_accountInfo["AccountName"]."\' is deleted.";
                    $values["type"] = "success";
                    return $values;
                }
            }else {
                // Low Permission
                $values["title"] = "Low Permission";
                $values["comment"] = "You cannot delete someone more authoritative than you! (User Permission: ".$row_accountInfo["PermissionName"].")";
                $values["type"] = "error";
                return $values;
            }
        }
    }else {
        // No Account
        $values["title"] = "No Account";
        $values["comment"] = "Sorry, no such person found!";
        $values["type"] = "error";
        return $values;
    }
}
/* end Functions */
?>