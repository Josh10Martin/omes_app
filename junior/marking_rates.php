
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
                    <h4 class="page-title">MARKING RATES</h4>
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
                    <th>SUBJECT</th>
                    <th>PAPER</th>
                    <th>CHIEF-EXAMINER RATE (K)</th>
                    <th>DEPUTY CHIEF-EXAMINER RATE (K)</th>
                    <th>TEAM-LEADER RATE (K)</th>
                    <th>EXAMINER RATE (K)</th>
                    <th>DATA ENTRY RATE (K)</th>
                    <th>ACTION </th> 
                </thead>
                <tbody>
                    <!-- <tr>
                        <td>ENGLISH LANGUAGE</td>
                        <td>PAPER 1</td>
                        <td>K 8.00</td>
                        <td>K 8.00</td>
                        <td>K 8.00</td>
                        <td>K 8.00</td>
                        <td class="text-right">
                            <span class="btn btn-sm btn-primary" data-toggle="modal" data-target="#update-marking-rate">UPDATE</span>
                           <div class="dropdown dropdown-action">
                                <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a class="dropdown-item" href="javascript:void(0)" ><i class="fa fa-pencil m-r-5 blue-ecz"></i> Edit</a>
                                    <a class="dropdown-item" href="javascript:void(0)" data-toggle="modal" data-target="#delete_center"><i class="fa fa-trash-o m-r-5 red-ecz"></i> Delete</a>
                                </div>
                            </div> 
                        </td> -->
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
            <form action="" method="post" id="update_rates">
            <div class="modal-header p-2 bg-success ">
                <div class="modal-title text-white h5 text-center">UPDATE <span class="subject_name_paper"></span></div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            
            <div class="row">
                    
                    <div class="col-md-6">
                        <div class="d-flex justify-content-between">
                            <label>CHIEF EXAMINER:</label>
                            <input type="number" step=".01" name="che" class="mark form-control" required>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="d-flex justify-content-between">
                            <label>DEPUTY CHIEF EXAMINER:</label>
                            <input type="number" name="dche" step=".01" class="mark form-control" required>
                        </div>
                    </div>
                    
                </div>
                <div class="row">
                <div class="col-md-6">
                        <div class="d-flex justify-content-between">
                            <label>TEAM LEADER :</label>
                            <input type="number" name="tl" step=".01" class="mark form-control" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="d-flex justify-content-between">
                            <label>EXAMINER:</label>
                            <input type="number" name="ex" step=".01" class="mark form-control" required>
                        </div>
                    </div>
                </div>
                    <div class="row">
                    <div class="col-md-6">
                        <div class="d-flex justify-content-between mt-2">
                            <label>DATA ENTRY OPERATOR:</label>
                            <input type="number" name="deo" step=".01" class="mark form-control" required>
                        </div>
                    
                    </div>
                    </div>
                   
              
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
    get_marking_rates();

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

    function get_marking_rates(){
        $.ajax({
            url: 'php/get_marking_rates.php',
            nethod: 'POST',
            dataType: 'json',
            success: function(data){
                if(data.status == '200'){
                    $.each(data,function(){
                        $('table.table tbody').append('<tr class="'+this["id"]+'">'+
                    '<td>'+this["subject_name"]+'</td>'+
                    '<td>'+this["paper_no"]+'</td>'+
                    '<td>'+this["chief_examiner"]+'</td>'+
                    '<td>'+this["deputy_c_examiner"]+'</td>'+
                    '<td>'+this["t_leader"]+'</td>'+
                    '<td>'+this["examiner"]+'</td>'+
                    '<td>'+this["data_entry_operator"]+'</td>'+
                    '<td class="text-right">'+
                            '<span id="'+this["id"]+'" class="btn btn-sm btn-primary update" data-toggle="modal" data-target="#update-marking-rate">UPDATE</span>'+
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
            }
        });
    }

    function rates(){
        $('span.update').click(function(){
            var subject_name = $(this).closest('tr').find('td:nth-child(1)').text(),
             paper_no = $(this).closest('tr').find('td:nth-child(2)').text(),
             che_rate = $(this).closest('tr').find('td:nth-child(3)').text(),
                dche_rate = $(this).closest('tr').find('td:nth-child(4)').text()
                tl_rate = $(this).closest('tr').find('td:nth-child(5)').text(),
                ex_rate = $(this).closest('tr').find('td:nth-child(6)').text(),
                deo_rate = $(this).closest('tr').find('td:nth-child(7)').text(),
                id = $(this).attr('id');
                // alert(id);
                // alert(che_rate);
            $('input[type=number][name=che]').val(che_rate);
            $('input[type=number][name=dche]').val(dche_rate);
            $('input[type=number][name=tl]').val(tl_rate);
            $('input[type=number][name=ex]').val(ex_rate);
            $('input[type=number][name=deo]').val(deo_rate);
            $('input[type=hidden][name=subject_id]').val(id);
            $('span.subject_name_paper').text(subject_name+' PAPER '+paper_no);
            update_marking_rates();
            
        });
    }

    function update_marking_rates(){
        $('#update_rates').submit(function(e){
            e.preventDefault();
            $.ajax({
                url: 'php/update_marking_rates.php',
                method: 'POST',
                data: $('#update_rates').serialize(),
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

                        $('table.table tbody tr.'+data.subject_id).find('td:nth-child(3)').text(data.che);
                        $('table.table tbody tr.'+data.subject_id).find('td:nth-child(4)').text(data.dche);
                        $('table.table tbody tr.'+data.subject_id).find('td:nth-child(5)').text(data.tl);
                        $('table.table tbody tr.'+data.subject_id).find('td:nth-child(6)').text(data.ex);
                        $('table.table tbody tr.'+data.subject_id).find('td:nth-child(7)').text(data.deo);

                        $('.dialog').text(data.response_msg).dialog('open');
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