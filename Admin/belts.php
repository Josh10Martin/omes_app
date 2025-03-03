<!DOCTYPE html>
<html lang="en">



<?php include 'includes/header.php'?>

<body>
    <style>
       
        .table>tbody>tr.active{
            background-color: rgba(29, 157, 117, 0.26);
            border:1px solid #1d9d74;
        }
        .tableFixHead          { overflow: auto; max-height: 20rem; }
        .tableFixHead thead th { position: sticky; top: 0; z-index: 1; background-color: #1d9d74;}
       
    </style>
<div class="main-wrapper">

    <?php include 'includes/navbar.php'?>     

    <?php include 'includes/sidebar.php'?>

    <div class="page-wrapper">
            <div class="content">

            <div class="row">
                    <div class="col-sm-12">
                        <h4 class="page-title">Belt 2 Centers and scripts</h4>
                    </div>
                    
                </div>
                <div class="row p-2">
                    
                    <div class="col-lg-6 border border-dark p-2">
                    <div class="text-center">
                       <p class="h4 text-success " id="box-title"> New Apotionment</p> 
                    </div>
                    <form action="" method="post">
                    
                    <div class="row">
                        <div class="col-xs-12 col-sm-6 col-md-6">
                            <div class="form-group">
                                <label>Subject:</label>
                                <select class="select" disabled>
                                    <option>Enlish Language</option>
                                    <option value="1">Enlish Language</option>
                                    <option value="2">Mathermatics</option>
                                    <option value="3">Science</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-6">
                            <div class="form-group">
                                <label>Paper:</label>
                                <select class="select" disabled>
                                    <option>Paper 1</option>
                                    <option value="1">Paper 1</option>
                                    <option value="2">Paper 2</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row p-2">
                        <div class="col-xs-12 col-sm-6 col-md-6">
                            <div class="form-group">
                                <label >Center:</label>
                                <input type="text" id="ceter_number" required list="suggestions" class="form-control">
                                <datalist id="suggestions">
                                <optgroup>
                                    <option>2031 - ST Mary's secondary</option>
                                    <option>2132 - Kings man secondary</option>
                                    <option>2233 - Monze boys secondary</option>
                                    <option>2034 - Ancher pvt</option>
                                    <option>2035 - Makoye secondary</option>
                                    <option>2022 - St Joseph's secondary</option> 
                                    <option>2030 - St edmunds</option>
                                    <option>2130 - Kaonga secondary</option>
                                    <option>2230 - Mazabuka girls</option>
                                    <option>2032 - Nakambala pvt</option>
                                    <option>2034 - Lusaka boys</option>
                                    <option>2022 - Bayuni secondary</option> 
                                </optgroup>
                            </datalist>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-6">
                        <div class="form-group">
                                <label>NO. of Scripts:</label>
                                <input type="text" id="number_of_scripts" required class="form-control" >
                            </div>
                           
                        </div>
                    </div>
                   
                    
                    <div class="row p-2 justify-content-around">
                        <div id="updatediv" class="d-none">
                            <span class="mr-auto ml-auto">
                                <button type="submit" class="btn btn-info">UPDATE</button>
                            </span>
                            
                            <span class="mr-auto ml-auto ">
                                <button type="submit" class="btn btn-danger">DELETE</button>
                            </span>

                            <span class="mr-auto ml-auto ">
                                <!-- <button type="btn" class="btn bg-light border-secondary">CANCEL</button> -->
                                <span class="btn bg-light border-secondary" id="cancel">CANCEL</span>
                            </span>
                        </div>
                        <div id="savediv">
                            <span class="mr-auto ml-auto">
                                <button type="submit" class="btn btn-primary">SAVE</button>
                            </span>
                        </div>
                    </div>
                </form>
                    </div>
                    <div class="col-lg-6 border border-dark p-2">
                    <div class="tableFixHead table-hover">
									<table class="table mb-0" id="beltTable">
										<thead>
											<tr>
												<th>Subject</th>
												<th>Paper</th>
												<th>Belt</th>
                                                <th>Center</th>
												<th>No. Scripts</th>
											</tr>
										</thead>
										<tbody>
											<tr >
												<td>English Language</td>
												<td>1</td>
												<td>1</td>
                                                <td>3021</td>
												<td>800</td>
											</tr>
											<tr>
												<td>English Language</td>
												<td>1</td>
												<td>1</td>
                                                <td>3022</td>
												<td>150</td>
											</tr>
											<tr>
												<td>English Language</td>
												<td>1</td>
												<td>1</td>
                                                <td>3032</td>
												<td>550</td>
											</tr>
                                            <tr>
												<td>English Language</td>
												<td>1</td>
												<td>1</td>
                                                <td>3022</td>
												<td>850</td>
											</tr>
											<tr>
												<td>English Language</td>
												<td>1</td>
												<td>1</td>
                                                <td>3032</td>
												<td>950</td>
											</tr>
                                            <tr>
												<td>English Language</td>
												<td>1</td>
												<td>1</td>
                                                <td>3022</td>
												<td>190</td>
											</tr>
											<tr>
												<td>English Language</td>
												<td>1</td>
												<td>1</td>
                                                <td>3032</td>
												<td>990</td>
											</tr>
										</tbody>
									</table>
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
         $('#number_of_scripts').mask('000000');

         var activeRow= $('#beltTable tr.active')
         $('#beltTable tr').click(function(){
            // console.log("Clicked",$(this))
            // console.log("Active row",activeRow)
            activeRow.removeClass('active');
            $(this).addClass('active');
            activeRow=$(this);

            $('#updatediv').removeClass('d-none');
            $('#savediv').addClass('d-none');
            var numberOfScrips = $(this).find("td").eq(4).html()
            var center = $(this).find("td").eq(3).html()
            // console.log("Cliked Scripts:",numberOfScrips)
            // console.log("Cliked Center:",center)
            $('#number_of_scripts').val(numberOfScrips);
            $('#ceter_number').val(center);
            $('#box-title').text('Update Apportionment');
         })

         $('#cancel').click(function(){
            $('#savediv').removeClass('d-none');
            $('#updatediv').addClass('d-none');
            $('#number_of_scripts').val("");
            $('#ceter_number').val("");
            $('#box-title').text('New Apportionment');
            activeRow.removeClass('active');
         })
    })
</script>

</body>



</html>