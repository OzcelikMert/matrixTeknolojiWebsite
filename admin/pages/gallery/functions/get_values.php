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
$Gallery_Name = ClearVariable($_GET["gallery_name"], "normal");
$Count = 0;
$Gallery_Name_Images = "";

if($Gallery_Name == "top-slider"){
    // Top Slider Images
    $Images = GetImages("../images/top-slider");
    $Gallery_Name_Images = '<li class="col-lg-4" style="width: 100%; max-width: 100%; flex: none;"><hr><h3>Top Slider Images</h3><hr></li>';
    foreach($Images as $image){
        if(strlen($image) > 4){
            $Count++;
            $Gallery_Name_Images .= '
            <li class="col-lg-4 col-md-6 col-sm-12" id="Image_'.$Count.'" image-url="top-slider/'.$image.'">
                <div class="da-card box-shadow">
                    <div class="da-card-photo">
                        <img src="./images/top-slider/'.$image.'" alt="Top Slider Image" style="max-height: 290px; min-height: 290px; background-color: #c9c4c4;">
                        <div class="da-overlay">
                            <div class="da-social">
                                <ul class="clearfix">
                                    <li><a href="./images/top-slider/'.$image.'" target="_blank" title="Show"><i class="fa fa-eye"></i></a></li>
                                    <li><a href="javascript:ImageDelete('.$Count.');" title="Delete"><i class="fa fa-trash"></i></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </li>
            ';
        }
    }
}else if ($Gallery_Name == "reference"){
    // Reference Images
    $Images = GetImages("../images/reference");
    $Gallery_Name_Images = '<li class="col-lg-4" style="width: 100%; max-width: 100%; flex: none;"><hr><h3>Reference Images</h3><hr></li>';
    foreach($Images as $image){
        if(strlen($image) > 4){
            $Count++;
            $Gallery_Name_Images .= '
            <li class="col-lg-4 col-md-6 col-sm-12" id="Image_'.$Count.'" image-url="reference/'.$image.'">
                <div class="da-card box-shadow">
                    <div class="da-card-photo">
                        <img src="./images/reference/'.$image.'" alt="Reference Images" style="max-height: 290px; min-height: 290px; background-color: #c9c4c4;">
                        <div class="da-overlay">
                            <div class="da-social">
                                <ul class="clearfix">
                                    <li><a href="./images/reference/'.$image.'" target="_blank" title="Show"><i class="fa fa-eye"></i></a></li>
                                    <li><a href="javascript:ImageDelete('.$Count.');" title="Delete"><i class="fa fa-trash"></i></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </li>
            ';
        }
    }
}else if ($Gallery_Name == "blog-logo"){
    // Blog Logo Images
    $Images = GetImages("../images/blog/logo");
    $Gallery_Name_Images = '<li class="col-lg-4" style="width: 100%; max-width: 100%; flex: none;"><hr><h3>Blog Logo Images</h3><hr></li>';
    foreach($Images as $image){
        if(strlen($image) > 4){
            $Count++;
            $Gallery_Name_Images .= '
            <li class="col-lg-4 col-md-6 col-sm-12" id="Image_'.$Count.'" image-url="blog/logo/'.$image.'">
                <div class="da-card box-shadow">
                    <div class="da-card-photo">
                        <img src="./images/blog/logo/'.$image.'" alt="Blog Logo Images" style="max-height: 290px; min-height: 290px; background-color: #c9c4c4;">
                        <div class="da-overlay">
                            <div class="da-social">
                                <ul class="clearfix">
                                    <li><a href="./images/blog/logo/'.$image.'" target="_blank" title="Show"><i class="fa fa-eye"></i></a></li>
                                    <li><a href="javascript:ImageDelete('.$Count.');" title="Delete"><i class="fa fa-trash"></i></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </li>
            ';
        }
    }
}else if ($Gallery_Name == "blog"){
    // Blog Images
    $Images = GetImages("../images/blog");
    $Gallery_Name_Images = '<li class="col-lg-4" style="width: 100%; max-width: 100%; flex: none;"><hr><h3>Blog Images</h3><hr></li>';
    foreach($Images as $image){
        if(strlen($image) > 4){
            $Count++;
            $Gallery_Name_Images .= '
            <li class="col-lg-4 col-md-6 col-sm-12" id="Image_'.$Count.'" image-url="blog/'.$image.'">
                <div class="da-card box-shadow">
                    <div class="da-card-photo">
                        <img src="./images/blog/'.$image.'" alt="Blog Images" style="max-height: 290px; min-height: 290px; background-color: #c9c4c4;">
                        <div class="da-overlay">
                            <div class="da-social">
                                <ul class="clearfix">
                                    <li><a href="./images/blog/'.$image.'" target="_blank" title="Show"><i class="fa fa-eye"></i></a></li>
                                    <li><a href="javascript:ImageDelete('.$Count.');" title="Delete"><i class="fa fa-trash"></i></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </li>
            ';
        }
    }
}else if ($Gallery_Name == "project-logo"){
    //  Project Logo Images
    $Images = GetImages("../images/project/logo");
    $Gallery_Name_Images = '<li class="col-lg-4" style="width: 100%; max-width: 100%; flex: none;"><hr><h3>Project Logo Images</h3><hr></li>';
    foreach($Images as $image){
        if(strlen($image) > 4){
            $Count++;
            $Gallery_Name_Images .= '
            <li class="col-lg-4 col-md-6 col-sm-12" id="Image_'.$Count.'" image-url="project/logo/'.$image.'">
                <div class="da-card box-shadow">
                    <div class="da-card-photo">
                        <img src="./images/project/logo/'.$image.'" alt="Project Logo Images" style="max-height: 290px; min-height: 290px; background-color: #c9c4c4;">
                        <div class="da-overlay">
                            <div class="da-social">
                                <ul class="clearfix">
                                    <li><a href="./images/project/logo/'.$image.'" target="_blank" title="Show"><i class="fa fa-eye"></i></a></li>
                                    <li><a href="javascript:ImageDelete('.$Count.');" title="Delete"><i class="fa fa-trash"></i></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </li>
            ';
        }
    }
}else if ($Gallery_Name == "project"){
    // Project Images
    $Images = GetImages("../images/project");
    $Gallery_Name_Images = '<li class="col-lg-4" style="width: 100%; max-width: 100%; flex: none;"><hr><h3>Project Images</h3><hr></li>';
    foreach($Images as $image){
        if(strlen($image) > 4){
            $Count++;
            $Gallery_Name_Images .= '
            <li class="col-lg-4 col-md-6 col-sm-12" id="Image_'.$Count.'" image-url="project/'.$image.'">
                <div class="da-card box-shadow">
                    <div class="da-card-photo">
                        <img src="./images/project/'.$image.'" alt="Project Images" style="max-height: 290px; min-height: 290px; background-color: #c9c4c4;">
                        <div class="da-overlay">
                            <div class="da-social">
                                <ul class="clearfix">
                                    <li><a href="./images/project/'.$image.'" target="_blank" title="Show"><i class="fa fa-eye"></i></a></li>
                                    <li><a href="javascript:ImageDelete('.$Count.');" title="Delete"><i class="fa fa-trash"></i></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </li>
            ';
        }
    }
}else if ($Gallery_Name == "account"){
    // Account Images
    $Images = GetImages("../images/account");
    $Gallery_Name_Images = '<li class="col-lg-4" style="width: 100%; max-width: 100%; flex: none;"><hr><h3>Account Images</h3><hr></li>';
    foreach($Images as $image){
        if(strlen($image) > 4){
            $Count++;
            $Gallery_Name_Images .= '
            <li class="col-lg-4 col-md-6 col-sm-12" id="Image_'.$Count.'" image-url="account/'.$image.'">
                <div class="da-card box-shadow">
                    <div class="da-card-photo">
                        <img src="./images/account/'.$image.'" alt="Account Images" style="max-height: 290px; min-height: 290px; background-color: #c9c4c4;">
                        <div class="da-overlay">
                            <div class="da-social">
                                <ul class="clearfix">
                                    <li><a href="./images/account/'.$image.'" target="_blank" title="Show"><i class="fa fa-eye"></i></a></li>
                                    <li><a href="javascript:ImageDelete('.$Count.');" title="Delete"><i class="fa fa-trash"></i></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </li>
            ';
        }
    }
}

// end GET Values


/* Functions */
// Get Images
function GetImages($location){
    $dir    = $location;
    // Get Items
    $files = scandir($dir);

    return $files;
}
/* end Functions */
?>