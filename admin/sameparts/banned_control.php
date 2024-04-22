<?php
include_once("./config/config.php");
session_start();
$email = isset($_SESSION['email']) ? $_SESSION['email'] : "";
$id = GetID($conn, $email);
if(!empty($id))
    $bannedControl = GetBannedInfo($conn, $id);

if(!empty($id) && $bannedControl["type"] == "1"){
    session_destroy();
    header("Location: index.php");
}
?>