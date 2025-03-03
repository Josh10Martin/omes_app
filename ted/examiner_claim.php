<?php
session_start();
include '../config.php';
include '../functions.php';
$rate_value = 100/85;
$tax = 15/100;
if(isset($_POST['course_group']) && isset($_POST['app_belt_no2'])){
    $course_group = $_POST['course_group'];
    $belt_no = $_POST['app_belt_no2'];

    $sql = $db_ted->prepare('
    WITH examiners_claim AS(
        SELECT COUNT(ex.nrc) AS no_of_examiners, ga.no_of_scripts AS no_of_scripts,  ga.belt_no AS belt_no FROM group_apportion ga
        INNER JOIN course_group cg ON (ga.group_code = cg.group_code)
        INNER JOIN course co ON (cg.group_code = co.group_id)
        INNER JOIN examiner ex ON (co.course_code = ex.course_code)
        WHERE ex.belt_no = ga.belt_no
        AND ga.marking_centre = ex.marking_centre
        AND ga.group_code =:group_code 
        AND ga.belt_no =:belt_no
        AND ga.marking_centre =:marking_centre_code
        AND ex.role IN ("EXAMINER","TEAM LEADER")
        GROUP BY ga.no_of_scripts,ga.belt_no
        )
                            SELECT ex.nrc AS nrc, ex.tpin AS tpin,  CONCAT(ex.first_name," ",ex.last_name) AS full_name,ex.role AS position,mr.examiner * :rate_value AS examiner_paper_rate,mr.t_leader * :rate_value AS team_leader_paper_rate,ga.no_of_scripts
                            AS script_no, co.course_name AS course_name,

                            (
                                SELECT
                            CASE
                                WHEN no_of_scripts / no_of_examiners = 0 THEN 0
                                WHEN no_of_scripts / no_of_examiners < 100 THEN 100
                                ELSE no_of_scripts / no_of_examiners
                            END
                        FROM
                            examiners_claim 
                            ) *
                            (
                                CASE
                                WHEN ex.role = "EXAMINER" THEN mr.examiner * :rate_value
                                ELSE mr.t_leader * :rate_value
                                END
                            )
                            AS gross_pay,
                            (
                                SELECT
                            CASE
                                WHEN no_of_scripts / no_of_examiners = 0 THEN 0
                                WHEN no_of_scripts / no_of_examiners < 100 THEN 100
                                ELSE no_of_scripts / no_of_examiners
                            END
                        FROM
                            examiners_claim 
                            ) *
                            (
                                CASE
                                WHEN ex.role = "EXAMINER" THEN mr.examiner * :rate_value
                                ELSE mr.t_leader * :rate_value
                                END
                            ) * :tax AS 15_wht,
                            (
                                SELECT
                            CASE
                                WHEN no_of_scripts / no_of_examiners = 0 THEN 0
                                WHEN no_of_scripts / no_of_examiners < 100 THEN 100
                                ELSE no_of_scripts / no_of_examiners
                            END
                        FROM
                            examiners_claim 
                            ) *
                            (
                                CASE
                                WHEN ex.role = "EXAMINER" THEN mr.examiner * :rate_value
                                ELSE mr.t_leader * :rate_value
                                END
                            ) -
                            (
                                SELECT
                            CASE
                                WHEN no_of_scripts / no_of_examiners = 0 THEN 0
                                WHEN no_of_scripts / no_of_examiners < 100 THEN 100
                                ELSE no_of_scripts / no_of_examiners
                            END
                        FROM
                            examiners_claim 
                            ) *
                            (
                                CASE
                                WHEN ex.role = "EXAMINER" THEN mr.examiner * :rate_value
                                ELSE mr.t_leader * :rate_value
                                END
                            ) * :tax AS net_pay,
                            
                            ex.account_no AS account_no, ex.bank AS bank,ex.branch AS branch,cg.group_code AS group_code,cg.group_name AS group_name,
                            SUM(DISTINCT(CASE WHEN ex.nrc <> "" THEN 1  ELSE "0" END)) AS no_of_examiners, GROUP_CONCAT(su.subject_code," - ",su.subject_name ORDER BY su.subject_code SEPARATOR ", ") AS subjects_in_belt
                           FROM  examiner ex INNER JOIN course  co ON (ex.course_code = co.course_code)
                           INNER JOIN course_group cg ON (co.group_id = cg.group_code)
                           INNER JOIN group_apportion ga ON (cg.group_code = ga.group_code)
                           INNER JOIN subjects su ON (co.course_code = su.course_id)
                           CROSS JOIN marking_rates mr
                           WHERE ex.marking_centre = ga.marking_centre
                           AND ex.session = ga.session
                           AND ex.belt_no = ga.belt_no
                           AND ex.attendance = "1"
                           AND ex.role IN ("EXAMINER","TEAM LEADER")
                           AND ga.group_code =:group_code
                           AND ga.belt_no =:belt_no
                           AND ga.marking_centre =:marking_centre_code
                           AND ga.session =:session
                           AND mr.session =:session
                           GROUP BY ex.nrc,ex.tpin,ex.first_name,ga.no_of_scripts,ex.role,mr.t_leader,mr.examiner,ex.last_name,ex.account_no,ex.bank,ex.branch');
    $sql->execute(array(
        ':group_code'=>$course_group,
        ':belt_no'=>$belt_no,
        ':rate_value'=>$rate_value,
        ':tax'=>$tax,
        ':session'=>$_SESSION['session_year'],
        ':marking_centre_code'=>$_SESSION['marking_centre_code']
        
    ));
    $sql->bindColumn('full_name',$full_name);
    $sql->bindColumn('gross_pay',$gross_pay);
    $sql->bindColumn('15_wht',$wht);
    $sql->bindColumn('net_pay',$net_pay);
    $sql->bindColumn('account_no',$account_no);
    $sql->bindColumn('course_name',$course_name);
    $sql->bindColumn('bank',$bank);
    $sql->bindColumn('branch',$branch);
    $sql->bindColumn('position',$position);
    $sql->bindColumn('examiner_paper_rate',$examiner_paper_rate);
    $sql->bindColumn('team_leader_paper_rate',$team_leader_paper_rate);
    $sql->bindColumn('group_code',$group_code);
    $sql->bindColumn('group_name',$group_name);
    // $sql->bindColumn('no_of_examiners',$no_of_examiners);
    $sql->bindColumn('script_no',$script_no);
    $row = $sql->rowCount();
    $sql->fetch(PDO::FETCH_BOUND);

?>

<!DOCTYPE html>
<html lang="en">



<?php include 'includes/header.php';

if($_SESSION['user_type']  == 'ADMIN'){

?>
<body>
    <div class="main-wrapper">

<?php include 'includes/navbar.php'?>     

<?php include 'includes/sidebar.php'?>

<style>
    .maxvalue-error{
        position: absolute;
        z-index: 10000;
        /* display: block ruby; */
    }
</style>

        <div class="page-wrapper">
			<div class="content p-5 " id="parameters">
			<div class="items p-3 ">
				<div class="row justify-content-center">
					<div class="col-md-9 alert alert-info">
						<h3 class="text-center">GROUP <?php echo $group_code,' - ',$group_name; ?> BELT <?php echo $belt_no; ?></h3> 
					</div>
					
				</div>
				<div class="dialog"></div>
				
				
            
           
			</div>
			</div>
            <div class="content pt-1" id="result">
                <div class="row pt-0">
               
                </div>

                <div class="border p-1 mt-0 mb-1 bg-light">
                
                
                </div>
                

				<div class="row">
					<div class="col-md-4 col-sm-6">
						<input type="text" id="search" class="form-control mb-1" placeholder="Search">
					</div>
				</div>
                <div class="row">
					<div class="col-md-12">
                
                        <div class="">
                                <table class="table table-sm table-border table-striped custom-table mb-0"  >  <!---->
                                        <thead class="sticky sticky-top" id="table-head">
                <tr>
                <th>FULL NAME</th>
                <th>POSITION</th>
                <th>GROUP</th>
                <th>COURSE</th>
                <th>GROSS</th>
                <th>TAX (15%)</th>
                <th>NET</th>
                <th>ACCOUNT NO.</th>
                <th>BANK</th>
                <th>BRANCH</th>
                
                </tr>
                </thead>
                <tbody class="marks-table">
                <?php  do{ ?> 
                <tr>
                <td><?php echo $full_name; ?></td>
                <td><?php echo $position; ?></td>
                <td><?php echo $group_name; ?></td>
                <td><?php echo $course_name; ?></td>
                <td><?php echo number_format((float)$gross_pay,2,'.',''); ?></td>
                <td><?php echo number_format((float)$wht,2,'.',''); ?></td>
                <td><?php echo number_format((float)$net_pay,2,'.',''); ?></td>
                <td><?php echo $account_no; ?></td>
                <td><?php echo $bank; ?></td>
                <td><?php echo $branch; ?></td>
                </tr>
                <?php  }while ($sql->fetch(PDO::FETCH_BOUND)); ?>
                                        
        
                </tbody>
                </table>
                       

		</div>
                      
                        
                       		
                	</div>
                </div>
               
            </div>


    <!-- notifications -->
 <?php include 'includes/notifications.php' ?>

        </div>
    </div>

	<div class="sidebar-overlay" data-reff=""></div>

	
	<?php include 'includes/scripts.php' ?>
    <script src="../assets/js/jquery.dataTables.min.js"></script>
    <script src="../assets/js/dataTables.bootstrap4.min.js"></script>
   
 

</body>
<script>
     

 
   </script>

<?php
}
}else{
    header('location: ../');
}
?>

</html>