<?php
session_start();

?>

<!DOCTYPE html>
<html lang="en">



<?php include 'includes/header.php'?>
<?php
if($_SESSION['user_type']  == 'ADMIN' || $_SESSION['user_type']  == 'ECZ' || $_SESSION['user_type']  == 'DEO'){
?>
<body>
	<style>
		.form-control {
			height: calc(1.95rem + 2px);
		   }
		   .select{
			   height: calc(1.95rem + 2px) !important;
		   }

		   label {
			display: inline-block;
			margin-bottom: 0.1rem;
		}
	</style>
    <div class="main-wrapper">

<?php include 'includes/navbar.php'?>     

<?php include 'includes/sidebar.php'?>

        <div class="page-wrapper">


			<div class="content p-5 " id="parameters">
                <div class="items p-3 ">
                    <div class="row justify-content-center">
                        <div class="col-md-9 alert alert-info">
                            <h3 class="text-center">Please select missing mark search parameters</h3> 
                        </div>
                        
                    </div>
                    <div class="dialog"></div>
                    
                    <form action="" method="post" id="parameters-form">
                    <div class="row justify-content-center align-items-center p-2">
                        
                        <div class="col-md-4 col-sm-6">
                            <label class="font-weight-bold" for="">Start Centre:</label>
                            <select name="start_centre" class="select" id="" required>
                            </select>
                        </div>
                        <div class="col-md-4 col-sm-6">
                            <label class="font-weight-bold" for="">End Centre:</label>
                            <select name="end_centre" class="select" id="" required>
                            </select>
                        </div>
                    </div>
                    <div class="row justify-content-center p-2">
                        <div class="col-md-6 col-sm-12">
                            <label class="font-weight-bold" for="">Select Subject:</label>
                            <select name="subject" class="select" id="" required>
                            </select>
                        </div>
                        <!-- <div class="col-md-4 col-sm-6">
                            <label class="font-weight-bold" for="">Select Paper:</label>
                            <select name="paper" class="select" id="" required>
                            </select>
                        </div> -->
                        <!-- <div class="col-md-4 col-sm-6">
                            <label class="font-weight-bold" for="">Select Status:</label>
                            <select name="status" class="select" id="" required>
                                <option value="" selected>Select Status</option>
                                <option value="L">Missing (L)</option>
                                <option value="X">  Absent (X)</option>
                                <option value="-">  Entered Mark (-)</option>
                            </select>
                        </div> -->
                        <!-- <div class="col-md-4 col-sm-6">
                            <label class="font-weight-bold" for="">Candidate Type:</label>
                            <select name="candidate_type" class="select" id="" required>
                            <option value="0">MAIN STREAM </option>
                                <option value="1">SEN</option>
                            </select>
                        </div> -->
                       
                    </div>
                    <div class="buttons p-3">
                        <button type="submit" id="btn-submit" class="btn btn-success d-block ml-auto mr-auto">Submit</button>
						<div class="load"></div>
                    </div>
                    
                    
                </form>
                </div>
                </div>




            <div class="content d-none pt-2" id="result">
            <div class="row">
                    <div class="col-sm-5 col-5">
                        <h4 class="page-title">MISSING MARKS REPORT</h4>
                    </div>
                    <!-- <div class="col-sm-8 col-9 text-right m-b-20">
					            <a class="btn btn-white"  href="add-examiners.php"><i class="fa fa-plus green-ecz" aria-hidden="true"></i> Add Examiner</a>
                    </div> -->
                </div>
<div class="row justify-content-between p-2">
	<div class="col-md-2">
		<input type="text" id="search" placeholder="Search" class="form-control">
	</div>
	<div class="col-md-6">
	<!-- <div class="row align-items-center">
		<div class="col-sm-1 ">
			<span class="font-weight-bold  ">Filter</span>
		</div>
				<div class="col-md-4">
					<select name="subject" id="" class="select">
					</select>
				</div>
				<div class="col-md-4">
					<select name="paper" class="select">
					</select>
				</div>
				<div class="col-md-3">
					<span class="d-flex align-items-center">
					<div>Belt:</div>
					<select name="belt_no" class="select" required>
					</select>
					</span>
				</div>
			</div> -->
	</div>
    
    <div class="col-md-4">
        <div class="d-flex justify-content-between align-items-center ">
            <div class="col-xs-4 px-0 align-items-center">EXPORT</div>
            <div class="col-xs-4 px-1 align-items-center "><a href="javascript:void(0)" id="pdf-btn">PDF <i class="fa fa-file-pdf-o red-ecz" aria-hidden="true"></i></a> </div>
            <!-- <div class="col-xs-4 px-1 align-items-center"><a href="">CSV <i class="fa fa-file-excel-o green-ecz" aria-hidden="true"></i></a> </div> -->
        </div>
    </div>

</div>
			
			<br>
                <div class="row">
					<div class="col-md-12">
						<div class="table-responsive">
							<div class="dialog"></div>
							<div class="dialog0"></div>
							<table class="table table-border table-striped custom-table mb-0" id="missing-marks-table">
								<thead>
									<tr>
										<th>EXAM NO</th>
										<th>SURNAME</th>
										<th>FIRST NAME</th>
										<th>CENTRE CODE</th>
										<th>STATUS</th>
										<th>COMMENT</th>
									</tr>
								</thead>
								<tbody>
									
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
       
         <div id="edit_examiner" class="modal fade delete-modal" role="dialog">
			<div class="modal-dialog modal-lg ">
				<div class="modal-content">
					<div class="modal-header by-primary p-2">
						<h4 class="modal-title" >Update Details</h4> 
					</div>
					<form action="" method="post">
						<div class="modal-body ">
							<div class="row">
								<div class="col-md-4">
									<label for="">First Name</label>
									<input type="text" name="first_name" class="form-control" oninput="this.value = this.value.toUpperCase()">
								</div>
								<div class="col-md-4">
									<label for="">Last Name</label>
									<input type="text" name="last_name" class="form-control" oninput="this.value = this.value.toUpperCase()">
								</div>
								<div class="col-md-2">
									<label for="">Title</label>
									<select class="select" name="title">
										<option disabled>Select Title</option>
										<option value="MR">MR</option>
										<option value="MRS">MRS</option>
										<option value="MISS">MSS</option>
										<option value="DR">DR</option>
										<option value="PROFF">PROFF</option>
										<option value="HON">HON</option>
										<option value="PR">PR</option>
									</select>
								</div>
								<div class="col-md-2">
									<label for=""> Role</label>
									<select name="role" class="form-control" required>
										
									</select>
								</div>
							</div>
							<hr>
							<div class="row">
								<div class="col-md-4">
									<label for="">Email</label>
									<input type="email" name="email" class="form-control" >
								</div>
								<div class="col-md-2">
									<label for="">NRC</label>
									<input type="text" name="nrc" class="form-control" readonly>
								</div>
								<div class="col-md-2">
									<label for=""> Phone</label>
									<input type="text" name="phone" class="form-control" >
								</div>
								<div class="col-md-4">
									<label for="">Address</label>
									<textarea rows="2" cols="12" class="form-control" placeholder="Enter Address" name="address" ></textarea>
								</div>
								
							</div>
							<hr>
							<div class="row">
								<div class="col-md-4">
									<label for="">Marking Centre</label>
									<input type="text" name="marking_centre" id="" value="<?php echo $_SESSION['marking_centre_name']; ?>" disabled>
								</div>
								<div class="col-md-4">
									
									<label for=""> Subject</label>
									<select name="subjects" class="form-control " id="">
										<option value="" >select marking centre</option>
									</select>
								</div>
								<!-- <div class="col-md-4">
									<label for=""> Paper</label>
									<select name="paper_code" class="form-control " id="">
										<option value="1">1</option>
									</select>
								</div> -->
								
							</div>
							<hr>
							<div class="row">
								<div class="col-md-4">
									<label for=""> Bank</label>
									<select name="bank" class="form-control " id="">
										<option value="" >select  bank</option>
									</select>
								</div>
								<div class="col-md-4">
									
									<label for=""> Branch</label>
									<select name="branch" class="form-control " id="">
									</select>
								</div>
								<div class="col-md-2">
									<label for="">Acc.#</label>
									<input type="text" name="account_no" class="form-control" >
								</div>
								<div class="col-md-2">
									<label for="">T-PIN</label>
									<input type="text" name="tpin" class="form-control" >
								</div>
							</div>
							<hr>
							
								<div class="col-md-2">
									<label for=""> Belt #</label>
									<input type="number" name="belt_no" class="form-control" >
								</div>
								<div class="col-md-2">
									<label for="">Attendance</label>
									<select class="select" name="attendance" required>
                             
                              
			     						</select>
								</div>
								<div class="col-md-2">
									<label for="">N0. Days</label>
									<input type="number" name="no_of_days" class="form-control" >
								</div>
							</div>
							<div class="m-t-20 row justify-content-between p-3"> 
								
								<button type="submit" class="btn btn-primary col-auto">Save</button>
								<a href="javascript:void(0)" class="btn btn-white col-auto" data-dismiss="modal">Close</a>
							</div>
						</div>
					</form>
					

				</div>
			</div>
		</div>
    </div> 
    <!-- Missing Marks -->
<div class="modal fade" id="missing_marks_modal" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  
  <div class="dialog"></div>

  <div class="modal-dialog modal-dialog-centered" role="document">
  <form action="reports/missing_marks.php" target="_blank" method="post" style="width:100%;">
    <div class="modal-content">
      <div class="modal-header bg-success p-1 d-flex justify-content-center">
        <div class="modal-title h4 text-white text-center " id="exampleModalLongTitle">Missing Marks Report</div>
      </div>
      <div class="modal-body">
        
      <div class="row">
          
          <div class="col-md-6">
            <p>Start centre
            <select name="start_centre" class="select" id="start_center" required>
            </select>
            </p>
          </div>
          <div class="col-md-6">
            <p>End centre
            <select name="end_centre" class="select" id="end_center" required>
            </select>
            </p>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <p>Subject
            <select name="subject" class="select" id="Subject" required>
              <option value="" selected> Select Subject</option>
              <option value="0">sub 1</option>
            </select>
            </p>
          </div>

         
        </div>
        
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary mr-auto" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary"><i class="fa fa-cloud-download" aria-hidden="true"></i> GENERATE</button>
      </div>
    </div>

  </form>
  </div>
</div>
 
	<div class="sidebar-overlay" data-reff=""></div>

	
	<?php include 'includes/scripts.php' ?>
    <script src="../assets/js/jquery.dataTables.min.js"></script>
    <script src="../assets/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.0.10/jspdf.plugin.autotable.min.js"></script>
   
 

</body>
<script>
$(document).ready(function(){
	get_schools_in_marking_centre();
	get_subjects();
	get_paper();
	missing_mark_list();

	function missing_mark_list(){
		$('#parameters-form').submit(function(e){
			e.preventDefault();
			$.ajax({
				url: 'php/get_missing_marks.php',
				method: 'POST',
				data: $('#parameters-form').serialize(),
				dataType: 'json',
				beforeSend: function(){
                    $('buton[type=submit]').attr('disabled',true).html('<img src="../images/loading.gif" style="transform:scale(.3);" />');
					$('.load').html('<img src="../images/loading.gif" style="transform:scale(.7) translateY(-100%) translateX(-50%);left:50%;position:absolute;"/>');                    // $('.school_name').html('<img src="../images/loading.gif" style="transform:scale(.3);" />');
                    },
					success:function(data){
						$.each(data,function(){
							$('table.table tbody').append('<tr class="'+this["exam_no"]+'">'+
							'<td>'+this["exam_no"]+'</td>'+
							'<td>'+this["last_name"]+'</td>'+
							'<td>'+this["first_name"]+'</td>'+
							'<td>'+this["centre_code"]+'</td>'+
							'<td>'+this["status"]+'</td>'+
							'<td></td>'+
						'</tr>');
						});
						$('table.table tbody tr.undefined').remove();
						$('buton[type=submit]').attr('disabled',false).text('Submit');
                    
						$('#parameters').addClass('d-none');
						$('#result').removeClass('d-none');
					}
			});
			

		});
	}
	function get_schools_in_marking_centre(){
    $.ajax({
      url: 'php/get_schools_in_marking_centre.php',
      method: 'POST',
      dataType: 'json',
      success: function(data){
        $('select[name=start_centre] option').remove();
        $('select[name=end_centre] option').remove();

        $('select[name=start_centre]').append(
            '<option value="" selected >Select start centre</option>'
          );
          $('select[name=end_centre]').append(
            '<option value="" selected disabled>Select end centre</option>'
          );
        $.each(data,function(){
          $('select[name=start_centre]').append(
            '<option value="'+this["centre_code"]+'">'+this["centre_code"]+' - '+this["centre_name"]+'</option>'
          );
          $('select[name=end_centre]').append(
            '<option value="'+this["centre_code"]+'">'+this["centre_code"]+' - '+this["centre_name"]+'</option>'
          );
          $('select[name=centre_code]').append(
            '<option value="'+this["centre_code"]+'">'+this["centre_code"]+' - '+this["centre_name"]+'</option>'
          );
        });
        $('select[name=start_centre]').select2({
          data:data
        });
        $('select[name=end_centre]').select2({
          data:data
        });
        $('select[name=centre_code]').select2({
          data:data
        });
        $('select[name=start_centre] option[value=undefined]').remove();
        $('select[name=end_centre] option[value=undefined]').remove();
        $('select[name=centre_code] option[value=undefined]').remove();
        

      }
    });
    
  }
  function get_subjects(){
    $.ajax({
          url: 'php/get_subject.php',
          method: 'POST',
          dataType: 'json',
          success:function(data){
            $('select[name=subject] option').remove();
              $('select[name=subject]').append(
                '<option selected disabled>Select Subject</option>'
              );
              $.each(data,function(){
                $('select[name=subject]').append(
                '<option value="'+this["subject_code"]+'">'+this["subject_code"]+' - '+this["subject_name"]+'</option>'
              );
              });
              $('select[name=subject]').select2({
                data:data
              });
          }
        });
  }
  function get_paper(){
    $('select[name=subject]').change(function(){
          var subject_code = $(this).val();
          $.ajax({
            url: 'php/get_paper.php',
            method: 'POST',
            data:{subject_code:subject_code},
            dataType: 'json',
            success:function(data){
              $('select[name=paper] option').remove();
              $('select[name=paper]').append(
                '<option value="" selected disabled>Select Paper Number</option>'
              );
              $.each(data,function(){
                $('select[name=paper]').append(
                '<option value="'+this["paper_no"]+'">'+this["paper_no"]+'</option>'
              );
              });
            }
          });
        
        });
  }
});
</script>
<script>
  $("#pdf-btn").click(function(){
    var doc = new jsPDF()
    
    doc.autoTable({ 
          html: '#missing-marks-table' ,
          margin: { top: 50 },
          fillColor:  [255, 255, 255],
          headStyles:{fillColor: [255, 255, 255],textColor:[0,0,0]},
          //columnStyles: { 0: { align: 'center', maxWidth: 20, fillColor: [255, 255, 255] } },
          didDrawPage: function (data) {
           var headerImg = new Image();
       
           headerImg.src = '../assets/img/eczlogo_tr_sm.jpg'; 
          //  signature.src = 'static/sign/signature.png';
          doc.setFontSize(13);
          doc.text('EXAMINATIONS COUNCIL OF ZAMBIA', 67,35);
          doc.text('MISSING MARKS REPORT', 80,40);
          //doc.addImage(img, 'PNG', logoX, logoY, logoWidth, logoHeight);
          doc.addImage(headerImg, 'JPEG', 100, 10, 20, 20);


          // Footer
            var str = "Page " + doc.internal.getNumberOfPages();
              
              doc.setFontSize(10);
          
              // jsPDF 1.4+ uses getWidth, <1.4 uses .width
              var pageSize = doc.internal.pageSize;
              var pageHeight = pageSize.height
                ? pageSize.height
                : pageSize.getHeight();
              doc.text(str, data.settings.margin.left, pageHeight - 10);
          
          }
          })

          doc.save('MISSING MARKS REPORT.pdf');
        });
        
  
  
   
        

</script>

<?php
}else{

loheader('location: ../');
}
?>
</html>