<?php
require_once("./config/config.php");
// Account Control
$email = $_SESSION["email"];
$id = GetID($conn, $email);
$self_permission = GetPermissionRange($conn, $id);
$default_Max_permission = 1;
// end Account Control

// Register User Function
function register_user($connect, $name_, $surname_, $nickname_, $telephone_, $email_, $password_, $permission_){
    $sql = "INSERT INTO `accounts`(`id`, `nickname`, `name`, `surname`, `tel`, `permission`, `email`, `password`) 
    VALUES (null, '$nickname_', '$name_', '$surname_', '$telephone_', '$permission_', '$email_', '$password_')";
    if (mysqli_query($connect, $sql)){
        return true;
    }else {
        return false;
    }
}
// end Save Company Function

// POST Control
if($_POST){
    // Values
    $name = ClearVariable($_POST["name"], "normal");
    $surname = ClearVariable($_POST["surname"], "normal");
    $nickname = ClearVariable($_POST["nickname"], "normal");
    $telephone = ClearVariable($_POST["telephone"], "normal+number");
    $email = ClearVariable($_POST["email"], "normal+email");
    $password = ClearVariable($_POST["password"], "normal");
    $confirm_password = ClearVariable($_POST["confirm_password"], "normal");
    $permission = ClearVariable($_POST["permission"], "normal+number");
    // end Values

    // Get error message
    $errorMessage = "";
    $errorMessage .= valuesControl($conn, $name, $surname, $nickname, $telephone, $email, $password, $confirm_password, $permission);
    // end Get error message

    // User Permission Control
    if(empty($errorMessage)){
        if(($self_permission > $default_Max_permission) || !permissionRangeControl($conn, $permission, $self_permission)){
            $errorMessage = "Low Permission"; 
        }
    }
    // end User Permission Control
    
    // Saving DB in Business
    if(empty($errorMessage)){
        $password = md5($password);
        if(register_user($conn, $name, $surname, $nickname, $telephone, $email, $password, $permission)){
            $ErrorMessage_show = '
            <div class="alert alert-success" role="alert">
                <h4>User is successfully registered!</h4>
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

// Values Control
function valuesControl($connect, $name_, $surname_, $nickname_, $telephone_, $email_, $password_, $confirm_password_, $permission_){
    // Message
    $errorMessage = "";

    // Name Control
    if (empty($name_)){
        $errorMessage .= "<li>Please fill in the user name!</li>";
    }else if(strlen($name_) > 75){
        $errorMessage .= "<li>User name is very long!</li>";
    }

    // Surname Control
    if (empty($surname_)){
        $errorMessage .= "<li>Please fill in the user surname!</li>";
    }else if(strlen($surname_) > 50){
        $errorMessage .= "<li>User surname is very long!</li>";
    }

    // Nickname Control
    if (empty($nickname_)){
        $errorMessage .= "<li>Please fill in the user nickname!</li>";
    }else if(strlen($nickname_) > 50){
        $errorMessage .= "<li>User nickname is very long!</li>";
    }

    // Telephone Control
    if (empty($telephone_)){
        $errorMessage .= "<li>Please fill in the telephone number!</li>";
    }else if(strlen($telephone_) > 11){
        $errorMessage .= "<li>Telephone number is very long!</li>";
    }else if(strlen($telephone_) < 10){
        $errorMessage .= "<li>Telephone number is very short!</li>";
    }else if(!filter_var($telephone_, FILTER_SANITIZE_NUMBER_INT)){
        $errorMessage .= "<li>Please enter a valid telephone number!</li>";
    }

    // Email Control
    if (empty($email_)) {
        $errorMessage .= "<li>Please fill in the user email!</li>";
    }else if(strlen($email_) > 100){
        $errorMessage .= "<li>User email is very long!</li>";
    }else if(!filter_var($email_, FILTER_VALIDATE_EMAIL)){
        $errorMessage .= "<li>Please enter a valid user email! (Examples:abc@xyz.com)</li>";
    }else if(emailControl($connect, $email_)){
        $errorMessage .= "<li>This email is already registered</li>";
    }

    // Password Control
    if (empty($password_)) {
        $errorMessage .= "<li>Please fill in the user password!</li>";
    }else if(strlen($password_) > 30){
        $errorMessage .= "<li>User password is very long!</li>";
    }
    
    // Confirm Password Control
    if (empty($confirm_password_)) {
        $errorMessage .= "<li>Please fill in the user confirm password!</li>";
    }else if($confirm_password_ != $password_){
        $errorMessage .= "<li>User passwords are not the same!</li>";
    }

    // Permission Control
    if (empty($permission_)) {
        $errorMessage .= "<li>Please fill in the permission!</li>";
    }else if(strlen($permission_) > 11){
        $errorMessage .= "<li>Permission is very long!</li>";
    }else if(!filter_var($permission_, FILTER_SANITIZE_NUMBER_INT)){
        $errorMessage .= "<li>Please enter a valid permission!</li>";
    }else if(permissionControl($connect, $permission_)){
        $errorMessage .= "<li>Wrong permission!</li>";
    }

    // Return Message
    return $errorMessage;
}
// end Values Control

// Email Control
function emailControl($connect, $email_){
    // Error message
    $errorMessage = "";

    // Control email
    $sql = "select * from accounts where email = '".$email_."'";
    $query = mysqli_query($connect, $sql);
    if(mysqli_num_rows($query) > 0){
        return true;
    }else {
        return false;
    }
}
// end Email Control

// Permission Control
function permissionControl($connect, $id_){
    // Control Permission
    $sql = "select * from permissions where id = ".(int)$id_."";
    $query = mysqli_query($connect, $sql);
    if(mysqli_num_rows($query) > 0){
        return false;
    }else {
        return true;
    }
}

function permissionRangeControl($connect, $id_, $self_permission){
    // Control Permission Range
    $sql = "select * from permissions where id = ".(int)$id_."";
    $query = mysqli_query($connect, $sql);
    if($row = mysqli_fetch_array($query)){
        if($row["permission_range"] <= $self_permission){
            return false;
        }else {
            return true;
        }
    }
}
// end Permission Control
?>