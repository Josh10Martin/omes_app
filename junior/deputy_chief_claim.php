<?php
session_start();
include '../config.php';
include '../functions.php';
$rate_value = 100/85;
$tax = 15/100;
if(isset($_POST['subject']) && isset($_POST['paper'])){
        $subject_code = $_POST['subject'];
        $paper_no = $_POST['paper'];

        $sql = $db_9->prepare('WITH highest_claim AS(
            
        SELECT COUNT(ex.nrc) AS no_of_examiners, ga.no_of_scripts AS no_of_scripts,ga.belt_no AS belt_no FROM group_apportion ga
        INNER JOIN examiner ex ON (ga.subject = ex.subject_code)
        WHERE ga.paper = ex.paper_no
        AND ex.belt_no = ga.belt_no
        AND ga.marking_centre = ex.marking_centre
        AND ga.subject =:subject_code 
        AND ga.paper =:paper_no
        AND ga.marking_centre =:marking_centre_code
        AND ex.role IN (1,3)
        GROUP BY ga.no_of_scripts,ga.belt_no
        )
    SELECT DISTINCT(ex.nrc) AS nrc, CONCAT(ex.first_name," ",ex.last_name) AS full_name, SUM(a.script_no) AS script_no,
    ex.account_no AS account_no, po.name AS position, CASE WHEN ex.role = 5 THEN mr.chief_examiner ELSE mr.deputy_c_examiner END AS paper_rate,
    mr.chief_examiner * :rate_value AS chief_examiner_rate, mr.deputy_c_examiner * :rate_value AS deputy_chief_examiner_rate,
    (
        SELECT no_of_scripts / no_of_examiners AS no_of_scripts_marked FROM highest_claim
        ORDER BY no_of_scripts_marked DESC LIMIT 1
     ) * (CASE WHEN ex.role = 5 THEN mr.chief_examiner * :rate_value ELSE mr.deputy_c_examiner * :rate_value END
        )
    AS gross_pay,
    (
        SELECT no_of_scripts / no_of_examiners AS no_of_scripts_marked FROM highest_claim
        ORDER BY no_of_scripts_marked DESC LIMIT 1
     ) * (CASE WHEN ex.role = 5 THEN mr.chief_examiner * :rate_value ELSE mr.deputy_c_examiner * :rate_value END
        ) * :tax AS 15_wht,

        ((
        SELECT no_of_scripts / no_of_examiners AS no_of_scripts_marked FROM highest_claim
        ORDER BY no_of_scripts_marked DESC LIMIT 1
     ) * (CASE WHEN ex.role = 5 THEN mr.chief_examiner * :rate_value ELSE mr.deputy_c_examiner * :rate_value END
        ) -
        (
        SELECT no_of_scripts / no_of_examiners AS no_of_scripts_marked FROM highest_claim
        ORDER BY no_of_scripts_marked DESC LIMIT 1
     ) * (CASE WHEN ex.role = 5 THEN mr.chief_examiner * :rate_value ELSE mr.deputy_c_examiner * :rate_value END
        ) * :tax) AS net_pay,

   b.name AS bank,br.name AS branch
   FROM bankbranch br INNER JOIN bank b ON (br.bank_id = b.id)
   INNER JOIN examiner ex ON (b.id = ex.bank)
   INNER JOIN position po ON (ex.role = po.id)
   INNER JOIN marking_rates mr ON (ex.subject_code = mr.subject_code)
   RIGHT OUTER JOIN apportionment a ON (mr.subject_code = a.subject)
   WHERE ex.subject_code = a.subject
   AND ex.paper_no = a.paper
   AND ex.paper_no = mr.paper_no
   AND a.paper = mr.paper_no
   AND ex.branch = br.id
   AND ex.marking_centre = a.marking_centre
   AND ex.attendance = "1"
   AND a.subject =:subject_code
   AND a.paper =:paper_no
   AND ex.role IN (4,5)
   AND a.marking_centre =:marking_centre_code
   GROUP BY ex.first_name,ex.last_name,mr.chief_examiner,ex.role,mr.deputy_c_examiner,ex.nrc,ex.account_no,ex.bank,ex.branch
   ');

$sql->execute(array(
':subject_code'=>$subject_code,
':paper_no'=>$paper_no,
':rate_value'=>$rate_value,
':tax'=>$tax,
':marking_centre_code'=>$_SESSION['marking_centre_code']

));
$sql->bindColumn('full_name',$full_name);
$sql->bindColumn('nrc',$nrc);
    $sql->bindColumn('position',$position);
    $sql->bindColumn('account_no',$account_no);
    $sql->bindColumn('bank',$bank);
    $sql->bindColumn('branch',$branch);
    $sql->bindColumn('paper_rate',$paper_rate);
    $sql->bindColumn('chief_examiner_rate',$chief_examiner_rate);
    $sql->bindColumn('deputy_chief_examiner_rate',$deputy_chief_examiner_rate);
    $sql->bindColumn('gross_pay',$gross_pay);
    $sql->bindColumn('15_wht',$wht);
    $sql->bindColumn('net_pay',$net_pay);
    // $sql->bindColumn('no_of_examiners',$no_of_examiners);
    $sql->bindColumn('script_no',$script_no);
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
						<h3 class="text-center"> CHIEF / DEPUTY CHIEF EXAMINER, <?php echo $subject_code,' - ',subject_name($db_9,$subject_code); ?> PAPER <?php echo $paper_no; ?> </h3> 
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
                <p class="">Chief Examiner rate: <?php echo $chief_examiner_rate; ?></p> 
                    <p class="">Deputy Chief Examiner rate: <?php echo $deputy_chief_examiner_rate; ?></p> 
               
                

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
                <th>NRC.</th>
                <th>FULL NAME</th>
                <th>POSITION</th>
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
                <td><?php echo $nrc ?></td>
                <td><?php echo $full_name; ?></td>
                <td><?php echo $position; ?></td>
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