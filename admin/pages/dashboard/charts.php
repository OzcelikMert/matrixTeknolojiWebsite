<!-- Charts -->
<div class="bg-white pd-20 box-shadow border-radius-5 mb-30">
	<div class="row clearfix">
		<div class="col-sm-6 col-md-6 col-lg-6 xs-mb-30">
            <div class="card">
	            <div class="p-4 border-bottom bg-light">
	              <h4 class="card-title mb-0">View Statisctics</h4>
	            </div>
	            <div class="card-body">
	              <div class="d-flex flex-column flex-lg-row">
	                <ul class="nav nav-tabs sales-mini-tabs ml-lg-auto mb-4 mb-md-0" role="tablist" style="align-self: center;">
	                  <li class="nav-item">
	                    <a class="nav-link active" style="cursor: pointer;" id="view-statistics_switch_1" data-toggle="tab" role="tab" aria-selected="true">1 Week</a>
	                  </li>
	                  <li class="nav-item">
	                    <a class="nav-link" style="cursor: pointer;" id="view-statistics_switch_2" data-toggle="tab" role="tab" aria-selected="false">1 Month</a>
	                  </li>
	                  <li class="nav-item">
	                    <a class="nav-link" style="cursor: pointer;" id="view-statistics_switch_3" data-toggle="tab" role="tab" aria-selected="false">1 Year</a>
	                  </li>
	                </ul>
	              </div>
	              <div class="d-flex flex-column flex-lg-row" style="align-items: center;">
	                <div class="data-wrapper d-flex mt-2 mt-lg-0">
	                  <div class="wrapper">
	                    <h5 class="mb-0">Total Views</h5>
	                    <div class="d-flex align-items-center">
	                      <h4 class="font-weight-semibold mb-0"><?php echo $TotalView; ?></h4>
	                    </div>
	                  </div>
	                </div>
	                <div class="ml-lg-auto" id="view-statistics-legend"></div>
	              </div>
	              <canvas id="ViewChart" class="mt-5" height="120"></canvas>
	            </div>
	        </div>
		</div>
		<div class="col-sm-6 col-md-6 col-lg-6 xs-mb-30">
            <div class="card">
	            <div class="p-4 border-bottom bg-light">
	              <h4 class="card-title mb-0">Blog Statistics</h4>
	            </div>
	            <div class="card-body">
	              <div class="d-flex flex-column flex-lg-row">
	                <ul class="nav nav-tabs sales-mini-tabs ml-lg-auto mb-4 mb-md-0" role="tablist" style="align-self: center;">
	                  <li class="nav-item">
	                    <a class="nav-link active" style="cursor: pointer;" id="blog-statistics_switch_1" data-toggle="tab" role="tab" aria-selected="true">1 Week</a>
	                  </li>
	                  <li class="nav-item">
	                    <a class="nav-link" style="cursor: pointer;" id="blog-statistics_switch_2" data-toggle="tab" role="tab" aria-selected="false">1 Month</a>
	                  </li>
	                  <li class="nav-item">
	                    <a class="nav-link" style="cursor: pointer;" id="blog-statistics_switch_3" data-toggle="tab" role="tab" aria-selected="false">1 Year</a>
	                  </li>
	                </ul>
	              </div>
	              <div class="d-flex flex-column flex-lg-row" style="align-items: center;">
	                <div class="data-wrapper d-flex mt-2 mt-lg-0">
	                  <div class="wrapper">
	                    <h5 class="mb-0">Total Blogs</h5>
	                    <div class="d-flex align-items-center">
	                      <h4 class="font-weight-semibold mb-0"><?php echo $TotalBlog; ?></h4>
	                    </div>
	                  </div>
	                </div>
	                <div class="ml-lg-auto" id="blog-statistics-legend"></div>
	              </div>
	              <canvas id="BlogChart" class="mt-5" height="120"></canvas>
	            </div>
	        </div>
		</div>
	</div>
</div>