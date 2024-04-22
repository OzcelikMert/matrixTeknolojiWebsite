<?php
function GetFileName(){
    $url = $_SERVER['PHP_SELF'];
    $path = pathinfo(parse_url($url, PHP_URL_PATH));
    $path_info =  $path['filename'];

    return $path_info;
}

$path_info = GetFileName();
?>