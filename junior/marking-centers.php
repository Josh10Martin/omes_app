<?php
session_start();
include '../config.php';
// include '../functions.php';
?>

<!DOCTYPE html>
<html lang="en">
    <style>
        /* The switch - the box around the slider */
.switch {
  position: relative;
  display: inline-block;
  width: 60px;
  height: 34px;
}

/* Hide default HTML checkbox */
.switch input {
  opacity: 0;
  width: 0;
  height: 0;
}

/* The slider */
.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #ccc;
  -webkit-transition: .4s;
  transition: .4s;
}

.slider:before {
  position: absolute;
  content: "";
  height: 26px;
  width: 26px;
  left: 4px;
  bottom: 4px;
  background-color: white;
  -webkit-transition: .4s;
  transition: .4s;
}

input:checked + .slider {
  background-color: #2196F3;
}

input:focus + .slider {
  box-shadow: 0 0 1px #2196F3;
}

input:checked + .slider:before {
  -webkit-transform: translateX(26px);
  -ms-transform: translateX(26px);
  transform: translateX(26px);
}

/* Rounded sliders */
.slider.round {
  border-radius: 34px;
}

.slider.round:before {
  border-radius: 50%;
}
    </style>



<?php include 'includes/header.php';
     include '../config.php';
     include '../functions.php';
if($_SESSION['user_type']  == 'SESO'){
    ?>

<body>
<div class="main-wrapper">

    <?php include 'includes/navbar.php'?>     
    <?php include 'includes/sidebar.php'?>
<div class="page-wrapper">
    <div class="content">
        <div class="row justify-content-between px-2">
            <div class="col-sm-6">
                <h4 class="page-title">MARKING CENTRES</h4>
            </div>
            <div class="col-sm-6">
                <h4 class="page-title">PROVINCE: <?php echo $_SESSION['province_name']; ?></h4>
            </div>
            <!-- <div class="col-xs-6">
                <a href="javascript:void(0)" data-toggle="modal" data-target="#add-marking-center" class="btn bg-light btn-sm"><i class="fa fa-plus"></i> Add Marking Center</a>
            </div> -->

        </div>

        <div class="row">
            <div class="col-sm-4">
                <div class="form-group">
                  <!-- <label for="">search:</label> -->
                  <input type="text"  id="search" class="form-control" placeholder="Search" >
                </div>
            </div>
            <div class="col-sm-4 d-flex align-items-center ">
            <span class="h4 align-items-bottom">



                <a href="<?php if ($_SESSION['session_type']=="I") { ?> subject_apportionment_summary.php <?php } else { ?>centres_apportionment_summary_external.php<?php }?> ">
                    <img src="../assets/img/icons/summary-icon1.png" alt="">
                    Summary
                </a>

                </span>
            </div>
            <div class="col-sm-4 d-flex align-items-center ">
                <span class="h4 align-items-bottom">
                    <a href="detailed_summary.php" >
                        <i class="fa fa-info-circle" aria-hidden="true"></i>
                        Detailed Summary
                    </a>
                    </span>
                </div>
            <!-- <div class="col-sm-4 d-flex align-items-center ">
            <span class="h4 align-items-bottom">
              <button type="button" class="btn btn-sm btn-outline-info">Finish</button>  
                </span>
            </div>
            <br>
        </div> -->
        <div class="dialog"></div>
            <div class="dialog1"></div>
            <div class="dialog2"></div>
            <div class="dialog3"></div>
            <div class="dialog4"></div>

        <div class="table-responsive">
            
          
            <form action="">
                <input type="hidden" name="no_of_marking_centres" value ="<?php echo no_of_marking_centres($db_9,$_SESSION['province_code'],$_SESSION['session_type']) ?>">
                <input type="hidden" name="session_type" value = "<?php echo $_SESSION['session_type']; ?>">
            </form>
        <table class="table custom-table table-bordered">
            <thead>
                <th>CODE</th>
                <th>MARKING CENTRE NAME</th>
                <th>SEN</th>
                <th><span class="one">CENTRES</span> </th>
                <?php if($_SESSION['session_type'] == 'E'){ ?>
                <th class="text-center">ACTION</th>
              <?php } ?>
            </thead>
            <tbody>
            <!-- <tr class="MC-70">
                <td>MC-80</td>
                <td>LUSAKA BOYS SECONDARY SCHOOL</td>
                <td>
                    <label class="switch">
                    <input type="checkbox" id="sen1-check" class="sen-check">
                    <span class="slider round"></span>
                    </label>
                    <br>
                    <label class="switch">
                    <input type="checkbox" id="sen2-check" class="sen-check">
                    <span class="slider round"></span>
                    </label>

                    <br>
                    <label class="switch">
                    <input type="checkbox" id="sen3-check" class="sen-check">
                    <span class="slider round"></span>
                    </label>
                </td>
                <td> 170
                    <span class=""> 
                        <a href="marking-center-apportionment.php" class="one"><i class="fa fa-pencil-square-o blue-ecz " aria-hidden="true"></i> Update</a> 
                        <a href="subject-apportionment.php" class="more"><i class="fa fa-pencil-square-o blue-ecz " aria-hidden="true"></i> Update</a> 
                    </span>
                </td>
                <td class="text-center">
                    <button id="MC-70" data-id="MC-70" class="btn 1" disabled="disabled" style="color: rgb(0, 128, 0); background-color: transparent; cursor: default;">ACTIVATED </button>
                </td>
            </tr> -->
      
            </tbody>
        </table>
        </div>


    <?php include 'includes/notifications.php' ?>
    </div> <!--End  content-->
</div> <!--End page wrapper-->
<!--Modal-->
<div class="modal fade" id="add-marking-center" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
        <form action="" method="post">
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
                        <input type="text" name="username" class="form-control" required>
                    </div>
                </div>
                
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label>NAME:</label>
                        <input type="text" name="first_name" class="form-control" required>
                    </div>
                </div>
               
            </div>
            
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary mr-auto" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary float-right">Save</button>
        </div>
        </form>
        </div>
    </div>
    </div>

<div class="sidebar-overlay" data-reff=""></div>
</div>	
<?php include 'includes/scripts.php' ?>

</body>
<script>
    $(document).ready(function(){
        get_marking_centre();
        // sen_marking_centre();
       $('#sen1-check').prop('checked', true);

       $('.sen-check').click(function(){
        var in_id=$(this).attr('id')
        if($('.sen-check:checked')){
            var out_id=$('.sen-check:checked').attr('id')
            $('#'+out_id+'').removeAttr('checked')
           // $('#'+out_id+'').prop('checked', false);
           // e.preventDefault();
            togglecheck(out_id,in_id)
        }
         
        console.log("checked ",in_id)

        
       })
        $('.dialog').dialog({
        title: 'REQUEST RESPONSE',
        width: '450',
        height: '150',
        modal: true,
        draggable: false,
        resizable: false,
        closeOnEscape: false,
        appendTo: '.table',
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
            {
                text: 'NO',
                click: function(){
                    $(this).dialog('close');
                }
            },
            {
                text: 'YES',
                click: function(){
                    var id = $('.dialog1').data('id');
                    activate_marking_centre(id);
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
        appendTo: '.table',
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
            {
                text: 'NO',
                click: function(){
                    location.reload();
                    $(this).dialog('close');
                }
            },
            {
                text: 'YES',
                click: function(){
                    var id = $('.dialog3').data('id');
                    add_sen(id);
                    $(this).dialog('close');
                }
            }
        ]
    });
        function togglecheck(out_id,in_id){
            $('#'+out_id+'').prop('checked', false);
            $('#'+in_id+'').prop('checked', true);
            console.log('OUT: ',out_id)
            console.log('IN: ',in_id)
        }
      
        $(document).on('click','input:radio[name=sen]',function(){
            
            var marking_centre = $(this).prop('checked',false).val().split(':'),
                marking_centre_code = marking_centre[0],
                marking_centre_name = marking_centre[1];
            $('.dialog3').text('SEN scripts to be marked at '+marking_centre_name+' ?').data('id',marking_centre_code).dialog('open');
            // $('input[type=radio][name=sen]').not(this).prop('checked',false);
            
        });
        function get_marking_centre(){
            var session_type = $('input[type=hidden][name=session_type]').val(),
            display = session_type == 'E' ? "none" : "block",
            visibility = session_type == 'E' ? "block" : "none";
            $.ajax({
                url: 'php/get_marking_centres.php',
                method: 'POST',
                dataType: 'json',
                success: function(data){
                    $('table.table tbody tr').remove();
                    if(data.status == '400'){
                        $('table.table tbody').append('<tr class="null">'+
                        '<td colspan="3">There are no marking centres to display</td>'+
                        '</tr>');
                    }else{
                        $.each(data,function(){
                            //To dissapear one center
                            //$('.one').addClass('d-none')

                            //To dissapear Subjects
                            // $('.more').addClass('d-none')

                            var active_status = this["activation_status"] == '1' ? 'ACTIVATED' : 'ACTIVATE',
                                sen = this["sen"] == '1' ? 'checked' : '',
                                 chosem_sen = ((this["valid"] == 1 && this["sen"] == 1) || (this["sen"] == 0 && this["valid"] == 1) || (this["chosen_sen"] == 1)) ? 'disabled' : '';
                               var bgColor = active_status == 'ACTIVATED' ? 'transparent' : 'green';
                               var color = active_status == 'ACTIVATED' ? 'green' : 'white';
                               var disabled = active_status == 'ACTIVATED' ? 'disabled' : '';
                            $('table.table tbody').append('<tr class="'+this["centre_code"]+'">'+
                            '<td>'+this["centre_code"]+'</td>'+
                            '<td>'+this["centre_name"]+'</td>'+
                            '<td>'+
                            '<label class="switch">'+
                                '<input type="radio" id="" value="'+this["centre_code"]+':'+this["centre_name"]+'" name="sen" class="sen-check" '+sen+' '+chosem_sen+'>'+
                                '<span class="slider round"></span>'+
                                '</label>'+
                            '</td>'+
                            '<td><span class="no_of_centres" style="float: left;">'+this["no_of_centres"]+'&nbsp '+
                            ' <a href="marking-center-apportionment.php?marking_centre_code='+this["centre_code"]+'&marking_centre_name='+this["centre_name"]+'" style="display: '+visibility+';float:right;"><i class="fa fa-pencil-square-o blue-ecz " aria-hidden="true"></i> Update</a></span>'+
                            
                            ' <a href="subject_apportionment_internal.php?marking_centre_code='+this["centre_code"]+'&marking_centre_name='+this["centre_name"]+'" style="display: '+display+';"  class="more"><i class="fa fa-pencil-square-o blue-ecz " aria-hidden="true"></i> Update</a> </span>'+
                            '</td>'+
                            '<td class="text-center not_one_centre" style="display: '+visibility+';">'+
                                '<button id="'+this["centre_code"]+'" data-id="'+this["centre_code"]+'" class="btn '+this["activation_status"]+'" style="background-color:'+bgColor+'; color:'+color+';" '+disabled+'>'+active_status+' </button>'+
                        
                            '</td>'+
                            '</tr>');
                        });
                        $('table.table tbody tr.undefined').remove();
                        // $('table.table tbody td').each(function(){
                        //     var currentTd = $(this).html();
                        //     if(currentTd == 'undefined'){
                        //         $(this).parent('tr.undefined').remove();
                        //     }
                        // });
                    //   button();
                      btn_click();
                    }
                }

            });
        }
    //    var activateBtn = $('table span.btn.btn-primary');

    //    activateBtn.click(function(){
    //     $(this).removeClass('btn-primary')
    //     $(this).addClass('green-ecz')
    //     $(this).text("ACTIVATED")
    //    })
    });
    function button(){
        var state = $('table button').attr('class').split(' '),
            status = state[1];
        if(status == 1){
            $('table button').removeClass('btn-primary').css({'color':'green','background-color': 'transparent','cursor': 'default'}).attr('disabled',true);
    }else{
        $('table button').css({'color':'white','background-color': 'green'}).attr('disabled',false);
    }
}
function btn_click(){
$('table button').click(function(){
    var id = $(this).data('id'),
        centre_name = $(this).closest('tr').find('td:nth-child(2)').text();
    $('.dialog1').text('Activate '+id+' - '+centre_name+'?').data('id',id).dialog('open');
});
}
function activate_marking_centre(id){
   
        $.ajax({
            url: 'php/activate_marking_centre.php',
            method: 'POST',
            data: {centre_code:id},
            dataType: 'json',
            beforeSend: function(){
                $('button#'+id).html('<img src = "../images/loading.gif" />').attr('disabled',true);
            },
            success: function(data){
                if(data.status == '200'){
                    $('button#'+id).text('ACTIVATED').css({'color':'green','background-color': 'transparent','cursor': 'default'});
                }else{
                    $('button#'+id).text('ACTIVATE').css({'color':'white','background-color': 'green'});
                    $('.dialog').text(data.response_msg).dialog('open');
                }
            }
        }); 
}

function add_sen(id){
                $.ajax({
                    url: 'php/add_sen.php',
                    method: 'POST',
                    data: {marking_centre_code:id},
                    dataType: 'json',
                    success:function(data){
                        if(data.status == '200'){
                            // $('input:radio[name=sen][value^='+data.marking_centre_code+']').prop('checked',true);
                            location.reload();
                        }else{
                            $('.dialog2').text(data.response_msg).dialog('open');
                        }
                    }

                });
            
}
</script>

<?php
}else{
    header('location: ../');
}

?>
</html>