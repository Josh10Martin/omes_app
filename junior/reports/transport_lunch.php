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
    if(isset($_POST['subject']) && isset($_POST['paper']) && isset($_POST['belt_no'])){
        $subject_code = $_POST['subject'];
        $paper_no = $_POST['paper'];
        $belt_no = $_POST['belt_no'];

        $i =0;
        if($belt_no == 'all'){
        $sql = $db_9->prepare('SELECT ex.nrc AS nrc, CONCAT(ex.first_name," ",ex.last_name) AS full_name,
                                lt.lunch AS lunch,lt.transport AS transport,  ex.belt_no AS belt_no,
                                su.subject_code AS subject_code, su.subject_name AS subject_name,p.name AS role,pa.paper_no
                                
                                FROM position p INNER JOIN examiner ex ON (p.id = ex.role)
                                INNER JOIN subjects su ON (ex.subject_code = su.subject_code)
                                INNER JOIN paper pa ON (su.subject_code = pa.subject_code)
                                CROSS JOIN lun_trans lt 
                                WHERE ex.paper_no = pa.paper_no
                                AND ex.subject_code =:subject_code
                                AND ex.paper_no =:paper_no
                                AND ex.attendance = 1
                                AND ex.marking_centre =:marking_centre_code
                                AND ex.province = :province_code');
        $sql->execute(array(
            ':subject_code'=>$subject_code,
            ':paper_no'=>$paper_no,
            ':marking_centre_code'=>$_SESSION['marking_centre_code'],
            ':province_code'=>$_SESSION['province_code']
        ));

        $sql->bindColumn('nrc',$nrc);
        $sql->bindColumn('full_name',$full_name);
        $sql->bindColumn('subject_name',$subject_name);
        $sql->bindColumn('subject_code',$subject_code);
        $sql->bindColumn('role',$role);
        $sql->bindColumn('belt_no',$belt_no);
        $sql->bindColumn('transport',$transport);
        $sql->bindColumn('lunch',$lunch);
        $sql->fetch(PDO::FETCH_BOUND);
    }else{
        $sql = $db_9->prepare('SELECT ex.nrc AS nrc, CONCAT(ex.first_name," ",ex.last_name) AS full_name, su.subject_code AS subject_code, su.subject_name AS subject_name,p.name AS role,pa.paper_no,
                                lt.lunch AS lunch,lt.transport AS transport
                                FROM position p INNER JOIN examiner ex ON (p.id = ex.role)
                                INNER JOIN subjects su ON (ex.subject_code = su.subject_code)
                                INNER JOIN paper pa ON (su.subject_code = pa.subject_code)
                                CROSS JOIN lun_trans lt 
                                WHERE ex.paper_no = pa.paper_no
                                AND ex.subject_code =:subject_code
                                AND ex.paper_no =:paper_no
                                AND ex.belt_no =:belt_no
                                AND ex.attendance = 1
                                AND ex.marking_centre =:marking_centre_code
                                AND ex.province = :province_code');
        $sql->execute(array(
            ':subject_code'=>$subject_code,
            ':paper_no'=>$paper_no,
            ':belt_no'=>$belt_no,
            ':marking_centre_code'=>$_SESSION['marking_centre_code'],
            ':province_code'=>$_SESSION['province_code']
        ));

        $sql->bindColumn('nrc',$nrc);
        $sql->bindColumn('full_name',$full_name);
        $sql->bindColumn('subject_name',$subject_name);
        $sql->bindColumn('subject_code',$subject_code);
        $sql->bindColumn('subject_code',$subject_code);
        $sql->bindColumn('transport',$transport);
        $sql->bindColumn('lunch',$lunch);
        $sql->bindColumn('role',$role);
        $sql->fetch(PDO::FETCH_BOUND);
    }
?>

<doctype html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../../assets/css/reports.css">
        <tilte>Transport and Lunch Allowance</tilte>
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
                <p style="text-align: center;">TRANSPORT AND LUNCH ALLOWANCE REPORT</p> 
            </td>
        </tr>
    </table>

    <table class="head-data w100" style="margin-top: 5px;">
    <tr>
        <th>
            Marking Centre Code: <?php echo $_SESSION['marking_centre_code']; ?>    
        </th>
        <th>
            Belt: <?php echo $belt_no; ?>
        </th>
        <th>
            Subject Code: <?php echo $subject_code; ?>
        </th>
        <th>
            Subject Name: <?php echo $subject_name; ?>
        </th>
    </tr>
    <tr>
        
    </tr>
    <tr>
        <th>
            Marking Centre Name: <?php echo $_SESSION['marking_centre']; ?>
        </th>
        <th></th>
        <th>
            
        Paper Code: <?php echo $paper_no; ?>
        </th>
        <th>
            Attendance: Present
        </th>
        
    </tr>
    </table>

    <table class=" w100" style=" margin-top:10px;">
        <thead style="border-bottom: 1px solid black;border-top: 1px solid black;">
            <th>
                NRC
            </th>
            <th>
                FULL NAME
            </th>
            <th>
                ROLE
            </th>
           
            
            <th>
                TRANSPORT
            </th>
            <th>
                LUNCH
            </th>
        </thead>
        <tbody >
            <?php
            do{
            ?>
            <tr>
                <td><?php echo $nrc; ?></td>
                <td><?php echo $full_name; ?></td>              
                <td><?php echo $role; ?></td>
                <td><?php echo 'K'.$transport; ?></td>
                <td><?php echo 'K'.$lunch; ?></td>
                
            </tr>
            <?php
            $i++;
            } while($sql->fetch(PDO::FETCH_BOUND));
            ?>
        </tbody>
    </table>

    <div>
        <p><strong>Total Number Of Examiners: <?php if($nrc){echo $i;}else{echo '0';}; ?></strong> </p>
    </div>

    <table class="w100">
        <tbody>
            <tr>
                <th>VERIFIED BY CHIEF EXAMINER (FULLNAME):..............................</th>
                <th>SIGNATURE:............................................................</</th>
            </tr>
            <tr>
                <th>CONFIRMED BY CENTRE COORDINATOR (FULLNAME):............................................................</</th>
                <th>SIGNATURE:............................................................</</th>
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
$pdf->stream('Transport_Lunch', Array('Attachment'=>0));
}

?>