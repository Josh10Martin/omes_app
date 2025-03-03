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
                <h4 class="page-title">DATA ENTRY OPERATORS</h4>
            </div>
            <div class="col-xs-6">
                <a href="javascript:void(0)" data-toggle="modal" data-target="#add-admin" class="btn bg-light btn-sm"><i class="fa fa-user-plus"></i> Add User</a>
            </div>

        </div>

        <div class="row">
            <div class="col-sm-4">
                <div class="form-group">
                  <!-- <label for="">search:</label> -->
                  <input type="text" id="search" class="form-control" placeholder="search" >
                </div>
            </div>
            <br>
        </div>
        

        <div class="table-responsive">
        <table class="table custom-table table-bordered" id="table">
            <thead>
                <th>USERNAME</th>
                <th>OTHER NAME(S)</th>
                <th>SURNAME</th>
                <th>MARKING CENTRE</th>
                <th>USER TYPE</th>
                <th>EMAIL</th>
                <th>ACTIVATION STATUS</th>
                <th>ACTION</th>
            </thead>
            <tbody>
                <!-- <tr>
                    <td>admin</td>
                    <td>CLEMENT</td>
                    <td>KAULA</td>
                    <td>KABULONGA GIRLS</td>
                    <td>email-emailclementkaula@email.com</td>
                    <td class="text-right">
                        <div class="dropdown dropdown-action">
                            <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a class="dropdown-item" href="javascript:void(0)" ><i class="fa fa-pencil m-r-5 blue-ecz"></i> Edit</a>
                                <a class="dropdown-item" href="javascript:void(0)" data-toggle="modal" data-target="#delete_admin"><i class="fa fa-trash-o m-r-5 red-ecz"></i> Delete</a>
                                <a class="dropdown-item" href="javascript:void(0)" data-toggle="modal" data-target="delete_admin"><i class="fa fa-ban fa-fw red-ecz"></i> De Activate</a>
                            </div>
                        </div>
                    </td>
                </tr> -->
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
        <form action="" method="post" id="add_admin">
        <div class="modal-header p-2 bg-success ">
            <div class="modal-title text-white h5 text-center">New User</div>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
        
        <div class="row">
                
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Username:</label>
                        <input type="text" name="username" class="form-control" pattern="[a-zA-Z0-9]+" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Email:</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                </div>
            </div>
            <div class="row">
                
                <div class="col-md-6">
                    <div class="form-group">
                        <label>First Name:</label>
                        <input type="text" name="first_name" class="form-control"  oninput="this.value = this.value.toUpperCase()" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Last Name</label>
                        <input type="text" name="last_name" class="form-control"  oninput="this.value = this.value.toUpperCase()" required>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                    <label >User Type:</label>
                    <select name="user_type" id="" class="select" style="width: 100%;" required>
                    <!-- <option value="">Choose user type</option>   -->
                    <!-- <option value="ADMIN" selected>SYSTEM ADMIN</option> -->
                      <option value="DEO" selected>DATA ENTRY OPERATOR</option>
                    </select>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                    <label >MARKING CENTRE:</label>
                    <select name="marking_centre" id="" class="select" style="width: 100%;" required>
                      
                    </select>
                    </div>
                </div>
            </div>
            <input type="hidden" name="activation_status" value="NOT ACTIVE">
      
        
        </div>
        <div class="modal-footer">
            <button type="button" id="button_close" class="btn btn-secondary mr-auto" data-dismiss="modal">Close</button>
            <img class="loading" src="../images/loading.gif" style="transform: translateX(100%); display:none;"/>
            <button type="submit" id="save" class="btn btn-primary float-right">Save</button>
        </div>
        </form>
        </div>
    </div>
    </div>

    <!-- <div id="delete_admin" class="modal fade delete-modal" role="dialog">
			<div class="modal-dialog modal-dialog-centered">
				<div class="modal-content">
					<div class="modal-body text-center">
						
						<h3>Are you sure want to delete this Admin User?</h3>
						<div class="m-t-20"> <a href="#" class="btn  btn-white" data-dismiss="modal">Close</a>
							<button type="submit" class="btn  btn-danger">Delete</button>
						</div>
					</div>
				</div>
			</div>
		</div> -->

</div> <!--End page wrapper-->

<div class="sidebar-overlay" data-reff=""></div>
</div>	
<?php include 'includes/scripts.php' ?>
</body>

<script type = "text/javascript">
$(document).ready(function(){
    $('.dialog').dialog({
        title: 'REQUEST RESPONSE',
        width: '450',
        height: '150',
        modal: true,
        draggable: false,
        resizable: false,
        closeOnEscape: false,
        appendTo: '#add-admin',
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
    $('.dialog5').dialog({
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
                text: 'OK',
                click: function(){
                    $(this).dialog('close');
                }
            }
            // {
            //     text: 'YES',
            //     click: function(){
            //         var id = $('.dialog4').data('id');
            //         delete_admin(id);
            //         $(this).dialog('close');
            //     }
            // }
        ]
    });
    $('.dialog6').dialog({
        title: 'REQUEST RESPONSE',
        width: '450',
        height: '150',
        modal: true,
        draggable: false,
        resizable: false,
        closeOnEscape: false,
        appendTo: '#add-admin',
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
            //         var id = $('.dialog4').data('id');
            //         delete_admin(id);
            //         $(this).dialog('close');
            //     }
            // }
        ]
    });
    $.ajax({
        url: 'php/get_admin.php',
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
                    
            var activation = this["activation_status"] == 'NOT ACTIVE' ? 'Activate' : 'De Activate';
                    
            $('table#table tbody').append('<tr class="'+this["username"]+'">'+
                    '<td id="'+this["username"]+'">'+this["username"]+'</td>'+
                    '<td>'+this["first_name"]+'</td>'+
                    '<td>'+this["last_name"]+'</td>'+
                    '<td>'+this["marking_centre_name"]+'</td>'+
                    '<td>'+this["user_type"]+'</td>'+
                    '<td><a href="mailto:'+this["email"]+'&subject=Message from Examinations Council of Zambia">'+this["email"]+'</a></td>'+
                    '<td>'+this["activation_status"]+'</td>'+
                    '<td class="text-right">'+
                        '<div class="dropdown dropdown-action">'+
                            '<a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>'+
                            '<div class="dropdown-menu dropdown-menu-right">'+
                                '<a class="dropdown-item delete" href="javascript:void(0)" data-id="'+this["username"]+'" data-toggle="modal" data-target="delete_admin"><i class="fa fa-trash-o m-r-5 red-ecz"></i> Delete</a>'+
                                '<a id="'+this["username"]+'" class="dropdown-item '+this["activation_status"]+' dea_activate" href="#" data-id="'+this["username"]+'" data-toggle="modal" data-target="delete_admin"><i class="fa fa-ban fa-fw red-ecz"></i> '+activation+'</a>'+
                            '</div>'+
                        '</div>'+
                    '</td>'+
                    '</tr>');
                });
                $('a.dea_activate').click(function(){
                    var stat_val = $(this).attr('class').split(' '),
                    id = $(this).attr('id'),
                    state = stat_val[1];
                   
                    status = state == 'NOT' ? 'Activate' : 'De Activate';
                    $('.dialog2').text('Are you sure you want to '+status+' user?').data('id',id).dialog('open');

                });
              delete_user();
              $('table#table tbody tr.undefined').remove();
            }
        }
    });
   $('#add_admin').submit(function(e){
        e.preventDefault();
        var username = $('input[type=text][name=username]').val(),
         first_name = $('input[type=text][name=first_name]').val(),
         last_name = $('input[type=text][name=last_name]').val(),
         marking_centre = $('select[name=marking_centre]').val().split(':'),
         marking_centre_code = marking_centre[0],
         marking_centre_name = marking_centre[1],
         email = $('input[type=email][name=email]').val(),
         activation_status = $('input[type=hidden][name=activation_status]').val();
        $.ajax({
            url: 'php/add_admin.php',
            method: 'POST',
            data: $('#add_admin').serialize(),
            dataType: 'json',
            beforeSend: function(){
                $('button[id=button_close]').attr('disabled',true);
                $('button[id=save]').attr('disabled',true);
                $('button[id=save]').addClass('bg_att');
                $('img.loading').css('display','block');
            },
            success:function(data){
              
                if(data.status == '200'){
                      $('#add_admin').trigger('reset');
                      var activation = activation_status == 'NOT ACTIVE' ? 'Activate' : 'De Activate';

                $('table#table tbody').prepend('<tr class="'+data.username+'">'+
                    '<td id="'+data.username+'">'+data.username+'</td>'+
                    '<td>'+data.first_name+'</td>'+
                    '<td>'+data.last_name+'</td>'+
                    '<td>'+data.marking_centre_name+'</td>'+
                    '<td>'+data.user_type+'</td>'+
                    '<td><a href="mailto:'+data.email+'&subject=Message from Examinations Council of Zambia">'+data.email+'</a></td>'+
                    '<td>'+data.activation_status+'</td>'+
                    '<td class="text-right">'+
                        '<div class="dropdown dropdown-action">'+
                            '<a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>'+
                            '<div class="dropdown-menu dropdown-menu-right">'+
                                '<a class="dropdown-item" href="javascript:void(0)" ><i class="fa fa-pencil m-r-5 blue-ecz"></i> Edit</a>'+
                                '<a class="dropdown-item delete" href="javascript:void(0)" data-id="'+username+'" data-toggle="modal" data-target="delete_admin">><i class="fa fa-trash-o m-r-5 red-ecz"></i> Delete</a>'+
                                '<a id="'+data.username+'" class="dropdown-item '+activation_status+' dea_activate" href="javascript:void(0)" data-id="'+data.username+'" data-toggle="modal" data-target="delete_admin"><i class="fa fa-ban fa-fw red-ecz"></i> '+activation+'</a>'+
                            '</div>'+
                        '</div>'+
                    '</td>'+
                    '</tr>');

                    $('a.dea_activate').click(function(){
                    var stat_val = $(this).attr('class').split(' '),
                    id = $(this).attr('id'),
                    state = stat_val[1];
                    status = state == 'NOT' ? 'Activate' : 'De Activate';
                    $('.dialog2').text('Are you sure you want to '+status+' user?').data('id',id).dialog('open');

                });

              delete_user();
              $('table#table tbody td').parent('tr.null').remove();
                    
                       
                    
                        send_admin_email(data.username,data.email,data.first_name,data.last_name,data.marking_centre_name,data.password,data.user_type);
                    
                    
                   
                 
                }else{
                    $('button[id=save]').removeClass('bg_att');
                    $('.dialog').text(data.response_msg).dialog('open');
                    $('img.loading').css('display','none');
                    $('button').attr('disabled',false);
                }
            }
        });
   });
   function send_admin_email(username,email,first_name,last_name,marking_centre_name,password,user_type){
    $.ajax({
        // url: 'php/send_admin_email.php',
        url: 'https://verify.exams-council.org.zm/orvs/send_admin_email.php',
        method: 'POST',
        data: {username:username,email:email,first_name:first_name,last_name:last_name,marking_centre_name:marking_centre_name,password:password,user_type:user_type},
        dataType: 'json',
        success: function(data){
            if(data.status == '200'){
                $('.dialog6').text(data.response_msg).dialog('open');
                    $('button[id=save]').removeClass('bg_att');
                    $('img.loading').css('display','none');
                    $('button').attr('disabled',false);
            }else{
                    $('.dialog6').text(data.response_msg).dialog('open');
                    $('button[id=save]').removeClass('bg_att');
                    $('img.loading').css('display','none');
                    $('button').attr('disabled',false);
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
                        url: 'php/change_admin_status.php',
                        method: 'POST',
                        data: {username:id},
                        dataType:'json',
                        success:function(data){
                            if(data.status == '400'){
                                $('.dialog3').text(data.response_msg).dialog('open');
                            }else{
                              var status3 = data.activation_value == '1' ? 'De Activate' : 'Activate';
                                
                                // $('.dialog2').text(data.response_msg).dialog('open');
                                // $('table.table tbody td[id='+id+']').next().next().next().next().text(status);
                               $('a[id='+username+']').html('<i class="fa fa-ban fa-fw red-ecz"></i> '+status3);
                                location.reload();
                            }
                        }
                    });
                }
        function delete_user(){
            $('a.delete').click(function(){
                
                id = $(this).data('id');
                
                $('.dialog4').text('Are you sure you want to delete user?').data('id',id).dialog('open');

            });
        }
        function delete_admin(id){
        $.ajax({
            url: 'php/delete_admin.php',
            method: 'POST',
            data: {username:id},
            dataType: 'json',
            success: function(data){
                if(data.status == '400'){
                   
                    $('.dialog5').text(data.response_msg).dialog('open');
                }else{
                   $('table#table tbody td[id='+id+']').parent('tr').remove();
                }
            }
        });
    }

    $.ajax({
        url: 'php/get_marking_centres.php',
        method: 'POST',
        dadaType: 'json',
        success:function(data){
            $('select[name=marking_centre] option').remove();
            $.each(data,function(){
                $('select[name=marking_centre]').append(
                    '<option value="'+this["centre_code"]+':'+this["centre_name"]+'">'+this["centre_code"]+' - '+this["centre_name"]+'</option>'
                );
            });
            
            $('select[name=marking_centre] option[value=undefined]').remove();
            $('select[name=marking_centre]').select2({
              data:data
            });
        }
    });
});
</script>
<?php
   }else{
    header('location: ../');
   }
?>
</html>