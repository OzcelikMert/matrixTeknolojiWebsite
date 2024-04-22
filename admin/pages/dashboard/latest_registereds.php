<!-- Latest Registereds -->
<div class="bg-white pd-20 box-shadow border-radius-5 mb-30">
    <div class="row clearfix">
        <div class="bg-white col-xl-12 col-lg-12 col-md-12 col-sm-12 mb-30">
            <h4 class="text-blue mb-30">Latest Registereds</h4>
            <div class="card-group mb-30">
                <div class="table-responsive">
                	<table class="table table-striped">
                	  <thead>
                	    <tr>
                	        <th scope="col">Name</th>
                          <th scope="col">Nickname</th>
                          <th scope="col">Email</th>
                          <th scope="col">Permission</th>
                          <th scope="col">Registered Date</th>
                	    </tr>
                	  </thead>
                	  <tbody>
                	    <?php echo $Registereds; ?>
                	  </tbody>
                	</table>
                </div>
            </div>
        </div>
    </div>
</div>