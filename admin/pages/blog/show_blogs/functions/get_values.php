<?php
include_once("./config/config.php");
// sameparts/accounts_settings -> have: $email, $id , $permission and all permissions
// GET Values
$get_category_value = ClearVariable($_GET["blog_category"], "normal");
$get_page_number = ClearVariable($_GET["page"], "normal+number");
$get_page_number = (!empty($get_page_number)) ? $get_page_number : 0;
// end GET Values

// Values //
$SortCount = 6;
$Buttons = GetPageButtons($conn, $get_category_value, $get_page_number);
// Page Number Max Min Control
if($get_page_number < $Buttons["min"]){
    $get_page_number = $Buttons["min"];
}else if ($get_page_number > $Buttons["max"]){
    $get_page_number = $Buttons["max"];
}
$min = ($get_page_number - 1 >= 0) ? $SortCount * ($get_page_number - 1) : 0;
$max = $SortCount;
// end Page Number Max Min Control
$Blogs = GetBlogs($conn, $permission, $NormalUser, $get_category_value, $min, $max);
$Categories = GetCategories($conn, $get_category_value);
// end Values //

/* Functions */
// Get Blogs
function GetBlogs($connect, $permission, $maxPermission, $wanted_category, $min, $max){
    $where_category = (!empty($wanted_category)) ? "where blog_categories.seourl = '".$wanted_category."'" : "";
    $values = "";
    $sql = "
    select 
    blogs.id as Blog_Id,
    blogs.main_image as Blog_Logo,
    blogs.title as Blog_Title,
    blogs.date as Blog_Date,
    blogs.is_active as Blog_Active,
    blogs.fixed as Blog_Fixed,
    blog_categories.name as Blog_Category,
    blog_categories.seourl as Blog_Category_Seourl,
    accounts.nickname as Blog_SharedName
    from blogs
    LEFT JOIN blog_categories ON blog_categories.id = blogs.category
    INNER JOIN accounts ON accounts.id = blogs.shared_aid
    $where_category 
    ORDER BY Blog_Fixed DESC, Blog_Active ASC, blogs.date DESC
    LIMIT $min, $max
    ";
    $query = mysqli_query($connect, $sql);
    while ($row = mysqli_fetch_array($query)) {
        $fixed = "";
        $li_bg = "#ffffff";
        $Delete_src = "";
        $Edit_src = "";
        $blogCategory = $row["Blog_Category"];
        $blogCategory_url = './admin/show_blogs.php?blog_category='.$row["Blog_Category_Seourl"].'';
        // Is Active Control
        if($row["Blog_Active"] != "1") {
            $li_bg = "#ffd6ab";
        }
        // Fixed Control
        if($row["Blog_Fixed"] == "1") {
            $fixed = '<i class="fa fa-thumb-tack" style="position: absolute; right: 25px; color: blue;" title="Fixed"></i>';
        }
        // Permission Control
        if ($permission < $maxPermission) {
            $Edit_src = '<a href="./admin/edit_blog_page.php?blog_id='.$row["Blog_Id"].'" class="btn btn-outline-primary">Edit</a>';
            $Delete_src = '<a href="javascript:BlogDelete('.$row["Blog_Id"].');" class="btn btn-outline-danger">Delete</a>';
        }
        // Category Control
        if(empty($blogCategory)){
            $blogCategory = "<font color='red'>Null Category</font>";
            $blogCategory_url = "javasciprt:void(0);";
        }

        $values .= '
        <li id="Blog_'.$row["Blog_Id"].'" blog-title="'.$row["Blog_Title"].'" style="background-color: '.$li_bg.';">
			<div class="row no-gutters">
				<div class="col-lg-4 col-md-12 col-sm-12">
					<div class="blog-img" style="background: url(\'./images/blog/logo/'.$row["Blog_Logo"].'\'); center center no-repeat;">
						<img src="./images/blog/logo/'.$row["Blog_Logo"].'" alt="'.$row["Blog_Title"].'" class="bg_img" style="display: none;">
					</div>
				</div>
				<div class="col-lg-8 col-md-12 col-sm-12">
                    <div class="blog-caption">
                        '.$fixed.'
						<h4><a href="#">'.$row["Blog_Title"].'</a></h4>
						<div class="blog-by">
							<p>Date:  <small>'.$row["Blog_Date"].'</small></p>
							<p>Category: <a href="'.$blogCategory_url.'"><b>'.$blogCategory.'</b></a></p>
							<p>Shared by: <b>'.$row["Blog_SharedName"].'</b></p>
							<div class="pt-10">
								'.$Edit_src.'
                                '.$Delete_src.'
							</div>
						</div>
					</div>
				</div>
			</div>
		</li>
        ';
    }
    return $values;
}

// Get Categories
function GetCategories($connect, $GET_value){
    $values = "";
    $sql = '
    select
    blog_categories.name as BlogCategory_Name,
    blog_categories.seourl as BlogCategory_Seourl,
    Count(blogs.id) as TotalCount
    from blog_categories
    LEFT JOIN blogs ON blogs.category = blog_categories.id
    GROUP BY blog_categories.id
    ORDER BY BlogCategory_Name ASC
    ';
    $query = mysqli_query($connect, $sql);
    while ($row = mysqli_fetch_array($query)) {
        // Href GET Link
        $href = 'blog_category='.$row["BlogCategory_Seourl"].'';
        // Active Control
        $active = "";
        if($GET_value == $row["BlogCategory_Seourl"]){
            $active = "active"; 
            $href = "";
        }
        // Get Count
        $category_count = 0;
        $category_count = $row["TotalCount"];
        // Get Values
        $values .= '
        <a href="./admin/show_blogs.php?'.$href.'" class="list-group-item d-flex align-items-center justify-content-between '.$active.'">
            '.$row["BlogCategory_Name"].' 
            <span class="badge badge-primary badge-pill">
            '.$category_count.'
            </span>
        </a>
        ';
    }
    return $values;
}
// Get Page Buttons
function GetPageButtons($connect, $wanted_category, $page_number){
    $values = array();
    $values["min"] = 1;

    // GET Control
    $link_category = (!empty($wanted_category)) ? "&blog_category=" . $wanted_category : "";
    $where_category = (!empty($wanted_category)) ? "where blog_categories.seourl = '".$wanted_category."'" : "";
    // end GET Control

    // Get Count
    $count = 0;
    $sql = "
    select 
    count(*) as Count_
    from blogs
    LEFT JOIN blog_categories ON blog_categories.id = blogs.category
    INNER JOIN accounts ON accounts.id = blogs.shared_aid
    $where_category";
    $query = mysqli_query($connect, $sql);
    if($row = mysqli_fetch_array($query)){
        $count = $row["Count_"];
    }
    // end Get Count

    if($count > 0){
        // Calculate Buttons
        $values["max"] = ceil($count / 6);
        // Max Min Control
        if($page_number < $values["min"]){
            $page_number = $values["min"];
        }else if ($page_number > $values["max"]){
            $page_number = $values["max"];
        }
        // end Max Min Control
        $values["buttons"] .= '<a href="./admin/show_blogs.php?'.$link_category.'&page='.$values["min"].'" class="btn btn-outline-primary prev"><i class="fa fa-angle-double-left"></i></a>';
        for ($i=1; $i <= $values["max"]; $i++) {
            $button_range = $i - $page_number;
            if(($button_range >= -2 ) && ($button_range <= 2 )){
                if(($i) == $page_number){
                    // Equals Page number
                    $values["buttons"] .= '<span class="btn btn-primary current">'.$i.'</span>';
                }else{
                    // Normal Page Button Button
                    $values["buttons"] .= '<a href="./admin/show_blogs.php?'.$link_category.'&page='.$i.'" class="btn btn-outline-primary">'.$i.'</a>';
                }
            }
        }
        $values["buttons"] .= '<a href="./admin/show_blogs.php?'.$link_category.'&page='.$values["max"].'" class="btn btn-outline-primary prev"><i class="fa fa-angle-double-right"></i></a>';
        // end Calculate Buttons
    }

    return $values;
}
/* end Functions */
?>