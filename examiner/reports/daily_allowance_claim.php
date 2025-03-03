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
    if(isset($_POST['subject']) && isset($_POST['paper']) && isset($_POST['belt_no'])){
        $subject_code = $_POST['subject'];
        $paper_no = $_POST['paper'];
        $belt_no = $_POST['belt_no'];
        $total =0;
        $sql = $db_12_gce->prepare('SELECT DISTINCT ex.nrc AS nrc, ex.title AS title, CONCAT(ex.first_name," ",ex.last_name) AS full_name,ex.account_no AS account_no,b.name
        AS bank,br.name AS branch,ex.no_of_days AS no_of_days, ex.no_of_days * 150 AS amount
                                FROM examiner ex INNER  JOIN bank b ON (ex.bank = b.id)
                                INNER JOIN bankbranch br ON (b.id = br.bank_id)
                                WHERE ex.subject_code =:subject_code
                                AND ex.paper_no =:paper_no
                                AND ex.belt_no =:belt_no
                                AND ex.branch = br.id
                                AND ex.marking_centre =:marking_centre_code
                                AND ex.attendance = "1"');
        $sql->execute(array(
            ':subject_code'=>$subject_code,
            ':paper_no'=>$paper_no,
            ':belt_no'=>$belt_no,
            ':marking_centre_code'=>$_SESSION['marking_centre_code']
        ));
        $sql->bindColumn('full_name',$full_name);
        $sql->bindColumn('title',$title);
        $sql->bindColumn('nrc',$nrc);
        $sql->bindColumn('account_no',$account_no);
        $sql->bindColumn('bank',$bank);
        $sql->bindColumn('branch',$branch);
        $sql->bindColumn('no_of_days',$no_of_days);
        $sql->bindColumn('amount',$amount);
        $sql->fetch(PDO::FETCH_BOUND);
?>

<doctype html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../../assets/css/reports.css">
        <title>DAILY ALLOWANCE CLAIM REPORT</title>
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
                <p style="text-align: center;"><?php  echo $_SESSION['session_name']; ?></p>
                <p style="text-align: center;">EXAMINER'S DAILY ALLOWANCE PAYMENT</p> 
            </td>
        </tr>
    </table>

    <table class="head-data w80" style="margin-top: 5px;">
        <th>
            Subject Code: <?php echo $subject_code; ?>
        </th>
        <th>
            Daily Allowance Rate: 2.66
        </th>
        <th>
            Paper Code : <?php echo $paper_no; ?>
        </th>
        <tr>
            <th>
                Belt No.: <?php echo $belt_no; ?>
            </th>
            <th>
            Marking Center : <?php echo $_SESSION['marking_centre']; ?>
            </th>
            
        </tr>
    </table>

    <table class="bodered w100">
        <thead>
            <th>
                FULL NAME
            </th>
            <th>
                NRC
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
                NO. OF DAYS
            </th>
            <th>
                AMOUNT
            </th>
            <th>
                SIGNATURE
            </th>
        </thead>
        <tbody >
            <?php do{ ?>
            <tr>
                <td><?php echo $title,' ',$full_name; ?></td>
                <td><?php echo $nrc; ?></td>              
                <td><?php echo $account_no; ?></td>
                <td><?php echo $bank; ?></td>
                <td><?php echo $branch; ?></td>
                <td><?php echo $no_of_days; ?></td>
                <td>K<?php echo $amount; ?></td>
                <td></td>
            </tr>
            <?php 
            $total += $amount;
            }while($sql->fetch(PDO::FETCH_BOUND));
            ?>
        </tbody>

    </table>


    <table class="w80" style="margin-top: 10px;">
        <tbody>
            <th>Total: <?php echo $total; ?></th> 
        </tbody>
    </table>
    <div>
        <p>Verified By Team Leader:--------------------</p>
        <p>Confirmed By Chief Examiner:----------------</p>
        <p>Recommended By Center Coordinator:----------------</p>
    </div>
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