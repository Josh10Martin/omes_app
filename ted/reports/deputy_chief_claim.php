<?php
session_start();
require_once '../../dompdf/autoload.inc.php';
include '../../config.php';
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
        $sql = $db_ted->prepare('SELECT DISTINCT(e.nrc) AS nrc, CONCAT( e.first_name," ",e.last_name) AS full_name, b.name AS bank,br.name AS branch, e.account_no AS account_no,
        e.phone_number AS phone,e.title AS title,e.tpin AS tpin, p.name AS role,
    
    (
         
        (
            SELECT MAX(no_of_scripts) AS script_no
            FROM group_apportion 
            WHERE marking_centre = :marking_centre_code
            AND subject=:subject_code
            AND paper =:paper_no
        ) * (CASE WHEN e.role="4" THEN mr.deputy_c_examiner 
                WHEN e.role="5" THEN mr.chief_examiner END ) / 
        (
            SELECT COUNT(*) AS examiner_count
            FROM examiner
            WHERE (belt_no, subject_code, paper_no,marking_centre) IN (
                SELECT belt_no, subject, paper,marking_centre
                FROM group_apportion
                WHERE no_of_scripts = (
                    SELECT MAX(no_of_scripts)
                    FROM group_apportion
                    WHERE marking_centre = :marking_centre_code
                    AND subject=:subject_code
                    AND paper =:paper_no
                )
                AND subject=:subject_code
                AND paper =:paper_no
                AND marking_centre =:marking_centre_code
            )
            AND role IN ("1","3") AND marking_centre=:marking_centre_code 
            AND belt_no = (SELECT belt_no from group_apportion
                          WHERE marking_centre=:marking_centre_code
                          AND subject=:subject_code
                		  AND paper =:paper_no
                          ORDER BY no_of_scripts DESC LIMIT 1)
        ) 
    
    ) AS amount_claimed
FROM bankbranch br INNER JOIN bank b ON (br.bank_id = b.id)
        INNER JOIN examiner e ON (b.id = e.bank)
        INNER JOIN position p ON (e.role = p.id)
        INNER JOIN group_apportion g ON (e.marking_centre = g.marking_centre)
        INNER JOIN marking_rates mr ON (g.subject = mr.subject_code)
        WHERE  e.subject_code =:subject_code
        AND e.paper_no =:paper_no
        AND e.role IN ("4","5")
        AND e.branch = br.id
        AND g.subject=:subject_code
        AND g.paper =:paper_no
        AND g.marking_centre =:marking_centre_code
        AND e.marking_centre =:marking_centre_code
        
                              ');

$sql->execute(array(
    ':subject_code'=>$subject_code,
    ':paper_no'=>$paper_no,
    ':province_code'=>$_SESSION['province_code'],
    ':marking_centre_code'=>$_SESSION['marking_centre_code']
    
));
$sql->bindColumn('full_name',$full_name);
$sql->bindColumn('nrc',$nrc);
        // $sql->bindColumn('belt_no',$belt_no);
        $sql->bindColumn('account_no',$account_no);
        $sql->bindColumn('bank',$bank);
        $sql->bindColumn('role',$position);
        $sql->bindColumn('branch',$branch);
        $sql->bindColumn('amount_claimed',$amount_claimed);
        $sql->bindColumn('title',$title);
        // $sql->bindColumn('no_of_examiners',$no_of_examiners);
        // $sql->bindColumn('script_no',$script_no);
        $sql->fetch(PDO::FETCH_BOUND);
?>

<doctype html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../../assets/css/reports.css">
        <title> DEPUTY CHIEF EXAMINERS / TEAM LEADERS CLAIM REPORT</title>
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
                <p style="text-align: center;"><?php echo $_SESSION['session_name'] ?> </p>
                <p style="text-align: center;">DEPUTY CHIEF EXAMINER / TEAM LEADERS CLAIM</p> 
            </td>
        </tr>
    </table>

    <table class="head-data w80" style="margin-top: 5px;">
        <th>
            Subject Code: <?php echo $subject_code; ?>
        </th>
        <th>
            Paper Rate: <?php echo $paper_rate; ?>
        </th>
        <th>
            Marking Center : <?php echo $_SESSION['marking_centre']; ?>
        </th>
        <tr>
            <th>
                Paper Code : <?php echo $paper_no; ?>
            </th>
            <th>
                Belt No: 0
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
                AMOUNT CLAIMED
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
            <tr id="<?php echo $array_nrcs; ?>">
                <td><?php echo $nrc,' ', $title,' ',$full_name; ?></td>
                <td><?php echo $position; ?></td>
                <td><?php echo $amount_claimed; ?></td>
                <td><?php echo $account_no; ?></td>
                <td><?php echo $bank; ?></td>
                <td><?php echo $branch; ?></td>
                <td></td>
            </tr>
            <?php 
            

           
            
            // $array_script_no = array($script_no);
            $nrcs = array($nrc);
           
            // $max_script_no[] =  $script_no;
            
            $grand_total += $amount_claimed;
            // $script_no++;
            }while($sql->fetch(PDO::FETCH_BOUND));
            ?>
        </tbody>

    </table>


    <table class="w80" style="margin-top: 10px;">
        <tbody>
            <tr >
            
            <!-- <th>Total Number of Scripts In Belt <?php //echo $belt_no; ?>: <?php // echo $script_no; ?></th>  -->
            
            </tr>
            <tr>
                <th>Total Number of Examiners : <?php if($nrc){echo $no_of_examiners;} else{echo '0';} ?></th> 
            </tr>
            <tr>
                <th>Grand Total : K<?php echo $grand_total; ?></th>
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
$pdf->stream('DEPUTY CHIEF EXAMINERS CLAIM', Array('Attachment'=>0));

        }
?>