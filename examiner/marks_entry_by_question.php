
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
    input[type=checkbox], input[type=radio] {
        box-sizing: border-box;
        padding: 0;
        height: 20px;
        width: 20px;
    }
    .invalid_input{
        border: 2px solid red;
    }
    .custom-td{
        max-height: 90px;
        overflow-y: auto;
    }
</style>

        <div class="page-wrapper">
			<div class="content p-5 " id="parameters" >
			<div class="items  ">
            <div class="row justify-content-center mb-4">
					<div class="col-md-12">
                        <p class="text-center h3">Marks Entry Per Question</p>
                    </div>
					
			</div>
				<div class="row justify-content-center mt-5">
					<div class="col-md-9 alert alert-info">
						<h3 class="text-center">Please select search parameters</h3> 
					</div>
					
				</div>
				<div class="dialog"></div>
				
				<form action="" method="post" id="parameters-form" >
				<div class="row align-items-center p-2">
					<?php
                     //  echo $_SESSION['marking_centre_code'];
                    ?>
					<div class="col-md-4 col-sm-6">
						<label class="font-weight-bold" for="">Select Centre:</label>
						<select name="centre" class="select" id="" required>
						</select>
					</div>
					<div class="col-md-4 col-sm-6">
						<label class="font-weight-bold" for="">Select Subject:</label>
						<select name="subject" class="select" id="" required>
						</select>
					</div>
					<div class="col-md-4 col-sm-6">
						<label class="font-weight-bold" for="">Select Paper:</label>
						<select name="paper" class="select" id="" required>
						</select>
					</div>
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
                   
				</div>
				<div class="buttons p-3">
					<button type="submit" id="btn-submit" class="btn btn-success d-block ml-auto mr-auto">Submit</button>
				</div>
				
				
			</form>
			</div>
			</div>

            <div id="auth_chief" class="modal fade add-modal" role="dialog">
                <div class="modal-dialog modal-dialog-centered">
                    
                    <div class="modal-content">
                        <div class="modal-title bg-success">
                            <span> <p class="text-center h4 text-white"><i class="fa fa-lock" aria-hidden="true"></i> Chief Examiner for: <span class="subject_name"></span> PAPER <span class="paper_no"></span></p> </span>
                        </div>
                        <div class="auth"></div>
                        <div class="auth2"></div>
                        <form action="" method="post" id="authorise" autofocus autocomplete="off">
                        <div class="modal-body text-center">
                           
                            <div class="row mt-2">
                                <div class="col-md-12">
                                    <p>Examiner Management System Password</p>
                                    <input type="password" name="password" id="password" placeholder="Password" required class="form-control" autocomplete="off">
                                </div>
                            </div>
                          <input type="hidden" name="centre_code" value="">
                          <input type="hidden" name="subject_code" value="">
                          <input type="hidden" name="paper_no" value="">
                          <input type="hidden" name="chief_examiner_username" value="">
                            <div class="m-t-20"> 
                                <!-- <a href="#" class="btn btn-white" data-dismiss="modal">Cancel</a> -->
                                <img class="loading"  src="../images/loading.gif" style="margin-left:50%;transform:translateX(-50%);display:none;"/>
                                <button type="submit" id="auth" class="btn btn-primary"><i class="fa fa-unlock" aria-hidden="true"></i> Authorise</button>
                            </div>
                        </div>
                    </form>
                    </div>
                </div>
                
            </div>

            <div class="content pt-1 d-none" id="result" >
                <div class="row pt-0">
                    <div class="col-md-12 ">
                        <h4 class="page-title mb-2">Marks Entry By Center</h4>
                    </div>
                </div>

                <div class="border p-1 mt-0 mb-1 bg-light">
                <div class="row">
                    <div class="col-md-2">Level: <span class="level"><?php echo $_SESSION['session_level']; ?></span></div>
                    <div class="col-md-2">SUBJECT CODE: <span class="subject_code"></span></div>
                    <div class="col-md-5">SUBJECT NAME: <span class="subject_name"></span></div>
                    <div class="col-md-3">CENTER CODE: <span class="centre_code"></span></div>
                </div>
                <div class="row ">
                    <div class="col-md-2">SESSION: <span class="session_id"><?php echo $_SESSION['session_id']; ?></span></div>
                    <div class="col-md-2">PAPER CODE: <span class="paper_no"></span></div>
                    <div class="col-md-8">CENTER NAME <span class="centre_name"></span></div>
                    <div class="col-md-8">YEAR <span class="year"><?php echo $_SESSION['session_year']; ?></span></div>
                    <div class="col-md-8">MAXIMUM MARK <span class="max_mark" id="max"></span></div>
                    
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
										<th></th>
										<th> </th>
                                        <th>ABSENT</th>
										<th>SCORE PER QUESTION</th>
                                        <th>TOTAL</th>
										<th>STATUS</th>
                                        
										<th>ENTERED BY</th>
										<th>DATE ENTERED</th>
                                        <!-- <th class="mark2" style="visibility: hidden;">STATUS</th> -->
									</tr>
								</thead>
								<tbody class="marks-table">


                                    <tr>
                                        <td>01</td>
                                        <td></td>
                                        <td></td>
                                        <td>02</td>
                                        <td>012</td>
                                        <td>02</td>
                                        <td>01\</td>
                                    </tr>
								
                              
								</tbody>
							</table>
                            <input type="hidden" name="subject_code" value="" />
                            <input type="hidden" name="paper_no" value="" />
                            <input type="hidden" name="centre_code" value="" />

                            <input type="hidden" name="username" value="<?php echo $_SESSION['first_name'],' ',$_SESSION['last_name']; ?>" />
						</div>
                        <div class="row fixed-bottom p-3">
                            <div id="subject-help" class=" d-none position-absolute"> <strong class="green-ecz">SUBJECT: <span class="subject_name"></span>.  PAPER: <span class="paper_no"></span></strong>  </div>
                            <span class="mr-auto ml-auto ">
                            <img class="loading" src="../images/loading.gif" style="transform: translateX(100%); display:none;"/>
                                <button id="submit_button" class="btn btn-primary " type="submit">submit</button>
                                <button id="validate_button" class="btn btn-primary d-none" type="button">Click to authorise edit</button>
                            </span>

                         
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

<script src="https://cdn.statically.io/gh/kswedberg/jquery-smooth-scroll/3948290d/jquery.smooth-scroll.min.js"></script>
<script>
        $(document).ready(function(){
          
			// get_schools_in_province();
            get_schools_in_marking_centre();
			get_subjects();
			get_paper();
			get_marksheet();
           
			submit_marks();
            
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
        appendTo: '#sidebar',
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
                    update_marks();
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
        appendTo: '#sidebar',
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
                    // location.reload();
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
        appendTo: '#sidebar',
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
                    $('#result').addClass('d-none');
					$('#parameters').removeClass('d-none');
                    location.reload();
                    $(this).dialog('close');
                }
            }
        ]
    });
    $('.auth').dialog({
        title: 'REQUEST RESPONSE',
        width: '450',
        height: '150',
        modal: true,
        draggable: false,
        resizable: false,
        closeOnEscape: false,
        appendTo: '#auth_chief',
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
    $('.auth2').dialog({
        title: 'REQUEST RESPONSE',
        width: '450',
        height: '150',
        modal: true,
        draggable: false,
        resizable: false,
        closeOnEscape: false,
        appendTo: '#auth_chief',
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
                    // location.reload();
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
// $('input').focus(function() {
// var container = $(this).closest('.custom-td');
// container.scrollTop($(this).position().top + container.scrollTop() - container.height() / 2);
// container.animate({ scrollTop: inputTop - (container.height() / 2) }, 'fast');
//  });

	function press_enter(){
        $('.mark').click(function(){
            $(this).select();
        });
    $('body').on('keydown', 'input', function(e) {
        $(this).closest('tr').find('td:nth-child(7)').children().val('-');
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
         $(this).closest('tr').find('td:nth-child(8)').children().val(username);
        $(this).closest('tr').find('td:nth-child(9)').children().val(current_date_time);

        if (e.which === 13 || e.which === 40 ) {
          var self = $(this), form = self.parents('form:eq(0)'), focusable, next,
              username = $('input[type=hidden][name=username]').val(),
               
                current_date_time = day+'/'+month+'/'+dt.getFullYear()+' '+hour+':'+minute+':'+seconds;
          if(mark.length > 0){
            console.log("Value is",mark);
            var maxmark=$('span.max_mark').text()
                validatemaxmark(mark,Number(maxmark),$(this))
            $(this).closest('tr').find('td:nth-child(7)').children().val('-');
            $(this).closest('tr').find('td:nth-child(8)').children().val(username);
            $(this).closest('tr').find('td:nth-child(9)').children().val(current_date_time);
           
            
          }
          focusable = form.find('.mark').filter(':visible').filter(':not(:disabled)').filter(':not([readonly])');;
          next = focusable.eq(focusable.index(this)+1).select();
          if (next.length) {
              next.focus();
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
      


    //    $('input[type=text].mark').focus(function(){
        
    //     var ele = $(this);
    //     var container = $(this).closest('.custom-td');
    //     var inputTop = $(this).position().top + container.scrollTop() - container.offset().top;
    //     console.log("Forcused")

    //     ele.scrollTop(10);
        
    //     var cHeight=container.height()
    //     console.log("Container Height",cHeight)
    //     console.log("Offset",ele.offset().top)
    //     //container.animate({scrollTop: inputTop - (container.height() / 2)},fast)
        
    //     console.log($(this).val)
        
    //     $('html, body').animate(
    //         {
    //             scrollTop: ele.offset().top - 280
    //     }, 100);





    //     });

$('input[type=text].mark').on('focus', function() {
                var ele = $(this);
                var container = ele.closest('.custom-td');
                var containerHeight = container.height();
                var inputTop = ele.offset().top - container.offset().top + container.scrollTop() - containerHeight / 2 + ele.height() / 2;

                if (inputTop > containerHeight) {
                    // Scroll the entire page 
                    $('html, body').animate({
                        scrollTop: ele.offset().top - 280
                    }, 'fast');
                } else {
                    // Scroll only the container
                    container.animate({
                        scrollTop: inputTop
                    }, 'fast');
                }
            });



        $(":checkbox").on("change", function() {
    // Cache the jQuery object for the checkbox
    var chx = $(this);

    // Disable the checkbox and get its ID
   // chx.prop('disabled', true);
    var chx_id = chx.attr('id');
    console.log("ID CHX", chx_id);

    // Get other values
    var exam_no = chx.val();
    var targetRow = chx.closest('tr');
    var username = $('input[type=hidden][name=username]').val();

    // Get the current date and time
    var dt = new Date();
    var month = (dt.getMonth() + 1).toString().padStart(2, '0');
    var day = dt.getDate().toString().padStart(2, '0');
    var minute = dt.getMinutes().toString().padStart(2, '0');
    var hour = (dt.getHours() - 1).toString().padStart(2, '0');
    var seconds = dt.getSeconds().toString().padStart(2, '0');
    var current_date_time = `${day}/${month}/${dt.getFullYear()} ${hour}:${minute}:${seconds}`;

    // Disable/enabled text inputs in the same row based on the checkbox state
    targetRow.find('input:text').prop("disabled", true);

    if (chx.is(':checked')) {
        // If the checkbox is checked
        targetRow.find('td:nth-child(7)').children().val('X');
        targetRow.find('td:nth-child(5)').children().val('0');
        targetRow.find('td:nth-child(8)').children().val(username);
        targetRow.find('td:nth-child(9)').children().val(current_date_time);
        var test_v = targetRow.find('td:nth-child(7)').children().text();
        console.log("TEST VALUE: ", test_v);
        make_absent(exam_no);
    } else {
        targetRow.find('input:text').prop("disabled", false);
        // If the checkbox is unchecked
        targetRow.find('td:nth-child(7)').children().val('L');
        targetRow.find('td:nth-child(8)').children().val('');
        targetRow.find('td:nth-child(9)').children().val('');
        make_missing(exam_no);
    }
});

    
    //   $(":checkbox").on("change", function() {
    //     var chx = $(this).is(':checked').prop('disabled',disabled)
    //     var chx_id = $(this).is(':checked').attr('id')
    //     console.log("ID CHX",chx_id)


    //     exam_no = $(this).val(),
    //      targetRow = $(this).closest('tr'),
    //      username = $('input[type=hidden][name=username]').val(),

    //      dt = new Date(),
    //     month = (dt.getMonth() + 1).toString(),
    //     month = month.length > 1 ? month : '0' + month,
    //     day = dt.getDate().toString(),
    //     day = day.length > 1 ? day : '0' + day,
    //     minute = dt.getMinutes().toString(),
    //     minute = minute.length > 1 ? minute : '0' + minute,
    //     hour = (dt.getHours() - 1).toString(),
    //     hour = hour > 1 ? hour : '0' + hour,
    //     seconds = dt.getSeconds().toString(),
    //     seconds = seconds.length > 1 ? seconds : '0' + seconds,
    //       current_date_time = day+'/'+month+'/'+dt.getFullYear()+' '+hour+':'+minute+':'+seconds;
    //     targetRow.find('input:text').prop("disabled", chx);
    //     if (chx){
    //         targetRow.find('td:nth-child(7)').children().val('X');
    //         targetRow.find('td:nth-child(5)').children().val('0');
    //         targetRow.find('td:nth-child(7)').children().val(username);
    //         targetRow.find('td:nth-child(9)').children().val(current_date_time);
    //         var test_v=targetRow.find('td:nth-child(7)').children().text()


    //         console.log("TEST VALUE: ",test_v)
    //         make_absent(exam_no);
    //     }else{
    //         targetRow.find('td:nth-child(7)').children().val('L');
    //         targetRow.find('td:nth-child(8)').children().val('');
    //         targetRow.find('td:nth-child(9)').children().val('');
    //         make_missing(exam_no);
    //     }
        
    //  });
    }
	
    function make_absent(absent_exam_no){
        var centre_code = $('input[type=hidden][name=centre_code]').val(),
        subject_code = $('input[type=hidden][name=subject_code]').val(),
        paper_no =  $('input[type=hidden][name=paper_no]').val();

        $.ajax({
            url: 'php/update_marks_question.php',
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
            url: 'php/update_marks_question.php',
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
							'<option value ="" selected></option>'
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
	 function get_subjects(){
	$.ajax({
          url: 'php/get_subject.php',
          method: 'POST',
          dataType: 'json',
          success:function(data){
              $('select[name=subject]').append(
                '<option value="" selected disabled>Select Subject</option>'
              );
              $.each(data,function(){
                $('select[name=subject]').append(
                '<option value="'+this["subject_code"]+'">'+this["subject_code"]+' - '+this["subject_name"]+'</option>'
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
          var subject_code = $(this).val();
          $.ajax({
            url: 'php/get_paper.php',
            method: 'POST',
            data:{subject_code:subject_code},
            dataType: 'json',
            success:function(data){
              $('select[name=paper] option').remove();
              $.each(data,function(){
                $('select[name=paper]').append(
                '<option value="'+this["paper_no"]+'">'+this["paper_no"]+'</option>'
              );
              });
            }
          });
        });
	}
	function get_marksheet(){
	$('#parameters-form').submit(function(e){
		e.preventDefault();
        
		$.ajax({
			url: 'php/marksheet_question.php',
			method: 'POST',
			data: $('#parameters-form').serialize(),
            dataType: 'json',
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
                    marksheet(data);
			}
        }
		});
		
    });
}
        function total(){
            
                $('.mark').keyup(function(){
                    var total = 0;

                    // common values
                    var exam_no = $(this).attr('name').match(/\[(\d+)\]/)[1];

                    $('.mark[name^="raw_mark['+exam_no+']"]').each(function(){
                        total += parseFloat($(this).val()) || 0;
                    });
                    console.log("Total is:",total)
                    var max=$("#max").text()
                    console.log("Total is:",max)
                    
                    $('.total_mark[name="total_mark['+exam_no+']"]').val(total);
                    validatemaxmark(total,max,$('.total_mark[name="total_mark['+exam_no+']"]'))
                });
          
        }
        function marksheet(data){
            // var currentUrl = window.location.href,
            //         newUrl = currentUrl + (currentUrl.includes('?') ? '&' : '?') + 'marksheet=1';
					$('span.subject_code').text(data.subject_code);
					$('span.subject_name').text(data.subject_name);
					$('span.centre_code').text(data.centre_code);
					$('span.centre_name').text(data.centre_name);
					$('span.paper_no').text(data.paper_no);
					$('span.max_mark').text(data.max_mark);

                    $('input[type=hidden][name=centre_code]').val(data.centre_code);
                    $('input[type=hidden][name=subject_code]').val(data.subject_code);
                    $('input[type=hidden][name=paper_no]').val(data.paper_no);
                    $('input[type=hidden][name=chief_examiner_username]').val(data.chief_examiner_username);
                    if(data.not_display == 'true'){
                        $('button#submit_button').addClass('d-none');
                        $('button#validate_button').removeClass('d-none');
                    }else{
                        $('button#submit_button').removeClass('d-none');
                        $('button#validate_button').addClass('d-none');
                    }
					$.each(data.candidate,function(){
                        var checked = this["status"] == 'X' ? 'checked' : '',
                            mark = this["mark"].split(","),
                            question = this["question"].split(","),
                            disable = this["disable"] == 1 ? 'disabled' : '';
                        var markInput = [];
                        $.each(mark, function(key, value){
                        markInput.push(
                            '<div class="d-flex flex-row"><span >Q '+question[key]+' </span><input type="text" class="form-control mark mx-1" name="raw_mark['+this["exam_no"]+']['+question[key]+']" value="'+value+'" maxlength="3" pattern="[0-9]+"  style="width:40px;" '+disable+'/></div>'
                        
                            );
                    }.bind(this));
						$('table.table tbody').append('<tr id="'+this["exam_no"]+'">'+
						'<td>'+this["exam_no"]+'</td>'+
						'<td>'+this["first_name"]+'</td>'+
						'<td>'+this["last_name"]+'</td>'+

						'<td>'+
                        '<input type="checkbox" class="customcheck" name="absent" value="'+this["exam_no"]+'" id="" '+checked+' '+disable+'>'+
                        '</td>'+

                        '<td >'+
                        '<div class="custom-td">'+
                        markInput.join('')+
                        '<div class="col-2 maxvalue-error invalid-feedback"  role="alert">'+
                        '<div class="alert alert-danger mt-3 p-1" >'+
                        '<span class="text-center">Exceeded Max Allowed Mark !!</span> '+
                        '</div>'+
                        '</div>'+
                        '</div>'+
                        '</td>'+
						//total
						'<td>'+
                            '<input type="text" class="form-control total_mark" name="total_mark['+this["exam_no"]+']" value="'+this["total_mark"]+'" maxlength="3" pattern="[0-9]+" max="'+this["max_mark"]+'" style="width:60px;" readonly required/>'+
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
					$('buton[type=submit]').attr('disabled',false).text('SUbmit');
                    // history.pushState(null,null,newUrl)
                    press_enter();
                    total();
                    // page_reload();
                     $('.mark').mask('000');

				}
        $('button#validate_button').click(function(){
              $('#auth_chief').modal({
                show:true,
                // backdrop: 'static',
                // keyboard: false
            });
            authorise();
        });
        function authorise(){
            $('form#authorise').submit(function(e){
                e.preventDefault();
            
            var username = $('input:hidden[name=chief_examiner_username]').val(),
                 centre_code = $('input:hidden[name=centre_code]').val(),
                 subject_code = $('input:hidden[name=subject_code]').val(),
                 paper_no = $('input:hidden[name=paper_no]').val(),
                password = $('input:password[name=password]').val();
            $.ajax({
                url: 'https://ems.exams-council.org.zm:8080/api/auth-user/api-ems/',
                method: 'POST',
                data: {username:username,password:password},
                dataType: 'json',
                beforeSend: function(){
                    $('img.loading').css('display','block');
                    $('buton#auth').attr('disabled',true);
                },
                success:function(data){
                    if(data.status == '400'){
                        $('.auth').text('Password does not match with Chief Examiner').dialog('open');
                        $('img.loading').css('display','none');
                         $('buton#auth').attr('disabled',false);
                        
                    }else{
                        enable(centre_code,subject_code,paper_no);  
                    }
                }

            });
        });
        }
        function enable(centre_code,subject_code,paper_no){
            $.ajax({
                url: 'php/enable.php',
                method:'POST',
                data: {centre_code:centre_code,subject_code:subject_code,paper_no:paper_no},
                dataType: 'json',
                success: function(data){
                    if(data.status == '400'){
                        $('.auth').text(data.response_msg).dialog('open');
                        $('img.loading').css('display','none');
                         $('buton#auth').attr('disabled',false);
                    }else{
                        $('.auth2').text(data.response_msg).dialog('open');
                        $('button#submit_button').removeClass('d-none');
                        $('button#validate_button').addClass('d-none');
                        $('input:text.mark').attr('disabled',false);
                        $('input:checkbox[name=absent]').prop('disabled',false);

                        $('img.loading').css('display','none');
                        $('buton#auth').attr('disabled',false);
                       
                    }
                }
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
                url: 'php/update_marks_question.php',
                method: 'POST',
                data:  $('#marksheet-form').serialize(),
                dataType: 'json',
                beforeSend:function(){
                    $('img.loading').css('display','block');
                    $('buton[type=submit]').attr('disabled',true).html('<img src="../images/loading.gif" style="transform:scale(.3);" />');
                },
                success: function(data){
                    if(data.status == '400'){
                        $('.dialog2').text(data.response_msg).dialog('open');
                        $('img.loading').css('display','none');
                        $('buton[type=submit]').attr('disabled',false).text('Submit');
                    }else{
                        $('.dialog3').text(data.response_msg).dialog('open');
                        $('img.loading').css('display','none');
                        $('buton[type=submit]').attr('disabled',false).text('Submit');
                        // update_total();
                    }
                }

            });
        }
        function update_total(){
            // $.getJSON('php/update_marks_question.php',function(response){
            //     var data = JSON.stringify(response);

                $.ajax({
                    url: 'php/update_total.php',
                    method: 'POST',
                    // data: data,
                    dataType: 'json',
                    success: function(data){
                        if(data.status == '200'){
                            $('img.loading').css('display','none');
                            $('.dialog3').text(data.response_msg).dialog('open');
                            $('buton[type=submit]').attr('disabled',false).text('Submit');
                        }else{
                            $('img.loading').css('display','none');
                            $('.dialog2').text(data.response_msg).dialog('open');
                            ('buton[type=submit]').attr('disabled',false).text('Submit');
                        }
                    }
                });
            // });
        }

	});
    function validatemaxmark(current,maxmark,eve){
        if (current> maxmark){
            console.log("TOO HIGH VALUE");
            console.log("FOR: ",eve.val());
            eve.addClass("is-invalid");
            eve.addClass("invalid");
            formValid = false;
        }
        else{
            eve.removeClass("is-invalid");
            eve.removeClass("invalid");
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