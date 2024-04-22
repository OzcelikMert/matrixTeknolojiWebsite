<?php
// Includes
if(file_exists("./config/config.php")){
    include_once("./config/config.php");
}else if(file_exists("./config/config.php")){
    include_once("../admin/config/config.php");
}
// end Includes

// Function Return Values
$ContactValues = GetContactInfo_Values($conn);
// end Function Return Values

/* Functions */

// Get Contact Info
function GetContactInfo_Values($connect){
    $values = array();
    $sql = "select * from contact_info";
    $query = mysqli_query($connect, $sql);
    if($row = mysqli_fetch_array($query)){
        $values["contact_form_email"] = $row["contact_form_email"];
        $values["contact_form_password"] = $row["contact_form_password"];
        $values["contact_form_host"] = $row["contact_form_host"];
        $values["contact_form_title"] = $row["contact_form_title"];
    }

    return $values;
}
// end Get Contact Info

/* end Functions */
?>