<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<style>
       
        .table>tbody>tr.active{
            background-color: rgba(29, 157, 117, 0.26);
            border:1px solid #1d9d74;
        }
        .tableFixHead          { overflow: auto; max-height: 28rem; }
        .tableFixHead thead th { position: sticky; top: 0; z-index: 1; background-color: #1d9d74;}
       
    </style>


<?php include 'includes/header.php'?>
<?php
if($_SESSION['user_type']  == 'DEO'){
?>
<body>
<div class="main-wrapper">

    <?php include 'includes/navbar.php'?>     

    <?php include 'includes/sidebar.php'?>

<div class="page-wrapper">
<div class="content">
    <div class="row">
        <div class="col-md-6"><h4>Improvised Marks Entery</h4> </div>
    </div>
    <div class="row">
        
        <div class="col-md-5  px-3 pb-0">
            <div class="row bg-light my-0 pt-0">
                <h5 class="text-center ml-auto mr-auto p-4">ADD MARK</h5>
            </div>
            <div class="dialog"></div>
            <div class="dialog1"></div>
            <div class="dialog2"></div>
            <div class="dialog3"></div>
            <div class="dialog4"></div>

            <form action="" method="post" id="improvised_mark" class="border-bottom border-dark p-3">
                <div class="row">
                <div class="col-md-6">
                        <p>EXAM NO:
                            <input type="nmber" name="exam_no" class="form-control" id="examnumber" required>
                        </p>
                    </div>

                    <div class="col-md-12">
                        <p>Center Code:
                            <select name="centre_code" id="centre_code" class="select" required>

                            </select>
                            
                        </p>
                    </div>
                    
                    
                </div>
                <div class="row">
                <div class="col-md-12">
                        <p>Subject:
                            <select name="subject" id="subject" class="select">

                            </select>
                            <!-- <input type="text" class="form-control" required> -->
                        </p>
                    </div>
                
                    <input type="hidden" name="subject_name">
                    <input type="hidden" name="exam_number">
                    <input type="hidden" name="centre_code">
                    <input type="hidden" name="belt_no">
                    <input type="hidden" name="sen">

                    <input type="hidden" name="max_mark">
                </div>
                <div class="row">
                <div class="col-md-3">
                        <p>Mark:
                            <input type="number" name="mark" class="form-control" id="mark" required>
                        </p>
                </div>
                <div class="col-md-6">
						<label class="font-weight-bold" for="">Condidate Type:</label>
						<select name="candidate_type" class="select" id="" required>
                        <option value="0">MAIN STREAM </option>
							<option value="1">SEN</option>
						</select>
					</div>
                    <div class="col-md-3">
                        <p>Belt number:
                            <input type="number" min="1" name="belt_no" id="belt" class="form-control" required placeholder ="0">
                        </p>
                    </div>
                    <!-- <div class="col-md-6">
                        <p>Status:
                            <select name="status" id="" class="select">
                                <option value="L">L</option>
                                <option value="X">X</option>
                                <option value="-">-</option>
                            </select>
                           
                        </p>
                    </div> -->
                </div>
                <div class="row  justify-content-around">
                    <div id="updatediv" class="d-none">
                        <button  class="btn btn-sm btn-info update" type="button">UPDATE</button>
                        <button class="btn btn-sm btn-danger delete" type="button">DELETE</button>
                        <button class="btn btn-sm border-secondary cancel" id="cancel_btn" type="button">CANCEL</button>
                       
                    </div>
                    <div id="savediv">
                    <button class="btn btn-sm btn-primary ml-auto mr-auto" id="save" type="submit">Save</button>
                    </div>
                    
                    <div class="load"></div>
                </div>
            </form>
        </div>
        <div class="col-md-7 border border-dark bg-white ">
        <div class="row p-1">
            <div class="col-md-5 ">
                <input type="text" placeholder="Search" class="form-control" name="search" id="search">
                
            </div>
            
        </div>
        <div class="tableFixHead">
        <table class="table table-sm table-hover" id="improvised_marks_tble">
        <thead>
            <th class="text-center" >Exam Number</th>
            <th class="text-center">Center Code</th>
            <th class="text-center">Subject </th>
            <th class="text-center">Paper</th>
            <th class="text-center">Mark</th>
            <th class="text-center">Belt</th>
            
            
            <th class="text-center">Date Entered</th>
        </thead>
        <tbody>
            <!-- <tr>
                <td>00000000000</td>
                <td>3423</td>
                <td>ENGLISH LANGUAGE</td>
                <td>1</td>
                <td>50</td>
                
                
                <td>31 july 2023 12:48</td>
            </tr> -->


        </tbody>
    </table>
    </div>
        </div>
    </div>
   

    <div>

    </div>



    <?php include 'includes/notifications.php' ?>
</div>
</div>

            <div class="sidebar-overlay" data-reff=""></div>
</div>

	
<?php include 'includes/scripts.php' ?>


</body>
<script>
    $(document).ready(function(){

        $('#examnumber').mask("000000000000");
        $('#mark').mask("000");

        get_specific_subjects_based_centre_code();
        get_max_mark();
        get_schools();
        submit_improvised();
        get_improvised_marks();
        // update_improvised_mark();
       
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
            {
                text: 'NO',
                click: function(){
                    $(this).dialog('close');
                }
            },
            {
                text: 'YES',
                click: function(){
                    delete_candidate();
                    $(this).dialog('close');
                }
            }
        ]
    });

    function table_onclik(){
        var activeRow= $('#improvised_marks_tble tr.active');
         $('#improvised_marks_tble tbody tr').click(function(){
            // console.log("Clicked",$(this));
            // console.log("Active row",activeRow);
            activeRow.removeClass('active');
            $(this).addClass('active');
            activeRow=$(this);
            //$('input[type=text][name=centre_code]').attr('readonly',true);

            $('#updatediv').removeClass('d-none');
            $('#savediv').addClass('d-none');
            var examnumber = $(this).find("td").eq(0).html();
            var center = $(this).find("td").eq(1).html();
            var subject_name = $(this).find("td").eq(2).html();
            var paper = $(this).find("td").eq(3).html();
            var mark = $(this).find("td").eq(4).text();
            var belt = $(this).find("td").eq(5).text();
            // console.log("Cliked Scripts:",numberOfScrips)
           // console.log("Cliked Center:",center);
            // console.log("MARK:",mark)
            $('#examnumber').val(examnumber);
            $('#center').val(center).change();
            $("#subject").select2();

            // var subject = $('select[name=subject]').val().split(':')[1].change();
            // var subject_name = subject[1];
            $('select[name=subject]').attr('disabled',true);
            $('select[name=paper]').attr('disabled',true);
            $('select[name=centre_code]').attr('disabled',true);
            $('select[name=candidate_type]').attr('disabled',true);
            $('input[name=exam_no]').attr('readonly',true);
            $('input[name=mark]').val(mark);
            $('input[type=hidden][name=subject_name]').val(subject_name);
            $('input[type=hidden][name=centre_code]').val(center);
            $('input[type=hidden][name=exam_number]').val(examnumber);
            $('input[type=hidden][name=belt_no]').val(belt);


            // $("#subject").val(subjec_name).trigger("change");
           
            console.log("SUB:",subject)
            $("#subject").select2(); 
            $('#belt').val(belt);
            $('#mark').val(mark);
            $('#mark').text('Update Apportionment');
           // display_centre_name(center);
           // $('button#delete').attr('data-id',center);
           // $('input[type=number][name=script_no]').attr('title','click on the desired button after update. Dont press the "ENTER" key')

         });
         delete_from_improvised();
         update_improvised_mark();
         cancel();


    }
function cancel(){
    $('#cancel_btn').click(function(){
            $('#savediv').removeClass('d-none');
            $('#updatediv').addClass('d-none');
            $('#examnumber').val("");
            $('#center').val("");
            $('#subject').val("");
            $('#paper').val("");
            $('#mark').val("");

            $('#box-title').text('New Apportionment');
            // activeRow.removeClass('active');
            $('input[type=text][name=centre_code]').attr('readonly',false);
            $('.school_name').text('');
            $('input[type=number][name=script_no]').attr('title','');

            $('select[name=subject]').attr('disabled',false);
            $('select[name=centre_code]').attr('disabled',false);
            $('select[name=candidate_type]').attr('disabled',false);
            $('input[name=exam_no]').attr('readonly',false);
            $('input[name=mark]').val('');
            $('input[type=hidden][name=subject_name]').val('');
            // $('input[type=hidden][name=paper_number]').val('');
            $('input[type=hidden][name=exam_number]').val('');
         });
}


        

// function get_subjects(){
//     $.ajax({
//           url: 'php/get_subject.php',
//           method: 'POST',
//           dataType: 'json',
//           success:function(data){
//             $('select[name=subject] option').remove();
//               $('select[name=subject]').append(
//                 '<option selected disabled>Select Subject</option>'
//               );
//               $.each(data,function(){
//                 $('select[name=subject]').append(
//                 '<option value="'+this["subject_code"]+':'+this["subject_name"]+'">'+this["subject_code"]+' - '+this["subject_name"]+'</option>'
//               );
//               });
//               $('select[name=subject]').select2({
//                 data:data
//               });
//           }
//         });
//   }
//   function get_paper(){
//     $('select[name=subject]').change(function(){
//           var subject = $(this).val().split(':'),
//                 subject_code = subject[0];
//           $.ajax({
//             url: 'php/get_paper.php',
//             method: 'POST',
//             data:{subject_code:subject_code},
//             dataType: 'json',
//             success:function(data){
//               $('select[name=paper] option').remove();
//               $('select[name=paper]').append(
//                 '<option value="" selected disabled>Select Paper Number</option>'
//               );
//               $.each(data,function(){
//                 $('select[name=paper]').append(
//                 '<option value="'+this["paper_no"]+'">'+this["paper_no"]+'</option>'
//               );
//               });
//             }
//           });
//         //   get_apportioned_belts(subject_code);
//         //   get_belt(subject_code);
//         });
//   }
function get_max_mark(){
    $('select[name=subject]').change(function(){
        var subject = $(this).val().split(':'),
        subject_code = subject[0];
        $.ajax({
            url: 'php/get_max_mark.php',
            method: 'POST',
            data: {subject_code:subject_code},
            dataType: 'json',
            success:function(data){
                $('input[type=hidden][name=max_mark]').val(data.max_mark);
            }
        });
    });
}

  function get_schools(){
    $.ajax({
      url: 'php/get_schools.php',
      method: 'POST',
      dataType: 'json',
      success: function(data){
        // $('select[name=centre_code] option').remove();

        $('select[name=centre_code]').append(
            '<option value="" selected disabled>Select centre code</option>'
          );
         
        $.each(data,function(){
          $('select[name=centre_code]').append(
            '<option value="'+this["centre_code"]+'">'+this["centre_code"]+' - '+this["centre_name"]+'</option>'
          );
          
        });
       
        $('select[name=centre_code]').select2({
          data:data
        });
       
        $('select[name=centre_code] option[value=undefined]').remove();
        

      }
    });
}
function get_specific_subjects_based_centre_code(){
    $('select[name=centre_code]').change(function(){
        var centre_code = $(this).val(),
        level_type = centre_code.charAt(0);
        $.ajax({
            url: 'php/get_subjects_per_level.php',
            method: 'POST',
            data: {level_type:level_type},
            dataType: 'json',
            success: function(data){
                $('select[name=subject] option').remove();
              $('select[name=subject]').append(
                '<option selected disabled>Select Subject</option>'
              );
              $.each(data,function(){
                $('select[name=subject]').append(
                '<option value="'+this["subject_code"]+':'+this["subject_name"]+'">'+this["subject_code"]+' - '+this["subject_name"]+'</option>'
              );
              });
              $('select[name=subject]').select2({
                data:data
              });
            }
        });

    });
}
  
    function submit_improvised(){
        $('#improvised_mark').submit(function(e){
            e.preventDefault();
            var centre_code = $('select[name=centre_code]').val();
            // alert(centre_code);
            $.ajax({
                url: 'php/insert_improvised.php',
                method: 'POST',
                data:  $(this).serialize() + '&centre_code=' + encodeURIComponent(centre_code),
                dataType: 'json',
                beforeSend: function(){
                    $('button[type=submit]').attr('disabled',true);
                    $('.load').html('<img src="../images/loading.gif" style="transform:scale(.7) translateY(-100%) translateX(-50%);left:50%;position:absolute;"/>');
                },
                success: function(data){
                    if(data.status == '400'){
                        $('.dialog').text(data.response_msg).dialog('open');
                    }else{
                        $('#improvised_mark').trigger('reset');
                       location.reload();
                    }
                    $('table.table#improvised_marks_tble tbody tr.null').remove();
                    $('button[type=submit]').attr('disabled',false);
                    $('.load').text('');
                    $('#improvised_mark').trigger('reset');
                    
                
                }
               
            });
         });
    }
    
    function get_improvised_marks(){

        $.ajax({
            url: 'php/get_improvised_marks.php',
            method: 'POST',
            dataType: 'json',
            success: function(data){
                if(data.status == '400'){
                    $('table.table#improvised_marks_tble tbody').prepend('<tr class="null">'+

                        '<td colspan="6">No improvised marks added</td>'+
                        '</tr>');
                }else{
                   $.each(data,function(){
                    $('table.table#improvised_marks_tble tbody').append('<tr class="'+this["exam_no"]+'">'+

                        '<td>'+this["exam_no"]+'</td>'+
                        '<td>'+this["centre_code"]+'</td>'+
                        '<td>'+this["subject_code"]+'</td>'+
                        '<td>'+this["paper_no"]+'</td>'+
                        '<td>'+this["mark"]+'</td>'+
                        '<td>'+this["belt_no"]+'</td>'+
                        '<td>'+this["date_entered"]+'</td>'+
                        '</tr>');
                   });

                    $('table.table#improvised_marks_tble tbody tr.null').remove();
                    $('table.table#improvised_marks_tble tbody tr.undefined').remove();
                    table_onclik()
                }
            }
        });
    }
    function update_improvised_mark(){
        $('button.update').click(function(){
            var exam_number = $('input[type=hidden][name=exam_number]').val(),
                subject_code = $('input[type=hidden][name=subject_name]').val(),
                belt_no = $('input[type=hidden][name=belt_no]').val(),
                mark = $('input[type=number][name=mark]').val();
                // alert(exam_no);
            $.ajax({
                url: 'php/update_improvised_mark.php',
                method: 'POST',
                data: {exam_no:exam_number,subject_code:subject_code,belt_no:belt_no,mark:mark},
                dataType: 'json',
                success:function(data){
                    if(data.status == '200'){
                        $('#improvised_marks_tble tbody tr.'+data.exam_no).find("td").eq(4).text(data.mark);
                        $('#improvised_marks_tble tbody tr.'+data.exam_no).find("td").eq(5).text(data.belt_no);
                        cancel();
                    }else{
                        $('.dialog').text(data.response_msg).dialog('open')
                    }
                }
            });
        });
    }
    function delete_from_improvised(){
            $('button.delete').click(function(){
                $('.dialog1').text('Are you sure you want to delete candidate from improvised marksheet?').dialog('open');
            });
            
    }
    function delete_candidate(){
        var exam_number = $('input[type=hidden][name=exam_number]').val(),
            subject_code = $('input[type=hidden][name=subject_name]').val(),
            centre_code = $('input[type=hidden][name=centre_code]').val();

            $.ajax({
                url: 'php/delete_improvised_candidate.php',
                method: 'POST',
                data: {exam_no:exam_number,subject_code:subject_code,centre_code:centre_code},
                dataType: 'json',
                success:function(data){
                    if(data.status == '200'){
                        cancel();
                       location.reload();

                    }else{
                        $('.dialog1').text(data.response_msg).dialog('open');
                    }
                }
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