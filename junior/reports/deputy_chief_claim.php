<?php
session_start();
require_once '../../dompdf/autoload.inc.php';
include '../../config.php';
include '../../functions.php';
use Dompdf\Dompdf;
use Dompdf\Options;
use Dompdf\FontMetrics;

$options = new Options();
$options->set('isPhpEnabled', true);
$options->set('isRemoteEnabled', true);
$options->setChroot(['../../assets']);
$pdf = new Dompdf($options);
    ob_start();
    if(isset($_POST['subject']) && isset($_POST['paper'])){
        $subject_code = $_POST['subject'];
        $paper_no = $_POST['paper'];

        $no_of_examiners = 0;
        $grand_total = 0;
        $nrcs = array();
        // $max_sum_script =array();
        $amount = array();
        // $amount_claimed = 0;
        // $max_script_no = array();
        $script_no =0;
        $array_nrc = array();
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
        SELECT DISTINCT(ex.nrc) AS nrc,ex.tpin AS tpin, CONCAT(ex.first_name," ",ex.last_name) AS full_name, SUM(a.script_no) AS script_no,
        ex.account_no AS account_no, po.name AS position, CASE WHEN ex.role = 5 THEN mr.chief_examiner ELSE mr.deputy_c_examiner END AS paper_rate,
        mr.chief_examiner AS chief_examiner_rate, mr.deputy_c_examiner AS deputy_chief_examiner_rate,
        (
            SELECT no_of_scripts / no_of_examiners AS no_of_scripts_marked FROM highest_claim
            ORDER BY no_of_scripts_marked DESC LIMIT 1
         ) * (CASE WHEN ex.role = 5 THEN mr.chief_examiner ELSE mr.deputy_c_examiner END
            )
        AS gross_pay,
        (
            SELECT no_of_scripts / no_of_examiners AS no_of_scripts_marked FROM highest_claim
            ORDER BY no_of_scripts_marked DESC LIMIT 1
         ) * (CASE WHEN ex.role = 5 THEN mr.chief_examiner ELSE mr.deputy_c_examiner END
            ) * (15/100) AS 15_wht,

            ((
            SELECT no_of_scripts / no_of_examiners AS no_of_scripts_marked FROM highest_claim
            ORDER BY no_of_scripts_marked DESC LIMIT 1
         ) * (CASE WHEN ex.role = 5 THEN mr.chief_examiner ELSE mr.deputy_c_examiner END
            ) -
            (
            SELECT no_of_scripts / no_of_examiners AS no_of_scripts_marked FROM highest_claim
            ORDER BY no_of_scripts_marked DESC LIMIT 1
         ) * (CASE WHEN ex.role = 5 THEN mr.chief_examiner ELSE mr.deputy_c_examiner END
            ) * (15/100)) AS net_pay,

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
    ':marking_centre_code'=>$_SESSION['marking_centre_code']
    
));
$sql->bindColumn('full_name',$full_name);
$sql->bindColumn('nrc',$nrc);
        $sql->bindColumn('nrc',$nrc);
        $sql->bindColumn('tpin',$tpin);
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

<doctype html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../../assets/css/reports.css">
        <title>CLAIM REPORT</title>
    </head>
    <body>
        <style>
            table.center {
    margin-left: auto; 
    margin-right: auto;
  }

table.bodered, 
table.bodered th,
table.bodered td{
    border: 1px solid black; 
    border-collapse: collapse;
}

.w80{
    width: 80%;
}
.w100{
    width: 100%;
}
.w25{
    width: 25%;
}
.p-5{
padding: 5px;
}
.pt-10{
    padding-top: 10px;
}

table.foot{
    bottom: 0;
}
table.data th,
table.data td{
 padding:1px 3px;
}


th {
    text-align: inherit;
}
p{
    margin: 7px;
}
        </style>
    <table class="center" style="width: 500px;margin-bottom:3px;">
        <tr >
            <td>
                <img src="../../assets/img/eczlogo_tr_sm.jpg" style="width:60%">
            </td>
            <td>
               <p  style="text-align: center;">EXAMINATIONS COUNCIL OF ZAMBIA</p> 
                <p style="text-align: center;"><?php echo $_SESSION['session_name'] ?></p>
                <p style="text-align: center;">CHIEF AND DEPUTY CHIEF EXAMINER'S CLAIM</p> 
            </td>
        </tr>
    </table>

    <table class="head-data w80" style="margin-top: 5px;">
        <th>
            Subject: <?php echo $subject_code,' - ',subject_name($db_12_gce,$subject_code); ?>
        </th>
        <th>
            <!-- Paper Rate: <?php // echo $paper_rate; ?> -->
        </th>
        <th>
            Marking Centre : <?php echo $_SESSION['marking_centre']; ?>
        </th>
        <tr>
            <th>
                Paper Code : <?php echo $paper_no; ?>
            </th>
            <th>
                Belt No: 0
            </th>
            <th>
               Rate: [Chief Examiner = <?php echo $chief_examiner_rate; ?>] |
                 [Deputy Chief Examiner = <?php echo $deputy_chief_examiner_rate; ?>] |
            </th>
        </tr>
    </table>

    <table class="bodered w100">
        <thead>
            <th>
                FULL NAME
            </th>
            <th>
                POSITION
            </th>
            <th>
                GROSS
            </th>
            <th>
                TAX (15%)
            </th>
            <th>
               NET
            </th>
            <th>
                ACCOUNT NO
            </th>
            <th>
                BANK
            </th>
            <th>
                BRANCH
            </th>
            <th>
                SIGNATURE
            </th>
        </thead>
        <tbody >
            <?php
        
            do{
                
               
                // $nrcs = array($nrc);
                // $array_nrc = array_unique($nrcs);
                // $array_script_no = array($script_no);
                //  $max_sum_script = max($array_script_no);
                //  $amount_claimed =$max_sum_script * $paper_rate; 

                $array_nrc = array_unique($nrcs);
            $array_nrcs = $array_nrc;
                $array_nrc = array($nrc);
                // $amount[] = $script_no;
                // $amount_claimed =max($amount) * $paper_rate;
                $array_nrc[] = $nrc;
                // $array_nrcs = array_unique($array_nrc);

               
            ?>
            <tr id="<?php echo $nrc; ?>">
                <td><?php echo $full_name; ?></td>
                <td><?php echo $position; ?></td>
                <td><?php echo number_format((float)$gross_pay,2,'.',''); ?></td>
                <td><?php echo number_format((float)$wht,2,'.',''); ?></td>
                <td><?php echo number_format((float)$net_pay,2,'.',''); ?></td>
                <td><?php echo $account_no; ?></td>
                <td><?php echo $bank; ?></td>
                <td><?php echo $branch; ?></td>
                <td></td>
            </tr>
            <?php 
            

            $no_of_examiners++;
            $grand_total += $net_pay;
            
            // $array_script_no = array($script_no);
            $nrcs = array($nrc);
           
            // $max_script_no[] =  $script_no;
            
            // $amount_claimed =max($amount) * $paper_rate;
            // $script_no++;
            }while($sql->fetch(PDO::FETCH_BOUND));
            ?>
        </tbody>

    </table>


    <table class="w80" style="margin-top: 10px;">
        <tbody>
            <tr >
            
            <!-- <th>Total Number of Scripts In Belt <?php // echo $belt_no; ?>: <?php // echo $script_no; ?></th>  -->
            
            </tr>
            <tr>
                <th>Total Number of Examiners : <?php if($nrc){echo $no_of_examiners;}else{echo '0';} ?></th> 
            </tr>
            <tr>
                <th>Grand Total (net): K<?php echo number_format((float)$grand_total,2,'.',''); ?></th>
            </tr>
        </tbody>
    </table>
    <table class="w100 pt-10" >
        <tbody>
        <tr >
            <th >Verified By Chief Examiner:..............................</th>
            <th>Recommended By Centre Coordinator:..............................</</th>
        </tr>
        <tr class="pt-10">
            <th >Confirmed By Deputy Chief Examiner:..............................</</th>
            <th>Approved By Director EAD:..............................</</th>
           
        </tr>
        </tbody>
        
    </table>
 
    </body>
</html>

<?php
$html = ob_get_clean();
$pdf->loadHtml($html);
$pdf->setPaper('A4', 'landscape');
$pdf->render();
$canvas = $pdf->getCanvas();
$fontMetrics = new FontMetrics($canvas, $options);

$w =$canvas->get_width();
$h = $canvas->get_height();

$font = $fontMetrics->getFont('times');

$text = "Page {PAGE_NUM} of {PAGE_COUNT}";
$date_generated = 'Date generated: '.date("d/m/Y h:m:s a");

$textHeight = $fontMetrics->getFontHeight($text, 20);
$textWidth = $fontMetrics->getTextWidth($font, $text, 5);

$x = $w - $textWidth;
$y = $h - $textHeight;


$canvas->page_text($x, $y, $text, $font, 10);
$canvas->page_text(500, $y, $date_generated, $font, 10);
$pdf->stream('Centers_in_belt', Array('Attachment'=>0));

        }
?>