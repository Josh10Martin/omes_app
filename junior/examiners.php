<?php
session_start();

?>

<!DOCTYPE html>
<html lang="en">



<?php include 'includes/header.php'?>
<?php
if($_SESSION['user_type']  == 'ADMIN' || $_SESSION['user_type']  == 'ECZ' || $_SESSION['user_type'] == 'DEO'){
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
            <div class="content">
            <div class="row">
                    <div class="col-sm-4 col-3">
                        <h4 class="page-title">Examiners</h4>
                    </div>
		    <?php
			if($_SESSION['user_type'] == 'ADMIN' || $_SESSION['user_type'] == 'DEO'){
		    ?>
                    <div class="col-sm-8 col-9 text-right m-b-20">
					<a class="btn btn-white"  href="add-examiners.php"><i class="fa fa-plus green-ecz" aria-hidden="true"></i> Add Examiner</a>
					<div class="clearfix"></div>
					<span class="btn btn-light" style="justify-content:center;">OR</span>
                   
					<form class="width:10%;" id="upload_examiners"  enctype="multipart/form-data" >
					<p>Upload examiners</p>	
					<input type="file" name="upload" id="upload" accept=".csv"  id="formFileSm">
						
						<button type="submit" class="btn btn-primary"><i class="fa fa-cloud-upload" aria-hidden="true"></i></button>
						<img class="loading" src="../images/loading.gif" style="transform: translateX(100%); display:none;"/>
					</form>
					<a href="documents/examiners_template.csv" download>Download template</a>
                    </div>
		    <?php
			}
		    ?>
			<span class="red">Key: red background needs action.</span>
                </div>
<div class="row justify-content-between p-2">
	<div class="col-md-3">
		<input type="text" id="search" placeholder="Search" class="form-control">
	</div>
	<div class="col-md-6">
	<div class="row align-items-center">
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
			</div>
	</div>
</div>
			
			<br>
                <div class="row">
					<div class="col-md-12">
						<div class="table-responsive">
							<!-- <?php //echo $_SESSION['province_code'] ?> <br /> -->
							<!-- <?php //echo $_SESSION['marking_centre_code'] ?> <br /> -->
							<!-- <?php //echo $_SESSION['session_type'] ?> <br /> -->
							<div class="dialog"></div>
							<div class="dialog0"></div>
							<table class="table table-border table-striped custom-table mb-0">
								<thead>
									<tr>
										<th>NRC Number</th>
										<th>Surname</th>
										<th>Othername(s)</th>
										<th>Phone</th>
										<th>Subject</th>
										<th>Paper No.</th>
										<th>Belt</th>
										<th>Role</th>
										<?php if($_SESSION['user_type'] != 'ECZ' ){  ?>
										<th class="text-right">Action</th>
										<?php } ?>
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
									<input type="text" name="marking_centre" id="" value="<?php echo $_SESSION['marking_centre']; ?>" disabled>
								</div>
								<div class="col-md-4">
									
									<label for=""> Subject</label>
									<select name="subjects" class="form-control " id="">
										<option value="" >select marking centre</option>
									</select>
								</div>
								<div class="col-md-4">
									<label for=""> Paper</label>
									<select name="paper_code" class="form-control " id="">
										<option value="1">1</option>
									</select>
								</div>
								
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
 
	<div class="sidebar-overlay" data-reff=""></div>

	
	<?php include 'includes/scripts.php' ?>
    <script src="../assets/js/jquery.dataTables.min.js"></script>
    <script src="../assets/js/dataTables.bootstrap4.min.js"></script>
   
 

</body>
<script>
$(document).ready(function(){

$('#beltFilter').mask('000');


	get_paper();
	get_subjects();
	view_all_examinerss();
	view_examiners_per_subject();
	upload_examiners();

	$('.dialog').dialog({
        title: 'REQUEST RESPONSE',
        width: '450',
        height: '150',
        modal: true,
        draggable: false,
        resizable: false,
        closeOnEscape: false,
        // appendTo: '#add-admin',
        autoOpen: false,
        create: function(e){
            $(e.target).parent().css({
                'position':'fixed'
            }); 
            
        },
        buttons: [
            {
                text: 'NO',
                click: function(){
                    $(this).dialog('close');
                }
            },
            {
                text: 'YES',
                click: function(){
                    var id = $('.dialog').data('id');
                    delete_examiner(id);
                    $(this).dialog('close');
                }
            }
        ]
    });
	$('.dialog0').dialog({
        title: 'REQUEST RESPONSE',
        width: '450',
        height: '150',
        modal: true,
        draggable: false,
        resizable: false,
        closeOnEscape: false,
        // appendTo: '#add-admin',
        autoOpen: false,
        create: function(e){
            $(e.target).parent().css({
                'position':'fixed'
            }); 
            
        },
        buttons: [
            {
                text: 'OK',
                click: function(){
                    $(this).dialog('close');
		    location.reload();
                }
            },
        //     {
        //         text: 'YES',
        //         click: function(){
        //             var id = $('.dialog').data('id');
        //             delete_examiner(id);
        //             $(this).dialog('close');
        //         }
        //     }
        ]
    });
    function get_subjects(){
	$.ajax({
          url: 'php/get_subject.php',
          method: 'POST',
          dataType: 'json',
          success:function(data){
			$('select[name=subject] option').remove();
              $('select[name=subject]').append(
                '<option selected disabled>Select Subject</option>'+
                '<option value="all">All examiners</option>'
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
	function upload_examiners(){
		$('#upload_examiners').submit(function(e){
			e.preventDefault();
			$.ajax({
				url: 'php/upload_examiners.php',
				method: 'POST',
				data: new FormData(this),
				dataType: 'json',
				processData: false,
				contentType: false,
				cache: false,
				beforeSend:function(){
					$('button').attr('disabled',true).addClass('bg_att');
                    $('img.loading').css('display','block');
				},
				success:function(data){
					$('button').attr('disabled',false).removeClass('bg_att');
                    $('img.loading').css('display','none');
					if(data.status == '200'){
						$('.dialog0').text(data.response_msg).dialog('open');
					}else{
						$('.dialog0').text(data.response_msg).dialog('open');
					}
				}
			});
		});
	}
function view_all_examinerss(){
	$('select[name=paper]').attr('disabled',true);
	$('select[name=belt_no]').attr('disabled',true);
	
	$.ajax({
		url: 'php/get_examiners.php',
		method: 'POST',
		dataType: 'json',
		success: function(data){
			$('table.table tbody tr').remove();
			if(data.status== '400'){
				$('table.table tbody').append('<tr class="null">'+
				'<td colspan="8">No examiner added</td>'+
				
				'</tr>');
			}else{
				examiner_data(data);
				
			}
			delete_press();	
		}
	});

}
function view_examiners_per_subject(){
	
	$('select[name=subject]').change(function(){
		$('select[name=belt_no] option[value=all]').change();
		
		var subject = $(this).val();
		if(subject == 'all'){
			view_all_examinerss();
			
			$('select[name=belt_no]').attr('disabled',true);
		}else{
			// $('table.table tbody tr').remove();
			$.ajax({
			url: 'php/get_paper.php',
			method: 'POST',
			data:{subject_code:subject},
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
			$('table.table tbody tr').remove();
			}
			});
			examiners_per_subject_and_paper(subject);
		}
	});
	

}
	function examiners_per_subject_and_paper(subject){
		$('select[name=paper]').attr('disabled',false).change(function(){
			$('select[name=belt_no]').attr('disabled',false);
			$('select[name=belt_no] option[value=all]').change();
				var paper = $(this).val();
				$.ajax({
					url: 'php/get_examiners.php',
					method: 'POST',
					data: {subject_code:subject,paper:paper},
					dataType: 'json',
					success: function(data){
						$('table.table tbody tr').remove();
						if(data.status== '400'){
						$('table.table tbody').append('<tr class="null">'+
						'<td colspan="8">No examiner added</td>'+
						
						'</tr>');
					}else{
						examiner_data(data);
					}
						delete_press();
					}
				});
				examiners_per_belt(subject,paper);
				get_belt(subject,paper);
			});
	}
	function get_belt(subject_code,paper){
		$.ajax({
			url: 'php/get_belt.php',
			method: 'POST',
			data: {subject_code:subject_code,paper:paper},
			dataType: 'json',
			success:function(data){
				$('select[name=belt_no] option').remove();
				if(data.status == '200'){
					$('select[name=belt_no]').append(
					'<option value="all">All</option>'
				);
					$.each(data,function(){
						$('select[name=belt_no]').append(
					'<option value="'+this["belt_no"]+'">'+this["belt_no"]+'</option>'
				);
					});

					$('select[name=belt_no] option[value=undefined]').remove();
				}
			}
		});
	}
	function examiners_per_belt(subject,paper){
		$('select[name=belt_no]').change(function(){
			var belt_no = $(this).val();
			    if(belt_no == 'all'){
				$.ajax({
					url: 'php/get_examiners.php',
					method: 'POST',
					data: {subject_code:subject,paper:paper},
					dataType: 'json',
					success: function(data){
						$('table.table tbody tr').remove();
						if(data.status== '400'){
						$('table.table tbody').append('<tr class="null">'+
						'<td colspan="8">No examiner added</td>'+
						
						'</tr>');
					}else{
						examiner_data(data);
					}
						delete_press();
					}
				});
			}else{
				$.ajax({
					url: 'php/get_examiners.php',
					method: 'POST',
					data: {subject_code:subject,paper:paper,belt_no:belt_no},
					dataType: 'json',
					success: function(data){
						$('table.table tbody tr').remove();
						if(data.status== '400'){
						$('table.table tbody').append('<tr class="null">'+
						'<td colspan="8">No examiner added</td>'+
						
						'</tr>');
					}else{
						examiner_data(data);
					}
						delete_press();
					}
				});
			}
		});
	}

function examiner_data(data){
	$.each(data,function(){
		var red = this["branch_id"] == '' ? 'lightcoral' : '';
		$('table.table tbody').append('<tr class="'+this["id"]+'" style="background-color:'+red+'">'+
		'<td>'+this["nrc"]+'</td>'+
		'<td>'+this["last_name"]+'</td>'+
		'<td>'+this["first_name"]+'</td>'+
		'<td>'+this["phone"]+'</td>'+
		'<td>'+this["subject_name"]+'</td>'+
		'<td>'+this["paper_no"]+'</td>'+
		'<td>'+this["belt_no"]+'</td>'+
		'<td>'+this["role"]+'</td>'+
		<?php if($_SESSION['user_type'] != 'ECZ' ){  ?>
		'<td class="text-right">'+
			'<div class="dropdown dropdown-action">'+
				'<a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v "></i></a>'+
				'<div class="dropdown-menu dropdown-menu-right">'+
					'<a class="dropdown-item edit" id="'+this["id"]+'" href="edit-examiner.php?id='+this["id"]+'&nrc='+this["nrc"]+'"><i class="fa fa-pencil m-r-5 blue-ecz"></i> Edit</a>'+
					'<a data-id="'+this["nrc"]+'" class="dropdown-item delete" href="#" data-toggle="modal" data-target="#delete_examiner"><i class="fa fa-trash-o m-r-5 red-ecz"></i> Delete</a>'+
				'</div>'+
			'</div>'+
		'</td>'+
		<?php  }  ?>
		'</tr>');
	});
	$('table.table tbody td').parent('tr.null').remove();
	$('table.table tbody td').each(function(){
	var currentTd = $(this).html();
	if(currentTd == 'undefined'){
		$(this).parent('tr.undefined').remove();
	}
	
		
	});
}
function delete_press(){
	$('a.delete').click(function(){
	var id = $(this).data('id'),
	role = $(this).parent().parent().parent().prev().text();
	$('.dialog').text('Are you sure you want to delete '+role+'?').data('id',id).dialog('open');
});
}
function delete_examiner(id){
	$.ajax({
		url: 'php/delete_examiner.php',
		method: 'POST',
		data: {id:id},
		dataType: 'json',
		success: function(data){
			if(data.status == '400'){
				$('.dialog0').text(data.response_msg).dialog('open');
			}else{
				$("table.table tbody tr."+id).remove();
			}
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
	'<option value="" disabled>Select Paper Number</option>'
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

<?php
}else{

loheader('location: ../');
}
?>
</html>