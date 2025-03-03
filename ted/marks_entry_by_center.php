<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">



<?php include 'includes/header.php';

if($_SESSION['user_type']  == 'DEO'){
?>
<body>
    <div class="main-wrapper">

<?php include 'includes/navbar.php'?>     

<?php include 'includes/sidebar.php'?>
<style>
    .maxvalue-error{
        position: absolute;
        z-index: 10000;
        /* display: block ruby; */
    }
</style>

        <div class="page-wrapper">
			<div class="content p-5 " id="parameters">
			<div class="items p-3 ">
				<div class="row justify-content-center">
					<div class="col-md-9 alert alert-info">
						<h3 class="text-center">Please select search parameters</h3> 
					</div>
					
				</div>
				<div class="dialog"></div>
				
				<form action="" method="post" id="parameters-form">
				<div class="row align-items-center p-2">
					
					<div class="col-md-4 col-sm-6">
						<label class="font-weight-bold" for="">Select Centre:</label>
						<select name="centre" class="select" id="" required>
						</select>
					</div>
					<div class="col-md-4 col-sm-12">
						<label class="font-weight-bold" for="">Select Subject:</label>
						<select name="subject" class="select" id="" required>
						</select>
					</div>
					<!-- <div class="col-md-4 col-sm-6">
						<label class="font-weight-bold" for="">Select Paper:</label>
						<select name="paper" class="select" id="" required>
						</select>
					</div> -->
					<div class="col-md-4 col-sm-6">
						<label class="font-weight-bold" for="">Select Status:</label>
						<select name="status" class="select" id="" required>
							<option value="" selected>Select Status</option>
							<option value="L">Missing (L)</option>
							<option value="X">  Absent (X)</option>
							<option value="-">  Entered Mark (-)</option>
						</select>
					</div>
                    <div class="col-md-4 col-sm-6">
						<label class="font-weight-bold" for="">Candidate Type:</label>
						<select name="candidate_type" class="select" id="" required>
                        <option value="0">MAIN STREAM </option>
							<option value="1">SEN</option>
						</select>
					</div>
                    <div class="col-md-4 col-sm-6">
                    <label class="font-weight-bold belt_no" for="">Belt number:</label>
                        <input type="number" name="belt_no" min="1" placeholder="0" required style="width:50px;">
                    </div>
                   
				</div>
				<div class="buttons p-3">
					<button type="submit" id="btn-submit" class="btn btn-success d-block ml-auto mr-auto">Submit</button>
				</div>
				
				
			</form>
            
           
			</div>
			</div>
            <div class="content pt-1 d-none" id="result">
                <div class="row pt-0">
                    <div class="col-md-12 ">
                        <h4 class="page-title mb-2">Marks Entry By Centre</h4>
                    </div>
                </div>

                <div class="border p-1 mt-0 mb-1 bg-light">
                <div class="row">
                    <div class="col-md-2">Level: <span class="level"><?php echo $_SESSION['session_level']; ?></span></div>
                    <div class="col-md-2">SUBJECT CODE: <span class="subject_code"></span></div>
                    <div class="col-md-5">SUBJECT NAME: <span class="subject_name"></span></div>
                    <div class="col-md-3">CENTRE CODE: <span class="centre_code"></span></div>
                    <div class="col-md-3">BELT NUMBER: <span class="belt_no"></span></div>
                </div>
                <div class="row ">
                    <div class="col-md-2">SESSION: <span class="session_id"><?php echo $_SESSION['session_id']; ?></span></div>
                    <div class="col-md-2">NO. OF RECORD(S): <span class="record_count"></span></div>
                    <div class="col-md-8">CENTRE NAME <span class="centre_name"></span></div>
                    <div class="col-md-8">YEAR <span class="year"><?php echo $_SESSION['session_year']; ?></span></div>
                    <div class="col-md-8">MAXIMUM MARK <span class="max_mark"></span></div>
                    
                </div>
                </div>
                

				<div class="row">
					<div class="col-md-4 col-sm-6">
						<input type="text" id="search" class="form-control mb-1" placeholder="Search">
					</div>
					
				</div>
                <div class="row">
					<div class="col-md-12">
                    <div class="dialog1"></div>
                    <div class="dialog2"></div>
                    <div class="dialog3"></div>
                    <div class="dialog4"></div>
                    <form action="" method="" id="marksheet-form">    
                        <div class="">
							<table class="table table-sm table-border table-striped custom-table mb-0"  >  <!---->
								<thead class="sticky sticky-top" id="table-head">
									<tr>
										<th>EXAM NO.</th>
										<th>FIRST NAME</th>
										<th>LAST NAME</th>
                                        <th>ABSENT</th>
										<th>MARK</th>
										<th>STATUS</th>
                                        
										<th>ENTERED BY</th>
										<th>DATE ENTERED</th>
                                        <!-- <th class="mark2" style="visibility: hidden;">STATUS</th> -->
									</tr>
								</thead>
								<tbody class="marks-table">
                                
								
                              
								</tbody>
							</table>
                            <input type="hidden" name="subject_code" value="" />
                            <input type="hidden" name="centre_code" value="" />
                            <input type="hidden" name="sen" value="" />
                            <input type="hidden" name="belt_no" value="" />

                            <input type="hidden" name="username" value="<?php echo $_SESSION['first_name'],' ',$_SESSION['last_name']; ?>" />
						</div>
                        <div class="row fixed-bottom p-3">
                        <div id="subject-help" class=" d-none "> <strong class="green-ecz">SUBJECT: <span class="subject_name"></span>.  PAPER: <span>2</span> | BELT: <span class="belt_no"></span></strong>  </div>                            <span class="mr-auto ml-auto ">
                                <button id="submit_marksheet" class="btn btn-primary " type="submit">submit</button>
                            </span>
                            <div id="row-count" class=" d-none float-right ml-auto"> <strong class="green-ecz">NUMBER OF RECORD(S): <span class="record_count"></span>  </strong>  </div>
                        </div>
                        
                        </form>
					</div>
                </div>
               
            </div>


    <!-- notifications -->
 <?php include 'includes/notifications.php' ?>

        </div>
    </div>

	<div class="sidebar-overlay" data-reff=""></div>

	
	<?php include 'includes/scripts.php' ?>
    <script src="../assets/js/jquery.dataTables.min.js"></script>
    <script src="../assets/js/dataTables.bootstrap4.min.js"></script>
   
 

</body>
<script>
        $(document).ready(function(){
			// get_schools_in_province();
            get_schools_in_marking_centre();
			get_specific_subjects_based_centre_code();
			// get_paper();
			get_marksheet();
			submit_marks();
			belt_no_disable_status();
            $('.mark').mask('000');
            
      //  $(window).on('scroll',function(){
       //     var divOffset = $('.table-head').offset().top;
       //     console.log("NOW:",divOffset)
        //    var scrollTop = $(window).scrollTop();
        //    if (scrollTop >= divOffset){
        //        $('.subject-help').removeClass('d-none')
        //    }else{
         //       $('.subject-help').addClass('d-none')
        //    }
       // })

        var formValid = true;

        $(window).on('scroll', function() {
            var tableHead = $('#table-head');
            if (tableHead.length === 0) {
              return; // Exit early if .table-head element is not found
            }
            
            var divOffset = tableHead.offset().top;
            //console.log("NOW:", divOffset);
            
            var scrollTop = $(window).scrollTop() + 51;
            //console.log("TOP:", scrollTop);
            
            if (scrollTop >= divOffset) {
              $('#subject-help').removeClass('d-none');
            } else {
              $('#subject-help').addClass('d-none');
            }
          });

		$('.dialog').dialog({
        title: 'REQUEST RESPONSE',
        width: '450',
        height: '150',
        modal: true,
        draggable: false,
        resizable: false,
        closeOnEscape: false,
        // appendTo: '#parameters-form',
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
		$('.dialog1').dialog({
        title: 'REQUEST RESPONSE',
        width: '450',
        height: '150',
        modal: true,
        draggable: false,
        resizable: false,
        closeOnEscape: false,
        appendTo: '#submit_marksheet',
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
                    if (formValid){
                        update_marks();
                    }
                    
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
        appendTo: '#submit_marksheet',
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
    $('.dialog3').dialog({
        title: 'REQUEST RESPONSE',
        width: '450',
        height: '150',
        modal: true,
        draggable: false,
        resizable: false,
        closeOnEscape: false,
        appendTo: '#submit_marksheet',
        autoOpen: false,
        create: function(e){
            $(e.target).parent().css({
                'position':'fixed'
            }); 
            
        },
        buttons: [
            {
                text: 'YES',
                click: function(){
                    window.open('reports/transcription_checklist.php','_blank');
                    $(this).dialog('close');
                }
            },
            {
                text: 'NO',
                click: function(){
                    // $('#result').addClass('d-none');
					// $('#parameters').removeClass('d-none');
                    location.reload();
                    $(this).dialog('close');
                }
            }
        ]
    });
//     function page_reload(){
//         window.onbeforeunload = function ()
// {
//     return false;
// }
//     }

function belt_no_disable_status(){
        $('select[name=status]').change(function(){
            var status= $(this).val();
            if(status == "L"){
                $('label.belt_no').css('display','block');
                $('input[type=number][name=belt_no]').attr({'required': true,'disabled': false});
            }else{
                $('label.belt_no').css('display','none');
                $('input:number[name=belt_no]').attr({'required': false,'disabled': true});
            }
        });
    }
	function press_enter(){
        $('.mark').click(function(){
            $(this).select();
        });
        $('body').on('keydown', 'input', function(e) {
            $('input[type=text].mark').on('input', function() {
            let value = $(this).val();
                if ($.isNumeric(value)) {
                    $(this).closest('tr').find('td:nth-child(7)').children().val(username);
                    $(this).closest('tr').find('td:nth-child(8)').children().val(current_date_time);
                    $(this).closest('tr').find('td:nth-child(6)').children().val('-');

                    let newValue = value.replace(/^0+/, '');
                    if (newValue === '') {
                        newValue = '0';
                    }
                    $(this).val(newValue);
                }
        });
            var mark = $(this).val(),
            
            dt = new Date(),
            month = (dt.getMonth() + 1).toString(),
            month = month.length > 1 ? month : '0' + month,
            day = dt.getDate().toString(),
            day = day.length > 1 ? day : '0' + day,
            minute = dt.getMinutes().toString(),
            minute = minute.length > 1 ? minute : '0' + minute,
            hour = (dt.getHours() - 1).toString(),
            hour = hour > 1 ? hour : '0' + hour,
            seconds = dt.getSeconds().toString(),
            seconds = seconds.length > 1 ? seconds : '0' + seconds,
            username = $('input[type=hidden][name=username]').val(),
            current_date_time = day+'/'+month+'/'+dt.getFullYear()+' '+hour+':'+minute+':'+seconds;
            $(this).closest('tr').find('td:nth-child(7)').children().val(username);
            $(this).closest('tr').find('td:nth-child(8)').children().val(current_date_time);

            if (e.which === 13 || e.which === 40 ) {
            var self = $(this), form = self.parents('form:eq(0)'), focusable, next,
                username = $('input[type=hidden][name=username]').val(),
                
                    current_date_time = day+'/'+month+'/'+dt.getFullYear()+' '+hour+':'+minute+':'+seconds;
            if(mark.length > 0){

                //console.log("Value is",mark);
                var maxmark=$('span.max_mark').text()
                validatemaxmark(mark,Number(maxmark),$(this))
                $(this).closest('tr').find('td:nth-child(6)').children().val('-');
                $(this).closest('tr').find('td:nth-child(7)').children().val(username);
                $(this).closest('tr').find('td:nth-child(8)').children().val(current_date_time);
            
                
            }
            focusable = form.find('.mark').filter(':visible').filter(':not(:disabled)');
            next = focusable.eq(focusable.index(this)+1).select();
            if (next.length) {
                next.focus();
            }
            return false;
            }

            // UP ARROW
            if (e.which === 38 ) {
            var self = $(this), form = self.parents('form:eq(0)'), focusable, prev,
                username = $('input[type=hidden][name=username]').val(),
                
                    current_date_time = day+'/'+month+'/'+dt.getFullYear()+' '+hour+':'+minute+':'+seconds;
            if(mark.length > 0){

                //console.log("Value is",mark);
                var maxmark=$('span.max_mark').text()
                validatemaxmark(mark,Number(maxmark),$(this))
                $(this).closest('tr').find('td:nth-child(6)').children().val('-');
                $(this).closest('tr').find('td:nth-child(7)').children().val(username);
                $(this).closest('tr').find('td:nth-child(8)').children().val(current_date_time);
            
                
            }
            focusable = form.find('.mark').filter(':visible').filter(':not(:disabled)');
            prev = focusable.eq(focusable.index(this)-1).select();
            if (prev.length) {
                prev.focus();
            }
            return false;
            }


        });
            $('body').on('keyup', 'input[type=text].mark', function(e) {
                var mark = $(this).val();
                var field=$(this).attr('name')
                var maxmark=$('span.max_mark').text()
                //console.log("MAX MARK IS:",maxmark)
                validatemaxmark(mark,Number(maxmark),$(this))
            });


      $('input[type=text].mark').focus(function(){
        console.log("Forcused")
            console.log($(this).val)
            var ele = $(this);
            $('html, body').animate(
                {
                scrollTop: ele.offset().top - 280
                }, 100);

        });
    
      $(":checkbox").on("change", function() {
        var chx = $(this).is(':checked'),
         targetRow = $(this).closest('tr'),
         username = $('input[type=hidden][name=username]').val(),
         exam_no = $(this).val(),

         dt = new Date(),
        month = (dt.getMonth() + 1).toString(),
        month = month.length > 1 ? month : '0' + month,
        day = dt.getDate().toString(),
        day = day.length > 1 ? day : '0' + day,
        minute = dt.getMinutes().toString(),
        minute = minute.length > 1 ? minute : '0' + minute,
        hour = (dt.getHours() - 1).toString(),
        hour = hour > 1 ? hour : '0' + hour,
        seconds = dt.getSeconds().toString(),
        seconds = seconds.length > 1 ? seconds : '0' + seconds,
          current_date_time = day+'/'+month+'/'+dt.getFullYear()+' '+hour+':'+minute+':'+seconds;
        targetRow.find('input:text').prop("readonly", chx);
        if (chx){
            targetRow.find('td:nth-child(6)').children().val('X');
            targetRow.find('td:nth-child(7)').children().val(username);
            targetRow.find('td:nth-child(8)').children().val(current_date_time);
            make_absent(exam_no);
        }else{
            targetRow.find('td:nth-child(6)').children().val('L');
            targetRow.find('td:nth-child(7)').children().val(username);
            targetRow.find('td:nth-child(8)').children().val(current_date_time);
            make_missing(exam_no);
        }
        
     });
    }
	//  function get_schools_in_province(){
	// 	$.ajax({
    //             url: 'php/get_schools.php',
    //             method: 'POST',
    //             dataType: 'json',
    //             success: function(data){
                    
    //                 if(data.status == '200'){
	// 					$('select[name=centre] option').remove();
	// 					$('select[name=centre]').append(
	// 						'<option value ="" selected></option>'
	// 					);
	// 					$.each(data,function(){
	// 						$('select[name=centre]').append(
	// 						'<option value ="'+this["centre_code"]+'">'+this["centre_code"]+' - '+this["centre_name"]+'</option>'
	// 					);
	// 					});
    //                     $('select[name=centre]').select2({
	// 						data:data
	// 					});
    //                 }
    //             }
    //         });
	//  }
    function make_absent(absent_exam_no){
        var centre_code = $('input[type=hidden][name=centre_code]').val(),
        subject_code = $('input[type=hidden][name=subject_code]').val(),
        paper_no =  $('input[type=hidden][name=paper_no]').val();

        $.ajax({
            url: 'php/update_marks.php',
            method: 'POST',
            data: {absent_exam_no:absent_exam_no,centre_code:centre_code,subject_code:subject_code,paper_no:paper_no},
            dataType: 'json',
            success: function(data){
                if(data.status == '200'){
                }else{
                    $('.dialog2').text(data.response_msg).dialog('open');
                }
            }
        });
    }
    function make_missing(missing_exam_no){
        var centre_code = $('input[type=hidden][name=centre_code]').val(),
        subject_code = $('input[type=hidden][name=subject_code]').val(),
        paper_no =  $('input[type=hidden][name=paper_no]').val();

        $.ajax({
            url: 'php/update_marks.php',
            method: 'POST',
            data: {missing_exam_no:missing_exam_no,centre_code:centre_code,subject_code:subject_code,paper_no:paper_no},
            dataType: 'json',
            success: function(data){
                if(data.status == '200'){
                }else{
                    $('.dialog2').text(data.response_msg).dialog('open');
                }
            }
        });
    }
     function get_schools_in_marking_centre(){
		$.ajax({
                url: 'php/get_schools_in_marking_centre.php',
                method: 'POST',
                dataType: 'json',
                success: function(data){
                    
                    if(data.status == '200'){
						$('select[name=centre] option').remove();
						$('select[name=centre]').append(
							'<option value ="" selected select subject>Select centre</option>'
						);
						$.each(data,function(){
							$('select[name=centre]').append(
							'<option value ="'+this["centre_code"]+'">'+this["centre_code"]+' - '+this["centre_name"]+'</option>'
						);
						});
                        $('select[name=centre]').select2({
							data:data
						});
                    }
                }
            });
	 }
     function get_specific_subjects_based_centre_code(){
    $('select[name=centre]').change(function(){
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
	//  function get_subjects(){
	// $.ajax({
    //       url: 'php/get_subject.php',
    //       method: 'POST',
    //       dataType: 'json',
    //       success:function(data){
    //           $('select[name=subject]').append(
    //             '<option value="" selected disabled>Select Subject</option>'
    //           );
    //           $.each(data,function(){
    //             $('select[name=subject]').append(
    //             '<option value="'+this["subject_code"]+'">'+this["subject_code"]+' - '+this["subject_name"]+'</option>'
    //           );
    //           });
    //           $('select[name=subject]').select2({
	// 				data:data
	// 			});
    //       }
    //     });
    // }
	// function get_paper(){
	// 	$('select[name=subject]').change(function(){
    //       var subject_code = $(this).val();
    //       $.ajax({
    //         url: 'php/get_paper.php',
    //         method: 'POST',
    //         data:{subject_code:subject_code},
    //         dataType: 'json',
    //         success:function(data){
    //           $('select[name=paper] option').remove();
    //           $.each(data,function(){
    //             $('select[name=paper]').append(
    //             '<option value="'+this["paper_no"]+'">'+this["paper_no"]+'</option>'
    //           );
    //           });
    //         }
    //       });
    //     });
	// }
	function get_marksheet(){
	$('#parameters-form').submit(function(e){
		e.preventDefault();
		$.ajax({
			url: 'php/marksheet.php',
			method: 'POST',
			data: $('#parameters-form').serialize(),
			beforeSend: function(){
                    $('buton[type=submit]').attr('disabled',true).html('<img src="../images/loading.gif" style="transform:scale(.3);" />');
                    // $('img.loading').css('display','block');
                    // $('.school_name').html('<img src="../images/loading.gif" style="transform:scale(.3);" />');
                    },
			success: function(data){
				$('table.table tbody tr').remove();
				if(data.status == '400'){
					$('.dialog').text(data.response_msg).dialog('open');
					$('buton[type=submit]').attr('disabled',false).text('SUbmit');
				}else{
					$('span.subject_code').text(data.subject_code);
					$('span.subject_name').text(data.subject_name);
					$('span.centre_code').text(data.centre_code);
					$('span.centre_name').text(data.centre_name);
					$('span.belt_no').text(data.belt_number);
					$('span.record_count').text(data.record_count);
                    
                    $('span.max_mark').text(data.max_mark);

                    $('input[type=hidden][name=centre_code]').val(data.centre_code);
                    $('input[type=hidden][name=subject_code]').val(data.subject_code);
                    $('input[type=hidden][name=sen]').val(data.sen);
                    $('input[type=hidden][name=belt_no]').val(data.belt_number);
					$.each(data.candidate,function(){
						$('table.table tbody').append('<tr id="'+this["exam_no"]+'">'+
						'<td>'+this["exam_no"]+'</td>'+
						'<td>'+this["first_name"]+'</td>'+
						'<td>'+this["last_name"]+'</td>'+
						'<td><input type="checkbox" name="absent" value="'+this["exam_no"]+'" id=""></td>'+
						'<td>'+
                            '<input type="text" class="form-control mark" name="raw_mark['+this["exam_no"]+']" value="'+this["mark"]+'" maxlength="3" pattern="[0-9]+" max="'+this["max_mark"]+'" placeholder="0" style="width:40px;" required/>'+
                            '<div class="col-2 maxvalue-error invalid-feedback" id="error_raw_mark['+this["exam_no"]+']" role="alert">'+
                           ' <div class="alert alert-danger mt-3 p-1" >'+
                            '<span class="text-center">Exceeded Max Allowed Mark !!</span> '+
                           ' </div>'+
                           ' </div>'+
                        '</td>'+
						'<td><input type="text" class="borderless" name="status['+this["exam_no"]+']" value="'+this["status"]+'" style="width:20px;" readonly/></td>'+
						'<td><input type="text" class="borderless" name="entered_by['+this["exam_no"]+']" value="'+this["entered_by"]+'" readonly/></td>'+
						'<td><input typr="text" class="borderless" name="date_entered['+this["exam_no"]+']" value="'+this["date_entered"]+'" readonly/></td>'+
						'</tr>');
					});
                    $('#parameters-form').trigger('reset');
					$('#result').removeClass('d-none');
					$('#parameters').addClass('d-none');
					$('buton[type=submit]').attr('disabled',false).text('Submit');
                    press_enter();
                    // page_reload();

				}
			}
		});
				
			});
		}
        function submit_marks(){
                $('#marksheet-form').submit(function(e){
                    e.preventDefault();
                    $("input[type=text].mark").each(function() {
                       if ($(".mark").hasClass("is-invalid")){
                        formValid=false
                       }else{
                        formValid=true
                       }
                    })
                    if(formValid){
                        $('.dialog1').text('Are you sure you want to save marks?').dialog('open');
                    }
                   
                   
                    
                });
        }
        function update_marks(){
            
            $.ajax({
                url: 'php/update_marks.php',
                method: 'POST',
                data:  $('#marksheet-form').serialize(),
                dataType: 'json',
                beforeSend:function(){
                    $('buton[type=submit]').attr('disabled',true).html('<img src="../images/loading.gif" style="transform:scale(.3);" />');
                },
                success: function(data){
                    if(data.status == '400'){
                        $('.dialog2').text(data.response_msg).dialog('open');
                        $('buton[type=submit]').attr('disabled',false).text('Submit');
                    }else{
                        $('.dialog3').text(data.response_msg+' Generate transcription checklist?').dialog('open');
                        $('buton[type=submit]').attr('disabled',false).text('Submit');
                        
                    }
                }

            });
        }
	});

    function validatemaxmark(current,maxmark,eve){
        if (current> maxmark){
            console.log("TOO HIGH VALUE");
            eve.addClass("is-invalid");
            formValid = false;
        }
        else{
            eve.removeClass("is-invalid");
            formValid = true;
        }
    }
   </script>

<?php
}else{
    header('location: ../');
}
?>

</html>