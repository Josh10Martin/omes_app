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
    $sql = $db_12_gce->prepare('SELECT DISTINCT(ex.nrc) AS nrc, ex.first_name AS first_name, ex.last_name AS last_name, ex.address AS address,ex.district AS district, ex.province AS province,ex.bank AS bank, ex.branch AS branch, ex.account_no AS account_no,
                            ex.phone_number AS phone, SUM(m.status <> "L") AS no_of_scripts, SUM(m.status <> "L") * mr.data_entry AS amount_claimed,
                            m.centre_code AS centre_code,m.exam_no AS exam_no,mr.data_entry AS data_entry_rate
                            FROM examiner ex INNER JOIN marks_questions m ON (ex.marking_centre = m.marking_centre)                            
                            INNER JOIN marking_rates mr ON (m.subject_code = mr.subject_code)
                            WHERE m.paper_no = mr.paper_no
                            AND ex.subject_code = mr.subject_code
                            AND ex.paper_no = mr.paper_no
                            AND ex.subject_code = m.subject_code
                            AND ex.paper_no = m.paper_no
                            AND m.marking_centre =:marking_centre_code
                            AND ex.examiner_number = LEFT(m.entered_by,LOCATE(" ",m.entered_by) -1)
                            AND m.entered_by =:username
                            AND ex.examiner_number =:examiner_number
                            AND ex.role = "DATA ENTRY OFFICER"
                            GROUP BY m.centre_code,m.exam_no,ex.first_name,ex.last_name,ex.bank, ex.branch,ex.account_no,ex.nrc,ex.phone_number,mr.data_entry');
    $sql->execute(array(
        ':examiner_number'=>$_SESSION['username'],
        ':marking_centre_code'=>$_SESSION['marking_centre_code'],
        ':username'=>$_SESSION['username'].' - '.$_SESSION['first_name'].' '.$_SESSION['last_name']
    ));
    $sql->bindColumn('first_name',$first_name);
    $sql->bindColumn('last_name',$last_name);
    $sql->bindColumn('bank',$bank);
    $sql->bindColumn('branch',$branch);
    $sql->bindColumn('account_no',$account_no);
    $sql->bindColumn('nrc',$nrc);
    $sql->bindColumn('phone',$phone);
    $sql->bindColumn('address',$address);
    $sql->bindColumn('district',$district);
    $sql->bindColumn('province',$province);
    $sql->bindColumn('no_of_scripts',$no_of_scripts);
    $sql->bindColumn('amount_claimed',$amount_claimed);
    $sql->bindColumn('data_entry_rate',$data_entry_rate);
    $sql->fetch(PDO::FETCH_BOUND);

?>

<doctype html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../../assets/css/reports.css">
        <title>Data enter Claim</title>
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
                <p style="text-align: center;">DATA ENTRY CLAIM</p> 
            </td>
        </tr>
    </table>

    <table class="head-data w100" style="margin-top: 10px;">
    <tr>
        <th>
            Marking Center: <?php echo $_SESSION['marking_centre']; ?>
        </th>
        <th>
            ACCOUNT No: <?php echo $account_no; ?>
        </th>
    </tr>
    <tr>
        <th>
           FIRST NAME:  <?php echo $first_name; ?>
        </th>
        <th>
            BANK:  <?php echo $bank; ?>
        </th>
      
       
    </tr>
    <tr>
        <th>
           LASTNAME:  <?php echo $last_name; ?>
        </th>
        <th>
            BRANCH:  <?php echo $branch; ?>
        </th>
        
        
    </tr>
    <tr>
        <th>
            NRC No:  <?php echo $nrc; ?>
        </th>
        <th>
            DATA ENTRY RATE:  K <?php echo $data_entry_rate; ?>
        </th>
    </tr>
    <tr>
        <th>
            PHONE No: <?php echo $phone; ?>
        </th>
        <th>
            TOTAL No OF SCRIPTS ENTERED: <?php echo $no_of_scripts; ?>
        </th>
    </tr>
    <tr>
        <th></th>
        <th></th>
    </tr>
    <tr>
        <th></th>
        <th >AMOUNT CLAIMED: K <?php echo number_format((float)$amount_claimed,2,'.',''); ?></th>
    </tr>
    <tr>
        
        <th >ADDRESS: <?php echo $address; ?></th>
    </tr>
    <tr>
        
        <th >DISTRICT: <?php echo $district; ?></th>
    </tr>
    <tr>
        
        <th >PROVINCE: <?php echo $province; ?></th>
    </tr>
    </table>

    <div style="padding-top: 5px;">
    <p>CLAIMANT SIGNATURE :</p>
    <p>DATE CLAIMED: <?php echo date('d / m / Y'); ?></p>
    <p>VERIFIED BY CHIEF EXAMINER (FULLNAME) :</p>
    <p>SIGNATURE :</p>
    <p>DATE VERIFIED :</p>
    <br>
    <p>CONFIRMED BY CENTRE COORDINATOR (FULLNAME) :</p>
    <p>SIGNATURE :</p>
    <p>DATE CONFIRMED :</p>
    <br>

    <p>APPROVED BY DIRECTOR (EAD) :</p>
    <p>SIGNATURE :</p>
    <p>DATE APPROVED :</p>

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
$pdf->stream('DATA ENTRY CLAIM', Array('Attachment'=>0));

    
?>