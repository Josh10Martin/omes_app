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
    if(isset($_POST['centre_code']) || isset($_POST['subject']) || isset($_POST['paper'])){

        $centre_code = $_POST['centre_code'];
        $subject_code = $_POST['subject'];
        $paper_no = $_POST['paper'];
        $i =0;
        $sql = $db_12_gce->prepare('SELECT m.exam_no AS exam_no,GROUP_CONCAT(m.question ORDER BY m.question ASC) AS question,GROUP_CONCAT(CONCAT("[Q ",m.question," - ",m.mark,"] | ") ORDER BY m.question ASC SEPARATOR "") AS mark,ma.mark AS total_mark,
                                GROUP_CONCAT(DISTINCT(m.status) ORDER BY m.question ASC) AS status, m.entered_by AS entered_by,sc.centre_code AS centre_code,sc.centre_name AS centre_name,
                                su.subject_code AS subject_code,su.subject_name AS subject_name,pa.paper_no AS paper_no
                                FROM marks ma INNER JOIN school sc ON (ma.centre_code = sc.centre_code)
                                INNER JOIN marks_questions m ON (sc.centre_code = m.centre_code)
                                INNER JOIN subjects su ON (m.subject_code = su.subject_code)
                                INNER JOIN paper pa ON (su.subject_code = pa.subject_code)
                                WHERE ma.centre_code = m.centre_code
                                AND ma.exam_no = m.exam_no
                                AND ma.subject_code = m.subject_code
                                AND ma.paper_no = m.paper_no
                                AND m.paper_no = pa.paper_no
                                AND m.subject_code =:subject_code
                                AND m.paper_no =:paper_no
                                AND m.centre_code =:centre_code
                                AND m.improvised_mark = "0"
                                AND ((m.entered_by =:username) OR (m.entered_by =:username OR m.entered_by IS NULL))
                                AND m.marking_centre =:marking_centre_code
                                GROUP BY m.exam_no,ma.mark,m.entered_by,sc.centre_code,sc.centre_name,su.subject_code,su.subject_name,pa.paper_no
                                ');
        $sql->execute(array(
            ':subject_code'=>$subject_code,
            ':paper_no'=>$paper_no,
            ':centre_code'=>$centre_code,
            ':username'=>$_SESSION['username'].' - '.$_SESSION['first_name'].' '.$_SESSION['last_name'],
            ':marking_centre_code'=>$_SESSION['marking_centre_code']
        ));

        $sql->bindColumn('exam_no',$exam_no);
        // $sql->bindColumn('first_name',$first_name);
        // $sql->bindColumn('last_name',$last_name);
        $sql->bindColumn('mark',$mark);
        $sql->bindColumn('total_mark',$total_mark);
        $sql->bindColumn('question',$question);
        $sql->bindColumn('status',$status);
        $sql->bindColumn('entered_by',$entered_by);
        $sql->bindColumn('centre_code',$centre_code);
        $sql->bindColumn('centre_name',$centre_name);
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
        <title>Transcription Checklist</title>
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
                <p style="text-align: center;"><?php echo $_SESSION['session_name']; ?></p>
                <p style="text-align: center;">TRANSCRIPTION CHECKLIST</p> 
            </td>
        </tr>
    </table>

    <table class="head-data w100" style="margin-top: 5px;">
    <tr>
        <!-- <th>
            Marking Centre Code: <?php // echo $_SESSION['marking_centre_code']; ?>    
        </th> -->
    </tr>
    <tr>
        
        <th>
            Level: <?php echo $_SESSION['session_level']; ?>
        </th>
        <th>
            Center Code: <?php   echo $centre_code; ?>
        </th>
        <th>
            Center Name: <?php   echo $centre_name; ?>
        </th>
    </tr>
    <tr>
        <th>
            Session: <?php echo $_SESSION['session_id']; ?>
        </th>
        <th>
            
        </th>
            Subject Code: <?php  echo $subject_code; ?>
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
            <!-- <th>
                SURNAME
            </th>
            <th>
                FORST NAME
            </th> -->
            <!-- <th>
                QUESTION
            </th> -->
            <th>
                MARK
            </th>
            <th>
            TOTAL
            </th>
            <th>
                STATUS
            </th>
            <th>
                ENTERED BY
            </th>
        </thead>
        <tbody >
            <?php
           do{
            ?>
            <tr>
                <td><?php  echo $exam_no; ?></td>
                <!-- <td><?php // echo $last_name; ?></td>              
                <td><?php // echo $first_name; ?></td> -->
                <!-- <td><?php echo $question; ?></td> -->
                <td><?php echo $mark; ?></td>
                <td style="text-align:center;"><?php echo $total_mark; ?></td>
                <td><?php echo $status; ?></td>
                <td><?php echo $entered_by; ?></td>
               
                
            </tr>
            <?php
           $i++;
           } while($sql->fetch(PDO::FETCH_BOUND));
            ?>
        </tbody>
    </table>

    <div>
        <p><strong>Total Number Of Candidates: <?php if($exam_no){echo $i;}else{echo '0';}; ?></strong> </p>
    </div>

    <table class="w100">
        <tbody>
            <tr>
                <th>VERIFIED BY TEAM LEADER (FULLNAME):................................................................................</th>
                <th>SIGNATURE:........................................................</</th>
            </tr>
            <!-- <tr>
                <th>CONFIRMED BY CENTRE COORDINATOR (FULLNAME):............................................................</</th>
                <th>SIGNATURE:............................................................</</th>
            </tr> -->
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

$textHeight = $fontMetrics->getFontHeight($text, 35);
$textWidth = $fontMetrics->getTextWidth($font, $text, 5);

$x = $w - $textWidth;
$y = $h - $textHeight;


$canvas->page_text($x, $y, $text, $font, 10);
$canvas->page_text(50, $y, $date_generated, $font, 10);
$pdf->stream('Attendance Report', Array('Attachment'=>0));


}
?>