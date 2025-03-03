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

    if(isset($_POST['subject']) && isset($_POST['paper']) && isset($_POST['centre_type'])){
        $subject_code = $_POST['subject'];
        $paper_no = $_POST['paper'];
        $centre_type = $_POST['centre_type'];
        
        // $no_of_missing_mark = 0;
        // $no_of_absentees = 0;
        // $total_no_of_candidates = 0;
        $sql = $db_12_gce->prepare('SELECT su.subject_code AS subject_code,su.subject_name AS subject_name, pa.paper_no AS paper_no,
                                     COUNT(m.exam_no) AS no_of_candidates,
                                     CAST(m.mark AS UNSIGNED) AS mark,
                                 (SELECT COUNT(*) FROM marks WHERE subject_code =:subject_code AND paper_no =:paper_no AND marking_centre =:marking_centre_code) AS total_no_of_candidates, 
                                 (SELECT COUNT(*) FROM marks WHERE subject_code =:subject_code AND paper_no =:paper_no AND marking_centre =:marking_centre_code AND status ="L") AS no_of_missing_mark, 
                                 (SELECT COUNT(*) FROM marks WHERE subject_code =:subject_code AND paper_no =:paper_no AND marking_centre =:marking_centre_code  AND status ="X")AS no_of_absentees,
                                 (SELECT mark FROM marks WHERE subject_code =:subject_code AND paper_no =:paper_no AND marking_centre =:marking_centre_code AND status NOT IN ("X","L") ORDER BY CAST(mark AS UNSIGNED) DESC LIMIT 1) AS highest_mark,
                                 (SELECT mark FROM marks WHERE subject_code =:subject_code AND paper_no =:paper_no AND marking_centre =:marking_centre_code AND status NOT IN ("X","L") ORDER BY CAST(mark AS UNSIGNED) ASC LIMIT 1) AS lowest_mark
                                
                                FROM marks m INNER JOIN subjects su ON (m.subject_code = su.subject_code)
                                INNER JOIN paper pa ON (su.subject_code = pa.subject_code)
                                WHERE m.paper_no = pa.paper_no
                                AND m.subject_code = pa.subject_code
                                AND m.subject_code =:subject_code
                                AND m.paper_no =:paper_no
                                AND m.status NOT IN ("L","X")
                                AND m.centre_code IN (SELECT centre_code FROM school WHERE centre_type =:centre_type)
                                AND m.marking_centre =:marking_centre_code
                                GROUP BY su.subject_code,su.subject_name,pa.paper_no, CAST(m.mark AS UNSIGNED)
                                ORDER BY CAST(m.mark AS UNSIGNED) DESC');
        $sql->execute(array(
            ':subject_code'=>$subject_code,
            ':paper_no'=>$paper_no,
            ':centre_type'=>$centre_type,
            ':marking_centre_code'=>$_SESSION['marking_centre_code']
        ));
        $row = $sql->rowCount();
        $sql->bindColumn('subject_code',$subject_code);
        $sql->bindColumn('subject_name',$subject_name);
        $sql->bindColumn('paper_no',$paper_no);
        $sql->bindColumn('total_no_of_candidates',$total_no_of_candidates);
        $sql->bindColumn('no_of_candidates',$no_of_candidates);
        $sql->bindColumn('mark',$mark);
        $sql->bindColumn('no_of_missing_mark',$no_of_missing_mark);
        $sql->bindColumn('highest_mark',$highest_mark);
        $sql->bindColumn('lowest_mark',$lowest_mark);
        $sql->bindColumn('no_of_absentees',$no_of_absentees);
        $sql->fetch(PDO::FETCH_BOUND);

    
?>

<doctype html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../../assets/css/reports.css">
        <title>Improvised Marks Report</title>
    </head>
    <body>
   
        <style>
      </style>
    <table class="center" style="width: 500px;margin-bottom:3px;">
        <tr >
            <td>
                <img src="../../assets/img/eczlogo_tr_sm.jpg" style="width:80%">
            </td>
            <td>
               <p  style="text-align: center;">EXAMINATIONS COUNCIL OF ZAMBIA</p> 
                <p style="text-align: center;"><?php echo $_SESSION['session_name']; ?></p>
                <p style="text-align: center;">FREQUENCY DISTRIBUTION</p> 
            </td>
        </tr>
    </table>

    <table class="head-data w100" style="margin-top: 5px;">
    <tr>
        <th>
        Subject Code : <?php echo $subject_code; ?>
        </th>
    </tr>
    <tr>
        <th>
        Subject Name : <?php echo $subject_name; ?>
        </th>
        
       
    </tr>
    <tr>
        <th>
        Paper Code : <?php echo $paper_no; ?>
        </th>
        
    </tr>
    </table>

    <table class=" w100" style=" margin-top:10px;">
        <thead style="border-bottom: 1px solid black;border-top: 1px solid black;">
            <th>
                MARK
            </th>
            <th>
                NO. OF CANDIDATES
            </th>
            
        </thead>
        <tbody >
            <?php
            do{
            ?>
            <tr>
                <td><?php echo $mark; ?></td>
                <td><?php echo $no_of_candidates; ?></td>              
   
            </tr>
            <?php
            // $marks = array($mark);
            
            // $lowest_mark[] = min($mark);
            // $total_no_of_candidates++;
            // $no_of_missing_mark += $no_of_missing_mark;
            // $no_of_absentees += $no_of_absentees;
            } while($sql->fetch(PDO::FETCH_BOUND));
            // $highest_mark = max($marks);
            // $lowest_mark = min($marks);
            ?>
        </tbody>

    </table>

    <div>
        <p><strong>Total Number Of Candidates: <?php echo $total_no_of_candidates; ?></strong> </p>
    </div>

    <table class="w100" style="margin-top: 10px;">
        <tbody>
            <tr>
                <th>Highest Mark Obtained: <?php echo $highest_mark; ?></th> 
                <th>Absentees: <?php echo $no_of_absentees; ?></th> 
            </tr>
            <tr>
                <th>Lowest Mark Obtained: <?php echo $lowest_mark; ?></th> 
                <th>Missing Marks: <?php echo $no_of_missing_mark; ?></th> 
            </tr>
            
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
$canvas->page_text(50, $y, $date_generated, $font, 10);
$pdf->stream('frequecy_distribution', Array('Attachment'=>0));

    }
?>