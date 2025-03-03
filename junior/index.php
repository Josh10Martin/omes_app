<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">



<?php include 'includes/header.php';

if($_SESSION['user_type'] == 'ADMIN' || $_SESSION['user_type'] == 'ECZ' || $_SESSION['user_type'] == 'DEO' || $_SESSION['user_type'] == 'SESO'){
	include '../config.php';
	include '../functions.php';
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
<div class="row">
	<div class="col-12">
		<h4>Dashboard</h4>
	</div>
</div>

<!-- Data Entery Operator Details Form-->
<?php
	if($_SESSION['user_type'] == 'DEO' ){
		?>

<div class="dialog"></div>
<div class="dialog1"></div>
<div class="deo-dash opacity-25">
	<?php
		if(account_not_provided($db_9,'DEO',$_SESSION['username']) == 'true'){
?>

	<div class="row justify-content-center align-items-center">
		<div class="col-md-6 ">
		<div class=" opacity-100">
		<div class="card border border-primary ">
			<div class="card-header bg-light">
				DATA ENTRY OPERATOR DETAILS UPDATE
			</div>
			<div class="card-body">
			<form action="" method="" id="update_form">
			<div class="row">
				<div class="col-md-6">
					<p>NRC:
					<input type="text" maxlength="11" name="nrc" id="nrc" class="form-control" required>
					</p>
				</div>
				<div class="col-md-6">
					<p>TPIN:
					<input type="text" pattern="[0-9]+" maxlength="10" name="tpin" id="tpin" class="form-control" required>
					</p>
				</div>
				<div class="col-md-6">
					<p>PHONE NUMBER:
					<input type="text" maxlength="10" name="phone" id="phone" class="form-control" required>
					</p>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<p>BANK:
					<select name="bank" id="" class="select" required>
				
					</select>
					</p>
				</div>
				<div class="col-md-12">
					<p>BRANCH:
					<select name="branch" id="" class="select" required>
						
					</select>
					</p>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6">
					<p>ACCOUNT NUMBER:
					<input type="text" name="account_no" maxlength="15" pattern="[0-9]+" id="account_number" class="form-control" required>
					</p>
				</div>
				
			</div>
			<img class="loading" src="../images/loading.gif" style="transform: translateX(100%); display:none;"/>
			<button type="submit" class=" d-flex btn btn-sm btn-primary mx-auto">SAVE</button>
			
		</form>
			</div>
		</div>
	</div>

		</div>
	</div>
	

<?php
	}
	?>
</div>
<?php
}
?>

<!-- Admin update details form -->

<?php
	if($_SESSION['user_type'] == 'ADMIN' ){
		?>

<div class="dialog2"></div>
<div class="dialog13"></div>

	<?php
		if(account_not_provided($db_9,'ADMIN',$_SESSION['username']) == 'true'){
?>

	<div class="row justify-content-center align-items-center" style="height:100vh;position:fixed;z-index:1040;width:100%;background-color: rgba(0,0,0,0.5);top:0;left:0; ">
		<div class="col-md-6 ">
		<div class=" opacity-100">
		<div class="card border border-primary ">
			<div class="card-header bg-light">
				SYSTEM ADMIN DETAILS UPDATE
			</div>
			<div class="card-body">
			<form action="" method="" id="update_admin_form">
			<div class="row">
				<div class="col-md-6">
					<p>NRC:
					<input type="text" minlength="11" name="nrc" id="nrc" class="form-control" required>
					</p>
				</div>
				<div class="col-md-6">
					<p>TPIN:
					<input type="text" pattern="[0-9]+" maxlength="10" name="tpin" id="tpin" class="form-control" required>
					</p>
				</div>
				<div class="col-md-6">
					<p>PHONE NUMBER.:
					<input type="text" maxlength="10" name="phone" id="phone" class="form-control" required>
					</p>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<p>BANK:
					<select name="bank" id="" class="select" required>
				
					</select>
					</p>
				</div>
				<div class="col-md-12">
					<p>BRANCH:
					<select name="branch" id="" class="select" required>
						
					</select>
					</p>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6">
					<p>ACCOUNT No.:
					<!-- <input type="text" name="account_no" maxlength="15" id="account_number" class="form-control" required> -->

					<input type="text" pattern="[0-9]+" name="account_no" maxlength="15" id="account_number" class="form-control" required>

					</p>
				</div>
				
			</div>
			<img class="loading" src="../images/loading.gif" style="transform: translateX(100%); display:none;"/>
			<button type="submit" class=" d-flex btn btn-sm btn-primary mx-auto">SAVE</button>
			
		</form>
			</div>
		</div>
	</div>

		</div>
	</div>
	

<?php
	}
	
}
?>


<div class="row">
	<div class=" col-xl-5 col-lg-6">
		<div class="row">
			<?php
				if($_SESSION['user_type'] == 'ADMIN' || $_SESSION['user_type'] == 'ECZ' || $_SESSION['user_type'] == 'SESO'){

			?>
			<div class="col-md-6">
				<div class="card">
					<div class="card-body p-3">
					<div class="float-right">
					<i class="fa fa-users green-ecz widget-icon bg-green" aria-hidden="true"></i>
					</div>
					<h5 class="text-muted fw-normal mt-0" title="Number of Customers">Examiners</h5>
					<h2 class="mt-1 mb-1 examiner_number"></h2>
					<p class="mb-0 text-muted">
						
						<span class="text-nowrap">Registered</span>  
                    </p>
					</div>
				</div>
			</div>
			<?php
			}
			if($_SESSION['user_type'] == 'ECZ' || $_SESSION['user_type'] == 'SESO'){
			?>
			<div class="col-md-6">
					<div class="card">
					<div class="card-body p-3">
					<div class="float-right">
					<i class="fa fa-university blue-ecz widget-icon bg-blue" aria-hidden="true"></i>
					</div>
					<h5 class="text-muted  mt-0">Centres</h5>
					<h2 class="mt-1 mb-1 no_of_schools"></h2>
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
			if($_SESSION['user_type'] == 'ADMIN' || $_SESSION['user_type'] == 'ECZ' || $_SESSION['user_type'] == 'SESO'){
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
					<h2 class="mt-1 mb-1 no_of_scripts"></h2>
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
					<h5 class="text-muted  mt-0">Marks NOT Entered</h5>
					<h2 class="mt-1 mb-1 missing_marks"></h2>
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
	if($_SESSION['user_type'] == 'SESO' || $_SESSION['user_type'] == 'ECZ' | $_SESSION['user_type'] == 'ADMIN'){
	?>
	<div class="col-xl-7 col-lg-6">
		<div class="card">
		  <div class="d-flex card-header justify-content-between py-1">
			<h5 class="header-title">NO. of Scripts Per Subject</h5>
		  </div>
		  <div class="card-body p-1 mx-0">
			<div id="chart" class="my-0"></div>
			<div id="pagination" class="d-flex p-0 m-0 justify-content-center">
				<a href="javascript:void(0)" id="prev" onclick="previousPage()" class="px-2 btn-off"><i class="fa fa-chevron-circle-left" aria-hidden="true"></i></a>
				<a href="javascript:void(0)" id="next" onclick="nextPage()" class="px-2 "><i class="fa fa-arrow-right" ></i></a>
			</div>
		  <!-- <canvas id="linegraph" style="height: 100px;"></canvas> -->
		  </div>
		</div>
	</div>
	<?php
	}
	?>
</div>
<div class="row">
	<?php
	if($_SESSION['user_type'] == 'ADMIN' || $_SESSION['user_type'] == 'ECZ' || $_SESSION['user_type'] == 'SESO'){
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
										<div class="progress-bar no_of_entered_marks" role="progressbar" style=" height: 20px;" aria-valuenow="" aria-valuemin="0" aria-valuemax=""></div>
									</div>
								</td>
							</tr>
							<tr>
								<td>Unentered</td>
								<td class="missing_marks"></td>
								<td>
									<div class="progress" style="height: 3px;">
										<div class="progress-bar missing_marks bg-info" role="progressbar" style="height: 20px;" aria-valuenow="" aria-valuemin="0" aria-valuemax=""></div>
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
	if($_SESSION['user_type'] == 'ECZ' || $_SESSION['user_type'] == 'SESO' || $_SESSION['user_type'] == 'ADMIN'){
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

	
	<?php include 'includes/scripts.php';
	if($_SESSION['user_type'] == 'ECZ' || $_SESSION['user_type'] == 'SESO' || $_SESSION['user_type'] == 'ADMIN'){
	?>

	<script src="js/apexchart.js"></script>
	<?php
	}
	?>


 

</body>

<script>
$(document).ready(function(){
	<?PHP  
		if($_SESSION['user_type'] == 'ADMIN'){
			echo ' alert("IMPORTANT!!. DO NOT FORGET TO SUBMIT EXAMINER CLAIMS (UNDER APPORTIONMENT WHEN PANEL IS DONE) IN ADDITION TO GIVING OUT THE HARD COPY AND DO NOT FORGET TO SUBMIT YOUR CLAIM (UNDER REPORTS). SUBMIT WHEN NEEDED");';
		}ELSE{
			IF($_SESSION['user_type'] == 'DEO'){
				echo 'alert("IMPURTANT!!. DO NOT FORGET TO SUBMIT YOUR CLAIM (UNDER REPORTS) WHEN YOU ARE DONE");';
			}
		}
	?>
	$('#account_number').mask('000000000000000');
	$('#nrc').mask('000000/00/0');
	$('#phone').mask('0000000000');

	no_of_examiners();
	no_of_schools();
	no_of_scripts();
	missing_marks();
	no_of_entered_marks();
	no_of_improvised();
	statistics();

	get_bank();
	get_branch();

	nrc_helper();
	update_data_entry_bank_details();
	update_admin_bank_details();

	$('.dialog').dialog({
        title: 'REQUEST RESPONSE',
        width: '450',
        height: '150',
        modal: true,
        draggable: false,
        resizable: false,
        closeOnEscape: false,
	appendTo: '#update_form',
        autoOpen: false,
        create: function(e){
            $(e.target).parent().css({
                'position':'fixed'
            }); 
            
        },
        buttons: [
            // {
            //     text: 'login',
            //     click: function(){
            //         location.href="/orvs";
            //     }
            // },
            {
                text: 'OK',
                click: function(){
                    $(this).dialog('close');
                }
            }
        ]
    });
	$('.dialog1').dialog({
        title: 'REQUEST RESPONSE',
        width: '450',
        height: '150',
        modal: true,
        draggable: false,
        resizable: false,
        closeOnEscape: false,
	appendTo: '#update_form',
        autoOpen: false,
        create: function(e){
            $(e.target).parent().css({
                'position':'fixed'
            }); 
            
        },
        buttons: [
            // {
            //     text: 'login',
            //     click: function(){
            //         location.href="/orvs";
            //     }
            // },
            {
                text: 'OK',
                click: function(){
		location.reload();
                    $(this).dialog('close');
                }
            }
        ]
    });
    $('.dialog2').dialog({
        title: 'REQUEST RESPONSE',
        width: '450',
        height: '150',
        modal: true,
        draggable: false,
        resizable: false,
        closeOnEscape: false,
	appendTo: '#update_admin_form',
        autoOpen: false,
        create: function(e){
            $(e.target).parent().css({
                'position':'fixed'
            }); 
            
        },
        buttons: [
            // {
            //     text: 'login',
            //     click: function(){
            //         location.href="/orvs";
            //     }
            // },
            {
                text: 'OK',
                click: function(){
                    $(this).dialog('close');
                }
            }
        ]
    });
    $('.dialog3').dialog({
        title: 'REQUEST RESPONSE',
        width: '450',
        height: '150',
        modal: true,
        draggable: false,
        resizable: false,
        closeOnEscape: false,
	// appendTo: '#update_form',
        autoOpen: false,
        create: function(e){
            $(e.target).parent().css({
                'position':'fixed'
            }); 
            
        },
        buttons: [
            // {
            //     text: 'login',
            //     click: function(){
            //         location.href="/orvs";
            //     }
            // },
            {
                text: 'OK',
                click: function(){
		location.reload();
                    $(this).dialog('close');
                }
            }
        ]
    });
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
		},
		success: function(data){
		
				$('.examiner_number').text(data.response_msg);
		
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

				
    			$('.progress-bar').attr('aria-valuemax', total);

				//$('.progress-bar').attr('aria-valuemax',data.count_rows);
			
		}
	});
}
function update_data_entry_bank_details(){
        $('#update_form').submit(function(e){
		e.preventDefault();
		$.ajax({
			url: 'php/update_data_entry_bank_details.php',
			method: 'POST',
			data: $('#update_form').serialize(),
			dataType: 'json',
			beforeSend: function(){
				$('button[id=save]').attr('disabled',true).addClass('bg_att');
                		$('img.loading').css('display','block');
			},
			success: function(data){
				if(data.status == '200'){
					$('button[id=save]').attr('disabled',false).removeClass('bg_att');
                			$('img.loading').css('display','none');
					$('.dialog1').text(data.response_msg).dialog('open');
					$('#update_form').trigger('reset');
				}else{
					$('button[id=save]').attr('disabled',false).removeClass('bg_att');
                			$('img.loading').css('display','none');
					$('.dialog').text(data.response_msg).dialog('open');
				}
			}
		});
	});
}
function update_admin_bank_details(){
	$('#update_admin_form').submit(function(e){
		e.preventDefault();
		$.ajax({
			url:'php/update_admin_bank_details.php',
			method: 'POST',
			data: $('#update_admin_form').serialize(),
			dataType: 'json',
			beforeSend: function(){
				$('button[id=save]').attr('disabled',true).addClass('bg_att');
                $('img.loading').css('display','block');
			},
			success:function(data){
				if(data.status == '200'){
					$('button[id=save]').attr('disabled',false).removeClass('bg_att');
                			$('img.loading').css('display','none');
					$('.dialog3').text(data.response_msg).dialog('open');
					// $('#update_admin_form').trigger('reset');
					location.reload();
				}else{
					$('button[id=save]').attr('disabled',false).removeClass('bg_att');
                			$('img.loading').css('display','none');
					$('.dialog2').text(data.response_msg).dialog('open');
				}
			}
		});
	});
}
function get_bank(){
	$.ajax({
          url: 'php/get_bank.php',
          method: 'POST',
          dataType: 'json',
          success: function(data){
			
            $('select[name=bank]').append(
                '<option value="" selected disabled>Select Bank</option>'
              );
              $.each(data,function(){
                $('select[name=bank]').append(
                '<option value="'+this["id"]+'" >'+this["name"]+'</option>'
              );
              });
              $('select[name=bank]').select2({
              data:data
            });
          }
        });
}

function get_branch(){
	$('select[name=bank]').change(function(){
          var bank_id = $(this).val();
          $.ajax({
            url: 'php/get_branch.php',
            method: 'POST',
            data:{bank_id:bank_id},
            dataType: 'json',
            success:function(data){
              $('select[name=branch] option').remove();
              $('select[name=branch]').append(
                '<option value="" selected disabled>Select Branch</option>'
              );
              $.each(data,function(){
                $('select[name=branch]').append(
                '<option value="'+this["id"]+'">'+this["name"]+'</option>'
              );
              });
              $('select[name=branch]').select2({
              data:data
            });
            }
          });
        });
}

function nrc_helper(){
	$('input[type=text][name=nrc_number]').keyup(function(){
        
        var nrc = $(this).val();
        if(nrc.length == 6 ){
          var str = nrc+'/';
          $(this).val(str);
        }
        if(nrc.length == 9){
          var str = nrc+'/';
          $(this).val(str);
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