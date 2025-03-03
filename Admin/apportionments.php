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
                        <h4 class="page-title">Apportionments</h4>
                    </div>
                    <div class="col-sm-8 col-9 text-right m-b-20">
                        <a href="#"  data-toggle="modal" data-target="#addApportionment" class="btn btn-white"><i class="fa fa-plus"></i> Add</a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
						<div class="table-responsive">
                            <table class="table table-border table-striped custom-table mb-0">
                                <thead>
                                    <tr>
                                        <th>Belt</th>
                                        <th>Subject </th>
                                        <th>Paper </th>
                                        <th>Centers</th>
                                        <th>NO. Scripts</th>
                                        <th class="text-right">Action</th>
                                        <!--<th>Subject Code</th>
                                        <th>Paper Number</th>
                                        <th>Absent</th>
                                        <th>Mark</th>
                                        <th>Hide</th> 
                                        -->
                                        
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>English Language</td>
                                        <td>1 </td>
                                        <td>3 </a></td>
                                        <td>399</td>
                                        <td class="text-right">
											<div class="dropdown dropdown-action">
												<a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
												<div class="dropdown-menu dropdown-menu-right">
													<a class="dropdown-item table-icon" href="belts.php"><i class="fa fa-pencil m-r-5" style="color:blue"></i> Edit</a>
													<a class="dropdown-item" href="#" data-toggle="modal" data-target="#delete_examiner"><i class="fa fa-trash-o m-r-5" style="color:lightcoral"></i> Delete</a>
												</div>
											</div>
										</td>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td>Science</td>
                                        <td>2</td>
                                        <td>4 </td>
                                        <td>750</td>
                                        <td class="text-right">
											<div class="dropdown dropdown-action">
												<a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
												<div class="dropdown-menu dropdown-menu-right">
													<a class="dropdown-item table-icon" href="belts.php"><i class="fa fa-pencil m-r-5" style="color:blue"></i> Edit</a>
													<a class="dropdown-item" href="#" data-toggle="modal" data-target="#delete_examiner"><i class="fa fa-trash-o m-r-5" style="color:lightcoral"></i> Delete</a>
												</div>
											</div>
										</td>
                                    </tr>
                                   
                                </tbody>
                            </table>
						</div>
                    </div>
                </div>
            </div>


            <!-- Add Apportionment modal -->
            <div class="modal fade" id="addApportionment" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                <div class="modal-header p-2 bg-primary ">
                    <div class="modal-title text-white h5 text-center">New Apportionment</div>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                <form action="" method="post">
                    <div class="row">
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Belt:</label>
                                <input type="text" id="belt-input" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Subject:</label>
                                <select class="select">
                                    <option>Select Subject</option>
                                    <option value="1">Enlish Language</option>
                                    <option value="2">Mathermatics</option>
                                    <option value="3">Science</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Paper:</label>
                                <select class="select">
                                    <option>Select State</option>
                                    <option value="1">Paper 1</option>
                                    <option value="2">Paper 2</option>
                                </select>
                            </div>
                        </div>
                    </div>
            
                </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary mr-auto" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary float-right">Save</button>
                </div>
                </div>
            </div>
            </div>


                <?php include 'includes/notifications.php' ?>
            </div>
    </div>

            <div class="sidebar-overlay" data-reff=""></div>
</div>

	
<?php include 'includes/scripts.php' ?>
<script>
    $(document).ready(function(){
        $("#belt-input").mask('000');
    })
</script>

</body>



</html>