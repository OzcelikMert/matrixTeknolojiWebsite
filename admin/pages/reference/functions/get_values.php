<?php
include_once("./config/config.php");

// Account Control
$email = $_SESSION["email"];
$id = GetID($conn, $email);
$PermissionRange = GetPermissionRange($conn, $id);
// end Account Control

// Get Values
$maxPermissionRange = 1;
$References = GetReferences($conn, $PermissionRange, $maxPermissionRange);
// end Get Values

/* Functions */
function GetReferences($connect, $self_permission, $maxPermissionRange){
    $values = "";
    $sql = "select * from reference order by title ASC";
    $query = mysqli_query($connect, $sql);
    while ($row = mysqli_fetch_array($query)) {
        $update_src = "javascript:void(0);";
        $delete_src = "javascript:void(0);";
        // Check Permission
        if ($self_permission <= $maxPermissionRange){
            $update_src = "javascript:updateReference(".$row["id"].");";
            $delete_src = "javascript:deleteReference(".$row["id"].");";
        }

        $values .= '
        <tr id="reference_'.$row["id"].'" reference-title="'.$row["title"].'" reference-image="'.$row["image"].'">
			<th scope="row" id="reference_'.$row["id"].'_name">'.$row["title"].'</th>
			<th scope="row"><a href="'.$delete_src.'" class="hover-link" style="color: #d70000;">Delete</a></th>
			<th scope="row"><a href="'.$update_src.'" class="hover-link" style="color: #0449e5;">Update</a></th>
	  	</tr>
        ';
    }
    return $values;
}
/* end Functions */
?>