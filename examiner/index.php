<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">




<?php include 'includes/header.php';

if($_SESSION['user_type'] == 'ADMIN' || $_SESSION['user_type'] == 'ECZ' || $_SESSION['user_type'] == 'DEO' ){
	include '../config.php';
	include '../functions.php';
	
	// if($_SESSION['user_type'] == 'DEO' && data_entry_in_attendance($db_12_gce) != 'true'){
	// 	echo '<script>
	// 	alert("DATA ENTRY OPERATOR NOT IN ATTENDANCE");location="../php/logout.php";
	// 	</script>';
	// }
?>

<body>
	<style>
		.custom-width{
			max-width:17rem;
		}

		a.btn-off{
			color:black;
		}
		
	</style>
    <div class="main-wrapper">

<?php include 'includes/navbar.php'?>     

<?php include 'includes/sidebar.php'?>

        <div class="page-wrapper">
<div class="content">
<div class="row py-3">
	<div class="col-6">
		<h4 class="blue-ecz">DASHBOARD</h4>
	</div>
	<div class="col-6">
		<h4 class="blue-ecz">MARKING CENTRE: <span> <?php echo $_SESSION['marking_centre'] ?></span></h4>
	</div>
</div>


<?php
if($_SESSION['user_type'] == 'DEO' ){

	?>
	<div class="row">
		
		<div class="col-md-6">
			DATA ENTRY OPERATOR
		</div>

		<div class="col-md-6">
			<span > MARKING CENTRE : <?php echo $_SESSION['marking_centre'] ?> </span>
		</div>

	</div>


			<?php
}
			// echo $_SESSION['marking_centre'];
				if($_SESSION['user_type'] == 'ADMIN' || $_SESSION['user_type'] == 'ECZ' ){

			?>
			<div class="row">
			<div class=" col-xl-5 col-lg-6">
				<div class="row">
			<div class="col-md-6">
				<div class="card">
					<div class="card-body p-3">
					<div class="float-right">
					<i class="fa fa-users green-ecz widget-icon bg-green" aria-hidden="true"></i>
					</div>
					<h5 class="text-muted fw-normal mt-0" title="Number of Customers">Examiners</h5>
					<span class="mt-1 mb-1 examiner_number"></span>
					<span class="text-nowrap">Registered</span>  
					<p class="mb-0 text-muted">
						
						
                    </p>
					<span class="mt-1 mb-1 examiner_number_present"></span>
					<span class="text-nowrap">Present</span> 
					</div>
				</div>
			</div>
			<?php
			}
			if($_SESSION['user_type'] == 'ECZ' ){
			?>
			<div class="col-md-6">
					<div class="card">
					<div class="card-body p-3">
					<div class="float-right">
					<i class="fa fa-university blue-ecz widget-icon bg-blue" aria-hidden="true"></i>
					</div>
					<h5 class="text-muted  mt-0">Centres</h5>
					<h3 class="mt-1 mb-1 no_of_schools"></h3>
					<p class="mb-0 text-muted">
						<!-- <span class="text-success me-2"> 5.27%</span> -->
						<span class="text-nowrap p-0 m-0">From OCRS</span>  
                    </p>
					</div>
				</div>
			</div>
			<?php
			}
			?>
		<!-- </div>
		<div class="row"> -->
			<?php
			if($_SESSION['user_type'] == 'ADMIN' || $_SESSION['user_type'] == 'ECZ' ){
			?>
			<div class="col-md-6">
				<div class="card">
					<div class="card-body p-3">
					<div class="float-right">
						<i class="widget-icon  widget-icon bg-blue">
						<img src="../assets/img/essay_sm.png" alt="">
						</i>
						
					<!-- <i class="fa fa-users green-ecz widget-icon bg-green" aria-hidden="true"></i> -->
					</div>
					<h5 class="text-muted fw-normal mt-0" title="Number of Customers">Scripts</h5>
					<h3 class="mt-1 mb-1 no_of_scripts"></h3>
					<p class="mb-0 text-muted">
						<span class="text-nowrap">All</span>  
                    </p>
					</div>
				</div>
			</div>

			
			<div class="col-md-6">
					<div class="card">
					<div class="card-body p-3">
					<div class="float-right">
					<i class="widget-icon  widget-icon bg-red">
						<img src="../assets/img/missing-marks.png" alt="">
					</i>
					<!-- <i class="fa fa-university blue-ecz widget-icon bg-green" aria-hidden="true"></i> -->
					</div>
					<h5 class="text-muted  mt-0">marks not entered</h5>
					<h3 class="mt-1 mb-1 missing_marks"></h3>
					<p class="mb-0 text-muted">
						<span class="text-nowrap p-0 m-0">All</span>  
                    </p>
					</div>
				</div>
			</div>
			<?php
			}
			?>
		 </div>
	</div> 
	<?php
//	if($_SESSION['user_type'] == 'ADMIN' || $_SESSION['user_type'] == 'ECZ' ){
	?>
	<div class="col-xl-7 col-lg-6">
		<div class="card">
		  <div class="d-flex card-header justify-content-between py-1">
			<h4 class="header-title">NO. of Scripts Per Subject</h4>
		  </div>
		  <div class="card-body p-1">
			<div id="chart"></div>
			<div id="pagination" class="d-flex p-0  justify-content-center">
				<a href="javascript:void(0)" id="prev" onclick="previousPage()" class="px-2 btn-off"><i class="fa fa-chevron-circle-left" aria-hidden="true"></i></a>
				<a href="javascript:void(0)" id="next" onclick="nextPage()" class="px-2 "><i class="fa fa-arrow-right" ></i></a>
			</div>
		  <!-- <canvas id="linegraph" style="height: 100px;"></canvas> -->
		  </div>
		</div>
	</div>
	<?php
//	}
	?>
</div>
<div class="row">
	<?php
	if($_SESSION['user_type'] == 'ADMIN' || $_SESSION['user_type'] == 'ECZ' ){
	?>
	<div class="col-xl-4 col-lg-6">
		<div class="card">
			<div class="d-flex card-header justify-content-between align-items-center px-2 pb-0 pt-1">
				<h4>Marks</h4>
			</div>
			<div class="card-body pt-0">
				<div class="table-responsive">
					<table class="table table-sm table-centered mb-0 font-14">
						<thead class="table-light">
							<tr>
								<th>Type</th>
								<th>No.</th>
								<th style="width: 40%;"></th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>Entered</td>
								<td class="no_of_entered_marks"></td>
								<td>
									<div class="progress" style="height: 3px;">
										<div class="progress-bar no_of_entered_marks" role="progressbar" style="height: 20px;" aria-valuenow="" aria-valuemin="0" aria-valuemax=""></div>
									</div>
								</td>
							</tr>
							<tr>
								<td>marks not entered</td>
								<td class="missing_marks"></td>
								<td>
									<div class="progress" style="height: 3px;">
										<div class="progress-bar bg-info missing_marks" role="progressbar" style="height: 20px;" aria-valuenow="" aria-valuemin="0" aria-valuemax=""></div>
									</div>
								</td>
							</tr>
							<tr>
								<td>Improvised</td>
								<td class="no_of_improvised"></td>
								<td>
									<div class="progress" style="height: 3px;">
										<div class="progress-bar bg-danger no_of_improvised" role="progressbar" style="height: 20px;" aria-valuenow="" aria-valuemin="0" aria-valuemax=""></div>
									</div>
								</td>
							</tr>
						</tbody>
					</table>
				</div> <!-- end table-responsive-->
			</div>
		</div>
		<?php
		}
		?>
	</div>
	<?php
	if($_SESSION['user_type'] == 'ECZ'  || $_SESSION['user_type'] == 'ADMIN'){
	?>
	<div class="col-xl-4 col-lg-6">
		<div class="card">
			<div class="card-header d-flex justify-content-between align-items-cetnter px-2 pb-0 pt-1">
				<h4>Attendance</h4>
			</div>
			<div class="card-body p-1 bg-light">
				<div id="attendance"></div>
			</div>
		</div>
	</div>
	<?php
	}
	?>
</div>

</div>


    <!-- notifications -->
 <?php include 'includes/notifications.php' ?>

        </div>
    </div>

	<div class="sidebar-overlay" data-reff=""></div>

	
	<?php include 'includes/scripts.php' ?>
	<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

	<script src="js/apexchart.js"></script>


 

</body>

<script>
$(document).ready(function(){
	
	no_of_examiners();
	no_of_schools();
	no_of_scripts();
	missing_marks();
	no_of_entered_marks();
	no_of_improvised();
	statistics();

	// setInterval(no_of_examiners,500);
	// setInterval(no_of_schools,500);
	// setInterval(no_of_scripts,500);
	// setInterval(missing_marks,500);
	// setInterval(no_of_entered_marks,500);
	// setInterval(no_of_improvised,500);

	function no_of_examiners(){
	$.ajax({
		url: 'dashboard/examiner_number.php',
		method: 'POST',
		dataType: 'json',
		beforeSend: function(){
			$('.examiner_number').html('<img src="images/loading.gif" style="transform:scale(.7) translateY(-100%) translateX(-50%);left:50%;position:absolute;"/>');
			$('.examiner_number_present').html('<img src="images/loading.gif" style="transform:scale(.7) translateY(-100%) translateX(-50%);left:50%;position:absolute;"/>');
		},
		success: function(data){
		
				$('.examiner_number').text(data.no_of_examiners);
				$('.examiner_number_present').text(data.no_of_examiners_present);
	
				
		
		}
	});
}
function no_of_schools(){
	$.ajax({
		url: 'dashboard/no_of_schools.php',
		method: 'POST',
		dataType: 'json',
		beforeSend: function(){
			$('.no_of_schools').html('<img src="images/loading.gif" style="transform:scale(.7) translateY(-100%) translateX(-50%);left:50%;position:absolute;"/>');
		},
		success: function(data){
			
				$('.no_of_schools').text(data.response_msg);
			
		}
	});
}
function no_of_scripts(){
	$.ajax({
		url: 'dashboard/no_of_scripts.php',
		method: 'POST',
		dataType: 'json',
		beforeSend: function(){
			$('.no_of_scripts').html('<img src="images/loading.gif" style="transform:scale(.7) translateY(-100%) translateX(-50%);left:50%;position:absolute;"/>');
		},
		success: function(data){
		
				
					$('.no_of_scripts').text(data.response_msg);
			
			
		}
	});
}
function missing_marks(){
	$.ajax({
		url: 'dashboard/missing_marks.php',
		method: 'POST',
		dataType: 'json',
		beforeSend: function(){
			$('.missing_marks').html('<img src="images/loading.gif" style="transform:scale(.7) translateY(-100%) translateX(-50%);left:50%;position:absolute;"/>');
		},
		success: function(data){
			
					$('.missing_marks').text(data.response_msg);
			
				
		
		}
	});
}
function no_of_entered_marks(){
	$.ajax({
		url: 'dashboard/no_of_entered_marks.php',
		method: 'POST',
		dataType: 'json',
		beforeSend: function(){
			$('.no_of_entered_marks').html('<img src="images/loading.gif" style="transform:scale(.7) translateY(-100%) translateX(-50%);left:50%;position:absolute;"/>');
		},
		success: function(data){
			
					$('.no_of_entered_marks').text(data.response_msg);
			
			
		}
	});
}
function no_of_improvised(){
	$.ajax({
		url: 'dashboard/no_of_improvised.php',
		method: 'POST',
		dataType: 'json',
		beforeSend: function(){
			$('.no_of_improvised').html('<img src="images/loading.gif" style="transform:scale(.7) translateY(-100%) translateX(-50%);left:50%;position:absolute;"/>');
		},
		success: function(data){
			
					$('.no_of_improvised').text(data.response_msg);
			
			
		}
	});
}
function statistics(){
	$.ajax({
		url: 'dashboard/statistics.php',
		method: 'POST',
		dataType: 'json',
		success: function(data){
			
			
					var entered_marks = parseInt(data.no_of_entered_marks),
						missing_marks = parseInt(data.no_of_missing_marks),
						improvised_marks = parseInt(data.no_of_improvised_marks),
						total = parseInt(data.count_rows),
						calculated_entered_marks = (entered_marks / total) * 100,
						calculated_missing_marks = (missing_marks / total) * 100,
						calculated_improvised_marks = (improvised_marks / total) * 100;

				$('.progress-bar.no_of_entered_marks').attr('aria-valuenow',entered_marks).css('width',calculated_entered_marks+'%');
				$('.progress-bar.missing_marks').attr('aria-valuenow',missing_marks).css('width',calculated_missing_marks+'%');
				$('.progress-bar.no_of_improvised').attr('aria-valuenow',improvised_marks).css('width',calculated_improvised_marks+'%');
			
			
			
		}
	});
}
});
</script>
<?php
}else{
	header('location: ../php/logout.php');
}
?>


</html>