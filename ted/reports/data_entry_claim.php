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
    if((isset($_SESSION['username']) || isset($_POST['deo'])) && (isset($_SESSION['marking_centre_code']) || isset($_POST['marking_centre'])) && isset($_SESSION['session_year']) || isset($_POST['session'])){

    $username = $_SESSION['username'] ?? $_POST['deo'];
    $marking_centre_code = $_SESSION['marking_centre_code'] ?? $_POST['marking_centre'];
    $session = $_SESSION['session_year'] ?? $_POST['session'];

    $sql = $db_ted->prepare('SELECT marking_centre_name, full_name, bank, branch, account_no,nrc,phone_number,no_of_scripts,gross_pay,15_wht,net_pay,
                                    grossed_up_rate, date_claimed,session_name 
                                    FROM data_entry_claims WHERE examiner_number =:examiner_number AND marking_centre_code =:marking_centre_code AND session =:session');
    $sql->execute(array(
        ':session'=>$session,
        ':marking_centre_code'=>$marking_centre_code,
        ':examiner_number'=>$username
    ));
    $row = $sql->fetch(PDO::FETCH_ASSOC);
    $full_name = $row['full_name'] ?? '';
    $bank = $row['bank'] ?? '';
    $branch = $row['branch'] ?? '';
    $account_no = $row['account_no'] ?? '';
    $phone = $row['phone_number'] ?? '';
    $no_of_scripts = $row['no_of_scripts'] ?? '';
    $gross_pay = $row['gross_pay'] ?? '';
    $wht = $row['15_wht'] ?? '';
    $net_pay = $row['net_pay'] ?? '';
    $net_pay = $row['net_pay'] ?? '';
    $data_entry_rate = $row['grossed_up_rate'] ?? '';
    $date_claimed = $row['date_claimed'] ?? '';
    $session_name = $row['session_name'] ?? '';

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
                <p style="text-align: center;"><?php echo $session_name; ?></p>
                <p style="text-align: center;">DATA ENTRY CLAIM</p> 
            </td>
        </tr>
    </table>

    <table class="head-data w100" style="margin-top: 10px;">
    <tr>
        <th>
            MARKING CENTRE: <?php echo $marking_centre_name; ?>
        </th>
        <th>
            ACCOUNT No: <?php echo $account_no; ?>
        </th>
    </tr>
    <tr>
        <th>
           FULL NAME:  <?php echo $full_name; ?>
        </th>
        <th>
            BANK:  <?php echo $bank; ?>
        </th>
      
       
    </tr>
    <tr>
       
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
            TOTAL No OF SCRIPTS MARKED: <?php echo $no_of_scripts; ?>
        </th>
    </tr>
    <tr>
        <th></th>
        <th></th>
    </tr>
    <tr>
        <th></th>
        <th >GROSS PAY: K <?php echo number_format((float)$gross_pay,2,'.',''); ?></th>
       </tr>
    <tr>
        <th></th>
        <th >TAX(15%): K <?php echo number_format((float)$wht,2,'.',''); ?></th>
    </tr>
    <tr>
        <th></th>
        <th >NET PAY: K <?php echo number_format((float)$net_pay,2,'.',''); ?></th>
    </tr>
    </table>

    <div style="padding-top: 5px;">
    <p>CLAIMANT SIGNATURE :</p>
    <p>DATE CLAIMED: <?php echo date("d / m / Y",strtotime($date_claimed)); ?></p>
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

}
?>