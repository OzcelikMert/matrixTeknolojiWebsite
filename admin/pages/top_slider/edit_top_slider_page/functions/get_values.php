<?php
include_once("./config/config.php");


// Get Values
$Slider_id = ClearVariable($_GET["slider_id"], "normal+number");
$GetSliderValues = GetSliderInfo($conn, $Slider_id);
// Check Layer Add
$Count = 1;
$MainLayer = "";
$MoreLayer = "";
$explodeLayer = explode("[<-layer->]", $GetSliderValues["layers"]);
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
            <input class="form-control" type="text" maxlength="50" name="layer[]" placeholder="Slider Layer (Please enter type HTML code)" value=\''.$explodeLayer_value.'\'>
        </div>
        ';
    }
    $Count++;
}
// end Look Layer in Values
// end Get Values

/* Functions */
// Get Slider Info
function GetSliderInfo($connect, $slider_id){
    $values = array();
    $sql = "select * from top_slider where id = ".(int)$slider_id."";
    $query = mysqli_query($connect, $sql);
    // Control Slider id
    if(mysqli_num_rows($query) > 0){
        // Get Values
        if($row = mysqli_fetch_array($query)){
            $values["image"] = $row["image"]; 
            $values["duration"] = $row["duration"];
            $values["title"] = $row["title"];
            $values["layers"] = $row["layers"];
            $values["is_active"] = $row["is_active"];
            $values["rank"] = $row["rank"];
        }
    }else {
        // Wrong Slider id
        header("Location: dashboard.php");
    }

    return $values;
}
/* end Functions */
?>