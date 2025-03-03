<?php
session_start();

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
                <h4 class="page-title"><img src="../assets/img/icons/summary-icon1.png" alt=""> <?php if($_SESSION['session_type'] == 'I'){echo 'SCRIPTS /';} ?> CENTRES NOT ALLOCATED</h4>
            </div>
            <div class="col-sm-6">
                <?php // echo $_SESSION['province_code']; ?>
                <h4 class="page-title">PROVINCE: <span id="province"><?php echo $_SESSION['province_name']; ?></span></h4>
            </div>
            <div class="col-xs-6">
                <p  class="btn bg-light btn-sm"><i class="fa fa-plus"></i> <?php echo centres_subjects_in_marksheet($db_9,$_SESSION['province_code']); ?></p>
            </div>

        </div>

        <div class="row">
            <div class="col-sm-4">
                <div class="form-group">
                  <!-- <label for="">search:</label> -->
                  <input type="text"  id="search" class="form-control" placeholder="Search" >
                </div>
            </div>
            <div class="col-xs-2">
           

                 <!-- <a id="pdf-1" href="reports/script_movement_summary.php" target="_blank"  class="btn bg-light btn-sm"> <i class="fa fa-file-pdf-o red-ecz" aria-hidden="true"></i> pdf | </a>
             -->
                </div>
          
         
            
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
          
           
        <table class="table custom-table table-bordered" id="unapportioned">
            <thead>
                <th>EXAMINATION CENTRE</th>              
                <th>DISTRICT </th>
                <?php if($_SESSION['session_type'] == 'I'){ ?>
                <th><span class="one">SUBJECT(S)</span> </th>
                <?php } ?>
            </thead>
            <tbody>

            
      
            </tbody>
        </table>
        </div>


    <?php include 'includes/notifications.php' ?>
    </div> <!--End  content-->
</div> <!--End page wrapper-->
<!--Modal-->


<div class="sidebar-overlay" data-reff=""></div>
</div>	
<?php include 'includes/scripts.php' ?>

</body>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.4/jspdf.min.js"></script>
<script src="https://unpkg.com/jspdf-autotable@3.5.22/dist/jspdf.plugin.autotable.js"></script>
<script>
    $(document).ready(function(){
       
        get_unapportioned();

       function get_unapportioned(){
        $.ajax({
            url: 'php/unapportioned_centres_scripts.php',
            method: 'POST',
            dataType: 'json',
            beforeSend:function(){
                $('img.loading').css('display','block');
                $('.feedback').text('Please wait ....');
            },
            success:function(data){
                $('img.loading').css('display','none');
                $('.feedback').text('');
                $('table#unapportioned tbody').empty();
                if(data.status == '400'){
                    $('table#unapportioned tbody').append('<tr>'+
                    '<td colespan="<?php if($_SESSION['session_type'] == 'I'){echo '3';}else{echo '2';} ?>">'+data.response_msg+'</td>'+
                    '</tr>');
                }else{
                    $.each(data,function(){
                        var html = '<tr>'+
                        '<td>'+this["exam_centre"]+'</td>'+
                        '<td>'+this["district"]+'</td>'+
                        <?php if($_SESSION['session_type'] == 'I'){ ?>
                            '<td>'+this["subject"]+'</td>'+
                        <?php } ?>
                        '</tr>';
                        $('table#unapportioned tbody').append(html);
                    });
                    
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