<?php
header("Access-Control-Allow-Origin: *");
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
    if(isset($_POST['subject']) && isset($_POST['paper']) && isset($_POST['app_belt_no']) && isset($_POST['marking_centre'])){
        $subject_code = $_POST['subject'];
        $paper_no = $_POST['paper'];
        $belt_no = $_POST['app_belt_no'];
        $marking_centre_code = $_POST['marking_centre'];
        $total =0;
        $grand_total = 0;
        $no_of_examiners =0;
        // $claim =0;
        // $examiners = array();
        $sql = $db_12_gce->prepare('SELECT marking_centre_name,full_name, position,grossed_up_rate,no_of_scripts, gross_pay, 15_wht, net_pay,account_no ,bank, branch,session_name
                                FROM examiner_claim WHERE marking_centre_code =:marking_centre_code AND subject_code =:subject_code AND paper_no =:paper_no AND belt_no =:belt_no
                               ');
        $sql->execute(array(
            ':subject_code'=>$subject_code,
            ':paper_no'=>$paper_no,
            ':belt_no'=>$belt_no,
            ':marking_centre_code'=>$marking_centre_code
            
        ));

      
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
            @page{
             /*   margin-top: 100px;  create space for header */
                margin-bottom: 150px; /* create space for footer */
            }
            table.Centre {
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
    <table class="Centre" style="width: 500px;margin-bottom:3px;">
        <tr >
            <td>
                <img src="../../assets/img/eczlogo_tr_sm.jpg" style="width:60%">
            </td>
            <td>
               <p  style="text-align: Centre;">EXAMINATIONS COUNCIL OF ZAMBIA</p> 
                <p style="text-align: Centre;"><?php echo $session_name; ?></p>
                <p style="text-align: Centre;">EXAMINER'S CLAIM SCHEDULE</p> 
            </td>
        </tr>
    </table>

    <table class="head-data w80" style="margin-top: 5px;">
        <th>
            Subject: <?php echo $subject_code,' - ',subject_name($db_12_gce,$subject_code); ?>
        </th>
        <th>
           
        </th>
        <th>
            Marking Centre : <?php echo $marking_centre_name; ?>
        </th>
        <tr>
            <th>
                Paper Code : <?php echo $paper_no; ?>
            </th>
            <th>
                Belt No.: <?php echo $belt_no; ?>
            </th>
            <th>
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
                RATE
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
           
                while($row = $sql->fetch(PDO::FETCH_ASSOC)){
                    $marking_centre_name = $row['marking_centre_name'] ?? '';
                    $full_name = $row['full_name'] ?? '';
                    $position = $row['position'] ?? '';
                    $rate = $row['grossed_up_rate'] ?? '';
                    $gross_pay = $row['gross_pay'] ?? '';
                    $wht = $row['15_wht'] ?? '';
                    $net_pay = $row['net_pay'] ?? '';
                    $account_no = $row['account_no'] ?? '';
                    $bank = $row['bank'] ?? '';
                    $branch = $row['branch'] ?? '';
                    $session_name = $row['session_name'] ?? '';
                    $no_of_scripts = $row['no_of_scripts'] ?? '';
            ?>
            <tr>
                <td><?php echo $full_name; ?></td>
                <td><?php echo $position; ?></td>
                <td><?php echo $rate; ?></td>
                <td><?php echo number_format((float)$gross_pay,2,'.',''); ?></td>
                <td><?php echo number_format((float)$wht,2,'.',''); ?></td>
                <td><?php echo number_format((float)$net_pay,2,'.',''); ?></td>
                <td><?php echo $account_no; ?></td>
                <td><?php echo $bank; ?></td>
                <td><?php echo $branch; ?></td>
                <td></td>
            </tr>
            <?php
            // $total += $script_no;
            $grand_total += $net_pay;
            // $no_of_examiners = $no_of_examiners++;
            $no_of_examiners++;
            
            }
            // while ($sql->fetch(PDO::FETCH_BOUND));
            ?>
        </tbody>

    </table>

    <table class="foot w100">
        <tbody>
            <tr>
                <th>GENERATED BY: <?php echo $_SESSION['username']; ?></th>
                <th>Total Number of Examiners : <?php echo $no_of_examiners; ?></th>
                <th>Total Number of Scripts <?php echo $script_count = $belt_no == 0 ? 'Claimed' : 'In Belt'; ?>: <?php echo $no_of_scripts; ?></th>
                <th>Grand Total (net) : K<?php echo number_format((float)$grand_total,2,'.',''); ?></th>
                <th></th>
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
$footer_text1='Verified By Team Leader:...........................................................
                Recommended By Centre Coordinator:................................................';
        
$footer_text2= 'Confirmed By Chief Examiner:...................................................
                Approved By Director EAD:.........................................................';

$text = "Page {PAGE_NUM} of {PAGE_COUNT}";
$date_generated = 'Date generated: '.date("d/m/Y h:m:s a");

$textHeight = $fontMetrics->getFontHeight($text, 20);
$textWidth = $fontMetrics->getTextWidth($font, $text, 5);

$x = $w - $textWidth;
$y = $h - $textHeight;


$canvas->page_text($x, $y, $text, $font, 10);
$canvas->page_text(500, $y, $date_generated, $font, 10);
$canvas->page_text(50, 500, $footer_text1, $font, 13);
$canvas->page_text(50, 520, $footer_text2, $font, 13);
$pdf->stream('tl_ch_ex_claim', Array('Attachment'=>0));

}

?>