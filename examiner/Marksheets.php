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
                        <h4 class="page-title">Marksheets</h4>
                    </div>
                </div>
            <div class="row">
                    <div class="col-lg-12">
						<div class="table-responsive">
                            <table class="table table-striped custom-table mb-0">
                                <thead>
                                    <tr>
                                        <th>Center Code</th>
                                        <th>Exam Number</th>
                                        <th>Other Name(s)</th>
                                        <th>Surname</th>
                                        <th>Subject Code</th>
                                        <th>Paper Number</th>
                                        <th>Absent</th>
                                        <th>Mark</th>
                                        <th>Hide</th>
                                        
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>3021</td>
                                        <td>179000220312 </td>
                                        <td>Albina</i> </td>
                                        <td> Simonis</i> </td>
                                        <td>2211 </td>
                                        <td>1 </td>
                                        <td> <input class="form-control" style="width: 1rem;" type="checkbox" name="" id=""></td>
                                        <td>
                                            <input type="text" class="form-control mark" maxlength="3" max="100" name="">
                                        </td>
                                        <td><i class="fa fa-check text-success"></i> </td>
                                    </tr>
                                    <tr>
                                        <td>2312</td>
                                        
                                        <td>179000220312 </td>
                                        <td>Christina </td>
                                        <td>Jembo </td>
                                        <td>2211 </td>
                                        <td>1 </td>
                                        <td> <input class="form-control" style="width: 1rem;" type="checkbox" name="" id=""></td>
                                        <td>
                                            <input type="text" class="form-control mark" maxlength="3" max="100" name="" id="" >
                                        </td>
                                        <td><i class="fa fa-check text-success"></i> </td>
                                    </tr>
                                    <tr>
                                        <td>2231</td>
                                        
                                        <td>179000220312 </td>
                                        <td> Feeney </td>
                                        <td>Haylie </td>
                                        <td>2211</td>
                                        <td>1 </td>
                                        <td> <input class="form-control" style="width: 1rem;" type="checkbox" name="" id=""></td>
                                        <td>
                                            <input type="text" class="form-control mark" maxlength="3" max="100" name="" id="">
                                        </td>
                                        <td><i class="fa fa-check text-success"></i> </td>
                                    </tr>
                                    <tr>
                                        <td>3022</td>
                                       <td>179000220312 </td>
                                        <td> Mericle</td>
                                        <td>Mary</i> </td>
                                        <td>2211</i> </td>
                                        <td>1 </td>
                                        <td> <input class="form-control" style="width: 1rem;" type="checkbox" name="" id=""></td>
                                        <td>
                                            <input type="text" class="form-control mark" maxlength="3" max="100" name="" id="">
                                        </td>
                                        <td><i class="fa fa-check text-success"></i> </td>
                                    </tr>
                                   
                                </tbody>
                            </table>
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