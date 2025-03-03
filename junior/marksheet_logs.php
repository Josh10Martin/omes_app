<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">


<?php include 'includes/header.php';
     include '../config.php';
     include '../functions.php';
if($_SESSION['user_type']  == 'ECZ'){
    ?>

<body>
<div class="main-wrapper">

    <?php include 'includes/navbar.php'?>     
    <?php include 'includes/sidebar.php'?>
<div class="page-wrapper">
    <div class="content">
        <div class="row justify-content-between px-2">
            <div class="col-sm-6">
                <h4 class="page-title">Load Marksheet Logs</h4>
            </div>
            <div class="col-sm-6">
                <!-- last updated: Date time : time:time -->
                <!-- <h4 class="page-title">PROVINCE: <?php echo $_SESSION['province_name']; ?></h4> -->
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
            <div class="col-sm-4 d-flex align-items-center ">
            <!-- <span class="h4 align-items-bottom">
                <a href="subject_apportionment_summary.php" >
                    <img src="../assets/img/icons/summary-icon1.png" alt="">
                    Summary
                </a>
                </span> -->
            </div>
            <br>
        </div>
        

        <div class="table-responsive">
            <div class="dialog"></div>
            <div class="dialog1"></div>
            <div class="dialog"></div>
          
            <form action="">
                <input type="hidden" name="no_of_marking_centres" value ="<?php echo no_of_marking_centres($db_9,$_SESSION['province_code'],$_SESSION['session_type']) ?>">
                <input type="hidden" name="session_type" value = "<?php echo $_SESSION['session_type']; ?>">
            </form>
        <table class="table custom-table table-bordered">
            <thead>
                <th>Centre_Number</th>
                <th>Exam_Number</th>
                <th>Subject</th>
                <th>Paper</th>
                <th>Marking_Centre</th>
                <th>Province</th>
                <th>Comment</th>
            </thead>
            <tbody>
            <!-- <tr>
                <td></td>
                <td></td>
                <td></td>
                <td> </td>
                <td class="">
                LUSAKA BOYS SECONDARY SCHOOL
                </td>
                <td>Lusaka</td>
                <td></td>
            </tr> -->
      
            </tbody>
        </table>
        </div>


    <?php include 'includes/notifications.php' ?>
    </div> <!--End  content-->
</div> <!--End page wrapper-->
<!--Modal-->
<div class="modal fade" id="add-marking-center" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
        <form action="" method="post">
        <div class="modal-header p-2 bg-success ">
            <div class="modal-title text-white h5 text-center">New Marking Centre</div>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
        
        <div class="row">
               
                <div class="col-md-6">
                    <div class="form-group">
                        <label>CODE:</label>
                        <input type="text" name="username" class="form-control" required>
                    </div>
                </div>
                
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label>NAME:</label>
                        <input type="text" name="first_name" class="form-control" required>
                    </div>
                </div>
               
            </div>
            
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary mr-auto" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary float-right">Save</button>
        </div>
        </form>
        </div>
    </div>
    </div>

<div class="sidebar-overlay" data-reff=""></div>
</div>	
<?php include 'includes/scripts.php' ?>

</body>
<script type="text/javascript">
$(document).ready(function(){
    get_log();
    function get_log(){
        $.ajax({
            url:'php/get_marksheet_log.php',
            method: 'POST',
            dataType: 'json',
            beforeSend:function(){
                $('table.table').append('<tr class="null">'+
                    '<td colspan="7">Please wait as data is generated...  <img class="loading" src="../../images/loading.gif" style="transform: translateX(100%); display:none;"/></td>'+
                    '</tr>');
            },
            success:function(data){
                // $('table.table tbody tr.null').remove();
                $('table.table tbody').empty();
                if(data.status == '400'){
                    $('table.table').append('<tr class="null">'+
                    '<td colspan="7">No Marksheet Logs</td>'+
                    '</tr>');
                }else{
                    var html = '';
                    // $('table.table tbody tr.null').remove();
                    $.each(data,function(){
                        html += '<tr class="'+this["centre_code"]+'">'+
                        '<td>'+this["centre_code"]+'</td>'+
                        '<td>'+this["exam_no"]+'</td>'+
                        '<td>'+this["subject_code"]+'</td>'+
                        '<td>'+this["paper_no"]+'</td>'+
                        '<td>'+this["marking_centre_code"]+'</td>'+
                        '<td>'+this["province"]+'</td>'+
                        '<td>'+this["comment"]+'</td>'+
                        '</tr>';
                    });
                    $('table.table tbody').append(html);
                    $('table.table tbody tr.undefined').remove();
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