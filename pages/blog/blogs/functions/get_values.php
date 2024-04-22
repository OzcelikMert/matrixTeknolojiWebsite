<?php
include_once("./admin/config/config.php");

// GET Values
$get_category_value = ClearVariable($_GET["blog_category"], "normal");
$get_text_value = ClearVariable($_GET["wanted_text"], "normal");
$get_page_number = ClearVariable($_GET["page"], "normal+number");
$get_page_number = (!empty($get_page_number)) ? $get_page_number : 0;
// end GET Values

// Values //
$SortCount = 6;
$Button_Values = GetPageButton_Values($conn, $get_text_value, $get_category_value, $get_page_number);

// Page Number Max Min Control
if($get_page_number < $Button_Values["min"]){
    $get_page_number = $Button_Values["min"];
}else if ($get_page_number > $Button_Values["max"]){
    $get_page_number = $Button_Values["max"];
}
$min = ($get_page_number - 1 >= 0) ? $SortCount * ($get_page_number - 1) : 0;
$max = $SortCount;
// end Page Number Max Min Control

$Blog_Values = GetBlog_Values($conn, $get_text_value, $get_category_value, $min, $max);
// end Values //


/* Functions */

// Get All Blogs
function GetBlog_Values($connect, $wanted_text, $wanted_category, $min, $max){
    $where_category = (!empty($wanted_category)) ? " and blog_categories.seourl = '".$wanted_category."'" : "";
    $where_category .= (!empty($wanted_text)) ? " and blogs.title like '%".$wanted_text."%'" : "";
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
    where blogs.is_active = '1' $where_category
    ORDER BY Blog_Fixed DESC, Blog_Date DESC 
    LIMIT $min, $max
    ";
    $query = mysqli_query($connect, $sql);
    while ($row = mysqli_fetch_array($query)) {
		$values .= '
        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
			<div class="single-news-item">
				<div class="img">
					<img src="images/blog/logo/'.$row["Blog_Logo"].'" alt="'.$row["Blog_Title"].'" style="min-height: 200px; min-width: 100%;">
					<a href="./blog-detail.php?blog='.$row["Blog_Seourl"].'" class="opacity tran4s"><i class="fa fa-eye" aria-hidden="true"></i></a>
				</div> <!-- /.img -->
				<div class="post">
					<h6><a href="./blog-detail.php?blog='.$row["Blog_Seourl"].'" class="tran3s">'.$row["Blog_Title"].'</a></h6>
                    <a href="javascript:void(0);" style="cursor: default;">Paylaşan: <span class="p-color">'.$row["Blog_SharedName"].'</span> | Tarih: '.$row["Blog_Date"].'</a>
					<a href="blogs.php?blog_category='.$row["Blog_Category_Seourl"].'">Kategori: <span class="p-color">'.$row["Blog_Category"].'</span></a>
					<p style="word-break: break-word; overflow: hidden;">'.strip_tags(substr($row["Blog_Content"], 0, 100)).'...<a href="./blog-detail.php?blog='.$row["Blog_Seourl"].'" class="tran3s">Devamını Oku</a></p>
				</div>
			</div>
		</div>
        ';
	}
    
    if(empty($values)){
        $values .= "<p style='color: red; font-size: 20px;'>Üzgünüz. Hiç bir sonuç bulunamadı!</p>";
    }

    return $values;
}
// end Get All Blogs

// Get Page Buttons
function GetPageButton_Values($connect, $wanted_text, $wanted_category, $page_number){
    $values = array();
    $values["min"] = 1;

    // GET Control
    $link_category = (!empty($wanted_category)) ? "&blog_category=" . $wanted_category : "";
    $link_category .= (!empty($wanted_text)) ? "&wanted_text=" . $wanted_text : "";

    $where_category = (!empty($wanted_category)) ? " and blog_categories.seourl = '".$wanted_category."'" : "";
    $where_category .= (!empty($wanted_text)) ? " and blogs.title like '%".$wanted_text."%'" : "";
    // end GET Control

    // Get Count
    $count = 0;
    $sql = "
    select 
    count(*) as Count_
    from blogs
    LEFT JOIN blog_categories ON blog_categories.id = blogs.category
    INNER JOIN accounts ON accounts.id = blogs.shared_aid
    where blogs.is_active = '1' $where_category
	";
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
        $values["buttons"] .= '<a href="./blogs.php?'.$link_category.'&page='.$values["min"].'" class="btn btn-outline-primary"><i class="fa fa-angle-double-left"></i></a>';
        for ($i=1; $i <= $values["max"]; $i++) {
            $button_range = $i - $page_number;
            if(($button_range >= -2 ) && ($button_range <= 2 )){
                if(($i) == $page_number){
                    // Equals Page number
                    $values["buttons"] .= '<span class="btn btn-primary">'.$i.'</span>';
                }else{
                    // Normal Page Button Button
                    $values["buttons"] .= '<a href="./blogs.php?'.$link_category.'&page='.$i.'" class="btn btn-outline-primary">'.$i.'</a>';
                }
            }
        }
        $values["buttons"] .= '<a href="./blogs.php?'.$link_category.'&page='.$values["max"].'" class="btn btn-outline-primary"><i class="fa fa-angle-double-right"></i></a>';
        // end Calculate Buttons
    }

    return $values;
}
// end Get Page Buttons

/* end Functions */
?>