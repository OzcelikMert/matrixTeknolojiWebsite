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
    $facebook = ClearVariable($_POST["facebook"], "normal");
    $twitter = ClearVariable($_POST["twitter"], "normal");
    $instagram = ClearVariable($_POST["instagram"], "normal");
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
        if(save_socialMedia($conn, $facebook, $twitter, $instagram)){
            $ErrorMessage_show = '
            <div class="alert alert-success" role="alert">
                <h4>Social media is successfully saved!</h4>
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
function save_socialMedia($connect, $facebook, $twitter, $instagram){
    $sql = "update contact_info set facebook='$facebook', twitter='$twitter', instagram='$instagram'";
    if (mysqli_query($connect, $sql)){
        return true;
    }else {
        return false;
    }
}
// end Save Company Function

/* end Functions */
?>