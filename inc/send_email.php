<?php
// Includes
if(file_exists("../admin/config/config.php")){
    include_once("../admin/config/config.php");
}

if(file_exists("../admin/inc/send_smtp_mail.php")){
    include_once("../admin/inc/send_smtp_mail.php");
}

if(file_exists("../admin/pages/contact_info/advanced_contact_info/functions/get_values.php")){
    include_once("../admin/pages/contact_info/advanced_contact_info/functions/get_values.php");
}
// end Includes

if($_POST){

    $name = ClearVariable($_POST["name"], "normal");
    $email = ClearVariable($_POST["email"], "normal");
    $subject = ClearVariable($_POST["subject"], "normal");
    $message = ClearVariable($_POST["message"], "normal");

    //echo "Before Values Control ";
    // Values Control
    $errorMessage = valuesControl($name, $email, $subject, $message);
    
    if(empty($errorMessage)){
        // Send Message
        
        // Get Values
        $ContactValues = GetContactInfo_Values($conn);
        // end Get Values

        $message .= '
        <br>
        <hr/>
        <ul>
            <li>This message was sent by www.matrixteknoloji.com.tr</li>
            <li>Sender name: '.$name.'</li>
            <li>Sender email: '.$email.'</li> 
            <li>Email subject: '.$subject.'</li> 
        </ul>
        ';

        // Send
        if(sendMail_smtp($ContactValues["contact_form_host"], $ContactValues["contact_form_email"], $ContactValues["contact_form_password"], $ContactValues["contact_form_title"], $email, $name, $subject, $message)){
            // Success
            echo "Success";
        }else{
            // Success
            echo "Send Email Error";
        }
        // end Send

        // end Send Message
    }else{
        // Set Error Message
        echo "<ul id='contactError' style='list-style: circle; color: red;'>".$errorMessage."</ul>";
        // end Set Error Message
    }
}

/* Functions */

// Values Control
function valuesControl($name, $email, $subject, $message){
    // Error Message
    $errorMessage = "";

    // Name Control
    if (empty($name)){
        $errorMessage .= "<li>Please fill in the name!</li>";
    }else if(strlen($name) > 75){
        $errorMessage .= "<li>Name is very long!</li>";
    }

    // Email Control
    if (empty($email)) {
        $errorMessage .= "<li>Please fill in the e-mail!</li>";
    }else if(strlen($email) > 100){
        $errorMessage .= "<li>E-mail is very long!</li>";
    }else if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $errorMessage .= "<li>Please enter a valid e-mail! (Examples:abc@xyz.com)</li>";
    }

    // Subject Control
    if (empty($subject)){
        $errorMessage .= "<li>Please fill in the subject!</li>";
    }else if(strlen($subject) > 75){
        $errorMessage .= "<li>Subject is very long!</li>";
    }

    // Message Control
    if (empty($message)){
        $errorMessage .= "<li>Please fill in the message!</li>";
    }else if(strlen($message) > 750){
        $errorMessage .= "<li>Message is very long!</li>";
    }

    // Return Error Message
    return $errorMessage;
}
// end Values Control

/* end Functions */
?>