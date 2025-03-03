<?php
session_start();
include '../config.php';
include '../functions.php';
$rate_value = 100/85;
$tax = 15/100;
if(isset($_POST['subject']) && isset($_POST['paper']) && isset($_POST['app_belt_no'])){

        $subject_code = $_POST['subject'];
        $paper_no = $_POST['paper'];
        $belt_no = $_POST['app_belt_no'];

        $sql = $db_9->prepare('
        WITH examiners_belt AS (
            SELECT CASE WHEN g.no_of_scripts = 0 THEN 0 WHEN g.no_of_scripts < 100 THEN 100 ELSE g.no_of_scripts END AS no_of_scripts, COUNT(ex.nrc) AS no_of_examiners, ex.subject_code AS subject_code,ex.paper_no AS paper_no
             FROM group_apportion g
            INNER JOIN examiner ex ON (g.subject = ex.subject_code)
            WHERE g.paper = ex.paper_no
            AND g.marking_centre = ex.marking_centre
            AND g.belt_no = ex.belt_no
            AND ex.subject_code =:subject_code
            AND ex.paper_no =:paper_no
            AND ex.belt_no =:belt_no
            AND ex.marking_centre =:marking_centre_code
            AND ex.role IN ("1","3")
            GROUP BY g.no_of_scripts,ex.subject_code,ex.paper_no
        )
        
        SELECT 
        e.nrc AS nrc,
        e.tpin AS tpin,
        CONCAT(e.first_name," ",e.last_name) AS full_name,
        e.account_no AS account_no,
        e.title AS title,
        p.name as position,
        b.name as bank,
        br.name as branch,
        eb.no_of_scripts as no_of_scripts,
        eb.no_of_examiners AS no_of_examiners,
        e.belt_no as belt_no,
        mr.examiner * :rate_value AS examiner_rate,
        mr.checker * :rate_value AS checker_rate,
        mr.t_leader* :rate_value  AS team_leader_rate,
        (eb.no_of_scripts / eb.no_of_examiners) * (CASE WHEN e.role = 1 THEN mr.examiner * :rate_value WHEN e.role = 2 THEN mr.checker * :rate_value ELSE mr.t_leader * :rate_value END) AS gross_pay,
        (eb.no_of_scripts / eb.no_of_examiners) * (CASE WHEN e.role = 1 THEN mr.examiner * :rate_value WHEN e.role = 2 THEN mr.checker * :rate_value ELSE mr.t_leader * :rate_value END) * :tax AS 15_wht,
        (eb.no_of_scripts / eb.no_of_examiners) * (CASE WHEN e.role = 1 THEN mr.examiner * :rate_value WHEN e.role = 2 THEN mr.checker * :rate_value ELSE mr.t_leader * :rate_value END) - (eb.no_of_scripts / eb.no_of_examiners) * (CASE WHEN e.role = 1 THEN mr.examiner * :rate_value WHEN e.role = 2 THEN mr.checker * :rate_value ELSE mr.t_leader * :rate_value END) * :tax AS net_pay
    FROM 
        bankbranch br
        INNER JOIN bank b ON (br.bank_id = b.id)
        INNER JOIN examiner e ON (b.id = e.bank)
        INNER JOIN position p ON (e.role = p.id)
        INNER JOIN marking_rates mr ON (e.subject_code = mr.subject_code)
        INNER JOIN group_apportion g ON (mr.subject_code = g.subject)
        INNER JOIN examiners_belt eb ON (g.subject = eb.subject_code)
    WHERE 
        eb.paper_no = g.paper
        AND e.subject_code = g.subject
        AND e.paper_no = g.paper
        AND e.branch = br.id
        AND e.paper_no = mr.paper_no
        AND g.paper = mr.paper_no
        AND e.province = g.province
        AND e.marking_centre = g.marking_centre
        AND e.belt_no = g.belt_no
        AND e.attendance = "1"
        AND e.role IN ("1","2","3")
        AND g.subject = :subject_code
        AND g.paper = :paper_no
        AND g.belt_no = :belt_no
        AND g.province = :province_code
        AND g.marking_centre = :marking_centre_code
    GROUP BY 
        e.nrc, e.tpin, e.title, full_name, e.role, p.name, mr.t_leader, mr.examiner, mr.checker, e.account_no, b.name,eb.no_of_scripts,eb.no_of_examiners,  br.name,g.no_of_scripts
    ');

    $sql->execute(array(
        ':subject_code'=>$subject_code,
        ':paper_no'=>$paper_no,
        ':belt_no'=>$belt_no,
        ':rate_value'=>$rate_value,
        ':tax'=>$tax,
        ':province_code'=>$_SESSION['province_code'],
        ':marking_centre_code'=>$_SESSION['marking_centre_code']
        
    ));
    $sql->bindColumn('nrc',$nrc);
    $sql->bindColumn('tpin',$tpin);
    $sql->bindColumn('full_name',$full_name);
    $sql->bindColumn('position',$position);
    $sql->bindColumn('examiner_rate',$examiner_rate);
    $sql->bindColumn('checker_rate',$checker_rate);
    $sql->bindColumn('team_leader_rate',$team_leader_rate);
    $sql->bindColumn('gross_pay',$gross_pay);
    $sql->bindColumn('15_wht',$wht);
    $sql->bindColumn('net_pay',$net_pay);
    $sql->bindColumn('account_no',$account_no);
    $sql->bindColumn('bank',$bank);
    $sql->bindColumn('branch',$branch);
    //$sql->bindColumn('paper_rate',$paper_rate);
    $sql->bindColumn('title',$title);
    // $sql->bindColumn('no_of_examiners',$no_of_examiners);
    $sql->bindColumn('no_of_scripts',$no_of_scripts);
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
						<h3 class="text-center"><?php echo $subject_code,' - ',subject_name($db_9,$subject_code); ?> PAPER <?php echo $paper_no; ?> BELT <?php echo $belt_no; ?></h3> 
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
                <p class="">Examiner rate: <?php echo $examiner_rate; ?></p> 
                    <p class="">Checker rate: <?php echo $checker_rate; ?></p> 
                    <p class="">Team Leader rate: <?php echo $team_leader_rate; ?></p>
                <div class="row">
                    
					<div class="col-md-12">
                
                        <div class="">
                                <table class="table table-sm table-border table-striped custom-table mb-0"  >  <!---->
                                        <thead class="sticky sticky-top" id="table-head">
                <tr>
                <th>NRC.</th>
                <th>TPIN</th>
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
                <td><?php echo $tpin ?></td>
                <td><?php echo $title," ",$full_name; ?></td>
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