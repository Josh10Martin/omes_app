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
    $sql = $db_ted->prepare('SELECT u.first_name AS first_name, u.last_name AS last_name, b.name AS bank,br.name AS branch, u.account_no AS account_no,
    u.nrc AS nrc,u.phone AS phone, 

(
    SELECT 
    (
        SELECT MAX(no_of_scripts) 
        FROM group_apportion 
        WHERE marking_centre = :marking_centre_code
    ) * (mr.sys_admin) / 
    (
        SELECT COUNT(*) AS examiner_count
        FROM examiner
        WHERE (belt_no, subject_code, paper_no,marking_centre) IN (
            SELECT belt_no, subject, paper,marking_centre
            FROM group_apportion
            WHERE no_of_scripts = (
                SELECT MAX(no_of_scripts)
                FROM group_apportion
                WHERE marking_centre = :marking_centre_code
            )
        )
        AND role IN ("1","3") AND marking_centre=:marking_centre_code
    ) 

) AS amount_claimed,

    mr.sys_admin AS system_admin_rate
    FROM bankbranch br INNER JOIN bank b ON (br.bank_id = b.id)
    INNER JOIN users u ON (b.id = u.bank)
    INNER JOIN group_apportion g ON (u.marking_centre = g.marking_centre)
    INNER JOIN marking_rates mr ON (g.subject = mr.subject_code)
    WHERE g.paper = mr.paper_no
    AND u.branch = br.id
    AND g.marking_centre =:marking_centre_code
    AND u.username = LEFT(g.username,LOCATE(" ",g.username) -1)
    AND g.username =:username
    AND u.user_type = "ADMIN"
    GROUP BY u.first_name,u.last_name,b.name,br.name,u.account_no,u.nrc,u.phone,mr.sys_admin');
                            
    $sql->execute(array(
        ':marking_centre_code'=>$_SESSION['marking_centre_code'],
        ':province_code'=>$_SESSION['province_code'],
        ':username'=>$_SESSION['username'].' - '.$_SESSION['first_name'].' '.$_SESSION['last_name']
    ));
    $sql->bindColumn('first_name',$first_name);
    $sql->bindColumn('last_name',$last_name);
    $sql->bindColumn('bank',$bank);
    $sql->bindColumn('branch',$branch);
    $sql->bindColumn('account_no',$account_no);
    $sql->bindColumn('nrc',$nrc);
    $sql->bindColumn('phone',$phone);
    // $sql->bindColumn('no_of_scripts',$no_of_scripts);
    $sql->bindColumn('amount_claimed',$amount_claimed);
    $sql->bindColumn('system_admin_rate',$system_admin_rate);
    $sql->fetch(PDO::FETCH_BOUND);

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
                <p style="text-align: center;"><?php echo $_SESSION['session_name']; ?></p>
                <p style="text-align: center;">SYSTEMS ADMIN CLAIM</p> 
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
$pdf->stream('SYSTEMS ADMIN CLAIM', Array('Attachment'=>0));

    
?>