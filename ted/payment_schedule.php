
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
<div class="page-wrapper">
    <div class="content">
        <div class="row justify-content-between align-middle px-2">
            <div class="col-xs-6">
                <h4 class="page-title">PAYMENT SCHEDULE</h4>
            </div>
            <div class="col-xs-6 ">
                <span class="align-middle">EXPORT</span>                
                <a id="csv" href="javascript:void(0)" data-toggle="modal" data-target="#add-admin" class="btn bg-light btn-sm"> <i class="fa fa-file-excel-o" aria-hidden="true"></i> csv</a>
            </div>

        </div>

        <div class="row">
            <div class="col-sm-4">
                <div class="form-group">
                  <!-- <label for="">search:</label> -->
                  <input type="text" name="search" id="search" class="form-control" placeholder="Search" >
                </div>
            </div>
            <br>
        </div>
        

        <div class="table-responsive">
            <div class="dialog"></div>
            <div class="dialog1"></div>
            <div class="dialog2"></div>
            <div class="dialog3"></div>
            <div class="dialog4"></div>
            <div class="dialog5"></div>
        <table class="table custom-table table-bordered text-nowrap" id="payment_schedule">
            <thead>
            <th>MARKING CENTRE NAME</th>
		<th>NRC</th>
                <th>NAME OF PAYEE</th>
                <th>SORT CODE</th>
                <th>BANK ACCOUNT</th>
		<th>NUMBER OF SCRIPTS</th>
                <th>GROSS PAY</th>
                <th>15% WHT</th>
                <th>NET PAY</th>
                <th>BANK NAME</th>

                <th>BRANCH NAME</th>
                <th>SUBJECT CODE</th>
                <th>PAPER </th>
                <th>BELT</th>
            </thead>
            <tbody id="table">
                <!-- <tr>
                    <td>MUSUKWA YANGSON</td>
                    <td>000998</td>
                    <td>0101833275900</td>
                    <td>1201.67</td>
                    <td>180.25</td>
                    <td>1 021.42</td>
                    <td>STANDARD CHARTERED</td>
                    <td>CHILILABOMBWE</td>
                    <td>5090</td>
                    <td>2</td>
                    <td>0</td>
                   
                </tr> -->
            </tbody>
        </table>
        </div>

    <?php include 'includes/notifications.php' ?>
    </div> <!--End  content-->
 
    </div>



</div> <!--End page wrapper-->

<div class="sidebar-overlay" data-reff=""></div>
</div>	
<?php include 'includes/scripts.php' ?>

</body>
<script type="text/javascript">

$(document).ready(function(){
    payment_schedule();
function payment_schedule(){
    $.ajax({
        url: 'php/payment_schedule.php',
        method: 'POST',
        dataType: 'json',
        success: function(data){
            // $('table#payment_schedule').remove();
            if(data.status == '400'){
                $('table#payment_schedule').append('<tr class="null">'+
                '<td colspan="11">There is not payment schedule data</td>'+
               '</tr>');
            }else{
                $('table#payment_schedule tr.null').remove();
                $.each(data,function(){
                    $('table#payment_schedule').append('<tr class="'+this["nrc"]+'">'+
                '<td>'+this["marking_centre_name"]+'</td>'+
		'<td>'+this["nrc"]+'</td>'+
                '<td>'+this["payee_full_name"]+'</td>'+
                '<td>'+this["sortcode"]+'</td>'+
                '<td>'+this["account_no"]+'</td>'+
		'<td>'+this["script_no"]+'</td>'+
                '<td>'+this["gross_pay"]+'</td>'+
                '<td>'+this["15_wht"]+'</td>'+
                '<td>'+this["net_pay"]+'</td>'+
                '<td>'+this["bank"]+'</td>'+
                '<td>'+this["branch"]+'</td>'+
                '<td>'+this["subject_code"]+'</td>'+
                '<td>'+this["paper_no"]+'</td>'+
                '<td>'+this["belt_no"]+'</td>'+
                '</tr>');
                });
                downloadcsv();
                $('table#payment_schedule tr.undefined').remove();
            }
        }
    });
}
function downloadcsv(){
    var options = {
        "seperator":",",
        "filename":"examiner_payment_schedule.csv"
    }
    $('a#csv').click(function(){
        $('#payment_schedule').table2csv(options);
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