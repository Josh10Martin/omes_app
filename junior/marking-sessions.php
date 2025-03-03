
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
                    <h4 class="page-title">SESSIONS</h4>
                </div>
                <div class="col-xs-6">
                    <a href="javascript:void(0)" data-toggle="modal" data-target="#add-marking-center" class="btn bg-light btn-sm"><i class="fa fa-plus"></i> Add Session</a>
                </div>
    
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
            
            <div class="dialog2"></div>
            <div class="dialog3"></div>
            <div class="table-responsive">
            <table class="table custom-table table-bordered">
                <thead >
                    <th>YEAR</th>
                    <th>DESCRIPTION</th>
                    <th>LEVEL</th>
                    <th>ACTION</th> 
                </thead>
                <tbody>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="text-right">
                            <div class="dropdown dropdown-action">
                                <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a class="dropdown-item edit" href="javascript:void(0)" data-toggle="modal" data-target="#add-marking-center"> <i class="fa fa-pencil m-r-5 blue-ecz"></i> Update</a>
                                    <a class="dropdown-item delete" href="javascript:void(0)" data-toggle="modal" data-target="#delete_center"><i class="fa fa-trash-o m-r-5 red-ecz"></i> Delete</a>
                                </div>
                            </div>
                        </td>
                    </tr>
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
            <div class="modal-body text-center"> -->
                <!-- <img src="assets/img/sent.png" alt="" width="50" height="46"> -->
                <!-- <h3>Are you sure want to delete this Session?</h3>
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
                <div class="dialog"></div>
                <div class="dialog1"></div>
                <div class="dialog4"></div>
            <form action="" method="post" id="marking_session">
            <div class="modal-header p-2 bg-success ">
                <div class="modal-title text-white h5 text-center">Update Session</div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            
            <div class="row">
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>YEAR:</label>

                            <select name="session_code" class="select" id="" required> 
                            <option value="" selected>select...</option>
                            <?php
                            $year = date('Y');
                            for($i=$year-2;$i<=$year+1;$i++){
                            ?>
                            <option value="<?php echo $i; ?>" ><?php echo $i; ?></option>

                            <?php
                            }
                            ?>
                            </select>
                            
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="type">SELECT LEVEL</label>
                        <select name="type" class="select" id="" required> 
                            <option value="" selected>select...</option>
                            <option value="I" >Grade 9 Internal</option>
                            <option value="E" >Grade 9 External</option>
                        </select>
                    </div>
                    
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>DESCRIPTION:</label>
                            <input type="text" name="description" class="form-control" value="JUNIOR SECONDARY SCHOOL LEAVING EXAMINATION" readonly required>
                        </div>
                    </div>
                   
                </div>
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary mr-auto" data-dismiss="modal">Close</button>
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
    get_session();
    edit();
    $('.dialog').dialog({
        title: 'REQUEST RESPONSE',
        width: '450',
        height: '150',
        modal: true,
        draggable: false,
        resizable: false,
        closeOnEscape: false,
        appendTo: '#marking_session',
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
        appendTo: '#marking_session',
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
                    remove_session();
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
        // appendTo: '#marking_session',
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
                    remove_session();
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
        // appendTo: '#marking_session',
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
            //         remove_session();
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
        appendTo: '#marking_session',
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
                    location.href="../php/logout.php";
                    $(this).dialog('close');
                }
            }
        ]
    });

    $('#marking_session').submit(function(e){
        e.preventDefault();
        var code = $('input[type=text][name=session_code]').val(),
            description = $('input[type=text][name=description]').val(),
            type = $('select[name=type]').val() == 'I' ? 'GRADE 9 INTERNAL' : 'GRADE 9 EXTERNAL';
        $.ajax({
            url: 'php/update_session.php',
            method: 'POST',
            data: $('#marking_session').serialize(),
            dataType: 'json',
            beforeSend: function(){
                $('button[id=save]').attr('disabled',true).addClass('bg_att');
                $('button').attr('disabled',true);
                 $('img.loading').css('display','block');
            },
            success: function(data){
                if(data.status == '200'){
                    $('table.table tbody tr').find('td:nth-child(1)').text(data.code);
                    $('table.table tbody tr').find('td:nth-child(2)').text(description);
                    $('table.table tbody tr').find('td:nth-child(3)').text(type);

                    $('button[id=save]').attr('disabled',false).removeClass('bg_att');
                    $('button').attr('disabled',false);
                    $('img.loading').css('display','none');
                    $('#marking_session').trigger('reset');
                    $('.dialog4').text(data.response_msg+' You will need to log out and log in again').dialog('open');
                    

                }else{
                    $('button[id=save]').attr('disabled',false).removeClass('bg_att');
                    $('button').attr('disabled',false);
                    $('img.loading').css('display','none');
                    $('.dialog').text(data.response_msg).dialog('open');
                }
            }
        });
    });

    function get_session(){
        $.ajax({
            url: 'php/get_session.php',
            method: 'POST',
            dataType: 'json',
            success: function(data){
                // $('table.table tbody tr').remove();
                if(data.status == '400'){
                    $('table.table tbody td').text('not set');
                }else{
                    $('table.table tbody tr').find('td:nth-child(1)').text(data.code);
                    $('table.table tbody tr').find('td:nth-child(2)').text(data.description);
                    $('table.table tbody tr').find('td:nth-child(3)').text(data.type);
                }
            }
        });
    }
    function edit(){
        $('a.edit').click(function(){
            var code = $('table.table tbody tr').find('td:nth-child(1)').text(),
                description = $('table.table tbody tr').find('td:nth-child(2)').text(),
                type = $('table.table tbody tr').find('td:nth-child(3)').text();

            // $('input[type=text][name=session_code]').val(code);
            // $('input[type=text][name=description]').val(description);
        });
    }
    $('a.delete').click(function(){
       
        $('.dialog2').text('Are you sure you wanr to remove session?').dialog('open');
    });
    function remove_session(){
        $.ajax({
            url: 'php/remove_session.php',
            method: 'POST',
            dataType: 'json',
            success: function(data){
                if(data.status == '400'){
                    $('.dialog3').text(data.response_msg).dialog('open');
                }else{
                    $('table.table tbody tr').find('td:nth-child(1)').text(''),
                    $('table.table tbody tr').find('td:nth-child(2)').text(''),
                    $('table.table tbody tr').find('td:nth-child(3)').text('');
                    location.reload();
                }
            }
        });
    }
    });
</script>
<?php
}else{
    header('location:../');
}
?>


</html>