<?php
session_start();

?>
<!DOCTYPE html>
<html lang="en">



<?php include 'includes/header.php'?>

<body>
<div class="main-wrapper">

    <?php include 'includes/navbar.php'?>     
    <?php include 'includes/sidebar.php'?>
<div class="page-wrapper">
    <div class="content">
        <div class="row justify-content-between px-2">
            <div class="col-xs-6">
                <h4 class="page-title">SYSTEM ADMINISTRATORS AND DATA ENTRY OPERATOR USERS</h4>
            </div>
            <div class="col-xs-6">
                
                <a href="javascript:void(0)" data-toggle="modal" data-target="#add-admin" class="btn bg-light btn-sm"><i class="fa fa-user-plus"></i> Add SESO</a>
            </div>

        </div>

        <div class="row">
            <div class="col-sm-4">
                <div class="form-group">
                  <!-- <label for="">search:</label> -->
                  <input type="text" name="search" id="search" class="form-control" placeholder="search" >
                </div>
            </div>
            <br>
            <a href="#"  data-toggle="modal" data-target="#admin_deo_modal" class="btn btn-white"><i aria-hidden="true"></i> Acivate / De-Acivate Users</a>

        </div>
        
        <div class="table-responsive">
            <div class="dialog"></div>
            <div class="dialog1"></div>
            <div class="dialog2"></div>
            <div class="dialog3"></div>
            <div class="dialog4"></div>
            
        <table class="table custom-table table-bordered" >
            <thead>
                <th>USERNAME</th>
                <th>SURNAME</th>
                <th>OTHER NAME(S)</th>
                <th>MARKING CENTRE</th>
                <th>PROVINCE</th>
                <th> EMAIL / PHONE</th>
                <th>ACTIVATION STATUS</th>
                <th>ROLE</th>
            </thead>
            <tbody id="table">

            </tbody>
        </table>
        </div>

        <!-- admin / data entry modal -->

        <div class="modal fade" id="admin_deo_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header p-2 bg-success ">
                                <div class="modal-title h4 text-white text-center " id="exampleModalLongTitle">ADMIN / DEO Activation status</div>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="dialog"></div>
                                <div class="dialog1"></div>
                                <div class="dialog2"></div>
                                <div class="dialog3"></div>
                                <form method="post" id="user_status">
                                   
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Users:</label>
                                                <select class="select" name="roles" required>
                                                    <option value="" selected desable> choose users...</option>
                                                    <option value="all">ALL</option>
                                                    <option value="ADMIN">SYSTEM ADMINISTRATORS</option>
                                                    <option value="DEO">DATA ENTRY OFFICERS</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Activation status:</label>
                                                <select class="select" name="ac_status" required>
                                                    <option value="" selected disable>Choose activation status...</option>
                                                    <option value="1">ACITVATE</option>
                                                    <option value="0">DE-ACTIVATE</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button id="button_close" type="button" class="btn btn-secondary mr-auto" data-dismiss="modal">Close</button>
                                        <img class="loading" src="../images/loading.gif" style="transform: translateX(100%); display:none;" />
                                        <button id="save" type="submit" class="btn btn-primary float-right">Save</button>
                                    </div>

                                </form>
                            </div>

                        </div>
                    </div>
                </div>


        <!-- admin data entry end -->

    <?php include 'includes/notifications.php' ?>
    </div> <!--End  content-->
    
</div> <!--End page wrapper-->

<div class="sidebar-overlay" data-reff=""></div>
</div>	
<?php include 'includes/scripts.php' ?>

</body>
<script type="text/javascript">

$(document).ready(function(){

    get_admins_deo();
    activate_deactivate();

    $('.dialog').dialog({
        title: 'REQUEST RESPONSE',
        width: '450',
        height: '150',
        modal: true,
        draggable: false,
        resizable: false,
        closeOnEscape: false,
        appendTo: '#sidebar',
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
                    $(this).dialog('close');
                    var id = $('.dialog').data('id');
                    change_admin_deo_status(id);
                    
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
                text: 'OK',
                click: function(){
                    location.reload();
                    $(this).dialog('close');
                }
            }
            // {
            //     text: 'YES',
            //     click: function(){
            //         var id = $('.dialog').data('id');
            //         change_admin_deo_status(id);
            //         $(this).dialog('close');
            //     }
            // }
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
        appendTo: '#admin_deo_modal',
        autoOpen: false,
        create: function(e){
            $(e.target).parent().css({
                'position':'fixed'
            }); 
            
        },
        buttons: [
            {
                text: 'YES',
                click: function(){
                    change_user_status();
                    $(this).dialog('close');
                }
            },
            {
                text: 'NO',
                click: function(){
                    $(this).dialog('close');
                }
            }
        ]
    });
    $('.dialog3').dialog({
        title: 'REQUEST RESPONSE',
        width: '450',
        height: '150',
        modal: true,
        draggable: false,
        resizable: false,
        closeOnEscape: false,
        appendTo: '#admin_deo_modal',
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
                    location.reload();
                    $(this).dialog('close');
                }
            }
            // {
            //     text: 'YES',
            //     click: function(){
            //         var id = $('.dialog').data('id');
            //         change_admin_deo_status(id);
            //         $(this).dialog('close');
            //     }
            // }
        ]
    });
    $('.dialog4').dialog({
        title: 'REQUEST RESPONSE',
        width: '450',
        height: '150',
        modal: true,
        draggable: false,
        resizable: false,
        closeOnEscape: false,
        appendTo: '#sidebar',
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
                    // location.reload();
                    $('.dialog').dialog('close');
                    $(this).dialog('close');
                }
            }
            // {
            //     text: 'YES',
            //     click: function(){
            //         var id = $('.dialog').data('id');
            //         change_admin_deo_status(id);
            //         $(this).dialog('close');
            //     }
            // }
        ]
    });

    function get_admins_deo(){
    $.ajax({
        url: 'php/get_admins_data_entry_operators.php',
        method: 'POST',
        dataType: 'json',
        success: function(data){
            
                
            if(data.status == '400'){
                $('table.table tbody#table').append('<tr class="null">'+
                '<td colspan="6" style="text-align:center;">There is no data</td>'+
                '</tr>');
            }else{
               

                $.each(data,function(){
                   var activation = this["activation_status"] == 'NOT ACTIVE' ? 'Activate' : 'De Activate',
                   color = this["activation_status"] == 'NOT ACTIVE' ? 'bg-danger' : 'bg-primary';
                    $('table.table tbody#table').append('<tr class="'+this["username"]+'">'+
                    '<td id="'+this["username"]+'">'+this["username"]+'</td>'+
                    '<td>'+this["last_name"]+'</td>'+
                    '<td>'+this["first_name"]+'</td>'+
                    '<td>'+this["marking_centre"]+'</td>'+
                    '<td>'+this["province"]+'</td>'+
                    '<td><a href="mailto:'+this["email"]+'&subject=Message from Examinations Council of Zambia">'+this["email"]+'</a> / '+this["phone_number"]+'</td>'+
                    '<td> <button type="button" style="box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);" class="btn btn-lg '+color+' btn-toggle active_status" aria-pressed ="false" data-id="'+this["username"]+'" autocomplete="off"><span style="color:white;">'+this["activation_status"]+'</span></button></td>'+
                    '<td>'+this["role"]+'</td>'+
                    '</tr>');
                   
                });
                $('button.active_status').hover(function(){
                    $(this).addClass('bg-dark');
                   
                    var status_value = $(this).children().text() == 'NOT ACTIVE' ? 'Activate?' : ($(this).children().text() == 'ACTIVE' ?'De-Activate?' : $(this).children().text() );
                    $(this).children().text(status_value);
                   

                }).mouseleave(function(){
                    var status_question = $(this).children().text() == 'Activate?' ? 'NOT ACTIVE' : ($(this).children().text() == 'De-Activate?' ?'ACTIVE' : $(this).children().text() );
                    $(this).children().text(status_question);
                
                }).click(function(){
                    var role = $(this).closest('td').next().html();
                    // alert(role);
                    var  username = $(this).data('id'),
                    status = $(this).children().text() == 'Activate?' ? 'activate' : ($(this).children().text() == 'De-Activate?' ?'de-activate' : '[unknown action]' );
                    $('.dialog').text('Are you sure you want to '+status+' '+role+'?').data('id',username).dialog('open');
                });
            
               
            }
        }
    });
}

function change_admin_deo_status(id){
    $.ajax({
        url: 'php/admin_deo_status.php',
        method: 'POST',
        data: {username:id},
        dataType: 'json',
        beforeSend:function(){
            $('button[data-id='+id+']').text('Please Wait...').attr('disable',true);
        },
        success:function(data){
            // $('.dialog4').text(data.response_msg).dialog('open');

            if(data.status == '200'){
                var status = data.before_activation_status == 1 ? 'MOT ACTIVE' : 'ACTIVE';
                $('button[data-id='+id+']').text(status).attr('disable',false).css('color','white');
                $('.dialog4').text(data.response_msg).dialog('open');
            }else{
                $('.dialog4').text(data.response_msg).dialog('open');
            }
        }
    });
}
function activate_deactivate(){
    $('#user_status').submit(function(e){
        e.preventDefault();
        var status = $('select[name=ac_status]').val() == 1 ? 'Activate' : 'De-activate',
            role = $('select[name=roles]').val() == 'ADMIN' ? 'System Administrators' : ($('select[name=roles]').val() == 'DEO' ? 'Data Entry Officers' : 'all users');
        $('.dialog2').text(status+' '+role+'?').dialog('open');
    });
}
function change_user_status(){
    $.ajax({
        url: 'php/change_user_status.php',
        method: 'POST',
        data: $('#user_status').serialize(),
        dataType : 'json',
        beforeSend: function(){
            $('button[id=save]').attr('disabled',true).addClass('bg_att');
            $('button[id=button_close]').attr('disabled',true);
            $('img.loading').css('display','block');
        },
        success:function(data){
            $('button[id=save]').attr('disabled',false).removeClass('bg_att');
            $('button[id=button_close]').attr('disabled',false);
            $('img.loading').css('display','none');

            $('.dialog3').text(data.response_msg).dialog('open');
        }

    });
}
});
</script>


</html>