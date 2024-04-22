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
                <p>For cropping image is mouse left click or press 'c'.</p>
                <!-- end Cropper -->
			</div>
			<div class="modal-footer">
				<button class="btn btn-primary" id="CroppedOkay" data-dismiss="modal" disabled>Okay</button>
			</div>
		</div>
	</div>
</div>
<!-- end Popup -->