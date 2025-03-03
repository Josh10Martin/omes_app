<?php
session_start();

?>
<!DOCTYPE html>
<html lang="en">



<?php include 'includes/header.php';
if($_SESSION['user_type']  == 'SESO'){
    if(isset($_GET['marking_centre_code']) && isset($_GET['marking_centre_name'])){
        $marking_centre_code = $_GET['marking_centre_code'];
        $marking_centre_name = $_GET['marking_centre_name'];
?>
<body>
    <style>
        .form-check{
            padding: 5rem !important; 
        }
    </style>
<div class="main-wrapper">

    <?php include 'includes/navbar.php'?>     
    <?php include 'includes/sidebar.php'?>
<div class="page-wrapper">
    <div class="content">
        <div class="row justify-content-between px-2">
            <div class="col-xs-6">
                <h4 class="page-title">MARKING CENTRE APPORTIONMENT</h4>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-light row justify-content-between p-1">
                    <div class="col-md-6">
                    <div class=""> MARKING CENTRE: <span><?php echo $marking_centre_name; ?></span></div>
                    </div>
                    <div class="col-md-6">
                        <div class="row align-items-center px-3">
                            <span>ACTION: </span>
                            <div class="col">
                            <select name="action" id="action" class="select">
                            <option value="add">Add Centres</option>
                            <option value="remove">Remove Centres</option>
                            </select>
                            </div>
                        </div>
                    </div>
                    
                </div>
                <div class="card-body">
            <div class="dialog"></div>
            <div class="dialog1"></div>
            <div class="dialog2"></div>
            <div class="dialog3"></div>
                    <form action="" id="add-center-form" class="add-centers-row" method="">
                    <div class="d-flex justify-content-between border-bottom px-5">
                        <div class=""> <strong>ADD CENTRES </strong>  </div>
                        <div> <strong>Select All <input type="checkbox" id="checkAll"></strong> </div>
                    </div>
                    
                    <div class="row">
                        <div class="add_centres row">
                        
                        <!-- <div class="col-md-3 col-sm-6">
                            <div class="d-flex align-items-center border-bottom border-primary mb-2">
                                <span class="text-center">2030 ST EDMUND'S SECONDARY SCHOOL</span>
                                <span class=""><input type="checkbox" class="form-check" name="center1" id="center1"></span>
                            </div> 
                        </div>

                        <div class="col-md-3 col-sm-6">
                            <div class="d-flex align-items-center border-bottom border-primary">
                                <span class="text-center">2030 ST EDMUND'S SECONDARY SCHOOL</span>
                                <span class=""><input type="checkbox" class="form-check" name="center1" id="center1"></span>
                            </div> 
                        </div>

                        <div class="col-md-3 col-sm-6">
                            <div class="d-flex align-items-center border-bottom border-primary">
                                <span class="text-center">2030 ST EDMUND'S SECONDARY SCHOOL</span>
                                <span class=""><input type="checkbox" class="form-check" name="center1" id="center1"></span>
                            </div> 
                        </div>

                        <div class="col-md-3 col-sm-6">
                            <div class="d-flex align-items-center border-bottom border-primary">
                                <span class="text-center">2030 ST EDMUND'S SECONDARY SCHOOL</span>
                                <span class=""><input type="checkbox" class="form-check" name="center1" id="center1"></span>
                            </div> 
                        </div>

                        <div class="col-md-3 col-sm-6 ">
                            <div class="d-flex align-items-center border-bottom border-primary">
                                <span class="text-center">2030 ST EDMUND'S SECONDARY SCHOOL</span>
                                <span class=""><input type="checkbox" class="form-check" name="center1" id="center1"></span>
                            </div> 
                        </div>

                        <div class="col-md-3 col-sm-6">
                            <div class="d-flex align-items-center border-bottom border-primary">
                                <span class="text-center">2030 ST EDMUND'S SECONDARY SCHOOL</span>
                                <span class=""><input type="checkbox" class="form-check" name="center1" id="center1"></span>
                            </div> 
                        </div>

                        <div class="col-md-3 col-sm-6">
                            <div class="d-flex align-items-center border-bottom border-primary">
                                <span class="text-center">2030 ST EDMUND'S SECONDARY SCHOOL</span>
                                <span class=""><input type="checkbox" class="form-check" name="center1" id="center1"></span>
                            </div> 
                        </div>

                        <div class="col-md-3 col-sm-6">
                            <div class="d-flex align-items-center border-bottom border-primary">
                                <span class="text-center">2030 ST EDMUND'S SECONDARY SCHOOL</span>
                                <span class=""><input type="checkbox" class="form-check" name="center1" id="center1"></span>
                            </div> 
                        </div>

                        <div class="col-md-3 col-sm-6">
                            <div class="d-flex align-items-center border-bottom border-primary">
                                <span class="text-center">2030 ST EDMUND'S SECONDARY SCHOOL</span>
                                <span class=""><input type="checkbox" class="form-check" name="center1" id="center1"></span>
                            </div> 
                        </div>

                        <div class="col-md-3 col-sm-6">
                            <div class="d-flex align-items-center border-bottom border-primary">
                                <span class="text-center">2030 ST EDMUND'S SECONDARY SCHOOL</span>
                                <span class=""><input type="checkbox" class="form-check" name="center1" id="center1"></span>
                            </div> 
                        </div>

                        <div class="col-md-3 col-sm-6">
                            <div class="d-flex align-items-center border-bottom border-primary">
                                <span class="text-center">2030 ST EDMUND'S SECONDARY SCHOOL</span>
                                <span class=""><input type="checkbox" class="form-check" name="center1" id="center1"></span>
                            </div> 
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <div class="d-flex align-items-center border-bottom border-primary">
                                <span class="text-center">2230 MAZABUKA GIRLS HIGH SCHOOL</span>
                                <span class=""><input type="checkbox" class="form-check" name="center1" id="center1"></span>
                            </div> 
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <div class="d-flex align-items-center border-bottom border-primary">
                                <span class="text-center">2030 KAONGA PRIMARY SCHOOL</span>
                                <span class=""><input type="checkbox" class="form-check" name="center1" id="center1"></span>
                            </div> 
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <div class="d-flex align-items-center border-bottom border-primary">
                                <span class="text-center">2030 ST EDMUND'S SECONDARY SCHOOL</span>
                                <span class=""><input type="checkbox" class="form-check" name="center1" id="center1"></span>
                            </div> 
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <div class="d-flex align-items-center border-bottom border-primary">
                                <span class="text-center">2030 ST EDMUND'S SECONDARY SCHOOL</span>
                                <span class=""><input type="checkbox" class="form-check" name="center1" id="center1"></span>
                            </div> 
                        </div> -->
                        <!-- end add centre div   -->
                        </div>
                        <input type="hidden" name="marking_centre_code" value="<?php echo $marking_centre_code; ?>">
                        <div class="col-sm-12">
                            <div class="row mt-2">
                            <img class="loading" src="../images/loading.gif" style="transform: translateX(100%); display:none;"/>
                                <button id="save" class="btn btn-sm btn-primary ml-auto mr-auto" type="submit">Submit</button>
                            </div>
                        </div>
                    </div>
                    </form>
                    <form  id="remove-centers-form" class="remove-centers-row d-none">
                    <div class="d-flex justify-content-between border-bottom px-5">
                        <div class=""> <strong>REMOVE CENTRES </strong>  </div>
                        <div> <strong>Remove All <input type="checkbox" id="removeAll"></strong> </div>
                    </div>
                    <div class="row ">
                        <div class="added_centres row" style="margin-bottom:30px;">
                    <!-- <div class="col-md-3 col-sm-6">
                            <div class="d-flex align-items-center border-bottom border-danger mb-2">
                                <span class="text-center">2030 ST EDMUND'S SECONDARY SCHOOL</span>
                                <span class=""><input type="checkbox" class="form-check" name="center1" id="center1"></span>
                            </div> 
                        </div> -->
                        </div>
                        <input type="hidden" name="marking_centre_code" value="<?php echo $marking_centre_code; ?>">
                        <div class="col-sm-12">
                            <div class="row mt-2">
                            <img class="loading" src="../images/loading.gif" style="transform: translateX(100%); display:none;"/>
                                <button id="save" class="btn btn-sm btn-danger ml-auto mr-auto remove" type="submit">Remove</button>
                            </div>
                        </div>
                    </div>
                    </form>
                    
                </div>
            </div>
            </div>
            
            
        </div>

        

    <?php include 'includes/notifications.php' ?>
    </div> <!--End  content-->
</div> <!--End page wrapper-->

<!--modals-->
<div class="modal fade" id="edit-subject-center" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="dialog"></div>
        <form action="" method="post" id="choose_centre">
        <div class="modal-header p-2 bg-success ">
            <div class="modal-title text-white h5 text-center">EDIT SUBJECT MARKING CENTRE</div>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
        
        <div class="row">
                
        <div class="col-md-6">
                    <div class="form-group">
                        <label>SUBJECT</label>
                        <input type="text" name="subject" class="form-control" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>PAPER:</label>
                        <input type="text" name="paper" class="form-control" required>
                    </div>
                </div>
                
            </div>
            <div class="row">
                
            <div class="col-md-12">
                    <div class="form-group">
                    <label >MARKING CENTRE:</label>
                    <select name="marking_centre" id="" class="form-control" style="width:100%;" required>
                       
                    </select>
                    </div>
            </div>
               
            </div>
            
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

<div class="sidebar-overlay" data-reff=""></div>
</div>	
<?php include 'includes/scripts.php' ?>
</body>
<script type="text/javascript">
$(document).ready(function(){
    get_schools_to_add();
    add_centres();

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
        // appendTo: '#add-admin',
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
                    $('.remove-centers-row').removeClass('d-none');
                    $('.add-centers-row').addClass('d-none');
                }
            }
        ]
    });

    // check all 
    $("#checkAll").click(function(){
    $('#add-center-form input:checkbox').not(this).prop('checked', this.checked);
    });

    // check all to remove 
    $("#removeAll").click(function(){
    $('#remove-centers-form input:checkbox').not(this).prop('checked', this.checked);
    });

    // switch action
    var action=$('#action').find(":selected").val();
    console.log("SELECTED: ",action)
    $('#action').change(function(){
        var action=$('#action').find(":selected").val();
        if (action == 'add'){
            console.log("SELECTED: ",action)
            $('.add-centers-row').removeClass('d-none')
            $('.remove-centers-row').addClass('d-none')
        }
        else if (action == 'remove'){
            console.log("SELECTED: ",action);
            $('.remove-centers-row').removeClass('d-none');
            $('.add-centers-row').addClass('d-none');
            get_schools_to_remove();
            remove_centres();
            
        }
        
    })
function get_schools_to_add(){
    $.ajax({
        url: 'php/get_schools_to_add.php',
        method: 'POST',
        dataType: 'json',
        success: function(data){
            if(data.status == '400'){
                $('.add_centres').text(data.response_msg);
            }else{
                $('.add_centres div').remove();
               $.each(data,function(){
                $('.add_centres').append('<div id="'+this["centre_code"]+'" class="col-md-3 col-sm-6">'+
                   '<div class="d-flex align-items-center border-bottom border-primary mb-2">'+
                        '<label for="'+this["centre_code"]+'" class="text-center">'+this["centre_code"]+' '+this["centre_name"]+'</label>'+
                            '<span class=""><input style="cursor:pointer;" type="checkbox" class="form-check" name="centre_code['+this["centre_code"]+']" value="'+this["centre_code"]+'" id="'+this["centre_code"]+'"></span>'+
                            '</div>'+ 
                       
                '</div>');
               });
               $('div#undefined').remove();
            }
        }
    });
}
function get_schools_to_remove(){
    $.ajax({
        url: 'php/get_schools_to_romove.php',
        method: 'POST',
        dataType: 'json',
        success: function(data){
            if(data.status == '400'){
                $('.added_centres').text(data.response_msg);
            }else{
                $('.added_centres div').remove();
               $.each(data,function(){
                $('.added_centres').append('<div id="'+this["centre_code"]+'" class="col-md-3 col-sm-6">'+
                   '<div class="d-flex align-items-center border-bottom border-primary mb-2">'+
                        '<label for="'+this["centre_code"]+'" class="text-center">'+this["centre_code"]+' '+this["centre_name"]+'</label>'+
                            '<span class=""><input style="cursor:pointer;" type="checkbox" class="form-check" name="centre_code['+this["centre_code"]+']" value="'+this["centre_code"]+'" id="'+this["centre_code"]+'"></span>'+
                            '</div>'+ 
                       
                '</div>');
               });
               $('div#undefined').remove();
            }
        }
    });
}
function add_centres(){
    $('#add-center-form').submit(function(e){
        e.preventDefault();
        if($('input[type=checkbox]:checked').length > 0){
            $.ajax({
                url: 'php/add_centres_to_marking_centre.php',
                method:'POST',
                data: $('#add-center-form').serialize(),
                dataType: 'json',
                beforeSend:function(){
                    $('button[id=save]').attr('disabled',true).addClass('bg_att');
                    $('img.loading').css('display','block');
                },
                success:function(data){
                    if(data.status == '200'){
                            $('.dialog1').text(data.response_msg).dialog('open');
                            $('#add-center-form').trigger('reset');
                            $('button[id=save]').attr('disabled',false).removeClass('bg_att');
                            $('img.loading').css('display','none');
                        
                    }else{
                        $('.dialog').text(data.response_msg).dialog('open');
                        $('button[id=save]').attr('disabled',false).removeClass('bg_att');
                        $('img.loading').css('display','none');
                    }
                }
            });

        }else{
            $('.dialog').text('CHoose centres you want to add to marking centres').dialog('open');
        }
    });
}

function remove_centres(){
    $('#remove-centers-form').submit(function(e){
        e.preventDefault();
    //    alert('hi');
        if($('input[type=checkbox]:checked').length > 0){
            $.ajax({
                url: 'php/remove_centres_from_marking_centre.php',
                method:'POST',
                data: $('#remove-centers-form').serialize(),
                dataType: 'json',
                beforeSend:function(){
                    $('button[id=save]').attr('disabled',true).addClass('bg_att');
                    $('img.loading').css('display','block');
                },
                success:function(data){
                    if(data.status == '200'){
                            $('.dialog2').text(data.response_msg).dialog('open');
                            $('#remove-centers-form').trigger('reset');
                            $('button[id=save]').attr('disabled',false).removeClass('bg_att');
                            $('img.loading').css('display','none');
                        
                    }else{
                        $('.dialog').text(data.response_msg).dialog('open');
                        $('button[id=save]').attr('disabled',false).removeClass('bg_att');
                        $('img.loading').css('display','none');
                    }
                }
            });
        }else{
            $('.dialog').text('CHoose centres you want to remove from the marking centres').dialog('open');
        }
    });
}

});

</script>
<?php
    }else{
        header('location: marking-centers.php');
    }
}else{
    header('location: ../');
}
?>

</html>