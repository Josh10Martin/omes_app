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
    if(isset($_POST['subject']) && isset($_POST['paper']) && isset($_POST['app_belt_no']) ){
        $subject_code = $_POST['subject'];
        $paper_no = $_POST['paper'];
        $belt_no = $_POST['app_belt_no'];
        // $end_centre = $_POST['end_centre'];
        $no_of_candidates = 0;

        $sql = $db_12_gce->prepare('SELECT DISTINCT m.exam_no AS exam_no, m.first_name AS first_name,m.last_name AS last_name,m.centre_code AS centre_code,
                                m.status AS status, CASE WHEN m.sen = 1 THEN "YES" WHEN m.sen = 0 THEN "NO" ELSE "[UNKNOWN]" END AS sen, su.subject_code AS subject_code,su.subject_name, pa.paper_no
                                FROM apportionment a INNER JOIN marks m ON (a.subject =m.subject_code)
                                INNER JOIN subjects su ON (m.subject_code = su.subject_code)
                                INNER JOIN paper pa ON (su.subject_code = pa.subject_code)
                                WHERE a.paper = m.paper_no
                                AND a.marking_centre = m.marking_centre
                                AND a.subject = su.subject_code
                                AND m.paper_no = pa.paper_no
                                AND m.marking_centre =:marking_centre_code
                                AND m.subject_code =:subject_code
                                AND m.paper_no =:paper_no
                                AND a.school = m.centre_code
                                AND a.belt_no =:belt_no
                                AND m.status = "L"
                                ');
        $sql->execute(array(
            ':subject_code'=>$subject_code,
            ':paper_no'=>$paper_no,
            ':belt_no'=>$belt_no,
            // ':end_centre'=>$end_centre,
            ':marking_centre_code'=>$_SESSION['marking_centre_code']
            
        ));
    $sql->bindColumn('exam_no',$exam_no);
    $sql->bindColumn('first_name',$first_name);
    $sql->bindColumn('last_name',$last_name);
    $sql->bindColumn('centre_code',$centre_code);
    $sql->bindColumn('status',$status);
    $sql->bindColumn('sen',$sen);
    $sql->bindColumn('subject_code',$subject_code);
    $sql->bindColumn('subject_name',$subject_name);
    $sql->bindColumn('paper_no',$paper_no);
    $sql->fetch(PDO::FETCH_BOUND);
?>

<doctype html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../../assets/css/reports.css">
        <title>Missing Marks Report</title>
    </head>
    <body>
   
        <style>
      </style>
    <table class="center" style="width: 500px;margin-bottom:3px;">
        <tr >
            <td>
                <img src="../../assets/img/eczlogo_tr_sm.jpg" style="width:60%">
            </td>
            <td>
               <p  style="text-align: center;">EXAMINATIONS COUNCIL OF ZAMBIA</p> 
                <p style="text-align: center;"><?php echo $_SESSION['session_name'];  ?></p>
                <p style="text-align: center;">MISSING MARKS</p> 
            </td>
        </tr>
    </table>

    <table class="head-data w80" style="margin-top: 5px;">
    <tr>
        <th>
            Marking Center : <?php echo $_SESSION['marking_centre']; ?>
        </th>
        <th>
            Belt no : <?php echo $belt_no; ?>
        </th>
    </tr>
    <tr>
        <th>
            Level: <?php echo $_SESSION['session_level']; ?> 
        </th>
        <th>
            Subject Code: <?php echo $subject_code; ?>
        </th>
    </tr>
    <tr>
        <th>
            Session: <?php echo $_SESSION['session_id']; ?>
        </th>
        <th>
            Subject Name: <?php echo $subject_name; ?>
        </th>
        <th>
            Paper: <?php echo $paper_no; ?>
        </th>
        
    </tr>
    </table>

    <table class=" w100" style=" margin-top:10px;">
        <thead style="border-bottom: 1px solid black;border-top: 1px solid black;">
            <th>
                EXAM NO
            </th>
            <th>
                SURNAME
            </th>
            <th>
                FIRST NAME
            </th>
            <th>
                CENTER CODE
            </th>
            <th>
                SEN
            </th>
            <th>
                STATUS
            </th>
            <th>
                COMMENT
            </th>
        </thead>
        <tbody >
            <?php
            do{
            ?>
            <tr>
                <td><?php echo $exam_no; ?></td>
                <td><?php echo $last_name; ?></td>              
                <td><?php echo $first_name; ?></td>
                <td><?php echo $centre_code; ?></td>
                <td><?php echo $sen; ?></td>
                <td><?php echo $status; ?></td>
                <td></td>
                
            </tr>
            <?php 
        $no_of_candidates++;    
        } while($sql->fetch(PDO::FETCH_BOUND));
            ?>
        </tbody>

    </table>

    <div>
        <p><strong>Total Number Of Candidates: <?php if($exam_no){echo $no_of_candidates;}else{echo '0';} ?></strong> </p>
    </div>

    <table class="w100" style="margin-top: 10px;">
        <tbody>
            <th>VERIFIED BY (FULL NAME): ______________________________</th> 
            <th>SIGNATURE: <span >__________________________________</span> </th> 
        </tbody>
    </table>
    </body>
</html>

<?php
$html = ob_get_clean();
$pdf->loadHtml($html);
$pdf->setPaper('A4', 'portrait');
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
$pdf->stream('Missing Marks', Array('Attachment'=>0));

    }
?>