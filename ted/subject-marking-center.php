<?php
session_start();

?>
<!DOCTYPE html>
<html lang="en">



<?php include 'includes/header.php';
if($_SESSION['user_type']  == 'SESO'){
?>
<body>
<div class="main-wrapper">

    <?php include 'includes/navbar.php'?>     
    <?php include 'includes/sidebar.php'?>
<div class="page-wrapper">
    <div class="content">
        <div class="row justify-content-between px-2">
            <div class="col-xs-6">
                <h4 class="page-title">SUBJECT MARKING CENTRES</h4>
            </div>
            <div class="col-xs-6">
                <a href="javascript:void(0)" class="btn btn-default btn-sm"><i class="fa fa-bars"></i> MARKING CENTRES LIST</a>
            </div>

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
        

        <div class="table-responsive">
        <table class="table custom-table table-striped">
            <thead>
                <th>SUBJECT</th>
                <th>PAPER</th>
                <th>MARKING CENTRE</th>
               
                <th class="text-right">Action</th>
            </thead>
            <tbody>
                <!-- <tr>
                    <td>ENGLISH LANGUAGE</td>
                    <td>PAPER 1</td>
                    <td>KABULONGA GIRLS</td>
                   
                    <td class="text-right">
                        <a class="" href="javascript:void(0)" data-toggle="modal" data-target="#edit-subject-center"><i class="fa fa-pencil m-r-5 blue-ecz"></i> Edit</a>
                    </td>
                </tr> -->
            </tbody>
        </table>
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
    $('.dialog').dialog({
        title: 'REQUEST RESPONSE',
        width: '450',
        height: '150',
        modal: true,
        draggable: false,
        resizable: false,
        closeOnEscape: false,
        appendTo: '#edit-subject-center',
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
    // $.ajax({
    //       url: 'php/get_subject_marking_centre.php',
    //       method: 'POST',
    //       dataType: 'json',
    //       success:function(data){
    //           $('select[name=subject]').append(
    //             '<option selected disabled>Select Subject</option>'
    //           );
    //           $.each(data,function(){
    //             $('select[name=subject]').append(
    //             '<option value="'+this["subject_code"]+':'+this["subject_name"]+'">'+this["subject_code"]+' - '+this["subject_name"]+'</option>'
    //           );
    //           });
    //       }
    //     });

    //     $('select[name=subject]').change(function(){
    //       var subject_val = $(this).val().split(':'),
    //         subject_code = subject_val[0];
    //       $.ajax({
    //         url: 'php/get_paper.php',
    //         method: 'POST',
    //         data:{subject_code:subject_code},
    //         dataType: 'json',
    //         success:function(data){
    //             $('select[name=paper] option').remove();
    //           $('select[name=paper]').append(
    //             '<option value="" selected disabled>Select Paper Number</option>'
    //           );
    //           $.each(data,function(){
    //             $('select[name=paper]').append(
    //             '<option value="'+this["paper_no"]+'">'+this["paper_no"]+'</option>'
    //           );
    //           });
            
    //         }
    //       });
    //     });
       

        $.ajax({
        url: 'php/get_marking_centres_add.php',
        method: 'POST',
        dadaType: 'json',
        success:function(data){
            $('select[name=marking_centre]').append(
                '<option value="" selected disabled>Select Marking Centre</option>'
              );
            $.each(data,function(){
                $('select[name=marking_centre]').append(
                    '<option value="'+this["centre_code"]+':'+this["centre_name"]+'">'+this["centre_code"]+' - '+this["centre_name"]+'</option>'
                );
            });

            $('select[name=marking_centre]').select2({
              data:data
            });
        }
    });

    $.ajax({
        url: 'php/get_chosen_marking_centres.php',
        method: 'POST',
        dataType: 'json',
        success: function(data){
            if(data.status == '400'){
                $('table.table tbody').append('<tr class="null">'+
                '<td colspan="4" style="text-align:center;">There is no data</td>'+
                '</tr>');
            }else{
                $.each(data,function(){
                $('table.table tbody tr.null').remove();
                $('table.table tbody').append('<tr class='+this["subject_name"]+'>'+
                '<td class="'+this["subject_name"]+'">'+this["subject_name"]+'</td>'+
                '<td>'+this["paper"]+'</td>'+
                '<td>'+this["marking_centre_name"]+'</td>'+
                '<td class="text-right">'+
                        '<a id="'+this["subject_code"]+'" class="'+this["paper"]+' '+this["subject_name"]+' mark_centre" href="javascript:void(0)" data-toggle="modal" data-target="#edit-subject-center"><i class="fa fa-pencil m-r-5 blue-ecz"></i> Edit</a>'+
                    '</td>'+
                '</tr>');
            });
            }
            $('table.table td').each(function(){
                    var currentTd = $(this).html();
                     if(currentTd == 'undefined'){
                        $(this).parent('tr.undefined').remove();
                     }
                });

                $('a.mark_centre').click(function(){
    var subject_name = $(this).parent('td').parent('tr').children().first().text(),
        subject_code = $(this).attr('id'),
        paper_split = $(this).attr('class').split(' '),
        paper =paper_split[0];
       
    //   alert(subject_name)
;       $('input[type=text][name=subject]').val(+subject_code+' - '+subject_name).attr({'readonly':true, 'id':+subject_code});
       $('input[type=text][name=paper]').val(+paper).attr('readonly',true);
    
});
        }
   
   });


               
  
    $('#choose_centre').submit(function(e){
        e.preventDefault();
        var subject_code = $('input[type=text][name=subject]').attr('id'),
            subject_name = $('input[type=text][name=subject]').val(),
            paper = $('input[type=text][name=paper]').val(),
            marking_centre = $('select[name=marking_centre]').val().split(':'),
            marking_centre_code = marking_centre[0],
            marking_centre_name = marking_centre[1];

        $.ajax({
            url: 'php/define_marking_centre.php',
            method: 'POST',
            data: {subject_code:subject_code,subject_name:subject_name,paper:paper,marking_centre_code:marking_centre_code,marking_centre_name:marking_centre_name},
            dataType: 'json',
            beforeSend: function(){
                $('button[id=button_close]').attr('disabled',true);
                $('button[id=save]').attr('disabled',true);
                $('button[id=save]').addClass('bg_att');
                $('img.loading').css('display','block');
            },
            success:function(data){
                if(data.status == '400'){
                    $('button[id=button_close]').attr('disabled',true);
                    $('button[id=save]').attr('disabled',true);
                    $('button[id=save]').addClass('bg_att');
                    $('img.loading').css('display','block');
                    $('.dialog').text(data.response_msg).dialog('open');
                }else{
                    $('table.table tbody td a#'+subject_code).parent('td').prev().text(''+marking_centre_name
                    );

                    $('button[id=button_close]').attr('disabled',false);
                    $('button[id=save]').attr('disabled',false);
                    $('button[id=save]').removeClass('bg_att');
                    $('img.loading').css('display','none');
                    // $('#choose_centre').trigger('reset');
                    $('.dialog').text(data.response_msg).dialog('open');
                }
            }
        });
    });

});

</script>
<?php
}else{
    header('location: ../');
}
?>

</html>