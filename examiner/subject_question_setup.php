
<?php
session_start();
// include '../config.php';
// include '../functions.php';
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
                    <h4 class="page-title">SETUP NUMBER OF QUESTIONS PER SUBJEC</h4>
                </div>
                <!-- <div class="col-xs-6">
                    <a href="javascript:void(0)" data-toggle="modal" data-target="#add-marking-center" class="btn bg-light btn-sm"><i class="fa fa-plus"></i> Add Marking Center</a>
                </div> -->
    
            </div>
    
            <div class="row">
                <div class="col-sm-4">
                    <div class="form-group">
                      <label for="">search:</label>
                      <input type="text"  id="search" class="form-control" placeholder="search" >
                    </div>
                </div>
                <br>
            </div>
        <div class="dialog"></div>
    <div class="dialog1"></div>
    <div class="dialog2"></div>

            <div class="table-responsive">
                <div class="dialog"></div>
            <table class="table custom-table table-bordered">
                <thead >
                    <th>SUBJECT</th>
                    <th>PAPER</th>
                    <th>NUMBER OF QUESTION</th>
                    <th>UPDATE</th>
                </thead>
                <tbody>
                   
                </tbody>
            </table>
            </div>
        </div>
    </div>

    <!-- Modals  --><!-- Modal -->
      
    <div class="modal fade" id="update-questions" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="dialog"></div>
                <div class="dialog1"></div>
            <form action="" id="update_question_number">
            <div class="modal-header p-2 bg-success ">
                <div class="modal-title text-white h5 text-center">UPDATE <span class="subject_name_paper"></span></div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            
            <div class="row">
                    
                    <div class="col-md-12">
                        <div class="d-flex">
                            <label>NUMBER OF QUESTION:</label>
                            <input type="number" step=".01" name="no_of_questions" class=" mx-3 mark form-control" required>
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

    <div class="sidebar-overlay" data-reff=""></div>
</div>

<?php include 'includes/scripts.php' ?>

</body>
<script>
$(document).ready(function(){
    //get_province();
   // add_marking_centre();
  get_subject_paper();
  $('.dialog').dialog({
        title: 'REQUEST RESPONSE',
        width: '450',
        height: '150',
        modal: true,
        draggable: false,
        resizable: false,
        closeOnEscape: false,
        appendTo: '#update-questions',
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
  
function get_subject_paper(){
    $.ajax({
            url: 'php/get_subject_paper_question.php',
            method: 'POST',
            dataType: 'json',
            success:function(data){
                    $.each(data,function(){
                    $('table.table tbody').append('<tr class="'+this["id"]+'">'+
                    '<td>'+this["subject_name"]+'</td>'+
                    '<td>'+this["paper_no"]+'</td>'+
                    '<td>'+
                        '<div class="d-flex justify-content-between">'+
                            '<div>'+
                            ''+this["max_questions"]+''+
                            '</div>'+
                            
                        '</div>'+ 
                    '</td>'+
                    '<td class="text-center">'+
                        '<span class="btn btn-sm btn-primary" data-toggle="modal" data-target="#update-questions">UPDATE</span>'+ 
                    '</td>'+
                  
                    '</tr>');
                });
                $('table.table tbody tr.undefined').remove();
                
            }
        });
}
$(document).on('click','span.btn',function(){
    var subject_name = $(this).closest('tr').find('td:nth-child(1)').text(),
     paper_no = $(this).closest('tr').find('td:nth-child(2)').text(),
     no_of_questions = $(this).closest('tr').find('td:nth-child(3)').text(),
     id = $(this).closest('tr').attr('class');
     $('span.subject_name_paper').text(subject_name+' PAPER '+paper_no);
     $('input[type=number][name=no_of_questions]').val(no_of_questions);
     update_questions_per_subject_paper(id);
     
    //  alert(id);

});
function update_questions_per_subject_paper(id){
$('#update_question_number').submit(function(e){
    e.preventDefault();
    var no_of_questions = $('input[type=number][name=no_of_questions]').val();
    $.ajax({
        url: 'php/update_no_of_question.php',
        method: 'POST',
        data: {id:id,no_of_questions:no_of_questions},
        dataType: 'json',
        success: function(data){
            if(data.status == '200'){
                $('.dialog').text(data.response_msg).dialog('open');
                $('table.table tbody tr.'+data.id).find('td:nth-child(3)').text(data.no_of_questions);
            }else{
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