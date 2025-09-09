<?php
session_start();
?>


<!DOCTYPE html>
<html lang="en">

<?php include 'includes/header.php';

if($_SESSION['user_type'] == 'ECZ' || $_SESSION['user_type'] == 'ADMIN' || $_SESSION['user_type'] == 'DEO'){

  ?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search</title>
    <style>
        #search{
            width: 50%;
            padding: 5.5px;
            border-radius: 5px;
            border: 1px solid gray;
        }

        #search:focus{
            border: 1px solid #28a745;
        }

    </style>
    <?php include 'includes/header.php'?>
</head>
<body>
    <div class="main-wrapper">
        <?php include 'includes/navbar.php'?>     
        <?php include 'includes/sidebar.php'?>
        <div class="dialog"></div>
        <div class="dialog2"></div>
        <div class="page-wrapper">
            <div class="content">
                <div class="row">
                    <div class="col-sm-4 col-3">
                        <h4 class="page-title">Search Marksheet</h4>
                    </div>
                </div>

                <!-- Modal -->
<div class="modal fade" id="markingCentreModal" tabindex="-1" aria-labelledby="markingCentreModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      
      <!-- Modal Header -->
      <div class="modal-header">
        <h5 class="modal-title" id="markingCentreModalLabel">Change Marking Centre</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <!-- Modal Body with Form -->
      <form id="markingCentreForm">
        <div class="modal-body">
            <p>Move candidate <span class="exam_no"></span> with subject <span class="subject_code"></span> paper <span class="paper_no"></span></p>

          <!-- Hidden fields (example) -->
          <input type="hidden" name="exam_no" value="">
          <input type="hidden" name="subject_code" value="">
          <input type="hidden" name="paper_no" value="">
          <input type="hidden" name="id" value="">

          <!-- Select field -->
          <div class="mb-3">
            <label for="marking_centre" class="form-label">Select Marking Centre</label>
            <select class="form-select" id="marking_centre"  name="marking_centre" required>
            
            </select>
          </div>

        </div>

        <!-- Modal Footer -->
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
      </form>

    </div>
  </div>
</div>

                <div class="row">
                    <div class="col-sm-8 col-12 mb-5">
                        <form id="searchForm">
                                <input type="search" placeholder="Exam number / Centre code" name="search" id="search">
                                <!-- <img src="../images/loading.gif" alt="Loading..." class="d-block ml-auto mr-auto " style="position: absolute; top: 50%; left: 50%; display:none; transform: translate(-50%, -50%);"> -->
                                <button type="submit" class="btn btn-primary">Search</button>
                              
                                
                        </form>
                    </div>
                </div>

                <div class="row" id="searchResults">
                <table class="searchResultsTable table table-sm table-border table-striped custom-table mb-0"  >  <!---->
                    <thead class="sticky sticky-top" id="table-head">
                        <tr>
                            <th>CENTRE CODE</th>
                            <th>EXAM NO.</th>
                            <!-- <th><FIRST NAME</th>
                            <th>LAST NAME</th> -->
                            <th>SUBJECT CODE</th>
                            <th>PAPER NO</th>
                            <th>MARK</th>
                            <th>BELT NO.</th>
                            <th>STATUS</th>
                            <th>SEN</th>
                            <th>IMPROVISED MARK</th>
                            <th>ENTERED BY</th>
                            <th>DATE ENTERED</th>
                            <th>MARKING CENTRE</th>
                           
                        </tr>
                    </thead>
                    <tbody>
                    
                    </tbody>
				</table>
                    
                </div>

            </div>
        </div>
    </div>
    
    <?php include 'includes/scripts.php' ?>
    
   

</body>

<script>
            $(document).ready(function() {
                get_marking_centre();
            // $('.searchResultsTable').hide();
            $('.searchResultsTable').hide();
            $('img.loading').css('display','block')
            $('.dialog').dialog({
        title: 'REQUEST RESPONSE',
        width: '450',
        height: '150',
        modal: true,
        draggable: false,
        resizable: false,
        closeOnEscape: false,
        // appendTo: '#upload-marksheet-modal',
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

            $('.dialog2').dialog({
        title: 'REQUEST RESPONSE',
        width: '450',
        height: '150',
        modal: true,
        draggable: false,
        resizable: false,
        closeOnEscape: false,
        appendTo: '#markingCentreModal',
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
            //         var id = $('.dialog2').data(id);
            //         transfer_candidate(yd);
            //         $(this).dialog('close');
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
        
            

            $('#searchForm').on('submit', function(event) {
                event.preventDefault(); // Prevent the default form submission
                
                var query = $('#search').val();
                if (query !== '') {
                    $.ajax({
                        url: 'php/search.php',
                        method: 'POST',
                        data: { search: query },
                        beforeSend: function(data){
                            $('button[type=submit]').attr('disabled',true).addClass('bg_att');
                            $('button[id=close]').attr('disabled',true);
                            $('img.loading').css('display','block');
                        },
                        success: function(data) {
                            if(data.status == '400'){
                            $('button[type=submit]').attr('disabled',false).removeClass('bg_att');
                            $('img.loading').css('display','none');

                            $('.dialog').text(data.response_msg).dialog('open')
                           }else{
                            $('.searchResultsTable tbody tr').remove();
                            $.each(data,function(){
                                var display = (this["status"] == 'L' || this["status"] == 'X') ? 'block' : 'none';
                                $('.searchResultsTable tbody').append('<tr class="'+this["centre_code"]+'">'+
                                '<td>'+this["centre_code"]+'</td>'+
                                '<td>'+this["exam_no"]+'</td>'+
                                // '<td>'+this["first_name"]+'</td>'+
                                // '<td>'+this["last_name"]+'</td>'+
                                '<td>'+this["subject_code"]+'</td>'+
                                '<td>'+this["paper_no"]+'</td>'+
                                '<td>'+this["mark"]+'</td>'+
                                '<td>'+this["belt_no"]+'</td>'+
                                '<td>'+this["status"]+'</td>'+
                                '<td>'+this["sen"]+'</td>'+
                                '<td>'+this["improvised_mark"]+'</td>'+
                                '<td>'+this["entered_by"]+'</td>'+
                                '<td>'+this["date_entered"]+'</td>'+
                                '<td>'+this["marking_centre"]+' <br />'+
                                <?php if($_SESSION['user_type'] == 'ECZ'){ ?>
                                 '<form class="change_candidate_marking_centre">'+
                                 '<button  type="button" class="btn btn-primary" data-toggle="modal" data-target="#markingCentreModal">CHANGE MARKING CENTRE</button>'+
                                 '<input type="hidden" name="id" value="'+this["id"]+'" />'+
                                 '<input type="hidden" name="exam_no" value="'+this["exam_no"]+'" />'+
                                 '<input type="hidden" name="subject_code" value="'+this["subject_code"]+'" />'+
                                 '<input type="hidden" name="paper_no" value="'+this["paper_no"]+'" />'+
                                 '<input type="hidden" name="marking_centre" value="'+this["marking_centre"]+'" />'+
                                 '</form>'+
                                 <?php } ?>
                                 '</td>'+
                                '</tr>');
                            
                            });
                                $('.searchResultsTable').show();
                            $('.searchResultsTable tbody tr.undefined').remove();
                            $('button[type=submit]').attr('disabled',false).removeClass('bg_att');
                            $('img.loading').css('display','none');
                            $('#searchForm').trigger('reset');
                           }
                            // if (response.trim() === '') {
                            //     $('.searchResultsTable').hide();
                                
                            // } else {
                            //     $('.searchResultsTable tbody').html(response);
                            //     $('.searchResultsTable').show();
                            // }
                            // $('#searchForm').find('input[name="search"]').val(query); // Preserve the search query in the input field
                        }
                    });
                }
            });


           
               $(document).on('click','.change_candidate_marking_centre button',function(){
                    
                let form = $(this).closest("form");

                // extract values from that form
                let id = form.find("input[name='id']").val();
                let exam_no = form.find("input[name='exam_no']").val();
                let subject_code = form.find("input[name='subject_code']").val();
                let paper_no = form.find("input[name='paper_no']").val();
                let marking_centre = form.find("input[name='marking_centre']").val();

                // populate modal hidden fields
                $("#markingCentreModal input[name='id']").val(id);
                $("#markingCentreModal input[name='exam_no']").val(exam_no);
                $("#markingCentreModal input[name='subject_code']").val(subject_code);
                $("#markingCentreModal input[name='paper_no']").val(paper_no);
                $("#markingCentreModal input[name='marking_centre']").val(marking_centre);

                $('span.exam_no').text(exam_no);
                $('span.subject_code').text(subject_code);
                $('span.paper_no').text(paper_no);
                            

               });
            
            function get_marking_centre(){
    $.ajax({
      url:'php/get_marking_centres.php',
      method: 'POST',
      dataType: 'json',
      success:function(data){
        $('select[name=marking_centre] option').remove();

      
        $('select[name=marking_centre]').append(
          '<option value="" selected disabled>Select Marking Centre to transfer..</option>'
         
        );
        $.each(data,function(){
          $('select[name=marking_centre]').append(
          '<option value="'+this["centre_code"]+'">'+this["centre_name"]+'</option>'
        );
        
        });
      }
    });
  }
   $(document).on('submit', '#markingCentreForm', function(e){
    e.preventDefault();

    $.ajax({
        url: 'php/move_candidate.php',
        method: 'POST',
        data: $(this).serialize(),
        dataType: 'json',
        success: function(data){
            if(data.status == '200'){
                $('.dialog2').text(data.response_msg).dialog('open');
            }else{
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