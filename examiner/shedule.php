<?php
session_start();

?>
<!DOCTYPE html>
<html lang="en">



<?php
// include '/includes/header.php';
include 'includes/header.php';

if ($_SESSION['user_type'] == 'ECZ') {
    if(isset($_GET['examiner'])){
        $examiner = $_GET['examiner'];

?>

<body>
    <div class="main-wrapper">

        <?php include 'includes/navbar.php' ?>
        <!-- includes/navbar.php -->
        <?php include 'includes/sidebar.php' ?>
        <!-- <div id="preloader-div" class="d-none" style="height: 100%;width:100%; left:0;top:0; position:absolute; background-color: #414040b9;z-index:10000">
                <img src="../images/loading.gif" alt="Loading..." class="d-block ml-auto mr-auto " style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);">
                <p class="text-center " style="position: absolute; top: 60%; left: 50%; transform: translateX(-50%); color: white; font-weight: bold;font-size:large;">Uploading <span class="centre_type"></span> Centre(s) from OCRS. Please wait...</p>
            </div> -->

        <div class="page-wrapper">

            <!-- Preloader -->



            <div class="content">
                <div class="row">
                    <div class="col-md-12">
                        <h4 class="page-title"><?php if($examiner == 'examiner'){echo 'EXAMINER';} else{echo 'DATA ENTRY';} ?> PAYMENT SCHEDULE </h4> 
                    </div>
                </div>
                <div class="d-flex">
                    <div class="col-md-6">
                        
                    </div>
                    <div class="col-md-6">
                        <table>
                            <tbody>
                                <tr>
                                    <td>
                                    <button id ="extract" class="btn btn-primary"> EXTRACT EXCEL</button>
                                    </td>
                                    <td>
                                    <form action="<?php if($examiner == 'examiner'){echo 'submitted_examiners_claim.php';}else{echo 'submitted_data_entry_claim.php';} ?>" method="post" target="_blank">
                                    <input type="hidden" name="user_type" value="<?php if($examiner == 'examiner'){echo 'ADMIN';}else{echo 'DEO';} ?>">
                    
                                    <button type="submit" class="btn btn-primary"> PAYMENT CLAIMS</button>
                    
                                    </form> 
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                  
                      
                </div>
                </div>

                <!-- Table -->

                <div class="row">
                    <div class="table-responsive">
                        <table class="table table-sm text-nowrap bg-white" id="schedule_table">
                            <thead class="table-active bg-light">
                                <th>MARKING CENTRE</th>
                                <th>T-PIN</th>
                                <th>NRC</th>
                                <th>ROLE</th>
                                <th>PAYEE FULL NAME</th>
                                <th>PAYEE ADDRESS</th>
                                <th>SORT CODE</th>
                                <th>ACCOUNT_NUMBER</th>
                                <th>GROSS PAY</th>
                                <th>WHT@ 15%</th>
                                <th>NET PAY</th>
                                <th>BANK</th>
                                <th>BRANCH</th>
                                <th>SUBJECT</th>
                                <th>PAPER</th>
                                <th>No_SCRIPTS</th>
                                <th>BELT</th>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>

                </div>
            </div>

            <div class="sidebar-overlay" data-reff=""></div>
        </div>





        <?php include 'includes/scripts.php' ?>

</body>
<script>
    $(document).ready(function () {
        

        var url = 'php/payment_schedule/<?php if($_GET['examiner'] == 'examiner'){echo 'examiners.php';}else{echo 'data_entry.php';} ?>';
        var entities = '<?php if($_GET['examiner'] == 'examiner'){echo 'examiners';}else{echo 'data_entry';} ?>';
        $('#schedule_table').DataTable({
            "ajax": {
                "url": url,
                "dataSrc": function (json) {
                    var data = [];
                    for (var key in json) {
                        if (json.hasOwnProperty(key) && key !== 'status') {
                            data.push(json[key]);
                        }
                    }
                    return data;
                }
            },
            "pageLength": 20, // Set the number of rows to display
            "autoWidth": false,
            "scrollX": true,
            "columns": [
                //  { "data": "id" },
                {
                    "data": "marking_centre_name"
                },
                {
                    "data": "tpin"
                },
                {
                    "data": "nrc"
                },
                {
                    "data": "position"
                },
                {
                    "data": "payee_full_name"
                },
                {
                    "data": "payee_address"
                },
                {
                    "data": "sortcode"
                },
                {
                    "data": "account_no"
                },

                {
                    "data": "gross_pay"
                },
                {
                    "data": "15_wht"
                },
                {
                    "data": "net_pay"
                },
                {
                    "data": "bank"
                },

                {
                    "data": "branch"
                },
                // { "data": "subject_code" },//Not there for DEO
                // { "data": "bank" },
                // { "data": "branch" },

                {
                    "data": "subject_name"
                }, //Not there for DEO
                {
                    "data": "paper_no"
                }, //Not there for DEO
                {
                    "data": "no_of_scripts"
                }, //Not there for SAD
                {
                    "data": "belt_no"
                }, //Not there for DEO


            ],

            "dom": 'Bfrtip', // Include the Buttons extension
            "buttons": [
                'excel'
            ],
            "initComplete": function (settings, json) {
                // Hide the preloader when the DataTable initialization is complete
                $('.result').removeClass('d-none')
                $('.para').addClass('d-none')
                $('#preload').addClass('d-none')
            }

        });
        $('#extract').click(function(){

        
        $.getJSON(url, function (data) {
        try {
            // Convert JSON data to a worksheet
            const worksheet = XLSX.utils.json_to_sheet(data);

            // Create a new workbook and append the worksheet
            const workbook = XLSX.utils.book_new();
            XLSX.utils.book_append_sheet(workbook, worksheet, "Sheet1");

            // Export the workbook as an Excel file
            const fileName = entities+".xlsx"; // Replace 'entities' with your dynamic value
            XLSX.writeFile(workbook, fileName);
            // location.reload();
        } catch (error) {
            console.error("Error exporting JSON to Excel:", error);
        }
    }).fail(function (jqxhr, textStatus, error) {
        console.error("Failed to fetch JSON data:", textStatus, error);
    });
    });
    });
</script>
<?php
}else{

}
} else {
    header('location: ../');
}
?>


</html>