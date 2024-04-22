<?php
require_once("./config/config.php");
// Account Control
$email = $_SESSION["email"];
$id = GetID($conn, $email);
// end Account Control

// POST Control
if($_POST){
    // Values
    $name = ClearVariable($_POST["name"], "normal");
    $surname = ClearVariable($_POST["surname"], "normal");
    $tel = ClearVariable($_POST["telephone"], "normal+number");
    // end Values

    // Get error message
    $errorMessage = "";
    $errorMessage = valueControl($name, $surname, $tel);
    // end Get error message
    
    if(empty($errorMessage)){
        // Save Values
        if(save_contactInfo($conn, $name, $surname, $tel, $id)){
            header("Location: profile.php");
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
function save_contactInfo($connect, $name, $surname, $tel, $id){
    $sql = "update accounts set name='$name', surname='$surname', tel='$tel' where id=".(int)$id."";
    if (mysqli_query($connect, $sql)){
        return true;
    }else {
        return false;
    }
}
// end Save Company Function

// Values Control
function valueControl($name, $surname, $tel){
    // Message
    $errorMessage = "";

    // Control - 1
    if (empty($name)){
        $errorMessage .= "<li>Please fill the name!</li>";
    }else if(strlen($name) > 75){
        $errorMessage .= "<li>Name is very long!</li>";
    }

    // Control - 2
    if (empty($surname)){
        $errorMessage .= "<li>Please fill the surname!</li>";
    }else if(strlen($surname) > 50){
        $errorMessage .= "<li>Surname is very long!</li>";
    }

    // Control - 3
    if (empty($tel)){
        $errorMessage .= "<li>Please fill the telephone!</li>";
    }else if(strlen($tel) > 11){
        $errorMessage .= "<li>Telephone number is very long!</li>";
    }else if(strlen($tel) < 11){
        $errorMessage .= "<li>Telephone number is very small!</li>";
    }

    // Return Message
    return $errorMessage;
}
// end Values Control
/* end Functions */
?>