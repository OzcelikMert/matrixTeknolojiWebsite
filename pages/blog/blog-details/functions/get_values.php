<?php
include_once("./admin/config/config.php");

// GET Values
$blog_seo_name = ClearVariable($_GET["blog"], "normal");
// end GET Values

// Values //
$Blog_Values = GetBlog_Values($conn, $blog_seo_name);

// Values Empty Control
if(empty($Blog_Values)){
    header("Location: blogs.php");
}
// end Values //


/* Functions */

// Get Blog
function GetBlog_Values($connect, $blog_seo_name){
    $values = "";
    $sql = "
    select 
    blogs.main_image as Blog_Logo,
    blogs.title as Blog_Title,
    blogs.content as Blog_Content,
    blogs.date as Blog_Date,
    blogs.fixed as Blog_Fixed,
    blog_categories.name as Blog_Category,
    blog_categories.seourl as Blog_Category_Seourl,
    accounts.nickname as Blog_SharedName 
    from blogs 
    INNER JOIN blog_categories ON blog_categories.id = blogs.category 
    INNER JOIN accounts ON accounts.id = blogs.shared_aid 
    where blogs.seourl = '$blog_seo_name'
    ";
    $query = mysqli_query($connect, $sql);
    if ($row = mysqli_fetch_array($query)) {
		$values .= '
        <img src="images/blog/logo/'.$row["Blog_Logo"].'" alt="'.$row["Blog_Title"].'" title="'.$row["Blog_Title"].'">
        <div class="post-heading">
        	<h4>'.$row["Blog_Title"].'</h4>
        	<span>Paylaşan: <p style="display: inline-block;" class="tran3s p-color">'.$row["Blog_SharedName"].'</p>  '.$row["Blog_Date"].' | <a href="./blogs.php?blog_category='.$row["Blog_Category_Seourl"].'" class="tran3s active">'.$row["Blog_Category"].'</a></span>
        </div>
        '.$row["Blog_Content"].'
        ';
	}

    return $values;
}
// end Get Blog

/* end Functions */
?>