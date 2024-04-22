<?php
include_once("./config/config.php");

// Function Return Values
$SocialMediaValues = GetSocialMedia($conn);
// end Function Return Values

// Functions
function GetSocialMedia($connect){
    $values = array();
    $sql = "select * from contact_info";
    $query = mysqli_query($connect, $sql);
    if ($row = mysqli_fetch_array($query)) {
        $values["facebook"] = $row["facebook"];
        $values["twitter"] = $row["twitter"];
        $values["instagram"] = $row["instagram"];
    }

    return $values;
}
?>