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
        <div class="row justify-content-between px-2">
            <div class="col-xs-6">
                <h4 class="page-title">Data Entry Officers</h4>
            </div>
           

        </div>

        <div class="row">
            <div class="col-sm-4">
                <div class="form-group">
                  <!-- <label for="">search:</label> -->
                  <input type="text" id="search" class="form-control" placeholder="Search" >
                </div>
            </div>
            <br>
        </div>
        
        <div class="feedback" style="text-align:center;font-size:16px;"></div>
        <div class="table-responsive">
          
        <table class="table custom-table table-bordered" id="table">
            <thead>
                <th>USERNAME</th>
                <th>OTHER NAME(s)</th>
                <th>SURNAME</th>
                <th>ACTIVATION STATUS</th>
                <th>LOGIN STATUS</th>
                <!-- <th>ACTION</th> -->
            </thead>
            <tbody>
              
            </tbody>
        </table>
        </div>

    <?php include 'includes/notifications.php' ?>
    </div> <!--End  content-->
    <!--Modal-->
    <div class="modal fade" id="add-admin" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="dialog"></div>
            <div class="dialog1"></div>
            <div class="dialog2"></div>
            <div class="dialog3"></div>
            <div class="dialog4"></div>
            <div class="dialog5"></div>
            <div class="dialog6"></div>
        
        </div>
    </div>
    </div>

 

</div> <!--End page wrapper-->

<div class="sidebar-overlay" data-reff=""></div>
</div>	
<?php include 'includes/scripts.php' ?>
</body>

<script type = "text/javascript">
   

$(document).ready(function(){
    get_data_entry();

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
                text: 'NO',
                click: function(){
                    $(this).dialog('close');
                }
            },
            {
                text: 'YES',
                click: function(){
                    var id = $('.dialog2').data('id');
                    change_status(id);
                    $(this).dialog('close');
                }
            }
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
                    var id = $('.dialog4').data('id');
                    change_login_status(id);
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
        // appendTo: '#delete_admin',
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
                    var id = $('.dialog4').data('id');
                    delete_admin(id);
                    $(this).dialog('close');
                }
            }
        ]
    });
    $('.dialog').dialog({
        title: 'REQUEST RESPONSE',
        width: '450',
        height: '150',
        modal: true,
        draggable: false,
        resizable: false,
        closeOnEscape: false,
        // appendTo: '#delete_admin',
        autoOpen: false,
        create: function(e){
            $(e.target).parent().css({
                'position':'fixed'
            }); 
            
        },
        buttons: [
            // {
            //     text: 'NO',
            //     click: function(){
            //         $(this).dialog('close');
            //     }
            // },
            {
                text: 'OK',
                click: function(){
                
                    $(this).dialog('close');
                    location.reload();
                }
            }
        ]
    });

 


function get_data_entry(){
    $.ajax({
        url: 'php/get_data_entry.php',
        method: 'POST',
        dataType: 'json',
        success: function(data){
            $('table#table tbody tr').remove();
            
            if(data.status == '400'){
                
                $('table#table tbody').append('<tr class="null">'+
                '<td colspan="6" style="text-align:center;">There is no data</td>'+
                '</tr>');
            }else{
               
                $.each(data,function(){
                    
            var activation = this["active"] == 'NOT ACTIVE' ? 'Activate' : 'De Activate',
             color = this["active"] == 'NOT ACTIVE' ? 'bg-danger' : 'bg-primary',
             login_status_color = this["login_status"] == 'LOGGED OUT' ? 'bg-danger' : 'bg-primary';
                    
            $('table#table tbody').append('<tr class="'+this["id"]+'">'+
                    '<td>'+this["username"]+'</td>'+
                    '<td>'+this["first_name"]+'</td>'+
                    '<td>'+this["last_name"]+'</td>'+
                    '<td> <button type="button" style="box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);" class="btn btn-lg '+color+' btn-toggle active_status" aria-pressed ="false" data-id="'+this["id"]+'" autocomplete="off"><span style="color:white;">'+this["active"]+'</span></button> </td>'+
                    '<td> <button type="button" style="box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);" class="btn btn-lg '+login_status_color+' btn-toggle login_status" aria-pressed ="false" data-id="'+this["id"]+'" autocomplete="off"><span style="color:white;">'+this["login_status"]+'</span></button></td>'+
                    // '<td class="text-right">'+
                    //     '<div class="dropdown dropdown-action">'+
                    //         '<a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>'+
                    //         '<div class="dropdown-menu dropdown-menu-right">'+
                    //             '<a id="'+this["id"]+'" class="dropdown-item '+this["active"]+' dea_activate" href="#" data-id="'+this["id"]+'" data-toggle="modal" data-target="delete_admin"><i class="fa fa-ban fa-fw red-ecz"></i> '+activation+'</a>'+
                    //             '<a id="'+this["id"]+'" class="dropdown-item '+this["login_status"]+' login_logout" href="#" data-id="'+this["id"]+'" data-toggle="modal" data-target="delete_admin"><i class="fa fa-ban fa-fw red-ecz"></i> '+login_status+'</a>'+
                    //         '</div>'+
                    //     '</div>'+
                    // '</td>'+
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
                    var  id = $(this).data('id'),
                    status = $(this).children().text() == 'Activate?' ? 'activate' : ($(this).children().text() == 'De-Activate?' ?'de-activate' : '[unknown action]' );
                    $('.dialog2').text('Are you sure you want to '+status+' user?').data('id',id).dialog('open');
                });

                    // log in log out
                $('button.login_status').hover(function(){
                    $(this).addClass('bg-dark');
                  
                    var status_value = $(this).children().text() == 'LOGGED OUT' ? 'Log In?' : ($(this).children().text() == 'LOGGED IN' ?'Log Out?' : $(this).children().text() );
                    $(this).children().text(status_value);
                  

                }).mouseleave(function(){
                    var status_question = $(this).children().text() == 'Log In?' ? 'LOGGED OUT' : ($(this).children().text() == 'Log Out?' ?'LOGGED IN' : $(this).children().text() );
                    $(this).children().text(status_question);
                    // alert(status_question)
                }).click(function(){
                    var  id = $(this).data('id'),
                    status = $(this).children().text() == 'Log In?' ? 'log in' : ($(this).children().text() == 'Log Out?' ?'log out' : '[unknown action]' );
                    $('.dialog4').text('Are you sure you want to '+status+' this user?').data('id',id).dialog('open');
                });
                
                // $('a.dea_activate').click(function(){
                //     var stat_val = $(this).attr('class').split(' '),
                //     id = $(this).attr('id'),
                //     state = stat_val[1],
                //     status = state == 'NOT' ? 'Activate' : 'De Activate';
                //     $('.dialog2').text('Are you sure you want to '+status+' user?').data('id',id).dialog('open');

                // });
                // $('a.login_logout').click(function(){
                //     var stat_val = $(this).attr('class').split(' '),
                //     id = $(this).attr('id'),
                //     state = stat_val[1],
                //     status = state == 'NOT' ? 'Log in' : 'Log out';
                //     $('.dialog4').text('Are you sure you want to '+status+' user?').data('id',id).dialog('open');

                // });
             
            }
        }
    });
}
             


   function change_status(id){
                    var state = $('table.table tbody td[id='+id+']').next().next().next().next().html(),
                    status = state == 'ACTIVE' ? 'NOT ACTIVE' : 'ACTIVE';
                    var state2 = $('a[id='+id+']').text(),
                    status2 = state2 == 'Activate' ? 'De Activate' : 'Activate',
                    username = $('table#table tbody td[id='+id+']').html();
                    $.ajax({
                        url: 'php/change_data_entry_status.php',
                        method: 'POST',
                        data: {id:id},
                        dataType:'json',
                        beforeSend:function(){
                            $('.feedback').text('Please wait for request feedback....')
                        },
                        success:function(data){
                           
                            if(data.status == '200'){
                                $('.feedback').text('');
                                $('.dialog').text(data.response_msg).dialog('open');
                            }else{
                                $('.feedback').text('');
                                $('.dialog').text(data.response_msg).dialog('open');
                               
                            }
                        }
                    });
                }
      
                function change_login_status(id){
                    $.ajax({
                        url: 'php/change_data_entry_login_status.php',
                        method: 'POST',
                        data: {id:id},
                        dataType:'json',
                        beforeSend:function(){
                            $('.feedback').text('Please wait for login / logout request feedback....')
                        },
                        success:function(data){
                           
                            if(data.status == '200'){
                                $('.feedback').text('');
                                $('.dialog').text(data.response_msg).dialog('open');
                            }else{
                                $('.feedback').text('');
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