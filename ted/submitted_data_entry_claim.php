<?php
header("Access-Control-Allow-Origin: *"); 
session_start();
?>

<!DOCTYPE html>
<html lang="en">



<?php include 'includes/header.php';
if((isset($_SESSION['user_type']) && $_SESSION['user_type']  == 'DEO') || (isset($_POST['user_type']) && $_POST['user_type'] == 'DEO' )){
    ?>

<body>
<div class="main-wrapper">

    <?php include 'includes/navbar.php'?>     
    <?php include 'includes/sidebar.php'?>
<div class="page-wrapper">
    <div class="content">
        <div class="row justify-content-between px-2">
            <div class="col-sm-6">
                <h4 class="page-title">SUBMITTED CLAIM (TEACHER EDUCATION DATA ENTRY)</h4>
            </div>
            
            <div class="col-md-6">
            <!-- <a href="reports/data_entry_claim.php" target="_blank"> GENERATE CLAIM</a> -->

            </div>

        </div>

        <div class="row">
            <div class="col-sm-4">

                <div class="form-group">
                  <label for="">search:</label>
                  <input type="text"  id="search" class="form-control" placeholder="search" >
                </div>
            </div>
            <?php
                if(isset($_SESSION['user_type']) && $_SESSION['user_type'] == 'DEO'){
                ?>
            <a href="reports/data_entry_claim.php" target="_blank"><div> GENERATE CLAIM</div></a> 
            <?php } else{ ?>
                <a href="#" data-toggle="modal" data-target="#data_entry_claim_modal">GENERATE CLAIM</a>
                <?php 
            }
                ?>
            <br>
        </div>

         <!-- data entry Claim Modal -->
         <div class="modal fade" id="data_entry_claim_modal" tabindex="-1" role="dialog" aria-labelledby="claimModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <form action="reports/data_entry_claim.php" target="_blank" method="post" style="width:100%;">
      <div class="modal-content">
        <div class="modal-header bg-success p-1 d-flex justify-content-center">
          <h5 class="modal-title h4 text-white text-center" id="claimModalLabel">Data Entry Claim</h5>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-12">
              <label for="marking_centre">Marking Centre</label>
              <select name="marking_centre" class="form-control" id="marking_centre" required>
                <option value="" disabled selected>Select Marking Centre</option>
                <!-- Dynamic options loaded via script -->
              </select>
            </div>
            <div class="col-md-12">
              <label for="deo">Data Entry user</label>
              <select name="deo" class="form-control" id="deo" required>
                <option value="" disabled selected>Select Data Entry user</option>
                <!-- Dynamic options loaded via script -->
              </select>
            </div>
            <div class="col-md-12">
              <label for="session">Session</label>
              <select name="session" class="form-control" id="session" required>
                <option value="" disabled selected>Select Session</option>
                <!-- Dynamic options loaded via script -->
              </select>
            </div>
          
           
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">
            <i class="fa fa-cloud-download" aria-hidden="true"></i> Generate
          </button>
        </div>
      </div>
    </form>
  </div>
</div>
<!-- end claim -->
        

        <div class="table-responsive">
            <div class="dialog"></div>
            <div class="dialog1"></div>
            <div class="dialog"></div>
        <table class="table custom-table table-bordered">
            <thead>
                <th>FULL NAME</th>
                <th>NO. OF SCRIPTS ENTERED</th>
                <th>BANK</th>
                <th>BRANCH</th>
                <th>ACCOUNT NO.</th>
                <th>GROSS PAY</th>
                <th>TAX(15%) </th>
                <th>NET PAY </th>
            </thead>
            <tbody>
               
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
            <div class="modal-title text-white h5 text-center">New Marking Center</div>
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
        submitted_claims();
        get_all_marking_centres();
        get_data_entry_user();
        get_year();
        showselect2();

        
        function submitted_claims(){
            $.ajax({
                url: 'php/api/payment_schedule/data_entry.php',
                method: 'POST',
                dataType: 'json',
                success: function(data){
                    $('table.table tbody tr').empty();
                    var html = ''; 
                    if(data.status == '400'){
                        $('table.table tbody').append('<tr class="null">'+
                        '<td colspan="8">There are no submitted claim to displayy</td>'+
                        '</tr>');
                    }else{
                        $.each(data,function(){
                           html += '<tr class ="'+this["id"]+'">'+
                                '<td>'+this["payee_full_name"]+'</td>'+
                                '<td>'+this["no_of_scripts"]+'</td>'+
                                '<td>'+this["bank"]+'</td>'+
                                '<td>'+this["branch"]+'</td>'+
                                '<td>'+this["account_no"]+'</td>'+
                                '<td>'+this["gross_pay"]+'</td>'+
                                '<td>'+this["fifteen_wht"]+'</td>'+
                                '<td>'+this["net_pay"]+'</td>'+
                           '</tr>'
                        });
                        $('table.table tbody').append(html);

                    }
                }

            });
        }
        function get_all_marking_centres(){
            $.ajax({
        url: 'php/get_all_marking_centres.php',
        method: 'POST',
        dataType: 'json',
        success:function(data){
            $('select[name=marking_centre] option').remove();
            $('select[name=marking_centre]').append(
                    '<option value="" selected disabled>Select Marking centre</option>'
                );
            
            $.each(data,function(){
                $('select[name=marking_centre]').append(
                    '<option value="'+this["centre_code"]+'">'+this["centre_name"]+'</option>'
                );
            });
           
            $('select[name=marking_centre]').select2({
              data:data
            });
        }
    });
        }

        function get_data_entry_user(){
            $('select[name=marking_centre]').change(function(){
                var marking_centre_code = $(this).val();
                $.ajax({
                    url: 'php/get_data_entry_user.php',
                    method: 'POST',
                    data: {marking_centre_code:marking_centre_code},
                    dataType: 'json',
                    success: function(data){
                        $('select[name=deo] option').remove();
                        if(data.status != '400'){
                            $('select[name=deo]').append(
                                    '<option value="" selected disabled>Select Data Entry User</opyion>'
                                );
                            $.each(data,function(){
                                $('select[name=deo]').append(
                                    '<option value="'+this["username"]+'">'+this["full_name"]+'</opyion>'
                                );
                            });
                        }
                    }
                });
            });
        }

        function get_year(){
        $('select[name=deo]').change(function(){

       
        $.ajax({
            url: 'php/get_year.php',
            method: 'POST',
            dataType: 'json',
            success: function(data){
                if(data.status != '400'){
                    $.each(data,function(){
                        $('select[name=session]').append(
                            '<option value="'+this["year"]+'">'+this["year"]+'</option>'
                        );
                    });
                }
            }
        });
        });
    }

    function showselect2(){
  $('#data_entry_claim_modal').on('shown.bs.modal', function () {
      $('#marking_centre,#deo,#session').select2({
        dropdownParent: $('#data_entry_claim_modal') // Ensures dropdown is appended to the modal
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