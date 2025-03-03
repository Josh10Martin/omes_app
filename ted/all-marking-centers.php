
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
                    <h4 class="page-title">MARKING CENTRE</h4>
                </div>
                <!-- <div class="col-xs-6">
                    <a href="javascript:void(0)" data-toggle="modal" data-target="#add-marking-center" class="btn bg-light btn-sm"><i class="fa fa-plus"></i> Add Marking Centre</a>
                </div> -->
    
            </div>
    
            <div class="row">
                <div class="col-sm-4">
                    <div class="form-group">
                      <!-- <label for="">search:</label> -->
                      <input type="text"  id="search" class="form-control" placeholder="Search" >
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
                    <th>CODE</th>
                    <th>MARKING CENTRE NAME</th>
                    <!-- <th>PROVINCE</th> -->
                    <!-- <th>TYPE</th> -->
                    <!-- <th>ACTION</th>  -->
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
      
      
      <div class="modal fade" id="add-marking-center" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
            <form action="" method="post" id="add_marking_centre">
            <div class="modal-header p-2 bg-success ">
                <div class="modal-title text-white h5 text-center">New Marking Centre</div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            
            <div class="row">
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>CODE:</label>
                            <input type="text" name="centre_code" class="form-control" value="<?php echo marking_centre_code($db_ted); ?>" required readonly>
                        </div>
                    </div>
                    
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>NAME:</label>
                            <input type="text" name="centre_name" class="form-control" oninput="this.value = this.value.toUpperCase()" required>
                        </div>
                    </div>
                   
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <label for="province">Select Province</label>
                        <select name="province" class="select" id="" required> 
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="type">Select Type</label>
                        <select name="centre_type" class="select" id="" required> 
                            <option value="" selected disabled>select...</option>
                            <option value="I" >Teacher Education</option>
                        </select>
                    </div>
                </div>
                
            </div>
            <div class="modal-footer">
                <button type="button" id="close" class="btn btn-secondary mr-auto" data-dismiss="modal">Close</button>
                <img class="loading" src="../images/loading.gif" style="transform: translateX(100%); display:none;"/>
                <button type="submit" id="save" class="btn btn-primary float-right">Save</button>
            </div>
            </form>
            </div>
        </div>
        </div>
	
<?php include 'includes/scripts.php' ?>

</body>
<script>
$(document).ready(function(){
    get_province();
    add_marking_centre();
    get_all_marking_centres();
    $('.dialog').dialog({
        title: 'REQUEST RESPONSE',
        width: '450',
        height: '150',
        modal: true,
        draggable: false,
        resizable: false,
        closeOnEscape: false,
        appendTo: '#add-marking-center',
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
    $('.dialog1').dialog({
        title: 'REQUEST RESPONSE',
        width: '450',
        height: '150',
        modal: true,
        draggable: false,
        resizable: false,
        closeOnEscape: false,
        // appendTo: '#add-marking-center',
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
                text: 'YES ',
                click: function(){
                    var id = $('.dialog1').data('id');
                    delete_marking_centre(id);
                    $(this).dialog('close');
                }
            }
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
        appendTo: '#add-marking-center',
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
                    location.reload();
                    $(this).dialog('close');
                }
            }
        ]
    });

function get_province(){
    $.ajax({
        url: 'php/get_province.php',
        method: 'POST',
        dataType: 'json',
        success:function(data){
            $('select[name=province]').append(
                '<option value="" selected disabled>Select province</option>'
            );
            $.each(data,function(){
                $('select[name=province]').append(
                '<option value="'+this["province_code"]+':'+this["province"]+'">'+this["province"]+'</option>'
            );
            });
        }
    });
}

function add_marking_centre(){
    
    $('#add_marking_centre').submit(function(e){
        e.preventDefault();
        var centre_code = $('input[type=text][name=centre_code]').val(),
            centre_name = $('input[type=text][name=centre_name]').val(),
            province = $('select[name=province]').val().split(':'),
            province_code = province[0],
            province_name = province[1],
            centre_type = $('select[name=centre_type]').val()  == 'I' ? 'TEACHER EDUCATION' : '[UNKNOWN]';
        $.ajax({
            url: 'php/add_marking_centre.php',
            method: 'POST',
            data: $('#add_marking_centre').serialize(),
            dataType: 'json',
            beforeSend: function(){
                $('button[id=close]').attr('disabled',true);
                $('button[id=save]').attr('disabled',true).addClass('bg_att');
                $('img.loading').css('display','block');
            },
            success:function(data){
               
                if(data.status == '400'){
                    $('.dialog').text(data.response_msg).dialog('open');
                   $('button[id=close]').attr('disabled',false);
                    $('button[id=save]').attr('disabled',false).removeClass('bg_att');
                    $('img.loading').css('display','none');
                }else{
                    var serial = parseInt($('input[type=text][name=centre_code]').val().substring(3)),
                        serial_1 = serial +1;
                    $('input[type=text][name=centre_code]').val(serial_1);
                    $('.dialog').text(data.response_msg).dialog('open');
                    $('#add_marking_centre').trigger('reset');
                    $('table.table tbody tr.null').remove();
                    $('table.table tbody').append('<tr class="'+centre_code+'">'+
                    '<td>'+centre_code+'</td>'+
                    '<td>'+centre_name+'</td>'+
                    // '<td>'+province_name+'</td>'+
                    '<td>'+centre_type+'</td>'+
                    // '<td class="text-right">'+
                    //         '<div class="dropdown dropdown-action">'+
                    //             '<a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>'+
                    //             '<div class="dropdown-menu dropdown-menu-right">'+
                    //                 '<a class="dropdown-item" href="javascript:void(0)" ><i class="fa fa-pencil m-r-5 blue-ecz"></i> Edit</a>'+
                    //                 '<a class="dropdown-item delete" data-id="'+centre_code+'" href="javascript:void(0)" data-toggle="modal" data-target="#delete_center"><i class="fa fa-trash-o m-r-5 red-ecz"></i> Delete</a>'+
                    //             '</div>'+
                    //         '</div>'+
                    //     '</td>'+
                    '</tr>');
                    $('.delete').click(function(){
                        var id = $(this).data('id');
                        $('.dialog1').text('Are you sure you want to delete this marking centre?').data('id',id).dialog('open');
                    });
                    $('button[id=close]').attr('disabled',false);
                    $('button[id=save]').attr('disabled',false).removeClass('bg_att');
                    $('img.loading').css('display','none');
                }
            }
        });
    });
}

function get_all_marking_centres(){
    $.ajax({
            url: 'php/get_all_marking_centres.php',
            method: 'POST',
            dataType: 'json',
            success:function(data){
                $('table.table tbody tr').remove();
                if(data.status == '400'){
                    $('table.table tbody').append('<tr class="null">'+
                    '<td colspan="5">No Marking Centres</td>'+
                   '</tr>' );
                }else{
                    $('table.table tbody tr.null').remove();
                    $.each(data,function(){
                    $('table.table tbody').append('<tr class="'+this["centre_code"]+'">'+
                    '<td>'+this["centre_code"]+'</td>'+
                    '<td>'+this["centre_name"]+'</td>'+
                    // '<td>'+this["province_name"]+'</td>'+
                    // '<td>'+this["centre_type"]+'</td>'+
                    // '<td class="text-right">'+
                    //         '<div class="dropdown dropdown-action">'+
                    //             '<a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>'+
                    //             '<div class="dropdown-menu dropdown-menu-right">'+
                    //                 '<a class="dropdown-item" href="javascript:void(0)" ><i class="fa fa-pencil m-r-5 blue-ecz"></i> Edit</a>'+
                    //                 '<a class="dropdown-item delete" data-id="'+this["centre_code"]+'" href="javascript:void(0)" data-toggle="modal" data-target="#delete_center"><i class="fa fa-trash-o m-r-5 red-ecz"></i> Delete</a>'+
                    //             '</div>'+
                    //         '</div>'+
                    //     '</td>'+
                    '</tr>');
                });
                $('.delete').click(function(){
                    var id = $(this).data('id');
                    $('.dialog1').text('Are you sure you want to delete this marking centre?').data('id',id).dialog('open');
                });
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


function delete_marking_centre(centre_code){
    $.ajax({
        url: 'php/delete_marking_centre.php',
        method: 'POST',
        data: {centre_code:centre_code},
        dataType: 'json',
        success: function(data){
            if(data.status == '400'){
                $('.dialog2').text(data.response_msg).dialog('open');
            }else{
                $('table.table tbody tr.'+centre_code).remove();
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