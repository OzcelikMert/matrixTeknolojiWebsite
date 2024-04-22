<?php
include_once("./config/config.php");
session_start();
$email = isset($_SESSION['email']) ? $_SESSION['email'] : "";
$id = GetID($conn, $email);

if(empty($email)){
    header("Location: index.php");
}

if (!empty($email)) {
    if (empty($id)) {
        header("Location: index.php");
    }
}

if ($_GET['exit'] == "true") {
    session_destroy();
    header("Location: index.php");
}
?>