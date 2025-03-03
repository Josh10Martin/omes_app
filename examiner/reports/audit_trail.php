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

        
        $sql = $db_12_gce->prepare('SELECT CONCAT(sc.centre_code," - ",sc.centre_name) AS school, m.exam_no AS exam_no, CONCAT(su.subject_code," - ",su.subject_name) AS subject,pa.paper_no AS paper_no,
                                    m.old_mark AS old_mark, m.old_status AS old_status,m.new_mark AS new_mark, m.status AS new_status,
                                    CASE WHEN m.sen = 0 THEN "NO" ELSE "YES" END AS sen, CASE WHEN improvised_mark = 1 THEN "YES" ELSE "NO" END AS improvised_mark, m.entered_by AS entered_by,m.action AS action,
                                    m.date_entered AS date_entered
                                    FROM school sc INNER JOIN marks_audit_trail m ON (sc.centre_code = m.centre_code)
                                    INNER JOIN subjects su ON (m.subject_code = su.subject_code)
                                    INNER JOIN paper pa ON (su.subject_code = pa.subject_code)
                                    WHERE m.paper_no = pa.paper_no
                                    AND m.subject_code = pa.subject_code
                                    AND m.marking_centre = :marking_centre_code
                                    AND m.subject_code =:subject_code
                                    AND m.paper_no =:paper_no');

$sql->execute(array(
    ':subject_code'=>$subject_code,
    ':paper_no'=>$paper_no,
    ':marking_centre_code'=>$_SESSION['marking_centre_code']
    
));
$rowCount = $sql->rowCount();
$sql->bindColumn('school',$school);
$sql->bindColumn('exam_no',$exam_no);
$sql->bindColumn('subject',$subject);
$sql->bindColumn('paper_no',$paper_no);
$sql->bindColumn('old_mark',$old_mark);
$sql->bindColumn('old_status',$old_status);
$sql->bindColumn('new_mark',$new_mark);
$sql->bindColumn('new_status',$new_status);
$sql->bindColumn('sen',$sen);
$sql->bindColumn('improvised_mark',$improvised_mark);
$sql->bindColumn('entered_by',$entered_by);
$sql->bindColumn('action',$action);
$sql->bindColumn('date_entered',$date_entered);
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

td{
    text-align:center;
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
                <p style="text-align: center;">AUDIT TRAIL</p> 
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
                <!-- Belt No: 0 -->
            </th>
        </tr>
    </table>

    <table class="bodered w100">
        <thead>
            <th>
                CENTE NAME
            </th>
            <th>
                EXAM NO.
            </th>
         
            <th>
                OLD MARK
            </th>
            <th>
                OLD STATUS
            </th>
            <th>
                NEW MARK
            </th>
            <th>
                NEW STATUS
            </th>
            <th>
                SEN
            </th>
            <th>
                IMPROVISED MARK
            </th>
            <th>
                PERSON RESPONSIBLE
            </th>
            <th>
                ACTION
            </th>
            <th>
                DATE ACTIONED
            </th>
        </thead>
        <tbody >
            <?php
        
            do{
            ?>
            <tr >
                <td><?php echo $school; ?></td>
                <td><?php echo $exam_no; ?></td>
               
                <td><?php echo $old_mark; ?></td>
                <td><?php echo $old_status; ?></td>
                <td><?php echo $new_mark; ?></td>
                <td><?php echo $new_status; ?></td>
                <td><?php echo $sen; ?></td>
                <td><?php echo $improvised_mark; ?></td>
                <td><?php echo $entered_by; ?></td>
                <td><?php echo $action; ?></td>
                <td><?php echo $date_entered; ?></td>
             
            </tr>
            <?php 
            
            }while($sql->fetch(PDO::FETCH_BOUND));
            ?>
        </tbody>

    </table>


    <table class="w80" style="margin-top: 10px;">
        <tbody>
           
            <tr>
                <th>Total Number of Records : <?php echo $rowCount; ?></th> 
            </tr>
            <tr>
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
$pdf->stream('audit_trail', Array('Attachment'=>0));

        }
?>