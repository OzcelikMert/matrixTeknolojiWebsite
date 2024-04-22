<?php
include_once("./config/config.php");
session_start();
// Account Control
$email = $_SESSION["email"];
$id = GetID($conn, $email);
$permission = GetPermissionRange($conn, $id);
$default_Max_permission = 2;
// end Account Control
if ($_POST) {
    // Cleaning Variable
    $slider_image = $_FILES["image"]["tmp_name"];
    $duration = ClearVariable($_POST["duration"], "normal+number");
    $title = ClearVariable($_POST["title"], "normal");
    $layer = ClearVariable($_POST["layer"], "replace-quotation-mark");
    $post_now = ClearVariable($_POST["post_now"], "normal+number");
    // Cleaned Variable

    // Active Control
    $post_now = (empty($post_now) || $post_now != 1) ? 0 : $post_now;
    // end Active Control

    // Layer Control
    $layer = LayerControl($layer);
    // end Layer Control

    // Variables Control
    $errorMessage = valueControl($slider_image, $duration, $title, $layer);
    // end Variables Control

    // Permission Control
    if(empty($errorMessage)){
        if($permission > $default_Max_permission){
            $errorMessage = "Low Permission"; 
        }
    }
    // end Permission Control

    if (empty($errorMessage)) {
        $newName = date("YmdHis")."_".rand(0, 999).".jpeg";
        $rank = (GetMaxRank($conn) + 1);
        $Add_SliderImage = AddSliderImage($conn, $newName, $duration, $title, $layer, $post_now, $rank);
        if ($Add_SliderImage == "Success") {
            Upload_SliderImage($slider_image, $newName);
            header("Location: show_top_sliders.php");
        }
    }else {
        $ErrorMessage_show = '
        <div class="alert alert-danger" role="alert" style="margin-top:10px;">
            '.$errorMessage.'
        </div>
        ';
        // Check Layer Add
        $Count = 1;
        $MainLayer = "";
        $MoreLayer = "";
        $explodeLayer = explode("[<-layer->]", $layer);
        // Look Layer in Values
        foreach($explodeLayer as &$explodeLayer_value){
            if($Count <= 1){
                $MainLayer = $explodeLayer_value;
            }else{
                $random = rand(0000, 9999);
                $random .= $Count;
                $MoreLayer .= '
                <div class="form-group layer-'.$random.'" id="layer">
                    <label>(<a href="javascript:DeleteLayer('.$random.');" style="color:red;">Delete Layer</a>)</label>
                    <input class="form-control" type="text" maxlength="250" name="layer[]" placeholder="Slider Layer (Please enter type HTML code)" value="'.$explodeLayer_value.'">
                </div>
                ';
            }
            $Count++;
        }
        // end Look Layer in Values
    }
}

/* Functions */
// Save Project
function AddSliderImage($connect, $slider_image, $duration, $title, $layer, $is_active, $rank){
    $sql = "insert into top_slider(`id`, `image`, `duration`, `title`, `layers`, `is_active`, `rank`) 
    values (null, '$slider_image', '$duration', '$title', '$layer', '$is_active', '$rank')";
    if (mysqli_query($connect, $sql)) {
        return "Success";
    }else {
        return "Error: ".mysqli_error($connect);
    }
}
// end Save Proje

// Values Control
function valueControl($slider_image, $duration, $title, $layer){
    // Message
    $errorMessage = "";

    // Control - 1
    if (empty($slider_image)){
        $errorMessage .= "<li>Please select the slider image!</li>";
    }

    // Control - 2
    if (empty($title)){
        $errorMessage .= "<li>Please enter the title!</li>";
    }else if(strlen($title) > 50){
        $errorMessage .= "<li>title is very long!</li>";
    }

    // Control - 3
    if (empty($duration)){
        $errorMessage .= "<li>Please enter the slider duration!</li>";
    }else if($duration > 50000 ||$duration < 1000){
        $errorMessage .= "<li>Please enter the true duration value (1000-50000)!</li>";
    }

    // Control - 4
    if (empty($layer)) {
        $errorMessage .= "<li>Please fill the layer!</li>";
    }
    
    // Return Message
    return $errorMessage;
}
// end Values Control

// Upload Slider Image
function Upload_SliderImage($file, $newName){
    $destination = "../images/top-slider/".$newName;
    move_uploaded_file($file, $destination);
}
// end Upload Slider Image

// Get Max Rank
function GetMaxRank($connect){
    $value = 0;
    $sql = "select rank from top_slider order by rank desc";
    $query = mysqli_query($connect, $sql);
    if($row = mysqli_fetch_array($query)){
        $value = $row["rank"];
    }
    return $value;
}
// end Get Max Rank

// Layer Control
function LayerControl($layer){
    $values = "";
    $enter_parser = false;
    foreach ($layer as &$layer_value) {
        if(!empty($layer_value)){
            if ($enter_parser) {
                $values .= "[<-layer->]".$layer_value;
            }else{
                $values .= $layer_value;
                $enter_parser = true;
            }
        }
    }
    return $values;
}
// end Layer Control

/* end Functions */
?>