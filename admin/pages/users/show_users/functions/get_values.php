<?php
include_once("./config/config.php");
// sameparts/accounts_settings -> have: $email, $id , $permission and all permissions
// Values //
$Accounts = GetAccounts($conn, $id, $permission, $Author);
// end Values //

/* Functions */
// Get Users
function GetAccounts($connect, $self_id, $permission, $maxPermission){
    $values = "";
    $sql = "
    select 
    accounts.id as AccountId,
    accounts.image as AccountImage,
    accounts.nickname as AccountNickname,
    accounts.name as AccountName,
    accounts.surname as AccountSurname,
    accounts.email as AccountEmail,
    accounts.tel as AccountTel,
    accounts.is_lock as AccountLock,
    accounts.lock_comment as AccountLockComment,
    accounts.lock_date as AccountLockDate,
    permissions.name as PermissionName,
    permissions.permission_range as PermissionRange
    from accounts
    INNER JOIN permissions ON permissions.id = accounts.permission
    where accounts.id NOT LIKE $self_id
    order by PermissionRange asc, AccountId desc
    ";
    $query = mysqli_query($connect, $sql);
    // Banned bg-color: #ff000033;
    // Banned Contact Avatar under line <h2 style="color:red;">Banned</h2>
    // Same bg-color: #d8d8d8c2;
    // Same delete: Delete Button
    while ($row = mysqli_fetch_array($query)) {
        // Get Blog Count
        $sql_blogCount = "select count(*) as BlogCount from blogs where shared_aid = '".$row["AccountId"]."'";
        $query_blogCount = mysqli_query($connect, $sql_blogCount);
        if($row_blogCount = mysqli_fetch_array($query_blogCount)){
            $blog_count = $row_blogCount["BlogCount"];
        }
        // end Get Blog Count
        $delete_link = '<a href="javascript:deleteAccount('.$row["AccountId"].');" style="background: #ce1d1d;color: white;">Delete</a>';
        $bg_color = "#ffffff";
        $banned_text = "";
        $accountBannedInfoValues = "";
        $permissionName = $row["PermissionName"];
        // Permission Control
        if($permission >= $row["PermissionRange"]){
            $delete_link = '<a href="javascript:void(0);" style="background: #8b8b8b;color: white;cursor: not-allowed;">Delete</a>';
            $bg_color = "#d8d8d8c2";
        }
        // Permission Control 2
        if($permission > $maxPermission){
            $delete_link = '';
            $permissionName = 'Hidden';
            $bg_color = "#ffffff";
        }
        // Ban Control
        if($row["AccountLock"] == "1"){
            // Banned Date Control
            $get_LockDate = date_create($row["AccountLockDate"]);
            $now_date = date_create(date("Y-m-d"));
            if($now_date < $get_LockDate){
                // Account is banned
                $bg_color = "#ff000033";
                $date_difference = date_diff($now_date, $get_LockDate);
                $banned_text = '<h4 style="color:red;">'.$date_difference->format("%a").' Days Banned!</h4>';
                $accountBannedInfoValues = "
                <li>
                    <p style='color:red;'><i class='fa fa-ban'></i>Account is Banned!</p>
                </li>
                <li>
                    <span>Banned Comment:</span>
                    ".$row["AccountLockComment"]."
                </li>
                <li>
                    <span>Account Opening Date:</span>
                    ".$row["AccountLockDate"]."
                </li>
                ";
            }
        }
        // Get Values
        $values .= '
        <li class="col-xl-4 col-lg-4 col-md-6 col-sm-12" id="user_'.$row["AccountId"].'" user-name="'.$row["AccountName"]." ".mb_strtoupper($row["AccountSurname"]).'">
            <div class="contact-directory-box" style="background-color: '.$bg_color.';min-height: 300px;">
                <div class="contact-dire-info text-center" style="max-height: 315px;">
                    <div class="contact-avatar">
                        <span>
                            <img src="./images/account/'.$row["AccountImage"].'" alt="'.$row["AccountName"]." ".mb_strtoupper($row["AccountSurname"]).'" title="'.$row["AccountName"]." ".mb_strtoupper($row["AccountSurname"]).'" style="height: 150px; width: 150px;">
                        </span>
                    </div>
                    <div class="contact-name">
                        '.$banned_text.'
                        <h4>'.$row["AccountName"]." ".mb_strtoupper($row["AccountSurname"]).'</h4>
                        <p>'.$permissionName.'</p>
                        <div class="work text-success"><i class="fa fa-tag"></i> '.$row["AccountNickname"].'</div>
                    </div>
                </div>
                <div class="view-contact">
                    <a href="javascript:void(0);" data-toggle="modal" data-target="#account_'.$row["AccountId"].'_info" style="border-radius:0px;">View Profile</a>
                    <!-- User Info -->
                    <div class="modal fade" id="account_'.$row["AccountId"].'_info" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" style="display: none;text-align: -webkit-center;" aria-hidden="true">
                        <div class="col-xl-3 col-lg-4 col-md-4 col-sm-12 mb-30" style="margin-top: 4%;">
					    	<div class="pd-20 bg-white border-radius-4 box-shadow">
					    		<div class="profile-photo">
                                    <img src="./images/account/'.$row["AccountImage"].'" alt="'.$row["AccountName"]." ".mb_strtoupper($row["AccountSurname"]).'" title="'.$row["AccountName"]." ".mb_strtoupper($row["AccountSurname"]).'" class="avatar-photo" style="height: 150px; width: 150px;">
                                    <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" style="display: none;" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                        </div>
                                    </div>
                                </div>
					    		<h5 class="text-center">'.$row["AccountName"]." ".mb_strtoupper($row["AccountSurname"]).'</h5>
					    		<p class="text-center text-muted">'.$row["AccountNickname"].'</p>
					    		<div class="profile-info">
					    			<h5 class="mb-20 weight-500">Contact Information</h5>
					    			<ul>
					    				<li>
					    					<span>Email Address:</span>
					    					'.$row["AccountEmail"].'
					    				</li>
					    				<li>
					    					<span>Phone Number:</span>
					    					'.$row["AccountTel"].'
					    				</li>
					    				<li>
					    					<span>Writed Blog Number:</span>
					    					'.$blog_count.'
                                        </li>
					    				'.$accountBannedInfoValues.'
                                        <li>
					    					<span>Account Permission:</span>
					    					'.$permissionName.'
					    				</li>
					    			</ul>
					    		</div>
                                <a href="javascript:void(0);" data-toggle="modal" data-target="#account_'.$row["AccountId"].'_info" style="border-radius:0px;background: #908d8db0;color: #424242;">Close</a>
					    	</div>
                        </div>
                    </div>
                    <!-- end User Info -->
                    '.$delete_link.'
                </div>
            </div>
        </li>
        ';
        // end Get Values
    }
    return $values;
}
/* end Functions */
?>