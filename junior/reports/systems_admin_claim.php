<?php
header("Access-Control-Allow-Origin: *"); 
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
    if(isset($_POST['marking_centre']) || isset($_SESSION['marking_centre_code'])){

        $marking_centre_code = $_POST['marking_centre'] ?? $_SESSION['marking_centre_code'];
        if(isset($_SESSION['marking_centre_code'])){
    $sql = $db_9->prepare('SELECT marking_centre_name,full_name,phone_number,nrc,bank,branch,account_no,grossed_up_rate,gross_pay,15_wht,net_pay,bank, branch,account_no,session_name
                            FROM system_admin_claims WHERE marking_centre_code =:marking_centre_code');
                            
    $sql->execute(array(
        ':marking_centre_code'=>$marking_centre_code
    ));
    $row = $sql->fetch(PDO::FETCH_ASSOC);
    $full_name = $row['full_name'] ?? '';
    $bank = $row['bank'] ?? '';
    $branch = $row['branch'] ?? '';
    $account_no = $row['account_no'] ?? '';
    $nrc = $row['nrc'] ?? '';
    $phone = $row['phone_number'] ?? '';
    $marking_centre_name = $row['marking_centre_name'] ?? '';
    $session_name = $row['session_name'] ?? '';
    $gross_pay = $row['gross_pay'] ?? '';
    $withhold_tax = $row['15_wht'] ?? '';
    $net_pay = $row['net_pay'] ?? '';
    $system_admin_rate = $row['grossed_up_rate'] ?? '';


    // $sql->bindColumn('full_name',$full_name);

    // $sql->bindColumn('bank',$bank);
    // $sql->bindColumn('branch',$branch);
    // $sql->bindColumn('account_no',$account_no);
    // $sql->bindColumn('nrc',$nrc);
    // $sql->bindColumn('phone_number',$phone);
    // $sql->bindColumn('marking_centre_name',$marking_centre_name);
    // $sql->bindColumn('session_name',$session_name);
    // $sql->bindColumn('gross_pay',$gross_pay);
    // $sql->bindColumn('15_wht',$withhold_tax);
    // $sql->bindColumn('net_pay',$net_pay);
    // $sql->bindColumn('grossed_up_rate',$system_admin_rate);
    // $sql->fetch(PDO::FETCH_BOUND);
}else{
    if($_POST['marking_centre']){
        $sql = $db_9->prepare('SELECT marking_centre_name, full_name,phone_number,nrc,bank,branch,account_no,grossed_up_rate,gross_pay,15_wht,net_pay,bank, branch,account_no,session_name
        FROM system_admin_claims WHERE marking_centre_code =:marking_centre_code ');
        
$sql->execute(array(
':marking_centre_code'=>$marking_centre_code
));
$row = $sql->fetch(PDO::FETCH_ASSOC);
$full_name = $row['full_name'] ?? '';
$bank = $row['bank'] ?? '';
$branch = $row['branch'] ?? '';
$account_no = $row['account_no'] ?? '';
$nrc = $row['nrc'] ?? '';
$phone = $row['phone_number'] ?? '';
$marking_centre_name = $row['marking_centre_name'] ?? '';
$session_name = $row['session_name'] ?? '';
$gross_pay = $row['gross_pay'] ?? '';
$withhold_tax = $row['15_wht'] ?? '';
$net_pay = $row['net_pay'] ?? '';
$system_admin_rate = $row['grossed_up_rate'] ?? '';

// $sql->bindColumn('full_name',$full_name);

// $sql->bindColumn('bank',$bank);
// $sql->bindColumn('branch',$branch);
// $sql->bindColumn('account_no',$account_no);
// $sql->bindColumn('nrc',$nrc);
// $sql->bindColumn('phone_number',$phone);
// $sql->bindColumn('marking_centre_name',$marking_centre_name);
// $sql->bindColumn('session_name',$session_name);
// $sql->bindColumn('gross_pay',$gross_pay);
// $sql->bindColumn('15_wht',$withhold_tax);
// $sql->bindColumn('net_pay',$net_pay);
// $sql->bindColumn('grossed_up_rate',$system_admin_rate);
// $sql->fetch(PDO::FETCH_BOUND);

    }
}

?>

<doctype html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../../assets/css/reports.css">
        <title>Systems Admin Claim</title>
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
                <p style="text-align: center;">EXAMINATIONS COUNCIL OF ZAMBIA</p> 
                <p style="text-align: center;"><?php echo $session_name; ?></p>
                <p style="text-align: center;">SYSTEMS ADMIN CLAIM</p> 
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
            SYSTEMS ADMIN RATE:  K <?php echo number_format((float)$system_admin_rate,2,'.',''); ?>
        </th>
    </tr>
    <tr>
        <th>
            PHONE No: <?php echo $phone; ?>
        </th>
        <!-- <th>
            TOTAL No OF SCRIPTS APPORTIONED: <?php // echo $no_of_scripts; ?>
        </th> -->
    </tr>
    <!-- <tr>
        <th></th>
        <th></th>
    </tr> -->
    <tr>
        <th></th>
        <th >GROSS PAY: K <?php echo number_format((float)$gross_pay,2,'.',''); ?></th>
    
    </tr>
    <tr>
        <th></th>
        <th >WITHHOLDING TAX (15%): K <?php echo number_format((float)$withhold_tax,2,'.',''); ?></th>
    
    </tr>
    <tr>
        <th></th>
        <th >NET PAY : K <?php echo number_format((float)$net_pay,2,'.',''); ?></th>
    
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
$pdf->stream('SYSTEMS ADMIN CLAIM', Array('Attachment'=>0));

}
?>