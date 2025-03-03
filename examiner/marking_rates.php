
<?php
session_start();

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
                    <h4 class="page-title">MARKING RATES</h4>
                </div>
                <!-- <div class="col-xs-6">
                    <a href="javascript:void(0)" data-toggle="modal" data-target="#add-marking-center" class="btn bg-light btn-sm"><i class="fa fa-plus"></i> Add Session</a>
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
            
    
            <div class="table-responsive">
                <div class="dialog"></div>
            <table class="table custom-table table-bordered">
                <thead>
                    <th>SUBJECT</th>
                    <th>PAPER</th>
                    <th>CHIEF-EXAMINER RATE (K)</th>
                    <th>DEPUTY CHIEF-EXAMINER RATE (K)</th>
                    <th>TEAM-LEADER RATE (K)</th>
                    <th>EXAMINER RATE (K)</th>
                    <th>DATA ENTRY RATE (K)</th>
                </thead>
                <tbody>
                    <!-- <tr>
                        <td>ENGLISH LANGUAGE</td>
                        <td>PAPER 1</td>
                        <td>K 8.00</td>
                        <td>K 8.00</td>
                        <td>K 8.00</td>
                        <td>K 8.00</td>
                        <td class="text-right">
                            <span class="btn btn-sm btn-primary" data-toggle="modal" data-target="#update-marking-rate">UPDATE</span>
                            <div class="dropdown dropdown-action">
                                <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a class="dropdown-item" href="javascript:void(0)" ><i class="fa fa-pencil m-r-5 blue-ecz"></i> Edit</a>
                                    <a class="dropdown-item" href="javascript:void(0)" data-toggle="modal" data-target="#delete_center"><i class="fa fa-trash-o m-r-5 red-ecz"></i> Delete</a>
                                </div>
                            </div> 
                        </td> -->
                    </tr>
                </tbody>
            </table>
            </div>
        </div>
    </div>

    <div class="sidebar-overlay" data-reff=""></div>
</div>

<!-- Modals  --><!-- Modal -->
      
      <div class="modal fade" id="update-marking-rate" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="dialog"></div>
                <div class="dialog1"></div>
          
            </div>
        </div>
        </div>
	
<?php include 'includes/scripts.php' ?>

</body>
<script>
$(document).ready(function(){
    get_marking_rates();

    $('.dialog').dialog({
        title: 'REQUEST RESPONSE',
        width: '450',
        height: '150',
        modal: true,
        draggable: false,
        resizable: false,
        appendTo: '#update-marking-rate',
        closeOnEscape: false,
        autoOpen: false,
        create: function(e){
            $(e.target).parent().css({
                'position':'fixed'
            }); 
            
        },
        buttons: [
            // {
            //     text: 'login',
            //     click: function(){
            //         location.href="/orvs";
            //     }
            // },
            {
                text: 'OK',
                click: function(){
                    $(this).dialog('close');
                }
            }
        ]
    });

    function get_marking_rates(){
        $.ajax({
            url: 'php/get_marking_rates.php',
            nethod: 'POST',
            dataType: 'json',
            success: function(data){
                if(data.status == '200'){
                    $.each(data,function(){
                        $('table.table tbody').append('<tr class="'+this["id"]+'">'+
                    '<td>'+this["subject_name"]+'</td>'+
                    '<td>'+this["paper_no"]+'</td>'+
                    '<td>'+this["chief_examiner"]+'</td>'+
                    '<td>'+this["deputy_c_examiner"]+'</td>'+
                    '<td>'+this["t_leader"]+'</td>'+
                    '<td>'+this["examiner"]+'</td>'+
                    '<td>'+this["data_entry_operator"]+'</td>'+
                  
                   '</tr>');
                    });
                    $('table.table tbody td').each(function(){
                    var currentTd = $(this).html();
                     if(currentTd == 'undefined'){
                        $(this).parent('tr.undefined').remove();
                     }
                });
                rates();
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