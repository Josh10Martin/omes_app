<?php
session_start();
?>


<!DOCTYPE html>
<html lang="en">

<?php include 'includes/header.php';

if($_SESSION['user_type'] == 'ECZ' || $_SESSION['user_type'] == 'ADMIN' || $_SESSION['user_type'] == 'SESO' || $_SESSION['user_type'] == 'DEO'){

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

        <div class="page-wrapper">
       
            <div class="content">
         
                <div class="row">
                    <div class="col-sm-4 col-3">
                        <h4 class="page-title">Search Marksheet</h4>
                    </div>
                </div>
               
                <div class="row">
                    <div class="col-sm-8 col-12 mb-5">
                        <form id="searchForm">
                                <input type="search" placeholder="Exam number / Centre code" name="search" id="search">
                                <!-- <img src="../images/loading.gif" alt="Loading..." class="d-block ml-auto mr-auto " style="position: absolute; top: 50%; left: 50%; display:none; transform: translate(-50%, -50%);"> -->
                                <button type="submit" class="btn btn-primary">Search</button>
                              
                                
                        </form>
                        </form>
                    </div>
                </div>
            
                <div class="row" id="searchResults">
                <div class="dialog"></div>
                <table class="searchResultsTable table table-sm table-border table-striped custom-table mb-0"  >  <!---->
               
                    <thead class="sticky sticky-top" id="table-head">
                        <tr>
                            <th>CENTRE CODE</th>
                            <th>EXAM NO.</th>
                            <th>FIRST NAME</th>
                            <th>LAST NAME</th>
                            <th>SUBJECT CODE</th>
                            <th>PAPER NO</th>
                            <th>MARK</th>
                            <th>STATUS</th>
                            <th>SEN</th>
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
        
            ;

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

                            $('.dialog').text(data.response_msg).dialog('open');
                           }else{
                            $('.searchResultsTable tbody tr').remove();
                            $.each(data,function(){
                                $('.searchResultsTable tbody').append('<tr class="'+this["centre_code"]+'">'+
                                '<td>'+this["centre_code"]+'</td>'+
                                '<td>'+this["exam_no"]+'</td>'+
                                '<td>'+this["first_name"]+'</td>'+
                                '<td>'+this["last_name"]+'</td>'+
                                '<td>'+this["subject_code"]+'</td>'+
                                '<td>'+this["paper_no"]+'</td>'+
                                '<td>'+this["mark"]+'</td>'+
                                '<td>'+this["status"]+'</td>'+
                                '<td>'+this["sen"]+'</td>'+
                                '<td>'+this["entered_by"]+'</td>'+
                                '<td>'+this["date_entered"]+'</td>'+
                                '<td>'+this["marking_centre"]+'</td>'+
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
        });
    </script>

<?php
}else{
  header('location: ../');
}
?>
</html>