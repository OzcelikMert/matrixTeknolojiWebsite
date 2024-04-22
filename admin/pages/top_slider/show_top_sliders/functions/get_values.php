<?php
include_once("./config/config.php");
// Session Info
session_start();
$email = $_SESSION["email"];
// end Session Info

// Get Config in Functions
$id = GetID($conn, $email);
$permissionRange = GetPermissionRange($conn, $id);
$max_permission = 2; // <=
// end Get Config in Functions

// GET Values
$Top_Sliders = GetTopSliders($conn, $permissionRange, $max_permission);
// end GET Values


/* Functions */
function GetTopSliders($connect, $self_permission, $max_permission){
    $values = "";
    $sql = 'Select * from top_slider order by rank asc';
    $query = mysqli_query($connect, $sql);
    while($row = mysqli_fetch_array($query)){
        $delete_link = "javascript:void(0);";
        $active_color = "white";

        if($row["is_active"] != "1"){
            $active_color = "orange";
        }
        if($self_permission <= $max_permission){
            $delete_link = "javascript:SliderDelete(".$row["id"].");";
        }

        $values .= '
        <li class="col-lg-4 col-md-6 col-sm-12" id="Slider_'.$row["id"].'" slider-title="'.$row["title"].'">
            <div class="da-card box-shadow">
                <div class="da-card-photo">
                    <img src="./images/top-slider/'.$row["image"].'" alt="'.$row["title"].'" style="max-height: 300px; min-height:300px;">
                    <div class="da-overlay">
                        <div class="da-social">
                        <h5 class="mb-10 pd-20" style="color: '.$active_color.';">'.$row["title"].'</h5>
                            <ul class="clearfix">
                                <li><a href="#" title="Show"><i class="fa fa-eye"></i></a></li>
                                <li><a href="./admin/edit_top_slider_page.php?slider_id='.$row["id"].'" title="Edit"><i class="fa fa-edit"></i></a></li>
                                <li><a href="'.$delete_link.'" title="Delete"><i class="fa fa-trash"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </li>
        ';
    }
    return $values;
}
/* end Functions */
?>