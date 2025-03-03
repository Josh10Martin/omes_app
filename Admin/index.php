<!DOCTYPE html>
<html lang="en">



<?php include 'includes/header.php'?>

<body>
	<style>
		.custom-width{
			max-width:17rem;
		}
		
	</style>
    <div class="main-wrapper">

<?php include 'includes/navbar.php'?>     

<?php include 'includes/sidebar.php'?>

        <div class="page-wrapper">
            <div class="content">

                <div class="row">
                    <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                        <div class="dash-widget">
							<span class="dash-widget-bg1">
								<!-- <i class="fa fa-stethoscope" aria-hidden="true"></i> -->
							</span>
							<div class="dash-widget-info text-right">
								<h3>98</h3>
								<span class="widget-title1">Examiners </i></span>
							</div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                        <div class="dash-widget">
                            <span class="dash-widget-bg2">
								<!-- <i class="fa fa-user-o"></i> -->
							</span>
                            <div class="dash-widget-info text-right">
                                <h3>1072</h3>
                                <span class="widget-title2">Candidates </i></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                        <div class="dash-widget">
                            <span class="dash-widget-bg3">
								<!-- <i class="fa fa-user-md" aria-hidden="true"></i> -->
							</span>
                            <div class="dash-widget-info text-right">
                                <h3>72</h3>
                                <span class="widget-title3">Missing Marks </i></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                        <div class="dash-widget">
                            <span class="dash-widget-bg4">
								<!-- <i class="fa fa-heartbeat" aria-hidden="true"></i> -->
							</span>
                            <div class="dash-widget-info text-right">
                                <h3>618</h3>
                                <span class="widget-title4">Scripts </i></span>
                            </div>
                        </div>
                    </div>
                </div>
				<div class="row">
					<div class="col-12 col-md-6 col-lg-6 col-xl-6">
						<div class="card">
							<div class="card-body">
								<div class="chart-title">
									<h4>Marksheets</h4>
									<span class="float-right"><i class="fa fa-caret-up" aria-hidden="true"></i> 15% Higher than Last Month</span>
								</div>	
								<canvas id="linegraph"></canvas>
							</div>
						</div>
					</div>
					<div class="col-12 col-md-6 col-lg-6 col-xl-6">
						<div class="card">
							<div class="card-body">
								<div class="chart-title">
									<h4>Marksheet</h4>
									<div class="float-right">
										<ul class="chat-user-total">
											<li><i class="fa fa-circle current-users" aria-hidden="true"></i>Recorded</li>
											<li><i class="fa fa-circle old-users" aria-hidden="true"></i> Missing</li>
										</ul>
									</div>
								</div>	
								<canvas id="bargraph"></canvas>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-12 col-md-6 col-lg-8 col-xl-8">
						<div class="card">
							<div class="card-header">
								<h4 class="card-title d-inline-block">Canditates</h4> <a href="appointments.html" class="btn btn-primary float-right">View all</a>
							</div>
							<div class="card-body p-0">
								<div class="table-responsive">
									<table class="table mb-0">
										<thead class="d-none">
											<tr>
												<th>Surname</th>
												<th style="max-width:5px;">Othername(s)</th>
												<th>Subject</th>
												<th class="text-right">Status</th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<td style="min-width: 200px;">
													<a class="avatar" href="profile.html">B</a>
													<h2><a href="profile.html">Bernardo Galaviz <span>173021190003</span></a></h2>
												</td>                 
												<td>
													<h5 class="time-title p-0" >Subjects</h5>
													<p class="custom-width" >[2230/1,2230/2,2111/1,2111/2,3021/1,2233/1,1121/2,1121/2]</p>
												</td>
												<td>
													<h5 class="time-title p-0">Timing</h5>
													<p>7.00 PM</p>
												</td>
												<td class="text-right">
													<a href="appointments.html" class="btn btn-outline-primary take-btn">Take up</a>
												</td>
											</tr>
											<tr>
												<td >
													<a class="avatar" href="profile.html">B</a>
													<h2><a href="profile.html">Bernardo Galaviz <span>New York, USA</span></a></h2>
												</td>                 
												<td>
													<h5 class="time-title p-0">Subjects</h5>
													<p class="custom-width" >[2230/1,2230/2,2111/1,2111/2,3021/1,2233/1,1121/2,1121/2]</p>
												</td>
												<td>
													<h5 class="time-title p-0">Timing</h5>
													<p>7.00 PM</p>
												</td>
												<td class="text-right">
													<a href="appointments.html" class="btn btn-outline-primary take-btn">Take up</a>
												</td>
											</tr>
											<tr>
												<td >
													<a class="avatar" href="profile.html">B</a>
													<h2><a href="profile.html">Bernardo Galaviz <span>New York, USA</span></a></h2>
												</td>                 
												<td>
													<h5 class="time-title p-0">Subjects</h5>
													<p class="custom-width" >[2230/1,2230/2,2111/1,2111/2,3021/1,2233/1,1121/2,1121/2]</p>
												</td>
												<td>
													<h5 class="time-title p-0">Timing</h5>
													<p>7.00 PM</p>
												</td>
												<td class="text-right">
													<a href="appointments.html" class="btn btn-outline-primary take-btn">Take up</a>
												</td>
											</tr>
											<tr>
												<td >
													<a class="avatar" href="profile.html">B</a>
													<h2><a href="profile.html">Bernardo Galaviz <span>New York, USA</span></a></h2>
												</td>                 
												<td>
													<h5 class="time-title p-0">Subjects</h5>
													<p class="custom-width" >[2230/1,2230/2,2111/1,2111/2,3021/1,2233/1,1121/2,1121/2]</p>
												</td>
												<td>
													<h5 class="time-title p-0">Timing</h5>
													<p>7.00 PM</p>
												</td>
												<td class="text-right">
													<a href="appointments.html" class="btn btn-outline-primary take-btn">Take up</a>
												</td>
											</tr>
				
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
                    <div class="col-12 col-md-6 col-lg-4 col-xl-4">
                        <div class="card member-panel">
							<div class="card-header bg-white">
								<h4 class="card-title mb-0">Examiners</h4>
							</div>
                            <div class="card-body">
                                <ul class="contact-list">
                                    <li>
                                        <div class="contact-cont">
                                           
                                            <div class="contact-info">
                                                <span class="contact-name text-ellipsis">John Doe</span>
                                                <span class="contact-date">2011/1</span>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="contact-cont">
                                           
                                            <div class="contact-info">
                                                <span class="contact-name text-ellipsis">Richard Miles</span>
                                                <span class="contact-date">1311/2</span>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="contact-cont">
                                            
                                            <div class="contact-info">
                                                <span class="contact-name text-ellipsis">John Doe</span>
                                                <span class="contact-date">1290/2</span>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="contact-cont">
                                            
                                            <div class="contact-info">
                                                <span class="contact-name text-ellipsis">Richard Miles</span>
                                                <span class="contact-date">2211/1</span>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="contact-cont">
                                            
                                            <div class="contact-info">
                                                <span class="contact-name text-ellipsis">John Doe</span>
                                                <span class="contact-date">2030/1</span>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="contact-cont">
                                            
                                            <div class="contact-info">
                                                <span class="contact-name text-ellipsis">Richard Miles</span>
                                                <span class="contact-date">1112/1</span>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <div class="card-footer text-center bg-white">
                                <a href="examiners.php" class="text-muted">View all Examiners</a>
                            </div>
                        </div>
                    </div>
				</div>
				<div class="row">
					<div class="col-12 col-md-6 col-lg-8 col-xl-8">
						<div class="card">
							<div class="card-header">
								<h4 class="card-title d-inline-block">Belts </h4> <a href="patients.html" class="btn btn-primary float-right">View all</a>
							</div>
							<div class="card-block">
								<div class="table-responsive">
									<table class="table mb-0 new-patient-table">
										<tbody>
											<tr>
												<td>
													<h2>Southern</h2>
												</td>
												<td>Mazabuka</td>
												<td>ST Edmunds Secondary</td>
												<td>5</td>
												<td><button class="btn btn-primary btn-primary-one float-right">Pending</button></td>
											</tr>
											
											<tr>
												<td>
													<h2>Martin</h2>
												</td>
												<td>Richard123@yahoo.com</td>
												<td>776-2323 89562015</td>
												<td>5</td>
												<td><button class="btn btn-primary btn-primary-four float-right">Fever</button></td>
											</tr>
											<tr>
												<td>
													<h2>Southern</h2>
												</td>
												<td>Mazabuka</td>
												<td>ST Edmunds Secondary</td>
												<td>5</td>
												<td><button class="btn btn-primary btn-primary-one float-right">Pending</button></td>
											</tr>
											
											<tr>
												<td>
													<h2>Martin</h2>
												</td>
												<td>Richard123@yahoo.com</td>
												<td>776-2323 89562015</td>
												<td>5</td>
												<td><button class="btn btn-primary btn-primary-four float-right">Fever</button></td>
											</tr>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
					<div class="col-12 col-md-6 col-lg-4 col-xl-4">
						<div class="barchart">
							<h4 class="card-title d-inline-block">Marking rate per belt</h4>
						</div>
						<div class="bar-chart">
							<div class="legend">
								<div class="item">
									<h4>Level1</h4>
								</div>
								
								<div class="item">
									<h4>Level2</h4>
								</div>
								<div class="item text-right">
									<h4>Level3</h4>
								</div>
								<div class="item text-right">
									<h4>Level4</h4>
								</div>
							</div>
							<div class="chart clearfix">
								<div class="item">
									<div class="bar">
										<span class="percent">25%</span>
										<div class="item-progress" data-percent="25">
											<span class="title">Belt 1</span>
										</div>
									</div>
								</div>
								<div class="item">
									<div class="bar">
										<span class="percent">71%</span>
										<div class="item-progress" data-percent="71">
											<span class="title">Belt 2</span>
										</div>
									</div>
								</div>
								<div class="item">
									<div class="bar">
										<span class="percent">82%</span>
										<div class="item-progress" data-percent="82">
											<span class="title">Belt 3</span>
										</div>
									</div>
								</div>
								<div class="item">
									<div class="bar">
										<span class="percent">90%</span>
										<div class="item-progress" data-percent="90">
											<span class="title">Belt 4</span>
										</div>
									</div>
								</div>
								<div class="item">
									<div class="bar">
										<span class="percent">100%</span>									
										<div class="item-progress" data-percent="100">
											<span class="title">Belt 5</span>
										</div>
									</div>
								</div>
							</div>
						</div>
					 </div>
				</div>
            </div>


    <!-- notifications -->
 <?php include 'includes/notifications.php' ?>

        </div>
    </div>

	<div class="sidebar-overlay" data-reff=""></div>

	
	<?php include 'includes/scripts.php' ?>
	<script src="../assets/js/Chart.bundle.js"></script>
	<script src="../assets/js/chart.js"></script>
 

</body>



</html>