<?php
require_once("./config/config.php");
// Account Control
$email = $_SESSION["email"];
$id = GetID($conn, $email);
$permission = GetPermissionRange($conn, $id);
$default_Max_permission = 1;
// end Account Control

// POST Control
if($_POST){
    // Values
    $comment = ClearVariable($_POST["comment"], "normal");
    $map = trim($_POST["map"]);
    $address = ClearVariable($_POST["address"], "normal");
    $phone = ClearVariable($_POST["phone"], "normal+number");
    $email = ClearVariable($_POST["email"], "normal+email");
    // end Values

    // Get error message
    $errorMessage = "";
    // end Get error message

    // User Permission Control
    if(empty($errorMessage)){
        if($permission > $default_Max_permission){
            $errorMessage = "Low Permission"; 
        }
    }
    // end User Permission Control
    
    if(empty($errorMessage)){
        // Save Values
        if(save_contactInfo($conn, $comment, $map, $address, $phone, $email)){
            $ErrorMessage_show = '
            <div class="alert alert-success" role="alert">
                <h4>Contact Info is successfully saved!</h4>
            </div>
            ';
        }else {
            $ErrorMessage_show = '
            <div class="alert alert-danger" role="alert">
                <h4>Unknown error occurred please report to support.</h4>
            </div>
            ';
        }
    }else{
        $ErrorMessage_show = '
        <div class="alert alert-warning" role="alert">
            <ul style="list-style: disc;">
                '.$errorMessage.'
            </ul>
        </div>
        ';
    }
    // end Saving DB in Business
}
// end POST Control

/* Functions */
// Register User Function
function save_contactInfo($connect, $comment, $map, $address, $phone, $email){
    $sql = "update contact_info set comment='$comment', map='$map', address='$address', phone='$phone', email='$email'";
    if (mysqli_query($connect, $sql)){
        return true;
    }else {
        return false;
    }
}
// end Save Company Function

/* end Functions */
?>