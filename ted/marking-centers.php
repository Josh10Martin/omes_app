<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">



<?php include 'includes/header.php';
     include '../config.php';
     include '../functions.php';
if($_SESSION['user_type']  == 'ECZ'){
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
                <!-- <h4 class="page-title">PROVINCE: <?php //  echo $_SESSION['province_name']; ?></h4> -->
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
            <br>
        </div>
        

        <div class="table-responsive">
            <div class="dialog"></div>
            <div class="dialog1"></div>
            <div class="dialog"></div>
          
            <form action="">
                <input type="hidden" name="no_of_marking_centres" value ="<?php echo no_of_marking_centres($db_9,$_SESSION['province_code'],$_SESSION['session_type']) ?>">
            </form>
        <table class="table custom-table table-bordered">
            <thead>
                <th>CODE</th>
                <th>MARKING CENTER NAME</th>
                
            </thead>
            <tbody>
            <!-- <tr class="MC-70">
                <td>MC-80</td>
                <td>LUSAKA BOYS SECONDARY SCHOOL</td>
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

        function get_marking_centre(){
            var no_of_marking_centres = $('input[type=hidden][name=no_of_marking_centres]').val(),
            display = no_of_marking_centres > 1 ? "none" : "block",
            visibility = no_of_marking_centres > 1 ? "block" : "none";
            $.ajax({
                url: 'php/get_marking_centres.php',
                method: 'POST',
                dataType: 'json',
                success: function(data){
                    $('table.table tbody tr').remove();
                    if(data.status != '200'){
                        $('table.table tbody').append('<tr class="null">'+
                        '<td colspan="3">There are no marking centres to display</td>'+
                        '</tr>');
                    }else{
                        $.each(data,function(){
                            //To dissapear one center
                            //$('.one').addClass('d-none')

                            //To dissapear Subjects
                            // $('.more').addClass('d-none')

                            var active_status = this["activation_status"] == '1' ? 'ACTIVATED' : 'ACTIVATE'
                            $('table.table tbody').append('<tr class="'+this["centre_code"]+'">'+
                            '<td>'+this["centre_code"]+'</td>'+
                            '<td>'+this["centre_name"]+'</td>'+
                            '<td><span class="no_of_centres" style="display: '+display+';">'+
                            // ' <a href="marking-center-apportionment.php?marking_centre_code='+this["centre_code"]+'&marking_centre_name='+this["centre_name"]+'"><i class="fa fa-pencil-square-o blue-ecz " aria-hidden="true"></i> Update</a></span>'+
                            // '<span class="no_of_subjects" style="display: '+visibility+';">'+this["no_of_subjects"]+
                            // ' <a href="subject-apportionment.php?marking_centre_code='+this["centre_code"]+'&marking_centre_name='+this["centre_name"]+'" class="more"><i class="fa fa-pencil-square-o blue-ecz " aria-hidden="true"></i> Update</a> </span>'+
                            '</td>'+
                            '<td class="text-center not_one_centre" style="display: '+display+';">'+
                                '<button id="'+this["centre_code"]+'" data-id="'+this["centre_code"]+'" class="btn '+this["activation_status"]+'">'+active_status+' </button>'+
                        
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
                      button();
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
</script>

<?php
}else{
    header('location: ../');
}

?>
</html>