<?php
include_once("./config/config.php");
include_once("./pages/contact_info/advanced_contact_info/functions/get_values.php");
include_once("./inc/send_smtp_mail.php");
session_start();
// Account Control
$email = $_SESSION["email"];
$id = GetID($conn, $email);
$permission = GetPermissionRange($conn, $id);
$default_Max_permission = 2;
// end Account Control
if ($_POST) {
    // Cleaning Variable
    $project_logo = ClearVariable($_POST["project_logo"], "normal");
    $title = ClearVariable($_POST["title"], "normal");
    $content = ClearVariable($_POST["content"], "replace-quotation-mark");
    $category = ClearVariable($_POST["category"], "normal+number");
    $post_now = ClearVariable($_POST["post_now"], "normal+number");
    $share_emails = ClearVariable($_POST["share_emails"], "normal+number");
    // Cleaned Variable
    // Active Control
    $post_now = (empty($post_now) || $post_now != 1) ? 0 : $post_now;
    // end Active Control

    // Variables Control
    $errorMessage = valueControl($conn, $project_logo, $title, $content, $category);
    // end Variables Control

    // Permission Control
    if(empty($errorMessage)){
        if($permission > $default_Max_permission){
            $errorMessage = "Low Permission"; 
        }
    }
    // end Permission Control

    if (empty($errorMessage)) {
        $seourl = convertURL($conn, $title);
        $date = date("Y-m-d H:i:s");
        $CreateProject = SaveProject($conn, $id, $project_logo.".jpeg", $title, $content, $category, $seourl, $date, $post_now);
        if ($CreateProject == "Success") {
            if ($share_emails == 1) {
                // Send Mails
                sendMail($conn, $ContactValues, $seourl, $title, $date);
            }
            header("Location: show_projects.php");
        }
    }else {
        $ErrorMessage_show = '
        <div class="alert alert-danger" role="alert" style="margin-top:10px;">
            '.$errorMessage.'
        </div>
        ';
    }
}

/* Functions */
// Save Project
function SaveProject($connect, $account_id, $project_logo, $title, $content, $category, $seourl, $date, $is_active){
    $sql = "insert into projects(`id`, `main_image`, `title`, `content`, `category`, `shared_aid`, `seourl`, `date`, `is_active`) 
    values (null, '$project_logo', '$title', '$content', '$category', '$account_id', '$seourl', '$date', '$is_active')";
    if (mysqli_query($connect, $sql)) {
        return "Success";
    }else {
        return "Error: ".mysqli_error($connect);
    }
}
// end Save Proje

// Values Control
function valueControl($connect, $project_logo, $title, $content, $category){
    // Message
    $errorMessage = "";

    // Control - 1
    if (empty($project_logo)){
        $errorMessage .= "<li>Please enter the project main image!</li>";
    }else if(strlen($project_logo) > 25){
        $errorMessage .= "<li>Project main image is very long!</li>";
    }

    // Control - 2
    if (empty($title)){
        $errorMessage .= "<li>Please enter the title!</li>";
    }else if(strlen($title) > 50){
        $errorMessage .= "<li>title is very long!</li>";
    }

    // Control - 3
    if (empty($content)){
        $errorMessage .= "<li>Please enter the project blog content!</li>";
    }else if(strlen($content) > 20000){
        $errorMessage .= "<li>Project blog content is very long!</li>";
    }

    // Control - 5
    if (!empty($category)) {
        if(CategoryControl($connect, $category)){
            $errorMessage .= "<li>Wrong Category!</li>";
        }
    }else{
        $errorMessage .= "<li>Please fill Category!</li>";
    }
    
    // Return Message
    return $errorMessage;
}
// end Values Control

// Category Control
function CategoryControl($connect, $category){
    $sql = "SELECT * FROM `project_categories` where id = ".(int)$category."";
    $query = mysqli_query($connect, $sql);
    if(mysqli_num_rows($query) > 0) {
        return false;
    }else {
        return true;
    }
}
// end Category Control

// Convert Seo Url
function convertUrl($connect, $url) {
    // Convert Seo Url
    $tr = array('ş','Ş','ı','I','İ','ğ','Ğ','ü','Ü','ö','Ö','Ç','ç','(',')','/',':',',','!');
    $eng = array('s','s','i','i','i','g','g','u','u','o','o','c','c','','','-','-','','');
    $url = str_replace($tr, $eng, $url);
    $url = strtolower($url);
    $url = preg_replace('/&amp;amp;amp;amp;amp;amp;amp;amp;amp;.+?;/', '', $url);
    $url = preg_replace('/\s+/', '-', $url);
    $url = preg_replace('|-+|', '-', $url);
    $url = preg_replace('/#/', '', $url);
    $url = str_replace('.', '', $url);
    $url = str_replace("'", '', $url);
    $url = trim($url, '-');
    // end Convert Seo Url
    
    // Seo Url Control
    $new_url = $url;
    $number = 2;
    while(controlSeoName($connect, $new_url)){
        $new_url = $url . $number; 
        $number++;
    }
    // end Seo Url Control

    return $new_url;
}
// end Convert Seo Url

// Control Seo Url
function controlSeoName($connect, $seoName){
    $sql = "select * from projects where seourl = '$seoName'";
    $query = mysqli_query($connect, $sql);
    if(mysqli_num_rows($query) > 0){
        return true;
    }else {
        return false;
    }
}
//  end Control Seo Url

function sendMail($connect, $contactValues, $Project_seourl, $msg_title, $msg_date){
    // Mail Infos
    $mail_subject = "Yeni Proje";
    // end Mail Info
    $sql = "select * from followers order by date asc";
    $query = mysqli_query($connect, $sql);
    while ($row = mysqli_fetch_array($query)) {
        // Get mail Message
        $mail_content = HTMLDesignMail(
            "Yeni Bir Proje: ".$msg_title, // -> Message Title
            "Sayfamızda yeni bir proje paylaşılmıştır.<br>Paylaşılma Tarihi: $msg_date<br>Bloğu görmek için lütfen butona tıklayınız. Ayrıca mesajlarımızı artık almak istemiyorsanız Takibi Bırak linkine tıklayınız.<br>Gelişmeler hakkında sizleri daha fazla bilgilendirmemiz için sosyal medya hesaplarından bizleri takip etmeyi unutmayınız.", // -> Message Content 
            "Devamını Gör", // -> Message in Read More Button 
            "Gizlilik Sözleşmesi", // -> Message in Privacy Policy Button 
            "Takibi Bırak", // -> Message in Unfallow Button 
            "https://".$_SERVER['HTTP_HOST']."/project-detail.php?project=$Project_seourl", // -> Proje Link 
            "https:/".$_SERVER['HTTP_HOST']."/follow/unfollow.php?email=".$row["email"]."" // -> Follower Unfallow Link
        );
        // Set Mail Message
        sendMail_smtp($contactValues["contact_form_host"], 
        $contactValues["contact_form_email"], 
        $contactValues["contact_form_password"], 
        $contactValues["contact_form_title"], 
        $row["email"], 
        $row["email"], 
        "Yeni Bir Proje Haberi", 
        $mail_content);
    }
}
/* end Functions */
?>