<?php
session_start();
require_once '../../dompdf/autoload.inc.php';
include '../../config.php';
include '../../functions.php';
use Dompdf\Dompdf;
use Dompdf\Options;
use Dompdf\FontMetrics;

$options = new Options();
$options->set('isPhpEnabled', true);
$options->set('isRemoteEnabled', true);
$options->setChroot(['../../assets']);  
$pdf = new Dompdf($options);
    ob_start();
    if(isset($_POST['course_group']) && isset($_POST['app_belt_no2']) && isset($_POST['marking_centre']) && isset($_POST['session'])){
        $course_group = $_POST['course_group'];
        $belt_no = $_POST['app_belt_no2'];
        $marking_centre_code = $_POST['marking_centre'];
        $session = $_POST['session'];
        $total =0;
        $grand_total = 0;
        $no_of_examiners =0;
        // $claim =0;
        // $examiners = array();
        $sql = $db_ted->prepare('SELECT marking_centre_name, nrc, tpin, full_name, position,grossed_up_rate,no_of_scripts, gross_pay, 15_wht, net_pay, account_no, bank, branch, group_code,group_name,course_code,session_name
                               FROM  examiner_claim WHERE group_code =:group_code AND belt_no =:belt_no AND marking_centre_code =:marking_centre_code AND session =:session ');
        $sql->execute(array(
            ':group_code'=>$course_group,
            ':belt_no'=>$belt_no,
            ':session'=>$session,
            ':marking_centre_code'=>$marking_centre_code
            
        ));
        // $session_name = '';
        // $marking_centre_name = '';
        // $group_code = '';
        // $group_name = '';

        // if ($row = $sql->fetch(PDO::FETCH_ASSOC)) {

        // $session_name = $row['session_name'] ?? '';
        // $marking_centre_name = $row['marking_centre_name'] ?? '';
        // $group_code = $row['group_code'] ?? '';
        // $group_name = $row['group_name'] ?? '';
        // }
      
?>

<doctype html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../../assets/css/reports.css">
        <title>CLAIM REPORT</title>
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
.w100{
    width: 100%;
}
.w25{
    width: 25%;
}
.p-5{
padding: 5px;
}
.pt-10{
    padding-top: 10px;
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
    <table class="center" style="width: 500px;margin-bottom:3px;">
        <tr >
            <td>
                <img src="../../assets/img/eczlogo_tr_sm.jpg" style="width:60%">
            </td>
            <td>
               <p  style="text-align: center;">EXAMINATIONS COUNCIL OF ZAMBIA</p> 
                <p style="text-align: center;"><?php echo $_SESSION['session_name'] ?? $session_name; ?></p>
                <p style="text-align: center;">EXAMINER'S CLAIM SCHEDULE</p> 
            </td>
        </tr>
    </table>

    <table class="head-data w80" style="margin-top: 5px;">
        <th>
            Group: <?php echo $course_group,' - ',$group_name; ?>
        </th>
        <th>
           
        </th>
        <th>
            Marking Center : <?php echo $_SESSION['marking_centre'] ?? $marking_centre_name; ?>
        </th>
        <tr>
            <th>
                
            </th>
            <th>
                Belt No.: <?php echo $belt_no; ?>
            </th>
        </tr>
    </table>

    <table class="bodered w100">
        <thead>
            <th>
                FULL NAME
            </th>
            <th>
                POSITION
            </th>
            </th>
            <th>
                COURSE / MAJOR
            </th>
            <th>
                RATE
            </th>
            <th>
                GROSS PAY (K)
            </th>
            <th>
               TAX(15%) (K)
            </th>
            <th>
               NET PAY (K)
            </th>
            <th>
                ACCOUNT NO
            </th>
            <th>
                BANK
            </th>
            <th>
                BRANCH
            </th>
            <th>
                SIGNATURE
            </th>
        </thead>
        <tbody >
            <?php
           $row = '';
         while($row = $sql->fetch(PDO::FETCH_ASSOC)){
        

        $full_name = $row['full_name'] ?? '';
        $gross_pay = $row['gross_pay'] ?? '';
        $wht = $row['15_wht'] ?? '';
        $net_pay = $row['net_pay'] ?? '';
        $account_no = $row['account_no'] ?? '';
        // $session_name = $row['session_name'] ?? '';
        $bank = $row['bank'] ?? '';
        $branch = $row['branch'] ?? '';
        $position = $row['position'] ?? '';
        // $marking_centre_name = $row['marking_centre_name'] ?? '';
        $rate = $row['grossed_up_rate'] ?? '';
        // $group_code = $row['group_code'] ?? '';
        // $group_name = $row['group_name'] ?? '';
        $course_code = $row['course_code'] ?? '';
        $no_of_scripts = $row['no_of_scripts'] ?? '';
        $session_name = $row['session_name'] ?? '';
        $marking_centre_name = $row['marking_centre_name'] ?? '';
        $group_code = $row['group_code'] ?? '';
        $group_name = $row['group_name'] ?? '';
            ?>
            <tr>
                <td><?php echo $full_name; ?></td>
                <td><?php echo $position; ?></td>
                <td><?php echo $course_code; ?></td>
                <td><?php echo $rate; ?></td>
                <td><?php echo number_format((float)$gross_pay,2,'.',''); ?></td>
                <td><?php echo number_format((float)$wht,2,'.',''); ?></td>
                <td><?php echo number_format((float)$net_pay,2,'.',''); ?></td>
                <td><?php echo $account_no; ?></td>
                <td><?php echo $bank; ?></td>
                <td><?php echo $branch; ?></td>
                <td></td>
            </tr>
            <?php
            // $total += $script_no;
            $grand_total += $net_pay;
            // $no_of_examiners = $no_of_examiners++;
            $no_of_examiners++;
            
            }
            ?>
        </tbody>

    </table >
  

    <table class="foot w80">
        <tbody>
            <tr>
                <td>DATE GANERATED: <?php echo date('d-m-Y H:m:s'); ?></td>
                <td>GENERATED BY: <?php echo $_SESSION['username'] ?? 'N/A'; ?></td>
            <tr >
            
            <th>Total Number of Scripts In Belt: <?php echo $no_of_scripts; ?></th> 
            
            </tr>
            <tr>
                <th>Total Number of Examiners : <?php echo $no_of_examiners; ?></th> 
            </tr>
            <tr>
                <th>Grand Total(net) : K<?php echo $grand_total ?></th>
            </tr>
        </tbody>
    </table>
    <table class="w100 pt-10" >
        <tbody>
        <tr >
            <th >Verified By Team Leader:...........................................................</th>
            <th>Recommended By Centre Coordinator:....................................................</th>
        </tr>
        <tr class="pt-10">
            <th >Confirmed By Chief Examiner:.............................................................</th>
            <th>Approved By Director EAD:......................................................................</th>
           
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
$pdf->stream('Centers_in_belt', Array('Attachment'=>0));

}

?>