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
                <h4 class="page-title">SESO / ECZ USERS</h4>
            </div>
            <div class="col-xs-6">
                
                <a href="javascript:void(0)" data-toggle="modal" data-target="#add-admin" class="btn bg-light btn-sm"><i class="fa fa-user-plus"></i> Add SESO / ECZ user</a>
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
        </div>
        

        <div class="table-responsive">
            <div class="dialog2"></div>
            <div class="dialog3"></div>
            <div class="dialog4"></div>
            <div class="dialog5"></div>
            <div class="dialog6"></div>
            <div class="dialog7"></div>
        <table class="table custom-table table-bordered" >
            <thead>
                <th>USERNAME</th>
                <th>SURNAME</th>
                <th>OTHER NAME(S)</th>
                <th>PROVINCE</th>
                <th> EMAIL</th>
                <th>ACTIVATION STATUS</th>
                <th>ACTION</th>
            </thead>
            <tbody id="table">
                <!-- <tr>
                    <td>admin</td>
                    <td>MAAMBO</td>
                    <td>MOONGA</td>
                    <td> LIVINGSTONE</td>
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
    <div class="modal fade" id="edit_seso" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
    <form id="edit_seso" action="" >
        
        <div class="modal-content">
        <div class="modal-header p-2 bg-success ">
            <div class="modal-title text-white h5 text-center">UPDATE SESO USER</div>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        
        <div class="modal-body">
        
        <div class="row">
                
        <div class="dialog"></div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Username:</label>
                        <input type="text" name="username" class="form-control" required>
                    </div>
                    <input type="hidden" name="user_name">
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
                        <label>Other Name(s)</label>
                        <input type="text" name="last_name" class="form-control"  oninput="this.value = this.value.toUpperCase()" required>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                    <label >Province:</label>
                    <select name="province" id="" class="form-control" required>
                       
                    </select>
                    </div>
                </div>
            </div>
    
        
        </div>
       <!-- <input type="hidden" name="activation_status" value="NOT ACTIVE">
       <input type="hidden" name="user_type" value="SESO"> -->
        <div class="modal-footer">
            <button type="button" id="button_close" class="btn btn-secondary mr-auto" data-dismiss="modal">Close</button>
            <img class="loading" src="../images/loading.gif" style="transform: translateX(100%); display:none;"/>
            <button id="save" type="submit" class="btn btn-primary float-right">Save</button>
        </div>
        </form>
        </div>
    </div>
    </div>

    <div class="modal fade" id="add-admin" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
    <form id="add_seso_form" action="" method="post">
        <div class="modal-content">
        <div class="modal-header p-2 bg-success ">
            <div class="modal-title text-white h5 text-center">New SESO User</div>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        
        <div class="modal-body">
        
        <div class="row">
                
        <div class="dialog"></div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Username:</label>
                        <input type="text" name="username" class="form-control" required>
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
                        <label>Other Name(s)</label>
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
                    <label >Province:</label>
                    <!-- <select name="province" class="select" required>
                       
                    </select> -->
                    <select name="province" id="" class="select" style="width: 100%;" required>
                    </select>
                    </div>
                </div>
            </div>
    
        
        </div>
       <input type="hidden" name="activation_status" value="NOT ACTIVE">
       <input type="hidden" name="user_type" value="SESO">
        <div class="modal-footer">
            <button type="button" id="button_close" class="btn btn-secondary mr-auto" data-dismiss="modal">Close</button>
            <img class="loading" src="../images/loading.gif" style="transform: translateX(100%); display:none;"/>
            <button id="save" type="submit" class="btn btn-primary float-right">Save</button>
        </div>
        </form>
        </div>
    </div>
    </div>

    <div id="delete_admin" class="modal fade delete-modal" role="dialog">
			<div class="modal-dialog modal-dialog-centered">
				<div class="modal-content">
					<div class="modal-body text-center">
						<!-- <img src="assets/img/sent.png" alt="" width="50" height="46"> -->
						<h3>Are you sure want to delete this SESO User?</h3>
						<div class="m-t-20"> <a href="#" class="btn  btn-white" data-dismiss="modal">Close</a>
							<button type="submit" class="btn  btn-danger">Delete</button>
						</div>
					</div>
				</div>
			</div>
		</div>

</div> <!--End page wrapper-->

<div class="sidebar-overlay" data-reff=""></div>
</div>	
<?php include 'includes/scripts.php' ?>

</body>
<script type="text/javascript">

$(document).ready(function(){
    update_seso_details();
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
                    location.reload();
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

    $('.dialog3').dialog({
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
            // {
            //     text: 'NO',
            //     click: function(){
            //         $(this).dialog('close');
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
                    delete_seso(id);
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
        // appendTo: '#add-admin',
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
                    location.reload();
                    $(this).dialog('close');
                }
            }
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
        appendTo: '#edit_seso',
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
                }
            }
        ]
    });
    $('.dialog7').dialog({
        title: 'REQUEST RESPONSE',
        width: '450',
        height: '150',
        modal: true,
        draggable: false,
        resizable: false,
        closeOnEscape: false,
        appendTo: '#edit_seso',
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
                    location.reload();
                    $(this).dialog('close');
                }
            }
        ]
    });

    $.ajax({
        url: 'php/get_sesos.php',
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
                    display = this["province"] == 'NOT APPLICABLE' ? 'd-none' : 'd-block';
                    $('table.table tbody#table').append('<tr class="'+this["username"]+'">'+
                    '<td id="'+this["username"]+'">'+this["username"]+'</td>'+
                    '<td>'+this["last_name"]+'</td>'+
                    '<td>'+this["first_name"]+'</td>'+
                    '<td>'+this["province"]+'</td>'+
                    '<td><a href="mailto:'+this["email"]+'&subject=Message from Examinations Council of Zambia">'+this["email"]+'</a></td>'+
                    '<td>'+this["activation_status"]+'</td>'+
                    '<td class="text-right">'+
                        '<div class="dropdown dropdown-action">'+
                            '<a href="#" class="action-icon dropdown-toggle '+display+'" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>'+
                            '<div class="dropdown-menu dropdown-menu-right">'+
                                '<a class="dropdown-item edit_seso" href="javascript:void(0)"  data-toggle="modal" data-target="#edit_seso" ><i class="fa fa-pencil m-r-5 blue-ecz"></i> Edit</a>'+
                                '<a class="dropdown-item delete" href="javascript:void(0)" data-id="'+this["username"]+'" data-toggle="modal" data-target="delete_admin"><i class="fa fa-trash-o m-r-5 red-ecz"></i> Delete</a>'+
                                '<a id="'+this["username"]+'" class="dropdown-item '+this["activation_status"]+' dea_activate" href="#" data-id="'+this["username"]+'" data-toggle="modal" data-target="delete_admin"><i class="fa fa-ban fa-fw red-ecz"></i> '+activation+'</a>'+
                            '</div>'+
                        '</div>'+
                    '</td>'+
                    '</tr>');
                   
                });
               click_edit();
                $('table.table tbody#table tr.undefined').remove();
               
                $('a.dea_activate').click(function(){
                    var stat_val = $(this).attr('class').split(' '),
                    id = $(this).attr('id'),
                    state = stat_val[1];
                    status = state == 'NOT' ? 'Activate' : 'De Activate';
                    $('.dialog2').text('Are you sure you want to '+status+' SESO?').data('id',id).dialog('open');

                });
                $('a.delete').click(function(){
                
                    id = $(this).data('id');
                    
                    $('.dialog4').text('Are you sure you want to delete this SESO?').data('id',id).dialog('open');

                });
              
                $('table.table tbody#table td').each(function(){
                    var currentTd = $(this).html();
                     if(currentTd == 'undefined'){
                        $(this).parent('tr.undefined').remove();
                     }
                });
               
            }
        }
    });
    function click_edit(){
        $('a.edit_seso').click(function(){
                var username = $(this).closest('tr').find('td:nth-child(1)').html(),
                    first_name = $(this).closest('tr').find('td:nth-child(3)').html(),
                    last_name = $(this).closest('tr').find('td:nth-child(2)').html();
                    email = $(this).closest('tr').find('td:nth-child(5)').text(),
                    // email = email1.attr('href').replace('mailto:','');
                $('input[type=text][name=username]').attr('readonly',true).val(username);
                $('input[type=email][name=email]').attr('readonly',true).val(email);
                $('input[type=text][name=first_name]').val(first_name);
                $('input[type=text][name=last_name]').val(last_name);
                
            });
    }
    function change_status(id){
                    var state = $('table.table tbody#table td[id='+id+']').next().next().next().next().html(),
                    status = state == 'ACTIVE' ? 'NOT ACTIVE' : 'ACTIVE',
                    state2 = $('a[id='+id+']').text(),
                    status2 = state2 == 'Activate' ? 'De Activate' : 'Activate',
                    username = $('table.table tbody#table td[id='+id+']').html();
                    $.ajax({
                        url: 'php/change_status.php',
                        method: 'POST',
                        data: {username:id},
                        dataType:'json',
                        success:function(data){
                            if(data.status == '400'){
                                $('.dialog3').text(data.response_msg).dialog('open');
                            }else{
                                var status3 = data.activation_value == '1' ? 'De Activate' : 'Activate';
                                // $('.dialog2').text(data.response_msg).dialog('open');
                                $('table.table tbody#table td[id='+id+']').next().next().next().next().next().text(status);
                               $('a[id='+username+']').html('<i class="fa fa-ban fa-fw red-ecz"></i> '+status3);
                               location.reload();

                            }
                        }
                    });
                }
    
    function delete_seso(id){
        $.ajax({
            url: 'php/delete_seso.php',
            method: 'POST',
            data: {username:id},
            dataType: 'json',
            success: function(data){
                if(data.status == '400'){
                   
                    $('.dialog5').text(data.response_msg).dialog('open');
                }else{
                   $('table.table tbody#table td[id='+id+']').parent('tr').remove();
                }
            }
        });
    }

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

    $('#add_seso_form').submit(function(e){
        e.preventDefault();
      
        var username = $('input[type=text][name=username]').val(),
         first_name = $('input[type=text][name=first_name]').val(),
         last_name = $('input[type=text][name=last_name]').val(),
         province = $('select[name=province] option').val().split(':'),
         province_name = province[1],
         province_code = province[0],
         email = $('input[type=email][name=email]').val(),
         activation_status = $('input[type=hidden][name=activation_status]').val();

        $.ajax({
            url: 'php/add_seso.php',
            method: 'POST',
            data: $('#add_seso_form').serialize(),
            dataType: 'json',
            beforeSend:function(){
                $('button[id=button_close]').attr('disabled',true);
                $('button[id=save]').attr('disabled',true);
                $('button[id=save]').addClass('bg_att');
                $('img.loading').css('display','block');
            },
            success:function(data){
                // $('button[id=save]').text('Save');
                if(data.status == '200'){
                    $('#add_seso_form').trigger('reset');
                    // $('.dialog').text(data.response_msg).dialog('open');
                    var activation = activation_status == 'NOT ACTIVE' ? 'Activate' : 'De Activate';
                $('table.table tbody#table').append('<tr class="'+username+'">'+
                    '<td id="'+username+'">'+username+'</td>'+
                    '<td>'+first_name+'</td>'+
                    '<td>'+last_name+'</td>'+
                    '<td>'+province_name+'</td>'+
                    '<td><a href="mailto:'+email+'&subject=Message from Examinations Council of Zambia">'+email+'</a></td>'+
                    '<td>'+activation_status+'</td>'+
                    '<td class="text-right">'+
                        '<div class="dropdown dropdown-action">'+
                            '<a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>'+
                            '<div class="dropdown-menu dropdown-menu-right">'+
                                '<a class="dropdown-item edit_seso" href="javascript:void(0)" ><i class="fa fa-pencil m-r-5 blue-ecz"></i> Edit</a>'+
                                '<a class="dropdown-item delete" href="javascript:void(0)" data-id="'+username+'" data-toggle="modal" data-target="delete_admin">><i class="fa fa-trash-o m-r-5 red-ecz"></i> Delete</a>'+
                                '<a id="'+username+'" class="dropdown-item '+activation_status+' dea_activate" href="#" data-id="'+username+'" data-toggle="modal" data-target="delete_admin"><i class="fa fa-ban fa-fw red-ecz"></i> '+activation+'</a>'+
                            '</div>'+
                        '</div>'+
                    '</td>'+
                    '</tr>');
                click_edit();
                    $('a.dea_activate').click(function(){
                    var stat_val = $(this).attr('class').split(' '),
                    id = $(this).attr('id'),
                    state = stat_val[1];
                    status = state == 'NOT' ? 'Activate' : 'De Activate';
                    $('.dialog2').text('Are you sure you want to '+status+' SESO?').data('id',id).dialog('open');

                });

                $('a.delete').click(function(){
                
                    id = $(this).data('id');
                    
                    $('.dialog4').text('Are you sure you want to delete SESO?').data('id',id).dialog('open');

                });

                    $('table.table tbody#table td').parent('tr.null').remove();
                   send_seso_email(data.email,data.username,data.password,data.first_name,data.last_name,data.user_type);                    
                }else{
                    $('button[id=save]').removeClass('bg_att');
                    $('.dialog').text(data.response_msg).dialog('open');
                    $('img.loading').css('display','none');
                    $('button').attr('disabled',false);
                }
            }
            
        });
        function send_seso_email(email,username,password,first_name,last_name,user_type){
            $.ajax({
                //  url: 'php/send_seso_email.php',
		        url: 'https://verify.exams-council.org.zm/orvs/send_seso_email.php',
                method: 'POST',
                data: {email:email,username:username,password:password,first_name:first_name,last_name:last_name,user_type:user_type},
                dataType: 'json',
                success:function(data){
                    // $('button[id=save]').text('Save');
                    if(data.status == '200'){
                        $('.dialog').text(data.response_msg).dialog('open');
                        $('button[id=save]').removeClass('bg_att');
                        $('img.loading').css('display','none');
                        $('button').attr('disabled',false);
                    }else{
                        $('.dialog').text(data.response_msg).dialog('open');
                        $('button[id=save]').removeClass('bg_att');
                        $('img.loading').css('display','none');
                        $('button').attr('disabled',false);
                    }
                }
            });
        }

        
    });
    function update_seso_details(){
           $('#edit_seso').submit(function(e){
            var username = $('input[type=text][name=username]').val();
            var first_name = $('input[type=text][name=first_name]').val();
            var last_name = $('input[type=text][name=last_name]').val();
            var province = $('select[name=province]').val().split(':');
            var province_code = province[0];
            e.preventDefault();
            $.ajax({
                url: 'php/edit_seso.php',
                method: 'POST',
                data: {username:username,first_name:first_name,last_name:last_name,province:province_code},
                dataType: 'json',
                beforeSend:function(data){
                    $('button[id=button_close]').attr('disabled',true);
                    $('button[id=save]').attr('disabled',true);
                    $('button[id=save]').addClass('bg_att');
                    $('img.loading').css('display','block');
                },
                success: function(data){
                    if(data.status == '200'){
                        $('.dialog7').text(data.response_msg).dialog('open');
                    }else{
                        $('button[id=button_close]').attr('disabled',false);
                        $('button[id=save]').attr('disabled',false);
                        $('button[id=save]').removeClass('bg_att');
                        $('img.loading').css('display','none');
                        $('.dialog6').text(data.response_msg).dialog('open');
                    }
                }
            });
           });
        }
});

</script>


</html>