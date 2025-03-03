<?php
session_start();

?>


<!DOCTYPE html>
<html lang="en">



<?php include 'includes/header.php';
if($_SESSION['user_type']  == 'ADMIN'){
	

	?>

<body>
    <div class="main-wrapper">

<?php include 'includes/navbar.php'?>     

<?php include 'includes/sidebar.php'?>

        <div class="page-wrapper">
            <div class="content">
            <div class="row">
                    <div class="col-md-12">
						<!-- <?php
						echo $_SESSION['marking_centre_code'];
						?> -->
                        <h4 class="page-title">Belted Examiners</h4>
                    </div>
                </div>
				<div class="row justify-content-between">
					<div class="col-md-3">
						<input type="text" placeholder="Search" class="form-control" id="search">
					</div>
					<div class="col-md-6">
					<div class="row">
						<div class="col-auto">
						<i class="fa fa-filter" style="font-size: 30px;" aria-hidden="true"></i>
						</div>

						<div class="col-md-6">
							<select name="course_group" id="" class="select">
							</select>
						</div>
						
						<div class="col-md-4">
							<select name="belt_no" class="select" required>
							</select>
						</div>
					</div>

					</div>
					
				</div>

                <div class="row mt-1">
					<div class="col-md-12">
						<div class="table-responsive">
							<div class="dialog"></div>
							<div class="dialog1"></div>
							<table class="table table-border table-striped custom-table ">
								<thead>
									<tr>
										<th>Examiner Number</th>
										<th>nrc</th>
										<th>Surname</th>
										<th>Othername(s)</th>
										<th>Belt No.</th>
										<th >Action</th>
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
   
 

</body>
<script>
$(document).ready(function(){
	get_course_group();
	// get_paper();
	

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
        //     {
        //         text: 'NO',
        //         click: function(){
        //             $(this).dialog('close');
        //         }
        //     },
            {
                text: 'OK',
                click: function(){
			location.reload();
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
		var id = $('.dialog1').data('id');
		remove_belted_examiner(id);
                    $(this).dialog('close');
                }
            }
        ]
    });

    function get_course_group(){
	$.ajax({
          url: 'php/get_course_group.php',
          method: 'POST',
          dataType: 'json',
          success:function(data){
			$('select[name=course_group] option').remove();
              $('select[name=course_group]').append(
                '<option selected disabled>Select Course Group</option>'
              );
              $.each(data,function(){
                $('select[name=course_group]').append(
                '<option value="'+this["group_code"]+'">'+this["group_code"]+' - '+this["group_name"]+'</option>'
              );
		  
              });
	      $('select[name=course_group]').select2({
		data:data
	      });
		get_belt();
          }
        });
    }

    
//     function get_subjects(){
// 	$.ajax({
//           url: 'php/get_subject.php',
//           method: 'POST',
//           dataType: 'json',
//           success:function(data){
// 			$('select[name=subject] option').remove();
//               $('select[name=subject]').append(
//                 '<option selected disabled>Select Subject</option>'
//               );
//               $.each(data,function(){
//                 $('select[name=subject]').append(
//                 '<option value="'+this["subject_code"]+'">'+this["subject_code"]+' - '+this["subject_name"]+'</option>'
//               );
//               });
// 	      $('select[name=subject]').select2({
// 		data:data
// 	      });
//           }
//         });
//     }

//     function get_paper(){
	
// 	$('select[name=subject]').change(function(){
		
// 		var subject = $(this).val();
		
// 		// $('table.table tbody tr').remove();
// 		$.ajax({
// 		url: 'php/get_paper.php',
// 		method: 'POST',
// 		data:{subject_code:subject},
// 		dataType: 'json',
// 		success:function(data){
		
// 		$('select[name=paper] option').remove();
// 		$('select[name=paper]').append(
// 			'<option value="" selected disabled>Select Paper Number</option>'
// 		);
// 		$.each(data,function(){
// 			$('select[name=paper]').append(
// 			'<option value="'+this["paper_no"]+'">'+this["paper_no"]+'</option>'
// 		);
// 		});
// 		get_belt(subject);
// 		$('table.table tbody tr').remove();
// 		$('select[name=belt_no] option[value=""]').change();
// 		}
// 		});
		
		
// 	});
// }

function get_belt(){
	$('select[name=course_group]').change(function(){

		var course_group = $(this).val();
		$.ajax({
			url: 'php/get_belt.php',
			method: 'POST',
			data: {course_group:course_group},
			dataType: 'json',
			success:function(data){
				$('select[name=belt_no] option').remove();
				if(data.status == '200'){
					$('select[name=belt_no]').append(
					'<option value="" disabled selected>Select belt number</option>'
				);
					$.each(data,function(){
						$('select[name=belt_no]').append(
					'<option value="'+this["belt_no"]+'">'+this["belt_no"]+'</option>'
				);
					});
					get_belted_examiner(course_group);

					$('select[name=belt_no] option[value=undefined]').remove();
				}
			}
		});

	});
}

function get_belted_examiner(course_group){
	$('select[name=belt_no]').change(function(){
		var belt_no = $(this).val();
		$.ajax({
			url: 'php/get_belted_examiners.php',
			method: 'POST',
			data: {course_group:course_group,belt_no:belt_no},
			dataType: 'json',
			success: function(data){
				$('table.table tbody tr').remove();
				if(data.status== '400'){
					$('table.table tbody tr').remove();
			}else{
				examiner_data(data);
			}
				
			}
		});
	});
}
function examiner_data(data){
	$.each(data,function(){
		$('table.table tbody').append('<tr class="'+this["id"]+'">'+
		'<td>'+this["examiner_number"]+'</td>'+
		'<td>'+this["nrc"]+'</td>'+
		'<td>'+this["last_name"]+'</td>'+
		'<td>'+this["first_name"]+'</td>'+
		'<td>'+this["belt_no"]+'</td>'+
		'<td>'+
		'<button data-id="'+this["id"]+'" class="btn btn-sm btn-outline-warning remove">Remove</button>'+
		'</td>'+
		'</tr>');
	});
	
	$('table.table tbody td').parent('tr.null').remove();
	$('table.table tbody td').each(function(){
	var currentTd = $(this).html();
	if(currentTd == 'undefined'){
		$(this).parent('tr.undefined').remove();
	}
	$('.remove').click(function(){
		var id = $(this).data('id');
		$('.dialog1').text('Remove examiner ?').data('id',id).dialog('open');
	});
		
	});
}
function remove_belted_examiner(id){
	$.ajax({
		url: 'php/remove_belted_examiner.php',
		method: 'POST',
		data: {id:id},
		dataType: 'json',
		success: function(data){
			if(data.status == '200'){
				$('table.table tbody tr.'+data.id).remove();
			}else{
				$('.dialog').text(data.response_msg).dialog('open');
			}
		}
	});
}
});
</script>
<?php
}else{
	header('location: ../');
}
?>


</html>

<!-- 
$.toast({
    heading: 'Positioning',
    text: 'Use the predefined ones, or specify a custom position object.',
    position: 'top-right',
    stack: false
}) 

$.toast({
    heading: 'Success',
    text: 'Here is some kind of success message with a success icon that you can notice at the left side.',
    icon: 'success'
})

$.toast({
    heading: 'Information',
    text: 'Now you can add icons to the toasts as well.',
    icon: 'info'
})


-->