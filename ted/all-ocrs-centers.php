
<?php
session_start();
include '../config.php';
include '../functions.php';
?>
<!DOCTYPE html>
<html lang="en">



<?php include 'includes/header.php';

if($_SESSION['user_type'] == 'ECZ'){

    ?>

<body>
<div class="main-wrapper">

    <?php include 'includes/navbar.php'?>     

    <?php include 'includes/sidebar.php'?>

    <div class="page-wrapper">
        <div class="content">
            <div class="row justify-content-between px-2">
                <div class="col-xs-6">
                    <h4 class="page-title">IMPORTED OCRS CENTRES</h4>
                </div>
                <!-- <div class="col-xs-6">
                    <a href="javascript:void(0)" data-toggle="modal" data-target="#add-marking-center" class="btn bg-light btn-sm"><i class="fa fa-plus"></i> Add Marking Center</a>
                </div> -->
    
            </div>
    
            <div class="row">
                <div class="col-sm-4">
                    <div class="form-group">
                      <label for="">search:</label>
                      <input type="text"  id="search" class="form-control" placeholder="search" >
                    </div>
                </div>
                <br>
            </div>
        <div class="dialog"></div>
    <div class="dialog1"></div>
    <div class="dialog2"></div>

            <div class="table-responsive">
            <table class="table custom-table table-bordered">
                <thead >
                    <th>CENTER CODE</th>
                    <th>CENTER NAME</th>
                </thead>
                <tbody>
                    <!-- <tr>
                        <td>MC-01</td>
                        <td>KABULONGA GIRLS SECONDARY SCHOOL MARKING CENTER</td>
                        <td>LUSAKA</td>
                        <td>INTERNAL</td>
                        <td class="text-right">
                            <div class="dropdown dropdown-action">
                                <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a class="dropdown-item" href="javascript:void(0)" ><i class="fa fa-pencil m-r-5 blue-ecz"></i> Edit</a>
                                    <a class="dropdown-item" href="javascript:void(0)" data-toggle="modal" data-target="#delete_center"><i class="fa fa-trash-o m-r-5 red-ecz"></i> Delete</a>
                                </div>
                            </div>
                        </td>
                    </tr> -->
                </tbody>
            </table>
            </div>
        </div>
    </div>

    <div class="sidebar-overlay" data-reff=""></div>
</div>

<!-- Modals  --><!-- Modal -->


<!-- <div id="delete_center" class="modal fade delete-modal" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body text-center">
                 <img src="assets/img/sent.png" alt="" width="50" height="46"> -->
                <!-- <h3>Are you sure want to delete this Marking Center?</h3>
                <div class="m-t-20"> <a href="#" class="btn  btn-white" data-dismiss="modal">Close</a>
                    <button type="submit" class="btn  btn-danger">Delete</button>
                </div>
            </div>
        </div>
    </div>
</div> --> 
      
      
      <!-- <div class="modal fade" id="add-marking-center" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
            <form action="" method="post" id="add_marking_centre">
            <div class="modal-header p-2 bg-success ">
                <div class="modal-title text-white h5 text-center">New Marking Center</div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            
           
            </form>
            </div>
        </div>
        </div> -->
	
<?php include 'includes/scripts.php' ?>

</body>
<script>
$(document).ready(function(){
    //get_province();
   // add_marking_centre();
   get_all_ocrs_centres();
  
function get_all_ocrs_centres(){
    $.ajax({
            url: 'php/get_all_ocrs_centres.php',
            method: 'POST',
            dataType: 'json',
            success:function(data){
                $('table.table tbody tr').remove();
                if(data.status == '400'){
                    $('table.table tbody').append('<tr class="null">'+
                    '<td colspan="4">No centres imported</td>'+
                   '</tr>' );
                }else{
                    $('table.table tbody tr.null').remove();
                    $.each(data,function(){
                    $('table.table tbody').append('<tr class="'+this["centre_code"]+'">'+
                    '<td>'+this["centre_code"]+'</td>'+
                    '<td>'+this["centre_name"]+'</td>'+
                   
                    '</tr>');
                });
                // $('.delete').click(function(){
                //     var id = $(this).data('id');
                //     $('.dialog1').text('Are you sure you want to delete this marking centre?').data('id',id).dialog('open');
                // });
                $('table.table tbody td').each(function(){
                    var currentTd = $(this).html();
                     if(currentTd == 'undefined'){
                        $(this).parent('tr.undefined').remove();
                     }
                });
                }
            }
        });
}


// function delete_marking_centre(centre_code){
//     $.ajax({
//         url: 'php/delete_marking_centre.php',
//         method: 'POST',
//         data: {centre_code:centre_code},
//         dataType: 'json',
//         success: function(data){
//             if(data.status == '400'){
//                 $('.dialog2').text(data.response_msg).dialog('open');
//             }else{
//                 $('table.table tbody tr.'+centre_code).remove();
//             }
//         }
//     });
// }

});
</script>
<?php

}else{
    header('location: ../');
}
?>

</html>