<?php
// Includes
if(file_exists("../admin/config/config.php")){
    include_once("../admin/config/config.php");
}
// end Includes
if($_GET["email"]){
    $email = ClearVariable($_GET["email"], "normal+email");

    if(!empty($email)){

        if(Unfollow($conn, $email))
            echo "<b style='color: green;font-size: 20px;'>You have successfully unfollow!</b>";
        else
            echo "<b style='color: red;font-size: 20px;'>Error!</b>";

    }else{
        echo "<b style='color: red;font-size: 20px;'>Error!</b>";
    }
}
/* Functions */

// Unfollow 
function Unfollow($connect, $email){
    $sql = "delete from followers where email = '$email'";
    if(mysqli_query($connect, $sql)){
        return true;
    }

    return false;
}
// end Unfollow

/* end Functions */
?>