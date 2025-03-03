<!DOCTYPE html>
<?php
session_start();
?>
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
            <div class="row">
                <div class="col-md-12">
                <h4 class="page-title"><i class="fa fa-file text-info " aria-hidden="true"></i> FILE UPLOADS</h4>
                </div>
            </div>

            <h5 class="blue-ecz"><i class="fa fa-flag-o" aria-hidden="true"></i> FORMS:</h5>
            <div class="row justify-content-around">
                    <!-- <div class="col-md-4  mx-1">
                    <a href="javascript:void(0)" class="text-center align-middle text-primary h4" data-toggle="modal" data-target="#upload-marking-conditions-modal">
                      <div><i class="fa fa-upload" aria-hidden="true"></i> Chief Examiners' Report on Marking Conditions Form</div>
                    </a>  
                    </div> -->
                    
                    <div class="col-md-4  mx-1">
                    <a href="javascript:void(0)" class="text-center align-middle text-primary h4" data-toggle="modal" data-target="#upload-marking-conditions-modal">
                      <div><i class="fa fa-upload" aria-hidden="true"></i> Upload File</div>
                    </a>  
                    </div>

                    <!-- <div class="col-md-4  mx-1">
                      <a href="javascript:void(0)" class="text-center text-primary h4" data-toggle="modal" data-target="#upload-marking-session-report-modal"><div><i class="fa fa-upload" aria-hidden="true"></i> Chief Examiners' Report on Marking Session Form</div></a>  
                    </div>            -->
            </div>
            <hr>
            
            <!-- <h5 class="blue-ecz"><i class="fa fa-flag-o" aria-hidden="true"></i> OTHER FORMS:</h5>
            <div class="row justify-content-around">
                    <div class="col-md-4  mx-1 my-1">
                    <a href="javascript:void(0)" class="text-center align-middle text-primary h4" data-toggle="modal" data-target="#upload-apportionment-document-modal"><div><i class="fa fa-upload" aria-hidden="true"></i> Apportionment Document</div></a>  
                    </div>
                    
                    <div class="col-md-4  mx-1 my-1">
                    <a href="javascript:void(0)" class="text-center text-primary h4" data-toggle="modal" data-target="#upload-centres-in-belt-modal"><div><i class="fa fa-upload" aria-hidden="true"></i> Centres In A Belt Document</div></a>  
                    </div>           
            </div> -->

            </div>

            <div class="sidebar-overlay" data-reff=""></div>
</div>





<!-- upload any document by specifying the type of document -->
<div class="modal fade" id="upload-marking-conditions-modal" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="dialog"></div>
      <div class="dialog1"></div>
      <form action=""  style="width:100%;" id="upload_form" enctype="multipart/form-data">
          <div class="modal-content">
            <div class="modal-header bg-success p-1">
              <h5 class="modal-title h4 text-white" id="exampleModalLongTitle">File Upload Form</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">

              <div class="form-group">
                <label>File type</label>
                <input type="text" class="form-control" placeholder="Name of File to Upload" name="file_desc" required>
              </div>

                <label>Attach file</label>
                <input type="file" accept=".docx, .csv, .pdf, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" class="form-control" placeholder="choose file to upload" id="myFile" name="myfile" required>
            </div>
            <div class="modal-footer">
              <button type="button" id="close" class="btn btn-secondary mr-auto" data-dismiss="modal">Close</button>
              <img class="loading" src="../images/loading.gif" style="transform: translateX(100%); display:none;"/>
              <button type="submit" id="save" class="btn btn-primary float-right">Upload</button>
            </div>
          </div>
        </form>
      </div>
</div>






	
<?php include 'includes/scripts.php' ?>

</body>
<script>
$(document).ready(function(){
  upload_file();
  
  $('.dialog').dialog({
        title: 'REQUEST RESPONSE',
        width: '450',
        height: '150',
        modal: true,
        draggable: false,
        resizable: false,
        closeOnEscape: false,
        appendTo: '#upload-marking-conditions-modal',
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

  function upload_file(){
    $('#upload_form').submit(function(e){
      e.preventDefault();
      $.ajax({
      url: 'php/upload_file.php',
      method: 'POST',
      data: new FormData(this),
      processData:false,
      contentType:false,
      cache:false,
      dataType: 'json',
      beforeSend: function(){
        $('button[id=save]').attr('disabled',true).addClass('bg_att');
        $('button[id=close]').attr('disabled',true);
        $('img.loading').css('display','block');
        },
        success:function(data){
          if(data.status == '200'){
            $('button[id=save]').attr('disabled',false).removeClass('bg_att');
          $('button[id=close]').attr('disabled',true);
          $('img.loading').css('display','none');
          $('.dialog').text(data.response_msg).dialog('open');
          $('#upload_form').trigger('reset');
        }else{
          $('button[id=save]').attr('disabled',false).removeClass('bg_att');
          $('button[id=close]').attr('disabled',true);
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