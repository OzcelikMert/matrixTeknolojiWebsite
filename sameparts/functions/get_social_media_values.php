<?php
// Includes
if(file_exists("./admin/config/config.php")){
    include_once("./admin/config/config.php");
}
// end Includes

// Get Values
$SocialMedia = GetSocialMedia_Values($conn);
// end Get Values

/* Functions */

// Get Social Media
function GetSocialMedia_Values($connect){
    $values = array();
    $sql = "select * from contact_info";
    $query = mysqli_query($connect, $sql);
    if($row = mysqli_fetch_array($query)){
        $values["facebook"] = $row["facebook"];
        $values["twitter"] = $row["twitter"];
        $values["instagram"] = $row["instagram"];
    }

    return $values;
}
// end Get Social Media

/* end Functions */
?>