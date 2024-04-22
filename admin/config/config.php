<?php
// Connect DB
$db_host="localhost";
$db_name="matrixte_website";
$db_user="matrixte_website";
$db_password="26108920Qwe*";

/*---------------------------------------*/

$conn = mysqli_connect($db_host, $db_user, $db_password, $db_name)or die('<div class="error"><h1>Veri Tabanı Bağlantısı Kurulamadı!</h1></div>');
$conn->query("SET NAMES 'utf8'"); 
$conn->query("SET CHARACTER SET utf8");  
$conn->query("SET SESSION collation_connection = 'utf8_unicode_ci'"); 

/* Other Functions */
// Get Account ID
function GetID($connect, $email){
    $sql = "select * from accounts where email = '$email'";
    $show_id = mysqli_query($connect, $sql);
    if($row = mysqli_fetch_assoc($show_id)){
        return $row["id"];
    }else{
        return "";
    }
}
// Get Account Permission
function GetPermissionRange($connect, $id){
    $sql = "select 
    permissions.permission_range as PermissionRange 
    from accounts
    INNER JOIN permissions ON permissions.id = accounts.permission
    where accounts.id = ".(int)$id."";
    $show_permission = mysqli_query($connect, $sql);
    if($row = mysqli_fetch_assoc($show_permission)){
        return $row["PermissionRange"];
    }else{
        return "";
    }
}
// Javascript Alert Function
function AlertPHP($message){
    echo "<script>alert('".$message."');</script>";
}

// Cleaning Get Variable
function ClearVariable($variable, $clearRange){
    $variable = isset($variable) ? $variable : "";
    // Clear Value
    switch ($clearRange) {
        // 1
        case "normal":
            $variable = htmlspecialchars(trim(strip_tags($variable)));
            $variable = str_replace("'", '', $variable);
        break;
        // 2
        case "replace-no":
            $variable = htmlspecialchars(trim(strip_tags($variable)));
        break;
        // 3
        case "replace-space":
            $variable = str_replace(" ", '', $variable);
        break;
        // 4
        case "replace-slash":
            $variable = str_replace("/", '', $variable);
        break;
        // 5
        case "replace-percent":
            $variable = str_replace("%", '', $variable);
        break;
        // 6
        case "normal+email":
            $variable = htmlspecialchars(trim(strip_tags($variable)));
            $variable = str_replace("'", '', $variable);
            $variable = filter_var($variable, FILTER_VALIDATE_EMAIL);
        break;
        // 7
        case "normal+number":
            $variable = htmlspecialchars(trim(strip_tags($variable)));
            $variable = str_replace("'", '', $variable);
            $variable = filter_var($variable, FILTER_SANITIZE_NUMBER_INT);
        break;
        case "replace-quotation-mark":
            $variable = str_replace("'", '', $variable);
        break;
        // 0
        default:
            $variable = "Wrong Range"; 
        break;
    }

    return $variable;
}
// Get Banned Info
function GetBannedInfo($connect, $id){
    $values = array();
    $sql = "select * from accounts where id = ".(int)$id."";
    $query = mysqli_query($connect, $sql);
    if($row = mysqli_fetch_array($query)){
        // Set Banned Values
        $values["date"] = $row["lock_date"];
        $values["comment"] = $row["lock_comment"];
        $values["type"] = $row["is_lock"];
    }
    // Banned Date Control
    $now_date = date_create(date("Y-m-d"));
    $lock_date = date_create($values["date"]);
    if($now_date >= $lock_date){
        // Open Account
        if(OpenBanned($connect, $id)){
            $values["type"] = "0";
        }
    }
    return $values;
}
// Account Banned
function AccountBanned($connect, $id, $comment, $date){
    $sql_banned = "update 
    accounts set is_lock = '1', 
    lock_comment = '$comment', 
    lock_date = (case when ( lock_rate > 3 ) THEN '".date("Y-m-d", strtotime($date . "+25 year"))."' ELSE '".$date."' END),
    lock_rate = lock_rate + 1
    where id = ".(int)$id."";
    if(mysqli_query($connect, $sql_banned))
        return true;
    else
        return false;
}
// Open Banned Account
function OpenBanned($connect, $id){
    $sql_banned = "update accounts set is_lock = '0' where id = ".(int)$id."";
    if(mysqli_query($connect, $sql_banned))
        return true;
    else
        return false;
}
/* end Other Functions */
?>