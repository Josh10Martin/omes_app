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
                        <h4 class="page-title">Transcribers</h4>
                    </div>
			  
		    <?php
			if($_SESSION['user_type'] == 'ADMIN' || $_SESSION['user_type'] == 'DEO'){
		    ?>
		    
                    <div class="col-sm-8 col-9 text-right m-b-20">
					<a class="btn btn-white"  href="add-transcribers.php"><i class="fa fa-plus green-ecz" aria-hidden="true"></i> Add Transcriber</a>
					<div class="clearfix"></div>
				
                   
                    </div>
			  <form action="" id="total_scripts">
			  <div class="title" class="col-md-6">
                  TOTAL NUMBER OF SCRIPTS:
                  <input type="text" title="Enter digit" name="total_scripts_no" placeholder="0" min="1" required style="width:30px;"/>
			<button type="submit" class="btn btn-dark">GO</i></button>
                </div>
			</form>
		    <?php
			}
		    ?>
                </div>
<div class="row justify-content-between p-2">
	
	<div class="col-md-6">
	
	</div>
</div>
			
			<br>
			
                <div class="row">
					<div class="col-md-12">
						<div class="table-responsive">
							
							<div class="dialog"></div>
							<div class="dialog0"></div>
							<div class="dialog1"></div>
							<div class="dialog2"></div>
							<table class="table table-border table-striped custom-table mb-0">
								<thead>
									<tr>
										<th>NRC Number</th>
										<th>Surname</th>
										<th>Othername(s)</th>
										<th>Phone</th>
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


	
	view_transcribers();
	get_trans_surrent_script_no();
	set_trans_script_no();
	
	

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
                    delete_transcriber(id);
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
                text: 'OK',
                click: function(){
                    $(this).dialog('close');
		  
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
	$('.dialog2').dialog({
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
	
	function get_trans_surrent_script_no(){

		$('input[type=text][name=total_scripts_no]').click(function(){
		$(this).select();
	  });

		$.ajax({
			url: 'php/get_trans_surrent_script_no.php',
			method: 'POST',
			dataType: 'json',
			success: function(data){
				$('input[type=text][name=total_scripts_no]').val(data.no_of_scripts);
			}
		});
	}
	function set_trans_script_no(){
		$('#total_scripts').submit(function(e){
			e.preventDefault();
			$.ajax({
				url: 'php/set_trans_script_no.php',
				method: 'POST',
				data: $(this).serialize(),
				dataType: 'json',
				success: function(data){
					if(data.status == '400'){
						$('.dialog1').text(data.response_msg).dialog('open');
					}else{
						$('.dialog2').text(data.response_msg).dialog('open');
					}
				}
			});
		});
	}

function view_transcribers(){
	
	$.ajax({
		url: 'php/get_transcriber.php',
		method: 'POST',
		dataType: 'json',
		success: function(data){
			$('table.table tbody tr').remove();
			if(data.status== '400'){
				$('table.table tbody').append('<tr class="null">'+
				'<td colspan="6">No transcriber added</td>'+
				
				'</tr>');
			}else{
				transcriber_data(data);
				
			}
			delete_press();	
		}
	});

}



function transcriber_data(data){
	$.each(data,function(){
		var red = this["bank_id"] == '' ? 'lightcoral' : '';
		$('table.table tbody').append('<tr class="'+this["id"]+'" style="background-color:'+red+'">'+
		'<td>'+this["nrc"]+'</td>'+
		'<td>'+this["last_name"]+'</td>'+
		'<td>'+this["first_name"]+'</td>'+
		'<td>'+this["phone"]+'</td>'+
		'<td>'+this["role"]+'</td>'+
		<?php if($_SESSION['user_type'] != 'ECZ' ){  ?>
		'<td class="text-right">'+
			'<div class="dropdown dropdown-action">'+
				'<a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v "></i></a>'+
				'<div class="dropdown-menu dropdown-menu-right">'+
					'<a class="dropdown-item edit" id="'+this["id"]+'" href="edit-transcriber.php?id='+this["id"]+'"><i class="fa fa-pencil m-r-5 blue-ecz"></i> Edit</a>'+
					'<a data-id="'+this["id"]+'" class="dropdown-item delete" href="#" data-toggle="modal" data-target="#delete_transcriber"><i class="fa fa-trash-o m-r-5 red-ecz"></i> Delete</a>'+
				'</div>'+
			'</div>'+
		'</td>'+
		<?php  }  ?>
		'</tr>');
	});
	

}
function delete_press(){
	$('a.delete').click(function(){
	var id = $(this).data('id');
	$('.dialog').text('Are you sure you want to delete transcriber?').data('id',id).dialog('open');
});
}
function delete_transcriber(id){
	$.ajax({
		url: 'php/delete_transcriber.php',
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

	




});
</script>

<?php
}else{

loheader('location: ../');
}
?>
</html>