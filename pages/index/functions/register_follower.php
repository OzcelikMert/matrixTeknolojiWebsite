<?php
include_once("../../../admin/config/config.php");

if($_POST){
    $email = ClearVariable($_POST["email"], "normal");

    // Value Control
    $ErrorMessage = valueControl($email);
    
    // Email Control
    if(!emailControl($conn, $email)){
        $self_ipaddress = GetIP();
        $date = date("Y-m-d H-i-s"); 
        RegisterFollower($conn, $email, $self_ipaddress, $date);
    }

    if(empty($ErrorMessage)){
        echo "success";
    }else{
        echo $ErrorMessage;
    }
}


/* Functions */

// Saving Follower
function RegisterFollower($connect, $email, $self_ipaddress, $date){
    $sql = "insert into followers(id, email, ip_address, date) values (null, '".$email."', '".$self_ipaddress."', '".$date."')";
    if(mysqli_query($connect, $sql)){
        return true;
    }else{
        return false;
    }
}
// end Saving Follower

// Values Control
function valueControl($email){
    // Message
    $errorMessage = "";

    // Control - 1
    if (empty($email)){
        $errorMessage .= "<li>Please fill the email!</li>";
    }else if(strlen($email) > 75){
        $errorMessage .= "<li>Email is very long!</li>";
    }else if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $errorMessage .= "<li>Please enter a valid user email! (Examples:abc@xyz.com)</li>";
    }
    
    // Return Message
    return $errorMessage;
}
// end Values Control

// Email Control
function emailControl($connect, $email_){
    $sql = "select * from followers where email = '".$email_."'";
    $query = mysqli_query($connect, $sql);
    if(mysqli_num_rows($query) > 0){
        return true;
    }else {
        return false;
    }
}
// end Email Control

// GET ip
function GetIP(){
    if(getenv("HTTP_CLIENT_IP")) {
        $ip = getenv("HTTP_CLIENT_IP");
    } elseif(getenv("HTTP_X_FORWARDED_FOR")) {
        $ip = getenv("HTTP_X_FORWARDED_FOR");
    if (strstr($ip, ',')) {
        $tmp = explode (',', $ip);
        $ip = trim($tmp[0]);
    }
    } else {
        $ip = getenv("REMOTE_ADDR");
    }
    return $ip;
}
// end GET ip

/* end Functions */
?>