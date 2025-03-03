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
        .question{
            max-height:15rem;
            overflow:auto;
        }
       
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
        <div class="col-md-6"><h4>Improvised Marks Entry</h4> </div>
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
            <div class="max_mark">MAXIMUM MARK: <span class="max_mark"></span></div>
            <form action="" id="improvised_mark" class="border-bottom border-dark p-3">
                <div class="row">
                    <div class="col-md-6">
                        <p>Center Code:
                            <select name="centre_code" id="centre_code" class="select">

                            </select>
                            
                        </p>
                    </div>
                    <div class="col-md-6">
                        <p>EXAM NO:
                            <input type="nmber" name="exam_no" class="form-control" id="examnumber" required>
                        </p>
                    </div>
                    
                </div>
                <div class="row">
                <div class="col-md-6">
                        <p>Subject:
                            <select name="subject" id="subject" class="select">

                            </select>
                            <!-- <input type="text" class="form-control" required> -->
                        </p>
                    </div>
                    <div class="col-md-6">
                        <p>Paper:
                            <select name="paper" id="paper" class="select">

                            </select>
                            <!-- <input type="text" class="form-control" required> -->
                        </p>
                    </div>
                    <input type="hidden" name="subject_name">
                    <input type="hidden" name="paper_number">
                    <input type="hidden" name="exam_number">
                    <input type="hidden" name="question">

                    <input type="hidden" name="max_mark">
                </div>
                <div class="row">
                <div class="col-md-6">
                        <div class="question" >
                        <!-- <p>Question <span class="question_number"></span>:
                            <input type="number" name="mark" class="form-control" id="mark" required>
                        </p> -->
                        </div>
                       
                    </div>
                    <div class="col-md-6">
						<label class="font-weight-bold" for="">Candidate Type:</label>
						<select name="candidate_type" class="select" id="" required>
                        <option value="0">MAINSTREAM </option>
							<option value="1">SEN</option>
						</select>
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
<<<<<<< HEAD
                <!-- <input type="text" name="mark" class="form-control d-none" id="mark" required> -->
=======
                <input type="text" name="mark" class="form-control d-none" id="mark" >
>>>>>>> 8bbe7d47ad1303c881251035e3bfd60cb9a3b57c
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
            <th class="text-center">Centre Code</th>
            <th class="text-center">Subject </th>
            <th class="text-center">Paper</th>
            <th class="text-center">Q</th>
            <th class="text-center">Mark</th>
            
            
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

        // $('#examnumber').mask("000000000000");
        // $('#mark').mask("000");
        // $('.mark').mask("000");

        get_subjects();
        get_paper();
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
            $('#mark').removeClass('d-none');
            $('#savediv').addClass('d-none');
            var examnumber = $(this).find("td").eq(0).html();
            var center = $(this).find("td").eq(1).html();
            var subject_name = $(this).find("td").eq(2).html();
            var paper = $(this).find("td").eq(3).html();
            var question = $(this).find("td").eq(4).html();
            var mark = $(this).find("td").eq(5).text();
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
            $('input[type=hidden][name=paper_number]').val(paper);
            $('input[type=hidden][name=exam_number]').val(examnumber);
            $('input[type=hidden][name=question]').val(question);


            // $("#subject").val(subjec_name).trigger("change");
           
            console.log("SUB:",subject)
            $("#subject").select2(); 
            $('#paper').val(paper);
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
            $('#mark').addClass('d-none');
            $('#examnumber').val("");
            $('#center').val("");
            $('#subject').val("");
            $('#paper').val("");
            $('#mark').val("");

            $('#box-title').text('New Apportionment');
            activeRow.removeClass('active');
            $('input[type=text][name=centre_code]').attr('readonly',false);
            $('.school_name').text('');
            $('input[type=number][name=script_no]').attr('title','');

            $('select[name=subject]').attr('disabled',false);
            $('select[name=paper]').attr('disabled',false);
            $('select[name=centre_code]').attr('disabled',false);
            $('select[name=candidate_type]').attr('disabled',false);
            $('input[name=exam_no]').attr('readonly',false);
            $('input[name=mark]').val('');
            $('input[type=hidden][name=subject_name]').val('');
            $('input[type=hidden][name=paper_number]').val('');
            $('input[type=hidden][name=exam_number]').val('');
         });
}



function centerFocusedInput() {
      var container = $('.question');
      //var focusedInput = $('.focused-input');
      var focusedInput = $('.mark:focus');

      // Calculate the new scrollTop to center the focused input
      var newScrollTop = focusedInput.offset().top - container.offset().top + container.scrollTop() - (container.height() / 2) + (focusedInput.height() / 2);

      // Animate the scroll to the new position
      container.animate({
        scrollTop: newScrollTop
      }, 200);
    }


        

function get_subjects(){
    $.ajax({
          url: 'php/get_subject.php',
          method: 'POST',
          dataType: 'json',
          success:function(data){
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
  }
  function get_paper(){
    $('select[name=subject]').change(function(){
          var subject = $(this).val().split(':'),
                subject_code = subject[0];
          $.ajax({
            url: 'php/get_paper.php',
            method: 'POST',
            data:{subject_code:subject_code},
            dataType: 'json',
            success:function(data){
              $('select[name=paper] option').remove();
              $('select[name=paper]').append(
                '<option value="" selected disabled>Select Paper Number</option>'
              );
              $.each(data,function(){
                $('select[name=paper]').append(
                '<option value="'+this["paper_no"]+'">'+this["paper_no"]+'</option>'
              );
              });
              
            }
          });
        //   get_apportioned_belts(subject_code);
        //   get_belt(subject_code);
        get_max_mark(subject_code,);
        show_text_boxes(subject_code);
        });
  }
function get_max_mark(subject_code){
    $('select[name=paper]').change(function(){
        var paper_no = $(this).val();
        $.ajax({
            url: 'php/get_max_mark.php',
            method: 'POST',
            data: {subject_code:subject_code,paper_no:paper_no},
            dataType: 'json',
            success:function(data){
                $('input[type=hidden][name=max_mark]').val(data.max_mark);
                $('span.max_mark').text(data.max_mark);
            }
        });
    });
}
function show_text_boxes(subject_code){
        // $(document).on('keyup','input[type=number][name=exam_no]',function(){
        //     var exam_no = $(this).val();
        // });
    $('select[name=paper]').change(function(){
        var paper_no = $(this).val();
        $.ajax({
            url: 'php/show_question_number.php',
            method: 'POST',
            data: {subject_code:subject_code,paper_no:paper_no},
            dataType: 'json',
            success:function(data){
                if(data.status == '400'){
                        $('.dialog').text(data.response_msg).dialog('open');
                }else{
                        $.each(data,function(){
                                $('div.question').append(
                                        '<p class="'+this["id"]+'">Question <span class="question_number">'+this["question"]+'</span>:'+
                                        '<input type="text" pattern="[0-9]+" name="mark['+this["question"]+']" maxlength="3"value="0" class="form-control mark" id="mark">'+
                                        '</p>'
                                );
                        });
                        $('div.question p.undefined').remove();
                        $('.mark').mask("000");
                        $('.mark').focus(function(){
                            $(this).select();
                        });

                }

                press_enter()
                
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
        $('select[name=centre_code] option').remove();

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

//   $('#save').click(function(){
//     alert('hi')
//   });
    function submit_improvised(){
        
        $('#improvised_mark').submit(function(e){
            e.preventDefault();
            // alert('hi')
            $.ajax({
                url: 'php/insert_improvised_question.php',
                method: 'POST',
                data: $('#improvised_mark').serialize(),
                dataType: 'json',
                beforeSend: function(){
                    $('button[type=submit]').attr('disabled',true);
                    $('.load').html('<img src="../images/loading.gif" style="transform:scale(.7) translateY(-100%) translateX(-50%);left:50%;position:absolute;"/>');
                },
                success: function(data){
                    if(data.status == '400'){
                        $('.dialog').text(data.response_msg).dialog('open');
                    }else{
                    $.each(data,function(){

                   
                        $('table.table#improvised_marks_tble tbody').prepend('<tr class="'+data.exam_no+'">'+

                        '<td>'+this["exam_no"]+'</td>'+
                        '<td>'+this["centre_code"]+'</td>'+
                        '<td>'+this["subject_name"]+'</td>'+
                        '<td>'+this["paper_no"]+'</td>'+
                        '<td>'+this["question"]+'</td>'+
                        '<td>'+this["mark"]+'</td>'+
                        '<td>'+this["date_entered"]+'</td>'+
                        '</tr>');
                    });
                        table_onclik();
                        
                    
                    $('table.table#improvised_marks_tble tbody tr.null').remove();
                    $('button[type=submit]').attr('disabled',false);
                    $('.load').text('');
                    $('#improvised_mark').trigger('reset');
                    location.reload();
                }
                    
                
                }
               
            });
         });
    }
    

    function press_enter(){
        $('.mark').click(function(){
            $(this).select();
        });
        
        $('body').on('keydown', 'input', function(e) {
            //e.preventDefault()
            console.log("Pressed: ",e.which)
            var self = $(this), form = self.parents('form:eq(0)'), focusable, next,prev
            focusable = form.find('.mark').filter(':visible').filter(':not(:disabled)');
                if(e.which=='13' || e.which == '40'){
                    //console.log("NEXTING..")
                    next = focusable.eq(focusable.index(this)+1).select();
                    //console.log('NEXT:',next)
                   
                    if (next.length) {
                        next.focus();
                        centerFocusedInput()
                    }
                    return false;

                }
                else if (e.which=='38'){
                    prev = focusable.eq(focusable.index(this)-1).select();
                   // console.log('PEV:',prev)
                  //  console.log("Preving..")
                    if (prev.length) {
                        prev.focus();
                        centerFocusedInput()
                    }
                    return false;
                }
        });
    }


    function get_improvised_marks(){

        $.ajax({
            url: 'php/get_improvised_marks_questions.php',
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
                        '<td>'+this["subject_name"]+'</td>'+
                        '<td>'+this["paper_no"]+'</td>'+
                        '<td>'+this["question"]+'</td>'+
                        '<td>'+this["mark"]+'</td>'+
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
                subject_name = $('input[type=hidden][name=subject_name]').val(),
                paper_number = $('input[type=hidden][name=paper_number]').val(),
                question = $('input[type=hidden][name=question]').val(),
                mark = $('input[type=number][name=mark]').val();
                // alert(exam_no);
            $.ajax({
                url: 'php/update_improvised_mark_question.php',
                method: 'POST',
                data: {exam_no:exam_number,subject_name:subject_name,paper_no:paper_number,question:question,mark:mark},
                dataType: 'json',
                success:function(data){
                    if(data.status == '200'){
                        $('#improvised_marks_tble tbody tr').find("td").eq(5).text(data.mark);
                        cancel();
                    }else{
                        $('.dialog').text(data.response_msg).dialog('open');
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
            subject_name = $('input[type=hidden][name=subject_name]').val(),
            paper_number = $('input[type=hidden][name=paper_number]').val(),
            question = $('input[type=hidden][name=question]').val();

            $.ajax({
                url: 'php/delete_improvised_candidate_question.php',
                method: 'POST',
                data: {exam_no:exam_number,subject_name:subject_name,paper_no:paper_number,question:question},
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