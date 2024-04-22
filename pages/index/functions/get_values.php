<?php
include_once("./admin/config/config.php");

// Get Variables
$Get_TopSlider = GetTopSlider_Values($conn);
$Get_Project = GetProject_Values($conn);
$Get_Blog = GetBlog_Values($conn);
$Get_Reference = GetReference_Values($conn);
$Get_ContactInfo = GetContactInfo_Values($conn);
//end Get Variables

/* Functions */

// Get Top Sliders
function GetTopSlider_Values($connect){
    $values = '';
    $sql = "select * from top_slider where is_active='1' order by rank asc";
    $query = mysqli_query($connect, $sql);
    while($row = mysqli_fetch_array($query)){
        // Variables
        $layerCount = 0;
        $layerDuration = 0;
        $layerStart_VOffset_1 = -60;
        $layerStart_VOffset_2 = -30;
        $layerStart_VOffset_Plus = 60;
        // end Variables

        // Slider Head
        $values .= '
        <li data-index="'.$row["rank"].'" data-transition="fade" data-slotamount="default" data-easein="default" data-easeout="default" data-masterspeed="default"  data-thumb="./images/top-slider/'.$row["image"].'"  data-rotate="0"  data-saveperformance="off"  data-title="'.$row["title"].'" data-description="'.$row["title"].'">
            <img src="./images/top-slider/'.$row["image"].'"  alt="'.$row["title"].'" class="rev-slidebg" data-bgparallax="3" data-bgposition="center center" data-duration="'.$row["duration"].'" data-ease="Linear.easeNone" data-kenburns="on" data-no-retina="" data-offsetend="0 0" data-offsetstart="0 0" data-rotateend="0" data-rotatestart="0" data-scaleend="100" data-scalestart="140">';
        
        // Slider Body
        $Layers = explode("[<-layer->]", $row["layers"]);
        foreach($Layers as $Layer){
            #Layer Count and Duration
            $layerCount++;
            $layerDuration = $layerCount * 1000;
            $layerStart_VOffset_1_Calculate = $layerStart_VOffset_1 + ($layerStart_VOffset_Plus * ($layerCount - 1));
            $layerStart_VOffset_2_Calculate = $layerStart_VOffset_2 + ($layerStart_VOffset_Plus * ($layerCount - 1));
            #end Layer Count and Duration

            $values .= '
            <!-- LAYER '.$layerCount.' -->
			<div class="tp-caption" 
				data-x="[\'center\',\'center\',\'center\',\'center\']" data-hoffset="[\'0\',\'0\',\'0\',\'0\']" 
				data-y="[\'middle\',\'middle\',\'middle\',\'middle\']" data-voffset="[\''.$layerStart_VOffset_1_Calculate.'\', \''.$layerStart_VOffset_2_Calculate.'\', \''.$layerStart_VOffset_2_Calculate.'\', \''.$layerStart_VOffset_1_Calculate.'\']" 
				data-width="none"
				data-height="none"
				data-whitespace="nowrap"
				data-transform_idle="o:1;"
		
				data-transform_in="y:[100%];z:0;rX:0deg;rY:0;rZ:0;sX:1;sY:1;skX:0;skY:0;opacity:0;s:2000;e:Power4.easeInOut;" 
				data-transform_out="y:[100%];s:1000;e:Power2.easeInOut;s:1000;e:Power2.easeInOut;" 
				data-mask_in="x:0px;y:[100%];" 
				data-mask_out="x:inherit;y:inherit;" 
				data-start="'.$layerDuration.'" 
				data-splitin="none" 
				data-splitout="none" 
				data-responsive_offset="on" 
				style="z-index: 6; white-space: nowrap;">
				'.$Layer.'
			</div>
            ';
        }

        // Slider end <li>
		$values .= '</li>';
    }

    return $values;
}

// Get Projects
function GetProject_Values($connect){
    $values["categories"] = "";
    $values["projects"] = "";
    $Oldcategory = "";
    // Get Projects
    $sql = "
    select 
    projects.id as Project_Id,
    projects.main_image as Project_Logo,
    projects.title as Project_Title,
    projects.seourl as Project_Seourl,
    projects.date as Project_Date,
    projects.is_active as Project_Active,
    project_categories.name as Project_Category,
    project_categories.seourl as Project_Category_Seourl
    from projects
    INNER JOIN project_categories ON project_categories.id = projects.category
    INNER JOIN accounts ON accounts.id = projects.shared_aid
    where projects.is_active = '1'
    ORDER BY Project_Date DESC
    LIMIT 0, 12
    ";
    $query = mysqli_query($connect, $sql);
    while($row = mysqli_fetch_array($query)){
        #Project
        $values["projects"] .= '
        <div class="mix grid-item '.$row["Project_Category_Seourl"].'">
			<div class="single-img">
				<img src="./images/project/logo/'.$row["Project_Logo"].'" alt="'.$row["Project_Title"].'" style="max-height: 230px; min-height: 230px;">
				<div class="opacity">
					<div class="border-shape">
						<div>
							<div>
								<h6><a href="project-detail.php?project='.$row["Project_Seourl"].'">'.$row["Project_Title"].'</a></h6>
								<ul>
									<li>'.$row["Project_Category"].' / </li>
									<li>'.substr($row["Project_Date"], 0, 10).'</li>
								</ul>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
        ';
        #end Project
    }

    // Get Project Categories
    $sql = "
    SELECT 
    project_categories.name as Project_Category,
    project_categories.seourl as Project_Category_Seourl
    FROM project_categories
    INNER JOIN projects ON projects.category = project_categories.id
    GROUP BY project_categories.id
    ORDER BY project_categories.name ASC
    ";
    $query = mysqli_query($connect, $sql);
    while($row = mysqli_fetch_array($query)){
        #Project Category
        if($Oldcategory != $row["Project_Category_Seourl"]){
            $values["categories"] .= '<li class="filter tran3s" data-filter=".'.$row["Project_Category_Seourl"].'">'.$row["Project_Category"].'</li>';
        }
        $Oldcategory = $row["Project_Category_Seourl"];
        #end Project Category
    }

    return $values;
}

// Get Blogs
function GetBlog_Values($connect){
    $values = "";
    $sql = "
    select 
    blogs.main_image as Blog_Logo,
    blogs.title as Blog_Title,
    blogs.seourl as Blog_Seourl,
    blogs.content as Blog_Content,
    blogs.date as Blog_Date,
    blogs.fixed as Blog_Fixed,
    blog_categories.name as Blog_Category,
    blog_categories.seourl as Blog_Category_Seourl,
    accounts.nickname as Blog_SharedName 
    from blogs 
    INNER JOIN blog_categories ON blog_categories.id = blogs.category 
    INNER JOIN accounts ON accounts.id = blogs.shared_aid 
    where blogs.is_active = '1' 
    ORDER BY Blog_Fixed DESC, Blog_Date DESC 
    LIMIT 0, 3
    ";
    $query = mysqli_query($connect, $sql);
    while($row = mysqli_fetch_array($query)){
        $values .= '
        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
			<div class="single-news-item">
                <div class="img">
                    <img src="./images/blog/logo/'.$row["Blog_Logo"].'" alt="'.$row["Blog_Title"].'" style="min-height: 220px; min-width: 100%;">
					<a href="./blog-detail.php?blog='.$row["Blog_Seourl"].'" class="opacity tran4s"><i class="fa fa-eye" aria-hidden="true"></i></a>
				</div>
				<div class="post">
					<h6 style="word-break: break-word; overflow: hidden;"><a href="./blog-detail.php?blog='.$row["Blog_Seourl"].'" class="tran3s">'.$row["Blog_Title"].'</a></h6>
                    <a href="javascript:void(0);" style="cursor: default;">Paylaşan: <span class="p-color">'.$row["Blog_SharedName"].'</span> | Tarih: '.substr($row["Blog_Date"], 0, 10).'</a>
                    <a href="./blogs.php?blog_category='.$row["Blog_Category_Seourl"].'">Kategori: <span class="p-color">'.$row["Blog_Category"].'</span></a>
					<p style="word-break: break-word; overflow: hidden;">'.strip_tags(substr($row["Blog_Content"], 0, 140)).'...<a href="./blog-detail.php?blog='.$row["Blog_Seourl"].'" class="tran3s">Devamını Oku</a></p>
				</div>
			</div>
		</div>
        ';
    }

    return $values;
}

// Get References
function GetReference_Values($connect){
    $values = "";
    $sql = "select * from reference order by id desc";
    $query = mysqli_query($connect, $sql);
    while($row = mysqli_fetch_array($query)){
        $values .= '
        <div class="item"><img src="./images/reference/'.$row["image"].'" alt="'.$row["title"].'"></div>
        ';
    }

    return $values;
}

// Get Contact Info
function GetContactInfo_Values($connect){
    $values = array();
    $sql = "select * from contact_info";
    $query = mysqli_query($connect, $sql);
    if($row = mysqli_fetch_array($query)){
        $values["comment"] = $row["comment"];
        $values["map"] = $row["map"];
        $values["address"] = $row["address"];
        $values["phone"] = $row["phone"];
        $values["email"] = $row["email"];
    }

    return $values;
}

/* end Functions */
?>