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
    $sql = $db_9->prepare('SELECT DISTINCT(ex.nrc) AS nrc, ex.title AS title,ex.phone_number AS phone, ex.first_name AS first_name,ex.last_name AS last_name,
    ex.account_no AS account_no, cc.deputy_c_person AS rate, cc.deputy_c_person AS amount_claimed,
                           b.name AS bank,br.name AS branch
                           FROM bankbranch br INNER JOIN bank b ON (br.bank_id = b.id)
                           INNER JOIN examiner ex ON (b.id = ex.bank)
                           INNER JOIN centre_chairperson_rate cc ON (ex.session = cc.session)
                           WHERE ex.branch = br.id
                           AND ex.attendance = "1"
                           AND ex.role = "7"
                           AND ex.province =:province_code
                           AND ex.marking_centre =:marking_centre_code
                           GROUP BY ex.title,ex.phone_number,ex.first_name,ex.last_name,cc.deputy_c_person,ex.nrc,ex.account_no,b.name,br.name');
    $sql->execute(array(
        ':marking_centre_code'=>$_SESSION['marking_centre_code'],
        ':province_code'=>$_SESSION['province_code']
    ));
    $sql->bindColumn('first_name',$first_name);
    $sql->bindColumn('last_name',$last_name);
    $sql->bindColumn('bank',$bank);
    $sql->bindColumn('branch',$branch);
    $sql->bindColumn('account_no',$account_no);
    $sql->bindColumn('nrc',$nrc);
    $sql->bindColumn('phone',$phone);
    $sql->bindColumn('amount_claimed',$amount_claimed);
    $sql->bindColumn('rate',$rate);
    $sql->fetch(PDO::FETCH_BOUND);

?>

<doctype html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../../assets/css/reports.css">
        <title>centre chairperson claims</title>
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
                <p style="text-align: center;">DEPUTY CENTRE CHAIRPERSON CLAIM</p> 
            </td>
        </tr>
    </table>

    <table class="head-data w100" style="margin-top: 10px;">
    <tr>
        <th>
            MARKING CENTRE: <?php echo $_SESSION['marking_centre']; ?>
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
            CENTRE CHAIRPERSON RATE:  K <?php echo $rate; ?>
        </th>
    </tr>
    <tr>
        <th>
            PHONE No: <?php echo $phone; ?>
        </th>
        <th>
          
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
$pdf->stream('CENTRE CHAIRPERSON CLAIM', Array('Attachment'=>0));

    
?>