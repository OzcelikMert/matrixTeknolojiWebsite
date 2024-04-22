<?php
#Profile Image Values
// Get $Account_Info = sameparts -> account_settings.php
$image_ = $Account_Info["image"];
$profilename_ = $Account_Info["name"] . " " . $Account_Info["surname"];
$permission_ = $Account_Info["permission"];
?>
<div class="profile-photo">
	<a href="javascript:OpenFileDialog();" class="edit-avatar"><i class="fa fa-pencil"></i></a>
	<input type="file" class="custom-file-input" id="customFile" style="display:none;">
    <img src="./images/account/<?php echo $image_; ?>" alt="<?php echo $profilename_; ?>" class="avatar-photo" id="avatar-image" style="max-height: 160px; max-width: 160px; min-height: 160px; min-width: 160px;">
	<!-- Popup -->
    <a href="javascript:void(0);" id="CroppedPopup" class="btn-block" data-toggle="modal" data-target="#Popup"></a>
    <div class="modal fade bs-example-modal-lg show" id="Popup" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" style="display: none; padding-right: 17px;">
    	<div class="modal-dialog modal-lg modal-dialog-centered">
    		<div class="modal-content" style="width:auto;">
    			<div class="modal-body">
    				<!-- Cropper -->
                    <div class="figure-wrapper">
                        <figure class="image-container target">
                          <div class="darkroom-container" id="ImageCropper">
                            <!-- Coropper Image in darkroom JS -->
                          </div>
                        </figure>
                    </div>
                    <p>For cropping image is click or press 'c'.</p>
                    <!-- end Cropper -->
    			</div>
    			<div class="modal-footer">
    				<button class="btn btn-primary" id="CroppedOkay" data-dismiss="modal" disabled>Update</button>
    			</div>
    		</div>
    	</div>
    </div>
    <!-- end Popup -->
</div>
<div>
    <h5 class="text-center"><?php echo $profilename_; ?></h5>
    <p class="text-center text-muted"><?php echo $permission_; ?></p>
</div>