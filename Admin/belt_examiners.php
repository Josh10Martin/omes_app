<!DOCTYPE html>
<html lang="en">



<?php include 'includes/header.php'?>

<body>
    <div class="main-wrapper">

<?php include 'includes/navbar.php'?>     

<?php include 'includes/sidebar.php'?>

        <div class="page-wrapper">
            <div class="content">
            <div class="row">
                    <div class="col-sm-4 col-3">
                        <h4 class="page-title">Belt Examiners</h4>
                    </div>
                    <div class="col-sm-8 col-9 text-right m-b-20">
                    <!-- <button class="btn btn-white"></button> -->
                    <span class="float-right">
                        <div class="input-group input-group-sm mb-3">
                            <div class="input-group-prepend">
                              <span class="input-group-text" id="inputGroup-sizing-sm">Belt Number</span>
                            </div>
                            <input type="text" id="belt_number" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm" maxlength="3" style="width:3rem;">
                          </div>
                    </span>
                    <!-- <a href="pdf_examiners.php" class="btn btn-white"><i class="fa fa-print fa-lg"></i> pdf</a> -->
                    </div>
                </div>

                <div class="row">
					<div class="col-md-12">
						<div class="table-responsive">
							<table class="table table-border table-striped custom-table datatable mb-0">
								<thead>
									<tr>
										<th>Examiner Number</th>
										<th>Surname</th>
										<th>Othername(s)</th>
										<th>Phone</th>
										<th>Email</th>
										<th class="beltth d-none" >Action</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td>2122/100005</td>
										<td> Robinson</td>
										<td> Jennifer</td>
										<!-- <td>1545 Dorsey Ln NE, Leland, NC, 28451</td> -->
										<td>(207) 808 8863</td>
										<td>jenniferrobinson@example.com</td>
										<td class="belttd d-none">
                                            <span class="btn btn-sm btn-outline-primary ">add to belt</span>
										</td>
									</tr>
									<tr>
										<td>2122/100006</td>
										<td>Baker</td>
										<td>Terry</td>
										<!-- <td>555 Front St #APT 2H, Hempstead, NY, 11550</td> -->
										<td>(376) 150 6975</td>
										<td>ST Edmunds Secondary School</td>
										<td class="belttd d-none">
                                            <span class="btn btn-sm btn-outline-primary ">add to belt</span>
										</td>
									</tr>
									
								</tbody>
							</table>
						</div>
					</div>
                </div>

				<!-- <div class="row">
                    <div class="col-sm-12">
                        <div class="see-all">
                            <a class="see-all-btn" href="javascript:void(0);">Load More</a>
                        </div>
                    </div>
                </div> -->
            </div>


    <!-- notifications -->
 <?php include 'includes/notifications.php' ?>

        </div>
        <div id="delete_examiner" class="modal fade delete-modal" role="dialog">
			<div class="modal-dialog modal-dialog-centered">
				<div class="modal-content">
					<div class="modal-body text-center">
						<!-- <img src="assets/img/sent.png" alt="" width="50" height="46"> -->
						<h3>Are you sure want to delete this Examiner?</h3>
						<div class="m-t-20"> <a href="#" class="btn btn-white" data-dismiss="modal">Close</a>
							<button type="submit" class="btn btn-danger">Delete</button>
						</div>
					</div>
				</div>
			</div>
		</div>
    </div>

	<div class="sidebar-overlay" data-reff=""></div>

	
	<?php include 'includes/scripts.php' ?>
    <script src="../assets/js/jquery.dataTables.min.js"></script>
    <script src="../assets/js/dataTables.bootstrap4.min.js"></script>
	<script>
		$(document).ready(function(){
			$('#belt_number').mask('000')
		})
	</script>
	<script>
		$("#belt_number").keyup(function(){
			var numb=$(this).val()
			if (numb.length>0){
				console.log("number :",numb)
				$(".beltth").removeClass('d-none')
				$(".beltth").css("width","78px")
				$(".belttd").removeClass('d-none')
			}
			else{
				console.log("No value")
				if (!$(".beltth").hasClass('d-none')){
					$(".beltth").addClass('d-none')
					$(".belttd").addClass('d-none')
				}
			}
		})
	</script>
   
 

</body>



</html>