<?php
include_once("./admin/config/config.php");

// GET Values
$get_category_value = ClearVariable($_GET["blog_category"], "normal");
// end GET Values

// Get Variables
$Category_Values = GetCategory_Values($conn, $get_category_value);
$RecentBlog_Values = GetRecentBlog_Values($conn);
// end Get Variables


/* Functions */

// Get Categories
function GetCategory_Values($connect, $GET_value){
    $values = "";
    $sql = '
    select
    blog_categories.name as BlogCategory_Name,
    blog_categories.seourl as BlogCategory_Seourl,
    Count(blogs.id) as TotalCount
    from blog_categories
    INNER JOIN blogs ON blogs.category = blog_categories.id
    where blogs.is_active = "1"
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
        <li>
            <a href="blogs.php?'.$href.'" class="tran3s '.$active.'">
                <i class="fa fa-hand-o-right" aria-hidden="true"></i>
                <span class="badge" style="background-color: #d73e4d;">
                    '.$row["TotalCount"].'
                </span> 
                '.$row["BlogCategory_Name"].'
            </a>
        </li>
        ';
    }

    return $values;
}

// Get Recent Blogs
function GetRecentBlog_Values($connect){
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
    LIMIT 0, 5
    ";
    $query = mysqli_query($connect, $sql);
    while($row = mysqli_fetch_array($query)){
        $values .= '
        <div class="recent-single-post clear-fix">
	    	<img src="./images/blog/logo/'.$row["Blog_Logo"].'" alt="'.$row["Blog_Title"].'" class="float-left" style="width: 50px; height: 50px;">
	    	<div class="post float-left">
	    		<a href="./blog-detail.php?blog='.$row["Blog_Seourl"].'" class="tran3s">'.$row["Blog_Title"].'</a>
	    		<span>'.$row["Blog_Date"].'</span>
	    	</div>
	    </div>
        ';
    }

    return $values;
}

/* end Functions */
?>