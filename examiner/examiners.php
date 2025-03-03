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
                    <div class="col-sm-4 col-3">
                        <h4 class="page-title">Examiners</h4>
                    </div>
                    <div class="col-sm-8 col-9 text-right m-b-20">
                    <!-- <button class="btn btn-white"></button> -->
                    <span class="float-right">
                        <div class="input-group input-group-sm mb-3">
                            <div class="input-group-prepend">
                              <span class="input-group-text" id="inputGroup-sizing-sm">Belt Number</span>
                            </div>
                            <input type="text" id="belt_number" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm" maxlength="3" style="width:3rem;" autocomplete="off">
                          </div>
                    </span>
                    <!-- <a href="pdf_examiners.php" class="btn btn-white"><i class="fa fa-print fa-lg"></i> pdf</a> -->
                    </div>
                </div>
		<div class="row justify-content-between">
			<div class="col-md-3">
				<input type="text" id="search" placeholder="Search" class="form-control">
			</div>
			<div class="col-md-6">
				<div class="row">
				<div class="col-auto">
				<i class="fa fa-filter" style="font-size: 30px;" aria-hidden="true"></i>
				</div>
				<div class="col-md-4">
					<select name="subject" id="" class="select">
						<option value="" selected>Subject</option>
					</select>
				</div>
				<div class="col-md-4">
					<select name="paper" class="select">
					<option value="" selected>Paper</option>
					</select>
				</div>
				</div>
			</div>
				
				
			</div>
			<br>

                <div class="row">
					<div class="col-md-12">
						<div class="cutom-head" style="max-height:calc(100vh-500px);">
						<div class="position-relative">
							<div class="dialog"></div>
							<div class="dialog1"></div>
							<?php // echo $_SESSION['marking_centre_code'] ?>
							<table class="table table-border table-striped custom-table mb-0">
								<thead>
									<tr>
										<th>Examiner No.</th>
										<th>NRC</th>
										<th>Surname</th>
										<th>Othername(s)</th>
										<th>Position</th>
										<th>Belt No.</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
									
									
								</tbody>
							</table>
						</div>
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
 <!-- <script src="js/check_examiner_details.js"></script> -->

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
	get_subjects();
	get_paper();
	$('#belt_number').mask('000');

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
			remove_examiner(id);
                    $(this).dialog('close');
                }
            }
        ]
    });


$("#belt_number").keyup(function(){
	var numb=$(this).val();
	if (numb.length>0){
		console.log("number :",numb);
		$(".beltth").removeClass('d-none');
		$(".beltth").css("width","78px");
		$(".belttd").removeClass('d-none');
		
		$(".add_to_belt.NOT_BELTED").removeClass('d-none');
		$(".remove_from_belt.BELTED").removeClass('d-none');

		
		
		
		$('input[type=hidden][name=belt_no]').val(numb);
		$('span.belt').text(numb);
	}
	else{
		console.log("No value");
		// location.reload();
			$(".beltth").addClass('d-none');
			$(".belttd").addClass('d-none');
			$('span.belt').text(numb);
			
		
	}
}).click(function(){
	$(this).select();
});
// $('input[type="number"][name=this_belt_no]').keyup(function(){
// 	var this_belt_no = $(this).val();
// 	$(this).parent().next()
// });



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
		
		var subject = $(this).val();
		
		$('table.table tbody tr').remove();
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
		// $('table.table tbody tr').remove();
		}
		});
		examiners_per_paper(subject);
		
	});
}
function examiners_per_paper(subject){
	$('select[name=paper]').change(function(){
		var paper = $(this).val();
		$.ajax({
			url: 'php/get_examiners.php',
			method: 'POST',
			data: {subject_code:subject,paper:paper},
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
		var visible = this["belt_no"] == 'NOT BELTED' ? 'd-none' : '';
		$('table.table tbody').append('<tr class="'+this["id"]+'">'+
		'<td>'+this["examiner_number"]+'</td>'+
		'<td>'+this["nrc"]+'</td>'+
		'<td>'+this["last_name"]+'</td>'+
		'<td>'+this["first_name"]+'</td>'+
		'<td>'+this["position"]+'</td>'+
		'<td class="belt_'+this["id"]+'">'+this["belt_no"]+'</td>'+
		'<td>'+
			'<form action="" class="add_to_belt d-none '+this["belt"]+'" id="'+this["id"]+'">'+
			'<button id="'+this["id"]+'" type="button" class="btn btn-sm btn-outline-primary add_to_belt">add to belt <span id="'+this["id"]+'" class="belt"></span></button>'+
			'<input type="hidden" name="belt_no">'+
			'<input type="hidden" name="id" value="'+this["id"]+'">'+
			'</form>'+

			'<form action="" class="remove_from_belt '+this["belt2"]+' '+visible+'" id="'+this["id"]+'" data-id="'+this["id"]+'">'+
			'<button id="'+this["id"]+'" type="button" class="btn btn-sm btn-outline-danger remove_from_belt">remove from belt <span id="'+this["id"]+'">'+this["belt_no"]+'</span></button>'+
			'<input type="hidden" name="belt_no">'+
			'<input type="hidden" name="id" value="'+this["id"]+'">'+
			'</form>'+
		'</td>'+
		'</tr>');
	});
	belt_examiner();
	remove_from_belt();
	$('table.table tbody td').parent('tr.null').remove();
	$('table.table tbody td').each(function(){
	var currentTd = $(this).html();
	if(currentTd == 'undefined'){
		$(this).parent('tr.undefined').remove();
	}
	
		
	});
}
function belt_examiner(){
	$('button.add_to_belt').click(function(){
		
		var id = $(this).attr('id'),
			belt_no = $("#belt_number").val();
			if(belt_no != ''){
		$.ajax({
			url: 'php/belt_examiner.php',
			method: 'POST',
			data: {id:id,belt_no:belt_no},
			dataType: 'json',
			beforeSend: function(){
				$('button[type=button]').attr('disabled',true);
			},
			success: function(data){
				if(data.status == '400'){
					$('.dialog').text(data.response_msg).dialog('open');
					$('button[type=button]').attr('disabled',false);
				}else{
					// $('table.table tbody tr.'+data.id).remove();
					$('form#'+data.id+'.add_to_belt').addClass('d-none').parent().prev('td').text(data.belt_no);
					$('form#'+data.id+'.add_to_belt').removeClass('NOT_BELTED');
					$('form#'+data.id+'.remove_from_belt').removeClass('d-none').addClass('BELTED').removeClass('NOT_BELTED');
					$('form#'+data.id+'.remove_from_belt span').text(data.belt_no);
					$('#search').focus().select();
					$('button[type=button]').attr('disabled',false);
				}
			}
		});
	}else{
		$('.dialog').text('You need to choose a belt number').dialog('open');
	}
	});
}

function remove_from_belt(){
	$('.remove_from_belt').click(function(){
		var id = $(this).data('id'),
			belt_no = $('button.remove_from_belt#'+id+' span').text();
		$('.dialog1').text('Remove examiner from belt '+belt_no+'?').data('id',id).dialog('open');
	});
}

function remove_examiner(id){
	$.ajax({
		url: 'php/remove_belted_examiner.php',
		method: 'POST',
		data: {id:id},
		dataType: 'json',
		success: function(data){
			if(data.status == '200'){
				$('form#'+data.id+'.remove_from_belt').addClass('d-none').addClass('NOT_BELTED').removeClass('BELTED');
				$('form#'+data.id+'.add_to_belt').addClass('NOT_BELTED').removeClass('d-none');
				
				$('table.table tbody tr td.belt_'+data.id+'').text('NOT BELTED');
				
				
				
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