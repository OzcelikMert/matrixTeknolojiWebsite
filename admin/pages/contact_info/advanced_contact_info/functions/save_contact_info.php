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
    $email = ClearVariable($_POST["email"], "normal");
    $password = ClearVariable($_POST["password"], "normal");
    $host = ClearVariable($_POST["host"], "normal");
    $title = ClearVariable($_POST["title"], "normal");
    // end Values

    // Get error message
    $errorMessage = "";
    $errorMessage = valueControl($email, $password, $host, $title);
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
        if(save_contactInfo($conn, $email, $password, $host, $title)){
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
function save_contactInfo($connect, $email, $password, $host, $title){
    $sql = "update contact_info set contact_form_email='$email', contact_form_password='$password', contact_form_host='$host', contact_form_title='$title'";
    if (mysqli_query($connect, $sql)){
        return true;
    }else {
        return false;
    }
}
// end Save Company Function

// Values Control
function valueControl($email, $password, $host, $title){
    // Message
    $errorMessage = "";

    // Control - 1
    if (empty($email)){
        $errorMessage .= "<li>Please fill the email!</li>";
    }else if(strlen($email) > 100){
        $errorMessage .= "<li>Email is very long!</li>";
    }

    // Control - 2
    if (empty($password)){
        $errorMessage .= "<li>Please fill the password!</li>";
    }else if(strlen($password) > 150){
        $errorMessage .= "<li>Password is very long!</li>";
    }

    // Control - 3
    if (empty($host)){
        $errorMessage .= "<li>Please fill the host!</li>";
    }else if(strlen($host) > 75){
        $errorMessage .= "<li>Host is very long!</li>";
    }

    // Control - 5
    if (empty($title)){
        $errorMessage .= "<li>Please fill the title!</li>";
    }else if(strlen($title) > 75){
        $errorMessage .= "<li>Title is very long!</li>";
    }

    // Return Message
    return $errorMessage;
}
// end Values Control
/* end Functions */
?>