
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
    <div id="preloader-div" class="d-none" style="height: 100%;width:100%; left:0;top:0; position:absolute; background-color: #414040b9;z-index:10000" >
      <img src="../images/loading.gif" alt="Loading..." class="d-block ml-auto mr-auto " style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);">
      <p class="text-center " style="position: absolute; top: 60%; left: 50%; transform: translateX(-50%); color: white; font-weight: bold;font-size:large;">Uploading Teacher Education Centre(s) from OCRS. Please wait...</p>
    </div>

    <div class="page-wrapper">

      <!-- Preloader -->

      

            <div class="content">
                <div class="row">
                        <div class="col-md-12">
                        <h4 class="page-title">DATA SETUP</h4>
                        </div>
                </div>
                <div class="dialog"></div>
                <div class="dialog1"></div>
                <div class="dialog2"></div>
                <div class="dialog3"></div>
                <div class="dialog4"></div>
                <div class="d-flex">
                  <div class="col-md-6">
                    <h5 class="blue-ecz">SESSIONS:</h5>
                  </div>
                  
                  <div class="col-md-6">
                    <div>ACTIVE SESSION: <?php echo $_SESSION['session_name'] ?? 'none'; ?></div>
                  </div>
                </div>
                
                <div class="row">
                        
                        <div class="col-md-6">
                          <a href="marking-sessions.php"><div><i class="fa fa-eye" aria-hidden="true"></i> VIEW SESSION:</div></a>   
                     </div>
                        <!-- <div class="col-md-6">
                               <a href="javascript:void(0)" data-toggle="modal" data-target="#change-session-modal"><div>change active session</div></a> 
                        </div> -->
                </div>
                <hr>
                <!-- <h5 class="blue-ecz">EXAMINERS:</h5>  -->
                <div class="row">
                        <!-- <div class="col-md-6">
                              <a href="" data-toggle="modal" data-target="#upload-examiners-modal"><div><i class="fa fa-upload" aria-hidden="true"></i> UPLOAD EXAMINERS:</div></a>  
                        </div> -->
                        <!-- <div class="col-md-6">
                               <a href="examiners.php" ><div><i class="fa fa-eye" aria-hidden="true"></i> EXAMINERS LIST:</div></a> 
                        </div> -->

                </div>
                <!-- <hr> -->
                <h5 class="blue-ecz">MARKSHEETS:</h5> 
                <div class="row">
                        <div class="col-md-6">
                              <a href="" data-toggle="modal" data-target="#upload-marksheet-modal"><div><i class="fa fa-upload" aria-hidden="true"></i> UPLOAD MARKSHEETS:</div></a>  
                        </div>
                        <div class="col-md-6">
                               <a href="" data-toggle="modal" data-target="#extract-marksheets-modal"><div><i class="fa fa-download" aria-hidden="true"></i> EXTRACT MARKS:</div></a> 
                        </div>

                </div>

                

                <hr>
                <h5 class="blue-ecz">MARKING RATES:</h5> 
                
                <div class="row">
                        <div class="col-md-6">
                             <a href="marking_rates.php"><div><i class="fa fa-eye" aria-hidden="true"></i> VIEW MARKING RATES:</div></a>   
                        </div>
                        <!-- <div class="col-md-6">
                               <a href="javascript:void(0)"><div><i class="fa fa-eye" aria-hidden="true"></i> Update marking rates:</div></a> 
                        </div> -->
                </div>
                <!-- <div class="row">
                  <div class="col-md-6">
                    <a href="other_rates.php"><div><i class="fa fa-bandcamp" aria-hidden="true"></i> OTHER RATES</div></a>   
                  </div>
              </div> -->

                <hr>
                <h5 class="blue-ecz">MARKING CENTRES:</h5> 
                <div class="row">
                        <div class="col-md-6">
                             <a href="all-marking-centers.php"><div><i class="fa fa-eye" aria-hidden="true"></i> VIEW MARKING CENTRES:</div></a>   
                        </div>
                        <!-- <div class="col-md-6">
                               <a href="javascript:void(0)"><div><i class="fa fa-plus" aria-hidden="true"></i> Add marking Center</div></a> 
                        </div> -->

                </div>

                <hr>
                <h5 class="blue-ecz">CENTRES FROM OCRS:</h5> 
                <div class="row">
                        <div class="col-md-6">
                             <a href="all-ocrs-centers.php"><div><i class="fa fa-eye" aria-hidden="true"></i> VIEW CENTRES:</div></a>   
                        </div>
                        <div class="col-md-6">
                               <a href="javascript:void(0)" data-toggle="modal" data-target="#import-ocrs-centers-modal"><div><i class="fa fa-cloud-upload" aria-hidden="true"></i> IMPORT CENTRES</div></a> 
                        </div>

                </div>

            </div>
    </div>

            <div class="sidebar-overlay" data-reff=""></div>
</div>




<!-- Modals -->
<!-- Button trigger modal -->

      
      <!-- Modal -->
      <div class="modal fade" id="change-session-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
        <form action="" type="post" style="width:100%;">
          <div class="modal-content">
            <div class="modal-header bg-success p-1">
              <div class="modal-title h4 text-white" id="exampleModalLongTitle">Change active session</div>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <select name="" class="select" id="" required>
                <option value="" selected> Select new session</option>
              </select>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary mr-auto" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary">Save</button>
            </div>
          </div>

        </form>
        </div>
      </div>


 
      <div class="modal fade" id="extract-marksheets-modal" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
            <form action="export/marksheet.php" method="post">
            <div class="modal-header p-1 bg-success ">
              <div class="modal-title h4 text-white text-center" id="exampleModalLongTitle">Extract Marksheets </div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
              <div class="row mb-2 px-2">
                <div class="col-md-6">
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="marks-category" id="by_subject" value="by_subject" checked>
                    <label class="form-check-label font-weight-bold" for="inlineRadio1">By Subject</label>
                  </div>
              </div>
              <div class="col-md-6">
                  <div class="form-check form-check-inline">
                    <!-- <input class="form-check-input" type="radio" name="marks-category" id="by_marking_centre" value="by_marking_centre"> -->
                    <!-- <label class="form-check-label font-weight-bold" for="inlineRadio2">By Province / Centre</label> -->
                  </div>
              </div>
             
              </div>
              <div class="row " id="by-subject-row">
                <div class="col-md-12">
                  <label for="subject"> Select subject</label>
                  <select name="subject" class="select" id="" required>
                  </select>
                </div>
                <!-- <div class="col-md-6">
                  <label for="subject"> Select Paper</label>
                  <select name="paper" class="select" id="" required>
                  </select>
                </div> -->
              </div>

              <div class="row ">
                <div class="col-md-6">
                  <label for="improvised"> Improvised mark status</label>
                  <select name="improvised" class="select" id="id_subject" required>
                    <option value="0">Not Improvised</option>
                    <option value="1">Improvised</option>
                  </select>
               
                </div>
                <div class="col-md-6">
                  <label for="improvised">Sen status</label>
                  <select name="sen" class="select" id="id_subject" required>
                    <option value="0">Mainstream</option>
                    <option value="1">SEN</option>
                  </select>
               
                </div>
                <div class="col-md-6">
                  <label for="improvised">Session</label>
                  <select name="session" class="select" id="session" required>
                   
                  </select>
               
                </div>
               
              </div> 
                
              <!-- <div class="row by-marking-province-row d-none">
                
              </div> -->

            </div>
            <div class="modal-footer">
              <button type="button" id="close" class="btn btn-secondary mr-auto" data-dismiss="modal">Close</button>
              <!-- <img class="loading" src="../images/loading.gif" style="transform: translateX(100%); display:none;"/> -->
              <button type="submit"  class="btn btn-primary float-right">Generate <i class="fa fa-cloud-download" aria-hidden="true"></i></button>
            </div>
            </form>
            </div>
        </div>
        </div>


<!-- upload examiners -->
<div class="modal fade" id="upload-examiners-modal" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
        <form action="" style="width:100%;" id="upload_examiners_form" enctype="multipart/form-data">
          <div class="modal-content">
            <div class="modal-header bg-success p-1">
              <h5 class="modal-title h4 text-white" id="exampleModalLongTitle">Upload Examiners</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <label>CSV to upload</label>
                <input type="file" accept=".csv"class="form-control" placeholder="choose file to upload" id="myFile" name="myFile" required>
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


<!-- Upload marksheets -->
      <div class="modal fade" id="upload-marksheet-modal" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
        <form action="" type="post" style="width:100%;" id="upload_form" enctype="multipart/form-data">
          <div class="modal-content">
            <div class="modal-header bg-success p-1">
              <h5 class="modal-title h4 text-white" id="exampleModalLongTitle">Upload Marksheet</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <label>CSV to upload</label>
                <label>CSV to upload</label> <a href="documents/sample_marksheet.csv" style="margin-left: 10px;"> download template</a>
                <input type="file" accept=".csv"class="form-control" placeholder="choose file to upload" id="myFile" name="myFile" required>
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


<!-- import centres -->
      <div class="modal fade" id="import-ocrs-centers-modal" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
        <form action="" type="post" style="width:100%;" id="ocrs_import_form" enctype="multipart/form-data">
          <div class="modal-content">
            <div class="modal-header bg-success p-1">
              <h5 class="modal-title h4 text-white" id="exampleModalLongTitle">Import Colleges From OCRS</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <label>Select Category</label>
                <!-- <input type="file" accept=".csv"class="form-control" placeholder="choose file to upload" id="myFile" name="myFile" required> -->

            </div>
            <div class="modal-footer">
              <button type="button" id="close" class="btn btn-secondary mr-auto" data-dismiss="modal">Close</button>
              <!-- <img class="loading" src="../images/loading.gif" style="transform: translateX(100%); display:none;"/> -->
              <button type="submit" id="ocrs-import" class="btn btn-primary float-right">Import</button>
            </div>
          </div>

        </form>
        </div>
      </div>

	
<?php include 'includes/scripts.php' ?>

</body>
<script>
$(document).ready(function(){
  upload_marksheet();
  get_all_subject();
  get_paper();
  upload_schools();
  upload_examiners();
  get_province();
  get_schools_from_marksheet();
  get_all_sessions();

  //Radio button change
  hideMarkingCenterDiv()
  $('input[type=radio][name=marks-category]').change(function() {
    if (this.value == 'by_subject') {
      console.log("HIDE MARKING CENTER")
      hideMarkingCenterDiv()
    }
    else if (this.value == 'by_marking_centre') {
      hideSubjectDive()
     
    } 
});

function hideSubjectDive(){
  $('#by-subject-row').addClass('d-none')
  $('select[name=province]').prop('required', true);
  $('select[name=marking_centre]').prop('required', true);

  $('select[name=subject]').prop('required', false);
  $('select[name=paper]').prop('required', false);

  $('#by-marking-centre-row').removeClass('d-none')

}
function hideMarkingCenterDiv(){
  $('#by-subject-row').removeClass('d-none')
  $('select[name=province]').prop('required', false);
  $('select[name=marking_centre]').prop('required', false);

  $('select[name=subject]').prop('required', true);
  $('select[name=paper]').prop('required', true);

  $('#by-marking-centre-row').addClass('d-none')
}

  $('.dialog').dialog({
        title: 'REQUEST RESPONSE',
        width: '450',
        height: '150',
        modal: true,
        draggable: false,
        resizable: false,
        closeOnEscape: false,
        appendTo: '#upload-marksheet-modal',
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
        appendTo: '#import-ocrs-centers-modal',
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
        appendTo: '#upload-examiners-modal',
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

    //Preloder
  // $("#ocrs-import").click(function(){
  //   $("#preloader-div").removeClass('d-none')
    
  // });
  function upload_examiners(){
    $('#upload_examiners_form').submit(function(){
   
      $.ajax({
        url: 'php/upload_examiners.php',
        // method: 'POST',
        data: new FormData(this),
        dataType: 'json',
        processData: false,
        contentType: false,
        cache: false,
        beforeSend: function(data){
            $('button[id=save]').attr('disabled',true).addClass('bg_att');
            $('button[id=close]').attr('disabled',true);
            $('img.loading').css('display','block');
        },
        success:function(data){
          if(data.status == '200'){
            $('button[id=save]').attr('disabled',false).removeClass('bg_att');
            $('button[id=close]').attr('disabled',false);
            $('img.loading').css('display','none');
            $('#upload_form').trigger('reset');
            $('.dialog2').text(data.response_msg).dialog('open');
            
          }else{
            $('button[id=save]').attr('disabled',false).removeClass('bg_att');
            $('button[id=close]').attr('disabled',false)
            $('img.loading').css('display','none');
            $('.dialog2').text(data.response_msg).dialog('open');
          }
        }
      });
    });
  }

  function upload_marksheet(){
    $('#upload_form').submit(function(e){
      e.preventDefault();
      $.ajax({
        url: 'php/upload_marksheet.php',
        method: 'POST',
        data: new FormData(this),
        dataType: 'json',
        processData: false,
        contentType: false,
        cache: false,
        beforeSend: function(data){
            $('button[id=save]').attr('disabled',true).addClass('bg_att');
            $('button[id=close]').attr('disabled',true);
            $('img.loading').css('display','block');
        },
        success:function(data){
          if(data.status == '200'){
            // $('button[id=save]').attr('disabled',false).removeClass('bg_att');
            // $('button[id=close]').attr('disabled',false)
            // $('img.loading').css('display','none');
            // $('#upload_form').trigger('reset');
            // $('.dialog').text(data.response_msg).dialog('open');
            // align_centres();
            align_subjects();
          }else{
            $('button[id=save]').attr('disabled',false).removeClass('bg_att');
            $('button[id=close]').attr('disabled',false);
            $('img.loading').css('display','none');
            $('.dialog').text(data.response_msg).dialog('open');
          }
        }
      });
    });
  }
  
  
  function get_all_sessions(){
    $.ajax({
      url: 'php/get_all_sessions.php',
      method: 'POST',
      dataType: 'json',
      success: function(data){
        $('select[name=session]').append(
          '<option value="" selected disabled>Select Session</option>'
        );
        $.each(data,function(){
          $('select[name=session]').append(
          '<option value="'+this["year"]+'" selected disabled>'+this["description"]+'</option>'
        );
        });
        $('select[name=session]').select2({
          data:data
        });
      }
    });
  }
// function align_centres(){
//   $.ajax({
//     url: 'php/align_centres.php',
//     method: 'POST',
//     dataType: 'json',
//     success:function(data){
//       if(data.status == '200'){
//         // $('button[id=save]').attr('disabled',false).removeClass('bg_att');
//         //     $('button[id=close]').attr('disabled',false)
//         //     $('img.loading').css('display','none');
//         //     $('#upload_form').trigger('reset');
//         //     $('.dialog').text(data.response_msg).dialog('open');
//         align_provinces();
//       }else{
//         $('button[id=save]').attr('disabled',false).removeClass('bg_att');
//             $('button[id=close]').attr('disabled',false);
//             $('img.loading').css('display','none');
//             $('#upload_form').trigger('reset');
//             $('.dialog').text(data.response_msg).dialog('open');
//       }
//     }
//   });
// }

// function align_provinces(){
//   $.ajax({
//     url: 'php/align_provinces.php',
//     method: 'POST',
//     dataType: 'json',
//     success:function(data){
//       if(data.status == '200'){
//         // $('button[id=save]').attr('disabled',false).removeClass('bg_att');
//         //     $('button[id=close]').attr('disabled',false)
//         //     $('img.loading').css('display','none');
//         //     $('#upload_form').trigger('reset');
//         //     $('.dialog').text(data.response_msg).dialog('open');
//         align_subjects();
       
//       }else{
//         $('button[id=save]').attr('disabled',false).removeClass('bg_att');
//             $('button[id=close]').attr('disabled',false);
//             $('img.loading').css('display','none');
//             $('#upload_form').trigger('reset');
//             $('.dialog').text(data.response_msg).dialog('open');
//       }
//     }
//   });
// }
function align_subjects(){
  $.ajax({
    url: 'php/align_subjects.php',
    method: 'POST',
    dataType: 'json',
    success:function(data){
      if(data.status == '200'){
        $('button[id=save]').attr('disabled',false).removeClass('bg_att');
            $('button[id=close]').attr('disabled',false);
            $('img.loading').css('display','none');
            $('#upload_form').trigger('reset');
            $('.dialog').text(data.response_msg).dialog('open');
      //  populate_null_subjects_paper();
      }else{
        $('button[id=save]').attr('disabled',false).removeClass('bg_att');
            $('button[id=close]').attr('disabled',false);
            $('img.loading').css('display','none');
            $('#upload_form').trigger('reset');
            $('.dialog').text(data.response_msg).dialog('open');
      }
    }
  });
}
// function populate_null_subjects_paper(){
//   $.ajax({
//     url: 'php/populate_null_subjects_paper.php',
//     method: 'POST',
//     dataType: 'json',
//     success:function(data){
//       if(data.status == '200'){
//         $('button[id=save]').attr('disabled',false).removeClass('bg_att');
//             $('button[id=close]').attr('disabled',false);
//             $('img.loading').css('display','none');
//             $('#upload_form').trigger('reset');
//             $('.dialog').text(data.response_msg).dialog('open');
      
//       }else{
//         $('button[id=save]').attr('disabled',false).removeClass('bg_att');
//             $('button[id=close]').attr('disabled',false);
//             $('img.loading').css('display','none');
//             $('#upload_form').trigger('reset');
//             $('.dialog').text(data.response_msg).dialog('open');
//       }
//     }
//   });
// }
function get_province(){
  $.ajax({
        url: 'php/get_province.php',
        method: 'POST',
        dataType: 'json',
        success:function(data){
            $('select[name=province]').append(
                '<option value="" selected disabled>Select province</option>'+
                '<option value="all:all">All Provinces</option>'
            );
            
            $.each(data,function(){
                $('select[name=province]').append(
                '<option value="'+this["province_code"]+':'+this["province"]+'">'+this["province"]+'</option>'
            );
            });
            $('select[name=province]').select2({
              data:data
            });
        }
    });
}
$('select[name=province]').change(function(){
  var province = $(this).val().split(':'),
    province_code = province[0];
    if(province_code == 'all'){
      $('select[name=centre]').attr('disabled',true);
    }else{
      $('select[name=centre]').attr('disabled',false);
    }
});
function get_schools_from_marksheet(){
  $('select[name=province]').change(function(){
    var province = $(this).val().split(':'),
      province_code = province[0],
      province_name = province[1];
    $.ajax({
                url: 'php/get_schools_from_marksheet.php',
                method: 'POST',
                data: {province_code:province_code},
                dataType: 'json',
                success: function(data){
                    
                if(data.status == '200'){
						$('select[name=centre] option').remove();
						$('select[name=centre]').append(
							'<option value ="all" selected> All Centres</option>'
						);
						$.each(data,function(){
							$('select[name=centre]').append(
							'<option value ="'+this["centre_code"]+'">'+this["centre_code"]+' - '+this["centre_name"]+'</option>'
						);
						});
                        $('select[name=centre]').select2({
							data:data
						});
                    }else{
                      $('select[name=centre] option').remove();
                    }
                }
            });
  });
		
	 }
  function get_all_subject(){
    $.ajax({
          url: 'php/get_all_subjects.php',
          method: 'POST',
          dataType: 'json',
          success:function(data){
            $('select[name=subject] option').remove();
              $('select[name=subject]').append(
                '<option selected disabled>Select Subject</option>'+
                '<option value="all">ALL SUBJECTS</option>'
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
          if(subject_code == 'all'){
            $('select[name=paper]').attr('disabled',true);
          }else{
            $('select[name=paper]').attr('disabled',false);
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
        }
        });
  }

  function upload_schools(){
    $('#ocrs_import_form').submit(function(e){
     
      e.preventDefault();
      $.ajax({
        url: 'php/upload_schools.php',
        method: 'POST',
        data: $(this).serialize(),
        dataType: 'json',
        beforeSend: function(){
          $("#preloader-div").removeClass('d-none');
       },
        success:function(data){
          if(data.status == '200'){
            $('.dialog1').text(data.response_msg).dialog('open');
            $('#ocrs_import_form').trigger('reset');
            $("#preloader-div").addClass('d-none');
          }else{
            $('.dialog1').text(data.response_msg).dialog('open');
            $("#preloader-div").addClass('d-none');
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