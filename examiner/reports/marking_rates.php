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
$options->setChroot(__DIR__ . '/../../assets'); // FIXED
$pdf = new Dompdf($options);

ob_start();

// Fetch data
$sql = $db_12_gce->prepare('SELECT su.subject_code AS subject_code, su.subject_name AS subject_name, pa.paper_no AS paper_no,
    mr.chief_examiner AS chief_examiner, mr.deputy_c_examiner AS deputy_chief_examiner,
    mr.t_leader AS team_leader, mr.examiner AS examiner, mr.checker AS checker, mr.data_entry AS data_entry
    FROM marking_rates mr 
    INNER JOIN subjects su ON (mr.subject_code = su.subject_code)
    INNER JOIN paper pa ON (su.subject_code = pa.subject_code)
    WHERE mr.paper_no = pa.paper_no
    AND (mr.subject_code, mr.paper_no) IN (SELECT subject,paper FROM marking_centre where centre_code =:marking_centre_code)
    ');
$sql->execute(array(
    ':marking_centre_code'=>$_SESSION['marking_centre_code']
));

$sql->bindColumn('subject_code', $subject_code);
$sql->bindColumn('subject_name', $subject_name);
$sql->bindColumn('paper_no', $paper_no);
$sql->bindColumn('chief_examiner', $chief_examiner);
$sql->bindColumn('deputy_chief_examiner', $deputy_chief_examiner);
$sql->bindColumn('team_leader', $team_leader);
$sql->bindColumn('examiner', $examiner);
$sql->bindColumn('checker', $checker); // ADDED
$sql->bindColumn('data_entry', $data_entry);
$sql->fetch(PDO::FETCH_BOUND);
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../../assets/css/reports.css">
        <title>Marking Rates</title>
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
                <p style="text-align: center;"><?php echo $_SESSION['session_year']," ", $_SESSION['session_name']; ?></p>
                <p style="text-align: center;">MARKING RATES</p> 
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
           
        </th>
        <th>
            
        </th>
        <th>
           
        </th>
    </tr>
    <tr>
        <th>
            Session: <?php echo $_SESSION['session_id']; ?>
        </th>
        <th>
            
        </th>
          
        <th>
           Data Entry rate: <?php  echo $data_entry; ?>
        </th>
        <th>
            
        </th>
    </tr>
    </table>

    <table class=" w100" style=" margin-top:10px;">
        <thead style="border-bottom: 1px solid black;border-top: 1px solid black;">
            <th>
              SUBJECT CODE
            </th>
             <th>
                <!-- SURNAME -->
            </th>
            <th>
                <!-- FORST NAME -->
            </th> 
            <th>
                SUBJECT NAME
            </th>
            <th>
                CHIEF EXAMINER
            </th>
            <th>
               DEPUTY CHIEF EXAMINER
            </th>
            <th>
              TEAM LEADER
            </th>
            <th>
              CHECKER
            </th>
            <th>
              EXAMINER
            </th>
        </thead>
        <tbody >
            <?php
           do{
            ?>
            <tr>
                <td><?php  echo $subject_code; ?></td>
                <td><?php // echo $last_name; ?></td>              
                <td><?php // echo $first_name; ?></td> 
                <td><?php echo $subject_name; ?></td>
                <td><?php echo $chief_examiner; ?></td>
                <td><?php echo $deputy_chief_examiner; ?></td>
                <td><?php echo $team_leader; ?></td>
                <td><?php echo $checker; ?></td>
                <td><?php echo $examiner; ?></td>
               
                
            </tr>
            <?php
          
           } while($sql->fetch(PDO::FETCH_BOUND));
            ?>
        </tbody>
    </table>

    <div>
        <p><strong>Formulas</strong> </p>
    </div>

    <table class="w100">
        <tbody>
            <tr>
                <th>
                        Chief Examiner / Deputy Chief Examiner: The calculation is derived from the examiner with the highest number
                        of scripts that they marked times their (chief examiner / deputy chief examiner) rate IE the belt in which each individual marker / examiner has marked the highest number of scripts (so that number)
                        times the rate eg if the highest number of scripts marked by an individual is 7, then 7 x the rate. Use the grossed up rate which is calculated at: current rate x (100/85) so for chief examiner the grossed up rate is 12 x (100/85) which is 14.1176470588236,
                        hence 7 x 14.1176470588236 = 98.8235294117652.. if the number of scripts is less than 100, then it is capped to 100 so the calculation is 100 x 14.1176470588236
                        which is 1,411.76470588236

                <//th>
            </tr>
            <tr>
                <th>
                    For Team leaders, Checkers and Examiners, The calculation is based on the number of scripts in the belt times their rate divide by the number of examiners in that belt (excluding checkers). the grossed up rate of 100/85 of the current rate is applied.
                    For example for english paper 2. the grossed up rate for a team leader in 11 x (100/85) which is 12.94117647058824. if a belt has a team leader, 3 examiners and a checker (5) and there are 600 scripts in the belt, the team leaders calculation will be
                    (600 * 12.94117647058824) / 4 which is 1,941.176470588236, final figure to be rounded off. Remember that checkers are not included in the count even when calculating their claim. if the number of scripts in a belt is less than 100, then the script count is 100

                </th>
               </tr>
            <tr>
                <th>
                   For data entry, their claim is based on the number of scripts they have entered x their grossed up rate of 100/85 of their current rate. eg if they have entered 2000 scripts, then their calculation is 0.25 * (100/85) = 0.2941176470588235, so 2000 x 0.2941176470588235
                   which is 588.2352941176471. Final figure to be rounded off.
                </th>
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

$w = $canvas->get_width();
$h = $canvas->get_height();
$font = $fontMetrics->getFont('times');

$text = "Page {PAGE_NUM} of {PAGE_COUNT}";
$date_generated = 'Date generated: ' . date("d/m/Y h:i:s a");

$textHeight = $fontMetrics->getFontHeight($font, 10);
$textWidth = $fontMetrics->getTextWidth($text, $font, 10);

$x = $w - $textWidth - 50;
$y = $h - 30;

$canvas->page_text($x, $y, $text, $font, 10);
$canvas->page_text(50, $y, $date_generated, $font, 10);

$pdf->stream('Marking_Rates.pdf', ['Attachment' => 0]);
?>