<?php
session_start();
include '../../config.php';
include '../../functions.php';
require_once '../../dompdf/autoload.inc.php';
use Dompdf\Dompdf;
use Dompdf\Options;
use Dompdf\FontMetrics;

$options = new Options();
$options->set('isPhpEnabled', true);
$options->set('isRemoteEnabled', true);
$options->setChroot(['../../assets']);
$pdf = new Dompdf($options);
    ob_start();
    if(isset($_POST['subject']) && isset($_POST['paper']) && isset($_POST['app_belt_no'])){
$subject_code = $_POST['subject'];
$paper_no = $_POST['paper'];
$belt_no = $_POST['app_belt_no'];
// $script_sum = 0;
// $i = 0;
$sql = $db_12_gce->prepare('SELECT su.subject_code AS subject_code,su.subject_name AS subject_name, a.belt_no AS belt_no, CASE WHEN a.sen = 1 THEN "YES" ELSE "NO" END AS sen,
                        pa.paper_no AS paper_no,sc.centre_code AS centre_code,sc.centre_name AS centre_name,a.script_no AS script_no,
                        ga.no_of_centres AS no_of_centres,ga.no_of_scripts AS total_no_of_scripts
                        
                        FROM  school sc INNER JOIN apportionment a ON (sc.centre_code = a.school)
                        INNER JOIN group_apportion ga ON (a.group_id = ga.id)
                        INNER JOIN subjects su ON (ga.subject = su.subject_code)
                        INNER JOIN paper pa ON (su.subject_code = pa.subject_code)
                        WHERE ga.subject = a.subject
                        AND ga.paper = a.paper
                        AND ga.belt_no = a.belt_no
                        AND ga.marking_centre = a.marking_centre
                        AND a.paper =:paper_no
                        AND a.paper = pa.paper_no
                        AND a.subject =:subject_code
                        AND a.subject = pa.subject_code
                        AND a.belt_no =:belt_no
                        AND a.marking_centre =:marking_centre_code
                        GROUP BY su.subject_code,su.subject_name,a.belt_no,a.sen,pa.paper_no,sc.centre_code,sc.centre_name,a.script_no,ga.no_of_centres,ga.no_of_scripts
                        ORDER BY sc.centre_code ASC
                        ');
$sql->execute(array(
    ':subject_code'=>$subject_code,
    ':paper_no'=>$paper_no,
    ':belt_no'=>$belt_no,
    ':marking_centre_code'=>$_SESSION['marking_centre_code']
));
$sql->bindColumn('subject_code',$subject_code);
$sql->bindColumn('subject_name',$subject_name);
$sql->bindColumn('belt_no',$belt_no);
$sql->bindColumn('sen',$sen);
$sql->bindColumn('paper_no',$paper_no);
$sql->bindColumn('no_of_centres',$no_of_centres);
$sql->bindColumn('total_no_of_scripts',$total_no_of_scripts);
$sql->bindColumn('centre_code',$centre_code);
$sql->bindColumn('centre_name',$centre_name);
$sql->bindColumn('script_no',$script_no);
$sql->fetch(PDO::FETCH_BOUND);


?>

<doctype html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../../assets/css/reports.css">
        <title>CENTERS IN BELT</title>
    </head>
    <body>
        <style>
            table.center {
    margin-left: auto; 
    margin-right: auto;
  }

table.bodered, 
table.bodered th,
table.bodered td{
    border: 1px solid black; 
    border-collapse: collapse;
}

.w80{
    width: 80%;
}

table.foot{
    bottom: 0;
}
table.data th,
table.data td{
 padding:1px 3px;
}


th {
    text-align: inherit;
}
p{
    margin: 7px;
}
        </style>
    <table class="center" style="width: 500px;">
        <tr >
            <td>
                <img src="../../assets/img/eczlogo_tr_sm.jpg">
            </td>
            <td>
               <p  style="text-align: center;">EXAMINATIONS COUNCIL OF ZAMBIA</p> 
                <p style="text-align: center;"><?php echo $_SESSION['session_name']; ?></p>
                <p style="text-align: center;">CENTERS IN BELT</p> 
            </td>
        </tr>
    </table>

    <table class="head-data w80">
        <tr>
        <th>
           Belt No.: <?php echo $belt_no; ?>
        </th>
        
       
        <th>
        Subject Code: <?php echo $subject_code; ?>
        </th>
        <th>
            Paper:  <?php echo $paper_no; ?>
        </th>
        <th>
        Marking Centre : <?php echo $_SESSION['marking_centre']; ?>
        </th>
        </tr>
        <tr>
            <th>
                Subject Name : <?php echo $subject_name; ?>
        </th>
        </tr>
    </table>

    <table class="bodered w80" style = "margin-bottom:1cm; margin-left:2cm;">
        <thead>
            <th>
            CENTRE CODE
            </th>
            <th>
                CENTRE NAME
            </th>
            <th>
               SEN
            </th>
            <th>
                NO. OF SCRIPTS
            </th>
        </thead>
       
        <tbody >
        <?php do{ ?>
            <tr>
                <td><?php echo $centre_code; ?></td>
                <td><?php echo $centre_name; ?></td>
                <td><?php echo $sen; ?></td>
                <td><?php echo $script_no; ?></td>
            </tr>
            <?php 
           
        } while($sql->fetch(PDO:: FETCH_BOUND));
            ?>
        </tbody>

    </table>


    <table style ="margin-top:0">
        <tbody>
            <th>
                <p>Total Number Of Centres in Belt: <?php echo $no_of_centres; ?></p>
                <p>Total Number Of Scripts Apportioned To Belt : <?php echo $total_no_of_scripts; ?></p>
            </th>
            <th>
            <td>GENERATED BY: <?php echo $_SESSION['username']; ?></td>
            </th>
        </tbody>
    </table>
    <table class="foot w80">
        <tbody>
            <tr>
                
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
$pdf->stream('Centers_in_belt', Array('Attachment'=>0));

}

?>