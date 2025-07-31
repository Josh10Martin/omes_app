<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">



<?php
include 'includes/header.php';

if ($_SESSION['user_type']  == 'ADMIN') {

    if (isset($_GET['belt_no']) && isset($_GET['subject_name']) && isset($_GET['paper_no']) && isset($_GET['subject_code']) && isset($_GET['id'])) {
        $belt_no = $_GET['belt_no'];
        $subject_code = $_GET['subject_code'];
        $subject_name = $_GET['subject_name'];
        $paper_no = $_GET['paper_no'];
        $id = $_GET['id'];



?>

        <body>
            <style>
                .table>tbody>tr.active {
                    background-color: rgba(29, 157, 117, 0.26);
                    border: 1px solid #1d9d74;
                }

                .tableFixHead {
                    overflow: auto;
                    max-height: 20rem;
                }

                .tableFixHead thead th {
                    position: sticky;
                    top: 0;
                    z-index: 1;
                    background-color: #1d9d74;
                }
            </style>
            <div class="main-wrapper">

                <?php include 'includes/navbar.php' ?>

                <?php include 'includes/sidebar.php' ?>

                <div class="page-wrapper">
                    <div class="content">

                        <div class="row">
                            <div class="col-sm-12">
                                <!-- <h4 class="page-title ">Belt <?php echo $belt_no; ?> Centres and scripts</h4> -->
                            </div>

                        </div>
                        <div class="row d-flex justify-content-center ">
                        
                        <form class="col-md-6 bg-white p-3 m-3 rounded" method="post" id="search_apportionment">
                            <div class="row d-flex justify-content-center">
                               <div class="form-group col-md-6">
                                    <label>Subject:</label>
                                    <select class="select" name="subject" required>
                                    </select>
                                </div>
                                <div class="form-group col-md-3">
                                    <label>Paper:</label>
                                    <select class="select" name="paper" required>
                                    </select>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="">Belt No.:</label>
                                    <select class="select" name="belt_no" id="belt_no"></select>
                                </div>
                               
                               
                            </div>
                             <div class="d-flex justify-content-center">
                                <span class=" mx-auto mb-2">
                                    <button id="getApportionment" type="submit" class="btn btn-primary mx-auto"><i class="fa fa-search" aria-hidden="true"></i> Search </button>
                                </span>
                             </div>
                           
                                
                        </form>
                    </div>
                     <div class="row">
                        <div class="col-lg-12">
                            <div class="table-responsive">
                                <table class="table table-border table-striped custom-table mb-0">
                                    <thead>
                                        <tr>
                                            <th>Code</th>
                                            <th>Center Name </th>
                                            <th>NO. Scripts</th>
                                            <!-- <th>Paper </th> -->
                                            <!-- <th>Centres</th> -->
                                            <th class="text-right">Belt</th>
                                            <th class="text-right"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>101</td>
                                            <td>Center Name</td>
                                            <td>2</td>
                                            <!-- <td>2</td> -->
                                            <!-- <td>2</td> -->
                                            <td class="text-right">1</td>
                                            <td class="text-center" style="width: 150px;">
                                                <select name="to_belt" id="to_belt" class="select">
                                                    <option value="0" selected dissabled>move to</option>
                                                    <option value="1">Belt 1</option>
                                                    <option value="2">Belt 2</option>
                                                    <option value="3">Belt 3</option>
                                                    <option value="4">Belt 4</option>
                                                    <option value="5">Belt 5</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>101</td>
                                            <td>Center Name</td>
                                            <td>2</td>
                                            <!-- <td>2</td> -->
                                            <!-- <td>2</td> -->
                                            <td class="text-right">1</td>
                                            <td class="text-center" style="width: 150px;">
                                                <select name="to_belt" id="to_belt" class="select">
                                                    <option value="0" selected dissabled>move to</option>
                                                    <option value="1">Belt 1</option>
                                                    <option value="2">Belt 2</option>
                                                    <option value="3">Belt 3</option>
                                                    <option value="4">Belt 4</option>
                                                    <option value="5">Belt 5</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>101</td>
                                            <td>Center Name</td>
                                            <td>2</td>
                                            <!-- <td>2</td> -->
                                            <!-- <td>2</td> -->
                                            <td class="text-right">1</td>
                                            <td class="text-center" style="width: 150px;">
                                                <select name="to_belt" id="to_belt" class="select">
                                                    <option value="0" selected dissabled>move to</option>
                                                    <option value="1">Belt 1</option>
                                                    <option value="2">Belt 2</option>
                                                    <option value="3">Belt 3</option>
                                                    <option value="4">Belt 4</option>
                                                    <option value="5">Belt 5</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>101</td>
                                            <td>Center Name</td>
                                            <td>2</td>
                                            <!-- <td>2</td> -->
                                            <!-- <td>2</td> -->
                                            <td class="text-right">1</td>
                                            <td class="text-center" style="width: 150px;">
                                                <select name="to_belt" id="to_belt" class="select">
                                                    <option value="0" selected dissabled>move to</option>
                                                    <option value="1">Belt 1</option>
                                                    <option value="2">Belt 2</option>
                                                    <option value="3">Belt 3</option>
                                                    <option value="4">Belt 4</option>
                                                    <option value="5">Belt 5</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>101</td>
                                            <td>Center Name</td>
                                            <td>2</td>
                                            <!-- <td>2</td> -->
                                            <!-- <td>2</td> -->
                                            <td class="text-right">1</td>
                                            <td class="text-center" style="width: 150px;">
                                                <select name="to_belt" id="to_belt" class="select">
                                                    <option value="0" selected dissabled>move to</option>
                                                    <option value="1">Belt 1</option>
                                                    <option value="2">Belt 2</option>
                                                    <option value="3">Belt 3</option>
                                                    <option value="4">Belt 4</option>
                                                    <option value="5">Belt 5</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>101</td>
                                            <td>Center Name</td>
                                            <td>2</td>
                                            <!-- <td>2</td> -->
                                            <!-- <td>2</td> -->
                                            <td class="text-right">1</td>
                                            <td class="text-center" style="width: 150px;">
                                                <select name="to_belt" id="to_belt" class="select">
                                                    <option value="0" selected dissabled>move to</option>
                                                    <option value="1">Belt 1</option>
                                                    <option value="2">Belt 2</option>
                                                    <option value="3">Belt 3</option>
                                                    <option value="4">Belt 4</option>
                                                    <option value="5">Belt 5</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>101</td>
                                            <td>Center Name</td>
                                            <td>2</td>
                                            <!-- <td>2</td> -->
                                            <!-- <td>2</td> -->
                                            <td class="text-right">1</td>
                                            <td class="text-center" style="width: 150px;">
                                                <select name="to_belt" id="to_belt" class="select">
                                                    <option value="0" selected dissabled>move to</option>
                                                    <option value="1">Belt 1</option>
                                                    <option value="2">Belt 2</option>
                                                    <option value="3">Belt 3</option>
                                                    <option value="4">Belt 4</option>
                                                    <option value="5">Belt 5</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>101</td>
                                            <td>Center Name</td>
                                            <td>2</td>
                                            <!-- <td>2</td> -->
                                            <!-- <td>2</td> -->
                                            <td class="text-right">1</td>
                                            <td class="text-center" style="width: 150px;">
                                                <select name="to_belt" id="to_belt" class="select">
                                                    <option value="0" selected dissabled>move to</option>
                                                    <option value="1">Belt 1</option>
                                                    <option value="2">Belt 2</option>
                                                    <option value="3">Belt 3</option>
                                                    <option value="4">Belt 4</option>
                                                    <option value="5">Belt 5</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>101</td>
                                            <td>Center Name</td>
                                            <td>2</td>
                                            <!-- <td>2</td> -->
                                            <!-- <td>2</td> -->
                                            <td class="text-right">1</td>
                                            <td class="text-center" style="width: 150px;">
                                                <select name="to_belt" id="to_belt" class="select">
                                                    <option value="0" selected dissabled>move to</option>
                                                    <option value="1">Belt 1</option>
                                                    <option value="2">Belt 2</option>
                                                    <option value="3">Belt 3</option>
                                                    <option value="4">Belt 4</option>
                                                    <option value="5">Belt 5</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>101</td>
                                            <td>Center Name</td>
                                            <td>2</td>
                                            <!-- <td>2</td> -->
                                            <!-- <td>2</td> -->
                                            <td class="text-right">1</td>
                                            <td class="text-center" style="width: 150px;">
                                                <select name="to_belt" id="to_belt" class="select">
                                                    <option value="0" selected dissabled>move to</option>
                                                    <option value="1">Belt 1</option>
                                                    <option value="2">Belt 2</option>
                                                    <option value="3">Belt 3</option>
                                                    <option value="4">Belt 4</option>
                                                    <option value="5">Belt 5</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>101</td>
                                            <td>Center Name</td>
                                            <td>2</td>
                                            <!-- <td>2</td> -->
                                            <!-- <td>2</td> -->
                                            <td class="text-right">1</td>
                                            <td class="text-center" style="width: 150px;">
                                                <select name="to_belt" id="to_belt" class="select">
                                                    <option value="0" selected dissabled>move to</option>
                                                    <option value="1">Belt 1</option>
                                                    <option value="2">Belt 2</option>
                                                    <option value="3">Belt 3</option>
                                                    <option value="4">Belt 4</option>
                                                    <option value="5">Belt 5</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>101</td>
                                            <td>Center Name</td>
                                            <td>2</td>
                                            <!-- <td>2</td> -->
                                            <!-- <td>2</td> -->
                                            <td class="text-right">1</td>
                                            <td class="text-center" style="width: 150px;">
                                                <select name="to_belt" id="to_belt" class="select">
                                                    <option value="0" selected dissabled>move to</option>
                                                    <option value="1">Belt 1</option>
                                                    <option value="2">Belt 2</option>
                                                    <option value="3">Belt 3</option>
                                                    <option value="4">Belt 4</option>
                                                    <option value="5">Belt 5</option>
                                                </select>
                                            </td>
                                        </tr>


                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                      


                        <?php include 'includes/notifications.php' ?>
                    </div>
                </div>

                <div class="sidebar-overlay" data-reff=""></div>
            </div>


            <?php include 'includes/scripts.php' ?>
           

        </body>
        <script>
            $(document).ready(function() {
             
            });
        </script>
<?php } else {
        header('location: apportionments.php');
    }
} else {
    header('location:../');
}
?>

</html>