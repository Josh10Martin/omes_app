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
                    <div class="col-sm-7 col-8">
                        <h4 class="page-title">Centers in belt</h4>
                    </div>

                    <div class="col-sm-5 col-4 text-right m-b-30">
                        <div class="btn-group btn-group-sm">
                            <!-- <button class="btn btn-white">CSV</button> -->
                            <!-- <button class="btn btn-white"></button> -->
                            <a class="btn btn-white" href="#"><i class="fa fa-file-excel-o" style="color: #1d9d74;" ></i> Excel</a>
                            <!-- <a class="btn btn-white" href="../pdf_examiners.php"><i class="fa fa-file-pdf-o " style="color: #ed3237;"></i> pdf</a> -->
                            <a class="btn btn-white" href="../pdf_centers_in_belt.php"><i class="fa fa-file-pdf-o " style="color: #ed3237;"></i> pdf</a>

                        </div>
                    </div>
            
                </div>
         
                <div class="row">
                    <div class="col-md-12">
						<div class="table-responsive">
                            <table class="table table-striped custom-table">
                                <thead>
                                    <tr>
                                        <th style="min-width:20px;">Center Code</th>
                                        <th style="min-width:200px;">Center Name</th>
                                        <th>NO# Of Scripts</th>
                                        
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
											 <h2>0001</h2>
										</td>
                                        <td>LUANSHYA CENTRAL  HIGH GCE</td>
                                        <td>344</td>
                                        
                                    </tr>
                                    <tr>
                                        <td>
											<h2>0002</h2>
										</td>
                                        <td>TAUNGUP HIGH SCHOOL GCE</td>
                                        <td>711</td>
                                        
                                    </tr>
									<tr>
                                        <td>
											<h2>0003</h2>
										</td>
                                        <td>MITONDO HIGH SCHOOL GCE</td>
                                        <td>644</td>
                                        
                                    </tr>
									<tr>
                                        <td>
											<h2>0004</h2>
										</td>
                                        <td>LUANSHYA ADULT G.C.E. CENTRE</td>
                                        <td>299</td>
                                        
                                    </tr>
									<tr>
                                        <td>
											<h2>0005</h2>
										</td>
                                        <td>NKULUMASHIBA HIGH SCHOOL GCE</td>
                                        <td>433</td>
                                       
                                    </tr>
                                </tbody>
                            </table>
						</div>
                    </div>
                </div>
            </div>
                       <!-- notifications -->
                       <?php include '../includes/notifications.php' ?>
        </div>
		<div id="delete_employee" class="modal fade delete-modal" role="dialog">
			<div class="modal-dialog modal-dialog-centered">
				<div class="modal-content">
					<div class="modal-body text-center">
						<img src="assets/img/sent.png" alt="" width="50" height="46">
						<h3>Are you sure want to delete this Employee?</h3>
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
 
</body>


<!-- employees23:22-->
</html>