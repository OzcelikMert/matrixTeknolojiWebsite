<?php
include_once("./config/config.php");
$Selected_Permission = ClearVariable($_POST["permission"], "normal+number");

// SESSION Control
$email = $_SESSION["email"];
$id = GetID($conn, $email);
$self_permission = GetPermissionRange($conn, $id);
// end SESSION Control

// Function Return Values
$Permissions = GetPermissions($conn, $Selected_Permission, $self_permission);
// end Function Return Values

// Functions
function GetPermissions($connect, $Selected_Permission_, $self_permission){
    $values = "";
    $sql = "select * from permissions order by permission_range desc";
    $query = mysqli_query($connect, $sql);
    while ($row = mysqli_fetch_array($query)) {
        $selected = "";
        if ($Selected_Permission_ == $row["id"]) {
            $selected .= "selected";
        }
        if($row["permission_range"] > $self_permission) {
            $values .= '
            <option value="'.$row["id"].'" '.$selected.'>'.$row["name"].'</option>
            ';
        }
    }
    return $values;
}
?>