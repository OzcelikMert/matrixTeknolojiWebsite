<?php
require_once("./config/config.php");
// Account Control
$email = $_SESSION["email"];
$id = GetID($conn, $email);
// end Account Control

// POST Control
if($_POST){
    // Values
    $now_password = ClearVariable($_POST["nowpassword"], "normal");
    $new_password = ClearVariable($_POST["newpassword"], "normal");
    $new_password_2 = ClearVariable($_POST["newpassword_2"], "normal");
    // end Values

    // Get error message
    $errorMessage = "";
    $errorMessage .= valuesControl($conn, $id, $now_password, $new_password, $new_password_2);
    // end Get error message
    
    if(empty($errorMessage)){
        // Convert md5
        $new_password = md5($new_password);
        // end Convert md5

        // Change Password
        if(UpdatePassword($conn, $new_password, $id)){
            header("Location: change_password.php?exit=true");
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
}
// end POST Control

/* Functions */
// Change Password
function UpdatePassword($connect, $password, $id){
    $sql = "update accounts set password='".$password."' where id=".(int)$id."";
    if (mysqli_query($connect, $sql)){
        return true;
    }else {
        return false;
    }
}
// end Change Password

// Values Control
function valuesControl($connect, $id, $now_password, $new_password, $new_password_2){
    // Message
    $errorMessage = "";

    // Control 1
    if (empty($now_password)){
        $errorMessage .= "<li>Please fill in the now password!</li>";
    }else if(!passwordControl($connect, md5($now_password), $id)){
        $errorMessage .= "<li>Now password is wrong!</li>";
    }

    // Control 2
    if (empty($new_password) || empty($new_password_2)){
        $errorMessage .= "<li>Please fill in the new password!</li>";
    }else if($new_password != $new_password_2){
        $errorMessage .= "<li>New passwords are not equals!</li>";
    }

    // Return Message
    return $errorMessage;
}
// end Values Control

// Password Control
function passwordControl($connect, $password, $id){
    // Control password
    $sql = "select * from accounts where password = '".$password."' and id=".(int)$id."";
    $query = mysqli_query($connect, $sql);
    if(mysqli_num_rows($query) > 0){
        return true;
    }else {
        return false;
    }
}
// end Password Control
/* end Functions */
?>