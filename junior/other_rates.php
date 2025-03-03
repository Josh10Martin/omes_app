
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
                    <h4 class="page-title">OTHER RATES</h4>
                </div>
                <!-- <div class="col-xs-6">
                    <a href="javascript:void(0)" data-toggle="modal" data-target="#add-marking-center" class="btn bg-light btn-sm"><i class="fa fa-plus"></i> Add Session</a>
                </div> -->
    
            </div>
    
            <div class="row">
                <div class="col-sm-4">
                    <div class="form-group">
                      <!-- <label for="">search:</label> -->
                      <input type="text"  id="search" class="form-control" placeholder="search" >
                    </div>
                </div>
                <br>
            </div>
            
    
            <div class="table-responsive">
                <div class="dialog"></div>
            <table class="table custom-table table-bordered">
                <thead >
                    <th ></th>
                    <th>CHECKER RATE (K)</th>
                    <th>SYSTEM ADMIN RATE (K)</th>
                    <th>TRANSCRIBER (K)</th>
                    <th>LUNCH ALLOWANXE (K)</th>
                    <th>TRANSPORT ALLOWANXE (K)</th>
                    <th>ACTION </th> 
                </thead>
                <tbody>
                   <tr>
                    <!-- <td>
                        RATE
                    </td>
                    <td>7</td>
                    <td>9</td>
                    <td>9</td>
                    <td>4</td>
                    <td><span data-toggle="modal" data-target="#update-marking-rate" class="btn btn-sm green-ecz update" >UPDATE</span></td> -->
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
            <form action="" id="update_other_rates">
            <div class="modal-header p-2 bg-success ">
                <div class="modal-title text-white h5 text-center">UPDATE <span class="subject_name_paper"></span></div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            
            <div class="row">
                    
                    <div class="col-md-6 p-1">
                        <div class="d-flex justify-content-between">
                            <label>CHECKER:</label>
                            <input type="number" step=".01" name="checker" class="mark form-control" required>
                        </div>
                    </div>

                    <div class="col-md-6 p-1">
                        <div class="d-flex justify-content-between">
                            <label>SYSTEM ADMIN:</label>
                            <input type="number" name="sad" step=".01" class="mark form-control" required>
                        </div>
                    </div>
                    
                </div>
                <div class="row">
                <div class="col-md-6 p-1">
                        <div class="d-flex justify-content-between">
                            <label>TRANSCRIBER:</label>
                            <input type="number" name="transcriber" step=".01" class="mark form-control" required>
                        </div>
                    </div>
                    <div class="col-md-6 p-1">
                        <div class="d-flex justify-content-between">
                            <label>LUNCH:</label>
                            <input type="number" name="lunch" step=".01" class="mark form-control" required>
                        </div>
                    </div>
                    <div class="col-md-6 p-1">
                        <div class="d-flex justify-content-between">
                            <label>TRANSPORT:</label>
                            <input type="number" name="transport" step=".01" class="mark form-control" required>
                        </div>
                    </div>
                </div>
                    <!-- <div class="row">
                    <div class="col-md-6">
                        <div class="d-flex justify-content-between mt-2">
                            <label>DATA ENTRY OPERATOR:</label>
                            <input type="number" name="deo" step=".01" class="mark form-control" required>
                        </div>
                    </div>
                    </div> -->
                   
              
                <input type="hidden" name="subject_id">
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
	
<?php include 'includes/scripts.php' ?>

</body>
<script>
$(document).ready(function(){
    // rates();
    get_other_marking_rates();
    update_other_marking_rates();

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

    function get_other_marking_rates(){
        $.ajax({
            url: 'php/get_other_marking_rates.php',
            nethod: 'POST',
            dataType: 'json',
            success: function(data){
                
                    $.each(data,function(){
                        $('table.table tbody').append('<tr>'+
                    '<td>RATE</td>'+
                    '<td>'+this["checker_rate"]+'</td>'+
                    '<td>'+this["sad_rate"]+'</td>'+
                    '<td>'+this["transcriber_rate"]+'</td>'+
                    '<td>'+this["lunch_rate"]+'</td>'+
                    '<td>'+this["transport_rate"]+'</td>'+
                    '<td class="text-right">'+
                            '<span id="" class="btn btn-sm btn-primary update" data-toggle="modal" data-target="#update-marking-rate">UPDATE</span>'+
                        '</td>'+
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
            
        });
    }
    function check_required(){
    if($('input[type=number][name=checker]').val() == '' && $('input[type=number][name=sad]').val() == ''){
        $('input[type=number][name=checker]').attr('required',false);
        $('input[type=number][name=sad]').attr('required',false);

        $('input[type=number][name=checker]').attr('disablrd',true);
        $('input[type=number][name=sad]').attr('disabled',true);

        $('input[type=number][name=transcriber]').attr('required',true);
        $('input[type=number][name=lunch]').attr('required',true);
        $('input[type=number][name=transport]').attr('required',true);
    }else{
        $('input[type=number][name=checker]').attr('required',true);
        $('input[type=number][name=sad]').attr('required',true);

        $('input[type=number][name=checker]').attr('disablrd',false);
        $('input[type=number][name=sad]').attr('disabled',false);

        $('input[type=number][name=transcriber]').attr('required',false);
        $('input[type=number][name=lunch]').attr('required',false);
        $('input[type=number][name=transport]').attr('required',false);
    }
}
    
    function rates(){
        $('span.update').click(function(){
            var checker_rate = $(this).closest('tr').find('td:nth-child(2)').text(),
             sad_rate = $(this).closest('tr').find('td:nth-child(3)').text(),
             transcriber_rate = $(this).closest('tr').find('td:nth-child(4)').text(),
             lunch_rate = $(this).closest('tr').find('td:nth-child(5)').text(),
                transport_rate = $(this).closest('tr').find('td:nth-child(6)').text();
                
                // alert(id);
                // alert(che_rate);
            $('input[type=number][name=checker]').val(checker_rate);
            $('input[type=number][name=sad]').val(sad_rate);
            $('input[type=number][name=transcriber]').val(transcriber_rate);
            $('input[type=number][name=lunch]').val(lunch_rate);
            $('input[type=number][name=transport]').val(transport_rate);
            check_required();
            
        });
    }

    function update_other_marking_rates(){
        $('#update_other_rates').submit(function(e){
            e.preventDefault();
            $.ajax({
                url: 'php/update_other_marking_rates.php',
                method: 'POST',
                data: $('#update_other_rates').serialize(),
                dataType: 'json',
                beforeSend: function(){
                    $('button[id=save]').attr('disabled',true).addClass('bg_att');
                    $('button[id=button_close]').attr('disabled',true);
                    $('img.loading').css('display','block');
                },
                success: function(data){
                    if(data.status == '200'){
                        $('button[id=save]').attr('disabled',false).removeClass('bg_att');
                        $('button[id=button_close]').attr('disabled',false);
                        $('img.loading').css('display','none');

                        location.reload();

                        // $('.dialog').text(data.response_msg).dialog('open');
                    }else{
                        $('button[id=save]').attr('disabled',false).removeClass('bg_att');
                        $('button[id=button_close]').attr('disabled',false);
                        $('img.loading').css('display','none');

                        $('.dialog').text(data.response_msg).dialog('open');
                    }
                }
            });
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