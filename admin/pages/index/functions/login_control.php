<?php 
require_once("./config/config.php");
session_start();
// Session Control
if(!empty($_SESSION["email"])){
    header("Location: dashboard.php");
}else{
    session_destroy();
    session_start();
}
// User control
if($_POST){
    $keep = ClearVariable($_POST['keep'], "normal");

    $email = ClearVariable($_POST['email'], "normal");

    $pass = ClearVariable($_POST['password'], "normal");

    // Value Controls
    $errorMessage = valueControl($email, $pass);
    // Account Controls
    if(empty($errorMessage)){
        $errorMessage .= accountControl($conn, $email, $pass);
    }
    // Banned Control
    if(empty($errorMessage)){
        $id = GetID($conn, $email);
        $BannedValues = GetBannedInfo($conn, $id);
        if($BannedValues["type"] == "1"){
            $errorMessage .= "Your account is banned!<br>Description of ban: '".$BannedValues["comment"]."'<br>Opening time '".$BannedValues["date"]."'";
        }
    }
    // Login
    if(empty($errorMessage)){
        if($keep == "Keep"){
            setcookie("email", $email, time() + 365 * 24 * 60 * 60);
        }else{
            setcookie("email", "", time() + -3600);
        }
        $_SESSION['email'] = $email;
        session_regenerate_id();
        header("Location: dashboard.php");
    }else{
        $ErrorMessage_show = '
        <div class="alert alert-warning" role="alert" id="notes">
            <ul style="list-style: disc;">
                '.$errorMessage.'
            </ul>
        </div>
        ';
    }
}
// Get Cookie Values
if(isset($_COOKIE["email"])){
    $cookie_email = $_COOKIE["email"];
}
// Title, Comment and Category control
function valueControl($email_, $pass_){
    $errorMessagge = "";
    // Email Control
    if (empty($email_)){
        $errorMessagge .= "<li>Please fill in the email!</li>";
    }else if(strlen($email_) > 75){
        $errorMessagge .= "<li>Email is very long!</li>";
    }else if(!filter_var($email_, FILTER_VALIDATE_EMAIL)){
        $errorMessagge .= "<li>Please enter a valid email! (Examples:abc@xyz.com)</li>";
    }
    // Password Control
    if (empty($pass_)) {
        $errorMessagge .= "<li>Please fill in the password!</li>";
    }else if(strlen($pass_) > 50){
        $errorMessagge .= "<li>Password is very long!</li>";
    }
    return $errorMessagge;
}
// Account Control
function accountControl($connect, $email_, $pass_){
    $pass_ = md5($pass_);
    $sql="SELECT * FROM accounts where email = '$email_' and password = '$pass_'";
        if($result = mysqli_query($connect, $sql)){
            if(mysqli_num_rows($result) > 0){
                $error_message = "";
            }else{
                $error_message = '<li>Your username or password is incorrect</li>';
            }
        }
    return $error_message;
}
?>