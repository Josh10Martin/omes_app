<?php
session_start();
// include '../functions.php';
?>

<!DOCTYPE html>
<html lang="en">



<?php include 'includes/header.php';
     include '../config.php';
     include '../functions.php';
if($_SESSION['user_type']  == 'SESO'){
    ?>

<body>
<div class="main-wrapper">

    <?php include 'includes/navbar.php'?>     
    <?php include 'includes/sidebar.php'?>
<div class="page-wrapper">
    <div class="content">
        <div class="row justify-content-between px-2">
            <div class="col-sm-6">
                <h4 class="page-title"><img src="../assets/img/icons/summary-icon1.png" alt=""> SCRIPT MOVEMENT SUMMARY</h4>
            </div>
            <div class="col-sm-6">
                <?php // echo $_SESSION['province_code']; ?>
                <h4 class="page-title">PROVINCE: <span id="province"><?php echo $_SESSION['province_name']; ?></span></h4>
            </div>
            <!-- <div class="col-xs-6">
                <a href="javascript:void(0)" data-toggle="modal" data-target="#add-marking-center" class="btn bg-light btn-sm"><i class="fa fa-plus"></i> Add Marking Center</a>
            </div> -->

        </div>

        <div class="row">
            <div class="col-sm-4">
                <div class="form-group">
                  <!-- <label for="">search:</label> -->
                  <input type="text"  id="search" class="form-control" placeholder="Search" >
                </div>
            </div>
            <div class="col-xs-2">
              <span class="align-end">Download</span>
                
                <a id="pdf-1" href="<?php if ($_SESSION['session_type']=="I") { ?> reports/script_movement_summary.php <?php } else { ?>reports/script_movement_summary_external.php<?php }?>" target="_blank"  class="btn bg-light btn-sm">
                    <i class="fa fa-file-pdf-o red-ecz" aria-hidden="true"></i> pdf | 
                </a>

                 <!-- <a id="pdf-1" href="reports/script_movement_summary.php" target="_blank"  class="btn bg-light btn-sm"> <i class="fa fa-file-pdf-o red-ecz" aria-hidden="true"></i> pdf | </a>
             -->
                </div>
            <?php if(not_valid($db_9,$_SESSION['province_code'],$_SESSION['session_type']) == 'true'){ ?>
            <!-- <div class="col-xs-2">
                    <span class="align-end"> Activate set script movement</span>                
                 <a id="activate_apportionment" href="javascript:void(0)"  class="btn bg-light btn-sm"> <i class="fa fa-file-settings-o red-ecz" aria-hidden="true"></i> Activate</a>
            </div> -->
            <div class="col-sm-4 d-flex align-items-center ">
            <span class="h4 align-items-bottom">
              <button id="activate_apportionment" type="button" class="btn btn-sm btn-outline-info">Activate set script movement</button>  
                </span>
            </div>
            <br>
        </div>
            <?php } ?>
            
            <br>
            <img class="loading" src="../images/loading.gif" style="transform: translateX(100%); display:none;"/>
            <div class="feedback1"></div>
            <div class="feedback1"></div>
        </div>
        

        <div class="table-responsive">
            <div class="dialog"></div>
            <div class="dialog1"></div>
            <div class="dialog2"></div>
            <div class="dialog3"></div>
            <div class="dialog4"></div>
          
            <form action="">
                <input type="hidden" name="no_of_marking_centres" value ="<?php echo no_of_marking_centres($db_9,$_SESSION['province_code'],$_SESSION['session_type']) ?>">
                <input type="hidden" name="session_type" value = "<?php echo $_SESSION['session_type']; ?>">
            </form>
        <table class="table custom-table table-bordered" id="script_movement">
            <thead>
                <th>CODE</th>
                <th>MARKING CENTER NAME</th>                
                <th>DISTRICT (S)</th>
                <th><span class="one">CENTRES</span> </th>
                <th>Actions</th>
            
            </thead>
            <tbody>

            
      
            </tbody>
        </table>
        </div>


    <?php include 'includes/notifications.php' ?>
    </div> <!--End  content-->
</div> <!--End page wrapper-->
<!--Modal-->
<div class="modal fade" id="from-centres-modal" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
        <form action="" method="post" id="add_admin">
        <div class="modal-header p-2 bg-success ">
            <div class="modal-title text-white h5 text-center">CENTRES</div>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
        
            <div class="row centre_list">
                <!-- <div class="col-md-4 px-1">ST EDMUND'S SECONDARY SCHOOL</div>
                <div class="col-md-4 px-1">ST RAPHAELS'S SECONDARY SCHOOL</div>
                <div class="col-md-4 px-1">LUSAKA BOYS SECONDARY SCHOOL</div>
                <div class="col-md-4 px-1">LUSAKA GIRLS SECONDARY SCHOOL</div>
                <div class="col-md-4 px-1">DAVID KAUNDA SECONDARY SCHOOL</div>
                <div class="col-md-4 px-1">ST EDMUND'S SECONDARY SCHOOL</div>
                <div class="col-md-4 px-1">ST EDMUND'S SECONDARY SCHOOL</div> -->



            </div>
       
        
        </div>
        <div class="modal-footer">
            <!-- <button type="button" id="button_close" class="btn btn-secondary mr-auto" data-dismiss="modal">Close</button>
            <img class="loading" src="../images/loading.gif" style="transform: translateX(100%); display:none;"/>
            <button type="submit" id="save" class="btn btn-primary float-right">Save</button> -->
        </div>
        </form>
        </div>
    </div>
    </div>

<div class="sidebar-overlay" data-reff=""></div>
</div>	
<?php include 'includes/scripts.php' ?>

</body>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.4/jspdf.min.js"></script>
<script src="https://unpkg.com/jspdf-autotable@3.5.22/dist/jspdf.plugin.autotable.js"></script>
<script>
    $(document).ready(function(){
        get_summary();
        start_apportion();

        $('.dialog').dialog({
        title: 'REQUEST RESPONSE',
        width: '450',
        height: '150',
        modal: true,
        draggable: false,
        resizable: false,
        closeOnEscape: false,
        appendTo: '.table',
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
        appendTo: '.table',
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
                    var id = $('.dialog1').data('id');
                    delete_apportionment(id);
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
        appendTo: '.table',
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
                    align_mainstream();
                    $(this).dialog('close');
                }
            }
        ]
    });
    var province_name= $('#province').text();
    $('a#pdf').click(function(){
      var headStyles={
      fillColor: [255, 255, 255] ,
      textColor: [0, 0, 0],
      lineWidth: 0.1,             // Set border width
      lineColor: [0, 0, 25] ,
  }
      var doc = new jsPDF();
      doc.autoTable({ 
        html: '#script_movement' ,
        margin: { top: 55 },
       // fillColor:  [255, 255, 255],
        headStyles:headStyles,
        //styles: cellStyles,
       // columnStyles: columnStyles,
        didDrawPage: function (data) {
          doc.setFontSize(13);
          doc.text('EXAMINATIONS COUNCIL OF ZAMBIA', 67,40);
          doc.text('SCRIPT MOVEMENT REPORT', 77,45);
          doc.text(province_name,77,50)

          var str = "Page " + doc.internal.getNumberOfPages();
                        
                        doc.setFontSize(10);
                    
                        // jsPDF 1.4+ uses getWidth, <1.4 uses .width
                        var pageSize = doc.internal.pageSize;
                        var pageHeight = pageSize.height
                          ? pageSize.height
                          : pageSize.getHeight();
                        doc.text(str, data.settings.margin.left, pageHeight - 10);
        },
       
    
      });
      const img=new Image();
      img.src='../assets/img/eczlogo_tr_sm1.jpg';
      img.onload=()=>{
        //doc.addImage(img, 'PNG', logoX, logoY, logoWidth, logoHeight);
        doc.addImage(img,'PNG',90,10,25,25);
        doc.save('script_Movement.pdf');
      }
      
      
  });


    function get_summary() {
    $.ajax({
        url: 'php/get_script_movement_external.php',
        method: 'POST',
        dataType: 'json',
        success: function(data) {
            $('table#script_movement tbody').empty();

            if (data.status == '400') {
                $('table#script_movement tbody').append('<tr class="null">'+
                    '<td colspan="4">No summary to show</td>'+
                '</tr>');
            } else {
                $.each(data, function() {
                    var show_details = this["subjects"] == 'ALL SEN SUBJECTS' ? 'd-none' : 'd-block';
                    var display = this["valid"] == 1 ? 'd-none' : 'd-block';

                    $('table#script_movement tbody').append('<tr class="'+this["marking_centre_code"]+'">'+
                        '<td>'+this["marking_centre_code"]+'</td>'+
                        '<td>'+this["marking_centre_name"]+'</td>'+
                        '<td class="text-center">'+this["districts"]+'</td>'+
                        '<td>'+
                            '<span class="" data-toggle="modal" data-target="#from-centres-modal">'+
                                this["no_of_centres"]+' <a href="javascript:void(0)" id="'+this["apportion_id"]+'" class="px-3 one text-info '+show_details+' centre_details"><i class="fa fa-info-circle" aria-hidden="true"></i> Details</a>'+
                            '</span>'+
                        '</td>'+
                        '<td>'+
                            '<a href="#" class="'+display+' fa fa-trash-o m-r-5 red-ecz bin" data-id="'+this["apportion_id"]+'"> Delete</a>'+ // Added delete button
                        '</td>'+
                    '</tr>');
                });
                remove_apportion();
                apportioned_centres();
                $('table#script_movement tbody tr.undefined').remove();
            }
        }
    });
}

// $(document).ready(function() {
//     get_summary();
// });


    function apportioned_centres(){
        $('.centre_details').click(function(){
            var apportioned_id = $(this).attr('id');
            $.ajax({
                url:'php/get_apportioned_centres.php',
                method: 'POST',
                data:{apportioned_id:apportioned_id},
                dataType: 'json',
                success:function(data){
                    $('div.centre_list').empty();
                    var html ='';
                    if(data.status == '400'){
                        $('div.centre_list').append(
                            '<div class="col-md-4 px-1">'+data.response_msg+'</div>'
                        );
                    }else{
                        $.each(data,function(){
                        html += '<div class="col-md-4 px-1">'+this["centre_code"]+' - '+this["centre_name"]+'</div>'
                    });
                    $('div.undefined').remove();
                    $('div.centre_list').append(html);
                    }
                    
                }
            });
        });
    }

    function remove_apportion(){
        $('.bin').click(function(){
            var id = $(this).data('id');
            $('.dialog1').text('Are you sure you want to delete apportionment?').data('id',id).dialog('open')

        });
    }

    function delete_apportionment(id){

        $.ajax({
            url: 'php/delete_subject_apportionment.php',
            method: 'POST',
            data: {id:id},
            dataType: 'json',
            success: function(data){
                if(data.status == '200'){
                    location.reload()
                }else{
                    $('.dialog').text(data.response_msg).dialog('open');
                }
            }
        });
    }
function start_apportion(){
    $('#activate_apportionment').click(function(){
        $('.dialog2').text('Are you sure you want to continue?. Please note that by clicking "YES" you will not be able to reverse the script / centre movements done. Continue?').dialog('open');
    });
}
function align_mainstream(){
  $.ajax({
    url: 'php/align_mainstream.php',
    method: 'POST',
    dataType: 'json',
    beforeSend:function(){
        $('img.loading').css('display','block');
        
      $('.feedback1').text('Aligning mainstream candidate(s) to respective marking centre(s)....');
    },
    success:function(data){
      if(data.status == '200'){
        $('.feedback2').text(data.response_msg);
        align_sen();
      }else{
        $('.feedback1').text(' ');
        $('.feedback1').text(' ');
            $('button[id=close]').attr('disabled',false);
            $('img.loading').css('display','none');
            $('.dialog').text(data.response_msg).dialog('open')
      }
    }
  });
} 
 
function align_sen(){
  $.ajax({
    url: 'php/align_sen.php',
    method: 'POST',
    dataType: 'json',
    beforeSend:function(){
      $('.feedback1').text('Aligning sen candidate(s) to respective marking centre....');
    },
    success:function(data){
      if(data.status == '200'){
        $('.feedback2').text(data.response_msg);
        // $('img.loading').css('display','none');
        // $('.feedback1').text(' ');
        finalise();
        
      }else{
        $('.feedback1').text(' ');
        $('.feedback').text(' ');
            $('button[id=close]').attr('disabled',false);
            $('img.loading').css('display','none');
            $('.dialog').text(data.response_msg).dialog('open')
      }
    }
  });
} 
function finalise(){
  $.ajax({
    url: 'php/finalise_script_movement.php',
    method: 'POST',
    dataType: 'json',
    beforeSend:function(){
      $('.feedback1').text('Finalising upload...');
    },
    success:function(data){
      if(data.status == '200'){
        $('.feedback1').text(' ');
        $('.feedback1').text(' ');

            $('img.loading').css('display','none');
            $('.dialog').text(data.response_msg).dialog('open');
      }else{
        $('.feedback1').text(' ');
        $('.feedback1').text(' ');
            $('img.loading').css('display','none');
            $('.dialog').text(data.response_msg).dialog('open')
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