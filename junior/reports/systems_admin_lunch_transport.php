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
    $sql = $db_9->prepare('SELECT u.first_name AS first_name, u.last_name AS last_name,
    u.nrc AS nrc,u.phone AS phone, lt.transport AS transport,lt.lunch AS lunch

    
    FROM users u CROSS JOIN lun_trans lt
    WHERE  u.username =:username
    AND u.user_type = "ADMIN"
    GROUP BY u.first_name,u.last_name,u.nrc,u.phone,lt.transport,lt.lunch');
                            
    $sql->execute(array(
        ':username'=>$_SESSION['username']
    ));
    $sql->bindColumn('first_name',$first_name);
    $sql->bindColumn('last_name',$last_name);
    $sql->bindColumn('nrc',$nrc);
    $sql->bindColumn('phone',$phone);
    // $sql->bindColumn('no_of_scripts',$no_of_scripts);
    $sql->bindColumn('transport',$transport);
    $sql->bindColumn('lunch',$lunch);
    $sql->fetch(PDO::FETCH_BOUND);

?>

<doctype html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../../assets/css/reports.css">
        <tilte>Systems Admin Lunch and Transport Allowance</tilte>
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
                <p style="text-align: center;"><?php echo $_SESSION['session_name']; ?></p>
                <p style="text-align: center;">SYSTEMS ADMIN LUNCH AND TRANSPORT</p> 
            </td>
        </tr>
    </table>

    <table class="head-data w100" style="margin-top: 10px;">
    <tr>
        <th>
            MARKING CENTRE: <?php echo $_SESSION['marking_centre']; ?>
        </th>
    
    </tr>
    <tr>
        <th>
           FIRST NAME:  <?php echo $first_name; ?>
        </th>
       
      
       
    </tr>
    <tr>
        <th>
           LASTNAME:  <?php echo $last_name; ?>
        </th>
        
        
        
    </tr>
    <tr>
        <th>
            NRC No:  <?php echo $nrc; ?>
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
        
        <th >TRANSPORT: K <?php echo $transport; ?></th>
        <th >LUNCH: K <?php echo $lunch; ?></th>
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

    
?>