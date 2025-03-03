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
    if((isset($_POST['marking_centre']) || isset($_SESSION['marking_centre_code'])) && (isset($_POST['deo']) || isset($_SESSION['username']))){
        $username = $_POST['deo'] ?? $_SESSION['username'];
        $marking_centre_code = $_POST['marking_centre'] ?? $_SESSION['marking_centre_code'];
    
    $sql = $db_12_gce->prepare('SELECT marking_centre_name,full_name,nrc,phone_number,account_no,bank,branch,SUM(no_of_scripts) AS no_of_scripts,SUM(gross_pay) AS gross_pay,SUM(15_wht) AS 15_wht,SUM(net_pay) AS net_pay,address,district,province,MAX(date_claimed) AS date_claimed,grossed_up_rate,session_name FROM data_entry_claims
                                WHERE marking_centre_code =:marking_centre_code AND examiner_number =:examiner_number
                                GROUP BY marking_centre_name,full_name,nrc,phone_number,account_no,bank,branch,address,district,province,grossed_up_rate,session_name
                                ');
    $sql->execute(array(
        ':examiner_number'=>$username,
        ':marking_centre_code'=>$marking_centre_code
    ));
   $row = $sql->fetch(PDO::FETCH_ASSOC);
   $full_name = $row['full_name'] ?? '';
   $bank = $row['bank'] ?? '';
   $branch = $row['branch'] ?? '';
   $account_no = $row['account_no'] ?? '';
   $nrc = $row['nrc'] ?? '';
   $phone = $row['phone_number'] ?? '';
   $address = $row['address'] ?? '';
   $district = $row['district'] ?? '';
   $province = $row['province'] ?? '';
   $no_of_scripts = $row['no_of_scripts'] ?? '';
   $gross_pay = $row['gross_pay'] ?? '';
   $wht = $row['15_wht'] ?? '';
   $net_pay = $row['net_pay'] ?? '';
   $date_claimed = $row['date_claimed'] ?? '';
   $data_entry_rate = $row['grossed_up_rate'] ?? '';
   $session_name = $row['session_name'] ?? '';
   $marking_centre_name = $row['marking_centre_name'] ?? '';
    // $sql->bindColumn('full_name',$full_name);
    // $sql->bindColumn('bank',$bank);
    // $sql->bindColumn('branch',$branch);
    // $sql->bindColumn('account_no',$account_no);
    // $sql->bindColumn('nrc',$nrc);
    // $sql->bindColumn('phone_number',$phone);
    // $sql->bindColumn('address',$address);
    // $sql->bindColumn('district',$district);
    // $sql->bindColumn('province',$province);
    // $sql->bindColumn('no_of_scripts',$no_of_scripts);
    // $sql->bindColumn('gross_pay',$gross_pay);
    // $sql->bindColumn('15_wht',$wht);
    // $sql->bindColumn('net_pay',$net_pay);
    // $sql->bindColumn('date_claimed',$date_claimed);
    // $sql->bindColumn('grossed_up_rate',$data_entry_rate);
    // $sql->bindColumn('session_name',$session_name);
    // $sql->bindColumn('marking_centre_name',$marking_centre_name);
    // $sql->fetch(PDO::FETCH_BOUND);

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
            Marking Center: <?php echo $marking_centre_name; ?>
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
        <th >
            GROSS: K <?php echo number_format((float)$gross_pay,2,'.',''); ?> <br />
            TAX (15%): K <?php echo number_format((float)$wht,2,'.',''); ?> <br />
            NET: K <?php echo number_format((float)$net_pay,2,'.',''); ?>
    </th>
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
    <p>DATE CLAIMED: <?php echo date('d /m / Y',strtotime($date_claimed)) ?></p>
    <p>VERIFIED BY CHIEF EXAMINER (FULLNAME) :</p>
    <p>SIGNATURE :</p>
    <p>DATE VERIFIED :</p>
    
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

}else{
    echo 'no set ';
}
?>