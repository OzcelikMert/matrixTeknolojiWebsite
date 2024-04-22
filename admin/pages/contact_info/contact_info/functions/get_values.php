<?php
include_once("./config/config.php");

// Function Return Values
$ContactValues = GetContact_Info($conn);
// end Function Return Values

// Functions
function GetContact_Info($connect){
    $values = array();
    $sql = "select * from contact_info";
    $query = mysqli_query($connect, $sql);
    if ($row = mysqli_fetch_array($query)) {
        $values["comment"] = $row["comment"];
        $values["map"] = $row["map"];
        $values["address"] = $row["address"];
        $values["phone"] = $row["phone"];
        $values["email"] = $row["email"];
    }

    return $values;
}
?>