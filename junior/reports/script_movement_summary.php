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
    // $province_code = isset($_SESSION['province_code']) ?? isset($_POST['province_code']);

    $sql = $db_9->prepare('SELECT apportion_id,marking_centre AS marking_centre_code,marking_centre_name,subject_name AS subjects,d_name AS districts,no_of_centres,valid
    FROM apportionment_summary WHERE province =:province_code
    AND apportion_id IN (SELECT apportion_id FROM marks_prep WHERE province =:province_code)');

$sql->execute(array(
    ':province_code'=>$_SESSION['province_code']
));
$sql->bindColumn('marking_centre_code',$marking_centre_code);
$sql->bindColumn('marking_centre_name',$marking_centre_name);
$sql->bindColumn('subjects',$subjects);
$sql->bindColumn('districts',$districts);
$sql->bindColumn('no_of_centres',$no_of_centres);
$sql->fetch(PDO::FETCH_BOUND);
    ?>

<doctype html>
    <html>
        <head>
            <meta charset="UTF-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link rel="stylesheet" href="../../assets/css/reports.css">
            <title>Attendance Report</title>
        </head>
        <body>
       
            <style>
                .table-border th,
                .table-border td {
                    border: 1px solid black;
                    border-collapse: collapse;
                }
                   
          </style>

        <table class="center" style="width: 500px;margin-bottom:3px;">
            <tr >
                <td>
                    <img src="../../assets/img/eczlogo_tr_sm.jpg" style="width:60%">
                </td>
                <td>
                   <p  style="text-align: center;">EXAMINATIONS COUNCIL OF ZAMBIA</p> 
                    <p style="text-align: center;"><?php echo $_SESSION['session_name']; ?></p>
                    <p style="text-align: center;">SCRIPT MOVEMENT SUMMARY</p> 
                    <p style="text-align: center;"><?php echo $_SESSION['province_name']; ?> PROVINCE</p> 
                </td>
            </tr>
        </table>
    
        <table class="head-data w100 table-border" style="margin-top: 50px; border: 1px solid black;border-collapse: collapse;">
        <thead>
        <tr>
            <th>
            CODE
            </th>
            <th>
            MARKING CENTER NAME
            </th>
            <th>
            SUBJECT(S) TO BE MARKED
            </th>
            <th>
            FROM DISTRICT (S)
            </th>
            <th>
            FROM CENTRES
            </th>
        </tr>
        </thead>
        <tbody>
            <?php do{ ?>
            <tr>
                <td><?php echo $marking_centre_code; ?></td>
                <td><?php echo $marking_centre_name; ?></td>
                <td><?php echo $subjects; ?></td>
                <td><?php echo $districts; ?></td>
                <td><?php echo $no_of_centres; ?></td>
            </tr>
            <?php } while($sql->fetch(PDO::FETCH_BOUND)); ?>
        </tbody>
        </table>
    
<<<<<<< HEAD
        <table class="w100" style="margin-top: 10px;">
=======
        <table class="w100" style="margin-top: 50px;">
>>>>>>> bcd37e570877b325387577a1fb5479a30ee562e4
            <tbody>
                <tr>
                    <th>VERIFIED BY SESO:..............................</th>
                    <th>SIGNATURE:............................................................</</th>
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
$pdf->stream('Attendance Report', Array('Attachment'=>0));


?>