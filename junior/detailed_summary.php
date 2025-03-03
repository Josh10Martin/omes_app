<?php
session_start();
include '../config.php';
// include '../functions.php';
?>

<!DOCTYPE html>
<html lang="en">
    <style>
        /* The switch - the box around the slider */
.switch {
  position: relative;
  display: inline-block;
  width: 60px;
  height: 34px;
}

/* Hide default HTML checkbox */
.switch input {
  opacity: 0;
  width: 0;
  height: 0;
}

/* The slider */
.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #ccc;
  -webkit-transition: .4s;
  transition: .4s;
}

.slider:before {
  position: absolute;
  content: "";
  height: 26px;
  width: 26px;
  left: 4px;
  bottom: 4px;
  background-color: white;
  -webkit-transition: .4s;
  transition: .4s;
}

input:checked + .slider {
  background-color: #2196F3;
}

input:focus + .slider {
  box-shadow: 0 0 1px #2196F3;
}

input:checked + .slider:before {
  -webkit-transform: translateX(26px);
  -ms-transform: translateX(26px);
  transform: translateX(26px);
}

/* Rounded sliders */
.slider.round {
  border-radius: 34px;
}

.slider.round:before {
  border-radius: 50%;
}
    </style>



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
                <h4 class="page-title">Detailed Script Movement Summary</h4>
            </div>
            <div class="col-sm-6">
                <h4 class="page-title">PROVINCE: <?php echo $_SESSION['province_name']; ?></h4>
            </div>
            <!-- <div class="col-xs-6">
                <a href="javascript:void(0)" data-toggle="modal" data-target="#add-marking-center" class="btn bg-light btn-sm"><i class="fa fa-plus"></i> Add Marking Center</a>
            </div> -->

        </div>

        <div class="row">
            <div class="col-sm-4">
                <div class="form-group">
                  <input type="text"  id="search" class="form-control" placeholder="Search" >
                </div>
            </div>
            <div class="col-sm-4 d-flex align-items-center ">
            <span class="h4 align-items-bottom">
                <a href="subject_apportionment_summary.php" >
                    <img src="../assets/img/icons/summary-icon1.png" alt="">
                    Summary
                </a>
                </span>
            </div>
            <div class="col-sm-4 d-flex align-items-center ">
                <span class="h4 align-items-bottom">
                    <a href="subject_apportionment_summary.php" >
                        <i class="fa fa-info-circle" aria-hidden="true"></i>
                        Detailed Summary
                    </a>
                    </span>
                </div>
           
        <div class="dialog"></div>
            <div class="dialog1"></div>
            <div class="dialog2"></div>
            <div class="dialog3"></div>
            <div class="dialog4"></div>

        <div class="table-responsive">
            
          
            <form action="">
                <input type="hidden" name="no_of_marking_centres" value ="<?php echo no_of_marking_centres($db_9,$_SESSION['province_code'],$_SESSION['session_type']) ?>">
                <input type="hidden" name="session_type" value = "<?php echo $_SESSION['session_type']; ?>">
            </form>
        <table class="table custom-table table-bordered">
            <thead>
                <th>CENTRE</th>
                <th>SUBJECT</th>
                <th>DISTRICT</th>
                <th>MARKING CENTRE NAME</th>
            </thead>
            <tbody>
            <!-- <tr class="MC-70">
                <td>ST EDMUNDS SECONDARY SCHOOL [030021]</td>
                <td>ENGLISH</td>
                <td>MAZABUKA</td>
                <td>ZCA</td>
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
<script>
   $(document).ready(function(){
    $.ajax({
        url: 'php/detailed_summary.php',
        methid: 'POST',
        dataType: 'json',
        beforeSend:function(){
            $('table.table tbody').append('<tr>'+
                '<td colspan="4">Generating summary....[this may take some time]</td>'+
                '</tr>');
        },
        success:function(data){
            $('table.table tbody').empty();
            var html = '';
            if(data.status == '400'){
                $('table.table tbody').append('<tr>'+
                '<td colspan="4">No detailed summary</td>'+
                '</tr>');
            }else{
                $.each(data,function(){
                    html += '<tr class="'+this["id"]+'">'+
                            '<td>'+this["centre_name"]+' ['+this["centre_code"]+']</td>'+
                            '<td>'+this["subject_name"]+'</td>'+
                            '<td>'+this["district"]+'</td>'+
                            '<td>'+this["marking_centre_name"]+'</td>'+
                            '</tr>';
                });
                $('table.table tbody tr.undefined').remove();
                $('table.table tbody').append(html);
            }
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